<?php

/**
 *
 */
class BuildingLandingPage extends UserDefinedForm {
	
	public static $icon = 'mysite/images/icons/homepage';
	
	private static $has_many = array(
			'Gallerys' => 'Gallery',
	);
	private static $db = array(
			'Call' => 'Varchar(255)',
			'ShortDescription' => 'Varchar(500)',
			'Estimated' => 'Date',
			'Email' => 'Varchar(255)',
			'Information' => 'Varchar(255)'
	);
	
	public function canCreate($member = null) {
		return false;
	}
	
	public function canDelete($member = null) {
		return false;
	}
	
	public function getCoordinateLat() {
		if($this->Lat){
			return $this->Lat;
		}
	
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($this->Address);
		return $Coordinate['lat'];
	}
	
	public function getCoordinateLng() {
		if($this->Lng){
			return $this->Lng;
		}
	
		$googcod = new GoogleGeocoding();
		$Coordinate = $googcod->address_to_point($this->Address);
		return $Coordinate['lng'];
	}
	public function getCMSFields ()
	{
		$fields = parent::getCMSFields();
		
		if($this->isPublished()){
			$fields->addFieldToTab('Root.Main', ExportField::create('ExportPage','ExportPage',$this),
					'Content');
		}
		
		$GallerysSections = GridField::create('Slideshow', 'Slideshow',
				$this->Gallerys(), GridFieldConfig_RelationEditor::create());
		$fields->removeByName('SideBar');
		$fields->removeByName('Resources');
		$fields->addFieldsToTab('Root.Main',
				array(
						TextField::create('Call', 'Call'),
						TextField::create('Email', 'Email'),
						DateField::create( "Estimated" )->setConfig ( 'showcalendar', true )->setConfig ( 'dateformat', 'dd/MM/YYYY' ),
						TextField::create('Information', 'Information'),
						TextareaField::create('ShortDescription', 'ShortDescription'),
				),'Content');
		
		return $fields;
	}
	public function dateFormatE(){
		return date('jS M,Y',strtotime($this->Estimated));
	}
}
class BuildingLandingPage_Controller extends UserDefinedForm_Controller {
	public $ThemeDir = '';
	public function init() {
		parent::init ();
		Requirements::css ( $this->ThemeDir . "css/magnificpopup.css" );
		Requirements::css ( $this->ThemeDir . "css/flexslider.css" );
		Requirements::javascript ( $this->ThemeDir . "javascript/jquery.flexslider-min.js" );
		Requirements::javascript ( $this->ThemeDir . "javascript/magnificpopup.js" );
	}
}
