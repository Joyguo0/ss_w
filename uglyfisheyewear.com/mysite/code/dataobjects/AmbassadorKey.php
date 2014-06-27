<?php
class AmbassadorKey extends DataObject {
	private static $db = array(
			'Title' 	=> 'Varchar(255)',
	);
	private static $has_one = array (
			'Image' 		=> 'Image',
			'Icon' 			=> 'Image',
			'Page' 			=> 'SiteTree',
			'SiteConfig' 	=> 'SiteConfig'
	);
	private static $summary_fields = array(
			'Title'  				=> 'Title',
			'Icon.CMSThumbnail'  	=> 'Icon',
			'Image.CMSThumbnail'  	=> 'Image'
	);
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						TextField::create('Title'),
						UploadField::create('Icon')->setFolderName('Uploads/AmbassadorKey/Icon'),
						UploadField::create('Image')->setFolderName('Uploads/AmbassadorKey')
				));
	
		return $fields;
	}
}