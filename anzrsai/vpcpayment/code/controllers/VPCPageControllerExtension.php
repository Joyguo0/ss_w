<?php
class VPCPageControllerExtension extends DataExtension {
	
	private static $allowed_actions = array(
		'vpcpgateway',
		'vpcpresults',
		'vpcpsuccess',
		'vpcpfailed',
			
		'getresult'	
	);
	
	
	protected $VPC_POST_Array = array();
	
	
	protected function populate_VPC_POST_data(){
		$currentArray = $this->VPC_POST_Array;
		
		$POSTarray = array();
		
		$POSTarray['Title'] 			= 'VPC payment';
		
		//add access code
		$POSTarray['vpc_AccessCode'] 	= VPCPayment::$AccessCode;
		
		//add Merchant ID
		$POSTarray['vpc_Merchant'] 		= VPCPayment::$MerchantID;
		
		//add vpc_Version
		$POSTarray['vpc_Version'] 		= Config::inst()->get('VPCPayment', 'VPCVersion');
		
		//add vpc_Command
		$POSTarray['vpc_Command'] 		= Config::inst()->get('VPCPayment', 'CommandType');
		
		//add Payment Server Display Language Locale
		$POSTarray['vpc_Locale'] 		= Config::inst()->get('VPCPayment', 'DisplayLanguage');
		
		$POSTarray['vpc_TicketNo']		= 'N/A';
		
		$POSTarray['vpc_OrderInfo']		= 'N/A';
		
		//generate unique vpc_MerchTxnRef
		$unique = false;
		do{
			$invoiceReference = mt_rand(10000000, 99999999) . mt_rand(10000000, 99999999);
			if(!$same = VPCPayment::get()->filter(array('MerchTxnRef' => $invoiceReference))->first())
			{
				$unique = true;
			}
				
		} while (!$unique);
		
		$POSTarray['vpc_MerchTxnRef']	= $invoiceReference;

		
		$this->VPC_POST_Array 			= array_merge($currentArray, $POSTarray);
		
		return $this->VPC_POST_Array;
	}
	
	
	protected function update_VPC_POST_data($array){
		$currentArray = $this->VPC_POST_Array;
		
		if(!empty($array)){
			$this->VPC_POST_Array = array_merge($currentArray, $array);
		}
		
		return $this->VPC_POST_Array;
	}
	
	
	public function PaymentRedirectionCheck(SS_HTTPRequest $requestDO){
		if(!($requestDO->postVar('go_to_VPCP') && $requestDO->postVar('action_prev') != 'Back')){
			return false;
		}
		
		$POSTarray = $this->populate_VPC_POST_data();
		
		$multiFormID 	= $requestDO->getVar('MultiFormSessionID');
		$SessionDO		= MultiFormSession::get()->filter(array('Hash' => $multiFormID))->first();
		$orderDO		= false;
		
		if($SessionDO && ($orderDO = $SessionDO->Order())){
			$this->update_VPC_POST_data(array('vpc_Amount' => $orderDO->TotalAmount(true)));
		}
		
		//setup order info for VPC
		$this->update_VPC_POST_data(array('vpc_OrderInfo' => ''));
		
		$orderInfo = '';
		if(method_exists($orderDO, 'GenerateOrderInfo')){
			$orderInfo = $orderDO->GenerateOrderInfo();
		}
		
		$params 	= $this->ProcessParameter($POSTarray, $requestDO, $orderInfo);
		
		if(!is_array($params)){
			return $this->owner->httpError(404);
		}
		
		//update payment DO details
		$PaymentDO	= $params['PaymentDO'];
		$PaymentDO->MultiFormSessionID 	= $SessionDO->ID;
		$PaymentDO->OrderID 			= $orderDO->ID;
		$PaymentDO->write();
		
		$SessionDO->VPCPaymentID		= $PaymentDO->ID;
		$SessionDO->write();
		
		$orderDO->Status				= 'Processing';
		$orderDO->VPCPaymentID			= $PaymentDO->ID;
		$orderDO->write();
		
		$this->owner->redirect($params['RedirectURL']);
		
		return $params['RedirectURL'];
	}
	
	
	
