<?php

class PaymentSecondFormStep extends MultiFormStep {
	
	protected $title = 'Information';

   	public static $next_steps = 'PaymentThirdFormStep';
   	
   	public static $delivery_cost = array(
   		'1' => '19.80',
   		'2' => '29.70',
   		'3' => '34.65',
   		'4' => '44.55'
   	);

	public function getFields() {
		$PaymentPageDO			= false;
		$PaymentPageController 	= $this->getForm()->getController();
		if($PaymentPageController && $PaymentPageController->ID){
			$PaymentPageDO = DataObject::get_by_id('PaymentPage', $PaymentPageController->ID);
		}
		
		$prevStepDO = $this->getPreviousStepFromDatabase();
		$prevStepData = $prevStepDO->loadData();
		
		$fields = new FieldList();
		
		$fields->push(new HeaderField('Personal Information'));
   		$fields->push(new DropdownField('Title', 'Title:', array('Mr.'=>'Mr.', 'Ms.'=>'Ms.', 'Mrs.'=>'Mrs.', 'Miss'=>'Miss', 'Dr.'=>'Dr.', 'Sir.'=>'Sir.', 'Prof.'=>'Prof.')));
   		$fields->push($name = new TextField('FirstName', 'First Name: *'));
   		$fields->push($surname = new TextField('LastName', 'Last Name: *'));
   		$fields->push($email = new EmailField('Email', 'Email: *'));
   		$fields->push($phone = new TextField('Phone', 'Phone:'));
   		
   		$fields->push(new HeaderField('Would you like to pick up your order, or have it delivered?'));
   		
   		$fields->push(OptionsetField::create(
   				'Option', 
   				'', 
   				array(
		   			'Pickup' 	=> 'Pickup',
		   			'Delivery' 	=> 'Delivery'	
	   			),
   				'Pickup'
   		));
   		
   		$fields->push(new LiteralField('div5', 
   			'<div class="pickup-box">
   				<p class="pickup">Pickup Address: '.$PaymentPageDO->PickupAddress.'</p>
	   			<div class="map-container">
		   			<div class="embed-container">
		   				<iframe class="pick-map" src="'.$PaymentPageDO->EmbedAddressMap.'" frameborder="0" style="border:0"></iframe>
		   			</div>
	   			</div>
   			</div>
   		'));

   		$fields->push(new LiteralField('div2', '<div class="addr-box">
	   		<div id="DeliveryCost" class="field readonly">
		   		<label class="left" for="PaymentMultiForm_PaymentMultiForm_DeliveryCost">Delivery Cost</label>
		   		<div class="middleColumn">
		   		<span id="PaymentMultiForm_PaymentMultiForm_DeliveryCost" class="readonly">
		   			'.'$'.self::CalculateDeliveryCost($prevStepData['Amount']).' (inc GST)
		   		</span>
		   		</div>
	   		</div>		
   		'));
   		
   		$fields->push($street = new TextField('Street', 'Street: *'));
   		$fields->push($city = new TextField('City', 'City: *'));
   		$fields->push($state = new TextField('State', 'State: *'));
   		$fields->push($postcode = new TextField('PostalCode', 'Postcode: *'));
   		$fields->push(new TextareaField('AdditionalInfo', 'Additional delivery instructions'));
   		$fields->push(new LiteralField('div3', '</div>'));
   		
   		if(eWayRapidPayment::$testValues){
   			$name->setValue('Guy');
   			$surname->setValue('Watson');
   			$email->setValue('guy.watson@internetrix.com.au');
   			$phone->setValue('0430496203');
   			$street->setValue('4 Samuel Court');
   			$city->setValue('Wollongong');
   			$state->setValue('NSW');
   			$postcode->setValue('2500');
   		}else{
   			
   		}
   		 
   		Requirements::javascript('mysite/javascript/paymentpage-s2.js');
   		
		return $fields;
   }
   
	public function getValidator() {
		
		$isDelivery = false;
		
		if($postVal = Controller::curr()->request->postVar('Option')){
			
			if($postVal == 'Delivery'){
				$isDelivery = true;
			}
			
		}else{
			
			$data = $this->loadData();
			if(isset($data['Option']) && $data['Option'] == 'Delivery'){
				$isDelivery = true;
			}
			
		}
		
		if($isDelivery){
			$OBJ = new RequiredFields('FirstName', 'LastName', 'Email', 'Phone', 'Street', 'City', 'State', 'PostalCode');
		}else{
			$OBJ = new RequiredFields('FirstName', 'LastName', 'Email', 'Phone');
		}
	   	
	   	return $OBJ;
	}
   
	public static function CalculateDeliveryCost($amount){
		$amount = intval($amount);
		if(!is_int($amount)){
			user_error('$amount should be an int', 1);
		}
		
		$cost = self::$delivery_cost;
		
		if(!empty($cost) && $amount){
			if(isset($cost[$amount])){
				return $cost[$amount];
			}else{
				return 0;
			}
		}
		
		return 0;
	}
	
	
	
}
