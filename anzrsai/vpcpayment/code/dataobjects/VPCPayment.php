<?php
class VPCPayment extends DataObject {
	
	public  static $MerchantID;
	public  static $AccessCode;
	public  static $SecureHashSecret;
	
	public  static $s2sv = false;		//enable server to server payment result verification.
	public  static $QueryDR_Username;	//for server to server verification
	public  static $QueryDR_Password;	//for server to server verification
	
	private static $singular_name 	= 'Virtual Payment Client Payment';
	private static $plural_name 	= 'Virtual Payment Client Payment';
	
	private static $VPC_URL 		= 'https://migs.mastercard.com.au/vpcpay';
	private static $result_function = 'vpcpresults';
	
	private static $db = array(
		'Status'			=> 'enum("Completed,Failure,Processing","Processing")',	
			
		//the following values exist in the payment response.	
		'Title'				=> 'Varchar',
		'Amount' 			=> 'Int',			//in cents
		'Card'				=> 'Varchar(16)',	//card type
		'Message'			=> 'Varchar(255)',
		'AcqResponseCode' 	=> 'Varchar(16)',	//Acquirer Response Code
		'MerchTxnRef'		=> 'Varchar(128)',	//can be set before redirecting to VPCP//Merchant Transaction Reference
		'OrderInfo'			=> 'Varchar(255)',  //can be set before redirecting to VPCP
		'BatchNo'			=> 'Varchar(32)',	//Batch Number
		'AuthorizeId'		=> 'Varchar(32)',
		'ReceiptNo'			=> 'Varchar(64)',	//RRN
		'SecureHash'		=> 'Varchar(32)',	//generated in VPCPageControllerExtension->ProcessParameter()
		'TransactionNo'		=> 'Varchar(64)',	//Transaction number
		'TxnResponseCode'	=> 'Varchar(16)',
			
		// 3-D Secure Data
		'VerType'			=> 'Varchar(5)',
		'VerStatus'			=> 'Varchar(5)',
		'VerToken'			=> 'Varchar(64)',
		'VerSecurityLevel'	=> 'Varchar(64)',
		'3DSenrolled'		=> 'Varchar(5)',
		'3DSXID'			=> 'Varchar(64)',	
		'3DSECI'			=> 'Varchar(5)',
		'3DSstatus'			=> 'Varchar(5)'
	);
	
	private static $has_one = array(
	);
	
	private static $summary_fields = array(
		'MerchTxnRef'	=> 'Merchant Transaction Reference',
		'OrderInfo'		=> 'Order Info',
		'Status'		=> 'Status',
		'AmountNice'	=> 'Amount',
	);
	
	
	public function AmountNice(){
		if($this->Amount){
			return number_format($this->Amount / 100, 2);
		}else{
			return '0';
		}
	}
	
	
	
	/**
	 This method uses the QSI Response code retrieved from the Digital
	 Receipt and returns an appropriate description for the QSI Response Code
	 
	 ---------------------------------------------------------------------
	 According to 'MasterCard VPC Integration Guide MR 25.pdf', $this->TxnResponseCode values mean
	 
	 "0"	- the transaction was completed successfully and you can display a receipt to the cardholder.
	 "?"
	 "1"	- the transaction has been declined, 
	 "2"	->and this needs to be conveyed 
	 "3"	->back to the cardholder.	
	 "4"	->
	 "5"	->
	 "6"
	 "7"	- an error has occurred. Other values may also indicate an error has occurred.
	 "8"	->Further details for error conditions can be gathered by examining the 'vpc_Message' field so a decision can be made as to the next step.

	---------------------------------------------------------------------
	
	 @param $responseCode String containing the QSI Response Code
	
	 @return String containing the appropriate description
	 */
	public function getResponseDescription($responseCode = null) {
		if($responseCode === null){
			$responseCode = $this->TxnResponseCode;
		}
		
		switch ($responseCode) {
			case "0" : $result = "Transaction Successful"; break;
			case "?" : $result = "Transaction status is unknown"; break;
			case "1" : $result = "Unknown Error"; break;
			case "2" : $result = "Bank Declined Transaction"; break;
			case "3" : $result = "No Reply from Bank"; break;
			case "4" : $result = "Expired Card"; break;
			case "5" : $result = "Insufficient funds"; break;
			case "6" : $result = "Error Communicating with Bank"; break;
			case "7" : $result = "Payment Server System Error"; break;
			case "8" : $result = "Transaction Type Not Supported"; break;
			case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
			case "A" : $result = "Transaction Aborted"; break;
			case "C" : $result = "Transaction Cancelled"; break;
			case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
			case "F" : $result = "3D Secure Authentication failed"; break;
			case "I" : $result = "Card Security Code verification failed"; break;
			case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
			case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
			case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
			case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
			case "S" : $result = "Duplicate SessionID (OrderInfo)"; break;
			case "T" : $result = "Address Verification Failed"; break;
			case "U" : $result = "Card Security Code Failed"; break;
			case "V" : $result = "Address Verification and Card Security Code Failed"; break;
			default  : $result = "There was an error"; //"Unable to be determined";
		}
		return $result;
	}
	
