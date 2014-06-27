<?php
class AjaxFilterControllerExtension extends DataExtension {
	
	private static $allow_action = array(
		'ajaxfilter'
	);
	
	private static $MethodName = 'Products';
	
	public function ajaxfilter(){
		$MethodName = Config::inst()->get('AjaxFilterControllerExtension', 'MethodName');
		
		$request = $this->owner->request;
		
		$start 		= '';
		$length 	= '';
		$sort		= '';
		$filter		= '';
		
		$DataList = $this->owner->$MethodName();
		
	}
	
	
	
	
	
}