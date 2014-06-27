<?php

class CheckoutFormStep5 extends MultiFormStep {

	public static $is_final_step = true;

   	public function validateTicket($ID){
   	
   		return false;
   	}
   	
   	public function validateSocialTicket($ID){
   	
   		return false;
   	}
   	
   	public function getFields() {
   		
   		$ConferenceListPageID = Session::get('ConferenceListPageID');
   		
		return false;
   }
   
	public function saveData($data) {
		$this->Data = serialize($data);
		$this->write();
		Session::set('FirstData', $data);
		//unserialize
		//var_dump($data);
   		//Debug::show($data);
   		//die;
   	}
}
