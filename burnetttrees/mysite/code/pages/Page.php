<?php
/**
 *
 */
class Page extends SiteTree {
	
	private static $db = array(
		'SlidesSource'			=> 'enum("Custom,Parent,Global,Hide","Hide")',
		'PageBannersSource'		=> 'enum("Custom,Parent,Global,Hide","Hide")',
		'Introductory'			=> 'HTMLText'
	);
	
	private static $defaults = array(
		'SlidesSource'			=> "Hide",
		'PageBannersSource'		=> "Global"
	);
	
	private static $many_many = array(
		'Slides' 				=> 'Slide',
		'PageBanners'			=> 'PageBanner'
	);
	
	private static $many_many_extraFields = array(
		'Slides'				=> array('Sort'=>'Int'),
		'PageBanners'			=> array('Sort'=>'Int')
	);
	
	public function getSettingsFields(){
		$fields = parent::getSettingsFields();
		
		$fields->addFieldToTab('Root.Settings', new CheckboxField("DoNotShowRemarketingCode", 'Do not show the remarketing code on this page?'), "ShowInMenus");
		
		return $fields;
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		/***************************************Slides******************************************/
		if($this->ClassName == 'HomePage'){
			$fields->addFieldToTab('Root.Slideshow', OptionsetField::create('SlidesSource', 'Slides Source' ,$this->dbObject('SlidesSource')->enumValues()));
				
			$slidesConfig = GridFieldConfig_ManySortableRelationEditor::create(30);
			if($this->ID){
				$slidesConfig->addComponent(new GridFieldManyRelationHandler(), 'GridFieldPaginator');
			}
			$fields->addFieldToTab('Root.Slideshow', CompositeField::create(GridField::create( 'Slides','Slides', $this->Slides(), $slidesConfig ))
					->displayIf("SlidesSource")->isEqualTo("Custom")->end());
		}
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
		if($this->ClassName == 'MediaPage' || $this->ClassName == 'ProductPage' || $this->ClassName == 'ServicePage' )
			$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Introductory', 'Introductory')->setRows(15), 'Content');
		
		/***************************************************************************************/
		
		$this->extend('IRXupdateCMSFields', $fields);
		
		return $fields;
	}
	
	public function Slides() {
		return $this->getManyManyComponents('Slides')->sort('Sort');
	}
	
	public function PageBanners() {
		return $this->getManyManyComponents('PageBanners')->sort('Sort');
	}
	
