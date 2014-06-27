<?php
/**
 *
 */
class ProductPage extends Page {
	
	
	private static $db = array(
		'Sort' => 'Int',
		'Price' => 'Decimal(19, 2)',
	);
	
	private static $has_one = array(
		'Logo' => 'Image'
	);
	
	private static $has_many = array(
		'ProductTabs' => 'ProductTab'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		//$fields->removeByName('SideBar');
		$fields->removeByName('Slideshow');
		
		$fields->addFieldToTab("Root.Logo", new UploadField('Logo','Logo'));
		$fields->addFieldToTab("Root", new TextField('Price','Price'),'Introductory');
		//$fields->addFieldToTab("Root.TAB", new TextField('Title','Title'));
		//$fields->addFieldToTab("Root.TAB", new TextField('Content','Content'));
		
		$TABConfig = GridFieldConfig_RecordEditor::create();
		$TABConfig->addComponent(new GridFieldSortableRows('Sort'));
		$TABField = new GridField('ProductTabs', 'ProductTabs', $this->ProductTabs()->sort('"Sort" ASC'), $TABConfig);
		$fields->addFieldToTab("Root.ProductTabs", $TABField);
		
		return $fields;
	}
}

class  ProductPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
