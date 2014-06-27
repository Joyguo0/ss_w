<?php
/**
 *
 */
class Page extends SiteTree {
	
	private static $db = array(
		'ResourceSource'			=> 'enum("Custom,Parent,Global,Hide","Hide")',
		'PageBannersSource'			=> 'enum("Custom,Parent,Global,Hide","Global")',
		'SlidesSource'				=> 'enum("Custom,Parent,Global,Hide","Hide")'
	);
	
	private static $defaults = array(
		'ResourceSource'				=> "Hide",
		'PageBannersSource'				=> "Global",
		'SlidesSource'					=> "Global"
	);

	private static $many_many = array(
		'Resources' 			=> 'Resource',
		'PageBanners'			=> 'PageBanner',
		'Slides' 				=> 'Slide',
	);
	
	private static $many_many_extraFields = array(
		'Resources'				=> array('Sort'=>'Int'),
		'Slides'				=> array('Sort'=>'Int'),
		'PageBanners'			=> array('Sort'=>'Int')
	);
	
	public function getSettingsFields(){
		$fields = parent::getSettingsFields();
	
		return $fields;
	}
	
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		/***************************************Resources*****************************************/
		$fields->addFieldToTab('Root.Resources', OptionsetField::create('ResourceSource', 'Resource Source' ,$this->dbObject('ResourceSource')->enumValues()));
			
		$resourceConfig = GridFieldConfig_RelationEditor::create(30);
		$fields->addFieldToTab('Root.Resources', CompositeField::create($gridField = GridField::create( 'Resources','Resources', $this->Resources(), $resourceConfig ))
				->displayIf("ResourceSource")->isEqualTo("Custom")->end());
		
		$columns = $gridField->getConfig()->getComponentByType('GridFieldDataColumns');
		$columns->setDisplayFields(array(
				'Title' => _t('File.Name'),
				'Created' => _t('AssetAdmin.CREATED', 'Date'),
				'File.Size' => _t('AssetAdmin.SIZE', 'Size'),
		));
		$columns->setFieldCasting(array(
			'Created' => 'Date->Nice'
		));
		/***************************************************************************************/
		/***************************************Slides******************************************/
		$fields->addFieldToTab('Root.Slideshow', OptionsetField::create('SlidesSource', 'Slides Source' ,$this->dbObject('SlidesSource')->enumValues()));
			
		$slidesConfig = GridFieldConfig_ManySortableRelationEditor::create(30);
		if($this->ID){
			$slidesConfig->addComponent(new GridFieldManyRelationHandler(), 'GridFieldPaginator');
		}
		$fields->addFieldToTab('Root.Slideshow', CompositeField::create(GridField::create( 'Slides','Slides', $this->Slides(), $slidesConfig ))
				->displayIf("SlidesSource")->isEqualTo("Custom")->end());
		/***************************************************************************************/
		
		
		/***************************************Side Bar Items**********************************/
		
			/***************************************Page Banners********************************/
		$fields->addFieldToTab('Root.SideBar', HeaderField::create('PageBannersHeading', 'Page Banners'));
		$fields->addFieldToTab('Root.SideBar', OptionsetField::create('PageBannersSource', 'Page Banners Source' ,$this->dbObject('PageBannersSource')->enumValues()));
		
		$pBannersConfig = GridFieldConfig_ManySortableRelationEditor::create(30);
		if($this->ID){
			$pBannersConfig->addComponent(new GridFieldManyRelationHandler(), 'GridFieldPaginator');
		}
		$fields->addFieldToTab('Root.SideBar', CompositeField::create(GridField::create( 'PageBanners','Page Banners', $this->PageBanners(), $pBannersConfig ))
				->displayIf("PageBannersSource")->isEqualTo("Custom")->end());
			/***********************************************************************************/
		
		/***************************************************************************************/
		
		$this->extend('IRXupdateCMSFields', $fields);

