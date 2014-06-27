<?php
class ProductLink extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Text',
		'Sort'		=> 'Int'
	);
	
	private static $has_one = array(
		'Link' 	=> 'Link',
		'Image' => 'Image',
		'Page' 	=> 'SiteTree'
	);
	
	static $summary_fields = array(
		'Image.CMSThumbnail'  	=> 'Image',
		'Title'     			=> 'Title',
		'Content'     			=> 'Content'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title'),
				LinkField::create('LinkID', 'Link'),
				UploadField::create('Image')
		));
		return $fields;		
	}
	
}