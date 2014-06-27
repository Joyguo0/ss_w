<?php
/**
 *
 */
class CasePage extends Page {
	
	
	private static $db = array(
		'Featured' => 'int'
	);
	
	private static $has_one = array(
		'Photo' => 'Image'
	);
	
	private static $has_many = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		$fields->addFieldToTab("Root.Main", new UploadField('Photo'), 'Content');
		
		$fields->removeByName('Featured');
				
		return $fields;
	}
	
	
	
	//->sort('"Featured" ASC, "ID" DESC')
	
	
}

class CasePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
