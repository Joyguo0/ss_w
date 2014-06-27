<?php

class PaymentFirstFormStep extends MultiFormStep {
	
	protected $title = 'Amount';

   	public static $next_steps = 'PaymentSecondFormStep';

	public function getFields() {
		$PaymentPageDO = DataObject::get_one('PaymentPage');
		
		$StepData = $this->loadData();
		$amount = 0;
		$totalPrice = 0.00;
		if(!empty($StepData) && isset($StepData['Amount']) && $StepData['Amount']){
			$amount = $StepData['Amount'];
			$totalPrice = $amount * $PaymentPageDO->BackpackPrice;
		}
		
   		$fields = new FieldList();
   		
   		$fields->push(new LiteralField('divdiv', '
	   		<div id="ProductName" class="field readonly">
		   		<label class="left" for="PaymentMultiForm_PaymentMultiForm_ProductName">Product Name</label>
		   		<div class="middleColumn">
		   		<span id="PaymentMultiForm_PaymentMultiForm_ProductName" class="readonly">
		   			'.$PaymentPageDO->ProductName.'
		   		</span>
		   		</div>
	   		</div>
	   		<div id="ProductPrice" class="field readonly">
		   		<label class="left" for="PaymentMultiForm_PaymentMultiForm_ProductPrice">Price</label>
		   		<div class="middleColumn">
		   		<span id="PaymentMultiForm_PaymentMultiForm_ProductPrice" class="readonly">
		   			'.$PaymentPageDO->BackpackPrice.' (inc GST)
		   		</span>
		   		</div>
	   		</div>		
   		'));

   		
//    		$fields->push(Object::create('ReadonlyField', 'ProductName', 'Product Name', $PaymentPageDO->ProductName));
//    		$fields->push(Object::create('ReadonlyField', 'ProductPrice', 'Price', '$'.$PaymentPageDO->BackpackPrice));

	   	$fields->push(Object::create('IntNumericField', 'Amount', 'Number of Backpacks')->setPositiveOnly());
   		
	   	$fields->push(new LiteralField('divdiv', "
			<div class='item-summary'>
	   			<p class='st'>Subtotal (<span class='amount' data-price='{$PaymentPageDO->BackpackPrice}'>{$amount}</span>):</p>
	   			<p class='st-price'>$<span class='price'>{$totalPrice}</span></p>
	   		</div>	
	   	"));
	   	
	   	Requirements::javascript('mysite/javascript/paymentpage-s1.js');
   		
   		return $fields;
   }
   
   
	public function getValidator() {
		$OBJ = new RequiredFields(array('Amount'));
		return $OBJ;
	}
}
