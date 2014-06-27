<?php
class TicketSubmission extends DataObject {
	
	private static $db = array(
		'Title' 		=> 'Text',
	);
	
	private static $has_one = array(
		'Page' 			=> 'Page',
		'Member' 		=> 'Member',
		'Order' 		=> 'TicketOrder',
		'VPCPayment' 	=> 'VPCPayment'
	);
	
	private static $summary_fields = array(
		'Order.IsFullConf'	=> 'FullConference',
		'Order.FirstName'	=> 'FirstName',
		'Order.Surname'		=> 'Surname',
		'Order.Email'		=> 'Email',
		'Order.TotalPrice'	=> 'TotalAmount',
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
		
		$OrderDO 	= $this->Order();
		$PaymentDO 	= $this->VPCPayment();
		
		$fields->addFieldsToTab('Root.Main', TextField::create('Title'));
		$fields->addFieldsToTab('Root.Main', ReadonlyField::create('EventName', 'Event', $this->Page()->Title));
		
		$DataList 		= $OrderDO->LoadEventTicketDetailsHTML(true);
		$HTMLresults = Object::create('ViewableData')->renderWith(
			'CMSOrderInfo',
			array(
				'Tickets' 		=> $DataList
		));
		
		$fields->addFieldsToTab('Root.Main', LiteralField::create('orderinfo', $HTMLresults));
		

		$memberDO 		= $this->Member();
		$memberArray 	= false;
		if($memberDO && $memberDO->ID){
			$memberArray = $memberDO->toMap();
		}else{
			//get record from multi step form
			$SessionDO 		= $this->Order()->MultiFormSession();
			$step3Do		= ConferenceThirdFormStep::get()->filter(array('SessionID' => $SessionDO->ID))->first();
			$memberArray 	= $step3Do->loadData();
		}
			
		$memberDataArray = array('MemberTitle', 'FirstName', 'Surname', 'Email', 'Organisation', 'MobilePhone', 'HomePhone', 'Position', 'AddressLine1', 'AddressLine2', 'City', 'State', 'Postcode', 'Country');
		foreach ($memberDataArray as $key){
			$value = isset($memberArray[$key]) ? $memberArray[$key] : null;
			
			$fields->addFieldsToTab(
					'Root.MemberDetails', 
					ReadonlyField::create($key)
						->setValue($value)
			);
		}
		
		
		$fields->addFieldsToTab('Root.MemberDetails',array(
				ReadonlyField::create('MerchTxnRef', 'Merchant Transaction Reference', $PaymentDO->MerchTxnRef),
				ReadonlyField::create('TransactionNo', 'Transaction No.', $PaymentDO->TransactionNo),
				ReadonlyField::create('ReceiptNo', 'Receipt No.', $PaymentDO->ReceiptNo),
			)
		);
		
				
		
		
		return $fields;
	}
	
}