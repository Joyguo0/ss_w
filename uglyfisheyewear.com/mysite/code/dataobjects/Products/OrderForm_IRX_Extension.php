<?php

class OrderForm_IRX_Extension extends DataExtension {
	
	public function getDetailsFormForStep1() {
		$fields = $this->owner->getPersonalDetailsFields();
		
		
		
		
		
		return $fields;
		
// 		return $this->owner->Fields()->fieldByName('TotalModificationsFields')->renderWith('CartSummaryModificationField');
	}
	
	
	public function updateFields(FieldList $fields){
		
		Requirements::block('swipestripe/css/Shop.css');
		
	}
	
}


