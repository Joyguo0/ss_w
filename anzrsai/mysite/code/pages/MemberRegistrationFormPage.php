<?php

class MemberRegistrationFormPage extends Page {
	
	public static $icon = 'mysite/images/icons/registrationformpage';

	private static $db = array(
		'RMMessage' => 'HTMLText'		
	);

	private static $has_one = array(
   		'MailingList' => 'MailingList'
   	);
	
	private static $has_many = array(
		"MembershipType" => "MembershipType",
	);
	
	public function canCreate($member = null) {
		return false;
	}
	
	public function canDelete($member = null) {
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}
	
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
	
		if(!MemberRegistrationFormPage::get()->Count()) {
			$page = new MemberRegistrationFormPage();
			$page->Title = 'Member Registration';
			$page->URLSegment = 'member-registration';
			$page->SendNotification = 1;
			$page->ParentID = 1;
			$page->ShowInMenus = false;
			$page->write();
			$page->publish('Stage', 'Live');
		}
		
		
		if(class_exists('MembershipType')){
			if(!MembershipType::get()->Count()){
				$MemberRegistrationFormPageDO = MemberRegistrationFormPage::get()->first();
				
				$MembershipTypeDO = new MembershipType();
				$MembershipTypeDO->Title = 'Standard annual ANZRSAI Subscription';
				$MembershipTypeDO->Price = 80.00;
				$MembershipTypeDO->MemberRegistrationFormPageID = $MemberRegistrationFormPageDO->ID;
				$MembershipTypeDO->write();
				
				$MembershipTypeDO = new MembershipType();
				$MembershipTypeDO->Title = 'Emeritus annual ANZRSAI Subscription';
				$MembershipTypeDO->Price = 30.00;
				$MembershipTypeDO->MemberRegistrationFormPageID = $MemberRegistrationFormPageDO->ID;
				$MembershipTypeDO->write();				
				
				$MembershipTypeDO = new MembershipType();
				$MembershipTypeDO->Title = 'Student annual ANZRSAI Subscription';
				$MembershipTypeDO->Price = 30.00;
				$MembershipTypeDO->MemberRegistrationFormPageID = $MemberRegistrationFormPageDO->ID;
				$MembershipTypeDO->write();			

				$MembershipTypeDO = new MembershipType();
				$MembershipTypeDO->Title = 'Website member';
				$MembershipTypeDO->Price = 0.00;
				$MembershipTypeDO->MemberRegistrationFormPageID = $MemberRegistrationFormPageDO->ID;
				$MembershipTypeDO->write();
			}
		}
		
	}

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root', $MembershipTypeTab = new Tab('MembershipType'));
		$MembershipTypeTab->setTitle('Membership Type');
		$MembershipTypeConfig = GridFieldConfig_RecordEditor::create();
		if(class_exists('GridFieldSortableRows')) {
			$MembershipTypeConfig->addComponent(new GridFieldSortableRows('SortID'));
		}
		$MembershipTypeField = new GridField('MembershipType', 'MembershipType', $this->MembershipType(), $MembershipTypeConfig);
		$fields->addFieldToTab("Root.MembershipType", $MembershipTypeField);
		
		
		$mailinglistMap = MailingList::get();
		if($mailinglistMap && $mailinglistMap->Count()){
			$mailinglistMap = $mailinglistMap->map()->toArray();
		}else{
			$mailinglistMap = array();
		}
		
		$fields->addFieldToTab("Root.Main", DropdownField::create('MailingListID', 'Newsletter Mailinglist', $mailinglistMap), 'Content');
		
		$fields->addFieldToTab("Root.Messages", HtmlEditorField::create('RMMessage', 'This message will be shown when user chooses "Returning Member".'));
		
		$fields->removeByName("Resources");
		$fields->removeByName("Slideshow");
		$fields->removeByName("SideBar");
		return $fields;
	}
}

class MemberRegistrationFormPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			'MemberRegistrationMultiForm',
			'getTypePrice',
			'finished',
			'webregfinished'
	);
	
	function MemberRegistrationMultiForm() {
		
		if($this->PaymentRedirectionCheck($this->request) !== false){
			return 0;
		}
		
		$form = new MemberRegistrationMultiForm($this, 'MemberRegistrationMultiForm');
		
		if($form->getSession()->IsComplete){
			return array(
				'Title' 						=> 'Session ID not found',
				'Content' 						=> '<p> Sorry, the requested session ID not found or the session is completed. Please try again or submit a new form. </p>',
				'MemberRegistrationMultiForm' 	=> false
			);
		}
		
		$stepDO = $form->getCurrentStep();
		if($stepDO && $stepDO->ClassName == 'MemberRegistrationFirstFormStep'){
			$RegoTypeField = $form->Fields()->dataFieldByName('RegType');
			
			$RegoTypeField->setValue('NewMember');
		}
		
		return $form;
	}
	
	function getTypePrice(SS_HTTPRequest $request){
		
		$typeid = $request->getVar('typeid');
		$ItemDLP = MembershipType::get()->filter('ID', $typeid);
		$htmlContent = false;
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$htmlContent = $itemDO->Price;
			}
		}
		
		return Convert::array2json(array('html' =>$htmlContent));
	}
	
	public function init() {
		parent::init();
		
		//user should not see this page if they logged in.
		$ActionName = $this->request->param('Action');
		if(Member::currentUserID() && !Permission::check('ADMIN') && ( $ActionName != 'webregfinished' && $ActionName != 'finished')){
			return $this->redirectBack();
		}
	
		Requirements::css('irxewayonepageajaxpayment/css/payment.css');
	
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/jquery.validate.js');
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/additional-methods.js');
		Requirements::javascript('https://api.ewaypayments.com/JSONP/v3/js');
		Requirements::javascript('irxewayonepageajaxpayment/javascript/ewayonestep.js');
	}
	
	
	/******************  Payment functions ****************/
	
	function finished() {

		$SessionHashID 	= $this->request->getVar('MultiFormSessionID');
		
		$SessionDO		= MultiFormSession::get()->filter(array('Hash' => $SessionHashID))->first();
		
		if(!($SessionDO && $SessionDO->ID)){
			//return 404 if there is session found
			return $this->httpError(404);
		}elseif ($SessionDO->IsComplete && $SessionDO->ShowedSummary){
			//dont show completed session
			return $this->redirect($this->Link('closedsession'));
		}
		
		$SessionDO->ShowedSummary = true;
		$SessionDO->write();
		
		$OrderDO 	= $SessionDO->Order();
		$PaymentDO 	= $SessionDO->VPCPayment();
		
		//return membership and payment details
		$memberDO = Member::currentUser();
		$MemberHTMLresults = $memberDO->renderWith(
			'MemberDetails',
			array(
				'Record' 	=> $memberDO
		));
		
		$membershipDO = $memberDO->GetLatestMembership();
		
		$MembershipSuccessSummary = $OrderDO->renderWith(
			'MembershipSuccessSummary',
			array(
				'Member'	=> $MemberHTMLresults,
				'Record' 	=> $membershipDO,
				'Payment'	=> $PaymentDO	
		));
		
		
		return array(
			'Title' 		=> 'Thank you for your submission',
			'Content' 		=> $MembershipSuccessSummary,
			'MemberRegistrationMultiForm' => false,	
		);
	}
	
	
	public function webregfinished(){
		return array(
			'Title' 						=> 'Thank you for your registration',
			'Content' 						=> '<p>Member registration is completed. <a href="'.$this->LoadMemberDashBoardPage()->Link().'">Member Dash Board</a></p>',
			'MemberRegistrationMultiForm' 	=> false
		);
	}
	
	function closedsession() {
		return array(
				'Title' 	=> 'Session Completed',
				'Content' 	=> '<p> The session ID you provided is completed. Please start a new one. </p> '
		);
	}
	
	
	/****************** END --- Payment functions ****************/

}