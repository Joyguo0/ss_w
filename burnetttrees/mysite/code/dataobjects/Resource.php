<?php
class Resource extends DataObject {
	
	private static $db = array(
		'Title' 		=> 'Varchar(255)',
		'Content' 		=> 'Text',
		'Sort'			=> 'Int'	
	);
	
	private static $has_one = array(
		"File" 		=> "File",
		'Parent' 	=> 'Page'	
	);
	
	public function getCMSFields(){
		$field = new FieldList(new TabSet('Root'));
		
		$field->addFieldsToTab('Root.Main', array(
			TextField::create('Title'),
			TextareaField::create('Content', 'Description'),
			UploadField::create("File")->setFolderName('Uploads/Resource')		
		));
		
		return $field;
	}
	
	
}