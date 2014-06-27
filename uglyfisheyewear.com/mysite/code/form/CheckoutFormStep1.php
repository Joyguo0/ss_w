<?php

class CheckoutFormStep1 extends MultiFormStep {

   	public static $next_steps = 'CheckoutFormStep2';

   	public function validateTicket($ID){
   	
   		return false;
   	}
   	
   	
   	public function getFields() {
   		
   		$list = new FieldList();
   		$list->push(new LiteralField('LeftHeader', '<div class="large-6 inner column inline uppercase no-pad-left">'));
   		$list->push(new LiteralField('Header', '<h4>ALREADY HAVE AN ACCOUNT?</h4>'));
   		$list->push(TextField::create('LoginEmail','Email'));
   		$list->push(PasswordField::create('Password','Password'));
   		$list->push(new LiteralField('LeftEnd', '<a href="/" class="small text-right column">I forgot my password</a><input type="submit" value="sign in & continue" class="button"></div>'));
   		//new OptionsetField($name)
   		$list->push(new LiteralField('RightHeader', '<div class="large-6 inner column inline uppercase no-pad-right"><h4>NEW CUSTOMER</h4><p class="cond">An account is not required to shop with us. You can check out as a guest or you can register to save your details for your next purchase.</p>'));
   		$list->push(new OptionsetField('CUSTOMER','',array('guest'=>' CHECKOUT AS GUEST ' , 'register' =>'REGISTER')));
   		$list->push(new LiteralField('LeftEnd', '<input type="submit" value="continue" class="button"></div>'));
   		
   		$list->push(new LiteralField('Html', ''));
//    		$list->push(new LiteralField('HavaAnAccount', '
   		
   					
//                     	<div class="large-6 inner column inline uppercase no-pad-left">
//                         	<h4>ALREADY HAVE AN ACCOUNT?</h4>	
//                             <div class="large-3 small-4 column">
//                                 <label for="email" >EMAIL</label>
//                             </div>
//                             <div class="large-9 small-8 column">
//                                 <input type="text" name="email" id="email" tab-index="0">
//                             </div> 
//                             <div class="large-3 small-4 column">
//                         		<label for="password" >PASSWORD</label>
//                             </div>
//                             <div class="large-9 small-8 column">
//                             	<input type="text" name="password" id="password" tab-index="0">
//                             </div>    
//                             <a href="/" class="small text-right column">I forgot my password</a>
//                             <input type="submit" value="sign in & continue" class="button">
//                         </div>    
//                     	<div class="large-6 inner column inline uppercase no-pad-right">
//                         	<h4>NEW CUSTOMER</h4>
//                             <p class="cond">An account is not required to shop with us. You can check out as a guest or you can register to save your details for your next purchase.</p>
//                             <div class="large-7 small-7 column">
//                             	<input type="radio" id="as-guest" name="checkout-as">
//                                 <label class="inline" for="as-guest">CHECKOUT AS GUEST</label>
//                             </div>
//                             <div class="large-5 small-5 column">
//                             	<input type="radio" id="register" name="checkout-as">
//                                 <label class="inline" for="register">register</label>
//                             </div>
//                             <input type="submit" value="continue" class="button">
//                         </div>
                    
   				
//    			'));

   		return $list;
   }
   
	public function saveData($data) {
		$this->Data = serialize($data);
		$this->write();
		Session::set('FirstData', $data);
		//unserialize
		//var_dump($data);
   		//Debug::show($data);
   		//die;
   	}
}
