<?php
/**
 *
 */
class ProductCategory extends Page {
	
	private static $icon = '';
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(	
	);
	
	private static $allowed_children = array(
		'ProductPage'
	);
	
	
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
}

class ProductCategory_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			'AjaxGetMore'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public $page_length= 6;
	public $page_num= 1;
	public $page_sum= 100;
	
	public function getProduct(){
		$Products = new ArrayList();
		$number = 0;
	
		//$Category = ProductCategory::get()->filter('ParentID', $this->ID)->first();
		//Debug::show($Category);
		$ProductsList = ProductPage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC, "ID" ASC')->limit($this->page_length * $this->page_num) ;
		
		$row_count = ProductPage::get()->filter('ParentID', $this->ID)->count();
		$count = $row_count > $this->page_length ? $this->page_length : $row_count;
		
		foreach ($ProductsList as $page){
				
			$page->number = $number;	//Number (begin  0 )
			$page->count = $count;		//Total
			$page->IsRowBegin = $number % 3 == 0 ? true : false;
			$page->IsRowEnd = ($number % 3  == 2  || $count == ($number + 1) )? true : false;
			$Products->push($page);
			$number++;
		}
	
		return $Products;
		
	}
	
	public  function AjaxGetMore(SS_HTTPRequest $request){
		$page_length = $this->page_length;
	
		$start_num = $request->getVar('start');
	
		$Category = ProductCategory::get()->filter('ParentID', $this->ID)->first();
	
		$row_count = ProductPage::get()->filter('ParentID', $this->ID)->count();
	
		$sum = ($this->page_sum > $row_count) ? $row_count : $this->page_sum  ;
	
		$htmlContent = false;
	
		$ItemDLP= ProductPage::get()->filter('ParentID', $this->ID)->sort('"Sort" ASC, "ID" DESC')->limit($page_length, $start_num);
	
		$number = 0;
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$itemDO->number = $number;	//Number (begin  0 )
				$itemDO->count = $sum;		//Total
				$itemDO->IsRowBegin = $number % 3 == 0 ? true : false;
				$itemDO->IsRowEnd = ($number % 3  == 2  || $sum == ($number + 1) )? true : false;
				$htmlContent .= $itemDO->renderWith('ProductList');
			}
		}
	
		return Convert::array2json(array('html' =>$htmlContent, 'start' => $start_num ,"length" => $page_length ,"sum" => $sum ));
	}
}
