<?php
class LandingPage extends Page {
	
	public static $icon = 'mysite/images/icons/mappage';
	
	private static $db = array(
		'BannerTitle' => 'Varchar(200)',
		'BannerContent' => 'Text',
		'BottomTitle' => 'Varchar(200)',
		'BottomTitle2' => 'Varchar(200)',
	);
	
	private static $has_one = array (
		'BannerImage' => 'Image',
		'BottomLink' => 'Link',
	);
	
	private static $has_many = array (
		'Features' => 'Feature',
	);
	
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab(
			'Root.Banner',
			array(
					new UploadField ( 'BannerImage' ),
					TextField::create('BannerTitle'),
					TextareaField::create('BannerContent'),
		));
		
		$fields->addFieldToTab('Root.Link', TextField::create('BottomTitle', 'Left Title'));
		$fields->addFieldToTab('Root.Link', TextField::create('BottomTitle2', 'Right Title'));
		$fields->addFieldToTab('Root.Link', LinkField::create('BottomLinkID', 'Bottom Button Link'));
		
		
		return $fields;
	}
		
	
}
class LandingPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init ();
	}
	
}
