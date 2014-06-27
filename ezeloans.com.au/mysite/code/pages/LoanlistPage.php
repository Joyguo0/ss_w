<?php
class LoanlistPage extends Page {
	
	public static $icon = 'mysite/images/icons/supplierholder';
	
    private static $db = array(
    	'SubTitle' => 'Varchar(500)',
    	'UseCustomJumpToLinks' => 'Boolean',
    );
    
    private static $has_many = array (
    	'JumpTos' => 'JumpTo',
    );
    
    private static $allowed_children = array('LoanPage');
    
    public function getCMSFields() {
    
    	$fields = parent::getCMSFields();
    
    	$fields->addFieldToTab ( 'Root.Main', TextField::create('SubTitle'), 'Content');
    	
    	$fields->addFieldsToTab('Root.JumpTo', DropdownField::create('UseCustomJumpToLinks', 'Custom Jumpto links')->setSource(array(true  => 'Yes',false => 'No')));
    	
    	$JumpTo= CompositeField::create(GridField::create ( 'JumpTos', 'JumpTos', $this->JumpTos(), GridFieldConfig_RelationEditor::create ()))	
    				->displayIf("UseCustomJumpToLinks")
    				->isEqualTo('1')
    				->end();
    	
    	$fields->addFieldToTab ( 'Root.JumpTo', $JumpTo);
    	
    	return $fields;
    }
    
    
    public function LoadJumpToLinks(){
    	if($this->UseCustomJumpToLinks){
    		return $this->JumpTos();
    	}else{
    		return $this->Children();
    	}
    }
    
}
class LoanlistPage_Controller extends Page_Controller {
	
	
}