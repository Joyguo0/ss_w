<?php

class CartForm_IRX_Extension extends DataExtension {
	

	private static $allowed_actions = array(
		'update',
		'remove',
		'edit'
	);
	
	public function update(SS_HTTPRequest $request) {

		if ($request->isPOST()) {

			$member = Customer::currentUser() ? Customer::currentUser() : singleton('Customer');
			$order = Cart::get_current_order();

			//Update the Order 
			$order->update($request->postVars());

			$order->updateModifications($request->postVars())
				->write();

			$form = CartForm::create(
				$this->owner->controller, 
				'CartForm'
			)->disableSecurityToken();

			// $form->validate();

			return $form->renderWith('CartForm');
		}
	}
	
	
	public function updateFields(FieldList $fields){
		
		$order = $this->owner->order;
		
		//Order modifications fields
		$subTotalModsFields = CompositeField::create()->setName('SubTotalModificationsFields');
		$subTotalMods = $order->SubTotalModifications();
		
		if ($subTotalMods && $subTotalMods->exists()) foreach ($subTotalMods as $modification) {
			$modFields = $modification->getFormFields();
			foreach ($modFields as $field) {
				$subTotalModsFields->push($field);
				
			}
		}
		
		$totalModsFields = CompositeField::create()->setName('TotalModificationsFields');
		$totalMods = $order->TotalModifications();
		
		if ($totalMods && $totalMods->exists()) foreach ($totalMods as $modification) {
			$modFields = $modification->getFormFields();
			foreach ($modFields as $field) {
				$totalModsFields->push($field);
			}
		}
		
		
		$fields->push($subTotalModsFields);
		$fields->push($totalModsFields);
		
		
	}
	
	
	public function getSubTotalModificationsFields() {
		return $this->owner->Fields()->fieldByName('SubTotalModificationsFields')->renderWith('CartSummaryModificationField');
	}
	
	public function getTotalModificationsFields() {
		return $this->owner->Fields()->fieldByName('TotalModificationsFields')->renderWith('CartSummaryModificationField');
	}
	
	public function remove(SS_HTTPRequest $request){
		$order = Cart::get_current_order();
		$order->update($request->postVars());
		$ID = $request->getVar("ID");
		//$value = $order->get_by_id('Item', $ID);
		
		foreach ($order->Items() as $Item){
			if($ID == $Item->ID){
				$order->Items()->removeByID($ID);
			}
			
		}
		
		$form = CartForm::create(
				$this->owner->controller,
				'CartForm'
		)->disableSecurityToken();
		
		return $form->renderWith('CartForm');
	}
	
	public function edit(SS_HTTPRequest $request){
		
		if ($request->isPOST()) {

			$order = Cart::get_current_order();

			//Update the Order 
			$order->update($request->postVars());
			
			//
			
			$order->updateModifications($request->postVars())
				->write();
			//Debug::show($request->postVars("Quantity"));
			//var_dump($request->postVars("Quantity"));
			$this->saveCart($request->postVars("Quantity"),CartForm::create(
					$this->owner->controller,
					'CartForm'
			)->disableSecurityToken());
			$form = CartForm::create(
				$this->owner->controller, 
				'CartForm'
			)->disableSecurityToken();
			
			// $form->validate();

			return $form->renderWith('CartForm');
		}
	}
	
	private function saveCart(Array $data, Form $form) {
		$currentOrder = Cart::get_current_order();
		$quantities = (isset($data['Quantity'])) ?$data['Quantity'] :null;
	
		if ($quantities) foreach ($quantities as $itemID => $quantity) {
	
			if ($item = $currentOrder->Items()->find('ID', $itemID)) {
				if ($quantity == 0) {
	
					SS_Log::log(new Exception(print_r($item->toMap(), true)), SS_Log::NOTICE);
	
					$item->delete();
				}
				else {
					$item->Quantity = $quantity;
					$item->write();
				}
			}
		}
		$currentOrder->updateTotal();
	}
}


