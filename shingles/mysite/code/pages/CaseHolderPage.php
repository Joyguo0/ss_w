<?php
/**
 *
 */
class CaseHolderPage extends Page {
	
	private static $allowed_children = array('CasePage');
	
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

class CaseHolderPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'AjaxGetMore'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public $page_length= 6;
	public $page_num= 1;
	public $page_sum= 100;
	
	public function ShowCases() {
		return CasePage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC')->limit($this->page_length * $this->page_num) ;
	}
	
	public function TesstValue(){
		return 3;
	}
	
	
	public  function AjaxGetMore(SS_HTTPRequest $request){
		$page_length = $this->page_length;
		
		$start_num = $request->getVar('start');
		
		$row_count = CasePage::get()->filter('ParentID', $this->ID)->count();
		
		$sum = ($this->page_sum > $row_count) ? $row_count : $this->page_sum  ;
		
		$htmlContent = false;
		
		$ItemDLP= CasePage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC')->limit($page_length, $start_num);
		
		if($ItemDLP && $ItemDLP->Count()){
			$case_count = 0;
			foreach ($ItemDLP as $itemDO){
				$case_count++;
				if($case_count % 3 == 0){
					$itemDO->isThird = true;
				}
				$htmlContent .= $itemDO->renderWith('CaseList');
			}
		}
		
		return Convert::array2json(array('html' =>$htmlContent, 'start' => $start_num ,"length" => $page_length ,"sum" => $sum ));
	}
	
	
	
}
