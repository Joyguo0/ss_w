<?php
/**
 *
 */
class NewslettersListingPage extends Page {
	
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Newsletters' => 'NewsletterFile'	
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Resources');
		$fields->removeByName('Slideshow');
		
		$GFConfig = GridFieldConfig_RecordEditor::create();
		$GFConfig->addComponent(new GridFieldSortableRows('Sort'));
		$GF = new GridField('Newsletters', 'Newsletters', $this->Newsletters(), $GFConfig);
		$fields->addFieldToTab("Root.Newsletters", $GF);
		
		return $fields;
	}
	
}

class NewslettersListingPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
