<?php
/**
 *
 */
class News extends Page {
	
	private static $default_sort = '"Date" DESC';
	
	private static $db = array(
		'Date' 				=> 'SS_Datetime',
	    'Author' 			=> 'Text'
	);
	
	private static $has_one = array(
		'Image'	=> 'Image'
	);
	
	private static $summary_fields = array(
		"Date",
		"Status",
		"Title",
		"Parent.Title",
		"Image.CMSThumbnail"
	);
	
	private static $field_labels = array(
		"Parent.Title" => 'Parent page name',
		"Image.CMSThumbnail" => 'Image'
	);
	
	public function populateDefaults(){
		parent::populateDefaults();
		
		$this->setField('Date', date('Y-m-d', strtotime('now')));
		
		$member = Member::currentUser();
		$member = $member ? $member->getName() : "";
		
		$this->setField('Author', $member);
	}
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	
		if(!$this->ParentID){
			$parent = NewsHolder::get()->First();
			if($parent){
				$this->setField('ParentID', $parent->ID);
			}
		}
	
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab("Root.Main", $date = new DateField("Date"),"Content");
		$date->setConfig('showcalendar', true);
		$date->setConfig('dateformat', 'dd/MM/YYYY');
		
		
		$fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Add an image.')
			->setFolderName('Uploads/News'), 'Content');
		
		
		$fields->addFieldToTab('Root.Main', new TextField('Author','Author Name'), 'Content');
		

		return $fields;
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
	
	public function getDateMonth() {
		return date('F', strtotime($this->Date));
	}
}

class News_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
	}
	
}
