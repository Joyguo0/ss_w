<?php
class UglyPeoplePage extends Page {
    
	private static $db = array (
			'Name' => 'Varchar(255)',
	);
	private static $has_one = array (
			'Page' => 'SiteTree',
			'Image' => 'Image',
			'AmbassadorKey' => 'AmbassadorKey',
			'YoutubeLink' => 'Link',
	);
	static $summary_fields = array(
			'Image.CMSThumbnail'  	=> 'Image',
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
	
		$fields->addFieldsToTab ( 'Root.Main', array (
				TextField::create ( 'Name' ),
				LinkField::create ( 'YoutubeLinkID', 'Link' ),
				UploadField::create('Image')->setFolderName('Uploads/UglyPeople'),
				DropdownField::create('AmbassadorKeyID','AmbassadorKey',AmbassadorKey::get()->map('ID', 'Title')),
		) ,'Content');
	
		return $fields;
	}
}
class UglyPeoplePage_Controller extends Page_Controller {
	
	
}