<?php

class ConferenceListingPage extends Page {
	
	public static $icon = 'mysite/images/icons/conferencepage';

// 	private static $allowed_children = array('ConferenceListPage');
	
	private static $db = array(
	);

	private static $has_one = array(
   		
   	);
	
	private static $has_many = array(
	);

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		$fields->removeByName("Resources");
		$fields->removeByName("Slideshow");
		$fields->removeByName("SideBar");
		return $fields;
	}
}

class ConferenceListingPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(

	);
	
// 	function ConferenceMultiForm() {
		
// 		Session::set('ConferencePageID', $this->ID);
		
// 		return new ConferenceMultiForm($this, 'ConferenceMultiForm');
// 	}
	
// 	function Form() {
// 		return new ConferenceMultiForm($this, 'Form');
// 	}
	
	public function init() {
		parent::init();
	
	}
	

}