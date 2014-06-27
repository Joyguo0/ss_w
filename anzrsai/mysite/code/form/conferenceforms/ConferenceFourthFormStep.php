<?php

class ConferenceFouthFormStep extends MultiFormStep {

	public static $is_final_step = true;
	
	public function getFields() {
		$memberDO = Member::currentUser();
		$HasMembership = $memberDO ? $memberDO->hasValidMembership() : false;
		
		//get ticket order info first. create one if there is none.
		$sessionDO 	= $this->form->session;
		$OrderDO 	= $sessionDO->LoadOrder();
		if(!$OrderDO){
			$OrderDO = new TicketOrder();
			$OrderDO->MemberID = $memberDO ? $memberDO->ID : false;
			$OrderDO->MultiFormSessionID = $sessionDO->ID;
			$OrderDO->Type = 'Ticket';
			$OrderDO->Status = 'Cart';
			$OrderDO->write();
			
			$sessionDO->OrderID = $OrderDO->ID;
			$sessionDO->write();
		}
		
		$Step3DO = $this->getPreviousStepFromDatabase();
		$Step3Data = $Step3DO->loadData();
		
		$fields = new FieldList();
		
		
		
		/****** Payment *****/
		$errorMSG = $this->Session()->PaymentMessage();
		if($errorMSG){
			$errorMSG .= ' Please try again.';
		
			$fields->push(HeaderField::create($errorMSG)
					->setHeadingLevel(2)
					->addExtraClass('payment-error')
			);
		
			//update order status
		
		}
			
		$fields->push(singleton('VPCPayment')->getPaymentFormFields());
		
		/****** End - Payment *****/
		
		
		 
		$fields->push(HeaderField::create('Your Details')->addExtraClass('event-form-heads')->setHeadingLevel(3));
		
		
		//save user details into order
		$OrderDO->FirstName 	= $Step3Data['FirstName'];
		$OrderDO->Surname 		= $Step3Data['Surname'];
		$OrderDO->Email 		= $Step3Data['Email'];
		$OrderDO->MobilePhone 	= $Step3Data['MobilePhone'];
		$OrderDO->HomePhone 	= $Step3Data['HomePhone'];
		$OrderDO->MemberDetails = serialize($Step3Data);
		
		$OrderDO->HasMembership = $HasMembership;

		$UserDetailHTML = $OrderDO->LoadUserDetailsHTML();
		
		$fields->push(LiteralField::create('UserTable', $UserDetailHTML));
		
		
		//generate event ticket details table		
		$fields->push(LiteralField::create('table41', '<div class="large-12 columns">'));
		$fields->push(HeaderField::create('Event Ticket')->addExtraClass('event-form-heads')->setHeadingLevel(3));
		
		//checking conference type
		$Step1DO = $this->form->getSavedStepByClass('ConferenceFirstFormStep');
		$Step1Data = $Step1DO->loadData();
		
		$isFullConf 	= true;	//is all days conference
		$AllowHalfDay	= false;
		$TicketClassName = 'EventTicket';
		if($Step1Data['Package'] != 'Full'){
			$isFullConf = false;
			$TicketClassName = 'EventTicketSingle';
			
			$AllowHalfDay			= $this->form->getController()->AllowHalfDay;
		}
		
		$OrderDO->FullConf 		= $isFullConf;
		$OrderDO->AllowHalfDay	= $AllowHalfDay;
		
		//check selected ticket 
		$Step2DO = $this->form->getSavedStepByClass('ConferenceSecondFormStep');
		$Step2Data = $Step2DO->loadData();
		
		$AllTicketDOlist = new ArrayList();
		
		//load event ticket
		if($AllowHalfDay){
			//half day logic
			$OrderDO->FullConf			= $isFullConf;
			$OrderDO->TicketClassName	= 'EventTicketSingle';
			
			if( isset($Step2Data['HFTickets']) && is_array($Step2Data['HFTickets']) && count($Step2Data['HFTickets'])){
				$SavedSelectedDays 		= $Step2Data['HFTickets'];		//ticketID is array key
				$SavedSelectedDaysQTY 	= $Step2Data['HFTicketsQTY'];
					
				$TicketsDL = EventTicketSingle::get()->byIDs($SavedSelectedDays);//$TicketClassName must be EventTicketSingle

				$selectedQTYarray = array();
				
				if($TicketsDL && $TicketsDL->count()){
					foreach ($TicketsDL as $TicketsDO){
						if(key_exists($TicketsDO->ID, $SavedSelectedDays)){
							if(isset($SavedSelectedDaysQTY[$TicketsDO->ID]['QTY']) && $SavedSelectedDaysQTY[$TicketsDO->ID]['QTY']){
								$selectedQTYarray[$TicketsDO->ID] = $SavedSelectedDaysQTY[$TicketsDO->ID]['QTY'];
								$AllTicketDOlist->push($TicketsDO);
							}
						}
					}
				}
				
				$OrderDO->HFTicketsQTY = serialize($selectedQTYarray);
			}
		}else{
			//normal logic
			$ticketDo = $TicketClassName::get()->byID($Step2Data[$TicketClassName]);
			
			if($ticketDo){
				$ticketQTYname 	= "{$ticketDo->ClassName}-{$ticketDo->ID}-QTY";
				$ticketQTY 		= $Step2Data[$ticketQTYname];
						
				$OrderDO->EventDates 		= isset($Step2Data['SelectedDays']) ? $Step2Data['SelectedDays'] : false;
				$OrderDO->TicketClassName	= $TicketClassName;
				$OrderDO->EventTicketID 	= $ticketDo->ID;
				$OrderDO->FullConf			= $isFullConf;
				$OrderDO->EventTicketQTY 	= $ticketQTY;
					
				$AllTicketDOlist->push($ticketDo);
			}
		}
		

		//load social event list
		if(isset($Step2Data['SocialEventTicket']) && !empty($Step2Data['SocialEventTicket']) && is_array($Step2Data['SocialEventTicket'])){	//$Step2Data['SocialEventTicket'] is an array
			$SEIDqty = array();	//store social event ticket ID and their qty for order
			
			foreach ($Step2Data['SocialEventTicket'] as $SocialEventID){
				$ticketQTYname 				= "SocialEventTicket-{$SocialEventID}-QTY";
				$ticketQTY 					= $Step2Data[$ticketQTYname];
				$SEIDqty[$SocialEventID] 	= $ticketQTY;
			}
			
			$OrderDO->SocialEventTickets 	= serialize($SEIDqty);
		}
		
		$TicketDetailHTML = $OrderDO->LoadEventTicketDetailsHTML();
		
		$fields->push(LiteralField::create('TicketTable', $TicketDetailHTML));
		
		$totalPrice = $OrderDO->TotalPrice();
		
		$fields->push(LiteralField::create('table42', '</div"><p class="ptp">Total Amount: $'.$totalPrice.' AUD</p>'));
		
		
		
		$fields->push(HeaderField::create('You will be redirected to Bendigo Bank payment gateway.')->addExtraClass('event-form-heads'));
		
		
		//update ticket detail into order record.
		$OrderDO->write();
		
		return $fields;
   }

}