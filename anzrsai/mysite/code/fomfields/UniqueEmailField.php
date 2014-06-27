<?php
 
/**
* UniqueEmailField extends the built in {@link EmailField} but add's an additional check
* to the validation to ensure a member doesn't already exist which the email given.
*
* @author Will Rossiter <http://twitter.com/willrossi>
*/
class UniqueEmailField extends EmailField {
	function validate($validator) {
		$valid = parent::validate($validator);
		if($valid) {
			// only do another look up if it will pass validation
			if($member = Member::currentUser()) {
				if($this->value == $member->Email) return true;
			}
			if(DB::query("SELECT COUNT(*) FROM Member WHERE \"Email\" = '". Convert::raw2sql($this->value) ."'")->value() > 0) {
					$validator->validationError(
					$this->name,
					_t('UniqueEmailField.UNIQUEVALIDATION', "A member already exists which that email address."),
					"validation"
				);
				return false;
			}
		}
		return $valid;
	}
}