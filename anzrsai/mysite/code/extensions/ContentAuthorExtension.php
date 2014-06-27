<?php
class ContentAuthorExtension extends DataExtension {
	
	public function canView($member) {
	
		if(is_int($member)){
			$member = Member::get()->byID($member);
		}
	
		$member = $member ? $member : Member::currentUser();
		
		if( ! $member){
			return null;
		}
	
		return $member->inGroup(1) ? true : null ;
	
	}

	
	public function canEdit($member) {
		
		if(is_int($member)){
			$member = Member::get()->byID($member);
		}
		
		$member = $member ? $member : Member::currentUser();
		
		if( ! $member){
			return null;
		}
		
		return $member->inGroup(1) ? true : null ;
		
	}
	
	
	public function canDelete($member) {

		if(is_int($member)){
			$member = Member::get()->byID($member);
		}
		
		$member = $member ? $member : Member::currentUser();
		
		if( ! $member){
			return null;
		}
		
		return $member->inGroup(1) ? true : null ;
		
	}
	
	
	public function canCreate($member) {
		
		if(is_int($member)){
			$member = Member::get()->byID($member);
		}
		
		$member = $member ? $member : Member::currentUser();
		
		if( ! $member){
			return null;
		}
		
		return $member->inGroup(1) ? true : null ;
		
	}
	
}