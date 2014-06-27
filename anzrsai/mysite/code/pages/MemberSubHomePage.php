<?php
/**
 *
 */
class MemberSubHomePage extends Page {
	
	public static $icon = 'mysite/images/icons/memberareapage';
	
	private static $db = array(
		'SubTitle' 		=> 'Varchar(255)',
		'SubContent' 	=> 'HTMLText',
	);
	
	private static $defaults = array(
	);
	
	private static $many_many = array(
	);
	
	private static $many_many_extraFields = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.SubContent', TextField::create('SubTitle', 'Sub-Title'));
		$fields->addFieldToTab('Root.SubContent', HtmlEditorField::create('SubContent', 'Sub-Content')->setRows(10));
		
		return $fields;
	}
	
	
}

class MemberSubHomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();

	}
	
	
	
}
