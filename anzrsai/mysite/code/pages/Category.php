<?php
/**
 *
 */
class Category extends Page {
	
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
	);
	
	private static $allowed_children = array(
		'PublicationVolume'
	);
	
	private static $excluded_children = array(
			'PublicationVolume'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		return $fields;
	}
	
	public function  getVolume(){
		
		//$holder = ShingleHolderPage::get()->First();
		//$PublicationVolumes = false;
		//$PublicationVolumes = PublicationVolume::get()->filter('CategoryID', $this->ID)->sort('"ID" DESC');
		//Debug::show($PublicationVolumes);
		return PublicationVolume::get()->filter('CategoryID', $this->ID)->sort('"ID" DESC');
	}
}

class Category_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