	//for testing //////////////////////////////////////////////////////////
	public function vpcpgateway(SS_HTTPRequest $requestDO){
		
		$POSTarray = $this->populate_VPC_POST_data();
		
		$paymentURL = $this->ProcessParameter($POSTarray, $requestDO);		
		
		if($paymentURL === false){
			return $this->owner->httpError(404);
		}
		
		$this->owner->redirect($paymentURL);
		
		return $paymentURL;
	}
	
	
	/**
	 * 
	 * @param SS_HTTPRequest $requestDO
	 * @param string $returnURL vpc payment url 
	 */
	protected function ProcessParameter($Amount, SS_HTTPRequest $requestDO = null, $OrderInfo = null, $returnURL = null){
		
		$POSTarray = $this->VPC_POST_Array;
		
		$POSTarray['vpc_OrderInfo'] = $OrderInfo;
		
		//return false if there is no amount.
		if(!( isset($POSTarray['vpc_Amount']) && $POSTarray['vpc_Amount'] && intval($POSTarray['vpc_Amount']) > 0)){
			return false;
		}
		
		//add result return URL
		if($returnURL === null){
			$resultFunction = Config::inst()->get('VPCPayment', 'result_function');
			$resultFunction = $resultFunction ? $resultFunction : 'vpcpresults';
			
			$POSTarray['vpc_ReturnURL'] = Director::absoluteURL($this->owner->Link($resultFunction));
		}else{
			$POSTarray['vpc_ReturnURL'] = Director::absoluteURL($this->owner->Link('vpcpresults'));
		}
		
		// Define Constants
		// ----------------
		// This is secret for encoding the MD5 hash
		// This secret will vary from merchant to merchant
		// To not create a secure hash, let SECURE_SECRET be an empty string - ""
		// $SECURE_SECRET = "secure-hash-secret";
		$SECURE_SECRET = VPCPayment::$SecureHashSecret;
		
		// add the start of the vpcURL querystring parameters
		$vpcURLfromConfig = Config::inst()->get('VPCPayment', 'VPC_URL');
		$vpcURL = $vpcURLfromConfig . "?";

		// Remove the Virtual Payment Client URL from the parameter hash as we
		// do not want to send these fields to the Virtual Payment Client.
		if(isset($POSTarray["virtualPaymentClientURL"])){
			unset($POSTarray["virtualPaymentClientURL"]);
		}
		if(isset($POSTarray["SubButL"])){
			unset($POSTarray["SubButL"]);
		}
		
		// The URL link for the receipt to do another transaction.
		// Note: This is ONLY used for this example and is not required for
		// production code. You would hard code your own URL into your application.
		
		// Get and URL Encode the AgainLink. Add the AgainLink to the array
		// Shows how a user field (such as application SessionIDs) could be added
		//$_POST['AgainLink']=urlencode($HTTP_REFERER);
		
		// Create the request to the Virtual Payment Client which is a URL encoded GET
		// request. Since we are looping through all the data we may as well sort it in
		// case we want to create a secure hash and add it to the VPC data if the
		// merchant secret has been provided.
		$md5HashData = $SECURE_SECRET;
		ksort ($POSTarray);
		
		// set a parameter to show the first pair in the URL
		$appendAmp = 0;
	
		foreach($POSTarray as $key => $value) {
		
			// create the md5 input and URL leaving out any fields that have no value
			if (strlen($value) > 0) {
		
				// this ensures the first paramter of the URL is preceded by the '?' char
				if ($appendAmp == 0) {
					$vpcURL .= urlencode($key) . '=' . urlencode($value);
					$appendAmp = 1;
				} else {
					$vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
				}
				$md5HashData .= $value;
			}
		}

		
		// Create the secure hash and append it to the Virtual Payment Client Data if
		// the merchant secret has been provided.
		if (strlen($SECURE_SECRET) > 0) {
			$vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
		}
		
		// FINISH TRANSACTION - Redirect the customers using the Digital Order
		// ===================================================================
		
		$paymentDO = new VPCPayment();
		foreach ($POSTarray as $key => $val){
			$DOKey 				= str_ireplace('vpc_', '', $key);
			$paymentDO->$DOKey	= $val;
		}
		$paymentDO->write();
		
		return array(
			'RedirectURL' 	=> $vpcURL,
			'PaymentDO' 	=> $paymentDO
		);
	}
	
	
	
	
	
	
	
