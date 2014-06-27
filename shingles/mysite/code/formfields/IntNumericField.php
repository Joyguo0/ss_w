<?php

/**
 * Text input field with validation for numeric values. Supports validating
 * the numeric value as to the {@link i18n::get_locale()} value.
 * 
 * @package forms
 * @subpackage fields-formattedinput
 */
class IntNumericField extends NumericField {

	private $positive_only = false;
	
	public function setPositiveOnly(){
		$this->positive_only = true;
		
		return $this;
	}
	
	public function validate($validator) {
		if(!$this->value && !$validator->fieldIsRequired($this->name)) {
			return true;
		}
		
		require_once THIRDPARTY_PATH."/Zend/Locale/Format.php";

		$valid = Zend_Locale_Format::isInteger(
			trim($this->value), 
			array('locale' => i18n::get_locale())
		);
		
		if(!$valid) {
			$validator->validationError(
				$this->name,
				_t(
					'IntNumericField.VALIDATION', "'{value}' is not a integer, only integer numbers can be accepted for this field",
					array('value' => $this->value)
				),
				"validation"
			);

			return false;
		}elseif($this->positive_only){
			if($this->value <= 0){
				$validator->validationError(
						$this->name,
						_t(
								'IntNumericField.VALIDATION', "'{value}' is not a positive number, only positive numbers can be accepted for this field",
								array('value' => $this->value)
						),
						"validation"
				);
				
				return false;
			}
		}
		
		return true;
	}
	
	public function dataValue() {
		return (is_numeric($this->value)) ? $this->value : '';
	}
}
