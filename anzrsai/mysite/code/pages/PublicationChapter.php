<?php
/**
 *
 */
class PublicationChapter extends Page {

	private static $singular_name = 'Chapter';
	
	private static $plural_name = 'Chapter';
	
	private static $db = array(
		"Abstract" 		=> "Text",
		"Editors" 		=> "Text",
		"Keywords" 		=> "Varchar(255)",
		"PageNumber" 	=> "Int"
	);
	
	private static $defaults = array(
		'PageBannersSource' => 'Hide'
	);
	
	private static $has_one = array(
		'File' 	=> 'File',
		'Issue' => 'PublicationIssue'
	);
	
	private static $has_many = array(
	);
	
	private static $summary_fields = array(
		'Title' 		=> 'Title',
		'Editors' 		=> 'Editors',
		'Abstract' 		=> 'Abstract',
		'Keywords' 		=> 'Keywords',
		"PageNumber" 	=> "PageNumber"
	);
	
	public static $default_sort = 'Sort';
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		//new Text
		$fields->addFieldToTab("Root.Main", TextField::create('Editors','Editors'), 'Metadata');
		$fields->addFieldToTab("Root.Main", $abstract = TextareaField::create('Abstract','Abstract'),"Content");
		
		$fields->addFieldToTab("Root.Main", TextField::create('Keywords','Keywords'), 'Metadata');
		$fields->addFieldToTab("Root.Main", NumericField::create('PageNumber','Page Number'), 'Metadata');
		$fields->addFieldToTab('Root.Main', UploadField::create('File', 'Add a PDF.')
				->setFolderName('Uploads/PublicationChapter'), 'Metadata');
		
		$fields->addFieldToTab('Root.Main', TextField::create('SortID','Sort ID'), 'Metadata');
		
		$fields->removeByName("MenuTitle");
		$fields->removeByName("Content");
		$fields->removeByName("Resources");
		$fields->removeByName("Slideshow");
		$fields->removeByName("SideBar");
		$fields->removeByName("SortID");
		
		if(!$this->ID){
			$fields->removeByName("URLSegment");
		}
		
		return $fields;
	}
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		
		$this->ParentID = $this->IssueID;
		
		if(!$this->ID){
			$parentID = ($this->ParentID) ? $this->ParentID : 0;
			$this->Sort = DB::query("SELECT MAX(\"Sort\") + 1 FROM \"SiteTree\" WHERE \"ParentID\" = $parentID")->value();
		}
	}
	
	public function onAfterWrite(){
		parent::onAfterWrite();
	
		if(!$this->IsDoingPublish){
			$this->IsDoingPublish = true;
			$this->writeToStage('Live');
		}
	
	}
	
	public function onBeforeDelete(){
		parent::onBeforeDelete();
		
		if(!$this->DoingUnpublish){
			$this->DoingUnpublish = true;
			$this->doUnpublish();
		}
	}
	
	public function LoadCategoryID(){
		$VolumeParentDO = $this->Parent()->Parent();
		return $VolumeParentDO->CategoryID;
	}
	
	
	public function IsLatestChapter(){
		$IssueDO = $this->Parent();
		
		return $IssueDO->IsLatestIssue();
	}
	
	
	public function CanViewLatestChapter(){
		
		$memberDO = false;
		
		if(Permission::check('ADMIN')){
			return true;
			
		}elseif ( ! $this->IsLatestChapter()){	
			//if this is not the chapters of latest issue, everyone can view it
			return true;
			
		}elseif ( ! $memberDO = Member::currentUser()){
			//ok, this is latest, then member has to login.
			return false;
			
		}
		
		//member can view it if they have valid membership.
		return $memberDO->hasValidMembership();
		
	}
	
}

class PublicationChapter_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'accessdenied'
	);
	
	
	public function init() {
		parent::init();
		
		if(! Permission::check('ADMIN') && $this->request->param('Action') != 'accessdenied' && $this->IsLatestChapter()){
			//then we have to check membership
			$memberDO = Member::currentUser();
				
			if( ! ($memberDO && $memberDO->ID && $memberDO->hasValidMembership())){
				//admin can see it
				//show error message if member doesnt has latest membership.
		
				$redirectURL = $this->Link('accessdenied');
		
				$this->redirect($redirectURL);
		
				return $redirectURL;
			}
				
		}
		
	}
	
	
	public function accessdenied(){
		$SiteConfigDO 	= SiteConfig::get()->first();
	
		return $this->customise(array(
				'Title' 			=> 'Access Denied',
				'AccessIsDenied' 	=> true,
				'Content'	 		=> ShortcodeParser::get_active()->parse($SiteConfigDO->LIdeniedMSG),
		));
	
	}
	
	
}
