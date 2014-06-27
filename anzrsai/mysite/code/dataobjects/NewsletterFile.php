<?php
class NewsletterFile extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Text',
		'Content'	=> 'Text',
		'Sort'		=> 'Int'	
	);
	
	private static $has_one = array(
		'Page' => 'Page',
		'File' => 'File'
	);
	
	private static $summary_fields = array(
		'Title'		=> 'Title'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->removeByName('Sort');
		$fields->removeByName('PageID');
		$fields->removeByName('Content');
		
		return $fields;
	}
	
}