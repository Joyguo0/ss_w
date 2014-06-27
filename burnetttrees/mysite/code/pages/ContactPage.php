<?php
/**
 *
 */
class ContactPage extends UserDefinedForm {
	
	private static $icon = 'mysite/images/icons/contactpage';
	
	private static $db = array(
		'MapEmbed' 		=> 'HTMLText'
	);
	
	private static $has_many = array(
		'ContactLinks'	=> 'ContactLink'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldsToTab('Root.Main', new TextareaField('MapEmbed', 'Map Embed'), 'Metadata');
		
		$content 		= $fields->findOrMakeTab('Root.FormContent');
		$options 		= $fields->findOrMakeTab('Root.FormOptions');
		$submissions 	= $fields->findOrMakeTab('Root.Submissions');
		
		$fields->removeByName('FormContent');
		$fields->removeByName('FormOptions');
		$fields->removeByName('Submissions');
		$fields->removeByName('PageBanners');
		$fields->removeByName('ExpandableSections');
		
		$fields->addFieldsToTab('Root', new TabSet('ContactForm'), 'Resources');
		
		$fields->addFieldsToTab('Root.ContactForm', array($content, $options, $submissions));

		return $fields;
	}
}

class ContactPage_Controller extends UserDefinedForm_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
