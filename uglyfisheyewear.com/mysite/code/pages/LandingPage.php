<?php
class LandingPage extends UserDefinedForm {
	public static $icon = 'mysite/images/icons/formpage';
	private static $db = array(
			'SubTitle' => 'Varchar(500)',
			'TopContent'		=> 'Text'
	);
	
	private static $has_one = array (
			'Link' => 'Link',
			'RightImage' => 'Image'
	);
	private static $has_many = array (
			'LandingBanner' => 'Obase',
	);
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		
		$fields->removeByName('SideBar');
		
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						TextField::create('SubTitle'),
						TextareaField::create('TopContent'),
						LinkField::create ( 'LinkID', 'Link' ),
						UploadField::create ( 'RightImage' )->setFolderName('Uploads/Banner') ,
				), 'Content');
		
		
		$LandingBanner = GridField::create ( 'LandingBanner', 'LandingBanner', $this->LandingBanner (), GridFieldConfig_RelationEditor::create () );
		
		$fields->insertAfter(Tab::create('LandingBanner'), 'Main');
		$fields->addFieldToTab ( 'Root.LandingBanner', $LandingBanner );
		
		return $fields;
	}
}
class LandingPage_Controller extends UserDefinedForm_Controller {
}
