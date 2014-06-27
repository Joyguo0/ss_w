<?php
/**
 *
 */
class ShingleHolderPage extends Page {
	
	private static $icon = 'mysite/images/icons/supplierholder';
	
	private static $allowed_children = array('ShingleTypePage');
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		return $fields;
	}
	
	
	
}

class ShingleHolderPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'ShinglesForm', 
		'AjaxGetMore'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public $page_length= 6;
	public $page_num= 1;
	public $page_sum= 100;
	
	public function ShowShingles() {
		/*
		if(Session::get('shingles_page_num')){
			$this->page_num = Session::get('shingles_page_num');
		}else {
			Session::set('shingles_page_num', 1);
		}
		*/
		//Debug::show($this->page_num);
		//$holder = ShingleTypePage::get()->First();
		return ShingleTypePage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC, "ID" ASC')->limit($this->page_length * $this->page_num) ;
	}
	
	
	public function ShinglesForm() {
	
		// Create fields
		// new HiddenField('pagenum','pagenum',1)
		$fields = new FieldList();
		// Create actions
		$actions = new FieldList(
				new FormAction('doShingles', 'Show More')
		);
		return new Form($this, 'ShinglesForm', $fields, $actions);
	}
	
	public function doShingles($data, $form) {
	
		Session::set('shingles_page_num', Session::get('shingles_page_num') + 1);
		return $this->redirectBack();
	}
	
	
	public function getFirstPageSum(){
		$row_count = ShingleTypePage::get()->filter('ParentID', $this->ID)->count();
		if($this->page_length > $row_count || $this->page_length == $row_count){
			return false;
		}
		return true;
	}
	
	
	public  function AjaxGetMore(SS_HTTPRequest $request){
		$page_length = $this->page_length;
		
		$start_num = $request->getVar('start');
		
		$row_count = ShingleTypePage::get()->filter('ParentID', $this->ID)->count();
		
		if($this->page_sum > $row_count){
			$sum = $row_count;
		}else {
			$sum = $this->page_sum ;
		}
		
		$htmlContent = false;
		
		$ItemDLP= ShingleTypePage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC, "ID" ASC')->limit($page_length, $start_num);
		
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$htmlContent .= $itemDO->renderWith('ShingleList');
			}
		}
		
		return Convert::array2json(array('html' =>$htmlContent, 'start' => $start_num ,"length" => $page_length ,"sum" => $sum ));
	}
	
	
	
}
