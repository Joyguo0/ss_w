<?php
/**
 * @author Guy Watson <guy.watson@internetrix.com.au>
 * @package irxewayonepageajaxpayment
 */
class OneStepPaymentPage extends Page {
	
	private static $icon = 'irxewayonepageajaxpayment/images/icons/payment';
	private static $db = array(
// 		'HeaderText' 			=> 'Text',
		'TermsAndConditions' 	=> 'HTMLText',
		'SuccessMessage'		=> 'HTMLText'
	);
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
// 		$fields->addFieldToTab('Root.Main', TextField::create('HeaderText', 'Header Text'), 'Content');	
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('TermsAndConditions', 'Terms and Conditions')->setRows('5'), 'Content');
		
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('SuccessMessage', 'Success Message')->setRows('5'), 'Content');
		return $fields;
	}
}

class OneStepPaymentPage_Controller extends Page_Controller {
	
	protected $formAction;
	protected $accessCode;
	
	private static $contactFields = array('Title', 'FirstName', 'LastName', 'Email', 'Phone', 'Street', 'City', 'State', 'PostalCode');
	
	private static $allowed_actions = array(
		'DetailsForm',
		'continuetopayment',
		'result'
	);
	
	public function init()
	{
		parent::init();
		
		/****************************CSS*************************************/
		Requirements::css('irxewayonepageajaxpayment/css/payment.css');
		/********************************************************************/
		
		
		/****************************JS**************************************/
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/jquery.validate.js');
		Requirements::javascript('irxewayonepageajaxpayment/thirdparty/jquery-validate/additional-methods.js');
		Requirements::javascript('https://api.ewaypayments.com/JSONP/v3/js');
		Requirements::javascript('irxewayonepageajaxpayment/javascript/ewayonestep.js');
		/********************************************************************/
		
		$this->extend('IRXInit');
	}																 
	
	/******************************* Actions ********************************/
	/************************************************************************/
	public function index()
	{
// 		return $this->customise($data)->renderWith(array('PaymentPage', 'Page'));
		return $this;
	}
	
	/************************ Forms and Form Actions ************************/
	/************************************************************************/
    
	public function DetailsForm()
	{
		Session::set('LoadFromSession', false);
		
		$fields = new FieldList();
		$fields->push($amount = new TextField('Amount', 'Amount'));	
		$fields->push(new DropdownField('Title', 'Title:', array('Mr.'=>'Mr.', 'Ms.'=>'Ms.', 'Mrs.'=>'Mrs.', 'Miss'=>'Miss', 'Dr.'=>'Dr.', 'Sir.'=>'Sir.', 'Prof.'=>'Prof.')));
		$fields->push($name = new TextField('FirstName', 'First Name: *'));	
		$fields->push($surname = new TextField('LastName', 'Last Name: *'));	
		$fields->push($email = new EmailField('Email', 'Email: *'));	
		$fields->push($phone = new TextField('Phone', 'Phone:'));
		$fields->push($street = new TextField('Street', 'Street:'));
		$fields->push($city = new TextField('City', 'City:'));
		$fields->push($state = new TextField('State', 'State:'));	
		$fields->push($postcode = new TextField('PostalCode', 'Postcode: *'));	
		
		if(eWayRapidPayment::$testValues){
			$amount->setValue(100);
			$name->setValue('Guy');
			$surname->setValue('Watson');
			$email->setValue('guy.watson@internetrix.com.au');
			$phone->setValue('0430496203');
			$street->setValue('4 Samuel Court');
			$city->setValue('Wollongong');
			$state->setValue('NSW');
			$postcode->setValue('2500');
		}

		$action 	= new FieldList(new FormAction('details', 'Continue to Payment'));
		$validator 	= new RequiredFields(array('FirstName', 'LastName', 'Email', 'Phone', 'Street', 'City', 'State', 'PostalCode'));
		$form 		= new Form($this, 'DetailsForm', $fields, $action, $validator);
		
		$form->setFormAction($this->Link('continuetopayment'));
		
		$this->extend('updateDetailsForm', $form);
		
		return $form;
	}
	
