<?php
class Detailtab extends DataObject {
	private static $db = array(
			'Title' 	=> 'Varchar(255)',
			'link' 	=> 'Varchar(500)',
			'Content'		=> 'Text'
	);
	private static $has_one = array (
			'Link' => 'Link',
			'Page' 	=> 'SiteTree',
	);
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						TextField::create('Title'),
						LinkField::create('LinkID', 'Link to page or file'),
						TextField::create('Content'),
				));
	
		return $fields;
	}
}