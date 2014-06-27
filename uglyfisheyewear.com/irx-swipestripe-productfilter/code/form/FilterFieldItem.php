<?php
class FilterFieldItem extends DropdownField {
	
	private static $FilterTitle = '';
	
	private static $http_param_name = 'attr';
	
	
	/**
	 * @var DataList
	 */
	protected $DataList;
	
	/**
	 * @var array
	 */
	protected $OptionArray;
	
	/**
	 * @var array
	 */
	protected $http_filter_data_all;
	
	/**
	 * @var array
	 */
	protected $http_filter_data_this;
	
	
	public function __construct($name = null, $title = null) {
		
		$name = $name ? $name : $this->ClassName;
		
		$title = $title ? $title : Config::inst()->get($this->ClassName, 'FilterTitle');
		
		parent::__construct($name, $title = null);
		
		$this->setTemplate('FilterFieldItem');
		
	}
	
	
	public function setList($list){
		$this->DataList = $list;
		
		return $this;
	}
	
	
	public function getList(){
		return $this->DataList;
	}
	
	/**
	 * @param array $Data
	 * 
	 * @return FilterFieldItem
	 */
	public function setFilterParams($Data){
		
		$this->http_filter_data_all = $Data;
		
		$param_name = Config::inst()->get('FilterFieldItem', 'http_param_name');
	
		if(isset($Data[$param_name]) && ! empty($Data[$param_name])){
			
			$this->http_filter_data_this = $Data[$param_name];
			
		}
		
		return $this;
	}
	
	
	/**
	 * @param array $Data
	 *
	 * @return FilterFieldItem
	 */
	public function getFilterParamName(){
		return Config::inst()->get($this->ClassName, 'http_param_name');
	}
	
	
	
	
	public function updateQueryFilter(DataList $list = null){
		
		$whereString = $this->Generate_Where_From_HTTP_Filter_Data();
			
		if($whereString !== false){
			$list = $list->leftJoin("Attribute", '"Attribute"."ProductID" = "Product"."ID"')
						 ->leftJoin("Option", '"Option"."AttributeID" = "Attribute"."ID"')
						 ->where($whereString);
		}
		
		return $list;
	}
	
	
	public function Generate_Where_From_HTTP_Filter_Data(){
		
		if( ! empty($this->http_filter_data_this)){
			
			$whereArray = array();
			
			$attributeCond 	= array();
			$optionCond 	= array();
			
			foreach ($this->http_filter_data_this as $attrTitle => $optionArray){
				
				$attributeCond[] = "'".Convert::raw2sql($attrTitle)."'";
				
				foreach ($optionArray as $optionTitle => $value){
					$optionCond[] = "'".Convert::raw2sql($optionTitle)."'";
				}
			}
			
			$attributeCond 	= implode(',', $attributeCond);
			$optionCond 	= implode(',', $optionCond);
			
			$whereArray[] = "((\"Attribute\".\"Title\" IN ($attributeCond)) AND (\"Option\".\"Title\" IN ($optionCond)))";

			$where = ( ! empty($whereArray)) ? implode(' AND ', $whereArray) : '1';
					
			return $where;
		}
		
		return false;
	}
	
	
	
