<?php

class SiteConfigExtension extends DataExtension {

	private static $db = array(
		'GACode'				=> 'Text',
		'RemarketingCode'		=> 'Text',
		'Tel'					=> 'Text',
		'Address'				=> 'Text',
		'WorkTime'				=> 'Text',
		'FooterBottomContent1'	=> 'HTMLText',
		'FooterQuickLinks1'		=> 'HTMLText',
		'FooterQuickLinks2'		=> 'HTMLText',
		'FooterBottomContent2'	=> 'HTMLText',
		'FooterBottomContent3'	=> 'HTMLText',
			
		'ThemeRed'				=> 'Boolean'
    );
	private static $has_one = array(
		'Logo'			=> 'Image',
		'NavigationLink'=> 'Link',
	);
	
    private static $has_many = array(
    );
    
    private static $many_many = array(
    	'Slides' 			=> 'Slide',
    	'HeaderLinks' 		=> 'HeaderLink',
    	'FooterLinks' 		=> 'FooterLink',
    	'PageBanners'		=> 'PageBanner'
    );
    
    private static $many_many_extraFields = array(
    	'Slides'			=> array('Sort' => 'Int'),
    	'HeaderLinks'		=> array('Sort' => 'Int'),
    	'FooterLinks'		=> array('Sort' => 'Int'),
    	'PageBanners'		=> array('Sort' => 'Int')
    );
    

	public function updateCMSFields(FieldList $fields) {
		
		/************************************GoogleTags**********************************************/
// 		$fields->addFieldToTab('Root.Main', ToggleCompositeField::create('GoogleTags', 'Google Tags', array(
// 				TextareaField::create('GACode', 'Google Analytics code (appears on every page)')->setRows(20),
// 				TextareaField::create('RemarketingCode', 'Remarketing code (appears on every page)')->setRows(20)
// 		))->setHeadingLevel(4));
		/*******************************************************************************************/
		
		$fields->addFieldToTab('Root.Main', CheckboxField::create('ThemeRed', 'Red Color Theme'));
		
		/************************************Add Header Icons ********************************/
		$fields->addFieldToTab('Root.Header.Main', UploadField::create('Logo')->setFolderName('Uploads/Logo'));
		$fields->addFieldToTab('Root.Header.Main', TextField::create('Tel', 'Tel'));
		$fields->addFieldToTab('Root.Header.Main', TextField::create('Address', 'Address'));
		$fields->addFieldToTab('Root.Header.Main', TextField::create('WorkTime', 'Work Time'));
		$fields->addFieldToTab('Root.Header.Main', LinkField::create("NavigationLinkID","Navigation Link"));
		
		$HeaderLinksConfig = GridFieldConfig_RelationEditor::create()
		->addComponent(new GridFieldOrderableRows('Sort'))
		->addComponent(new GridFieldManyRelationHandler());
		$fields->addFieldToTab('Root.Header.SocialMediaLinks', GridField::create( 'HeaderLinks','Social Media Links', $this->owner->HeaderLinks()->sort(array('Sort' => 'ASC')), $HeaderLinksConfig ));
		
		
		/*******************************************************************************************/
		
		
		/************************************Footer*************************************************/
// 		$fields->addFieldToTab('Root.Footer.Main', HtmlEditorField::create('FooterBottomContent1', 'Bottom Content 1 (Copyright text)')
// 				->setRows(6)->addExtraClass('stacked'));
// 		$fields->addFieldToTab('Root.Footer.Main', HtmlEditorField::create('FooterQuickLinks1', 'Quick Links 1')
// 			->setRows(6)->addExtraClass('stacked'));
// 		$fields->addFieldToTab('Root.Footer.Main', HtmlEditorField::create('FooterQuickLinks2', 'Quick Links 2')
// 				->setRows(6)->addExtraClass('stacked'));
// 		$fields->addFieldToTab('Root.Footer.Main', HtmlEditorField::create('FooterBottomContent2', 'Bottom Content 2')
// 			->setRows(6)->addExtraClass('stacked'));
// 		$fields->addFieldToTab('Root.Footer.Main', HtmlEditorField::create('FooterBottomContent3', 'Bottom Content 3')
// 				->setRows(20)->addExtraClass('stacked'));
		
		$fields->addFieldToTab("Root.Footer.Links.ColumnOne", new HtmlEditorField('FooterBottomContent1','FooterLinksOne'));
		$fields->addFieldToTab("Root.Footer.Links.ColumnTwo", new HtmlEditorField('FooterQuickLinks1','FooterLinksTwo'));
		$fields->addFieldToTab("Root.Footer.Links.ColumnThree", new HtmlEditorField('FooterQuickLinks2','FooterLinksThree'));
		$fields->addFieldToTab("Root.Footer.Links.ColumnFour", new HtmlEditorField('FooterBottomContent2','FooterLinksFour'));
		$fields->addFieldToTab("Root.Footer.Links.ColumnFive", new HtmlEditorField('FooterBottomContent3','FooterLinksFive'));
		
		$FooterLinksConfig = GridFieldConfig_RelationEditor::create()
		->addComponent(new GridFieldOrderableRows('Sort'))
		->addComponent(new GridFieldManyRelationHandler());
		$fields->addFieldToTab('Root.Footer.SocialMediaLinks', GridField::create( 'FooterLinks','Social Media Links', $this->owner->FooterLinks()->sort(array('Sort' => 'ASC')), $FooterLinksConfig ));

		/*******************************************************************************************/
		
		
		/************************************Slides*************************************************/
		$slidesConfig = GridFieldConfig_RelationEditor::create()
		->addComponent(new GridFieldOrderableRows('Sort'))
		->addComponent(new GridFieldBulkUpload("", array("Title")))
		->addComponent(new GridFieldManyRelationHandler());
		$fields->addFieldToTab('Root.Defaults.Slideshow', GridField::create( 'Slides','Slides', $this->owner->Slides()->sort(array('Sort' => 'ASC')), $slidesConfig ));
		/*******************************************************************************************/
		
		/************************************Page Banners*******************************************/
		$pBannersConfig = GridFieldConfig_RelationEditor::create()
		->addComponent(new GridFieldOrderableRows('Sort'))
		->addComponent(new GridFieldBulkUpload("", array("Title")))
		->addComponent(new GridFieldManyRelationHandler());
		$fields->addFieldToTab('Root.Defaults.PageBanners', GridField::create( 'PageBanners','Page Banners', $this->owner->PageBanners()->sort(array('Sort' => 'ASC')), $pBannersConfig ));
		/*******************************************************************************************/
		
	}
	
