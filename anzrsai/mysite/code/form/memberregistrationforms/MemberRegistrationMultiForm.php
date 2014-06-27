<?php

class MemberRegistrationMultiForm extends MultiForm {
	
	protected $MemberDataFields = array('Password', 'MemberTitle', 'Email', 'FirstName', 'Surname', 'State', 'City',  'Postcode', 'AddressLine1', 'AddressLine2', 'Country');

	public static $start_step = 'MemberRegistrationFirstFormStep';
	
	//overwritting for free member register.
	public function next($data, $form) {
		$formData = $form->getData();
		
		//if no need for payment, then redirect to finish page.
		$membershipTypeID = $formData['MembershipType'];
		$typeDO = MembershipType::get()->filter(array('ID' => $membershipTypeID))->first();

		if($typeDO && ($typeDO->Price <= 0.00)){
			$NewMemberDO = $this->CreateFreeMember($formData);
			
			$NewMemberDO->logIn();
			
			$MembergroupDO 	= Group::get()->byID(3);
			$MembergroupDO->Members()->add($NewMemberDO);
			
			$sessionDO = $this->session;
			$sessionDO->IsComplete = true;
			$sessionDO->write();
			
			$this->controller->redirect($this->controller->Link() . 'webregfinished');
		}else{
			
			//if it needs payment, do the normal next step
			parent::next($data, $form);
			
		}
	}
	
	
	public function CreateFreeMember($data){
		$NewMemberDO = new Member();
		$NewMemberDO->update($data);
		$NewMemberDO->write();
		
		//TODO add member into newsletter group if they tick the box
		 
		return $NewMemberDO;
	}
	
	
	public function finish($data, $form) {
		parent::finish($data, $form);
		
		$sessionDO = $this->session;
		
		$steps = DataObject::get(
				'MultiFormStep',
				"SessionID = {$sessionDO->ID}"
		);
		
		//$MembershipDetail = new Membership
		$controller = $this->getController();
      	$controller->redirect($controller->Link() . 'finished');
	}
}
