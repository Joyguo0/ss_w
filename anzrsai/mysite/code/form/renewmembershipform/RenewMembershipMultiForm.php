<?php

class RenewMembershipMultiForm extends MultiForm {

	public static $start_step = 'RenewMembershipFirstFormStep';
	
	public function finish($data, $form) {
		parent::finish($data, $form);
	
		$steps = DataObject::get(
				'MultiFormStep',
				"SessionID = {$this->session->ID}"
		);
	
		if($steps) {
			foreach($steps as $step) {
				
				$data = $step->loadData();

			}
		}
	
		$controller = $this->getController();
      	$controller->redirect($controller->Link() . 'finished');
	}
}
