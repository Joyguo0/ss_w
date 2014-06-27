<?php
class InlineEditingGridField extends GridField {
	
	public function saveInto(DataObjectInterface $record) {
	    foreach($this->getComponents() as $component) {
	    	if($component instanceof GridField_SaveHandler) {
	    		$component->handleSave($this, $record);
	    	}
	    }
	  }
	
}	