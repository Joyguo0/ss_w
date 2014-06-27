<?php
class LoanIconSelectorField extends IconSelectorField {

	public function InitClasses(){
		
		$this->setCSSFilePath('themes/ezeloans/loanicon.css');
		
		$class = array('cars','boats','caravans','bikes','trucks','personal','equipment');
		$array = array();
		foreach ($class as $val){
			$array[$val] = $val;
		}
		
		$this->SelectableClasses = $array;
	}
	
}

