<?php
/**
 *
 */
class ServicePage extends Page {
	
	
	private static $db = array(
		'Sort' => 'Int'
	);
	
	private static $has_one = array(
		'Logo' => 'Image'
	);
	
	private static $has_many = array(
		'ServiceTabs' => 'ServiceTab'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		//$fields->removeByName('SideBar');
		$fields->removeByName('Slideshow');
		
		$fields->addFieldToTab("Root.Logo", new UploadField('Logo','Logo'));
		//$fields->addFieldToTab("Root", new TextField('Price','Price'),'Introductory');
		
		$TABConfig = GridFieldConfig_RecordEditor::create();
		$TABConfig->addComponent(new GridFieldSortableRows('Sort'));
		$TABField = new GridField('ServiceTabs', 'ServiceTabs', $this->ServiceTabs()->sort('"Sort" ASC'), $TABConfig);
		$fields->addFieldToTab("Root.ServiceTabs", $TABField);
		
		return $fields;
	}
}

class  ServicePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
