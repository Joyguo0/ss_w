<?php

class SocialEventTicket extends DataObject {
	
	private static $db = array(
		'Name'				=> 'Varchar(255)',
		'Description'		=> 'Varchar(255)',
		"MemberPrice" 		=> "Decimal(19, 2)",
		"NonMemberPrice" 	=> "Decimal(19, 2)",	//not using it 
		"Quantity" 			=> "Int",
		//'EventPackage'	=> 'Enum("FullConference", "IndividualDays")',
		'SortID' 			=> 'Int'
	);

	private static $has_one = array(
		'EventPackage' => 'EventPackage',
		'ConferencePage' => 'ConferencePage'
	);
	private static $has_many = array(
		
	);
	
	private static $belongs_many_many = array(
	);

	private static $summary_fields = array(
		'Name'				=> 'Name',
		'Description'		=> 'Description',
		"Price" 			=> "Price",
		"Quantity" 			=> "Quantity"
	);

	public function getCMSFields(){
	
		$fields = parent::getCMSFields();
		
		
		$fields->removeByName("Quantity");
		$fields->removeByName("SortID");
		$fields->removeByName("EventPackageID");
		$fields->removeByName("ConferencePageID");
		$fields->removeByName("NonMemberPrice");
		
		return $fields;
	}
}