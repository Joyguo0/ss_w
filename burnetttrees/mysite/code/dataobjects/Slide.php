<?php

class Slide extends DataObject {
	
	private static $db = array(
		'Title' 			=> 'Varchar(255)',
		'Content'    		=> 'HTMLText',
		"RedirectionType" 	=> "Enum('Internal,External,Nolink','Nolink')",
		"ExternalURL" 		=> "Varchar(255)",
	);

	private static $defaults = array(
		'RedirectionType' => 'Nolink'
	);

	private static $has_one = array(
		"LinkTo" 		=> "SiteTree",
		'Image'			=> 'Image'
	);
	
	private static $belongs_many_many = array(
		'Pages'  		=> 'Page',
		'SiteConfigs'	=> 'SiteConfig'
	);

	private static $summary_fields = array(
		'Image.CMSThumbnail' 	 => 'Image',
	    'Title' 				 => 'Title',
	    'redirectionLink' 	     => 'Link'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('SiteConfigs');
		$fields->removeByName('Pages');
		
		$fields->addFieldToTab('Root.Main', TextField::create('Title'));
		
		$fields->addFieldToTab('Root.Main', OptionsetField::create(	
			"RedirectionType", 
			"Link to",
			array(	
				"Nolink" 	=> "No Link",
				"Internal" 	=> "A page on your website",
				"External" 	=> "Another website"
			),
			"Internal"
		));
		
		$fields->addFieldToTab('Root.Main', TreeDropdownField::create("LinkToID", "Page on your website","SiteTree")
			->displayIf("RedirectionType")->isEqualTo("Internal")->end() 
		);
		$fields->addFieldToTab('Root.Main',TextField::create("ExternalURL", "Other website URL")
			->displayIf("RedirectionType")->isEqualTo("External")->end() 
		);
		$fields->addFieldToTab('Root.Main', UploadField::create('Image')
			->setFolderName('Uploads/Slides')
		);
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content', 'Content'));
		
		return $fields;
	}

	public function onBeforeWrite(){

		$links = array('ExternalURL');

		foreach ($links as $name) {
			$link = $this->$name;

			if ($link && strpos($link, '://') === false) {
				$this->$name = "http://$link";
			}
		}

		parent::onBeforeWrite();
	}
	
	// this function creates the thumnail for the summary fields to use
	public function getThumbnail() { 
		return $this->Image()->CMSThumbnail();
	}

	function redirectionLink() {
		if($this->RedirectionType == 'External'){
			if($this->ExternalURL){
				return $this->ExternalURL;
			}
		}elseif($this->RedirectionType == 'Internal'){
			$linkTo = $this->LinkToID ? SiteTree::get()->byID($this->LinkToID) : null;
			
			if($linkTo){ 
				return $linkTo->Link();
			}
		}else{
			return 'javascript:void(0)';
		}
	}
	
	function TargetAttr(){
		if($this->RedirectionType == 'External'){
			return 'target="_blank" rel="nofollow"';
		} else {
			return '';
		}
	}
	
	function StyleAttr(){
		if($this->RedirectionType == 'Nolink'){
			return 'style="cursor:default;"';
		} else {
			return '';
		}
	}
	
}