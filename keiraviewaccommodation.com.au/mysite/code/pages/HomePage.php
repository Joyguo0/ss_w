<?php
class HomePage extends Page {
	public static $icon = 'mysite/images/icons/homepage';
	private static $db = array ();
	private static $has_one = array ();
	private static $has_many = array (
			'Slideshows' => 'Slideshow',
			'Gallerys' => 'Gallery' ,
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$SlideshowsSections = GridField::create ( 'Slideshows', 'Slideshows', $this->Slideshows (), GridFieldConfig_RelationEditor::create () );
		$GallerysSections = GridField::create ( 'Gallerys', 'Gallerys', $this->Gallerys (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Gallerys', $GallerysSections );
		$fields->addFieldToTab ( 'Root.Slideshows', $SlideshowsSections );
		return $fields;
	}
}
class HomePage_Controller extends Page_Controller {
	public function init() {
		parent::init ();
	}
}
