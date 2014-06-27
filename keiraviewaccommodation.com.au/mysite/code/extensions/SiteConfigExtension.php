<?php
class SiteConfigExtension extends DataExtension {
	private static $db = array ('FootContent'=>'Text',)

	;
	private static $has_one = array (
			'Toplogo' => 'Image',
			'ToplogoLink' => 'Link',
			'Footlogo' => 'Image',
			'FootlogoLink' => 'Link',
			'FootRight' => 'Image',
			'FootRightLink' => 'Link',
			'FootContentLink' => 'Link',
	);
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldsToTab ( "Root.Header", array (
				new UploadField ( 'Toplogo' ),
				LinkField::create ( 'ToplogoLinkID', 'Link of Top logo' ) 
		) );
		
		$SlideshowsSections = GridField::create ( 'Detailtabs', 'Detailtabs', Detailtab::get (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldsToTab ( "Root.Footer", 
				array (
						new UploadField ( 'FootRight' ) ,
						LinkField::create ( 'FootRightLinkID', 'Link of Foot Right' )
				));
		$fields->addFieldsToTab ( "Root.Footer", array (
				
				new UploadField ( 'Footlogo' ) ,
				LinkField::create ( 'FootlogoLinkID', 'Link of Foot logo' ) ,
				
				TextField::create('FootContent'),
				LinkField::create ( 'FootContentLinkID', 'Link of Foot Content' ) ,
		));
		
		$fields->addFieldToTab ( 'Root.Footer', $SlideshowsSections );
	}
}
