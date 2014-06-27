<?php
/**
 *
 */
class Page extends SiteTree {
	private static $db = array ();
	private static $has_many = array (
			'Slideshows' => 'Slideshow',
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$SlideshowsSections = GridField::create ( 'Slideshows', 'Slideshows', $this->Slideshows (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Slideshows', $SlideshowsSections );
		return $fields;
	}
	public function getSettingsFields() {
		$fields = parent::getSettingsFields ();
		
		return $fields;
	}
	public function Detailtabs(){
		return Detailtab::get ();
	}
}
class Page_Controller extends ContentController {
	public $ThemeDir = '';
	public function init() {
		parent::init ();
		$this->ThemeDir = 'themes/' . SSViewer::current_theme () . '/';
		
		Requirements::css ( $this->ThemeDir . 'css/editor.css' );
	}
	public function ContactForm() {
		// Create fields
		$fields = new FieldList ( new TextField ( 'Name' ), new OptionsetField ( 'Browser', 'Your Favourite Browser', array (
				'Firefox' => 'Firefox',
				'Chrome' => 'Chrome',
				'Internet Explorer' => 'Internet Explorer',
				'Safari' => 'Safari',
				'Opera' => 'Opera',
				'Lynx' => 'Lynx'
		) ) );
	
		// Create actions
		$actions = new FieldList ( new FormAction ( 'doBrowserPoll', 'Submit' ) );
		$validator = new RequiredFields ( 'Name', 'Browser' );
		return new Form ( $this, 'ContactForm', $fields, $actions, $validator );
	}
}
