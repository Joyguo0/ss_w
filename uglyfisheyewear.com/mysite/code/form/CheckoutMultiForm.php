<?php

class CheckoutMultiForm extends MultiForm {

	public static $start_step = 'CheckoutFormStep1';
	
	public function finish($data, $form) {
		parent::finish($data, $form);
	
		$steps = DataObject::get(
				'MultiFormStep',
				"SessionID = {$this->session->ID}"
		);
	
		if($steps) {
			foreach($steps as $step) {
				
				$data = $step->loadData();
				//Debug::show($data);

			}
		}
	}
	
	
}
