<?php
class DownloadFile extends DataObject {
	
	private static $db = array(
		'Title' 	=> 'Varchar(255)',
		'Content' 	=> 'Text',
		'Sort'		=> 'Int'	
	);
	
	private static $has_one = array(
		'Link' 	=> 'Link',
		'File' => 'File',
		'Page' 	=> 'SiteTree'			
	);
	
	static $summary_fields = array(
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldsToTab(
			'Root.Main', 
			array(
				TextField::create('Title'),
				UploadField::create('File'),
				TextField::create('Content')
		));
		
		return $fields;		
	}
	
}