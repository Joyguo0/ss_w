<?php
/**
 * @author Guy Watson <guy.watson@internetrix.com.au>
 * @package irxewayonepageajaxpayment
 */

class eWayRapidPayment extends DataObject{
	
	public static $username 		= 'USERNAME';
	public static $password 		= 'PASSWORD';
	public static $testMode 		= true;
	public static $testValues 		= false;
	public static $allowDefaultAddr = false;
	
	private static $db = array(
		'Status'				=> 'enum("Completed,Failure,Processing","Processing")',
		'Amount' 				=> 'Money',
		'IP' 					=> 'Varchar',
		'ProxyIP' 				=> 'Varchar',
		'PaidForID' 			=> "Int",
		'PaidForClass' 			=> 'Varchar',
		'PaymentDate' 			=> "Date",
	
		'AuthorisedAmount'		=> 'Decimal',
		'AccessCode' 			=> 'Text', //can be up to 512
		'TokenCustomerID' 		=> 'Varchar(16)',
		'InvoiceNumber' 		=> 'Varchar(64)',
		'InvoiceDescription'	=> 'Varchar(64)',
		'InvoiceReference'		=> 'Varchar(64)',
	
		'AuthorisationCode'		=> 'Varchar(6)', 	//The authorisation code for this transaction as returned by the bank.
		'ResponseCode'			=> 'Varchar(2)', 	//The two digit response code returned from the bank.
		'ResponseMessage' 		=> 'Varchar(5)',	//A code that describes the result of the action performed.
		'ResponseDescription' 	=> 'Varchar(64)',	//A code that describes the result of the action performed.
	
		'TransactionID'			=> 'Int',			//A unique identifier that represents the transaction in eWAY’s system.
		'TransactionStatus'		=> 'Boolean',		//A Boolean value that indicates whether the transaction was successful or not.
		'BeagleScore'			=> 'Varchar(6)',	//Fraud score representing the estimated probability that the order is fraud, based off analysis of past Beagle Free transactions. This field will only be returned for transactions using the Beagle Free gateway.
	
		//for multi form
		'MultiFormSessionHash'	=> 'Varchar(64)',
		'MultiFormSessionID'	=> 'Int',
			
		'CardName'				=> 'Varchar(64)',
		'CardNumber'			=> 'Varchar(32)'
	);
	
	private static $has_one = array(
		'PaidBy' 		=> 'Member',
		'Verification' 	=> 'Verification'
	);
	
	/**
	 * Make payment table transactional.
	 */
	private static $create_table_options = array(
		'MySQLDatabase' => 'ENGINE=InnoDB'
	);
	
	function populateDefaults() {
		parent::populateDefaults();
		
// 		$this->Amount->Currency = 'AUD';
		$this->setClientIP();
 	}
	
