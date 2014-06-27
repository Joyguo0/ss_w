<?php

class PaymentPage extends Page {

	public static $icon = 'mysite/images/icons/checkout-file.gif';
	
	private static $db = array(
		'WebSuccessText'		=> 'HTMLText',
		'AdminEmails'   	 	=> 'Text',
		'AdminFromEmail'   	 	=> 'Text',
		'AdminSubject'  	 	=> 'Text',
		'ClientSubject' 	 	=> 'Text',
		'ClientFromEmail' 	 	=> 'Text',
		'EmailMessage'			=> 'Text',
			
		'ProductName' 	=> 'Text',
		'BackpackPrice' => 'Decimal(19, 2)',
			
		'PickupAddress' => 'Text',
		'EmbedAddressMap' => 'Text'
	);

	private static $has_one = array(
		'TermsLink' => 'Link'	
	);

	private static $has_many = array(
	);
	
	public function canDelete($member = null){
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.FormSettings', new TextField('ProductName', 'Product Name'));
		$fields->addFieldToTab('Root.FormSettings', new NumericField('BackpackPrice', 'Price ( inc GST )'));
		$fields->addFieldToTab('Root.FormSettings', new TextField('PickupAddress', 'Pickup Address'));
		$fields->addFieldToTab('Root.FormSettings', new TextField('EmbedAddressMap', 'Embeded map link for pickup address'));
		$fields->addFieldToTab('Root.FormSettings', new LinkField('TermsLinkID', '"Terms and Conditions" Page'));
		$fields->addFieldToTab('Root.FormSettings', new HtmlEditorField('WebSuccessText', 'Success message on website', 5));
		
// 		$fields->addFieldToTab('Root.EmailSetting', new HeaderField("Admin email settings"));
// 		$fields->addFieldToTab("Root.EmailSetting", new TextField('AdminFromEmail', 'Admin Email From (e.g. no-reply@americanshingles.com.au)'));
		$fields->addFieldToTab("Root.EmailSetting", new TextField('AdminEmails', 'Admin Emails'));
// 		$fields->addFieldToTab("Root.EmailSetting", new TextField('AdminSubject', 'Admin Email Subject'));
		$fields->addFieldToTab('Root.EmailSetting', new HeaderField("Customer email settings"));
		$fields->addFieldToTab("Root.EmailSetting", new TextField('ClientFromEmail', 'Email From (e.g. no-reply@americanshingles.com.au)'));
		$fields->addFieldToTab("Root.EmailSetting", new TextField('ClientSubject', 'Email Subject'));
		$fields->addFieldToTab("Root.EmailSetting", new TextareaField('EmailMessage', 'Message in email'));
		

		return $fields;
	}
}

class PaymentPage_Controller extends Page_Controller {
	
	protected $form;
	
	private static $allowed_actions = array(
			'PaymentMultiForm',
			'finished',
			'result'
			//'success'
	);
	private static $contactFields = array('Title', 'FirstName', 'LastName', 'Email', 'Phone', 'Street', 'City', 'State', 'PostalCode');
	
	function PaymentMultiForm() {
		$this->form =  new PaymentMultiForm($this, 'PaymentMultiForm');
		
		if($this->form->NewPaymentFormAction){
			$this->form->setFormAction($this->form->NewPaymentFormAction);
		}
		
		return $this->form;
	}
	
	
	public function result($ssRequest){
		$result = singleton('OneStepPaymentPage_Controller')->result($ssRequest);
		$result = Convert::json2array($result);
		
		$message = '';

		if($result['success']){
			$accessCode 		= Convert::raw2sql($ssRequest->getVar('AccessCode'));
			$MultiFormSessionID = Convert::raw2sql($ssRequest->getVar('MultiFormSessionID'));
			
			$MultiFormSessionDO = DataObject::get_one('MultiFormSession', "\"Hash\" = '{$MultiFormSessionID}'");
			
			$userDetails = DataObject::get_one(
				'MultiFormStep', 
				sprintf("\"SessionID\" = '%s' AND \"ClassName\" = '%s'",
					$MultiFormSessionDO->ID,
					'PaymentSecondFormStep'
			));
			$userDetails = $userDetails->loadData();
			
			$orderDO 			= DataObject::get_one('Order', "\"MultiFormSessionID\" = {$MultiFormSessionDO->ID}");
			$PaymentDO 			= DataObject::get_one('eWayRapidPayment', "\"AccessCode\" = '{$accessCode}'");
			
			$PaymentDO = $this->getTokenDetails($PaymentDO, $orderDO);
	
			$orderDO->update($userDetails);
			
	   		$orderDO->Status	= 'Completed';
	   		$orderDO->RapidPaymentID = $PaymentDO->ID;
	   		$orderDO->SummaryHTML	 = $result['details'];
	   		$orderDO->write();
	   		
	   		$PaymentDO->OrderID = $orderDO->ID;
	   		$PaymentDO->MultiFormSessionID = $orderDO->ID;
	   		$PaymentDO->write();
	   		
	   		if(!$orderDO->EmailSent){
	   			$this->SentOrderEmail($orderDO, $MultiFormSessionDO, $PaymentDO);
	   		}
	   		
	   		$MultiFormSessionDO->OrderID	= $orderDO->ID;
	   		$MultiFormSessionDO->MultiFormSessionID = $MultiFormSessionDO->ID;
	   		$MultiFormSessionDO->MultiFormSessionHash = $MultiFormSessionDO->Hash;
	   		$MultiFormSessionDO->write();
	   		
	   		//send confirmation emails here.
			$redirectURL 	= Controller::join_links(Director::absoluteURL(Controller::curr()->Link()), "finished?MultiFormSessionID=" . $MultiFormSessionID);
		}else{
			$redirectURL = 'failed';
		}
		
		return Convert::array2json(array('result' => $redirectURL));
	}
	
	
	public function getTokenDetails($PaymentDO, $orderDO){
		if($PaymentDO && $PaymentDO->TokenCustomerID){
			//get token details
			$customer = new Customer();
			$customer->TokenCustomerID = $PaymentDO->TokenCustomerID;
			
			$paymentDetails 					= new Payment();
			$paymentDetails->TotalAmount 		= 100;
			$paymentDetails->InvoiceNumber		= 'Test Number';
			$paymentDetails->InvoiceDescription = 'Test Invoice Description';
			$paymentDetails->InvoiceReference 	= '1234';
			
			//now lets get the masked card
			$tokenDetails = singleton('eWayRapidPayment')->createAccessCode($this, $customer, $paymentDetails);
			
			if($tokenDetails){
				$PaymentDO->CardName	= $tokenDetails->CardName;
				$PaymentDO->CardNumber	= $tokenDetails->CardNumber;
				$PaymentDO->write();
			}
		}	
		
		return $PaymentDO;
	}
	
	
	public function SentOrderEmail($orderDO, $MultiFormSessionDO, $PaymentDO = false){
		$Title = $this->ClientSubject ? $this->ClientSubject : 'Payment Information';
		
		$summaryForm = $this->SummaryForm($MultiFormSessionDO, $orderDO, $PaymentDO);
		
		$EmailData = array(
			'Title' => $Title,
			'Message' => $this->EmailMessage,
			'Form' => $summaryForm
		);
		
		// Send Email to applicant
		$email = new Email();
		$email->setFrom($this->ClientFromEmail);
		$email->setTo($orderDO->Email);
		$email->setBcc($this->AdminEmails);
		$email->setSubject($this->ClientSubject);
		$email->populateTemplate($EmailData);
		$email->setTemplate('PaymentEmail');
		$email->send();
		
		$orderDO->EmailSent = true;
		$orderDO->write();
	}
	
	
	
