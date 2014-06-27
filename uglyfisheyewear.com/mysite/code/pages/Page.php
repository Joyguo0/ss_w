<?php
/**
 *
 */
class Page extends SiteTree {
	private static $db = array (
			'ResourceSource' => 'enum("Custom,Parent,Global,Hide","Hide")',
			'PageBannersSource' => 'enum("Custom,Parent,Global,Hide","Global")' 
	);
	private static $defaults = array (
			'ResourceSource' => "Hide",
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
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		/**
		 * *************************************Page Banners*******************************
		 */
		if($this->exists() && $this->ClassName != 'Product'){
			$fields->addFieldToTab ( 'Root.SideBar', HeaderField::create ( 'PageBannersHeading', 'Page Banners' ) );
			$fields->addFieldToTab ( 'Root.SideBar', OptionsetField::create ( 'PageBannersSource', 'Page Banners Source', $this->dbObject ( 'PageBannersSource' )->enumValues () ) );
			
			$pBannersConfig = GridFieldConfig_ManySortableRelationEditor::create ( 30 );
			
			if ($this->ID) {
				$pBannersConfig->addComponent ( new GridFieldManyRelationHandler (), 'GridFieldPaginator' );
			}
			$pBannersConfig = GridFieldConfig_RelationEditor::create ()
				->addComponent ( new GridFieldOrderableRows ( 'Sort' ) )
				->addComponent ( new GridFieldManyRelationHandler () );
			
			$fields->addFieldToTab ( 'Root.SideBar', CompositeField::create ( GridField::create ( 'PageBanners', 'Page Banners', $this->PageBanners (), $pBannersConfig ) )->displayIf ( "PageBannersSource" )->isEqualTo ( "Custom" )->end () );
		}
		
		
		/**
		 * ********************************************************************************
		 */
		
		return $fields;
	}
	public function Resources() {
		return $this->getManyManyComponents ( 'Resources' )->sort ( 'Sort' );
	}
	public function PageBanners() {
		return $this->getManyManyComponents ( 'PageBanners' )->sort ( 'Sort' );
	}
	public function LoadResources() {
		if ($this->ResourceSource == "Hide") {
			return false;
		}
		// we need to work out what slide to load. Either from this, parent or global
		if ($this->ResourceSource == "Parent" && $this->ParentID == 0) {
			$this->ResourceSource = "Global";
		}
		
		switch ($this->ResourceSource) {
			case "Custom" :
				return $this->Resources ();
				break;
			case "Parent" :
				return $this->Parent ()->LoadResources ();
				break;
			case "Global" :
				$siteConfig = SiteConfig::current_site_config ();
				return $siteConfig->LoadSiteConfigResources ();
				break;
			default :
				$siteConfig = SiteConfig::current_site_config ();
				return $siteConfig->LoadSiteConfigResources ();
				break;
		}
	}
	public function LoadPageBanners() {
		// Debug::show($this->PageBannersSource);
		if ($this->PageBannersSource == "Hide") {
			return false;
		}
		// we need to work out what slide to load. Either from this, parent or global
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

	
	public function CategoryNavColumnClass(){
		$SameParentCount = Page::get()->filter(array('ParentID' => $this->ParentID))->count();
		
		switch ($SameParentCount){
			case 6:
				return 'large-2';
			case 5:
				return '5';	//this is a special case. the class name will be determind in template file.
			case 4:
				return 'large-3';
			case 3:
				return 'large-4';
			case 2:
				return 'large-6';
			case 1:
				return 'large-12';
			default:
				return 'large-2';
		}
		
	}	
	
	
}


class Page_Controller extends ContentController {
	
	public $ThemeDir = '';
	
