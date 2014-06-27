<?php
class Gallery extends DataObject {
	
	private static $singular_name = 'Slideshow Image';
	
	private static $plural_name = 'Slideshow Images';
	
	private static $has_one = array (
			'Image' => 'Image',
			'Page' 	=> 'SiteTree',
			'Link' => 'Link'
	);
	static $summary_fields = array(
			'Image.CMSThumbnail'  	=> 'Image',
			'Link.getLinkURL'  	=> 'Link'
	);
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						UploadField::create('Image')->setFolderName('Uploads/Gallery'),
						LinkField::create ( 'LinkID', 'Link' )
				));
	
		return $fields;
	}
}