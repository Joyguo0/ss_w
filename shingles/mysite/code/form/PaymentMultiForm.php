<?php

class PaymentMultiForm extends MultiForm {

	public static $start_step = 'PaymentFirstFormStep';
	
	protected $NewPaymentFormAction = '';
	
	public function finish($data, $form) {
		parent::finish($data, $form);
	
		$steps = DataObject::get(
				'MultiFormStep',
				"SessionID = {$this->session->ID}"
		);
		
		$controller = $this->getController();
		$controller->redirect($controller->Link() . 'finished');
	}
	
	
	public function StepsProgress(){
		$currentStepHTMLclass 	= 'current';
		$completedStepHTMLclass = 'done';
		$futureStepHTMLclass 	= 'next';
		$lastStepHTMLclass 		= 'last';
		
		$allStepsInfo = $this->AllStepObject();
		
		$CompletedSteps = DataObject::get('MultiFormStep', "\"SessionID\" = {$this->session->ID} && \"Data\" IS NOT NULL");
		
		$completeStepsArray = array();
		if($CompletedSteps && $CompletedSteps->Count()){
			$completeStepsArray = $CompletedSteps->map('ID', 'ClassName')->toArray();
		}
		
		$currentStepDO = $this->getCurrentStep();
		
		$resultList = new ArrayList();
		
		foreach ($allStepsInfo as $number => $StepObject){
			if($StepObject->ClassName == $currentStepDO->ClassName){
				$StepObject->StepLinkingMode = $currentStepHTMLclass;
				$resultList->push($StepObject);
			}else{
				if(in_array($StepObject->ClassName, $completeStepsArray)){
					$StepObject->StepLinkingMode = $completedStepHTMLclass;
					$resultList->push($StepObject);
				}else{
					$StepObject->StepLinkingMode = $futureStepHTMLclass;
					$resultList->push($StepObject);
				}
			}
		}	
		
		return $resultList;
	}
	
	
	public function AllStepObject(){
		$StartClass = self::$start_step;
		$StartOBJ = new $StartClass();
		
		$AllSteps = array();
		$AllSteps[] = $StartOBJ;
		
		$currentStepOBJ = $StartOBJ;
		
		while(1){
			if(isset($currentStepOBJ::$is_final_step) && $currentStepOBJ::$is_final_step){
				break;
			}else{
				$NextClass = $currentStepOBJ::$next_steps;
				$NextOBJ = new $NextClass();

				$AllSteps[] = $NextOBJ;
				
				$currentStepOBJ = $NextOBJ;
			}
		}
		
		return $AllSteps;
	}
	
	
	public function GetOrCreateOrder(){
		if($this->session && $this->session->ID){
			$orderDO = DataObject::get_one('Order', "\"MultiFormSessionID\" = {$this->session->ID}");
			if(!$orderDO){
				$orderDO = new Order();
				$orderDO->MultiFormSessionID = $this->session->ID;
				$orderDO->write();
			}
			
			return $orderDO;
		}
		
		return false;
	}
	
	
}