	/********** functions for verifying result **************/
	
	public function vpcpresults(SS_HTTPRequest $requestDO){
		$do_not_update_values = array('vpc_Amount', 'vpc_MerchTxnRef', 'vpc_TicketNo', 'vpc_OrderInfo');

		$GETdataArray = $requestDO->getVars();
		
		if(VPCPayment::$s2sv){
			//server 2 server verification enabled.
				
			$GETdataArray = $this->verify_vpc_result($GETdataArray['vpc_MerchTxnRef']);
				
		}
		
		$PaymentDO = false;
		
		if(!(isset($GETdataArray['vpc_MerchTxnRef'])
			&& $GETdataArray['vpc_MerchTxnRef']
			&& ($PaymentDO = VPCPayment::get()
								->filter(array('MerchTxnRef' => Convert::raw2sql($GETdataArray['vpc_MerchTxnRef'])))->first())
		)){
			//no MerchTxnRef number and can loop up Payment record by this ref number.
			return $this->owner->httpError(404);
		}
		
		foreach (Config::inst()->get('VPCPayment', 'db') as $DOkey => $WeDontNeedThisValue){
			$GETkey = 'vpc_' . $DOkey;
			
			if(isset($GETdataArray[$GETkey]) && !in_array($GETdataArray[$GETkey], $do_not_update_values)){
				$PaymentDO->$DOkey = $this->null2unknown($GETdataArray[$GETkey]);
			}
			
			
		}
		
		//check payment is success or not.
		if($PaymentDO->PaymentSuccess()){
			$PaymentDO->Status 	= 'Completed';
			$PaymentDO->write();
			
			$OrderDO 			= $PaymentDO->Order();
			
			$redirectURL = $OrderDO->onOrderComplete($this->owner);
			
			if(!is_string($redirectURL)){
				$redirectURL = $this->owner->Link('vpcpsuccess');
			}
		}else{
			$PaymentDO->Status = 'Failure';
			$PaymentDO->write();
			
			$OrderDO 			= $PaymentDO->Order();
			$OrderDO->Status	= 'Cart';
			$OrderDO->write();
			
			$redirectURL = $OrderDO->onPaymentDenied($this->owner);
			
			if(!is_string($redirectURL)){
				$redirectURL = $this->owner->Link('vpcpfailed');
			}
		}
		
		//redirect to page according the result.
		return $this->owner->redirect($redirectURL);
	}
	
	
	public function vpcpsuccess(SS_HTTPRequest $requestDO){
		return $this->owner->customise(array(
			'Title' 	=> 'Payment Success', 
			'Content' 	=> 'Your payment is successful.'	
		));
	}
	
	
	public function vpcpfailed(SS_HTTPRequest $requestDO){
		return $this->owner->customise(array(
				'Title' 	=> 'Payment Failed',
				'Content' 	=> 'Payment failed. Please try again.'
		));
	}
	
	


