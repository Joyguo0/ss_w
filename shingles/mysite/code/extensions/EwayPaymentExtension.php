<?php
class EwayPaymentExtension extends DataExtension {
	
	private static $has_one = array(
		'Order' => 'Order'		
	);
	
}