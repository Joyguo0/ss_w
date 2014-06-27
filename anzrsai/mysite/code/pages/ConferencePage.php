<?php

class ConferencePage extends Page {

	public static $icon = 'mysite/images/icons/conferencelistpage';

	private static $db = array(
		'StartDate' 	=> 'Date',
		'EndDate' 		=> 'Date',
		'AllowHalfDay' 	=> 'Boolean'	
	);
	
	private static $defaults = array(
		"AllowHalfDay" => true
	);
	
	private static $extensions = array(
		'Addressable',
		'Geocodable'	
	);

	private static $has_one = array(
   	);
	
	private static $has_many = array(
		"EventTickets" 			=> "EventTicket",
		"EventTicketSingles" 	=> "EventTicketSingle",
		'SocialEventTickets' 	=> 'SocialEventTicket',
		"EventDetails" 			=> "EventDetail",
		"Submissions" 			=> "TicketSubmission",
	);
	
	
	public function getSettingsFields() {
		
		$fields = parent::getSettingsFields();
		
		$fields->addFieldToTab('Root.Settings', CheckboxField::create('AllowHalfDay', 'Allow half day in reg form step 2 when user select "Individual days" ?'));
		
		return $fields;
	}
	
	
	public function getCMSFields(){

		$fields = parent::getCMSFields();
		
		$fields->removeByName('AllowHalfDay');
		
		$fields->addFieldToTab('Root.Main', DateField::create('StartDate', 'Start Date')->setConfig('showcalendar', true), 'Content');
		$fields->addFieldToTab('Root.Main', DateField::create('EndDate', 'End Date')->setConfig('showcalendar', true), 'Content');
		
		
		$fields->addFieldToTab('Root', new Tab('Details'), 'Address');
		$DetailsConfig = GridFieldConfig_RecordEditor::create();
		$DetailsConfig->addComponent(new GridFieldSortableRows('SortID'));
		$DetailsField = new GridField('Details', 'Details', $this->EventDetails(), $DetailsConfig);
		$fields->addFieldToTab("Root.Details", $DetailsField);
		
		
		
// 		$fields->addFieldToTab('Root', $EventTicketTab = new Tab('TicketInfomation'));
// 		$EventTicketTab->setTitle('Event Ticket');
		
		$fields->addFieldToTab("Root.TicketInfo.EventTicket", HeaderField::create('Individual Days Ticket Price'));
		$EventTicketConfig2 = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldSortableRows')) {
			$EventTicketConfig2->addComponent(new GridFieldSortableRows('SortID'));
		}
		$EventTicketField2 = new GridField('EventTicketSingle', 'Individual Days Event Ticket', $this->EventTicketSingles(), $EventTicketConfig2);
		$fields->addFieldToTab("Root.TicketInfo.EventTicket", $EventTicketField2);
		
		$fields->addFieldToTab("Root.TicketInfo.EventTicket", HeaderField::create('Full Conference Ticket Price'));
		$EventTicketConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldSortableRows')) {
			$EventTicketConfig->addComponent(new GridFieldSortableRows('SortID'));
		}
		$EventTicketField = new GridField('EventTicket', 'Full Conference Event Ticket', $this->EventTickets(), $EventTicketConfig);
		$fields->addFieldToTab("Root.TicketInfo.EventTicket", $EventTicketField);
		
		
		$SocialEventTicketConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldSortableRows')) {
			$SocialEventTicketConfig->addComponent(new GridFieldSortableRows('SortID'));
		}
		$SocialEventTicketField = new GridField('SocialEventTicket', 'Social Event Tickets', $this->SocialEventTickets(), $SocialEventTicketConfig);
		$fields->addFieldToTab("Root.TicketInfo.SocialEventTicket", $SocialEventTicketField);
		
		$SubmissionsConfig 	= GridFieldConfig_RecordEditor::create();
		$SubmissionsConfig->removeComponentsByType('GridFieldAddNewButton');
		$SubmissionsField 	= new GridField('Submissions', 'Submissions', $this->Submissions(), $SubmissionsConfig);
		$fields->addFieldToTab("Root.TicketInfo.Submissions", $SubmissionsField);
		
		$fields->removeByName("Resources");

		return $fields;
	}
	
	
	public function IndividualDays(){
   		$startDate 	= strtotime($this->StartDate);
   		$endDate 	= strtotime($this->EndDate);
		
   		if(!$startDate || !$endDate || ($startDate > $endDate)){
   			return false;
   		}
   		
   		$datediff = $endDate - $startDate;
   		$days = floor($datediff/(60*60*24));

   		if($days <= 1){
   			$key = date('Y-m-d', $startDate);
   			$val = date('j F Y', $startDate);
   			
   			return array($key => $val);
   		}else{
   			$dayArray = array();
   			
   			$date = $startDate;
   			
   			//add the first one
   			$key = date('Y-m-d', $date);
   			$val = date('j F Y', $date);
   			$dayArray[$key] = $val;
   			
   			for ($i = 0; $i < $days ; $i ++){
   				
   				$date = $date + (60*60*24);
   				
   				$key = date('Y-m-d', $date);
   				$val = date('j F Y', $date);
   				$dayArray[$key] = $val;
   			}
 			
   			return $dayArray;
   		}
	}
	
	
	public function IsAllowHalfDay(){
		return $this->AllowHalfDay;
	}
	
}

