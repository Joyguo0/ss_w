<?php

class CartPageExtension extends DataExtension {
	
	public function contentcontrollerInit($CartPageContoller){
	
		//add javascripts requirements.
		Requirements::block('swipestripe-coupon/javascript/CouponModifierField.js');
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		
		Requirements::combine_files ( 'cart-page-ext.js', array (
			THIRDPARTY_DIR . '/jquery-entwine/dist/jquery.entwine-dist.js',
			'mysite/javascript/carform-init.js',
			'mysite/javascript/cart-coupon.js'
		) );
	
	}
	
	
	public function RelativeProducts(){
		
		return false;
		
	}


}

class CartPage_Controller_Extension extends DataExtension {
	
// 	private static $allowed_actions = array(
// 		'addCoupon'
// 	);
	
// 	public function addCoupon(SS_HTTPRequest $request){
		
// 		$orderDO = Cart::get_current_order();
		
		
		
		
// 	}
	
	
	
}