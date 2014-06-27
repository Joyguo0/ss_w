<?php

class BlogHolderExtension extends DataExtension {

	private static $db = array(
		'AjaxNumber' => 'Int'
	);
	
	public function updateCMSFields(FieldList $fields){
		$fields->addFieldToTab('Root.Setting', new NumericField('AjaxNumber', 'Number of blogs return for each request. ( 10 by default )'));
	}

	
}
