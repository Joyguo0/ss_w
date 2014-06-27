<?php
class GalleryImage extends DataObject {
	
	private static $singular_name = 'Image';
	
	private static $plural_name = 'Images';
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'Sort'		=> 'Int'	
	);
	
	private static $has_one = array(
		'Image' => 'Image',
		'Page' 	=> 'SiteTree'
	);
	
	static $summary_fields = array(
		'Title'     			=> 'Title',
		'Image.CMSThumbnail'  	=> 'Image'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title'),
				UploadField::create('Image')
		));
		
		return $fields;		
	}
	
}