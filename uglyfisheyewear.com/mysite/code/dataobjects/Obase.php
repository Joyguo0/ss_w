<?php
class Obase extends DataObject {
	
	private static $singular_name = 'Banner Image';
	private static $plural_name = 'Banner Images';
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'Content'	=> 'Text'
	);
	
	private static $has_one = array (
		'Page' 			=> 'SiteTree',
		'SiteConfig' 	=> 'SiteConfig',
		'Olink' 		=> 'Link',
		'Oimage' 		=> 'Image',
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
			'Root.Main',
			array(
				TextField::create('Title'),
				LinkField::create ( 'OlinkID', 'Olink Link' ),
				UploadField::create('Oimage')->setFolderName('Uploads/Banner')
		));
	
		return $fields;
	}
}