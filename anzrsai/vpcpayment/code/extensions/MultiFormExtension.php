<?php
class VPCPMultiFormSessionExtension extends DataExtension {

	private static $has_one = array(
		'VPCPayment' => 'VPCPayment'
	);

	public function IsPaymentSuccess(){
		$VPCPaymentDO = $this->owner->VPCPayment();
		
		if($VPCPaymentDO && $VPCPaymentDO->ID){
			//ok, got got the payment object
			return $VPCPaymentDO->PaymentSuccess();
		}
		
		return null;
	}
	
	
	public function PaymentMessage(){
		$VPCPaymentDO = $this->owner->VPCPayment();
		
		if($VPCPaymentDO && $VPCPaymentDO->ID){
			//ok, got got the payment object
			return $VPCPaymentDO->ErrorMessage();
		}
		
		return null;
	}
	
	
	
	
}



class VPCMultiFormSessionExtension extends DataExtension {

	private static $has_one = array(
		'MultiFormSession' => 'MultiFormSession'
	);

}