	/**
	 * 
	 * @param string $data
	 * @return string
	 */
	protected function null2unknown($data) {
	    if ($data == "") {
	        return "No Value Returned";
	    } else {
	        return $data;
	    }
	} 
	
	
	public function getresult(){
	
		if(Director::isLive()){
			return;
		}
		
		$MerchRef = $this->owner->request->getVar('ref');
	
		$MerchRef = $MerchRef ? $MerchRef : '3956159397663169';
	
		$result = $this->verify_vpc_result($MerchRef);
	
		Debug::show($result);
	}
	
	protected function verify_vpc_result($MerchTxnRef){
		
		$vpcURL = 'https://migs.mastercard.com.au/vpcdps';
		
		$Params = $this->populate_VPC_POST_data();
		$Params['vpc_MerchTxnRef'] 	= $MerchTxnRef;
			
		$Params['vpc_Command']		= 'queryDR';
		$Params['vpc_User'] 		= VPCPayment::$QueryDR_Username;
		$Params['vpc_Password'] 	= VPCPayment::$QueryDR_Password;
		
		unset($Params["virtualPaymentClientURL"]);
		unset($Params["SubButL"]);
		unset($Params["Title"]);
		
		// create a variable to hold the POST data information and capture it
		$postData = "";
		
		$ampersand = "";
		foreach($Params as $key => $value) {
			// create the POST data input leaving out any fields that have no value
			if (strlen($value) > 0) {
				$postData .= $ampersand . urlencode($key) . '=' . urlencode($value);
				$ampersand = "&";
			}
		}
		
		// Get a HTTPS connection to VPC Gateway and do transaction
		// turn on output buffering to stop response going to browser
		ob_start();
		
		// initialise Client URL object
		$ch = curl_init();
		
		// set the URL of the VPC
		curl_setopt ($ch, CURLOPT_URL, $vpcURL);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postData);
		
		// (optional) set the proxy IP address and port
		//curl_setopt ($ch, CURLOPT_PROXY, "192.168.21.13:80");
		
		// (optional) certificate validation
		// trusted certificate file
		//curl_setopt($ch, CURLOPT_CAINFO, "c:/temp/ca-bundle.crt");
		
		//turn on/off cert validation
		// 0 = don't verify peer, 1 = do verify
		//curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		// 0 = don't verify hostname, 1 = check for existence of hostame, 2 = verify
		//curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
		
		// connect
		curl_exec ($ch);
		
		// get response
		$response = ob_get_contents();

		// turn output buffering off.
		ob_end_clean();
		
		// set up message paramter for error outputs
		$message = "";
		
		// serach if $response contains html error code
		if(strchr($response,"<html>") || strchr($response,"<html>")) {;
		$message = $response;
		} else {
			// check for errors from curl
			if (curl_error($ch))
				$message = "%s: s". curl_errno($ch) . "<br/>" . curl_error($ch);
		}
		
		// close client URL
		curl_close ($ch);
		
		// Extract the available receipt fields from the VPC Response
		// If not present then let the value be equal to 'No Value Returned'
		$map = array();
		
		// process response if no errors
		if (strlen($message) == 0) {
			$pairArray = split("&", $response);
			foreach ($pairArray as $pair) {
				$param = split("=", $pair);
				$map[urldecode($param[0])] = urldecode($param[1]);
			}
			$message         = $this->null2unknown($map, "vpc_Message");
		}

		// Standard Receipt Data
		# merchTxnRef not always returned in response if no receipt so get input
		//TK//$merchTxnRef     = $vpc_MerchTxnRef;
// 		$merchTxnRef     = $Params["vpc_MerchTxnRef"];
		
		if( ! (isset($map["vpc_DRExists"]) && $map["vpc_DRExists"] == 'Y') ){
			// no vpc_DRExists record or vpc_DRExists = N. that means can't find the ref number for this payment. ( VPC only keep record for 3 days )
			
			$results = array();
			$results[] = 'SS environment_type = ' . ( Director::isDev() ? 'dev' : 'live');
			$results[] = print_r($map, 1);
			$results[] = print_r($this->owner->request, 1);
			$results[] = print_r(Member::currentUser(), 1);
			$results = implode('<br><br><br>', $results);
			
			mail('errors@internetrix.com.au', 'anzrsai.org : Error in verify_vpc_result() VPCPageControllerExtension.php', 'Could not look payment info by reference number <br>' .  $results);
			
		}
		
