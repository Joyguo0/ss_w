<?php
class ProductFilterForm extends Form {
	
	private static $ExcludeFilterItem = array();
	
	protected $dataQuery;
	
	/**
	 * The original DataList query
	 * 
	 * @var DataList
	 */
	protected $DataList;
	
	/**
	 * This DataList will be return to original query.
	 * 
	 * where condiction and join statements will be applied to it.
	 * 
	 * won't change the GroupBy data.
	 * 
	 * @var DataList
	 */
	protected $DataList_Filtered;	
	
	/**
	 * For generating filter fields HTML template
	 * 
	 * Ideally, we can use one single query to get all data and process them for template.
	 *
	 * @var SQLQuery
	 */
	protected $SQLQuery_FilterItems;
	
	/**
	 * The original PaginatedList if it's passed to here
	 * 
	 * @var PaginatedList
	 */
	protected $PaginatedList;
	
	/**
	 * @var int
	 */
	protected $PaginatedList_Start;
	
	/**
	 * @var int
	 */
	protected $PaginatedList_Length;
	
	/**
	 * @var SS_HTTPRequest
	 */
	protected $request;
	
	protected $http_param_name = 'pfv';
	
	protected $http_data;
	
	protected $not_filtered = false;
	
	public function __construct($controller, $name, $list) {

		$this->setupFormErrors();
		$this->addExtraClass('pf-form');
		$this->setTemplate('ProductFilterForm');
		
		//setup the objests
		$this->request	= $controller->request;
		
		//setup DataList or PaginatedList
		if($list instanceof PaginatedList){
			
			$this->PaginatedList = $list;
			
			$this->PaginatedList_Start	= $this->PaginatedList->getPageStart();
			
			$this->PaginatedList_Length	= $this->PaginatedList->getPageLength();
			
			$this->DataList = $this->PaginatedList->getList();
			
		}elseif($list instanceof DataList){
			
			$this->DataList = $DataList;
		
		}
		
		//check passed filter params from GET or POST
		$this->http_data 	= $this->request->getVar($this->http_param_name);
		$this->not_filtered = (empty($this->http_data)) ? true : false;

		//create filter fields
		$fieldsList = $this->CreateFilterItemFields();
		
		parent::__construct($controller, $name, $fieldsList, FieldList::create(), null);
		
	}
	
	
	public function getCurrentFilterArray(){
		$array = $this->http_data;
	
		if( ! $array){
			$array = array(
				$this->http_param_name => array()
			);
		}
	
		return $array;
	}
	
	
	public function getLinkForFilterItem($filter_param = null){
		
		if($filter_param === null){
			$filter_param = $this->http_data;
		}
		
		$PageDO = $this->controller;
		
		$link = $PageDO->Link();
		
		if( ! empty($filter_param)){
			
			$link = $link . '?' . http_build_query(array(
				$this->http_param_name => $filter_param
			));
			
		}
		
		return $link;
	}
	
	
	public function getRemoveLinkForFilterItem($filter_param = null){
	
		if($filter_param === null){
			$filter_param = $this->http_data;
		}
	
		$PageDO = $this->controller;
	
		$link = $PageDO->Link();
	
		if( ! empty($filter_param)){
				
			$link = $link . '?' . http_build_query(array(
					$this->http_param_name => $filter_param
			));
				
		}
	
		return $link;
	}
	
	
	public function CreateFilterItemFields(){
		
		$fields = new FieldList();
		
		$excludedClassName = Config::inst()->get('ProductFilterForm', 'ExcludeFilterItem');
		
		$FilterFieldItemClasses = ClassInfo::subclassesFor('FilterFieldItem');

		foreach ($FilterFieldItemClasses as $className){
			if( ! in_array($className, $excludedClassName)){
				
				$fields->push(
					$className::create($className)
						->setList($this->DataList)
						->setFilterParams($this->http_data)
				);	
				
			}	
		}
		
		return $fields;
	}	
	
	
	/**
	 * @return FieldList
	 */
	public function Fields() {
		
		//get filtered datalist query
		$this->UpdateAndGetFilteredDataList();
		
		//generate SQLQuery according to filtered DataList. FilterFieldItem->() may adjust it if necessary
		$this->updateSQLQueryForFilterFieldTemplate();
		
		//execute 
		$this->processDataForTemplate();
		
		return $this->fields;
		
	}
	
	
	/**
	 * add default filters and joins. also will apply the http filter setting.
	 * 
	 * @return ProductFilterForm
	 */
	public function UpdateAndGetFilteredDataList(){
	
		$this->DataList_Filtered = clone $this->DataList;
	
		if($this->fields && $this->fields->count()){
			$fields = $this->fields->dataFields();
	
			foreach ($fields as $field){
				$this->DataList_Filtered = $field->updateQueryFilter($this->DataList_Filtered);
			}
		}

		return $this->DataList_Filtered;
	
	}
	
	
	
