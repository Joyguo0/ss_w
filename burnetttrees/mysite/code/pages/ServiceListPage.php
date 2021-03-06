<?php
/**
 *
 */
class ServiceListPage extends Page {
	
	//public static $icon = 'mysite/images/icons/product';
	private static $allowed_children = array(
        'ServiceCategory'
    );
	 
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

class ServiceListPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			'AjaxGetMore'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public $page_length= 6;
	public $page_num= 1;
	public $page_sum= 100;
	
	public function getService(){
		$Services = new ArrayList();
		$number = 0;
	
		$Category = ServiceCategory::get()->filter('ParentID', $this->ID)->first();
		//Debug::show($Category);
		$ServicesList = ServicePage::get()->filter('ParentID', $Category->ID)->sort('"Sort" ASC, "ID" ASC')->limit($this->page_length * $this->page_num) ;
		
		$row_count = ServicePage::get()->filter('ParentID', $Category->ID)->count();
		$count = $row_count > $this->page_length ? $this->page_length : $row_count;
		
		foreach ($ServicesList as $page){
				
			$page->number = $number;	//Number (begin  0 )
			$page->count = $count;		//Total
			$page->IsRowBegin = $number % 3 == 0 ? true : false;
			$page->IsRowEnd = ($number % 3  == 2  || $count == ($number + 1) )? true : false;
			$Services->push($page);
			$number++;
		}
	
		return $Services;
		
	}
	
	public  function AjaxGetMore(SS_HTTPRequest $request){
		$page_length = $this->page_length;
	
		$start_num = $request->getVar('start');
		
		$Category = ServiceCategory::get()->filter('ParentID', $this->ID)->first();
		
		$row_count = ServicePage::get()->filter('ParentID', $Category->ID)->count();
	
		$sum = ($this->page_sum > $row_count) ? $row_count : $this->page_sum  ;
	
		$htmlContent = false;
	
		$ItemDLP= ServicePage::get()->filter('ParentID', $Category->ID)->sort('"Sort" ASC, "ID" DESC')->limit($page_length, $start_num);
	
		$number = 0;
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$itemDO->number = $number;	//Number (begin  0 )
				$itemDO->count = $sum;		//Total
				$itemDO->IsRowBegin = $number % 3 == 0 ? true : false;
				$itemDO->IsRowEnd = ($number % 3  == 2  || $sum == ($number + 1) )? true : false;
				$htmlContent .= $itemDO->renderWith('ServiceList');
			}
		}
	
		return Convert::array2json(array('html' =>$htmlContent, 'start' => $start_num ,"length" => $page_length ,"sum" => $sum ));
	}
}
