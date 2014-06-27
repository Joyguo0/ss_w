<?php
class HomePage extends Page {
	
	public static $icon = 'mysite/images/icons/homepage';
	
	private static $db = array(
		'BannerTitle' => 'Varchar(200)',
		'BannerTitle' => 'Varchar(200)',
		'Content2' => 'HTMLText'
	);
	
	private static $has_one = array (
		'BannerImage' => 'Image',
	);
	
	private static $has_many = array (
		'Features' => 'Feature',
	);
		
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						HtmlEditorField::create('Content2'),
				));
		$fields->addFieldsToTab(
				'Root.Banner',
				array(
						new UploadField ( 'BannerImage' ),
						TextField::create('BannerTitle'),
						TextareaField::create('BannerContent'),
				));
		$Features= GridField::create ( 'Features', 'Features', $this->Features(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Features', $Features );
		return $fields;
	}
	
	
	public function LoadHomeBannerImage(){
		$homebanner = false;
		
		if($homebanner = $this->BannerImage()){
		}else{
			$siteconfig = SiteConfig::get()->first();
			$homebanner = $siteconfig->CentreImage();
		}
		
		if($homebanner){
			return $homebanner;
		}else{
			return false;
		}
	}
		
	
}
class HomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init ();
	}
	
}
