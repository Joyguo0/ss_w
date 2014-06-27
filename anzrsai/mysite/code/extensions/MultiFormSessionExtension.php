<?php

class MultiFormSessionExtension extends DataExtension {

	private static $db = array(
		'ShowedSummary' => 'Boolean'	
    );
    
	private static $has_one = array(
		'Order' 	=> 'Order'
	);
	
	private static $has_many = array(
	);
	
	public function LoadOrder(){
		return TicketOrder::get()->byID($this->owner->OrderID);
	}
	
}
