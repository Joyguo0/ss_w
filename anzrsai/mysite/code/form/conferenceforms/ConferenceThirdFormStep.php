<?php

class ConferenceThirdFormStep extends MultiFormStep {

	public static $next_steps = 'ConferenceFouthFormStep';

	public function getValidator() {
		return new RequiredFields('MemberTitle', 'FirstName', 'Surname', 'Organisation', 'MobilePhone', 'AddressLine1', 'City', 'State', 'Postcode', 'Country');
	}
	
   	public function getFields() {
   		
   		$CurrentData = $this->loadData();
   		
   		$fields = new FieldList();
   		
   		$fields->push(HeaderField::create('Details')->addExtraClass('event-form-heads'));
   		
   		//left column
   		$fields->push(LiteralField::create('table1', '<div class="large-6 columns">'));
   		$fields->push($Title = new TextField('MemberTitle', 'Title'));
   		$fields->push($FirstName = new TextField('FirstName', 'First Name'));
   		$fields->push($LastName = new TextField('Surname', 'Surname'));
   		$fields->push($Organisation = new TextField('Organisation', 'Organisation'));
   		$fields->push($Position = new TextField('Position', 'Position'));
   		$fields->push($MobilePhone = new TextField('MobilePhone', 'Mobile Phone'));
   		$fields->push($HomePhone = new TextField('HomePhone', 'Home Phone'));
   		$fields->push(LiteralField::create('table1', '</div>'));
   		
   		//right column
   		$fields->push(LiteralField::create('table1', '<div class="large-6 columns">'));
   		$fields->push($AddressLine2 = new EmailField('Email', 'Email'));
   		$fields->push($AddressLine1 = new TextField('AddressLine1', 'Address Line 1'));
   		$fields->push($AddressLine2 = new TextField('AddressLine2', 'Address Line 2'));
   		$fields->push($City = new TextField('City', 'City'));
   		$fields->push($State = new TextField('State', 'State'));
   		$fields->push($Postcode = new TextField('Postcode', 'Postcode'));
   		$fields->push(CountryDropdownField::create('Country', 'Country', null, 'AU'));
   		$fields->push(LiteralField::create('table1', '</div>'));

   		return $fields;
   }
   
   

}