class ConferencePage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			//'Form',
			'ConferenceMultiForm',
			'finished',
			'reg'
	);
	
	public function init() {
		parent::init();
	
// 		Requirements::css('irxewayonepageajaxpayment/css/payment.css');
		//Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
// 		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/jquery.validate.js');
// 		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/additional-methods.js');
// 		Requirements::javascript('https://api.ewaypayments.com/JSONP/v3/js');
// 		Requirements::javascript('irxewayonepageajaxpayment/javascript/ewayonestep.js');ssss
	}
	
	public function RegTitle(){
		return 'Register Online -' . $this->Title;
	}
	
	public function reg($request){
		
		Requirements::javascript('mysite/javascript/event_rego_form.js');
		
		return $this->customise(array(
			'Title' 			  => $this->RegTitle(),
			'ConferenceMultiForm' => $this->ConferenceMultiForm(),
			'Content'			  => false,
			'ClickForReg'		  => true			
		));
		
	}
	
	public function ConferenceMultiForm() {
		
		if($this->PaymentRedirectionCheck($this->request) !== false){
			return 0;
		}
		
		$form = new ConferenceMultiForm($this, 'ConferenceMultiForm');
		$form->setDisplayLink($this->Link('reg'));
		
		//set value for step 3 (ConferenceThirdFormStep) if member logged in and no entered data
		$stepDO = $form->getCurrentStep();
		if($stepDO && $stepDO->ClassName == 'ConferenceThirdFormStep'){
			$CurrentData = $stepDO->loadData();
			
			$memberDO = Member::currentUser();
			if(empty($CurrentData) && $memberDO){
				$fields = $form->Fields();
				
				$memberDataArray = $memberDO->toMap();
			
				$fields->setValues($memberDataArray);
				
				$form->setFields($fields);
			}
			
		}
		
		return $form;
	}
	
	
	public function finished() {
		//default error message.
		$Title 				= 'Not Found';
		$OrderHTMLContent 	= '<p> Sorry, the requested session ID not found or the session is completed. Please try again or submit a new form. </p>';
		$TicketHTMLContent	= false;
		$ShowSummary		= false;
		$PaymentDO			= false;
		
		//try to get the session hash ID
		$sessionHashID 	= $this->request->getVar('MultiFormSessionID');
		$sessionDO		= MultiFormSession::get()->filter(array('Hash' => $sessionHashID))->first();
		
		if($sessionDO && $sessionDO->IsComplete && !$sessionDO->ShowedSummary){
			
			$sessionDO->ShowedSummary = true;
			$sessionDO->write();
			
			$Title 			= 'Thank you for your submission';
			
			//ok. we found it. mark this session as completed if the payment is done.
			$orderDO 	= $sessionDO->LoadOrder();
			$PaymentDO	= $sessionDO->VPCPayment();
			
			if($orderDO && $orderDO->Status == 'Completed'){
				$ShowSummary = true;
				
				$siteconfigDO = SiteConfig::get()->first();
				
				if(Director::isLive()){
					$sessionDO->IsComplete = true;
					$sessionDO->write();
				}
					
				//generate the confirmation details for the page and email
				$OrderHTMLContent = $orderDO->LoadUserDetailsHTML();
				
				$TicketHTMLContent = $orderDO->LoadEventTicketDetailsHTML();
				
				//TODO add CC details???
			}

		}
		
		return array(
			'Title' 				=> $Title,
			'Content' 				=> $OrderHTMLContent,
			'ClickForReg'			=> true,
			'ConferenceMultiForm'	=> false,
			'ShowSummary'			=> $ShowSummary,
			'TicketContent'			=> $TicketHTMLContent,
			'VPCPayment'				=> $PaymentDO
		);
	}

	
	
	
}