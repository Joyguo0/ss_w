<?php
class EventDetail extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Text',
		'Content'	=> 'Text',
		'SortID'	=> 'Int'	
	);
	
	private static $has_one = array(
		'Page' => 'Page'
	);
	
	private static $summary_fields = array(
		'Title'		=> 'Title',
		'Content'	=> 'Content'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->removeByName('SortID');
		$fields->removeByName('PageID');
		
		return $fields;
	}
	
}