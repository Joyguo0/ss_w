<?php
class Slideshow extends DataObject {
	private static $db = array(
			'Title' 	=> 'Varchar(255)',
	);
	private static $has_one = array (
			'Image' => 'Image',
			'Page' => 'SiteTree' 
	);
	static $summary_fields = array (
			'Image.CMSThumbnail' => 'Image' 
	);
	public function getCMSFields() {
		$fields = new FieldList ( new TabSet ( 'Root' ) );
		
		$fields->addFieldsToTab ( 'Root.Main', array (
				TextField::create ( 'Title' ),
				UploadField::create ( 'Image' ) 
		) );
		
		return $fields;
	}
}