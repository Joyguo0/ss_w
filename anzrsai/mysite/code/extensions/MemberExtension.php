<?php

class MemberExtension extends DataExtension {

	private static $db = array(
		'MemberTitle' 		=> "enum('Mr., Ms., Mrs., Miss, Dr., Sir., Prof.')",
		'AddressLine1' 		=>	'Varchar(50)',
		'AddressLine2' 		=>	'Varchar(50)',
		'State' 	 		=>	'Varchar(50)',
		'Postcode' 			=>	'Varchar(30)',
		'Phone' 			=>	'Varchar(50)',
		'Fax' 				=>	'Varchar(50)',
		'Organisation'		=>	'Varchar(50)', 
		'MobilePhone'		=>	'Varchar(50)',
		'HomePhone'			=>	'Varchar(50)',
		'Position'			=>	'Varchar(50)',
			
		'LegacyID'			=> 'Int'	
    );
    
	private static $has_one = array(
		'Order' 	=> 'Order'
	);
	
	private static $has_many = array(
		'Memberships' 		=> 'Membership',
		'TicketSubmissions' => 'TicketSubmission'
	);
	
	
	public function hasValidMembership(){
		$LatestMemberShip = $this->owner->GetLatestMembership();
		
		return ($LatestMemberShip && $LatestMemberShip->isValid());
	}
	
	
	public function GetLatestMembership(){
		return $this->owner->Memberships()->sort('"ExpiryDate" DESC')->first();
	}
	
	
	public function CountryName(){
		$countryCode = $this->owner->Country;
		
		$countryField = CountryDropdownField::create('Country', 'Country');
		$countrySourceArray = $countryField->getSource();
			
		if(isset($countrySourceArray[$countryCode]) && $countrySourceArray[$countryCode]){
			return $countrySourceArray[$countryCode];
		}
		
		return '';
	}
	
	
	
	
}