	public function LoadSlides(){
	
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
	
	public function LoadPageBanners(){
	
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
				return $this->Parent()->LoadPageBanners();
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
	
	public  function getParentPage(){
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
	
	public  function getGrandparentsChildren($num = null){
		$parent = $this->getParent()->getParent();
		if($parent)
			return $parent->Children()->sort('Sort','ASC')->limit($num);
		else
			return false;
	}
	
	public  function getGrandparentsPage(){
		$parent = $this->getParent()->getParent();
		if(empty($parent))
			return false;
			
		return $parent;
	}

	public function getCategory(){
		if(Subsite::currentSubsiteID()){
			//this is burrnet trees, then show service pages
			$ServiceListpage = ServiceListPage::get()->first();
			
			if($ServiceListpage){
				$ServiceCategory = ServiceCategory::get()->filter('ParentID', $ServiceListpage->ID)->sort('Sort','ASC');
				return $ServiceCategory;
			}
		}else{
			//this is Burnetts On Barneys, then show product pages
			$ProductListpage = ProductListPage::get()->first();
			
			if($ProductListpage){
				$ProductCategory = ProductCategory::get()->filter('ParentID', $ProductListpage->ID)->sort('Sort','ASC');
				return $ProductCategory;
			}
		}
	}
	
	public function getProducts($num = null){
		
		$ProList = new ArrayList();
		
		if(Subsite::currentSubsiteID()){
			//this is burrnet trees, then show service pages
			$ServicePages = ServicePage::get()->sort('Sort','ASC')->limit($num);
			
			foreach ($ServicePages as $servo){
				$category = $servo->getParent();
				$servo->CategoryTitle = $category->Title;
				$ProList->push($servo);
				
			}
		}else{
			//this is Burnetts On Barneys, then show product pages
			$ProductPages = ProductPage::get()->sort('Sort','ASC')->limit($num);
			
			foreach ($ProductPages as $pro){
				$category = $pro->getParent();
				$pro->CategoryTitle = $category->Title;
				$ProList->push($pro);
				
			}
		}

		return $ProList;
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
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => 'burnetts.local', 'Current' => $isCurrent)));
		}elseif(stripos($webDomain, '.dev.internetrix.net') !== false){
			//dev domain
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => 'burnetts.com.au.site.dev.cn.internetrix.net', 'Current' => $isCurrent)));
		}else{
			//live domain
			$reslutDL->push(new ArrayData(array('Title' => $siteconfigDO->Title, 'Domain' => $siteconfigDO->SiteDomain, 'Current' => $isCurrent)));
		}
	
		$subsiteDL = Subsite::get();
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
	
	public function OtherSiteDomain() {
		$dev_servers = array(
			'.internetrix.net.tmp.anchor.net.au' 	=> '.delta350.internetrix.net.tmp.anchor.net.au',
			'.delta350.internetrix.net' 			=> '.delta350.internetrix.net'
		);//don't change the order of this array
		
		$suffix = '';
		
		foreach ($dev_servers as $ServerURL => $server_suffix){
			if(stripos($_SERVER['HTTP_HOST'], $ServerURL) !== false){
				$suffix = $server_suffix;
			}
		}
		
		return Subsite::currentSubsiteID() ? 'burnettsonbarney.com.au' . $suffix : 'burnetttrees.com.au' . $suffix ;
	}
	
	
	public function OtherSiteConfig() {
		if(Subsite::currentSubsite()){
			return SiteConfig::get()->where('"SubsiteID" = 0')->first();
		}else{
			return SiteConfig::get()->where('"SubsiteID" = 1')->first();
		}
	}
	
}

class Page_Controller extends ContentController {
	
	public $ThemeDir = '';
	
	public function init() {
		parent::init();
		
		$this->ThemeDir = 'themes/' . SSViewer::current_theme() . '/';
		
		//Requirements::css($this->ThemeDir . 'css/editor.css');
		
		Requirements::block(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::block(FRAMEWORK_DIR .'/thirdparty/jquery/jquery.js');
		
		Requirements::combine_files('burnetts.js', array(
			'themes/burnetts/javascript/vendor/modernizr.js',
			'themes/burnetts/javascript/vendor/jquery.js',
			'themes/burnetts/javascript/foundation/foundation.js',
			'themes/burnetts/javascript/foundation/foundation.topbar.js',
			'themes/burnetts/javascript/foundation/foundation.tab.js',
			'themes/burnetts/javascript/foundation/foundation.orbit.js',
			'themes/burnetts/javascript/foundation/foundation.accordion.js',
			'themes/burnetts/javascript/vendor/isotope.pkgd.min.js',
			'themes/burnetts/slick/slick.min.js',
			'mysite/javascript/ajax.js',
			'mysite/javascript/flexslider/jquery.flexslider.manualDirectionControls.js',
			'mysite/javascript/flexslider/jquery.flexslider-min.js',
			'themes/burnetts/javascript/script.js'
		));
		Requirements::css('mysite/javascript/flexslider/flexslider.css');
	}
	
	protected $extracrumbs = array();
	
	public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
		$page = $this;
		$pages = array();
		
		$addedHomePage = false;
	
		while(
				$page
				&& (!$maxDepth || count($pages) < $maxDepth)
				&& (!$stopAtPageType || $page->ClassName != $stopAtPageType)
		) {
			if($showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
				$pages[] = $page;
			}
			
			if($page->ClassName == 'HomePage'){
				$addedHomePage = true;
			}
	
			$page = $page->Parent;
		}
	
		$pages = array_reverse($pages);
	
		// Push on additional items
		if ($this->extracrumbs) {
			$pages = array_merge($pages, $this->extracrumbs);
		}
	
		// Shift the home page link onto the top
		if ($this->RelativeLink() != '/' && !$addedHomePage) {
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
	
}
