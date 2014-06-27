<?php
/**
 *
 */
class AddressablePage extends Page {
	
	private static $db = array(
	);
	
	private static $defaults = array(
	);
	
	private static $many_many = array(
	);
	
	private static $many_many_extraFields = array(
		
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
	
}

class AddressablePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
}
