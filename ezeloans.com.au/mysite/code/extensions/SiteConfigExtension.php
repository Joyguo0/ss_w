<?php
class SiteConfigExtension extends DataExtension {
	
	private static $db = array (
		'FootContent1'=>'HTMLText',
		'FootContent2'=>'HTMLText',
		'FootContent3'=>'HTMLText',
		'Tel'=>'Varchar(45)'
	);
	
	private static $has_one = array (
		'Toplogo' => 'Image',
		'CentreImage' => 'Image',
		'BannerImage' => 'Image',
		'LearnMoreAboutUs' => 'Link',
		'ApplyForPreapproval' => 'Link',
	);
	
	private static $has_many = array (
		'SideBarLinks' => 'SideBarLink',
	);
	
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldsToTab ( "Root.Header", array (
				new UploadField ( 'Toplogo' ),
		) );
		
		
		$fields->addFieldsToTab ( "Root.Footer.Column1", array (
				HtmlEditorField::create('FootContent1', 'Column 1 Content'),
		));
		$fields->addFieldsToTab ( "Root.Footer.Column2", array (
				HtmlEditorField::create('FootContent2', 'Column 2 Content'),
		));
		$fields->addFieldsToTab ( "Root.Footer.Column3", array (
				HtmlEditorField::create('FootContent3', 'Column 3 Content'),
		));
		$SideBarLinks= GridField::create ( 'SideBarLinks', 'SideBarLinks', $this->owner->SideBarLinks(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.SideBarLinks', $SideBarLinks );
		
		$fields->addFieldToTab ( 'Root.Main',TextField::create('Tel'));
		$fields->addFieldToTab ( 'Root.Main',new UploadField ( 'CentreImage' ));
		$fields->addFieldToTab ( 'Root.Main',new UploadField ( 'BannerImage' ));
		$fields->addFieldToTab ( 'Root.Main',LinkField::create ( 'LearnMoreAboutUsID', 'Link of LearnMoreAboutUs' ));
		$fields->addFieldToTab ( 'Root.Main',LinkField::create ( 'ApplyForPreapprovalID', 'Link of ApplyForPreapproval' ));

	}
}
