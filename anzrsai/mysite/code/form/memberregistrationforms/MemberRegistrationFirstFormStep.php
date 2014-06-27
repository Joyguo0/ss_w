<?php

class MemberRegistrationFirstFormStep extends MultiFormStep {

   	public static $next_steps = 'MemberRegistrationSecondFormStep';
   	
   	public function getFields() {
   		
   		$fields = new FieldList();
   		
   		$SavedData = $this->loadData();
   		
   		$MemberRegistrationFormPageDO = $this->form->getController();
   		$MembershipTypeList = $MemberRegistrationFormPageDO->MembershipType();
   		
   		$RenewMembershipPageDO = singleton('Page_Controller')->LoadRenewMembershipPage();
   		
   		$fields->push(
   			OptionsetField::create(   
   				'RegType', 
   				'', 
   				array(
   					'NewMember' 		=> 'New Member', 
   					'ReturningMember'	=> 'Returning Member'
   				), 
   				''
   			)->addExtraClass("regtypy")
   		);
   		
   		
   		
   		$fields->push(LiteralField::create('', '
   			<div class="ReturningMember">
				'.DBField::create_field('HTMLText', $MemberRegistrationFormPageDO->RMMessage)->forTemplate().'	
   			</div>	
   		'));
   		
   		$NewMemberField = CompositeField::create()->addExtraClass("NewMember");
   		
   		$NewMemberField->push(HeaderField::create('HeaderOne', 'Personal Details', 3)->addExtraClass("event-form-heads"));
   		$NewMemberField->push($Title = new DropdownField('MemberTitle', 'Title:', array('Mr.'=>'Mr.', 'Ms.'=>'Ms.', 'Mrs.'=>'Mrs.', 'Miss'=>'Miss', 'Dr.'=>'Dr.', 'Sir.'=>'Sir.', 'Prof.'=>'Prof.')));
   		$NewMemberField->push($FirstName = new TextField('FirstName', 'First Name *'));
   		$NewMemberField->push($LastName = new TextField('Surname', 'Surname *'));
   		$NewMemberField->push($Email = new UniqueEmailField('Email', 'Email *'));
   		$NewMemberField->push(ConfirmedPasswordField::create('Password', 'Password *'));
   		$NewMemberField->push($Organisation = new TextField('Organisation', 'Organisation'));
   		$NewMemberField->push($Position = new TextField('Position', 'Position'));
   		$NewMemberField->push($MobilePhone = new TextField('MobilePhone', 'Mobile Phone'));
   		$NewMemberField->push($HomePhone = new TextField('HomePhone', 'Home Phone'));
   		$NewMemberField->push($AddressLine1 = new TextField('AddressLine1', 'Address Line 1 *'));
   		$NewMemberField->push($AddressLine2 = new TextField('AddressLine2', 'Address Line 2'));
   		$NewMemberField->push($City = new TextField('City', 'City *'));
   		$NewMemberField->push($State = new TextField('State', 'State *'));
   		$NewMemberField->push($Postcode = new TextField('Postcode', 'Postcode *'));
   		$NewMemberField->push(CountryDropdownField::create('Country', 'Country', null, 'AU'));
   		$NewMemberField->push($WorkPhone = new TextField('WorkPhone', 'Work Phone'));
   		$NewMemberField->push(new CheckboxField('SignUpToNewsletter', 'Sign Up to Newsletter'));
   		
   		$NewMemberField->push(HeaderField::create('HeaderOne', 'Membership Type', 3)->addExtraClass("event-form-heads"));
   		
   		$selectedPrice 	= 0.00;
   		$selectedID 	= 0;
   		if(isset($SavedData['MembershipType']) && $SavedData['MembershipType']){
   			$selectedID = $SavedData['MembershipType'];
   		}
   		
   		$MembershipTypeArray 	= array();
   		$MembershipPriceArray 	= array();
   		if($MembershipTypeList && $MembershipTypeList->Count()){
   			foreach ($MembershipTypeList as $MembershipType){
   				$MembershipTypeArray[$MembershipType->ID] = $MembershipType->Title."<p>$".number_format($MembershipType->Price, 2)." AUD</p>";
   				$MembershipPriceArray[$MembershipType->ID] = $MembershipType->Price;
   				
   				if($selectedID == $MembershipType->ID){
   					$selectedPrice = $MembershipType->Price;
   				}
   			}
   		}
   		$NewMemberField->push(new OptionsetField('MembershipType' , 'Membership Type' , $MembershipTypeArray, $selectedID));
   		
		if(!$selectedID && !empty($MembershipTypeArray)){
			$selectedPrice = number_format(current($MembershipPriceArray), 2);
		}
   		
   		$NewMemberField->push(new LiteralField('TotalAmount', '<div id="TotalAmount" class="field checkbox"><label>Total Amount Payable</label><label class="right">$<span id="Price">'.$selectedPrice.'</span> AUD inc GST</label></div><br>'));
   		$NewMemberField->push(new HiddenField('DataLink','DataLink',$string = substr($this->Link(),0,strrpos($this->Link(),"/") + 1)));
   		
   		$fields->push($NewMemberField);
   		
   		Requirements::javascript('framework/thirdparty/jquery-livequery/jquery.livequery.min.js');
   		Requirements::javascript('mysite/javascript/MemberRegistration1.js');
   		
   		return $fields;
   }
   
	public function saveData($data) {
		$this->Data = serialize($data);
		$this->write();
		
		if(isset($data['MembershipType']) && $data['MembershipType']){
			$MembershipTypeDO = MembershipType::get()->byID(Convert::raw2sql($data['MembershipType']));
				
			if($MembershipTypeDO && $MembershipTypeDO->Price > 0.00){
				$SessionDO 						= $this->Session();
				$orderDO 						= $SessionDO->Order();
		
				if(!$orderDO->ID){
					$orderDO = new Order();
					$orderDO->Type				= 'MemberRegister';
					$orderDO->MultiFormSessionID= $SessionDO->ID;
					$orderDO->EmailSent			= false;
					$orderDO->write();
						
					$SessionDO->OrderID 		= $orderDO->ID;
					$SessionDO->write();
				}
		
				$orderDO->Status				= 'Cart';
				$orderDO->ItemClassName			= $MembershipTypeDO->ClassName;
				$orderDO->ItemID				= $MembershipTypeDO->ID;
				$orderDO->FirstName				= $data['FirstName'];
				$orderDO->Surname				= $data['Surname'];
				$orderDO->Email					= $data['Email'];
				$orderDO->Amount				= $MembershipTypeDO->Price;
		
				$orderDO->write();
			}
		}
		
		
		
		
   	}
   	
}
