<?php

class ConferenceSecondFormStep extends MultiFormStep {

   	public static $next_steps = 'ConferenceThirdFormStep';
	
//    	public function getValidator() {
//    		return new RequiredFields('sss');
//    	}
	
   	public function getFields() {

   		$ConfPageDO = $this->form->getController();
   		
   		//add logic for half day selection in individual day mode.
   		$AllowHalfDay = $ConfPageDO->AllowHalfDay;
   		
   		$Step1DO = $this->getPreviousStepFromDatabase();
   		$Step1Data = $Step1DO->loadData();
   		
   		$Step2Data = $this->loadData();
   		
// Debug::show($Step2Data);die;

   		$fields = new FieldList();

   		//Event Tickets
   		$fields->push(HeaderField::create('Select Event Tickets')->addExtraClass('event-form-heads'));
   		
   		//check what option user choose.
   		$TicketClassName = 'EventTicket';
   		if($Step1Data['Package'] == 'Individual'){
   			//get ticket price data.
   			$TicketsDL = $ConfPageDO->EventTicketSingles();
   			
   			$TicketClassName = 'EventTicketSingle';
   			
   			
   			if($AllowHalfDay){
   				//is it's allow half day. we need to use another logic 
   				//form won't show all the days. 
   				//'EventTicketSingle' dataobject will store each day info.
   				$fields->push(HiddenField::create('HFTickets'));
   				$fields->push(HiddenField::create('HFTicketsQTY'));
   				
   			}else{
   				//only allow select full day(s)
   				//it will show all the days.
   				//'EventTicketSingle' dataobject will store different price rate.
	   			
	   			//selected individual day
	   			$DatesArray = $ConfPageDO->IndividualDays();
	   			
	   			$fields->push(CheckboxSetField::create('SelectedDays', '', $DatesArray));
   			}
   		}else{
   			//get ticket price data.
   			$TicketsDL = $ConfPageDO->EventTickets();
   		}
   		
   		//create hidden field first
   		$fields->push(HiddenField::create('EventTicket'));
   		$fields->push(HiddenField::create('EventTicketSingle'));
   		$fields->push(HiddenField::create('SocialEventTicket'));
   		
   		foreach ($TicketsDL as $TicketDO){
   			$fields->push(HiddenField::create("{$TicketDO->ClassName}-{$TicketDO->ID}-QTY"));
   		}
   		
   		if($AllowHalfDay){
   			//half day ticket logic
   			$SelectedTicketID 	= false;
   			$TicketQty			= false;
   			
   			if( isset($Step2Data['HFTickets']) && is_array($Step2Data['HFTickets']) && count($Step2Data['HFTickets'])){
   				$SavedSelectedDays 		= $Step2Data['HFTickets'];		//ticketID is array key
   				$SavedSelectedDaysQTY 	= $Step2Data['HFTicketsQTY'];	
   				
   				$NewSETicketsDL = new ArrayList();
   				foreach ($TicketsDL as $TicketsDO){
   					if(key_exists($TicketsDO->ID, $SavedSelectedDays)){
   						if(isset($SavedSelectedDaysQTY[$TicketsDO->ID]['QTY']) && $SavedSelectedDaysQTY[$TicketsDO->ID]['QTY']){
   							$TicketsDO->ThisIsChecked	= true;	
   							$TicketsDO->ThisQTY			= $SavedSelectedDaysQTY[$TicketsDO->ID]['QTY'];
   						}
   					}   		

   					$NewSETicketsDL->push($TicketsDO);
   				}
   				
   				$TicketsDL = $NewSETicketsDL;
   			}
   			
   		}else{	
	   		//check entered input
	   		$SelectedTicketID 	= false;
	   		$TicketQty			= false;
	   		if(isset($Step2Data[$TicketClassName]) && $Step2Data[$TicketClassName]){
	   			$SelectedTicketID = $Step2Data[$TicketClassName];
	   			
	   			$TicketInputName = "{$TicketClassName}-{$SelectedTicketID}-QTY";	//QTY input name should be '$ClassName-$ID-QTY'
	   			
	   			if(isset($Step2Data[$TicketInputName]) && $Step2Data[$TicketInputName]){
	   				$TicketQty = $Step2Data[$TicketInputName];
	   			}else{
	   				$TicketQty = 1;
	   			}
	   		}
   		}
   		
   		
   		//generate template
   		$TicketTemplate = ($AllowHalfDay && $Step1Data['Package'] == 'Individual') ? 'ConfTicketTableHalfDay' : 'ConfTicketTable';
   		
   		$tableHTML = $TicketsDL->renderWith(
   						$TicketTemplate, 
   						array(
   								'Records' 			=> $TicketsDL, 
   								'SelectedTicketID' 	=> $SelectedTicketID,
   								'TicketQty' 		=> $TicketQty,
   		));
   		$fields->push(LiteralField::create('table1', $tableHTML));
   		
   		
   		//Social Event Tickets
   		$SETicketsDL = $ConfPageDO->SocialEventTickets();
   		
   		$fields->push(HeaderField::create('Add Social Event Tickets')->addExtraClass('event-form-heads'));
   		
   		//checking selected SE tickets.
   		$checkedSEtickets = array();
   		if(isset($Step2Data['SocialEventTicket']) && !empty($Step2Data['SocialEventTicket']) && is_array($Step2Data['SocialEventTicket'])){	//$Step2Data['SocialEventTicket'] is an array
   			$checkedSEtickets = $Step2Data['SocialEventTicket'];
   		}
   		
   		if($SETicketsDL && $SETicketsDL->Count()){
   			$NewSETicketsDL = new ArrayList();
   			
   			foreach ($SETicketsDL as $SETicketsDO){
   				$SETicketQTYname = "{$SETicketsDO->ClassName}-{$SETicketsDO->ID}-QTY";

   				//insert hidden field first
   				$fields->push(HiddenField::create($SETicketQTYname));
   				
   				if(!empty($checkedSEtickets) && in_array($SETicketsDO->ID, $checkedSEtickets)){
   					$SETicketsDO->ThisIsChecked = true;
   					
   					//check its qty
   					if(isset($Step2Data[$SETicketQTYname]) && $Step2Data[$SETicketQTYname]){
   						$SETicketsDO->ThisQTY = $Step2Data[$SETicketQTYname];
   					}
   				}
   				
   				$NewSETicketsDL->push($SETicketsDO);
   			}
   		}
   		
   		//generate template
   		$table2HTML = $SETicketsDL->renderWith(
   						'ConfTicketTableSE', 
   						array(
   							'Records' 	=> $NewSETicketsDL
   		));
   		
   		$fields->push(LiteralField::create('table2', $table2HTML));
   		

   		
   		return $fields;
   }
   
	public function saveData($data) {
		$this->Data = serialize($data);
		$this->write();
	}
	
	
	
}