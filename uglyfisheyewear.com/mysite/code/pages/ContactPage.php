<?php
/**
 *
 */
class ContactPage extends UserDefinedForm {
	public static $icon = 'mysite/images/icons/formpage';
	private static $db = array (
			'SubTitle' => 'Varchar(255)',
			'Phone' => 'Varchar(255)',
			'FAX' => 'Varchar(255)',
			'POST' => 'Varchar(255)' 
	)
	;
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$fields->addFieldsToTab ( 'Root.Main', array (
				TextField::create ( 'SubTitle' ),
				TextareaField::create ( 'Phone' ),
				TextareaField::create ( 'FAX' ),
				TextareaField::create ( 'POST' ) 
		)
		, 'Content' );
		
		return $fields;
	}
}
class ContactPage_Controller extends UserDefinedForm_Controller {
}
