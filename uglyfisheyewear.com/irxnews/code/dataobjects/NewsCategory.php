<?php
class NewsCategory extends DataObject {
	private static $db = array(
			'Title' 	=> 'Varchar(255)',
	);
	public function getCMSFields(){
		$fields = new FieldList(new TabSet('Root'));
	
		$fields->addFieldsToTab(
				'Root.Main',
				array(
						TextField::create('Title'),
				));
	
		return $fields;
	}
}