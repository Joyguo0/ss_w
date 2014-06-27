<?php
/**
 *
 */
class PublicationVolume extends Page {
	
	private static $singular_name = 'Volume';
	
	private static $plural_name = 'Volume';
	
	private static $allowed_children = array('PublicationIssue');
	
	private static $db = array(
		'VolumeNumber' 	=> 'Int',
		'Year' 			=> 'varchar(64)'
	);
	
	private static $defaults = array(
		'PageBannersSource' => 'Hide'
	);
	
	private static $has_one = array(
		'Category' => 'PublicationCategory'
	);
	
	private static $has_many = array(
		'Issues' => 'PublicationIssue'
	);
	
	private static $summary_fields = array(
		"Year"			=> "Year",
		'VolumeNumber'	=> 'VolumeNumber',
		"Status"		=> "Status",
		'Issues.Count'	=> 'Number Of Issues'
	);
	
	private static $field_labels = array(
		'VolumeNumber' => 'Volume Number',
		'Year' => 'Year'
	);
	
	private static $searchable_fields = array(
		'VolumeNumber'
		// leaves out the 'Price' field, removing it from the search
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', $year = TextField::create('Year','Year'), 'Content');
		//$year->setConfig('showcalendar', true);
		//$year->setConfig('dateformat', 'YYYY');
		$fields->addFieldToTab('Root.Main', TextField::create('VolumeNumber','Volume Number'), 'Content');
		
		
		$CategorysMap = PublicationCategory::get()->map()->toArray();
		$fields->addFieldToTab('Root.Main',  DropdownField::create('CategoryID','Category',$CategorysMap), 'Content');
		
		if($this->ID){
			$IssueConfig = GridFieldConfig_RecordEditor::create();
			$IssueConfig->addComponent(new GridFieldSortableRows('Sort'));
			$IssueField = new GridField('Issue', 'Issue', $this->Issues()->sort('"Sort" ASC'), $IssueConfig);
			$fields->addFieldToTab("Root.Main", $IssueField, 'Metadata');
		}else{
			$fields->addFieldToTab("Root.Main", HeaderField::create('IssueMSG', 'Issues can be added after volume is created.'), 'Metadata');
		}
		
		if(!$this->ID){
			$fields->removeByName("URLSegment");
		}
		
		$fields->removeByName("Title");
		$fields->removeByName("MenuTitle");
		$fields->removeByName("Resources");
		$fields->removeByName("Slideshow");
		$fields->removeByName("SideBar");
		$fields->removeByName("Content");
		
		return $fields;
	}
	
	public function getCustomSearchContext() {
		
 		//$fields = $this->scaffoldSearchFields(array('restrictFields' => array('VolumeNumber')));
 		
		$fields = '';
		//$fields->push($this->scaffoldSearchFields(array('restrictFields' => array('Year'))));
		
		$filters = array(
				'VolumeNumber' => new PartialMatchFilter('VolumeNumber')
		);
		return new SearchContext(
				$this->class,
				$fields,
				$filters
		);
	}
	
	public function getSearchThis(){
		return  $this;
	}
	
	public function  getIssueAndVolume(){
	
		$publication = new ArrayList();
		$DOBJ = '';
				
		$issueList = PublicationIssue::get()->filter('ParentID', $this->ID);
		foreach ($issueList as $issue){
			$issue->issuenewTitle = $this->Title ." ".$issue->Title;

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
		
		$this->setField('Title',$this->Year." Volume ".$this->VolumeNumber);
		$this->setField('MenuTitle',$this->Year." Volume ".$this->VolumeNumber);
		$this->setField('URLSegment',$this->Year."-Volume-".$this->VolumeNumber);

		$this->ParentID = $this->CategoryID;
		
		//create default year if user doesnt define it
		if(!$this->Year){
			$this->setField('Year', date("Y"));
		}else{
			$this->setField('Year', substr($this->Year, 0, 4));
		}
		
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
		if(!$this->DoingUnpublish){
			$this->DoingUnpublish = true;
			$this->doUnpublish();
		}
	}
	
	public function LoadCategoryID(){
		return $this->CategoryID;
	}
	
}

class PublicationVolume_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
		$childenDL = $this->Children();
		
		if($childenDL && $childenDL->Count()){
			$issuePageDO = $childenDL->first();
			return $this->redirect($issuePageDO->Link());
		}
		
	}
	
}
