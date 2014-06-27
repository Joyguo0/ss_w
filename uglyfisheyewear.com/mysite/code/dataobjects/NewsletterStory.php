<?php
class NewsletterStory extends DataObject {
	
	private static $db = array(
		'Title' 			=> 'Varchar(255)',
		'Content'    		=> 'HTMLText',
	);
	
	private static $has_one = array(
		'Link'			=> 'Link',
		'Image'			=> 'Image',
		"Newsletter" 	=> "Newsletter"
	);
	
	private static $summary_fields = array(
		'Title'  				=> 'Title',
		'Content'  				=> 'Content',
		'Image.CMSThumbnail'  	=> 'Image'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content', 'Content')->setRows(10));
		$fields->addFieldToTab('Root.Main', LinkField::create('LinkID', 'Link'));
		$fields->addFieldToTab("Root.Main",UploadField::create( 'Image' )->setFolderName('Uploads/Logo'));
		
		
		return $fields;
	}
	
}