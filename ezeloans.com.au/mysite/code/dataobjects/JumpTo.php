<?php
class JumpTo extends DataObject {
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'IconClass' 	=> 'Varchar(255)',
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
				LoanIconSelectorField::create('IconClass', 'Icon Class'),
				LinkField::create ( 'BlinkID', 'Side Bar Link' ),
		));
	
		return $fields;
	}
}