		return $map;
		
//result samples		
		
		
		
// reference number does not exist.		
//		
// 		array(9) {
// 			["vpc_Amount"]=>
// 			string(1) "0"
// 					["vpc_BatchNo"]=>
// 					string(1) "0"
// 							["vpc_Command"]=>
// 							string(7) "queryDR"
// 									["vpc_DRExists"]=>
// 									string(1) "N"
// 											["vpc_FoundMultipleDRs"]=>
// 											string(1) "N"
// 													["vpc_Locale"]=>
// 													string(5) "en_US"
// 															["vpc_Merchant"]=>
// 															string(14) "TESTBBL7107147"
// 																	["vpc_TransactionNo"]=>
// 																	string(1) "0"
// 																			["vpc_Version"]=>
// 																			string(1) "1"
		
		
		
// reference number got.		
		
// 		array(30) {
// 			["vpc_3DSECI"]=>
// 			string(2) "01"
// 					["vpc_3DSXID"]=>
// 					string(28) "hFZ4WKW0sVG3oThA5GQgSXWTXTY="
// 							["vpc_3DSenrolled"]=>
// 							string(1) "Y"
// 									["vpc_3DSstatus"]=>
// 									string(1) "A"
// 											["vpc_AVSRequestCode"]=>
// 											string(1) "Z"
// 													["vpc_AVSResultCode"]=>
// 													string(11) "Unsupported"
// 															["vpc_AcqAVSRespCode"]=>
// 															string(11) "Unsupported"
// 																	["vpc_AcqCSCRespCode"]=>
// 																	string(11) "Unsupported"
// 																			["vpc_AcqResponseCode"]=>
// 																			string(2) "00"
// 																					["vpc_Amount"]=>
// 																					string(5) "95000"
// 																							["vpc_AuthorizeId"]=>
// 																							string(6) "422271"
// 																									["vpc_BatchNo"]=>
// 																									string(8) "20140523"
// 																											["vpc_CSCResultCode"]=>
// 																											string(11) "Unsupported"
// 																													["vpc_Card"]=>
// 																													string(2) "MC"
// 																															["vpc_Command"]=>
// 																															string(7) "queryDR"
// 																																	["vpc_DRExists"]=>
// 																																	string(1) "Y"
// 																																			["vpc_FoundMultipleDRs"]=>
// 																																			string(1) "N"
// 																																					["vpc_Locale"]=>
// 																																					string(2) "en"
// 																																							["vpc_MerchTxnRef"]=>
// 																																							string(16) "8266464044952265"
// 																																									["vpc_Merchant"]=>
// 																																									string(14) "TESTBBL7107147"
// 																																											["vpc_Message"]=>
// 																																											string(8) "Approved"
// 																																													["vpc_OrderInfo"]=>
// 																																													string(6) "Ticket"
// 																																															["vpc_ReceiptNo"]=>
// 																																															string(12) "414310422271"
// 																																																	["vpc_TransactionNo"]=>
// 																																																	string(2) "13"
// 																																																			["vpc_TxnResponseCode"]=>
// 																																																			string(1) "0"
// 																																																					["vpc_VerSecurityLevel"]=>
// 																																																					string(2) "06"
// 																																																							["vpc_VerStatus"]=>
// 																																																							string(1) "M"
// 																																																									["vpc_VerToken"]=>
// 																																																									string(28) "hpkPlTX29g/HDwAAADB7BIYAAAA="
// 																																																											["vpc_VerType"]=>
// 																																																											string(3) "3DS"
// 																																																													["vpc_Version"]=>
// 																																																													string(1) "1"
		
		
		
	}
	
	
	
}