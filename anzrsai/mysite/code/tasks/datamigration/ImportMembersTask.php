<?php

class ImportMembersTask extends BuildTask {
	
	protected $title = 'Import Members Task';
	
	protected $description = '';
	
	public function run($request) {
		
		increase_time_limit_to();
		
		
		include dirname(__FILE__) . '/arraydata/contact.php';
		
		$count = 0;
		
		$AJRSgroupDO 	= Group::get()->byID(5);
		$MembergroupDO 	= Group::get()->byID(3);
		$SRAgroupDO 	= Group::get()->byID(6);
		$ConcilgroupDO 	= Group::get()->byID(7);
		
		$MailingListDO	= MailingList::get()->first();
		
		foreach ($contact as $contactArray){
			$memberDO = Member::get()->filter(array('Email' => $contactArray['email']))->first();
	
			if(!$memberDO){
				$memberDO				= new Member();
				$memberDO->Email		= str_ireplace(' ', '', $contactArray['email']);
				$memberDO->FirstName	= $contactArray['firstname'];
				$memberDO->Surname		= $contactArray['surname'];
				$memberDO->MobilePhone	= $contactArray['mobile'];
				$memberDO->Fax			= $contactArray['fax'];
				$memberDO->Password		= $contactArray['password'];
				
				
				
				$memberDO->write();
				
				if($contactArray['category'] == 'member'){
					$MembergroupDO->Members()->add($memberDO);
					
				}elseif($contactArray['category'] == 'council'){
					$ConcilgroupDO->Members()->add($memberDO);
					
				}elseif($contactArray['category'] == 'AJRS'){
					$AJRSgroupDO->Members()->add($memberDO);
					
					//create a membership record for it
					$NewMembershipDO = new Membership();
					$NewMembershipDO = $NewMembershipDO->CreateNewMembershipFromNow($memberDO, null, 'Member Import');
					
				}elseif($contactArray['category'] == 'SRA'){
					$SRAgroupDO->Members()->add($memberDO);
					
				}
				Debug::show($memberDO->Email);				
				if($contactArray['newsletter']){
					$recipient	= Recipient::get()->filter(array('Email' => $memberDO->Email))->first();
					
					if(!$recipient){
						$recipient 				= new Recipient();
						$recipient->Verified 	= true;
						$recipient->Email 		= $memberDO->Email;
						$recipient->FirstName 	= $memberDO->FirstName;
						$recipient->Surname 	= $memberDO->Surname;
						$recipient->write();
					}
					
					$recipient->MailingLists()->add($MailingListDO);
				}
				
				
				$count++;
			}
			
		}
		
		
		echo "<br><br> added $count stores <br><br>";
		
	}
	
}
