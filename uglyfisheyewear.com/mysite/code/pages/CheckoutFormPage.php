<?php

class CheckoutFormPage extends Page {

	public static $icon = 'mysite/images/icons/conferencelistpage';

	private static $db = array(
	);

	private static $has_one = array(
   		
   	);
	
	private static $has_many = array(
		
	);

	public function getCMSFields(){

		$fields = parent::getCMSFields();
		
// 		$fields->addFieldToTab('Root', $EventTicketTab = new Tab('EventTicket'));
// 		$EventTicketTab->setTitle('Event Ticket');
// 		$EventTicketConfig = GridFieldConfig_RecordEditor::create();
// 		if(class_exists('GridFieldSortableRows')) {
// 			$EventTicketConfig->addComponent(new GridFieldSortableRows('SortID'));
// 		}
// 		$EventTicketField = new GridField('EventTicket', 'EventTicket', $this->EventTicket(), $EventTicketConfig);
// 		$fields->addFieldToTab("Root.EventTicket", $EventTicketField);
		
// 		$fields->addFieldToTab('Root', $SocialEventTicketTab = new Tab('SocialEventTicket'));
// 		$SocialEventTicketTab->setTitle('Social Event Ticket');
// 		$SocialEventTicketConfig = GridFieldConfig_RecordEditor::create();
// 		if(class_exists('GridFieldSortableRows')) {
// 			$SocialEventTicketConfig->addComponent(new GridFieldSortableRows('SortID'));
// 		}
// 		$SocialEventTicketField = new GridField('SocialEventTicket', 'SocialEventTicket', $this->SocialEventTicket(), $SocialEventTicketConfig);
// 		$fields->addFieldToTab("Root.SocialEventTicket", $SocialEventTicketField);
		
// 		$fields->addFieldToTab('Root', $EventPackageTab = new Tab('EventPackage'));
// 		$EventPackageTab->setTitle('Event Package');
// 		$EventPackageConfig = GridFieldConfig_RecordEditor::create();
// 		$EventPackageField = new GridField('EventPackage', 'EventPackage', EventPackage::get(), $EventPackageConfig);
// 		$fields->addFieldToTab("Root.EventPackage", $EventPackageField);
		
// 		$fields->removeByName("Resources");
// 		$fields->removeByName("Slideshow");
// 		$fields->removeByName("SideBar");
		return $fields;
	}
}

class CheckoutFormPage_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
			'CheckoutMultiForm',
			'finished'
	);
	
	function CheckoutMultiForm() {
		$form = new CheckoutMultiForm($this, 'CheckoutMultiForm');
		return $form;
	}
	
	function getStep() {
	
		$form = $this->CheckoutMultiForm();
		$step = $form->getCurrentStep();
		return $step;
	}
	
	public function init() {
		parent::init();
	}
	
	function finished() {
		return array(
				'Title' => 'Thank you for your submission',
				'Content' => ' <p> You have successfully submitted the form! </p> '
		);
	}

}