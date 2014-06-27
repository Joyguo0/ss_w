<?php

class BlogEntryExtension extends DataExtension {
	
	private static $db = array(
		'Summary' => 'Text'
	);
	
	private static $has_one = array(
		'Image'				=> 'Image'
	);
	private static $many_many = array(
	);
	
	private static $summary_fields = array(
		'Title' 			=> 'Title',
		'Date' 				=> 'Date'
	);
	
	
	public function updateCMSFields(FieldList $fields) {
		
		$fields->addFieldToTab('Root.Image', UploadField::create('Image','Image'));
		$fields->removeByName("SideBar");
		
		$fields->addFieldToTab('Root.Main', TextareaField::create('Summary', 'Summary')
				->setRows(6)->addExtraClass('stacked'),'Content');
	}
	
	public function PrevNextPage($Mode = 'next') {
	
		if($Mode == 'next'){
			$Direction = "Date:GreaterThan";
			$Sort = "Date ASC";
		}
		elseif($Mode == 'prev'){
			$Direction = "Date:LessThan";
			$Sort = "Date DESC";
		}
		else{
			return false;
		}
		//$dateObject = $this->owner->dbObject('Date');
		$justDate = date('Y-m-d', strtotime($this->owner->Date));
		$list = BlogEntry::get()
		->filter(array(
				'ParentID' => $this->owner->ParentID,
				$Direction => $justDate . date(' H:i:s', strtotime($this->owner->Created))
		))
		->exclude('ID',$this->owner->ID)
		->sort($Sort);
			
		$PrevNext = $list->first();
		//Debug::show($list->sql());
		if ($PrevNext){
			return $PrevNext->Link();
		}
	
	}
}
