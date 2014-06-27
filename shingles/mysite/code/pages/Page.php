<?php
/**
 *
 */
class Page extends SiteTree {
	
	private static $db = array(
	);
	
	private static $has_many = array(
		'GalleryImages' => 'GalleryImage'
	);
	
	public function getSettingsFields(){
		$fields = parent::getSettingsFields();

		
		return $fields;
	}
	
	public function GalleryImages(){
		return $this->getComponents('GalleryImages')->sort('Sort');
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		if($this->ClassName == 'Page' || $this->ClassName == 'ShingleTypePage' || $this->ClassName == 'CasePage'){
			$GimagesConfig = GridFieldConfig_RelationEditor::create()
				->addComponent(new GridFieldSortableRows('Sort'));
			$GimagesSections = GridField::create( 'GalleryImages','Images', $this->GalleryImages(), $GimagesConfig );
			$fields->addFieldToTab('Root.Images', $GimagesSections);
		}

		return $fields;
	}
	
	public function GetShingleHolderPage($num = null) {
		$holder = ShingleHolderPage::get()->First();
		return ($holder) ? ShingleTypePage::get()->filter('ParentID', $holder->ID)->sort('"Sort" ')->limit($num) : false;
		
	}
	
	public function GetCaseHolderPage($num = null) {
		$holder = CaseHolderPage::get()->First();
		return ($holder) ? CasePage::get()->filter('ParentID', $holder->ID)->sort('"Featured" DESC, "ID" DESC')->limit($num) : false;
	
	}
	
	public  function getParentPage($num = null){
		$parent = $this->getParent();
		if(empty($parent))
			return false;
			
		return $parent;
	}
	
	public  function getParentChildren($num = null){
		$parent = $this->getParent();
		if($parent)
			return $parent->Children()->sort('Sort','ASC')->limit($num);
		else
			return false;
	}
	
	public  function  SubSiteList() {
		$currentSubsiteID = Subsite::currentSubsiteID();
		$isCurrent = false;
		
		if($currentSubsiteID == 0){
			$isCurrent = true;
		}
		
		$siteconfigDO = SiteConfig::get()->where("\"ID\" = 1 AND \"SubsiteID\" = 0")->first();
		$reslutDL= new ArrayList();
		
		$webDomain = Director::absoluteBaseURL();
		if(stripos($webDomain, '.local') !== false){
			//local domain
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => 'americanshingles.local', 'Current' => $isCurrent)));
		}elseif(stripos($webDomain, '.dev.internetrix.net') !== false){
			//dev domain
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => 'americanshingles.dev.internetrix.net', 'Current' => $isCurrent)));
		}else{
			//live domain
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => $siteconfigDO->SiteDomain, 'Current' => $isCurrent)));
		}
		
		$subsiteDL = Subsite::get()->filter(array('IsPublic' => true));
		if($subsiteDL && $subsiteDL->Count()){
			foreach ($subsiteDL as $subsiteDO){
				$isCurrent = false;
				if($subsiteDO->ID == $currentSubsiteID){
					$isCurrent = true;
				}
				
				$subsiteTitle 		= $subsiteDO->Title;
				$subsiteDomainDO	= $subsiteDO->Domains()->sort('"IsPrimary" DESC')->first();
				$subsiteDomain		= ($subsiteDomainDO && $subsiteDomainDO->Domain) ? $subsiteDomainDO->Domain : false;
				
				if($subsiteDomain){
					$reslutDL->push(new ArrayData(array('Title' => $subsiteTitle, 'Domain' => $subsiteDomain, 'Current' => $isCurrent)));
				}
			}
		}
		
		return $reslutDL;
	}
}

class Page_Controller extends ContentController {
	
	public $ThemeDir = '';
	
	public function init() {
		parent::init();
		
		$this->ThemeDir = 'themes/' . SSViewer::current_theme() . '/';
		
		Requirements::css('http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700');
		Requirements::css('http://fonts.googleapis.com/css?family=Gentium+Book+Basic:700');	//secure anchor System Does not exist
		Requirements::css('http://fonts.googleapis.com/css?family=Lato:400,700,400italic');
		Requirements::css($this->ThemeDir . 'css/onepcssgrid.css');
		Requirements::css($this->ThemeDir . 'javascript/bestmenu/drop/superfish.css');
		Requirements::css($this->ThemeDir . 'javascript/bestmenu/mobile/meanmenu.css');
		Requirements::css($this->ThemeDir . 'javascript/tooltip/jquery.qtip.min.css');
		Requirements::css($this->ThemeDir . 'javascript/flexslider/flexslider.css');
		Requirements::css($this->ThemeDir . 'javascript/carousel/jquery.bxslider.css');
		Requirements::css($this->ThemeDir . 'javascript/magnificpopups/magnificpopups.css');
 		Requirements::css($this->ThemeDir . 'css/style.css');
		
 		Requirements::javascript(FRAMEWORK_DIR .'/thirdparty/jquery/jquery.js');
 		Requirements::javascript($this->ThemeDir . 'javascript/tooltip/jquery.qtip.min.js');
 		
 		Requirements::combine_files('site.js', array(
	 		$this->ThemeDir . 'javascript/magnificpopups/magnificpopups.js',
	 		$this->ThemeDir . 'javascript/bestmenu/drop/superfish.js',
	 		$this->ThemeDir . 'javascript/bestmenu/mobile/jquery.meanmenu.js',
	 		$this->ThemeDir . 'javascript/carousel/jquery.bxslider.js',
	 		$this->ThemeDir . 'javascript/flexslider/jquery.flexslider.manualDirectionControls.js',
	 		$this->ThemeDir . 'javascript/flexslider/jquery.flexslider-min.js',
	 		$this->ThemeDir . 'javascript/html.js',
	 	));
	}
	
	
	protected function _checkSSL() {
		//check server
		if(($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '110.173.154.238') && Director::isDev()){
			return false;
		}
		
		if(eWayRapidPayment::$testMode == true){
			return false;
		}
	
		//if its on live server, most of pages should be in https.
		$destURL = false;
		$needSSL = true;
	
// 		//check if this page need SSL
// 		if( ! in_array($this->ClassName, $this->SSL_Page_Types)){
// 			$needSSL = false;
// 		}
	
		$inSSL = ( isset($_SERVER['SSL']) || (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ) ? true : false;
	
		if($needSSL && !$inSSL){
			$destURL = 'https://safetypack.secureanchor.com.au' . $_SERVER['REQUEST_URI'];
		}elseif(!$needSSL && $inSSL){
			$destURL = str_replace('https:','http:', Director::absoluteURL($_SERVER['REQUEST_URI']));
		}
	
		if( $destURL ) {
			header("Location: $destURL", true, 301);
			die('<h1>Your browser is not accepting header redirects</h1><p>Please <a href="'.$destURL.'">click here</a>');
		}
	}
	
}
