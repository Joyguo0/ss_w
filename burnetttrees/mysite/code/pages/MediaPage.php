<?php
class MediaPage extends Page {
	
private static $db = array(
		"RedirectionType" 	=> "Enum('Videos,Images,News','News')",
		"ExternalURL" 		=> "Varchar(255)",
		'Introductory'			=> 'HTMLText'
	);

	private static $defaults = array(
		'RedirectionType' => 'News'
	);

	private static $has_one = array(
		'Image'		=> 'Image'
	);

	

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		//$fields->removeByName('Introductory');
		//$fields->removeByName('MediaPageID');
		
		//$fields->addFieldToTab('Root.Main', TextField::create('Title'));
		
		$fields->addFieldToTab('Root.Main', OptionsetField::create(
			"RedirectionType", 
			"Type",
			array(	
				"News" 		=> "News",
				"Images" 	=> "Images",
				"Videos" 	=> "Videos"
			),
			"News"
		),'Introductory');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Introductory', 'Introductory'), 'Content');
		
		$fields->addFieldToTab('Root.Main',TextField::create("ExternalURL", "Video URL",'Introductory')
			->displayIf("RedirectionType")->isEqualTo("Videos")->end(),'Introductory'
		);
		$fields->addFieldToTab('Root.Main', UploadField::create('Image','Introductory')
			->displayIf("RedirectionType")->isEqualTo("Images")->end(),'Introductory'
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
	
	// this function creates the thumnail for the summary fields to use
	public function getThumbnail() { 
		return $this->Image()->CMSThumbnail();
	}

	function redirectionLink() {
		if($this->RedirectionType == 'Videos'){
			if($this->ExternalURL){
				return $this->ExternalURL;
			}
		}elseif($this->RedirectionType == 'Images'){
			$linkTo = $this->Image() ? $this->Image()->Filename : null;
			//Debug::show($this->Image());
			if($linkTo){ 
				return $linkTo;
			}
		}else{
			return 'javascript:void(0)';
		}
	}
	
	function TargetAttr(){
		if($this->RedirectionType == 'Videos'){
			return 'target="_blank" rel="nofollow"';
		} else {
			return '';
		}
	}
	
	function StyleAttr(){
		if($this->RedirectionType == 'News'){
			return 'style="cursor:default;"';
		} else {
			return '';
		}
	}
	
}

class MediaPage_Controller extends Page_Controller {

	public function init() {
		parent::init();

	}

}