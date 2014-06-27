<?php
class SlideBarShow extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
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
		'Title'     			=> 'Title',
		'Link.getLinkURL'     	=> 'URL'
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