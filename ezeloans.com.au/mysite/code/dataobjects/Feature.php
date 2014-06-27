<?php
class Feature extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'IconClass' 	=> 'Varchar(255)',
		'Content'		=> 'Text'
	);
	
	private static $has_one = array (
		'Page' 	=> 'SiteTree',
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
			'Root.Main',
			array(
				TextField::create('Title'),
				IconSelectorField::create('IconClass', 'Icon Class'),
				TextareaField::create('Content'),
		));
	
		return $fields;
	}
}