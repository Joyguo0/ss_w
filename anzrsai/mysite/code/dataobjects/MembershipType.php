<?php

class MembershipType extends DataObject {
	
	private static $db = array(
		'Title'	=> 'Varchar(255)',
		'Desc'	=> 'Text',
		"Price"	=> "Decimal(19, 2)",
		'SortID'=> 'Int'
	);

	private static $has_one = array(
		'MemberRegistrationFormPage' => 'MemberRegistrationFormPage'
	);
	private static $has_many = array(
		
	);
	
	private static $belongs_many_many = array(
	);

	private static $summary_fields = array(
		'Title'		=> 'Title',
		'Price'		=> 'Price'
	);
	
	public function canDelete($member = null){
		if(in_array($this->ID, array(1,2,3))){
			return false;
		}
	}

	public function getCMSFields(){
	
		$fields = parent::getCMSFields();

		$fields->removeByName("SortID");
		$fields->removeByName("MemberRegistrationFormPageID");
		
		return $fields;
	}
}