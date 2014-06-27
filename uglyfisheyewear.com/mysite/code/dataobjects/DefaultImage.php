<?php
class DefaultImage extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Code' 	=> 'Varchar(64)',
	);
	
	private static $has_one = array (
		'Image' 	=> 'Image',
		'SiteConfig' => 'SiteConfig'
	);
	
	private static $summary_fields = array(
		'Title' 				=> 'Title', 
		'Code' 					=> 'Code',
		'Image.CMSThumbnail'  	=> 'Image'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
			'Root.Main',
			array(
				TextField::create('Title'),
				TextField::create('Code'),
				UploadField::create('Image')->setFolderName('Uploads/DefaultImage')
		));
	
		return $fields;
	}
	
}