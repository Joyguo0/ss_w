<?php

class SubscriptionPageExtension extends DataExtension {
	
	public function canDelete($member) {
		return false;
	}
	
	public function canCreate($member) {
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}

	public function updateCMSFields(FieldList $fields) {
		
	}
	
}
