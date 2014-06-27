<?php
class Follow extends DataObject {
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'IconClass' 	=> 'Varchar(255)',
	);
	
	private static $has_one = array (
		'Page' 	=> 'SiteTree',
		'Blink' => 'Link',
		'SiteConfig' => 'SiteConfig'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
			'Root.Main',
			array(
				TextField::create('Title'),
				TextField::create('IconClass', 'Icon Class'),
				LinkField::create ( 'BlinkID', 'Link' ),
		));
	
		return $fields;
	}
}