	public function continuetopayment($request){
		
		$post = $request->postVars();
		$load = Session::get('LoadFromSession');
		
		if(empty($post) && !$load){
			return $this->displayError();
		}
		
		if(!empty($post) && $load){
			$load = false;
		}
		$customer = new Customer();
		if($load){
			foreach(self::$contactFields as $f){
				$customer->$f = Session::get('Payment.' . $f);
			}
			$amount = Session::get('Payment.Amount');
		}else {
			foreach(self::$contactFields as $f){
				Session::set('Payment.' . $f, $post[$f]);
				$customer->$f = $post[$f];
			}
			if(!isset($post['Amount'])){
				return $this->displayError();
			}
			Session::set('Payment.Amount', $post['Amount']);
			$amount = $post['Amount'];
			
			$this->extend('handleExtraFields', $post);
		}
		$unique = false;
		do{
			$invoiceNumber = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
			if(!$same = eWayRapidPayment::get()->filter("InvoiceNumber", $invoiceNumber)->first()){
				$unique = true;
			}
		} while (!$unique);
		
		$unique = false;
		do{
			$invoiceReference = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
			if(!$same = eWayRapidPayment::get()->filter("InvoiceReference", $invoiceReference)->first()){
				$unique = true;
			}
		} while (!$unique);
		
		//somehow get the payment details
		$paymentDetails 					= new Payment();
		$paymentDetails->TotalAmount 		= $amount * 100;
		$paymentDetails->InvoiceNumber		= $invoiceNumber;
		$paymentDetails->InvoiceDescription = 'Payment from website';
		$paymentDetails->InvoiceReference 	= $invoiceReference;
		
		$result = singleton('eWayRapidPayment')->createAccessCode($this, $customer, $paymentDetails);
		
		if(!$result){
			return $this->displayError();
		}

		$resultArray = array(
			'success' => true, 
			'acarray' => $result
		);
		
		return Convert::array2json($resultArray);
	}
	
	public function PaymentForm()
	{
		$fields = new FieldList();
		$terms 	= $this->TermsAndConditions ? $this->TermsAndConditions : 'I agree to the <a target="_blank" href="/terms/" >Terms and Conditions</a>';
		
	
		$fields->push(singleton('eWayRapidPayment')->getPaymentFormFields($this->accessCode));
		$fields->push(new CheckboxField('Terms', $terms));
	
		$action = new FieldList(new FormAction('payment', 'Make Payment'));
		$form 	= new Form($this, 'PaymentForm', $fields, $action, null);
		
		$this->extend('updatePaymentForm', $form);
	
		return $form;
	}
	
	public function payment(){
		die("There has been an error. Please try again");
	}
	
	public function result($ssRequest)
	{
		$accessCode = $ssRequest->getVar('AccessCode');
		
		if(!$accessCode){
			//return error if there is no access code.
			return Convert::array2json(array('success' => false, 'message' => "No access code."));
		}
		 
		$payment = new eWayRapidPayment();
		$result = $payment->getPaymentResult($accessCode);
		
		if(!$result->isSuccess()){
			$error = $result->getValue() ? $result->getValue() : "Sorry your payment was unsuccessful";
			
			$resultArray = array(
				'success' => false, 
				'message' => $error
			);
		} else {
			
			$customer = new Customer();
			$customer->TokenCustomerID = $payment->TokenCustomerID;
			
			foreach(self::$contactFields as $f){
				$customer->$f = Session::get('Payment.' . $f);
			}
			
			$paymentDetails 					= new Payment();
			$paymentDetails->TotalAmount 		= 100;
			$paymentDetails->InvoiceNumber		= 'Test Number';
			$paymentDetails->InvoiceDescription = 'Test Invoice Description';
			$paymentDetails->InvoiceReference 	= '1234';
			
			//now lets get the masked card
			$tokenDetails = singleton('eWayRapidPayment')->createAccessCode($this, $customer, $paymentDetails);
			if(!$tokenDetails){
				$resultArray = array(
					'success' => false, 
					'message' => 'Could not get token details'
				);
			}else{
				
				$data = array(
					'Amount'		 	=> $payment->Amount->Amount,
					'InvoiceReference'	=> $payment->InvoiceReference,
					'Customer' 		 	=> $customer,
					'PaymentDetails' 	=> $payment,
					'TokenDetails'	 	=> $tokenDetails
				);
				
				
				$ssData = new ArrayData($data);
				
				$ssData = $ssData->renderWith(array('SuccessDetails'))->forTemplate();
				
				$resultArray = array(
					'success' => true,
					'message' => "Payment Successful",
					'details' => $ssData
				);
			}
			
		}
		
		return Convert::array2json($resultArray);
	}
	
	/**************************** Miscellaneous *****************************/
	/************************************************************************/
	
	public function displayError()
	{
		if(eWayRapidPayment::$testMode){
			SS_Backtrace::backtrace();
		}
		Session::clear_all();
		$this->httpError(404);
	}
}
    

