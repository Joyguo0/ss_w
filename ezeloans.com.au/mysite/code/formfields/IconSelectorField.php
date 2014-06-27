<?php
class IconSelectorField extends OptionsetField{
	
	protected $CSSFilePath = 'themes/ezeloans/icon.css';
	
	protected $SelectableClasses = array();
	
	public function __construct($name, $title = null, array $source = array(), $value = '', Form $form = null, $emptyString = null) {
		
		$this->InitClasses();
		
		if($this->CSSFilePath){
			Requirements::css($this->CSSFilePath);
		}
		
		$source = $this->SelectableClasses;
		
		parent::__construct($name, $title, $source, $value, $form, $emptyString);
	}

	public function InitClasses(){
		$array = array();
		
		for ($i = 1; $i <= 20; $i++){
			$val = 'a' . $i;
			$array[$val] = 'a' . $i;
		}
		
		$this->SelectableClasses = $array;
	}
	
	
	public function setCSSFilePath($path){
		$this->CSSFilePath = $path;
	}
	
	
	public function setClasses($array){
		$this->SelectableClasses = $array;
		
		$this->setSource($this->SelectableClasses);
	}
	
	public function getCSSFilePath(){
		return $this->CSSFilePath;
	}
	
	public function getClassName(){
		return get_class($this);
	}
	
}

