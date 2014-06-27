<?php

class RenewMembershipFirstFormStep extends MultiFormStep {

   	public static $next_steps = 'RenewMembershipSecondFormStep';
   	
   	public function getFields() {
   		
   		$fields = new FieldList();
   		
   		$member = Member::currentUser();
   		
   		$fields->push(TextField::create('FirstName', 'First Name : ', $member->FirstName)->setDisabled(true));
   		$fields->push(TextField::create('Surname', 'Surname : ', $member->Surname)->setDisabled(true));
   		$fields->push(TextField::create('Email',' Email : ', $member->Email )->setDisabled(true));
   		
   		$membership = Membership::get()->filter("MemberID",$member->ID)->sort('ID DESC')->first();

   		
   		$endtime = $membership ? strtotime($membership->End) : false;
   		$now = time();
   		
   		if($endtime < $now){
   			
   			$MembershipTypeList = MembershipType::get();
   			$MembershipTypeFirst = 0;
   			foreach ($MembershipTypeList as $MembershipType){
   				if($MembershipType->Price > 0.00){
	   				$Price = $MembershipTypeFirst ? $Price :  $MembershipType->Price ;
	   				$MembershipTypeArray[$MembershipType->ID] = $MembershipType->Title."<p>$".$MembershipType->Price." AUD</p>";
	   				$MembershipTypeFirst++;
   				}
   			}
   			
   			$fields->push(new OptionsetField('MembershipType' , 'Membership Type' , $MembershipTypeArray));
	   		$fields->push(new LiteralField('TotalAmount', '<div id="TotalAmount" class="field checkbox"><label>Total Amount Payable</label><label class="right" id="Price">$ '.$Price.' inc GST</label></div><br>'));
	   		
	   		$fields->push(new HiddenField('Amount','Amount',$Price));
	   		$fields->push(new HiddenField('DataLink','DataLink',$string = substr($this->Link(),0,strrpos($this->Link(),"/") + 1)));
   		}
   		
   		return $fields;
	
	
   }
   
	public function saveData($data) {
		
		$memberDO = Member::currentUser();
		
		$data['FirstName']	= $memberDO->FirstName;
		$data['Surname']	= $memberDO->Surname;
		$data['Email']		= $memberDO->Email;
		
		$this->Data = serialize($data);
		$this->write();
		
		
		if(isset($data['MembershipType']) && $data['MembershipType']){
			$MembershipTypeDO = MembershipType::get()->byID(Convert::raw2sql($data['MembershipType']));
			
			if($MembershipTypeDO && $MembershipTypeDO->Price > 0.00){
				$SessionDO 						= $this->Session();
				$orderDO 						= $SessionDO->Order();
				
				if(!$orderDO->ID){
					$orderDO = new Order();
					$orderDO->Type				= 'MembershipRenewal';
					$orderDO->MultiFormSessionID= $SessionDO->ID;
					$orderDO->MemberID			= $memberDO->ID;
					$orderDO->EmailSent			= false;
					$orderDO->write();
					
					$SessionDO->OrderID 		= $orderDO->ID;
					$SessionDO->write();
				}
				
				$orderDO->Status				= 'Cart';
				$orderDO->ItemClassName			= $MembershipTypeDO->ClassName;
				$orderDO->ItemID				= $MembershipTypeDO->ID;
				$orderDO->FirstName				= $memberDO->FirstName;
				$orderDO->Surname				= $memberDO->Surname;
				$orderDO->Email					= $memberDO->Email;
				$orderDO->Amount				= $MembershipTypeDO->Price;

				$orderDO->write();
			}
		}
		
   	}
}