	private static $allowed_actions = array (
			'NewsletterRegisterForm',
			'Register',
			'RegisterForm' ,
	        'ProdcutSearchForm'
	);
	
	
	public function init() {
		parent::init ();
		
		$this->ThemeDir = 'themes/' . SSViewer::current_theme () . '/';
		
		// Requirements::css($this->ThemeDir . 'css/normalize.css');
		// Requirements::css($this->ThemeDir . 'css/foundation.css');
		
		Requirements::combine_files ( 'page.css', array (
				$this->ThemeDir . 'css/foundation.css',
				$this->ThemeDir . 'css/normalize.css',
				$this->ThemeDir . 'css/style.css',
				$this->ThemeDir . 'css/jquery.metisMenu.css',
				$this->ThemeDir . 'css/superfish.css' 
		) );
		
// 		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
 		Requirements::javascript($this->ThemeDir . 'javascript/jquery.min.js');
		
		Requirements::combine_files ( 'page.js', array (
				$this->ThemeDir . 'javascript/vendor/custom.modernizr.js',
				$this->ThemeDir . 'javascript/foundation.min.js',
				$this->ThemeDir . 'javascript/vendor/jquery.horizontalNav.js',
				$this->ThemeDir . 'javascript/vendor/jquery.easytabs.min.js',
				
				$this->ThemeDir . 'javascript/vendor/hoverIntent.js',
				$this->ThemeDir . 'javascript/vendor/superfish.js',
				
				$this->ThemeDir . 'javascript/bootstrap.min.js',
				$this->ThemeDir . 'javascript/vendor/jquery.metisMenu.js',
				$this->ThemeDir . 'javascript/mysite.js',
		) );
	}
	
	
	
	protected $extracrumbs = array();
	
	public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
		$page = $this;
		$pages = array();
		$addHomeLink = true;
		
		$AlwaysIn = array(
			'HomePage',
			'ProductListPage',
			'ProductCategory',
			'Product'			
		);
	