		return $fields;
	}
	
	public function Resources() {
		return $this->getManyManyComponents('Resources')->sort('Sort');
	}
	
	public function PageBanners() {
		return $this->getManyManyComponents('PageBanners')->sort('Sort');
	}
	
	public function Slides() {
		return $this->getManyManyComponents('Slides')->sort('Sort');
	}
	
	public function LoadResources(){
	
		if($this->ResourceSource == "Hide"){
			return false;
		}
		//we need to work out what slide to load. Either from this, parent or global
		if($this->ResourceSource == "Parent" && $this->ParentID == 0){
			$this->ResourceSource = "Global";
		}
			
		switch($this->ResourceSource){
			case "Custom":
				return $this->Resources();
				break;
			case "Parent":
				return $this->Parent()->LoadResources();
				break;
			case "Global":
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigResources();
				break;
			default:
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigResources();
				break;
		}
	}
	
	public function LoadPageBanners(){
		//Debug::show($this->PageBannersSource);
		if($this->PageBannersSource == "Hide"){
			return false;
		}
		//we need to work out what slide to load. Either from this, parent or global
		if($this->PageBannersSource == "Parent" && $this->ParentID == 0){
			$this->PageBannersSource = "Global";
		}
		 
		switch($this->PageBannersSource){
			case "Custom":
				return $this->PageBanners();
				break;
			case "Parent":
				return $this->Parent()->PageBanners();
				break;
			case "Global":
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigPageBanners();
				break;
			default:
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigPageBanners();
				break;
		}
	}
	
	public function LoadSlides(){
		//Debug::show($this->Slides());
		if($this->SlidesSource == "Hide"){
			return false;
		}
		//we need to work out what slide to load. Either from this, parent or global
		if($this->SlidesSource == "Parent" && $this->ParentID == 0){
			$this->SlidesSource = "Global";
		}
			
		switch($this->SlidesSource){
			case "Custom":
				return $this->Slides();
				break;
			case "Parent":
				return $this->Parent()->LoadSlides();
				break;
			case "Global":
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigSlides();
				break;
			default:
				$siteConfig = SiteConfig::current_site_config();
				return $siteConfig->LoadSiteConfigSlides();
				break;
		}
	}
	
	
	
	
	public function LoadAllIssuesByCategory(){
	
		$categoryID = $this->LoadCategoryID();
	
		$PublicationVolume = PublicationVolume::get()->filter(array('CategoryID' => $categoryID))->sort('"Sort" DESC');
	
		if(!($PublicationVolume && $PublicationVolume->Count())){
			return false;
		}
	
		$publication = new ArrayList();
	
		foreach ($PublicationVolume as $Volume){
// 			$publication->push($Volume);
			$issueList = PublicationIssue::get()->filter('ParentID', $Volume->ID)->sort('"Sort" DESC');
			
			if($issueList && $issueList->Count()){
				foreach ($issueList as $issue){
					$issue->issuenewTitle = $Volume->Title ." ".$issue->Title;
					$publication->push($issue);
				}
			}
		}
	
		return $publication;
	}
	
	public function LoadCategoryID(){
		//we don't need this for Page.php
		return 0;
	}
	
	
}

class Page_Controller extends ContentController {
	
	private static $allowed_actions = array(
		'NewsletterSignUpForm'
	);
	
	protected $SubscriptionPageController = false;
	
	public $ThemeDir = '';
	
