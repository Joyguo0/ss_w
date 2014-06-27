<?php
/**
 *
 */
class HomePage extends Page {
	
	public static $icon = 'mysite/images/icons/homepage';
	
	private static $db = array(
	);
	
	private static $defaults = array(
	);
	
	private static $many_many = array(
	);
	
	private static $many_many_extraFields = array(
		
	);
	
	public function canCreate($member = null) {
		return false;
	}
	
	public function canDelete($member = null) {
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
	
}

class HomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		Requirements::javascript('themes/anzrsai/javascript/responsiveslides.min.js');
		Requirements::javascript('themes/anzrsai/javascript/rslides.js');
	}
	
	public function LatestNews(){
		$latestNews = News::get()->sort('Date','DESC')->limit(3);
		//Debug::show($latestNews);
		return $latestNews;
	}
	
	
	
}
