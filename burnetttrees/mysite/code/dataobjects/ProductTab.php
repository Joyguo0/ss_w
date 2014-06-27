<?php

class ProductTab extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(20)',
		'Sort' 		=> 'Int',
		'Content'  	=> 'Text'
	);

	private static $has_one = array(
		'ProductPage'	=> 'ProductPage'
	);
	
	private static $summary_fields = array(
			'Title' 		=> 'Title',
			'Content'		=> 'Content'
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', TextField::create('Title'));
		$fields->addFieldToTab('Root.Main', TextareaField::create('Content', 'Content'));
		$fields->addFieldToTab('Root.Main', TextField::create('Sort', 'Sort'),'Content');
		
		return $fields;
	}

	
	
}