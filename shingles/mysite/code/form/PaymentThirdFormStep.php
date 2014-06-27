<?php

class PaymentThirdFormStep extends MultiFormStep {
	
	protected $title = 'Payment';

	public static $is_final_step = true;
	
	private static $contactFields = array('Title', 'FirstName', 'LastName', 'Email', 'Phone', 'Street', 'City', 'State', 'PostalCode');
	
   	public function getFields() {
   		
   		$PaymentPageDO = DataObject::get_one('PaymentPage');
   		
   		$step2DO = $this->getPreviousStepFromDatabase();
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
   		
   		$res = json_decode($this->continuetopayment($step1DataArray, $step2DataArray, $PaymentPageDO, $totalPrice));

//    		Debug::show($res);die;
   		
   		$fields = new FieldList();
   		
   		$fields->push(SimpleSummaryTableField::create('Summary', array(
   			'ProductUnitPrice' 	=> number_format($PaymentPageDO->BackpackPrice, 2),
   			'ProductAmount' 	=> $step1DataArray['Amount'],
   			'ProductPrice' 		=> number_format($amount, 2),
   			'Delivery' 			=> number_format($deliveryCost, 2),
   			'Total' 			=> number_format($totalPrice, 2)
   		)));

   		$fields->push(new HiddenField('AccessCode','AccessCode',$res->acarray->AccessCode));
   		$fields->push(new HiddenField('BackURL', 'BackURL', Controller::join_links($this->form->getDisplayLink(), "PaymentMultiForm?MultiFormSessionID=".$this->form->session->Hash)));
   		
   		$this->getForm()->NewPaymentFormAction = $res->acarray->FormActionURL;
   		
   		$fields->push(new HiddenField('FormActionURL','FormActionURL',$res->acarray->FormActionURL));
   		
   		$termsLink = '/e-commerce-policy/';
   		$termsLinkDO = $PaymentPageDO->TermsLink();
   		if($termsLinkDO){
   			$termsLink = $termsLinkDO->getLinkURL();
   		}
   		
   		$terms 	= 'I agree to the <a target="_blank" href="'.$termsLink.'" >Terms and Conditions</a>';
   		$fields->push(singleton('eWayRapidPayment')->getPaymentFormFields($res->acarray->AccessCode));
   		$fields->push(new CheckboxField('Terms', $terms));
   		
   		return $fields;
   	}
	
   	public function getValidator() {
   		$OBJ = new RequiredFields(array('Terms'));
   		return $OBJ;
   	}
   	
   	public function continuetopayment($step1DataArray, $step2DataArray, $PaymentPageDO, $amount){
   		
   		if(!(isset($step1DataArray['Amount']) && $step1DataArray['Amount'] > 0)){
   			return false;
   		}
   	
   		$customer = new Customer();
   		foreach(self::$contactFields as $f){
   			$customer->$f = $step2DataArray[$f];
   		}
   				
   		$this->extend('handleExtraFields', $step2DataArray);

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
   		$paymentDetails->TotalAmount 		= strval($amount * 100);
   		$paymentDetails->InvoiceNumber		= $invoiceNumber;
   		$paymentDetails->InvoiceDescription = 'Payment from website';
   		$paymentDetails->InvoiceReference 	= $invoiceReference;
   		//var_dump($paymentDetails->TotalAmount);
   		$result = singleton('eWayRapidPayment')->createAccessCode($PaymentPageDO, $customer, $paymentDetails, Controller::join_links(Director::absoluteURL(Controller::curr()->Link()), "result"));//
   	
   		if(!$result){
   			return $this->displayError();
   		}
   		
   		//create or get order info
   		$orderDO = $this->getForm()->GetOrCreateOrder();
   		if($orderDO && $orderDO->ID){
	   		$orderDO->AccessCode 	= $result->AccessCode;
	   		$orderDO->Status		= 'Payment';
	   		$orderDO->Option		= $step2DataArray['Option'];	
	   		$orderDO->ProductAmount = $step1DataArray['Amount'];
	   		$orderDO->write();
   		}
   	
   		$resultArray = array(
   				'success' => true,
   				'acarray' => $result
   		);
   		
   		Requirements::javascript('mysite/javascript/paymentpage-s3.js');
   	
   		return Convert::array2json($resultArray);
   	}
   	
   	public function displayError()
   	{
   		if(eWayRapidPayment::$testMode){
   			SS_Backtrace::backtrace();
   		}
   		Session::clear_all();
   		$this->httpError(404);
   	}
   	
   	public function validateStep($data, $form) {
   		return true;
   	}


}