<?php
/**
 *
 */
class PublicationCategory extends Page {
	
	private static $icon = 'mysite/images/icons/publicationcategory';
	
	private static $db = array(
	);
	
	private static $defaults = array(
		'PageBannersSource' => 'Hide'
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Volumes' => 'PublicationVolume'		
	);
	
	private static $allowed_children = array(
		'PublicationVolume'
	);
	
	private static $extensions = array(
		"ExcludeChildren"
	);
	
	private static $excluded_children = array(
		'PublicationVolume'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root', new Tab('PublicationVolumes'), 'Resources');
		
		$VolumesConfig = GridFieldConfig_RecordEditor::create();
		$VolumesConfig->addComponent(new GridFieldSortableRows('Sort'));
		$VolumesField = new GridField('Volumes', 'Volumes', $this->Volumes()->sort('"Sort" ASC'), $VolumesConfig);
		$fields->addFieldToTab("Root.PublicationVolumes", $VolumesField);

		return $fields;
	}
	
	public function  getVolume(){
		return $this->Volumes();
	}
	
	
	public function LoadCategoryID(){
		return $this->ID;
	}
	
}

class PublicationCategory_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
