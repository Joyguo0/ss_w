<?php
class HomePage extends Page {
	public static $icon = 'mysite/images/icons/homepage';
	private static $db = array ();
	private static $has_one = array ();
	private static $has_many = array (
		'Gallerys' => 'Gallery'
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$GallerysSections = GridField::create ( 'Slideshow', 'Slideshow', $this->Gallerys(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Slideshow', $GallerysSections );
		return $fields;
	}
	
	
	public function canDelete($member = null){
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}
	
	public function canCreate($member = null){
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
}


class HomePage_Controller extends Page_Controller {
	
	public function LoadBestSellersProducts($limit = 6){
		$products = Product::get()->limit($limit);
		
		return $products;
	}
	
	
	
	
}
