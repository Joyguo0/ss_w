<?php

class CheckoutFormStep4 extends MultiFormStep {

   	public static $next_steps = 'CheckoutFormStep5';

	public function getFields() {
   		
   		$list = new FieldList();
   		
   		$list->push(new LiteralField('Header', '<div class="large-12 column"><div class="shipping-box column">'));
   		$list->push(new LiteralField('Header', '<h4>ALREADY HAVE AN ACCOUNT?</h4>'));
   		$list->push(TextField::create('LoginEmail','Email'));
   		$list->push(PasswordField::create('Password','Password'));
   		
   		$list->push(new LiteralField('End', '
   										</div>        
                                        <div class="large-12 column">
                                        	<div class="shipping-box column">
                                                <input type="radio" id="paypal" name="payment-method">
                                                <label class="inline" for="paypal">PayPal</label>
                                            </div>    
                                        </div> '));
   		
   		
   		
   		
//    		$list->push(new LiteralField('Header', '
//    			<div class="large-12 column">
//                                         	<div class="shipping-box column">
//                                                 <input type="radio" id="cc-payment" name="payment-method" checked>
//                                                 <label class="inline" for="cc-payment">Credit Card Payment</label>
                                                                  
//                                                 <div class="large-12 column">
//                                                     <label for="card-name" >* Name on Card</label>
//                                                     <input type="text" name="card-name" id="card-name">  
//                                                 </div>
//                                                 <div class="large-6 column">
//                                                     <label for="card-type" >* Credit Card Type</label>
//                                                     <select name="card-type" id="card-type">
//                                                         <option >Select a Card Type...</option>
//                                                         <option value="Mastercard">Mastercard</option>    
//                                                         <option value="Visa">Visa</option>
//                                                     </select>                                           	
//                                                 </div>
//                                                 <div class="large-12 column">
//                                                     <label for="card-number" >* Credit Card NUmber</label>
//                                                     <input type="text" name="card-number" id="card-number">  
//                                                 </div>                                       
//                                                 <div class="large-6 column">
//                                                     <label for="state" >* State/ Province</label>
//                                                     <input type="text" name="state" id="state">                                        	
//                                                 </div>  
//                                                 <div class="large-12 column">
//                                                     <label for="expiry-date" >* Expiry date</label>
//                                                     <div class="clear"></div>
//                                                     <div class="large-4 column no-pad-left">
//                                                         <select name="card-type" id="card-type">
//                                                             <option >Month...</option>
//                                                             <option value="01">January</option>    
//                                                             <option value="02">February</option>
//                                                             <option value="03">March</option>    
//                                                             <option value="04">April</option>
//                                                             <option value="05">May</option>    
//                                                             <option value="06">June</option>
//                                                             <option value="07">July</option>    
//                                                             <option value="08">August</option>
//                                                             <option value="09">September</option>    
//                                                             <option value="10">October</option> 
//                                                             <option value="11">November</option>    
//                                                             <option value="12">December</option>                                                                                                       
//                                                         </select>        
//                                                    </div>
//                                                     <div class="large-4 column no-pad-left float-left">
//                                                         <select name="card-type" id="card-type">
//                                                             <option >Year...</option>
//                                                             <option value="2014">2014</option>
//                                                             <option value="2015">2015</option>
//                                                             <option value="2016">2016</option>
//                                                             <option value="2017">2017</option>
//                                                             <option value="2018">2018</option>
//                                                             <option value="2019">2019</option>
//                                                             <option value="2020">2020</option>
//                                                         </select>        
//                                                    </div>                                           
//                                                 </div> 
//                                                 <div class="clear"></div>  
//                                                 <div class="large-4 column">
//                                                     <label for="csc" >* Card Verification Code</label>
//                                                     <input type="text" name="csc" id="csc">                                               	
//                                                 </div> 
//                                                 <div class="clear"></div>
//                                             </div>
//                                         </div>        
//                                         <div class="large-12 column">
//                                         	<div class="shipping-box column">
//                                                 <input type="radio" id="paypal" name="payment-method">
//                                                 <label class="inline" for="paypal">PayPal</label>
//                                             </div>    
//                                         </div> 
//    		'));

   		return $list;
   }
   
	
}
