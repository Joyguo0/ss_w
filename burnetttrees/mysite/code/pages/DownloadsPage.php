<?php
/**
 *
 */
class DownloadsPage extends Page {
	
	private static $icon = 'mysite/images/icons/downloadspage';
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Resources' => 'Resource'
	);
	
	public function getCMSFields(){
		
		
		$fields = parent::getCMSFields();
		
		/************************************ Resources **********************************************/
		$fields->addFieldToTab('Root.Resources', HeaderField::create('Resources', 'Resources'));
		$LinksConfig = GridFieldConfig_RelationEditor::create();
		$LinksConfig->addComponents(new GridFieldSortableRows('Sort'));
		$LinksSections = GridField::create('HomeLinks','SlideshowLinks', $this->Resources(), $LinksConfig );
		$fields->addFieldToTab('Root.Resources', $LinksSections);
		/**************************************************************************************/
		
		$fields->removeByName('SideBar');
		
		return $fields;
	}
}

class DownloadsPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
