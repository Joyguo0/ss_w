<?php
/**
 *
 */

class UserForceLogin extends Page_Controller {
	
	protected $allowIP = array('127.0.0.1', '165.228.11.252');

	public function index($request){
		if(!in_array($request->getIP(), $this->allowIP)){
			if(!Permission::check('ADMIN')) $this->httpError(404);
		}
		
		$username = Convert::raw2sql($request->getVar('email'));
		
		if($username){
			$member = DataObject::get_one('Member', "\"Email\" = '$username'");
			
			if($member){
				Session::clear_all();
				
				$member->logIn();
				
				return $this->redirect('/');
			}
			
			return "$username does not exist.";
		}
		
		return 'Something is wrong.';
	}
}