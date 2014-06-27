<?php

class MemberRegistrationSecondFormStep extends MultiFormStep {

	public static $is_final_step = true;
	
   	public function getFields() {
   		
   		$val = $this->getPreviousStepFromDatabase();
   		$step1data = unserialize($val->Data);
   		
   		$fields = new FieldList();
   		
   		/****** Payment *****/
   		$errorMSG = $this->Session()->PaymentMessage();
   		if($errorMSG){
   			$errorMSG .= ' Please try again.';
   			
   			$fields->push(HeaderField::create($errorMSG)
   					->setHeadingLevel(2)
   					->addExtraClass('payment-error')
   			);
   			
   			//update order status
   			
   		}
   		
   		$fields->push(singleton('VPCPayment')->getPaymentFormFields());
		
   		/****** End - Payment *****/
   		
   		$fields->push(HeaderField::create('You will be redirected to Bendigo Bank payment gateway.')->setHeadingLevel(3)->addExtraClass('event-form-heads'));
   		
   		
   		return $fields;
   	}
   
}