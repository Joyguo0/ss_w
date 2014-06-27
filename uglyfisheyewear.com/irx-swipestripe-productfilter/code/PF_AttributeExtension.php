<?php
class PF_AttributeExtension extends DataExtension {
	
	public function SetOptionsForAttributeFilter($OpTitleArray){
		$this->owner->AF_OptionTitleArray = $OpTitleArray;
	
		return $this->owner;
	}
	
	
	public function getOptionsForAttributeFilterTemplete(){
		$OpTitleArray = $this->owner->AF_OptionTitleArray;
	
		if($OpTitleArray && is_array($OpTitleArray)){
			$optionDO_Array = array();
				
			foreach ($OpTitleArray as $OptionTitle => $ExtraData){
				$optionDO = Option::create()
					->setField('AF_Title', $OptionTitle)
					->setField('AF_OptionTitleArray', $OptionTitle)
				;
	
				if(is_array($ExtraData)){
					foreach ($ExtraData as $dataName => $data){
						$optionDO->setField('AF_' . $dataName, $data);
					}
				}
	
				$optionDO_Array[] = $optionDO;
			}
				
			return new ArrayList($optionDO_Array);
		}
	
		return false;
	}
	
	
	public function getOptionsById($attribute_id) {
		return Option::get ()->where ( 'AttributeID=' . $attribute_id )->map ( 'ID', 'Title' )->toArray ();
	}
	
	
	public function getSelectedOptions() {
		$seleted=Attribute::get ()->where ( 'ID=' . $this->owner->ID )->map ( 'ID','SelectedOptionIDs' )->toArray ();
		$result=Option::get()->where("ID in (".$seleted[$this->owner->ID].')');
		return $result;
	}
	
	
	public function TitleOptionSummary() {
		$optionString = '';
		$options = $this->Options ();
		if ($options && $options->exists ()) {
			$optionString = implode ( ', ', $options->map ()->toArray () );
		}
		return $this->Title . " - $optionString";
	}
	
	
	
	
}