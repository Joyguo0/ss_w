<?php

class BlogHolderControllerExtension extends DataExtension {

	private static $allowed_actions = array(
			'AjaxGetMore'
	);
	
	public $page_length= 2;
	public $page_num= 1;
	public $page_sum= 100;
	
	public  function AjaxGetMore(SS_HTTPRequest $request){

		$BlogHolderDO = $this->owner->data();
		//Page Length
		if($BlogHolderDO && $BlogHolderDO->AjaxNumber){
			$page_length = $BlogHolderDO->AjaxNumber;
		}else{
			$page_length = $this->page_length;
		}
		//Start Record Number
		$start_num = $request->getVar('start') ? $request->getVar('start') : 0;
		
		$htmlContent = false;

		$ItemDLP = $this->owner->Entries()->sort('Date DESC')->limit($page_length, $start_num);
		//Total Records
		$row_count = $this->owner->Entries()->count();

		//Total Records 
		$sum = ($this->page_sum > $row_count) ? $row_count : $this->page_sum  ;
		
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$htmlContent .= $itemDO->renderWith('BlogSummary');
			}
		}
	
		return Convert::array2json(array('html' =>$htmlContent, 'start' => $start_num ,"length" => $page_length ,"sum" => $sum ));
	}
	
	
	
	public function BlogEntry(){
		$BlogHolderDO = $this->owner->data();
		
		if($BlogHolderDO && $BlogHolderDO->AjaxNumber){
			$page_length = $BlogHolderDO->AjaxNumber;
		}else{
			$page_length = $this->page_length;
		}
		
		$BlogEntries = $this->owner->BlogEntries($page_length * $this->page_num);
		
		$list = new ArrayList();
		if($BlogEntries && $BlogEntries->Count()){
			foreach ($BlogEntries as $itemDO){
				
				$list->push($itemDO);
			}
		}
		
		return $list;
	}
	
	public function ShowMoreButton($Count = FALSE){
		if($Count === false){
			$Count = $row_count = $this->owner->Entries()->count();
		}
		
		$BlogHolderDO = $this->owner->data();
		if($BlogHolderDO && $BlogHolderDO->AjaxNumber){
			$page_length = $BlogHolderDO->AjaxNumber;
		}else{
			$page_length = $this->page_length;
		}
		
		if( $page_length < $Count ){
			return true;
		}
		return false;
	}
	
	
}
