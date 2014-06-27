<?php
class OrderExtension extends DataExtension {
	
	private static $has_one = array(
		'VPCPayment' => 'VPCPayment'	
	);
	
}



class VPCOrderExtension extends DataExtension {

	private static $has_one = array(
		'Order' => 'Order'
	);

}