	public function init() {
		parent::init();
		
		Requirements::block(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::block(FRAMEWORK_DIR .'/thirdparty/jquery/jquery.js');
		
		//Requirements::javascript('themes/anzrsai/javascript/vendor/jquery.js');
		
		Requirements::combine_files('anzrsai.js', array(
			'themes/anzrsai/javascript/vendor/jquery.js',
			'themes/anzrsai/javascript/vendor/custom.modernizr.js',
			'themes/anzrsai/javascript/vendor/jquery.horizontalNav.js',
			'themes/anzrsai/javascript/jquery.sidr.min.js',
			'themes/anzrsai/javascript/foundation.min.js',
			'themes/anzrsai/javascript/foundation/foundation.orbit.js',
			'mysite/javascript/global.js',
			'mysite/javascript/AjaxMore.js'
		));
		
		Requirements::javascript('http://w.sharethis.com/button/buttons.js');
		
		//Moderniser
// 		Requirements::javascript('themes/anzrsai/javascript/vendor/custom.modernizr.js');
// 		Requirements::javascript('themes/anzrsai/javascript/vendor/jquery.horizontalNav.js');
// 		Requirements::javascript('themes/anzrsai/javascript/jquery.sidr.min.js');
// 		Requirements::javascript('themes/anzrsai/javascript/foundation.min.js');
// 		Requirements::javascript('themes/anzrsai/javascript/foundation/foundation.orbit.js');
// 		Requirements::javascript('mysite/javascript/global.js');

		
	}
	
	protected $extracrumbs = array();
	
	public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
		$page = $this;
		$pages = array();
		$addHomeLink = true;
	
		while(
				$page
				&& (!$maxDepth || count($pages) < $maxDepth)
				&& (!$stopAtPageType || $page->ClassName != $stopAtPageType)
		) {
			if($showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
				$pages[] = $page;
				
				if($page->ClassName == 'HomePage'){
					$addHomeLink = false;
				}
			}
	
			$page = $page->Parent;
		}
	
		$pages = array_reverse($pages);
	
		// Push on additional items
		if ($this->extracrumbs) {
			$pages = array_merge($pages, $this->extracrumbs);
		}
	
		// Shift the home page link onto the top
		if ($this->RelativeLink() != '/' && $addHomeLink) {
			$home = SiteTree::get_by_link('/');
			$page = new Page();
			$page->Title 	 = $home->Title;
			$page->MenuTitle = $home->MenuTitle;
			$page->Link 	 = $home->Link();
			array_unshift($pages, $page);
		}
	
		$template = new SSViewer('BreadcrumbsTemplate');
	
		return $template->process($this->customise(new ArrayData(array(
				'Pages' => new ArrayList($pages)
		))));
	}
	
	public function NiceEnumValues($enum){
		$types = $this->dbObject($enum)->enumValues();
		if($types){
			foreach($types as $key=>$value){
				$types[$key] = FormField::name_to_label($value);
			}
		}
		return $types;
	}
	
	
	public function NewsletterSignUpForm(){
		if($this->ClassName == 'SubscriptionPage'){
			return false;
		}
		
		Requirements::css('newsletter/css/SubscriptionPage.css');
		// load the jquery
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript(THIRDPARTY_DIR . '/jquery-validate/jquery.validate.min.js');
		
		if($this->SubscriptionPageController === false){
			$subscriptionPageDO = SubscriptionPage::get()->first();
			$subscriptionController = new SubscriptionPage_Controller($subscriptionPageDO);
			$this->SubscriptionPageController = $subscriptionController;
		}

		$form = $this->SubscriptionPageController->Form();
		$form->addExtraClass('signupform');
		
		return $form;
	}
	
	
	
	public function LoadSignUpPage(){
		$pageDO = MemberRegistrationFormPage::get()->first();
		return $pageDO;
	}
	
	public function LoadRenewMembershipPage(){
		$pageDO = RenewMembershipPage::get()->first();
		return $pageDO;
	}
	
	public function LoadMemberDashBoardPage(){
		$pageDO = MemberDashBoardPage::get()->first();
		return $pageDO;
	}
	
	public function LoadAbstractUploadPage(){
		$pageDO = AbstractUploadPage::get()->first();
		return $pageDO;
	}
	
	public function LoadSignInLink(){
		$memberDashBoardPageDO = $this->LoadMemberDashBoardPage();
		
		$returnURL = $memberDashBoardPageDO ? urlencode($memberDashBoardPageDO->Link()) : '%2F';

		return "/Security/login?BackURL=" . $returnURL;
	}
	
	
}
