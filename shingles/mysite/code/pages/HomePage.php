<?php
/**
 *
 */
class HomePage extends Page {
	
	private static $icon = 'mysite/images/icons/homepage-file.gif';
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Slideshows' => 'Slideshow',
		'ProductLinks' => 'ProductLink'
	);
	
	public function canDelete($member = null){
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}
	
	public function Slideshows(){
		return $this->owner->getComponents('Slideshows')->sort('Sort');
	}
	
	public function ProductLinks(){
		return $this->owner->getComponents('ProductLinks')->sort('Sort');
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		/*************************************** Slideshows ****************************************/
		$SlideshowsConfig = GridFieldConfig_RelationEditor::create()
			->addComponent(new GridFieldSortableRows('Sort'));
		$SlideshowsSections = GridField::create( 'Slideshows','Slideshows', $this->Slideshows(), $SlideshowsConfig );
		$fields->addFieldToTab('Root.Slideshows', $SlideshowsSections);
		
		/*************************************** Slideshows ****************************************/
		if(Subsite::currentSubsiteID() == 1){
			$ProductLinksConfig = GridFieldConfig_RelationEditor::create()
				->addComponent(new GridFieldSortableRows('Sort'));
			$ProductLinksSections = GridField::create( 'ProductLinks','Product Links', $this->ProductLinks(), $ProductLinksConfig );
			$fields->addFieldToTab('Root.ProductLinks', $ProductLinksSections);	
		}
		
		return $fields;
	}
	
	
	public function getPaymentPage(){
		$PaymentPage = PaymentPage::get()->First();
		return $PaymentPage;
	}
}

class HomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
