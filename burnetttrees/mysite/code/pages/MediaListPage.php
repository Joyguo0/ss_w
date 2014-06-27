<?php
/**
 *
 */
class MediaListPage extends Page {
	
	public static $icon = 'mysite/images/icons/media';
	private static $allowed_children = array('MediaPage');
	
	private static $db = array(
		'Sort' => 'Int'
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		
	);
	
	static $summary_fields = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		$fields->removeByName('SideBar');
		$fields->removeByName('Introductory');
		$fields->removeByName('Slideshow');
		
		
		
		return $fields;
	}
}

class  MediaListPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			'CategorySearch'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public function Medias(){
		return $this->Children();
	}
	
	public function CategorySearch(){
		//RedirectionType
		$type = $this->owner->request->param('ID');
		
		$medias = MediaPage::get()->filter('RedirectionType', $type);
		//Debug::show($medias);
		return $this->customise(array(
				'Medias' => $medias,
				'Type' =>$type
		));
		/*
		$blogcategory = BlogCategory::get_by_id('BlogCategory', $categoryID);
		$blogEntries = $blogcategory->BlogEntries()->sort('Date DESC')->limit($this->page_length);
		$ShowMoreButton  = $this->ShowMoreButton($blogcategory->BlogEntries()->sort('Date DESC')->count());
	
	
		$CategorySearchList = new ArrayList();
		if($blogEntries && $blogEntries->Count()){
			foreach ($blogEntries as $itemDO){
					
				$itemDO->EntryCategory = $this->EntryCategory($itemDO->ID);
				$CategorySearchList->push($itemDO);
			}
		}
	
		return $this->owner->customise(array(
				'BlogEntry' => $CategorySearchList,
				'ShowMoreButton' => $ShowMoreButton,
				'categoryid' =>$categoryID
		));
		*/
	}
}
