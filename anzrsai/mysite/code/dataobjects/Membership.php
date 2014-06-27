<?php

class Membership extends DataObject {
	
	private static $db = array(
		'ExpiryDate'   	=> 'Date',
		"Price"			=> "Decimal(19, 2)",
		'Type' 			=> 'Varchar(255)',
	);
	 
	private static $has_one = array(
		'MembershipType'	=> 'MembershipType',	
	  	'Member'  			=> 'Member',
		'VPCPayment'		=> 'VPCPayment'	
	);
	
	private static $has_many = array(
	);
	
	private static $belongs_many_many = array(
	);

	private static $summary_fields = array(
		'ExpiryDate',
		'Price',
		'Type'
	);

	public function getCMSFields(){
		
		$fields = parent::getCMSFields();		
		
		$fields->removeByName('MembershipTypeID');
		$fields->removeByName('MemberID');
		$fields->removeByName('VPCPaymentID');
		
		$fields->addFieldToTab('Root.Main', DateField::create('ExpiryDate')
												->setConfig('showcalendar', true)
												->setConfig('dateformat', 'dd/MM/YYYY')
		);
		
		return $fields;
	}
	
	
	public function isExpired(){
		$CurrentDate 	= strtotime(date('Y-m-d'));
		$ExpiryDate 	= strtotime($this->ExpiryDate);
			
		return $ExpiryDate < $CurrentDate;
	}
	
	
	public function isValid(){
		return ! $this->isExpired();
	}
	
	
	public function CreateNewMembershipFromNow($memberDO = null, $price = null, $type = null){
		if(!$this->ID){
			if($memberDO === null){
				$memberDO = Member::currentUser();
			}
			
			$this->MemberID		= $memberDO->ID;
			$this->ExpiryDate 	= date("Y-m-d", strtotime("+1 year", time()));
			$this->Price		= $price;
			$this->Type			= $type;
			
			$this->write();
			
			return $this;
		}
		
		return false;
	}
	
	
	
}