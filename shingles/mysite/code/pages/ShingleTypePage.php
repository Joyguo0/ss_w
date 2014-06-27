<?php
/**
 *
 */
class ShingleTypePage extends Page {
	
	private static $icon = 'mysite/images/icons/supplierpage';
	
	private static $db = array(
	);
	
	private static $has_one = array(
		'Photo' => 'Image'
	);
	
	private static $has_many = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		$fields->addFieldToTab("Root.Images", new UploadField('Photo'));

		return $fields;
	}
}

class ShingleTypePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
