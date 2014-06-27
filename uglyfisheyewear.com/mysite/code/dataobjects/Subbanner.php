<?php
class Subbanner extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
	);
	
	private static $has_one = array (
		'Page' 	=> 'SiteTree',
		'Blink' => 'Link',
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
			'Root.Main',
			array(
					TextField::create('Title'),
					LinkField::create ( 'BlinkID', 'Link' ),
		));
	
		return $fields;
	}
}