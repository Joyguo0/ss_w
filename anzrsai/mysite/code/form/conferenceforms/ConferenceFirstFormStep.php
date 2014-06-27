<?php

class ConferenceFirstFormStep extends MultiFormStep {

   	public static $next_steps = 'ConferenceSecondFormStep';
   	
   	public function getValidator(){
   		return new RequiredFields(array('Package'));
   	}

   	public function getFields() {
   		
   		$list = new FieldList();
   		$list->push(HeaderField::create('Select Package')->addExtraClass('event-form-heads'));
   		$list->push(new OptionsetField('Package' , '' , array('Full' => 'Full Conference', 'Individual' => 'Individual Days')));
   	
		return $list;
   }
   
	public function saveData($data) {
		
		$this->Data = serialize($data);
		$this->write();
		
   	}
}