	public function getCoordinateLat($address = '') {
		if(empty($address)){
			return false;
		}
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($address);
		return $Coordinate['lat'];
	}
	
	public function getCoordinateLng($address = '') {
		if(empty($address)){
			return false;
		}
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($address);
		return $Coordinate['lng'];
	}
	
	public function Slides() {
		return $this->owner->getManyManyComponents('Slides')->sort('Sort');
	}
	
	public function LoadSiteConfigSlides() {
		return $this->Slides();
	}
	
	public function PageBanners() {
		return $this->owner->getManyManyComponents('PageBanners')->sort('Sort');
	}
	
	public function LoadSiteConfigPageBanners() {
		return $this->PageBanners();
	}
	
	public function HeaderLinks() {
		return $this->owner->getManyManyComponents('HeaderLinks')->sort('Sort');
	}
	
	public function LoadSiteConfigHeaderLinks() {
		return $this->HeaderLinks();
	}
	
	public function FooterLinks() {
		return $this->owner->getManyManyComponents('FooterLinks')->sort('Sort');
	}
	
	public function LoadSiteConfigFooterLinks() {
		return $this->FooterLinks();
	}
	
	public function NiceEnumValues($enum){
		$types = $this->owner->dbObject($enum)->enumValues();
		if($types){
			foreach($types as $key=>$value){
				$types[$key] = FormField::name_to_label($value);
			}
		}
		return $types;
	}
	

	
}
