<?php

class EventTicket extends DataObject {
	
	private static $db = array(
		'Name'				=> 'Varchar(255)',
		'Description'		=> 'Varchar(255)',
		"MemberPrice" 		=> "Decimal(19, 2)",
		"NonMemberPrice" 	=> "Decimal(19, 2)",	//not using it 
		"Quantity" 			=> "Int",
// 		'EventPackage'	=> 'Enum("FullConference", "IndividualDays")',
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
		
// 		$value = SiteConfig::get_by_id("SiteConfig", 1);		
// 		$package1 = $value->EventPackage1;
// 		$package2 = $value->EventPackage2;
// 		$fields = parent::getCMSFields();
// 		$fields->addFieldToTab("Root.Main", new DropdownField('EventPackage','Event Package', array(
// 				$package1 => $package1,
// 				$package2 => $package2
// 		)
// 		));

		$fields->addFieldToTab('Root.Main', TextField::create('MemberPrice', 'Price ( Full Conference )'));
// 		$fields->addFieldToTab('Root.Main', TextField::create('NonMemberPrice', 'Non-member Price ( Full Conference )'));
		$fields->removeByName("NonMemberPrice");
		
		$fields->removeByName("Quantity");
		$fields->removeByName("EventPackageID");
		$fields->removeByName("SortID");
		$fields->removeByName("ConferencePageID");
		return $fields;
	}
}