		while(
				$page
				&& (!$maxDepth || count($pages) < $maxDepth)
				&& (!$stopAtPageType || $page->ClassName != $stopAtPageType)
		) {
			if(in_array($page->ClassName, $AlwaysIn) || $showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
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
    function ProdcutSearchForm() {
		$fields = new FieldList ( TextField::create ( 'Search', '' ));
		$actions = new FieldList ( FormAction::create ( 'results', 'ProdcutSearchForm' ) );
		$form = new Form ( $this, 'ProdcutSearchForm', $fields, $actions,null );
		$form->disableSecurityToken ();
		return $form;
	}
	
	function results($data, $form) {
		
	  if(!isset($data['Search'])){
        return false;
	    }
	    $SearchText = Convert::raw2sql($data['Search']);
	    $results=Product::get()->where("\"Title\" LIKE '%{$SearchText}%'");
	    return $this->renderWith('ProdcutSearchFormResults',$this->customise(array('Products'=>$results))) ;
	}
	
	
	public function isMainSite() {
		return ! Subsite::currentSubsiteID ();
	}
	
	
	public function LatestNews($limit = 2){
		
		$newsDL = News::get()->sort('"Date" DESC')->limit($limit);
		
		return $newsDL;
	}
	
	
	//************ Category controller ********************//
	public function AllProductCategories($forMenu = true) {
		$ProductListPageDO = ProductListPage::get ()->first ();
	
		$CategoriesDOS = ProductCategory::get ()->filter ( array (
				'ParentID' => $ProductListPageDO->ID
		) );
	
		$categoryArray = array ();
	
		if ($forMenu === true && $CategoriesDOS && $CategoriesDOS->Count ()) {
			$newLink = new DataObject();
			$newLink->SppMenuTitle = 'New';
			$newLink->Children = false;
			$newLink->Link = $ProductListPageDO->Link( 'newproduct' ); // check
				
			$saleLink = new DataObject ();
			$saleLink->SppMenuTitle = 'Sale';
			$saleLink->Children = false;
			$saleLink->Link = $ProductListPageDO->Link( 'sale' );
				
			// add 'New' link as first one
			$categoryArray[] = $newLink;
				
			foreach ( $CategoriesDOS as $CategoriesDO ) {
				if (strcasecmp ( $CategoriesDO->Title, 'lifestyle' ) == 0) {
					$categoryArray[] = $CategoriesDO;
				}
	
				if (strcasecmp ( $CategoriesDO->Title, 'range' ) == 0) {
					$RangeChildrenDOS = $CategoriesDO->Children();
						
					if ($RangeChildrenDOS && $RangeChildrenDOS->Count()) {
						foreach ( $RangeChildrenDOS as $RageCateDO ) {
							$categoryArray[] = $RageCateDO;
						}
					}
				}
			}
				
			// add 'Sale' link as last one
			$categoryArray [] = $saleLink;
				
			$CategoriesDOS = new ArrayList ( $categoryArray );
		}
	
		return ! empty ( $categoryArray ) ? $CategoriesDOS : false;
	}
	
	
	public function LoadProductSidebarCategories($forMenu = true) {
		$ProductListPageDO = ProductListPage::get()->first();
	
		//get category first
		$CategoriesDOS = ProductCategory::get()->filter ( array (
				'ParentID' => $ProductListPageDO->ID
		));
	
		return $CategoriesDOS;
	}
	
	
	public function PriceRange() {
		return false;
	}
	
	
// 	public function LoadAttributes() {
// 		return Attribute_Default::get();
// 	}
	//************ Category controller ********************//
	
	
	function NewsletterRegisterForm() {
		$fields = new FieldList ( EmailField::create ( 'Email', '' )->setAttribute ( 'placeholder', 'Email Address' )->setAttribute ( 'id', 'newsletter' )->setAttribute ( 'style', 'none' ) );
		$actions = new FieldList ( FormAction::create ( 'doNewsletterRegister', 'SUBSCRIBE' )->addExtraClass ( 'button' )->setAttribute ( 'id', 'newsletter-submit' ) );
		$validator = new RequiredFields ( 'Email' );
		$form = new Form ( $this, 'NewsletterRegisterForm', $fields, $actions, $validator );
		$form->disableSecurityToken ();
		
		return $form;
	}
	
	
	function doNewsletterRegister($data, $form) {
		
		// check to see if member already exists
		$recipient = false;
		
		if (isset ( $data ['Email'] )) {
			$recipient = Recipient::get ()->filter ( 'Email', Convert::raw2sql ( $data ['Email'] ) )->first ();
		}
		
		if (! $recipient) {
			$recipient = new Recipient ();
			$form->saveInto ( $recipient );
			$recipient->write ();
		}
		
		$mailingList = MailingList::get ()->filter ( 'Title', 'Newsetter List' )->first ();
		
		if (! $mailingList) {
			$mailingList = new MailingList ();
			$mailingList->Title = 'Newsetter List';
			$mailingList->write ();
		}
		
		$recipient->MailingLists ()->add ( $mailingList );
		
		$url = $this->Link ( "?registered=1" );
		$this->redirect ( $url );
	}
	
	
	public function Registered() {
		return isset ( $_REQUEST ['registered'] ) && $_REQUEST ['registered'] == "1";
	}
	
	
	function RegisterForm() {
		// $data = Session::get("FormInfo.Form_RegistrationForm.data");
	
		// $fields = singleton('Member')->getForumFields($use_openid, true);
		$fields = new FieldList ( new TextField ( "FirstName", "First Name" ), new TextField ( "Surname", "Last Name" ), new EmailField ( "Email", "Your Email" ), new ConfirmedPasswordField ( "Password", "Password" ) );
		$validator = new RequiredFields ( 'Email' );
		$form = new Form ( $this, 'RegisterForm', $fields, new FieldList ( FormAction::create ( "doregister", "Register" ) ), $validator  );
	
		$member = new Member ();
	
		// we should also load the data stored in the session. if failed
		// if(is_array($data)) {
		// $form->loadDataFrom($data);
		// }
	
		// Optional spam protection
		// if(class_exists('SpamProtectorManager') && ForumHolder::$use_spamprotection_on_register) {
		// SpamProtectorManager::update_form($form);
		// }
		return $form;
	}
	function Register() {
		return array('RegisterForm'=>$this->RegisterForm());
	}
	/**
	 * Register a new member
	 *
	 * @param array $data
	 *        	User submitted data
	 * @param Form $form
	 *        	The used form
	 */
	function doregister($data, $form) {
		// $myGroup = DataObject::get_one('Group', "Code = 'member'");
		if ($member = DataObject::get_one ( "Member", "`Email` = '" . Convert::raw2sql ($data['Email']) . "'" )) {
			if ($member) {
				$form->addErrorMessage ( "Blurb", _t ( 'ForumMemberProfile.EMAILEXISTS', 'Sorry, that email address already exists. Please choose another.' ), "bad" );
				$this->redirectBack();
				return;
			}
		}
		$member = new Customer ();
		$form->saveInto ( $member );
		
		$member->write ();
		$member->login ();
		$member->addToGroupByCode('customers');
		$member->write ();
		
		$this->redirect ( "account/" );
	}
	
	
	public function LoadCartPage(){
		return CartPage::get()->first();
	}
	
	public function LoadCheckoutPage(){
		return CheckoutPage::get()->first();
	}
	
	public function LoadProductListingPage(){
		return ProductListPage::get()->first();
	}
	
	public function LoadStoreLocatorPage(){
		return StoreLocatorPage::get()->first();
	}
	
	public function MainSiteConfig(){
		return SiteConfig::get()->where('"SubsiteID" = 0')->first();
	}
	
}