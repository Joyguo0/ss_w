<?php
class Order extends DataObject {
	
	private static $db = array(
		'Title' 		=> 'Varchar(16)', 
		'FirstName' 	=> 'Varchar(64)', 
		'LastName' 		=> 'Varchar(64)', 
		'Email' 		=> 'Varchar(32)', 
		'Phone' 		=> 'Varchar(32)', 
		'Street' 		=> 'Varchar(64)', 
		'City' 			=> 'Varchar(32)', 
		'State' 		=> 'Varchar(16)', 
		'PostalCode' 	=> 'Varchar(10)',
		'AdditionalInfo'=> 'Text',

		'Option' 		=> 'Varchar(16)',	
			
		'Status' 		=> 'Varchar(16)',
		'ProductAmount' => 'Int',
			
		'AccessCode' 	=> 'Text',
			
		'SummaryHTML' 	=> 'Text',
			
		'EmailSent' 	=> 'Boolean'
	);
	
	private static $has_one = array(
		'RapidPayment' 		=> 'eWayRapidPayment',
		'MultiFormSession' 	=> 'MultiFormSession'	
	);
	
	static $summary_fields = array(
		'FirstName'		=> 'FirstName',
		'Email'			=> 'Email',
		'Phone'			=> 'Phone',
		'Option' 		=> 'PickupOrDelivery',
		'Status'		=> 'Status'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('FirstName'),
				TextField::create('LastName')
					
					
					
		));
		
		return $fields;		
	}
	
	
	public function getProductPrice(){
		$paymentPageDO = DataObject::get_one('PaymentPage');
		
		if($paymentPageDO && $paymentPageDO->BackpackPrice){
			return $paymentPageDO->BackpackPrice;
		}
		
		return null;
	}
	
	
	public function getTotalPrice(){
		$price = $this->getProductPrice();
		
		return $this->ProductAmount * $price;
	}
	
	
}