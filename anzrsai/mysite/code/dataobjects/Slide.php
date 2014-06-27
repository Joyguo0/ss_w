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
		"LinkTo" 			=> "SiteTree",
		'CenterImage'		=> 'Image',
		'BackgroundImage'	=> 'Image'
	);
	
	private static $belongs_many_many = array(
		'Pages'  		=> 'Page',
		'SiteConfigs'	=> 'SiteConfig'
	);

	private static $summary_fields = array(
		'CenterImage.CMSThumbnail' 	 => 'CenterImage',
		'BackgroundImage.CMSThumbnail' 	 => 'BackgroundImage',
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
		$fields->addFieldToTab('Root.Main', UploadField::create('CenterImage','Center Image')
			->setFolderName('Uploads/Slides')
		);
		$fields->addFieldToTab('Root.Main', UploadField::create('BackgroundImage', 'Background Image')
				->setFolderName('Uploads/Slides')
		);
		$fields->addFieldToTab('Root.Main', TextareaField::create('Content', 'Content')
			->setRows(10) 
		);
		
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

	function redirectionLink() {
		if($this->RedirectionType == 'External'){
			if($this->ExternalURL){
				return $this->ExternalURL;
			}
		}elseif($this->RedirectionType == 'Internal'){
			$linkTo = $this->LinkToID ? DataObject::get_by_id("SiteTree", $this->LinkToID) : null;
			
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