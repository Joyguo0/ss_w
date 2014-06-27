<?php

class Distributor extends Store {

	private static $db = array(
	);
	
	private static $has_one = array(
		'Image' => 'Image'		
	);

	private static $default_sort = '"Title"';

	private static $searchable_fields = array(
		'Title'
	);

	private static $summary_fields = array(
		'Title',
		'Website'
	);

	public function getCMSFields ()
	{
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab('Root.Main',
	            UploadField::create('Image', 'Image'),'Content');
	
	    return $fields;
	}
	
}


class Distributor_Controller extends Store_Controller {


}