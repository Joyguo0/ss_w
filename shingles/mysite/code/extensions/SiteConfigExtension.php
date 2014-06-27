<?php

class SiteConfigExtension extends DataExtension {

	private static $db = array(
		'FooterTitleOne' 	=> 'Text',
		'FooterTitleTwo' 	=> 'Text',
		'FooterTitleThree' 	=> 'Text',
		'FooterTitleFour' 	=> 'Text',
			
		'FooterTel' 		=> 'Text',
		'FooterLogoText' 	=> 'HTMLText',
			
		'FooterLinksOne' 	=> 'HTMLText',
		'FooterLinksTwo' 	=> 'HTMLText',
		'FooterLinksThree' 	=> 'HTMLText',
		'FooterLinksFour' 	=> 'HTMLText',
			
		'SiteDomain' 		=> 'Text',
		//'TitleOneLinkID'	=> 'Int',
    );
    private static $has_one = array(
		'HeaderLogo' 		=> 'Image',
    	'TitleOneLink' 		=> 'Link',
    	'TitleTwoLink' 		=> 'Link',
    	'TitleThreeLink' 	=> 'Link',
    	'TitleFourLink' 	=> 'Link',
    	'Photo' 			=> 'Image',
    	//only for back pack
    	'PrivacyLink' 	=> 'Link',
    	'ECommerceLink' => 'Link',
    	'TermsLink' 	=> 'Link'
    );
    private static $has_many = array(
		'SlideBarShows' => 'SlideBarShow'	
	);
    /*
    static $summary_fields = array(
    		'Image.CMSThumbnail'  	=> 'Image',
    		'Title1'     			=> 'Title1',
    		'Title2'   	 			=> 'Title2',
    		'Link.getLinkURL'     	=> 'URL'
    );
    */
	public function updateCMSFields(FieldList $fields) {
		$SubsiteID = Subsite::currentSubsiteID();
		
		/***************** Header ***************************************/
		$fields->addFieldToTab('Root', new TabSet('Header'));
		$fields->addFieldToTab("Root.Header.Logo", UploadField::create('HeaderLogo', 'Header Logo'));
		
		$fields->addFieldToTab('Root', new TabSet('Footer'));
		$fields->addFieldToTab("Root.Footer", new Tab('Logo', new UploadField('Photo', 'Footer Logo')));
		
		if($SubsiteID != 3){
// 			$fields->addFieldToTab("Root.Footer.RightBottomText", new TextField('FooterTel', 'Telephone number'));
		}
		$fields->addFieldToTab("Root.Footer.BottomText", new HtmlEditorField('FooterLogoText', 'Footer Text'));
		
		
		if($SubsiteID != 3){
			/***************** Footer ***************************************/
			$fields->addFieldToTab("Root.Footer.Links.ColumnOne", new TextField('FooterTitleOne', 'Title'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnOne", new LinkField('TitleOneLinkID','Link'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnOne", new HtmlEditorField('FooterLinksOne'));
			
			$fields->addFieldToTab("Root.Footer.Links.ColumnTwo", new TextField('FooterTitleTwo', 'Title'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnTwo", new LinkField('TitleTwoLinkID','Link'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnTwo", new HtmlEditorField('FooterLinksTwo'));
			
			$fields->addFieldToTab("Root.Footer.Links.ColumnThree", new TextField('FooterTitleThree', 'Title'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnThree", new LinkField('TitleThreeLinkID','Link'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnThree", new HtmlEditorField('FooterLinksThree'));
			
			$fields->addFieldToTab("Root.Footer.Links.ColumnFour", new TextField('FooterTitleFour', 'Title'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnFour", new LinkField('TitleFourLinkID','Link'));
			$fields->addFieldToTab("Root.Footer.Links.ColumnFour", new HtmlEditorField('FooterLinksFour'));
			/*************************************** Plans ****************************************/
			$SlideBarShowsConfig = GridFieldConfig_RelationEditor::create()
				->addComponent(new GridFieldSortableRows('Sort'));
			$SlideBarShowsSections = GridField::create( 'SlideBarShows','SlideBarShows', $this->owner->SlideBarShows(), $SlideBarShowsConfig );
			$fields->addFieldToTab('Root.SlideBarShows', $SlideBarShowsSections);	
		}
		
		$fields->addFieldToTab("Root.Footer.PolicyLinks", new LinkField('PrivacyLinkID',	'Privacy Policy Page Link'));
		$fields->addFieldToTab("Root.Footer.PolicyLinks", new LinkField('ECommerceLinkID',	'E-Commerce Policy Page Link'));
		$fields->addFieldToTab("Root.Footer.PolicyLinks", new LinkField('TermsLinkID',		'Terms & Conditions Page Link'));
		
		
		if($this->owner->SubsiteID == 0){
			$fields->addFieldToTab("Root.Main", TextField::create('SiteDomain'));
		}
		
	}
	
	
	public function SlideBarShows(){
		return $this->owner->getComponents('SlideBarShows')->sort('Sort');
	}

	
}
