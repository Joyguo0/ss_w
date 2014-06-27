<?php

/**
 *
 */
class BuildingListPage extends Page {
	
	public static $icon = 'mysite/images/icons/buildingspage';
	
	private static $db = array(
		'BuildingSource' => 'enum("current,upcoming","current")'
	);
	
	private static $has_one = array(
		'Image' => 'Image'
	);
	
	public function Buildings() {
		return BuildingPage::get ()->filter ( 'DateState', $this->BuildingSource );
	}
	
	public function getCMSFields (){
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main',
				OptionsetField::create('BuildingSource', 'List Type',
						$this->dbObject('BuildingSource')
						->enumValues()), 'Content');
		
		$fields->addFieldToTab('Root.Main',
				UploadField::create('Image', 'Image'), 'Content');
		 
		return $fields;
	}
	
}
class BuildingListPage_Controller extends Page_Controller {
	
	
}
