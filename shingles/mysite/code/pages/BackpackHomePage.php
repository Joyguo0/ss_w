<?php
/**
 *
 */
class BackpackHomePage extends UserDefinedForm {
	
	public static $icon = 'mysite/images/icons/homepage-file.gif';
	
	private static $db = array(
		//"Address" => 'Text'
		'TSTitle' 	=> 'Varchar(128)',
		'TSContent' => 'Text'
			
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
		'Slideshows' => 'Slideshow',
		'Features' => 'Feature',
		'Pricing' => 'Pricing'
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
	
	public function Features(){
		return $this->owner->getComponents('Features')->sort('Sort');
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$SlideshowsConfig = GridFieldConfig_RelationEditor::create()
			->addComponent(new GridFieldSortableRows('Sort'));
		$SlideshowsSections = GridField::create( 'Slideshows','Slideshows', $this->Slideshows(), $SlideshowsConfig );
		$fields->addFieldToTab('Root.Slideshows', $SlideshowsSections);
		
		$FeaturesConfig = GridFieldConfig_RelationEditor::create()
		->addComponent(new GridFieldSortableRows('Sort'));
		$FeaturesSections = GridField::create( 'Features','Features', $this->Features(), $FeaturesConfig );
		$fields->addFieldToTab('Root.Features', $FeaturesSections);
		
		$fields->addFieldToTab('Root.TechSpec', TextField::create('TSTitle', 'Technical Specifications Title'));
		$fields->addFieldToTab('Root.TechSpec', TextareaField::create('TSContent', 'Technical Specifications Content'));
		
		return $fields;
	}
	
	public function getPaymentPage(){
		$PaymentPage = PaymentPage::get()->First();
		return $PaymentPage;
	}
	
	
	//getting aoterh subsite list for backpacks
// 	public  function  SubSiteList() {
// 		$backpackSubsiteID = Subsite::currentSubsiteID();
	
// 		$reslutDL= new ArrayList();
	
// 		$webDomain = Director::absoluteBaseURL();
// 		if(stripos($webDomain, '.local') !== false){
			
// 			$reslutDL->push(new ArrayData(array('Title' => 'American Shingles'		, 'Domain' => 'americanshingles.local')));
// 			$reslutDL->push(new ArrayData(array('Title' => 'Secure Anchor Systems'	, 'Domain' => 'secureanchorsystems.americanshingles.local')));

// 		}elseif(stripos($webDomain, '.dev.internetrix.net') !== false){
			
// 			$reslutDL->push(new ArrayData(array('Title' => 'American Shingles'		, 'Domain' => 'americanshingles.dev.internetrix.net')));
// 			$reslutDL->push(new ArrayData(array('Title' => 'Secure Anchor Systems'	, 'Domain' => 'secureanchorsystems.dev.internetrix.net')));

// 		}else{
			
// 			$subsiteDL = Subsite::get()->where("\"ID\" != $backpackSubsiteID AND \"IsPublic\" = 1");
// 			if($subsiteDL && $subsiteDL->Count()){
// 				foreach ($subsiteDL as $subsiteDO){
// 					$subsiteTitle 		= $subsiteDO->Title;
// 					$subsiteDomainDO	= $subsiteDO->Domains()->sort('"IsPrimary" DESC')->first();
// 					$subsiteDomain		= ($subsiteDomainDO && $subsiteDomainDO->Domain) ? $subsiteDomainDO->Domain : false;
		
// 					if($subsiteDomain){
// 						$reslutDL->push(new ArrayData(array('Title' => $subsiteTitle, 'Domain' => $subsiteDomain)));
// 					}
// 				}
// 			}
			
// 		}	
	
// 		return $reslutDL;
// 	}
	
}

class BackpackHomePage_Controller extends UserDefinedForm_Controller {
	
	private static $allowed_actions = array('Form','finished');
	
	public function Form() {
		$form = parent::Form();
		
		if( ! $form instanceof Form){
			return $form;
		}
		
		$form->addExtraClass('contact');
 	
		return  $form;
	}
	
	public function init() {
		parent::init();
	
	}
	
// 	public function  LoadAddress(){
// 		return urlencode($this->Address);
// 	}

}
