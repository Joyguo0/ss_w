<?php

class RenewMembershipPage extends Page {

	public static $icon = 'mysite/images/icons/renewmembershippage';

	private static $db = array(
	);

	private static $has_one = array(
   		
   	);
	
	private static $has_many = array(
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
	
		if(!RenewMembershipPage::get()->Count()) {
			$page = new RenewMembershipPage();
			$page->Title = 'Renew Membership';
			$page->URLSegment = 'renew-membership';
			$page->SendNotification = 1;
			$page->ShowInMenus = false;
			$page->ParentID = 1;
			$page->CanViewType = 'LoggedInUsers';
			$page->write();
			$page->publish('Stage', 'Live');
		}
	}

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		return $fields;
	}
}

class RenewMembershipPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'validmsg',	
		'RenewMembershipMultiForm',
		'getTypePrice',
		'finished'
	);
	
	function RenewMembershipMultiForm() {

		if($this->PaymentRedirectionCheck($this->request) !== false){
			return 0;
		}
		
		return new RenewMembershipMultiForm($this, 'RenewMembershipMultiForm');
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
		
		$memberDO = Member::currentUser();
		$actionName = $this->request->param('Action');
		if($actionName != 'validmsg' && $actionName != 'finished'&& $memberDO && !Permission::check('ADMIN') && $memberDO->hasValidMembership()){
			return $this->redirect($this->Link('validmsg'));
		}
	
		Requirements::css('irxewayonepageajaxpayment/css/payment.css');
	
	
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/jquery.validate.js');
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/additional-methods.js');
		Requirements::javascript('https://api.ewaypayments.com/JSONP/v3/js');
		Requirements::javascript('irxewayonepageajaxpayment/javascript/ewayonestep.js');
	}
	
	
	public function validmsg($request){
		$memberDO = Member::currentUser();
		
		$membershipDO = $memberDO->GetLatestMembership();
		
		$expDate = $membershipDO->ExpiryDate;
		
		$content = 'Your membership is valid until ' . date('d/m/Y', strtotime($expDate));
		
		$url = $this->request->getHeader('Referer');
		if(!$url || !Director::is_site_url($url)) $url = Director::baseURL();
		
		$content .= '<br><br><a href="'.$url.'">Go back</a>';
		
		return $this->customise(array(
			'Content' 					=> $content,
			'RenewMembershipMultiForm'	=> false,
			'LoadResources'				=> false			
		));
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
// 		$PaymentDO 	= $SessionDO->VPCPayment();
		
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
				'MemberHTMl'	=> $MemberHTMLresults,
				'Record' 		=> $membershipDO,
// 				'Payment'		=> $PaymentDO
		));
		
		
		return array(
			'Content' 					=> $MembershipSuccessSummary,
			'RenewMembershipMultiForm' 	=> false,	
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