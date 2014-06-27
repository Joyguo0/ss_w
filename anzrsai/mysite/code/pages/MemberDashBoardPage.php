<?php
/**
 *
 */
class MemberDashBoardPage extends Page {
	
	public static $icon = 'mysite/images/icons/memberareapage';
	
	private static $db = array(
	);
	
	private static $defaults = array(
	);
	
	private static $many_many = array(
	);
	
	private static $many_many_extraFields = array(
	);
	
	public function canCreate($member = null) {
		return false;
	}
	
	public function canDelete($member = null) {
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}
	
	public function requireDefaultRecords() {
		parent::requireDefaultRecords();
	
		if(!MemberDashBoardPage::get()->Count()) {
			$page = new MemberDashBoardPage();
			$page->Title = 'Member DashBoard';
			$page->URLSegment = 'member-dashBoard';
			$page->SendNotification = 1;
			$page->ShowInMenus = false;
			$page->ParentID = 1;
			$page->CanViewType = 'LoggedInUsers';
			$page->write();
			$page->publish('Stage', 'Live');
		}
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		return $fields;
	}
	
	
}

class MemberDashBoardPage_Controller extends Page_Controller {
	
	static $allowed_actions = array(
			'editprofile',
			'MemberForm'
	);
	
	public function init() {
		parent::init();
	}
	
	public function editprofile() {
		$member = Member::currentUser();
		if(!$member){
			return Security::permissionFailure();
		}
		return array(
			'Title' => 'Edit Profile' 
		);
	}
	
	
	public function MemberForm($type = "edit") {
		$member = Member::currentUser();
		$memberEmail = $member ? $member->Email : false;
		
		$fields = FieldList::create(
			ReadonlyField::create("Email","Email", $memberEmail),
			ConfirmedPasswordField::create('UpdatePassword', 'Update Password (Leave it blank if you are not changing it)')->setCanBeEmpty(true),
			DropdownField::create('MemberTitle', 'Title *', array('Mr.'=>'Mr.', 'Ms.'=>'Ms.', 'Mrs.'=>'Mrs.', 'Miss'=>'Miss', 'Dr.'=>'Dr.', 'Sir.'=>'Sir.', 'Prof.'=>'Prof.')),
			TextField::create("FirstName","First Name *"),
			TextField::create("Surname","Surname *"),
			
			TextField::create('Organisation', 'Organisation'),
			TextField::create('Position', 'Position'),
			TextField::create('MobilePhone', 'Mobile Phone'),
			TextField::create('HomePhone', 'Home Phone'),
			TextField::create('WorkPhone', 'Work Phone'),
			TextField::create('AddressLine1', 'Address Line 1 *'),
			TextField::create('AddressLine2', 'Address Line 2'),
			TextField::create('City', 'City *'),
			TextField::create('State', 'State *'),
			TextField::create('Postcode', 'Postcode *'),
			CountryDropdownField::create('Country', 'Country', null, 'AU')
		);
		
		$actions = FieldList::create(
				FormAction::create("SaveProfile","Update Profile")
			);
		
		$validator = RequiredFields::create(
			array(
				'MemberTitle',
				"FirstName",
				"Surname",
				"AddressLine1",
				"City",
				"State",
				"Postcode",
				'Country'	
			)
		);
		
		$form = Form::create($this, "MemberForm", $fields, $actions, $validator);
		
		$member = Member::currentUser();
		if($member){
			$form->loadDataFrom($member);
		}
		
		return $form;
	}
	
	public function SaveProfile($data,$form){
		$member = Member::currentUser();
		$form->saveInto($member);
		
		if(isset($data['UpdatePassword']) && strlen($data['UpdatePassword'])){
			$member->changePassword($data['UpdatePassword']);
		}
		
		$member->write();
		
		$form->sessionMessage('Your details were updated successfully', 'good');
		
		return $this->redirectBack();
	}
}
