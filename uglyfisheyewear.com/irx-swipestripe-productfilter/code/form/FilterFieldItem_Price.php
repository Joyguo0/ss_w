<?php
class FilterFieldItem_Price extends FilterFieldItem {
	
	static $PriceColumnName = 'Price';
	
	private static $FilterTitle = 'Price';
	
	private static $http_param_name = 'price';
	
	public function updateQueryFilter(DataList $list = null){
	
	
	
		return $list;
	}
	
	
	public function updateSQLQueryForTemplate(SQLQuery $SQL_Query = null){
		
		$PriceColumnName = self::$PriceColumnName;
		
		$SQL_Query
			->selectField('"Product"."'.$PriceColumnName.'"')
			->addGroupBy('"Product"."Price"')
		;
		
		return $SQL_Query;
	}
	
	
	public function processData($recordsArray){

		if( ! empty($recordsArray)){
			
			$PriceColumnName = self::$PriceColumnName;
			
			$AllPriceArray = array();
			
			foreach ($recordsArray as $record) {
				
				$thisPrice = $record[$PriceColumnName];
				
				if( ! key_exists($thisPrice, $AllPriceArray)){
					$AllPriceArray[$thisPrice]	= 1;
				}else{
					$AllPriceArray[$thisPrice]	+= 1;
				}
				
			}
			
			$source = $this->AddPriceRangeToFilterList($AllPriceArray, $PriceColumnName);
			
//			Each Source Item should looks like			
//			
// 			  'Price' => 
// 			    array (size=3)
// 			      0 => 
// 			        array (size=4)
// 			          'OptionProductCount' => int 4
// 			          'Price' => int 1
// 			          'StartAmount' => int 0
// 			          'EndAmount' => int 100
// 			      1 => 
// 			        array (size=4)
// 			          'OptionProductCount' => int 6
// 			          'Price' => int 1
// 			          'StartAmount' => int 100
// 			          'EndAmount' => int 200
// 			      2 => 
// 			        array (size=4)
// 			          'OptionProductCount' => int 0
// 			          'Price' => int 1
// 			          'StartAmount' => int 200
// 			          'EndAmount' => int 300
			
			$this->setSource($source);
		}
	
	}
	
	
	/**
	 * check price range for current query.
	 *
	 * $AllPriceArray
	 *
	 * sample
	 * 		'120.0000' 	=> 2	//number is product count
	 *	  	'110.0000' 	=> 3
	 *	  	'10.0000' 	=> 4
	 *
	 * @param array $AllPriceArray
	 * @param string $PriceColumnName
	 * @return boolean false | Attribute OBJ
	 */
	protected function AddPriceRangeToFilterList($AllPriceArray, $PriceColumnName){
	
		$AmountBreakPoints	= array(
				100 	=> 2,
				300 	=> 3,
				600 	=> 3,
				900 	=> 3,
				1200 	=> 4,
				1600 	=> 4
		);
	
		$uniquePriceNumber = count($AllPriceArray);
	
		if( $uniquePriceNumber <= 1) return false;
	
		//sort the price array - hight -> low
		krsort($AllPriceArray);
	
		$MaxPrice = floatval(key($AllPriceArray));
	
		//calculate and define the price range groups number
		$GroupNumber 	= 2;
		$RangeMax		= -1;
		$RangeMin		= 0;
		foreach ($AmountBreakPoints as $CurrentAmount => $gaps){
			if($MaxPrice < $CurrentAmount){
				$RangeMax 		= $CurrentAmount;
				$GroupNumber 	= $gaps;
				break;
			}
		}
	
		//out of range, then set the highest amount of $AmountBreakPoints
		if($RangeMax < 0){
			$RangeMax 		= key(krsort($AllPriceArray));
			$GroupNumber	= $AmountBreakPoints[$RangeMax];
		}
	
		//create all ranges and save them into $optionsArray
		$optionsArray = array();
		//  Sample ------
		// 		$optionsArray = array(
		// 			0 => array(
		//					'OptionProductCount' 	=> 1,
		//					'Price' 				=> 1,
		//					'StartPrice' 			=> '10.0000',
		//					'EndPrice' 				=> '20.0000'
		// 				),
		// 			1 => array(
		//					'OptionProductCount' => 1
		//					'OptionProductCount' 	=> 1,
		//					'Price' 				=> 1,
		//					'StartPrice' 			=> '20.0000',
		//					'EndPrice' 				=> '30.0000'
		// 			)
		// 		);
	
		$i = 1;
		$Interval 		= ($RangeMax / $GroupNumber);
		$startAmount	= 0;
		$endAmount		= 0;
	
		while ($i <= $GroupNumber){
			$startAmount	=  $Interval * ($i - 1);
			$endAmount		=  $Interval * $i;
	
			$priceArray = array();
	
			$productCount = 0;
	
			foreach ($AllPriceArray as $amount => $pCount){
				if($startAmount <= $amount && $amount < $endAmount){
					$productCount += $pCount;
					unset($AllPriceArray[$amount]);
				}
			}
	
			$priceArray['OptionProductCount'] = $productCount;
			$priceArray['StartAmount'] 	= $startAmount;
			$priceArray['EndAmount'] 	= $endAmount;
	
			$optionsArray[] = $priceArray;
	
			$i++;
		}
		
		$title = Config::inst()->get($this->ClassName, 'FilterTitle');
		$title = $title ? $title : 'Price';
		
		return array($title => $optionsArray);
	}
	
	
	/**
	 *
	 * @param array
	 *
	 * @return ArrayList
	 */
	public function GenerateOptionsForTemplate($OptionsArray, $attributeTitle = null){
	
		$ArrayList = new ArrayList();
		
		$shopconfigDO = ShopConfig::current_shop_config();
		
		$CY	= $shopconfigDO->BaseCurrency;
		$DS = $shopconfigDO->BaseCurrencySymbol;
		$stroke = '-';
	
		if( ! empty($ArrayList)){
			foreach ($OptionsArray as $title => $properties){
				
				$startPrice = sprintf("%s %01.2f %s", $DS, $properties['StartAmount'], $CY);
				$endPrice 	= sprintf("%s %01.2f %s", $DS, $properties['EndAmount'], $CY);
				$PriceTitle = "{$startPrice} {$stroke} {$endPrice}";
				
				$PageLinks = $this->FilterLink(
					array(
						'min' => $properties['StartAmount'],
						'max' => $properties['EndAmount']	
					), 
					$attributeTitle
				);
				
				$ArrayList->push(new ArrayData(array(
					'Title' 				=> $PriceTitle,
						'Link' 				=> $PageLinks[0],
						'DeleteLink' 		=> $PageLinks[1],
					'OptionProductCount' 	=> $properties['OptionProductCount']
				)));
			}
		}
	
		return $ArrayList;
	}
	
	
	public function FilterLink($OptionsProp, $attributeTitle = null){
	
		if( ! empty($OptionsProp)){
			
			$attrParamName = Config::inst()->get('FilterFieldItem_Price', 'http_param_name');
			
			$param = $this->form->getCurrentFilterArray();
			
			$min = $OptionsProp['min'];
			$max = $OptionsProp['max'];
			
			if(isset($param[$attrParamName][$min]) && $param[$attrParamName][$min] == $max){
				//this filter item is selected. hide it in filter selection area.
				unset($param[$attrParamName][$attributeTitle][$optionTitle]);
				
				$delLink 	= $this->form->getLinkForFilterItem($param);
				
				return array(false, $delLink);	
			}else{
				$param[$attrParamName][$min] = $max;
			}
			
			$Link = $this->form->getLinkForFilterItem($param);
			
			return array($Link, false);
		}
		
		return array(false, false);
	}
	
}