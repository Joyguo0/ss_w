<?php
class ProductImage extends DataObject {
	
	private static $singular_name = 'Product Image';
	private static $plural_name = 'Product Images';

	private static $db = array (
		'Title' 	=> 'Varchar(255)',
		'Thumbnail'	=> 'Boolean',
		'Sort'		=> 'Int'	
	);

	private static $has_one = array (
		'Image' 	=> 'Image',
		'Product' 	=> 'Product'
	);
	
	private static $summary_fields = array(
		'Image.CMSThumbnail' 	=> 'Image',
		'ThumbnailYes' 	 	=> 'Thumbnail',
	    'Title' 				=> 'Title'
	);
	
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));

		$fields->addFieldToTab('Root.Main', TextField::create('Title'));
		$fields->addFieldToTab('Root.Main', CheckboxField::create('Thumbnail', 'Is thumbnail'));
		$fields->addFieldToTab('Root.Main', UploadField::create('Image')->setFolderName('Uploads/Product'));
		
		return $fields;
	}


	public function ThumbnailYes(){
		return $this->Thumbnail ? 'Yes' : '';
	}
	
}