	/**
	 * Set the IP address of the user to this payment record.
	 * This isn't perfect - IP addresses can be hidden fairly easily.
	 */
	function setClientIP() {
		$proxy = null;
		$ip = null;
		
		if(isset($_SERVER['HTTP_CLIENT_IP'])) $ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif(isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
		else $ip = null;
		
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$proxy = $ip;
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		
		// Only set the IP and ProxyIP if none currently set
		if(!$this->IP) $this->IP = $ip;
		if(!$this->ProxyIP) $this->ProxyIP = $proxy;
	}
	
	function PaidObject(){
		$class = $this->PaidForClass;
		return $class::get()->byID($this->PaidForID);
	}
	
	function createAccessCode($page, $customer = false, $payment = false, $redirectURL = false)
	{
		$eway_params = array();
		if(self::$testMode){
			$eway_params['sandbox'] = true;
		}
		$service = new RapidAPI(self::$username, self::$password, $eway_params);
   	 	$request = new CreateAccessCodeRequest();
   	 	
   	 	if(!$payment){
   	 		user_error("You must send payment details");
   	 	}
   	 	
		if(!$customer){
   	 		user_error("You must send customer details");
   	 	}
   	 	
   	 	$request->Payment = $payment;

   	 	if($customer->TokenCustomerID){
   	 		$request->Customer->TokenCustomerID = (float) $customer->TokenCustomerID;
   	 	}else{
   	 		$request->Customer->Title 		= $customer->Title;
		    $request->Customer->FirstName 	= $customer->FirstName;
		    $request->Customer->LastName 	= $customer->LastName;
		    $request->Customer->Email 		= $customer->Email;
		    $request->Customer->Phone 		= $customer->Phone;
		    
		    if(self::$allowDefaultAddr){
		    	$request->Customer->Street1 	= 'default st';
		    	$request->Customer->City 		= 'default city';
		    	$request->Customer->State 		= 'NSW';
		    	$request->Customer->PostalCode 	= '2000';
		    	$request->Customer->Country 	= 'au';
		    }else{
		    	$request->Customer->Street1 	= $customer->Street;
		    	$request->Customer->City 		= $customer->City;
		    	$request->Customer->State 		= $customer->State;
		    	$request->Customer->PostalCode 	= $customer->PostalCode;
		    	$request->Customer->Country 	= $customer->Country ? $customer->Country : 'au';
		    }
   	 	}
   	 	
	 
	    $request->RedirectUrl 	= $redirectURL ? $redirectURL : $page->AbsoluteLink('result');
    	$request->Method 		= 'TokenPayment'; //Method for this request. e.g. ProcessPayment, Create TokenCustomer, Update TokenCustomer & TokenPayment
	    
    	$result = $service->CreateAccessCode($request);

	    //Check if any error returns
	    $lblError = "";
	    
		// Check if any error returns
	    if(isset($result->Errors)) {
	        // Get Error Messages from Error Code. Error Code Mappings are in the Config.ini file
	        $ErrorArray = explode(",", $result->Errors);
	        $lblError = "";
	        foreach ( $ErrorArray as $error ) {
	            $error = $service->getMessage($error);
	            $lblError .= $error . "<br />\n";
	        }
	    }
	    
	    if($lblError != ""){
	    	Debug::show($lblError);
	    	return false;
	    }
	    
	    //if all we really want is the card name and number
		if($customer->TokenCustomerID){
   	 		$do = new DataObject();
   	 		$do->CardName = isset($result->Customer) ? $result->Customer->CardName : null;
   	 		$do->CardNumber = isset($result->Customer) ? $result->Customer->CardNumber : null;
   	 		return $do;
   	 	}
   	 	
	    return $result;
	}
	
	function getPaymentResult($accessCode)
	{
	 	$eway_params = array();
		if(self::$testMode){
			$eway_params['sandbox'] = true;
		}
		$service = new RapidAPI(self::$username, self::$password, $eway_params);
		
		$request = new GetAccessCodeResultRequest();
		$request->AccessCode = $accessCode;
		
		//Call RapidAPI to get the result
		$result = $service->GetAccessCodeResult($request);
// 		Debug::show($result);
		
		//we need to save the following detail even if the payment was unsuccessful
		$this->PaymentDate 		= SS_Datetime::now();
		$this->Amount->Amount 	= Session::get('Payment.Amount');
		$this->AuthorisedAmount = isset($result->TotalAmount) 			? $result->TotalAmount / 100 	: 0;
		$this->AccessCode 		= isset($result->AccessCode) 			? $result->AccessCode 			: null;
		$this->TokenCustomerID 	= isset($result->TokenCustomerID) 		? $result->TokenCustomerID 		: null;
		$this->InvoiceNumber 	= isset($result->InvoiceNumber) 		? $result->InvoiceNumber 		: null;
		$this->InvoiceReference	= isset($result->InvoiceReference) 		? $result->InvoiceReference 	: null;
		
		$this->AuthorisationCode = isset($result->AuthorisationCode) 	? $result->AuthorisationCode 	: null;
		$this->ResponseCode		= isset($result->ResponseCode) 			? $result->ResponseCode 		: null;
		$this->ResponseMessage	= $result->ResponseMessage;
		
		if(isset($result->ResponseMessage))
		{
			$this->ResponseMessage	= $result->ResponseMessage;
			 
			$responseMessageArray = explode(",", $result->ResponseMessage);
			$responseMessage = "";
		
			foreach ($responseMessageArray as $message) {
				$moreMessage 	  = $service->getMessage($message);
				$responseMessage .= $moreMessage ? $moreMessage : $message;
			}
			$this->ResponseDescription	= $responseMessage;
		}
		
		$this->TransactionID		= isset($result->TransactionID) 		? $result->TransactionID 		: 0;
		$this->TransactionStatus	= isset($result->TransactionStatus) 	? $result->TransactionStatus 	: false;
		$this->BeagleScore			= isset($result->BeagleScore) 			? $result->BeagleScore 			: null;
		
		$verification 				= new Verification();
		$verification->CVN 			= isset($result->Verification->CVN) 	? $result->Verification->CVN 		: null;
		$verification->Address 		= isset($result->Verification->Address) ? $result->Verification->Address 	: null;
		$verification->Email 		= isset($result->Verification->Email) 	? $result->Verification->Email 		: null;
		$verification->Mobile 		= isset($result->Verification->Mobile) 	? $result->Verification->Mobile 	: null;
		$verification->Phone 		= isset($result->Verification->Phone) 	? $result->Verification->Phone 		: null;
		$verification->write();
			
		$this->VerificationID  		= $verification->ID;
		$this->PaidByID 			= Member::currentUserID();
		
		
		
		//Check if any error returns
		if(!$result->TransactionStatus)
		{
		    $lblError	= $this->ResponseDescription ? $this->ResponseDescription : "Sorry your payment was unsuccessful: ";
		    
		    if (isset($result->Errors)) {
		    	$errorArray = explode(",", $result->Errors);
		    	foreach ( $errorArray as $error ) {
		    		$error = $service->getMessage($error);
		    		$lblError .= $error . "<br />\n";
		    	}
		    }
		
		    //before we write it we actually need to set the values
		    $this->Status ='Failure';
		   	$this->write();
		   
		    return new Payment_Failure($lblError);
		}else {
			
			$this->Status = 'Completed';
			$this->write();
			
			return new Payment_Success();
		}
	}

	/**
	 * @return CompositeField
	 */
	function getPaymentFormFields($accessCode) {
		
		$paymentFields = new FieldList();		
		$paymentFields->push(new LiteralField(
							'PaymentsList',
							'<img src="irxewayonepageajaxpayment/images/payments/methods/visa.jpg" alt="Visa"/>' .
							'<img src="irxewayonepageajaxpayment/images/payments/methods/mastercard.jpg" alt="MasterCard"/>'
		));
		
		$paymentFields->push(new HiddenField('EWAY_ACCESSCODE', "", $accessCode));
		$paymentFields->push($name = new TextField('EWAY_CARDNAME', "Card Name"));
		$paymentFields->push($number = new NumericField('EWAY_CARDNUMBER', "Card Number"));
		$paymentFields->push($month = new NumericField('EWAY_CARDEXPIRYMONTH', "Expiry Month", '', 2));
		$paymentFields->push($year = new NumericField('EWAY_CARDEXPIRYYEAR', "Expiry Year", '', 2));
		$paymentFields->push($cvn = new NumericField('EWAY_CARDCVN', "CVN", '', 4));		

		if(self::$testValues){
			$name->setValue('Guy Watson');
			$number->setValue('4444333322221111');
			$month->setValue('08');
			$year->setValue('15');
			$cvn->setValue('123');
		}
		
		$payment = new CompositeField($paymentFields);
		$payment->setID('payment-fields');	
		
		return $payment;
	}
}

abstract class Payment_Result {
	
	protected $value;
	
	function __construct($value = null) {
		$this->value = $value;
	}

	function getValue() {
		return $this->value;
	}

	abstract function isSuccess();
	
	abstract function isProcessing();
	
}
class Payment_Success extends Payment_Result {

	function isSuccess() {
		return true;
	}
	
	function isProcessing() {
		return false;
	}
	
}
class Payment_Processing extends Payment_Result {

	function isSuccess() {
		return false;
	}

	function isProcessing() {
		return true;
	}
	
}
class Payment_Failure extends Payment_Result {

	function isSuccess() {
		return false;
	}

	function isProcessing() {
		return false;
	}
}