<?php
/**
 *
 */
class FormTypePage extends UserDefinedForm {
	
	private static $db = array(
		//"Address" => 'Text'
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		//$fields->addFieldToTab('Root.Main', TextField::create('Address'), 'Content');
		return $fields;
	}
}

class FormTypePage_Controller extends UserDefinedForm_Controller {
	
	private static $allowed_actions = array('Form','finished');
	public function init() {
		parent::init();
		
	}

	
	public function Form() {
		$form = parent::Form();
 		if(!empty($form)){
 			$form->addExtraClass('contact');
			
 		}
			
		
		return  $form;
	}
	
	
// 	public function  LoadAddress(){
// 		return urlencode($this->Address);
// 	}

}
