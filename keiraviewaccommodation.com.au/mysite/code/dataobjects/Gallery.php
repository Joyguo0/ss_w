<?php
class Gallery extends DataObject {
	private static $has_one = array (
			'Image' => 'Image',
			'Page' 	=> 'SiteTree',
	);
	static $summary_fields = array(
			'Image.CMSThumbnail'  	=> 'Image'
	);
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						UploadField::create('Image')
				));
	
		return $fields;
	}
}