	public function success($request) {
		
		$step = $this->PaymentMultiForm()->getCurrentStep();
		
		if($step->ClassName != 'PaymentSecondFormStep'){
			return $this->httpError(404);
		}
		
		return $this->customise(array(
				//'Title'   => $this->OnCompleteTitle,
				//'Form'    => $summary
				'Title'   => 'Payment Successful'
		));
		//Debug::show($step);
		//die;
		
	}
	public function init() {
		parent::init();
		
		Requirements::css('irxewayonepageajaxpayment/css/payment.css');
	
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/jquery.validate.js');
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/additional-methods.js');
		Requirements::javascript('https://api.ewaypayments.com/JSONP/v3/js');
// 		Requirements::javascript('irxewayonepageajaxpayment/javascript/ewayonestep.js');
		
		Requirements::javascript($this->ThemeDir . 'javascript/step2_payment.js');
		
		$this->_checkSSL();
	}
	
	function finished() {
		$SessionID = Convert::raw2sql($this->request->getVar('MultiFormSessionID'));
		$MultiFormSessionDO = DataObject::get_one('MultiFormSession', "\"Hash\" = '{$SessionID}'");

		$summaryForm = $this->SummaryForm($MultiFormSessionDO);
		
		return array(
				'PaymentMultiForm' => false,
				'Title' 	=> 'Payment Summary',
				'Content' 	=> $this->WebSuccessText,
				'Form' 		=> $summaryForm
		);
	}
	
	
	public function SummaryForm($MultiFormSessionDO, $orderDO = false, $PaymentDO = false){
		$orderDO 	= $orderDO 		? $orderDO 		: $MultiFormSessionDO->Order();
		$paymentDO 	= $PaymentDO 	? $PaymentDO 	: $orderDO->RapidPayment();

		$PaymentPageDO = DataObject::get_one('PaymentPage');
			
		$step2DO = PaymentSecondFormStep::get()->filter(array('SessionID' => $MultiFormSessionDO->ID))->First();
		$step2DataArray = $step2DO->loadData();
			
		$step1DO = $step2DO->getPreviousStepFromDatabase();
		$step1DataArray = $step1DO->loadData();
			
		$amount = $step1DataArray['Amount'] * $PaymentPageDO->BackpackPrice;
		$deliveryCost = 0.00;
		$totalPrice = $amount;
			
		if(isset($step2DataArray['Option']) && $step2DataArray['Option'] == 'Delivery'){
			$deliveryCost = PaymentSecondFormStep::CalculateDeliveryCost($step1DataArray['Amount']);
			
			if($deliveryCost > 0.00){
				$totalPrice = $amount + $deliveryCost;
			}
		}
		
		$summaryForm = new SimpleSummaryTableField(
				'Summary',
				array(
						'ProductUnitPrice' 	=> number_format($PaymentPageDO->BackpackPrice, 2),
						'ProductAmount' 	=> $step1DataArray['Amount'],
						'ProductPrice' 		=> number_format($amount, 2),
						'Delivery' 			=> number_format($deliveryCost, 2),
						'Total' 			=> number_format($totalPrice, 2)
				),
				$paymentDO,
				$orderDO
		);
		
		return $summaryForm;
	}
	
	
	function getSetpNum(){
		
		
		if( $step = $this->PaymentMultiForm()->getCurrentStep() )
			$step = $this->PaymentMultiForm()->getCurrentStep();
		else 
			return 1;

		if($step) {
			
			if($step->class == 'PaymentFirstFormStep') {
				return 1;
			}
	
			if($step->class == 'PaymentSecondFormStep') {
				return 2;
			}			
		}
	}

}