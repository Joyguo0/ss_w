<?php
/**
 *
 */
class SubHomePage extends Page {
	public static $icon = 'mysite/images/icons/supplierpage';
	private static $has_many = array (
		'Obaseone' => 'Obase',
		'Subbanners' => 'Subbanner',
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields ();
		$Obaseone = GridField::create ( 'Obaseone', 'Obaseone', $this->Obaseone (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.First', $Obaseone );
		$Subbanners = GridField::create ( 'Subbanners', 'Subbanners', $this->Subbanners (), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.Subbanners', $Subbanners );
		return $fields;
	}
}

class SubHomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
