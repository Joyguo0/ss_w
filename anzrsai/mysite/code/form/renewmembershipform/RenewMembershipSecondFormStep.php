<?php

class RenewMembershipSecondFormStep extends MultiFormStep {

	public static $is_final_step = true;
	
	//private static $contactFields = array('Amount','FirstName', 'Surname', 'State', 'City',  'Postcode', 'AddressLine1', 'Street');
	private static $contactFields = array();
	
   	public function getFields() {
   		
   		$prevDataDO = $this->getPreviousStepFromDatabase();
   		$prevData 	= $prevDataDO->loadData();
   		
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
   		
		$fields->push(HeaderField::create('You will be redirected to Bendigo Bank payment gateway to continue the payment. Please click \'Submit\' button.')
							->setHeadingLevel(3)
							->addExtraClass('event-form-heads')
		);
		
   		return $fields;
   	}
	
}