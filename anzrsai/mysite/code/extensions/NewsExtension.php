<?php

class NewsExtension extends DataExtension {

	public function onBeforeDelete(){
		
		if(!$this->owner->DoDeleteOnce){
			$this->owner->DoDeleteOnce = true;
			$this->owner->doUnpublish();
		}
		
	
	}
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	
		if(!$this->owner->ParentID){
			$parent = NewsHolder::get()->First();
			if($parent){
				$this->owner->setField('ParentID', $parent->ID);
			}
		}
		//$this->setField('Date',$this->getField('Date') . date(' H:i:s', strtotime('now')));
		//Debug::show($this->getField('Date') . date(' H:i:s', strtotime('now')));
		$mydatetime = date('Y-m-d', strtotime($this->owner->getField('Date'))) . date('H:i:s', strtotime('now'));
		$this->owner->setField('Date', date('Y-m-d H:i:s', strtotime($mydatetime)));
	
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
		$list = News::get()
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
