<?php
class FormFieldExtension extends DataExtension {
	
	public function LoadClassName(){
		return get_class($this->owner);
	}
	
	
	public function LoadSource(){
		if(method_exists($this->owner, 'getSource')){
			$sourceArray = $this->owner->getSource();
			$odd = 0;
			
			if(!empty($sourceArray)){
				$options = new ArrayList();
				$DOBJ = '';
				
				foreach($sourceArray as $value => $title) {
					$itemID = $this->owner->ID() . '_' . preg_replace('/[^a-zA-Z0-9]/', '', $value);
					$odd = ($odd + 1) % 2;
					$extraClass = $odd ? 'odd' : 'even';
					$extraClass .= ' val' . preg_replace('/[^a-zA-Z0-9\-\_]/', '_', $value);
					
					$DOBJ = new ArrayData(array(
						'ID' => $itemID,
						'Class' => $extraClass,
						'Name' => $this->owner->name,
						'Value' => $value,
						'Title' => $title,
						'isChecked' => $value == $this->owner->value,
						'isDisabled' => $this->owner->disabled || in_array($value, $this->owner->disabledItems),
					));
					
					$options->push($DOBJ);
				}
				
				return $options;
			}
		}
		
		return false;
	}
	
	
	
	
	
	
	
}