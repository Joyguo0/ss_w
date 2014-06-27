<?php
/**
 *
 */
class AbstractUploadPage extends UserDefinedForm {
	
	public static $icon = 'mysite/images/icons/articleholder';
	
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

class AbstractUploadPage_Controller extends UserDefinedForm_Controller {
	
	public function init() {
		parent::init();

	}
	
	
	
}
