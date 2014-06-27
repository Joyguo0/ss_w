<?php
/**
 *
 */
class PublicationIssue extends Page {
	
	private static $singular_name = 'Issue';
	
	private static $plural_name = 'Issue';
	
	private static $allowed_children = array('PublicationChapter');
	
	private static $db = array(
		'IssueNumber' 	=> 'Int',
		'Desc' 			=> 'HTMLText'
	);
	
	private static $defaults = array(
		'PageBannersSource' => 'Hide'
	);
	
	private static $has_one = array(
		'Volume' 		=> 'PublicationVolume',
		'FrontPages' 	=> 'File',
		'BackPages' 	=> 'File'
	);
	
	private static $has_many = array(
		'Chapters' => 'PublicationChapter'
	);
	
	private static $summary_fields = array(
		'Title' 			=> 'Title',
		'DescSummary'		=> 'Description',
		'Chapters.Count'	=> 'Number Of Chapters'
	);

	private static $field_labels = array(
		'IssueNumber' => 'Issue Number'
	);
	
	public static $default_sort = 'Sort';
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', TextField::create('IssueNumber','Issue Number'), 'Content');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Desc','Description')->setRows(10), 'Content');
		
		$fields->addFieldToTab('Root.Main', UploadField::create('FrontPages', 'Front Pages PDF')
				->setFolderName('Uploads/PublicationIssue/FrontPages'), 'Content');
		
		$fields->addFieldToTab('Root.Main', UploadField::create('BackPages', 'Back Pages PDF.')
				->setFolderName('Uploads/PublicationIssue/BackPages'), 'Content');
		
		if($this->ID){
			$ChapterConfig = GridFieldConfig_RecordEditor::create();
			$ChapterConfig->addComponent(new GridFieldSortableRows('Sort'));
			$ChapterField = new GridField('Chapter', 'Chapter', $this->Chapters()->sort('"Sort" ASC'), $ChapterConfig);
			$fields->addFieldToTab("Root.Chapters", $ChapterField);
		}else{
			$fields->addFieldToTab("Root.Chapters", HeaderField::create('IssueMSG', 'Chapters can be added after issue is created.'));
		}
			
			
		if(!$this->ID){
			$fields->removeByName("URLSegment");
		}
		
		$fields->removeByName("Title");
		$fields->removeByName("MenuTitle");
		$fields->removeByName("Resources");
		$fields->removeByName("Slideshow");
		$fields->removeByName("SideBar");
		$fields->removeByName("SortID");
		$fields->removeByName("Content");

		return $fields;
	}
	
	public function  getIssueAndVolume(){
		
		$VolumeDO = $this->Parent();
	
		$publication = new ArrayList();
		$DOBJ = '';
	
		$issueList = PublicationIssue::get()->filter('ParentID', $VolumeDO->ID);
		foreach ($issueList as $issue){
			$issue->issuenewTitle = $VolumeDO->Title ." ".$issue->Title;
			$publication->push($issue);

		}
	
		return $publication;
	}
	
	public function Status(){
		if($this->isNew()){
			return 'New Page';
		}elseif($this->isPublished()){
			return 'Published';
		}else{
			return 'Unpublished';
		}
	}
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		
		$this->setField('Title' ," Issue ".$this->IssueNumber);
		$this->setField('MenuTitle'," Issue ".$this->IssueNumber);
		$this->setField('URLSegment' , "Issue-".$this->IssueNumber);
		
		$this->ParentID = $this->VolumeID;
		
		if(!$this->ID){
			$this->IsFirstWrite = true;
		}
		
	}
	
	public function onAfterWrite(){
		parent::onAfterWrite();
		
		if($this->IsFirstWrite){
			$this->IsFirstWrite = false;
			
			$parentID = ($this->ParentID) ? $this->ParentID : 0;
			$this->Sort = DB::query("SELECT MAX(\"Sort\") + 1 FROM \"SiteTree\" WHERE \"ParentID\" = $parentID")->value();
			
			$this->write();
		}
		
		if(!$this->IsDoingPublish){
			$this->IsDoingPublish = true;
			$this->writeToStage('Live');
		}
		
	}
	
	public function onBeforeDelete(){
		if(!$this->DoingUnpublish){
			$this->DoingUnpublish = true;
			$this->doUnpublish();
		}
	}
	
// 	public function validate() {
// 		$result = parent::validate();
		
// 		if($this->VolumeID){
// 			//issue number should be unique
// 			$checkDO = PublicationIssue::get()->filter(array('IssueNumber' => $this->IssueNumber, 'VolumeID' => $this->VolumeID))
// 											  ->exclude('ID', $this->ID)
// 			 								  ->first();
	
// 			if($checkDO){
// 				$result->error(
// 					"Issue number '$this->IssueNumber' is already exist in volume no. $this->VolumeID"
// 				);
// 			}
// 		}
		
// 		return $result;
// 	}

	
	public function LoadCategoryID(){
		$VolumeParentDO = $this->Parent();
		return $VolumeParentDO->CategoryID;
	}
	
	public function DescSummary(){
		return DBField::create_field('HTMLText', $this->Desc)->Summary();
	}
	
	
	public function IsLatestIssue(){
		$thisVolumeDO	= $this->Parent();
		
		$categoryDO 	= $thisVolumeDO->Parent();
		
		$latestVolumeDO	= PublicationVolume::get()->filter(array('ParentID' => $categoryDO->ID))->sort('"Year" DESC, "VolumeNumber" DESC, "ID" DESC')->first();
		
		if($latestVolumeDO->ID != $thisVolumeDO->ID){
			return false;
		}
		
		$latestIssueDO	= PublicationIssue::get()->filter(array('ParentID' => $latestVolumeDO->ID))->sort('"IssueNumber" DESC, "ID" DESC')->first();
	
		if($latestIssueDO && $latestIssueDO->ID && $latestIssueDO->ID == $this->ID){
			return true;
		}
			
		return false;
		
	}
		
}

class PublicationIssue_Controller extends Page_Controller {
	
	private static $allowed_actions = array(
		'accessdenied'
	);
	
	public function init() {
		parent::init();
		
		if(! Permission::check('ADMIN') && $this->request->param('Action') != 'accessdenied' && $this->IsLatestIssue()){
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