	/**
	 * get condition, joins info from DataList. Then apply them to a new SQLQuery object.
	 *
	 * @return SQLQuery
	 */
	protected function set_DataList_2_SQLQuery(DataList $list){
		
		$SQLQuery_Array = $list->dataQuery()->query();

		$where 		= $SQLQuery_Array->getWhere();
		$from		= $SQLQuery_Array->getFrom();
		
		$new_SQL_Query = new SQLQuery('111');	//adding '111' for removing '*'. we don't need all info.
		
		//add 'where'
		if( ! empty($where)){
			$new_SQL_Query->setWhere($where);
		}
		
		//add 'joins'
		if( ! empty($from)){
			$new_SQL_Query->setFrom($from);
		}else{
			$new_SQL_Query->setFrom('"SiteTree"');
		}
		
		$this->SQLQuery_FilterItems = $new_SQL_Query;
		
		return $this->SQLQuery_FilterItems;
	}
	
	
	/**
	 * this is for getting filter field template
	 * 
	 * @return ProductFilterForm
	 */
	public function updateSQLQueryForFilterFieldTemplate(){
	
		//clone oringinal DataList for processing the filter options template.
		$this->SQLQuery_FilterItems = clone $this->DataList;
		
		$this->SQLQuery_FilterItems = $this->set_DataList_2_SQLQuery($this->SQLQuery_FilterItems);
		
		if($this->fields && $this->fields->count()){
			$fields = $this->fields->dataFields();
		
			foreach ($fields as $field){
				$this->SQLQuery_FilterItems = $field->updateSQLQueryForTemplate($this->SQLQuery_FilterItems);
			}
		}
		
		return $this->SQLQuery_FilterItems;
		
	}
	
	
	/**
	 * @return DataList
	 */
	public function processDataForTemplate(){
		
		$data 	= array();
		
		$filteredProductIDs = '0';
		
		if( ! $this->not_filtered){
			$list = clone $this->DataList_Filtered;
			
			$filteredProductIDsArray = $list->map('ID', 'ID')->toArray();

			if( ! empty($filteredProductIDsArray)){
				$filteredProductIDs = implode(',', $filteredProductIDsArray);
				
				$this->SQLQuery_FilterItems = $this->SQLQuery_FilterItems->addWhere("\"Product\".\"ID\" IN ($filteredProductIDs)");
			}
		}

		$query 	= $this->SQLQuery_FilterItems->execute();
		
		if($query->numRecords()){
			//process the returned records
			foreach ($query as $record){
				$data[] = $record;
			}

			$fields = $this->fields->dataFields();
				
			foreach ($fields as $field){
				$field->processData($data);
			}
			
		}
		
		return false;		
	}
	
	
	/**
	 * @return PaginatedList | DataList
	 */
	public function getFilteredList(){
		
		$List = $this->UpdateAndGetFilteredDataList();
		
		if($this->PaginatedList){
			//return PaginatedList object if it passed
			$List = PaginatedList::create($List)
						->setPageLength($this->PaginatedList_Length)
						->setPageStart($this->PaginatedList_Start)
			;
		}
		
		return $List;
		
	}
	
}