<?php

class DataMigrationExtension extends DataExtension {
	
	private static $db = array(
		'FSLegacyID' => "Int"
	);
	
	public function updateCMSFields(FieldList $fields) {
		
		$fields->removeByName('FSLegacyID');
		
	}
	
}