	/**
	 THIS METHOD USES THE VERRES STATUS CODE RETRIEVED FROM THE DIGITAL
	 RECEIPT AND RETURNS AN APPROPRIATE DESCRIPTION FOR THE QSI RESPONSE CODE
	
	 @PARAM STATUSRESPONSE STRING CONTAINING THE 3DS AUTHENTICATION STATUS CODE
	 @return String containing the appropriate description
	 */
	public function getStatusDescription($statusResponse = null) {
		if($statusResponse === null){
			$statusResponse = $this->VerStatus;
		}
		
		if ($statusResponse == "" || $statusResponse == "No Value Returned") {
			$result = "3DS not supported or there was no 3DS data provided";
		} else {
			switch ($statusResponse) {
				Case "Y"  : $result = "The cardholder was successfully authenticated."; break;
				Case "E"  : $result = "The cardholder is not enrolled."; break;
				Case "N"  : $result = "The cardholder was not verified."; break;
				Case "U"  : $result = "The cardholder's Issuer was unable to authenticate due to some system error at the Issuer."; break;
				Case "F"  : $result = "There was an error in the format of the request from the merchant."; break;
				Case "A"  : $result = "Authentication of your Merchant ID and Password to the ACS Directory Failed."; break;
				Case "D"  : $result = "Error communicating with the Directory Server."; break;
				Case "C"  : $result = "The card type is not supported for authentication."; break;
				Case "S"  : $result = "The signature on the response received from the Issuer could not be validated."; break;
				Case "P"  : $result = "Error parsing input from Issuer."; break;
				Case "I"  : $result = "Internal Payment Server system error."; break;
				default   : $result = "Unable to be determined"; break;
			}
		}
		return $result;
	}
	
	
	public function PaymentSuccess(){
		return ($this->TxnResponseCode == '0') ? true : false;
	}
	
	
	public function ErrorMessage(){
		if(!$this->PaymentSuccess()){
			$msg = '';
			
			if($this->Message){
				$msg .= $this->Message . '. ';
			}
			
			$msg .= $this->getResponseDescription() . '. '; 
			
			return $msg;
		}
		
		return;
	}
	
	
	public function getPaymentFormFields() {
	
		$paymentFields = new FieldList();
		
// 		$paymentFields->push(new LiteralField(
// 			'PaymentsList',
// 			'<div class="paymentimg">' .
// 			'<img src="irxewayrapidpayment/images/payments/methods/visa.jpg" alt="Visa"/>' .
// 			'<img src="irxewayrapidpayment/images/payments/methods/mastercard.jpg" alt="MasterCard"/>' .
// 			'</div>'
// 		));

		$paymentFields->push(new HiddenField('go_to_VPCP', "", true));
	
		$payment = new CompositeField($paymentFields);
		
		$payment->setID('vpc-payment-fields');
	
		return $payment;
	}
	
	
	
	public function CardTypeName(){
		if($this->Card == 'VC'){
			return 'Visa Card';
		}elseif ($this->Card == 'MC'){
			return 'Master Card';
		}else{
			return '';
		}
	}
	
	static function SetLiveMode($MerchantID, $AccessCode, $SecureHashSecret){
		self::$AccessCode 		= $AccessCode;
		self::$SecureHashSecret = $SecureHashSecret;
		self::$MerchantID		= $MerchantID;
	}
	
	static function SetTestMode($MerchantID, $AccessCode, $SecureHashSecret){
		self::$AccessCode 		= $AccessCode;
		self::$SecureHashSecret = $SecureHashSecret;
		self::$MerchantID		= 'test' . $MerchantID;
	}
	
	static function SetupServer2ServerVerification($username, $password){
		self::$s2sv					= true;
		self::$QueryDR_Username 	= $username;
		self::$QueryDR_Password 	= $password;
	}
	
	
}