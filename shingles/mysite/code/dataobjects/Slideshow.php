<?php
class Slideshow extends DataObject {
	
	private static $db = array(
		'Title1' 	=> 'Varchar(255)',
		'Title2' 	=> 'Varchar(500)',
		'Sort'		=> 'Int'	
	);
	
	private static $has_one = array(
		'Link' 	=> 'Link',
		'Image' => 'Image',
		'Page' 	=> 'SiteTree',
		'SiteConfig'	=> 'SiteConfig'				
	);
	
	static $summary_fields = array(
		'Image.CMSThumbnail'  	=> 'Image',
		'Title1'     			=> 'Title1',
		'Title2'    			=> 'Title2',
		'Link.getLinkURL'     	=> 'URL'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title1'),
				TextField::create('Title2'),
				LinkField::create('LinkID', 'Link'),
				UploadField::create('Image')
		));
		
		return $fields;		
	}
	
}