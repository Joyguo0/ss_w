<?php
/**
 *
 */
class FormTypePage extends UserDefinedForm {
	
	private static $icon = 'mysite/images/icons/contactpage';
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	public function getCoordinateLat() {
		if($this->Lat){
			return $this->Lat;
		}
		
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($this->Address);
		return $Coordinate['lat'];
	}
	
	public function getCoordinateLng() {
		if($this->Lng){
			return $this->Lng;
		}
		
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($this->Address);
		return $Coordinate['lng'];
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
