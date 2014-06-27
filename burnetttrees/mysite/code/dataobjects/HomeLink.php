<?php
class HomeLink extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'Sort'		=> 'Int'	
	);
	
	private static $has_one = array(
		'Link' 	=> 'Link',
		'Page' 	=> 'SiteTree'			
	);
	
	static $summary_fields = array(
		'Title'     			=> 'Title',
		'Link.getLinkURL'     	=> 'URL'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title'),
				LinkField::create('LinkID', 'Link')
		));
		
		return $fields;		
	}
	
}