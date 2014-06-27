<?php
/**
 *
 */
class ViewLatestChapter extends Page {
	
	public static $icon = 'mysite/images/icons/latestchapter';
	
	private static $db = array(
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		return $fields;
	}
	
	public function LatestChapter($num = 10){
		$ChapterList = new ArrayList();
		
		$SortedVolumnIDs = PublicationVolume::get()->sort('"PublicationVolume"."Year" DESC, "PublicationVolume"."VolumeNumber" DESC, "PublicationVolume"."ID" DESC')->map('ID', 'ID')->toArray();
		
		$count = 0;
		
		foreach ($SortedVolumnIDs as $vID){
			$sortedIssuesIDs = PublicationIssue::get()->filter(array('ParentID' => $vID))->sort('"PublicationIssue"."IssueNumber" DESC, "PublicationIssue"."ID" DESC')->map('ID', 'ID')->toArray();
			
			foreach ($sortedIssuesIDs as $issueID){
				$ChapterDL = PublicationChapter::get()->filter(array('ParentID' => $issueID))->sort('"PublicationChapter"."ID" DESC');
				
				if($ChapterDL && $ChapterDL->count()){
					foreach ($ChapterDL as $ChapterDO){
						$ChapterList->push($ChapterDO);
						
						$count++;
						
						if($count >= $num){
							return $ChapterList;
						}
					}
				}
			}
		}
		
		return $ChapterList;
	}
}

class ViewLatestChapter_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
