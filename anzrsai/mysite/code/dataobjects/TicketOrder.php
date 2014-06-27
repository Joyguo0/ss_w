<?php
class TicketOrder extends Order {
	
	private static $db = array(
		'FullConf' 				=> 'Boolean',
		'HasMembership' 		=> 'Boolean',
			
		'TicketClassName' 		=> 'Varchar(64)',
		'EventTicketID' 		=> 'Int',
		'EventTicketQTY' 		=> 'Int',
		'EventDates' 			=> 'Varchar',		//string
			
		'SocialEventTickets' 	=> 'Varchar',	//serielized array.
				
		'AllowHalfDay' 			=> 'Boolean',	//only for individual day mode.
		'HFTicketsQTY'			=> 'Varchar'	//only for individual day mode. serielized array.
												//single ticketID => qty
	);
	
	private static $has_one = array(
		'TicketSubmission' 		=> 'TicketSubmission'	
	);
	
	private static $summary_fields = array(
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
	
	public function ConfType(){
		return $this->FullConf ? 'Full Conference' : 'Individual Days';		
	}
	
	

	public function IsFullConf(){
		return $this->FullConf ? 'yes' : 'no';
	}
	
	
	public function TotalPrice($IsCent = false, $memberDO = false){
		$price = 0.00;
		
		if(is_object($memberDO)){
			$HasMembership = $memberDO ? $memberDO->hasValidMembership() : false;
		}else{
			$HasMembership = $this->HasMembership;
		}
		
		//load event tickets price
		$EventTicektClassName = $this->TicketClassName;
		if($this->AllowHalfDay){
			//half day mode
			$selectedQTYarray = unserialize($this->HFTicketsQTY);
				
			if(is_array($selectedQTYarray) && count($selectedQTYarray)){
				foreach ($selectedQTYarray as $TicketID => $thisQTY){
					$ticketDo = $EventTicektClassName::get()->byID($TicketID);
						
					if($ticketDo){
						$ticketPrice 	= $ticketDo->MemberPrice;//$HasMembership ? $ticketDo->MemberPrice : $ticketDo->NonMemberPrice;
						
						$price = $price + $ticketPrice * $thisQTY;
					}
				}
			}
		}else{
			if($EventTicektClassName && is_numeric($this->EventTicketQTY) && $this->EventTicketQTY){
					
				$ticketDo = $EventTicektClassName::get()->byID($this->EventTicketID);
					
				if($ticketDo){
					$ticketPrice 	= $ticketDo->MemberPrice;//$HasMembership ? $ticketDo->MemberPrice : $ticketDo->NonMemberPrice;
			
					$price = $price + $ticketPrice * $this->EventTicketQTY;
				}
					
			}
		}

		
		//load social event tickets price
		$SEEventsArray = unserialize($this->SocialEventTickets);
		if(!empty($SEEventsArray)){
		
			foreach ($SEEventsArray as $SocialEventID => $ticketQTY){
				$ticketDo = SocialEventTicket::get()->byID($SocialEventID);
		
				//load event ticket
				if($ticketDo){
					$ticketPrice 	= $ticketDo->MemberPrice;//$HasMembership ? $ticketDo->MemberPrice : $ticketDo->NonMemberPrice;
		
					$price = $price + $ticketPrice * $ticketQTY;
				}
			}
		}
		
		if($price > 0.00){
			$price = $IsCent ? $price * 100 : number_format($price,2);
		}
		
		return $price;
	}
	
	
	public function TotalAmount($IsCent = false){
		return $this->TotalPrice($IsCent);
	}
	
	
	public function LoadUserDetailsArray(){
		return $this->MemberDetails ? unserialize($this->MemberDetails) : false;	
	}
	
	
	public function LoadUserDetailsHTML(){
		$UserDetailsArray = $this->LoadUserDetailsArray();
		
		$HTMLresults = '';
		
		if(!empty($UserDetailsArray)){
			//convert country code.
			if(isset($UserDetailsArray['Country']) && $UserDetailsArray['Country']){
				$countryCode = $UserDetailsArray['Country'];
				$countryField = CountryDropdownField::create('Country', 'Country', null, $countryCode);
				$countrySourceArray = $countryField->getSource();
					
				if(isset($countrySourceArray[$countryCode]) && $countrySourceArray[$countryCode]){
					$UserDetailsArray['Country'] = $countrySourceArray[$countryCode];
				}
			}
			
			$datalist = new ArrayData($UserDetailsArray);
			$HTMLresults = Object::create('ViewableData')->renderWith(
				'ConfUserDetails',
				array(
						'Record' 	=> $datalist
			));
		}
		
		return $HTMLresults;
	}
	
	
	public function LoadEventTicketDetailsHTML($forEmail = false){
		$TicketClassName 	= $this->TicketClassName;
		$isFullConf 		= $this->FullConf;		//is all days conference
		$AllowHalfDay 		= $this->AllowHalfDay;	//only for individual days mode
		$HTMLresults = '';
		
		$AllTicketDOlist = new ArrayList();
		
		
		
		//load event ticket
		$ticketDo = $TicketClassName::get()->byID($this->EventTicketID);
		
		$memberDO = Member::currentUser();
		
		$HasMembership = $memberDO ? $memberDO->hasValidMembership() : false;
		
		if( ! $AllowHalfDay && $ticketDo){
			
			$ticketPrice 	= $ticketDo->MemberPrice;//$HasMembership ? $ticketDo->MemberPrice : $ticketDo->NonMemberPrice;
			$ticketQTY 		= $this->EventTicketQTY;
				
			$NameSuffix = '';
			
				
			if($isFullConf){
				$daycount = 1;
				$NameSuffix = ' - Full Conference';
			}else{
				$daycount = 0;
				$dayFormat = 'd/m/Y';
				$newDateArray = array();
				if($this->EventDates){
					$daysArray = explode(',', $this->EventDates);
					foreach ($daysArray as $eachDate){
						$daycount++;
		
						$newDateArray[] = date($dayFormat, strtotime($eachDate));
					}
				}
		
				$NameSuffix = " - {$daycount} Days (".implode(', ', $newDateArray).")";
			}
				
			$ticketTotalPrice = $ticketPrice * $ticketQTY * $daycount;
				
			$ticketDo->FinalTicketPrice = number_format($ticketPrice * $daycount, 2);
			$ticketDo->TotalTicketPrice = number_format($ticketTotalPrice, 2);
			$ticketDo->TicketQTY 		= $ticketQTY;
			$ticketDo->Name 			= $ticketDo->Name . "{$NameSuffix}";
			$ticketDo->DayCount 		= ($daycount > 1) ? $daycount : false;
			
			$AllTicketDOlist->push($ticketDo);
			
		}elseif( ! $isFullConf){
			// if this is half day mode and not full conference
			$selectedQTYarray = unserialize($this->HFTicketsQTY);
			
			if(is_array($selectedQTYarray) && count($selectedQTYarray)){
				foreach ($selectedQTYarray as $TicketID => $thisQTY){
					$ticketDo = $TicketClassName::get()->byID($TicketID);
					
					if($ticketDo){
						$ticketPrice 	= $ticketDo->MemberPrice;
						
						$ticketDo->FinalTicketPrice = number_format($ticketPrice, 2);
						$ticketDo->TotalTicketPrice = number_format($ticketPrice * $thisQTY, 2);
						$ticketDo->TicketQTY 		= $thisQTY;
						$ticketDo->Name 			= $ticketDo->Name;
						$ticketDo->DayCount 		= false;
						
						$AllTicketDOlist->push($ticketDo);
					}
				}
			}
		}
		
		
		//load social event list
		$SEEventsArray = unserialize($this->SocialEventTickets);
		if(!empty($SEEventsArray)){
				
			foreach ($SEEventsArray as $SocialEventID => $ticketQTY){
				$ticketDo = SocialEventTicket::get()->byID($SocialEventID);
		
				//load event ticket
				if($ticketDo){
					$ticketPrice 	= $ticketDo->MemberPrice;//$HasMembership ? $ticketDo->MemberPrice : $ticketDo->NonMemberPrice;
		
					$ticketTotalPrice = $ticketPrice * $ticketQTY;
		
					$ticketDo->FinalTicketPrice = number_format($ticketPrice, 2);
					$ticketDo->TotalTicketPrice = number_format($ticketTotalPrice, 2);
					$ticketDo->TicketQTY 		= $ticketQTY;
					
					$AllTicketDOlist->push($ticketDo);
				}
			}
		}

		if($forEmail === true){
			return $AllTicketDOlist;
		}
		
		//start to generate the HTML
		if($AllTicketDOlist && $AllTicketDOlist->count()){
			$HTMLresults = Object::create('ViewableData')->renderWith(
				'ConfTicketDetails',
				array(
					'Record' 		=> $AllTicketDOlist,
					'HasMembership' => $HasMembership,
					'IsFullConf' 	=> $isFullConf
			));
		}
		
		return $HTMLresults;
	}
	
	
	
	
	
	
	
	
	
	
	public function onOrderComplete($controller = null){
	
		$this->Status	= 'Completed';
		$this->write();
	
		$SessionDO = $this->MultiFormSession();
	
		if($SessionDO && $SessionDO->ID){
				
			if(!$SessionDO->IsComplete){
				$SessionDO->IsComplete = true;
				$SessionDO->write();
				
				$OrderDO = $SessionDO->Order();
				
				//create ticket submission object.
				$submissionDO 				= new TicketSubmission();
				$submissionDO->Title		= $controller->Title;
				$submissionDO->PageID		= $controller->ID;
				$submissionDO->MemberID		= $OrderDO->MemberID;
				$submissionDO->OrderID		= $OrderDO->ID;
				$submissionDO->VPCPaymentID	= $OrderDO->VPCPaymentID;
				$submissionDO->write();
				
				$this->TicketSubmissionID = $submissionDO->ID;
				$this->write();
	
				$this->SendEmail($SessionDO, $controller);		

				return $controller->Link('finished?MultiFormSessionID=' . $SessionDO->Hash);
			}else{
				//TODO send error log to developer.
			}
	
			return $controller->Link();
		}
	}
	
	
	public function onPaymentDenied($controller = null){
	
		$this->Status	= 'Cart';
		$this->write();
	
		$SessionDO = $this->MultiFormSession();
	
		if($SessionDO && $SessionDO->ID && ! $SessionDO->IsComplete){
			return $controller->Link('reg?MultiFormSessionID=' . $SessionDO->Hash);
		}
	
		return $controller->Link();
	}
	
	
	public function SendEmail($sessionDO, $controller){
	
		$PageDO  		= $controller;
		$orderDO 		= $sessionDO->LoadOrder();
		$PaymentDO 		= $this->VPCPayment();
		$siteconfigDO 	= SiteConfig::get()->first();
		
		$memberDO = new Member();
		$stepDO = ConferenceThirdFormStep::get()->filter(array('SessionID' => $sessionDO->ID))->first();
		$stepData = $stepDO->loadData();
		$memberDO->update($stepData);

		$TicketDL 		= $orderDO->LoadEventTicketDetailsHTML(true);
	
		$emailSubject = $siteconfigDO->EmailSubject ? $siteconfigDO->EmailSubject : 'Order Confirmation';
	
		$data = array(
				'Subject' 			=> $emailSubject,
				'ConferenceTitle'	=> $PageDO->Title,
				'Content' 			=> $siteconfigDO->EmailText,
				'Member' 			=> $memberDO,
				'Tickets' 			=> $TicketDL,
				'Payment' 			=> $PaymentDO,
		);
	
		$email = new Email();
	
		$email->setFrom($siteconfigDO->FromEmail ? $siteconfigDO->FromEmail : 'no-reply@anzrsai.org');
		$email->setTo($orderDO->Email);			// send an email to the user
	
		$developerEmails = 'jason.zhang@internetrix.com.au';
	
		$AdminEmails = $siteconfigDO->AdminEmails;
		$AdminEmails = $AdminEmails ? $AdminEmails . ',' . $developerEmails : $developerEmails;
	
		$email->setBcc($AdminEmails);	// send an email to the admins
		$email->setSubject($emailSubject . ' - ' . $PageDO->Title);
		$email->setTemplate('TicketOrderEmail');
		$email->populateTemplate($data);
	
		$email->send();
	
		$orderDO->EmailSent = true;
		$orderDO->write();
	
		return true;
	}
	
	
// 	public function onPaymentDenied($controller = null){
	
// 		$this->Status	= 'Cart';
// 		$this->write();
	
// 		$SessionDO = $this->MultiFormSession();
	
// 		if($SessionDO && $SessionDO->ID && !$SessionDO->IsComplete){
// 			return $controller->Link('?MultiFormSessionID=' . $SessionDO->Hash);
// 		}
	
// 		return $controller->Link();
// 	}
	
	
}