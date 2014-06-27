<?php
class Order extends DataObject {
	
	private static $db = array(
		'Type'					=> "enum('Ticket, MemberRegister, MembershipRenewal')",	
		'Status'				=> "enum('Cart, Processing, Completed, Denied')",
			
		'FirstName' 			=> 'Varchar',
		'Surname' 				=> 'Varchar',
		'Email' 				=> 'Varchar(256)', // See RFC 5321, Section 4.5.3.1.3.
		'MobilePhone'			=>	'Varchar(50)',
		'HomePhone'				=>	'Varchar(50)',
			
		"Amount" 				=> "Decimal(19, 2)",
			
		'MemberDetails'			=> 'Text',		
			
		'EmailSent'				=> 'Boolean',

		'ItemClassName'			=> 'Varchar',
		'ItemID'				=> 'Int'
	);
	
	private static $has_one = array(
		'Member' 			=> 'Member',
		'MultiFormSession' 	=> 'MultiFormSession'
	);
	
	private static $summary_fields = array(
		'Type'						=> 'Type',
		'Status'					=> 'Status',
		'Amount'					=> 'Amount',
		'FirstName' 				=> 'First Name',
		'Surname' 					=> 'Surname',
		'Email' 					=> 'Email',
		'VPCPayment.MerchTxnRef'	=> 'Payment Ref.',
		'VPCPayment.TransactionNo'	=> 'Transaction No.'
	);
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		$fields->removeByName('MemberDetails');
		$fields->removeByName('EmailSent');
		$fields->removeByName('ItemClassName');
		$fields->removeByName('ItemID');
		$fields->removeByName('MultiFormSessionID');
		$fields->removeByName('MemberID');
		$fields->removeByName('VPCPaymentID');
		
		return $fields;
	}
	
	
	public function TotalAmount($InCents = false){
		
		return $InCents ? $this->Amount * 100 : $this->Amount;
		
	}
	
	
	
	public function GenerateOrderInfo(){
		return $this->Type;
	}
	
	
	
	public function onOrderComplete($controller = null){
		
		$this->Status	= 'Completed';
		$this->write();
		
		$SessionDO = $this->MultiFormSession();
		
		if($SessionDO && $SessionDO->ID){
			
			if(!$SessionDO->IsComplete){
				$SessionDO->IsComplete = true;
				$SessionDO->write();
				
				if($this->Type == 'MembershipRenewal' || $this->Type == 'MemberRegister'){
					//create member DO first if it's member registration
					$memberDO = 0;
					if($this->Type == 'MemberRegister'){
						
						$stepDO = MemberRegistrationFirstFormStep::get()->filter(array('SessionID' => $SessionDO->ID))->first();
						
						$MemberDataArray = $stepDO->loadData();
						
						$memberDO = new Member();
						$memberDO->update($MemberDataArray);
						$memberDO->write();
						
						$memberDO->logIn();
					}
					
					$memberDO = Member::currentUser();
					
					$NewMembershipDO = new Membership();
					$NewMembershipDO = $NewMembershipDO->CreateNewMembershipFromNow($memberDO, $this->Amount);
					
					$membershipInfo = MembershipType::get()->byID($this->ItemID);
					
					$NewMembershipDO->VPCPaymentID 		= $this->VPCPaymentID;
					$NewMembershipDO->MembershipTypeID	= $this->ItemID;
					$NewMembershipDO->Type				= $membershipInfo->Title;
					$NewMembershipDO->write();
					
					//add user into groups 
					$AJRSgroupDO 	= Group::get()->byID(5);
					$MembergroupDO 	= Group::get()->byID(3);
					
					$AJRSgroupDO->Members()->add($memberDO);
					$MembergroupDO->Members()->add($memberDO);
					
					//send user email
					$siteconfigDO = SiteConfig::get()->first();
				
					//generate the confirmation details for the page and email
					$UserHTMLContent 	= '';
					$TicketHTMLContent 	= '';
				
					$emailSubject = $siteconfigDO->EmailSubject ? $siteconfigDO->EmailSubject : 'ANZRSAI Order Confirmation';
				
					$data = array(
							'Subject' 			=> $emailSubject,
							'ItemType'			=> 'Membership',
							'Member' 			=> $memberDO,
							'Membership' 		=> $NewMembershipDO,
							'Content' 			=> $siteconfigDO->EmailText,
							'Payment' 			=> $this->VPCPayment()
					);
				
					$email = new Email();
				
					$email->setFrom($siteconfigDO->FromEmail ? $siteconfigDO->FromEmail : 'no-reply@anzrsai.org');
					$email->setTo($this->Email);			// send an email to the user
				
					$developerEmails = 'jason.zhang@internetrix.com.au';
				
					$AdminEmails = $siteconfigDO->AdminEmails;
					$AdminEmails = $AdminEmails ? $AdminEmails . ',' . $developerEmails : $developerEmails;
				
					$email->setBcc($AdminEmails);	// send an email to the admins
					$email->setSubject($emailSubject);
					$email->setTemplate('OrderEmail');
					$email->populateTemplate($data);
				
					$email->send();
				
					$this->EmailSent = true;
					$this->write();
					
				}
				
				return $controller->Link('finished?MultiFormSessionID=' . $SessionDO->Hash);
			}
			
		}else{
			//TODO send error log to developer.
		}
		
		return $controller->Link();
	}
	
	
	public function onPaymentDenied($controller = null){
	
		$this->Status	= 'Cart';
		$this->write();
		
		$SessionDO = $this->MultiFormSession();
		
		if($SessionDO && $SessionDO->ID && !$SessionDO->IsComplete){
			return $controller->Link('?MultiFormSessionID=' . $SessionDO->Hash);
		}
		
		return $controller->Link(); 
	}
	
	
	
	
	
	
	
	
	
	
	
	
}




