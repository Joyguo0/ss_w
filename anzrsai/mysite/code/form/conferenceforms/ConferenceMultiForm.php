<?php

class ConferenceMultiForm extends MultiForm {

	//public static $start_step = 'ConferenceSecondFormStep';
	public static $start_step = 'ConferenceFirstFormStep';
	
	public function finish($data, $form) {
		parent::finish($data, $form);
		
		//program should not get into here.
		//mark this session as completed in ConferencePage
		$sessionDO 	= $this->session;
		$sessionDO->IsComplete = true;
		$sessionDO->write();
		
		$controller = $this->getController();
		$controller->redirect($controller->Link() . 'finished?MultiFormSessionID=' . $sessionDO->Hash);
		
	}
	
	
}
