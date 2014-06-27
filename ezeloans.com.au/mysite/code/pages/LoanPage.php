<?php
class LoanPage extends Page {
	
	public static $icon = 'mysite/images/icons/articleholder';
	
	private static $db = array(
		'Title' => 'Varchar(200)',
		'SubTitle' => 'Varchar(500)',
		'IconClass' 	=> 'Varchar(255)',
		'Content' => 'Text'
	);
	
	private static $has_many = array (
			'LoanTabs' => 'LoanTab',
	);
	
	public function getCMSFields() {
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						TextField::create('Title'),
						TextField::create('SubTitle'),
						LoanIconSelectorField::create('IconClass', 'Icon Class'),
						TextareaField::create('Content'),
				));
		
		$LoanTabs= GridField::create ( 'LoanTabs', 'LoanTabs', $this->LoanTabs(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.LoanTabs', $LoanTabs );
		return $fields;
	}
}
class LoanPage_Controller extends Page_Controller {
	public $ThemeDir = '';
	
	public function init() {
		parent::init ();
	
		$this->ThemeDir = 'themes/' . SSViewer::current_theme () . '/';
	
		Requirements::javascript( $this->ThemeDir . 'plugins/easytabs/jquery.easytabs.js' );
	}
}