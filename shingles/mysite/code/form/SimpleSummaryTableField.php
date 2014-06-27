<?php
/**
 * A simple readonly table which displays the items in an order, and the total
 * cost.
 */
class SimpleSummaryTableField extends ReadonlyField {
	
	

	/**
	 * @param string $name
	 * @param DataObjectSet $items
	 */
	public function __construct($name, $items, $paymentDO = false, $orderDO = false) {
		$this->items 		= $items;
		$this->paymentDO 	= $paymentDO;
		$this->orderDO 		= $orderDO;
		
		parent::__construct($name, '');
	}

	/**
	 * @return DataObjectSet
	 */
	public function getItems() {
		return new ArrayData($this->items);
	}

	public function getPaymentInfo() {
		return $this->paymentDO;
	}
	
	public function getOrderDO() {
		return $this->orderDO;
	}
	
	public function getIsDelivery(){
		$items = $this->items;
		
		return (isset($items['Delivery']) && ($items['Delivery'] > 0.00)) ? true : false;
	}
	
	public function forTemplate(){
		return $this->renderWith('SimpleSummaryTableField');
	}
	
	public function getPickupAddress(){
		$page = PaymentPage::get()->First();
		return $page->PickupAddress;
	}

}