	public function updateSQLQueryForTemplate(SQLQuery $SQL_Query = null){
		
		$SQL_Query
			->selectField('"Attribute"."Title"', 'AttributeTitle')
			->selectField('"Option"."Title"', 'OptionTitle')
			->selectField('COUNT( Distinct "Attribute"."ProductID")', 'OptionProductCount')
			->addLeftJoin("Attribute", '"Attribute"."ProductID" = "Product"."ID"')
			->addLeftJoin("Option", '"Option"."AttributeID" = "Attribute"."ID"')
			->addWhere('"Attribute"."ClassName" = \'Attribute\'')
			->addWhere('"Product"."ID" IS NOT NULL')
			->addGroupBy('"Option"."Title"')
		;
		
		return $SQL_Query;
	}
	
	
	public function processData($recordsArray){
		if( ! empty($recordsArray)){
			
			$source = $this->AttributeOptionsNestedArray($recordsArray, 'AttributeTitle', 'OptionTitle');
			
//			Each Source Item should looks like			
//			
// 			'FRAME COLOUR' => 
// 			    array (size=2)
// 			      'Gun Metal' => 
// 			        array (size=1)
// 			          'OptionProductCount' => string '2' (length=1)
// 			      'Pink' => 
// 			        array (size=1)
// 			          'OptionProductCount' => string '4' (length=1)
			
			$this->setSource($source);
		}
	}
	
	
	/**
	 * return sorted nested (attribute title => it's option title array)
	 *
	 * @param array $sourceArray
	 * @param string $column
	 * @param string $child_column
	 * @return array
	 */
	protected function AttributeOptionsNestedArray($sourceArray, $column, $child_column){
	
		$AttrArray	= array();
	
		foreach ($sourceArray as $record) {
	
			$attrTitleKey 	= $record[$column];
			$optionTitle 	= $record[$child_column];
	
			if( ! isset($AttrArray[$attrTitleKey])){
				$AttrArray[$attrTitleKey] = array();
			}
	
			$optionArray = &$AttrArray[$attrTitleKey];
	
			//if option hasnt assign to this attribute, then add it.
			if( ! key_exists($optionTitle, $optionArray)){
				
				$optionArray[$optionTitle] = array(
						'Title' 			 => $optionTitle,
						'OptionProductCount' => $record['OptionProductCount']
				);
			}
		}
	
		//sort value and then key
		//ASC by default.
		if(count($AttrArray)){
			//sort option title first
			foreach ($AttrArray as $AttrTitl => &$OptionTitlesArray){
				ksort($OptionTitlesArray);
			}
	
			//then sort attribute title - key
			ksort($AttrArray);
		}
	
		return $AttrArray;
	}
	
	
	public function Items(){
		$processSource = $this->getSource();
		
		$ArrayList = new ArrayList();

		if( ! empty($processSource)){
			foreach ($processSource as $title => $OptionsArray){
				$data = array();
				
				$data['Title'] 		= $title;
				$data['Options'] 	= $this->GenerateOptionsForTemplate($OptionsArray, $title);
				
				$ArrayList->push(new ArrayData($data));
			}
		}
		
		return $ArrayList;
	}
	
	
	/**
	 * 
	 * @param array
	 * 
	 * @return ArrayList
	 */
	public function GenerateOptionsForTemplate($OptionsArray, $attributeTitle = null){
		
		$ArrayList = new ArrayList();
		
		if( ! empty($ArrayList)){
			foreach ($OptionsArray as $title => $properties){
				
				$PageLinks = $this->FilterLink($properties, $attributeTitle);
				
				$properties = array_merge(array(
						'Link' 			=> $PageLinks[0],
						'DeleteLink' 	=> $PageLinks[1],
					), 
					$properties
				);
				
				$ArrayList->push(new ArrayData($properties));
			}
		}
		
		return $ArrayList;
	}
	
	
	
	public function FilterLink($OptionsProp, $attributeTitle = null){
		
		if( ! empty($OptionsProp) && $attributeTitle){
			
			$attrParamName = Config::inst()->get('FilterFieldItem', 'http_param_name');
			
			$param = $this->form->getCurrentFilterArray();
			
			$optionTitle = $OptionsProp['Title'];
		
			if(isset($param[$attrParamName][$attributeTitle][$optionTitle])){
				//this filter item is selected. hide it in filter selection area.
				unset($param[$attrParamName][$attributeTitle][$optionTitle]);
				
				$delLink 	= $this->form->getLinkForFilterItem($param);
				
				return array(false, $delLink);	
			}else{
				$param[$attrParamName][$attributeTitle][$optionTitle] = true;
			}
			
			$Link 		= $this->form->getLinkForFilterItem($param);
			
			return array($Link, false);
		}
		
		return array(false, false);
	}
	
	

	
}