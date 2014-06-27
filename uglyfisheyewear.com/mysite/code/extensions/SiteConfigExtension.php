<?php
class SiteConfigExtension extends DataExtension {
	private static $db = array (
		'FacebookLink' 			=> 'Varchar(255)',
		'TwitterLink' 			=> 'Varchar(255)',
		'GooglePlusLink' 		=> 'Varchar(255)',
		'YouTubeLink' 			=> 'Varchar(255)',
		'FootContent1' => 'HTMLText',
		'FootContent2' => 'HTMLText',
		'FootContent3' => 'HTMLText',
		'FootContent4' => 'HTMLText',
		'FootLink' => 'HTMLText',
		'Tel' => 'Varchar(100)',
		'Copyright' => 'Varchar(200)' ,
		
		//product
		'Delivery' => 'HTMLText',
		'Warranty' => 'HTMLText'
			
	);
	private static $has_one = array (
		'BannerNews' => 'Link',
		'Toplogo' => 'Image' 
	);
	private static $has_many = array (
		'Follows' 			=> 'Follow',		//social media icons
		'AmbassadorKeys'	=> 'AmbassadorKey',
		'DefaultImages' 	=> 'DefaultImage'	 
	);
	private static $many_many = array (
		'Resources' => 'Resource',
		'PageBanners' => 'PageBanner' 
	);
	private static $many_many_extraFields = array (
		'Resources' => array (
			'Sort' => 'Int' 
		),
		'PageBanners' => array (
			'Sort' => 'Int' 
		) 
	);
	public function updateCMSFields(FieldList $fields) {
		
		//***********  Products  ************//
		$fields->addFieldToTab ('Root.Product', HtmlEditorField::create('Delivery', '"DELIVERY & RETURNS" content for all product'));
		$fields->addFieldToTab ('Root.Product', HtmlEditorField::create('Warranty', '"WARRANTY" content for all product'));
		
		
		$fields->addFieldToTab ( 'Root.Main', LinkField::create ( 'BannerNewsID', 'Site Middle Link' ) );
		$Follows = GridField::create ( 'Follows', 'Follows', $this->owner->Follows (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Main', $Follows );
		
		$fields->addFieldsToTab ( "Root.Header", array (
				UploadField::create( 'Toplogo' )->setFolderName('Uploads/Logo') 
		) );
		$fields->addFieldToTab ( 'Root.Footer.General', TextareaField::create ( 'Tel' ) );
		$fields->addFieldToTab ( 'Root.Footer.General', TextareaField::create ( 'Copyright' ) );
		
		$fields->addFieldsToTab ( "Root.Footer.Column1", array (
				HtmlEditorField::create ( 'FootContent1', 'Column 1 Content' ) 
		) );
		$fields->addFieldsToTab ( "Root.Footer.Column2", array (
				HtmlEditorField::create ( 'FootContent2', 'Column 2 Content' ) 
		) );
		$fields->addFieldsToTab ( "Root.Footer.Column3", array (
				HtmlEditorField::create ( 'FootContent3', 'Column 3 Content' ) 
		) );
		$fields->addFieldsToTab ( "Root.Footer.Column4", array (
				HtmlEditorField::create ( 'FootContent4', 'Column 4 Content' ) 
		) );
		$fields->addFieldsToTab ( "Root.Footer.Bottom", array (
				HtmlEditorField::create ( 'FootLink', 'Bottom Links' )
		) );
		
		$AmbassadorKey= CompositeField::create(GridField::create ( 'AmbassadorKeys', 'AmbassadorKeys', $this->owner->AmbassadorKeys(), GridFieldConfig_RelationEditor::create ()));
		 
		$fields->addFieldToTab ( 'Root.Defaults.UglyPeoples', $AmbassadorKey);
		
		$DefaultsImages= CompositeField::create(GridField::create ( 'DefaultImages', 'DefaultImages', $this->owner->DefaultImages(), GridFieldConfig_RelationEditor::create ()));
			
		$fields->addFieldToTab ( 'Root.Defaults.Images', $DefaultsImages);
		
		
		/**
		 * **********************************Page Banners******************************************
		 */
		$pBannersConfig = GridFieldConfig_RelationEditor::create ()->addComponent ( new GridFieldOrderableRows ( 'Sort' ) )->addComponent ( new GridFieldManyRelationHandler () );
		$fields->addFieldToTab ( 'Root.Defaults.PageBanners', GridField::create ( 'PageBanners', 'Page Banners', $this->owner->PageBanners ()->sort ( array (
				'Sort' => 'ASC' 
		) ), $pBannersConfig ) );
		/**
		 * ****************************************************************************
		 */
		
		/************************************Newsletter Link********************************/
		$fields->addFieldToTab('Root.NewsletterConfiguration', new TextField('FacebookLink', 'Facebook'));
		$fields->addFieldToTab('Root.NewsletterConfiguration', new TextField('TwitterLink', 'Twitter'));
		$fields->addFieldToTab('Root.NewsletterConfiguration', new TextField('GooglePlusLink', 'Google Plus'));
		$fields->addFieldToTab('Root.NewsletterConfiguration', new TextField('YouTubeLink', 'YouTube'));
		
// 		$fields->addFieldToTab("Root",new Tab(_t("Newsletter.Configuration", "NewsletterConfiguration"),new TextField('FacebookLink', 'Facebook')));
// 		$fields->addFieldToTab("Root",new Tab(_t("Newsletter.Configuration", "NewsletterConfiguration"),new TextField('TwitterLink', 'Twitter')));
// 		$fields->addFieldToTab("Root",new Tab(_t("Newsletter.Configuration", "NewsletterConfiguration"),new TextField('GooglePlusLink', 'Google Plus')));
// 		$fields->addFieldToTab("Root",new Tab(_t("Newsletter.Configuration", "NewsletterConfiguration"),new TextField('YouTubeLink', 'YouTube')));
		/*******************************************************************************************/
		
	}
	public function Resources() {
		return $this->owner->getManyManyComponents ( 'Resources' )->sort ( 'Sort' );
	}
	public function LoadSiteConfigResources() {
		return $this->Resources ();
	}
	public function PageBanners() {
		return $this->owner->getManyManyComponents ( 'PageBanners' )->sort ( 'Sort' );
	}
	public function LoadSiteConfigPageBanners() {
		return $this->PageBanners ();
	}
}
