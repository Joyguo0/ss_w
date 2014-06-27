<?php
class MultiFormStepExtension extends DataExtension {
	
	public function StepTitle(){
		$title = $this->owner->title;
		
		return $title;
	}
	
}