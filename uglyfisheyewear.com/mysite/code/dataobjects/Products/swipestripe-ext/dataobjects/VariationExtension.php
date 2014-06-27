<?php
class VariationExtension extends DataExtension {
	private static $db = array(
			'LinkProductID' => 'int',
	);
	private static $has_one = array(
			'Product' => 'Product'
	);
	/**
	 * Summary fields for Attributes
	 *
	 * @var Array
	 */
	private static $summary_fields = array(
	        'LinkProductID' => 'LinkProductID',
	);
	function updateCMSFields(FieldList $fields){
		
		$fields->addFieldToTab ( 'Root.Variation', DropdownField::create ( 'LinkProductID', 'LinkProduct',$this->getProductList() ) );
				
		return $fields;
	}
	function getProductList(){
		$result = Product::get()->map('ID','Title')->toArray();
		return $result;
	}
	
	function onBeforeWrite() {
		parent::onBeforeWrite();
		$LinkProductID= Controller::curr ()->getRequest ()->postVar ('LinkProductID');
		$this->owner->LinkProductID =$LinkProductID;
	}
	
}