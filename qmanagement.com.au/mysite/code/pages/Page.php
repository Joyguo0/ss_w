<?php

/**
 *
 */
class Page extends SiteTree {
	private static $db = array (
			'PageBannersSource' => 'enum("Custom,Parent,Global,Hide","Global")' 
	);
	private static $defaults = array (
			'PageBannersSource' => "Global" 
	);
	private static $many_many = array (
			'PageBanners' => 'PageBanner' 
	);
	private static $many_many_extraFields = array (
			'PageBanners' => array (
					'Sort' => 'Int' 
			) 
	);
	private static $has_many = array (
			'Resources' => 'Resource' 
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
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
		$Resources = GridField::create ( 'Resources', 'Resources', $this->Resources (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Resources', $Resources );
		
		return $fields;
	}
	public function PageBanners() {
		return $this->getManyManyComponents ( 'PageBanners' )->sort ( 'Sort' );
	}
	public function LoadPageBanners() {
		// Debug::show($this->PageBannersSource);
		if ($this->PageBannersSource == "Hide") {
			return false;
		}
		// we need to work out what slide to load. Either from this, parent or
		// global
		if ($this->PageBannersSource == "Parent" && $this->ParentID == 0) {
			$this->PageBannersSource = "Global";
		}
		
		switch ($this->PageBannersSource) {
			case "Custom" :
				return $this->PageBanners ();
				break;
			case "Parent" :
				return $this->Parent ()->PageBanners ();
				break;
			case "Global" :
				$siteConfig = SiteConfig::current_site_config ();
				return $siteConfig->LoadSiteConfigPageBanners ();
				break;
			default :
				$siteConfig = SiteConfig::current_site_config ();
				return $siteConfig->LoadSiteConfigPageBanners ();
				break;
		}
	}
	public function useTitleBar(){
		if($this->ClassName=='HomePage' || $this->ClassName=='BuildingLandingPage' ){
			return false;
		}
		return true;
	}
}
class Page_Controller extends ContentController {
	public $ThemeDir = '';
	public function init() {
		parent::init ();
		
		$this->ThemeDir = 'themes/' . SSViewer::current_theme () . '/';
		if (isset ( $_GET ['suffix'] )) {
			Requirements::set_suffix_requirements ( false );
		}
		Requirements::combine_files ( 'page.css', array (
				$this->ThemeDir . 'css/foundation.min.css',
				$this->ThemeDir . 'css/hover-min.css',
				$this->ThemeDir . 'css/royalslider.css',
				$this->ThemeDir . 'css/jquery.sidr.light.css',
				$this->ThemeDir . 'css/style.css' 
		) );
		
		Requirements::combine_files ( 'page.js', array (
				$this->ThemeDir . 'javascript/emh5src.js',
				$this->ThemeDir . 'javascript/vendor/modernizr.js',
				
				$this->ThemeDir . 'javascript/vendor/jquery.js',
				$this->ThemeDir . 'javascript/vendor/jquery.easing.js',
				
				$this->ThemeDir . 'javascript/foundation.min.js',
				$this->ThemeDir . 'javascript/jquery.royalslider.min.js',
				$this->ThemeDir . 'javascript/jquery.sidr.min.js',
				$this->ThemeDir . 'javascript/script.js' 
		) );
	}
	
}
