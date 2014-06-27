<?php
/**
 *
 */
class FaqPage extends Page {
	
	public static $icon = 'mysite/images/icons/checklistpage';
	
	private static $has_many = array (
			'Questions' => 'Question',
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$Questions = GridField::create ( 'Questions', 'Questions', $this->Questions (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Questions', $Questions );
		return $fields;
	}

}

class FaqPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init ();
	
	
	}
	
}
