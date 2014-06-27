<?php
class Pricing extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Text',
		'Content' 	=> 'Text'
	);
	
	private static $has_one = array(
		'Page' 	=> 'SiteTree'
	);
	
	static $summary_fields = array(
		'Title'     => 'Title',
		'Content'	=> 'Content'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title'),
				TextareaField::create('Content')
		));
		
		return $fields;		
	}
	
}