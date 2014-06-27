<?php

class SiteConfigExtension extends DataExtension {

	private static $db = array(
		'LinkedInLink' 			=> 'Varchar(255)',
		'GACode'				=> 'Text',
		'HeaderLinks'			=> 'HTMLText',
		'FooterBottomContent1'	=> 'HTMLText',
		'FooterQuickLinks1'		=> 'HTMLText',
		'FooterQuickLinks2'		=> 'HTMLText',
		'FooterBottomContent2'	=> 'HTMLText',
		'FooterBottomContent3'	=> 'HTMLText',
			
		//for order
		'AdminEmails' 			=> 'Text',
		'FromEmail' 			=> 'Text',
		'EmailSubject' 			=> 'Text',
		'EmailText' 			=> 'HTMLText',
			
		//latest issue denied message
		'LIdeniedMSG' 			=> 'HTMLText'	
    );
    
	private static $has_one = array(
		'Logo'		=> 'Image'
	);
	
	private static $many_many = array(
		'Resources' 		=> 'Resource',
		'Slides' 			=> 'Slide',	
		'PageBanners'		=> 'PageBanner'
	);
	
	private static $many_many_extraFields = array(
		'Resources'			=> array('Sort' => 'Int'),
		'Slides'			=> array('Sort' => 'Int'),
		'PageBanners'		=> array('Sort' => 'Int')
	);

	public function updateCMSFields(FieldList $fields) {
		/************************************GoogleTags**********************************************/
		$fields->addFieldToTab('Root.Main', ToggleCompositeField::create('GoogleTags', 'Google Tags', array(
			TextareaField::create('GACode', 'Google Analytics code (appears on every page)')->setRows(20),
			TextareaField::create('RemarketingCode', 'Remarketing code (appears on every page)')->setRows(20)
		))->setHeadingLevel(4));
		/*******************************************************************************************/
		
		/************************************Add Header Icons ********************************/
		$fields->addFieldsToTab('Root.OrderSettings', array(
			TextField::create('AdminEmails', 'Admin Emails'),
			TextField::create('FromEmail', 'From Email ( e.g. no-reply@anzrsai.org )'),
			TextField::create('EmailSubject', 'Email Subject'),
			HtmlEditorField::create('EmailText', 'Email Content')->setRows(10)
		));
		/*******************************************************************************************/
		
		/************************************Add Header Icons ********************************/
		$fields->addFieldToTab('Root.Header', UploadField::create('Logo')
				->setFolderName('Uploads/Logo')
		);
		$fields->addFieldToTab('Root.Header', HtmlEditorField::create('HeaderLinks', 'Header Links')
				->setRows(6)->addExtraClass('stacked'));
		
		/*******************************************************************************************/
		
		/************************************Footer*************************************************/
		$fields->addFieldToTab('Root.Footer', HtmlEditorField::create('FooterBottomContent1', 'Bottom Content 1')
				->setRows(6)->addExtraClass('stacked'));
		$fields->addFieldToTab('Root.Footer', HtmlEditorField::create('FooterQuickLinks1', 'Quick Links 1')
			->setRows(6)->addExtraClass('stacked'));
		$fields->addFieldToTab('Root.Footer', HtmlEditorField::create('FooterQuickLinks2', 'Quick Links 2')
				->setRows(6)->addExtraClass('stacked'));
		$fields->addFieldToTab('Root.Footer', HtmlEditorField::create('FooterBottomContent2', 'Bottom Content 2')
			->setRows(6)->addExtraClass('stacked'));
		$fields->addFieldToTab('Root.Footer', HtmlEditorField::create('FooterBottomContent3', 'Bottom Content Copyright')
				->setRows(6)->addExtraClass('stacked'));
		/*******************************************************************************************/
		/************************************Add Social Media Icons ********************************/
		$fields->addFieldToTab('Root.SocialMedia', new TextField('LinkedInLink', 'Linked In'));
		
// 		$fields->addFieldToTab('Root', new TabSet('Defaults'));
		
		/************************************Slides*************************************************/
		$slidesConfig = GridFieldConfig_RelationEditor::create()
			->addComponent(new GridFieldOrderableRows('Sort'))
// 			->addComponent(new GridFieldBulkManager())
// 			->addComponent(new GridFieldBulkImageUpload("", array("Title")))
			->addComponent(new GridFieldManyRelationHandler());
		$fields->addFieldToTab('Root.Defaults.Slideshow', GridField::create( 'Slides','Slides', $this->owner->Slides()->sort(array('Sort' => 'ASC')), $slidesConfig ));
		/*******************************************************************************************/
		
		/************************************Page Banners*******************************************/
		$pBannersConfig = GridFieldConfig_RelationEditor::create()
			->addComponent(new GridFieldOrderableRows('Sort'))
// 			->addComponent(new GridFieldBulkManager())
// 			->addComponent(new GridFieldBulkImageUpload("", array("Title")))
			->addComponent(new GridFieldManyRelationHandler()); 
		$fields->addFieldToTab('Root.Defaults.PageBanners', GridField::create( 'PageBanners','Page Banners', $this->owner->PageBanners()->sort(array('Sort' => 'ASC')), $pBannersConfig ));
		/*******************************************************************************/
		
		
		$fields->addFieldToTab('Root.Access', new HtmlEditorField('LIdeniedMSG', 'Latest issue access denied message.'));
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
	
	public function Slides() {
		return $this->owner->getManyManyComponents('Slides')->sort('Sort');
	}
	
	public function Resources() {
		return $this->owner->getManyManyComponents('Resources')->sort('Sort');
	}
	
	public function LoadSiteConfigResources() {
		return $this->Resources();
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
	
	public function getExtraHeaderLinks(){
		$LinksContent = $this->owner->HeaderLinks;
		
		$newHTML_DOM = new DOMDocument();
		$newHTML_DOM->formatOutput = true;
		$newHTML_DOM->loadXML("<sstmproot></sstmproot>");
		$newHTML_DOM->saveHTML();
		
		$doc = new DOMDocument();
		$doc->loadHTML($LinksContent);
		
		$liTags = $doc->getElementsByTagName('li');
		
		foreach ($liTags as $liTag_domElement) {

			
			$liTag_domElement->setAttribute("class", "right-border");	//add stroke .
			
			$liTag_domElement = $newHTML_DOM->importNode($liTag_domElement, true);
			$newHTML_DOM->documentElement->appendChild($liTag_domElement);
		}
		
		$HTML_content = $newHTML_DOM->saveHTML();
		$HTML_content = str_ireplace('<sstmproot>', '', $HTML_content);
		$HTML_content = str_ireplace('</sstmproot>', '', $HTML_content);

		return $HTML_content;
	}
	
}
