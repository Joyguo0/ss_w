<?php
class SideBarLink extends DataObject {
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'IconClass' 	=> 'Varchar(255)',
		'Description'		=> 'Text'
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
				IconSelectorField::create('IconClass', 'Icon Class'),
				LinkField::create ( 'BlinkID', 'Side Bar Link' ),
				TextField::create('Description'),
		));
	
		return $fields;
	}
}