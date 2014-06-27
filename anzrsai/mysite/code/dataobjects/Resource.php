<?php
class Resource extends DataObject {
	
	private static $db = array(
		'Title' 			=> 'Varchar(255)',
		'Content'    		=> 'HTMLText',
	);
	
	private static $has_one = array(
		'File'			=> 'File',
		'Image'			=> 'Image'
	);
	
	private static $belongs_many_many = array(
		'Pages'  		=> 'Page',
		'SiteConfigs'	=> 'SiteConfig'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', UploadField::create('File', 'File')
			->setFolderName('Uploads/Resources')
		);
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content', 'Content')
			->setRows(10)
		);
		
		$fields->removeByName('Image');
		$fields->removeByName('Content');
		
		return $fields;
	}
	
}