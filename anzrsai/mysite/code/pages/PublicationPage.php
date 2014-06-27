<?php
/**
 *
 */
class PublicationPage extends Page {
	
	public static $icon = 'mysite/images/icons/publicationpage';
	
	private static $allowed_children = array('PublicationCategory','*Page','SubscriptionPage','RedirectorPage', 'NewslettersListingPage');
	
	private static $extensions = array(
		"ExcludeChildren"
	);
	
	private static $excluded_children = array(
		'PublicationVolume'
	);
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
	);
	
	private static $defaults = array(
		'PageBannersSource' => 'Hide'
	);
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();
		
		
		return $fields;
	}

}

class PublicationPage_Controller extends Page_Controller {
	
	protected $year;
	private static $allowed_actions = array('archive','MySearchForm','MydoSearch');
	public static $url_handlers = array(
			'archive/$Year'		=> 'archive',
			'archive'			=> 'archive'
	);
	
	public function init() {
		parent::init();
		
	}
	
	public function archive($request){
		$year = (int) $request->param('Year');
	
		if($year){
			$this->year = $year;
		}else{
			$this->year = date('Y');
		}
	
		$page = new Page();
		$page->Title 	 	 = 'archive';
		$page->MenuTitle 	 = 'archive';
		$this->extracrumbs[] = $page;
	
		$data = array(
				'Title' 	=> $this->year . ' Publication Volume',
				'Content' 	=> ''
		);
	
		return $this->customise($data)->renderWith(array('Publication_archive', 'Publication', 'Page'));
	}
	
	public function ArchiveVolumes(){
		$Volums = PublicationVolume::get()->where(sprintf(' "Year" = \'%s\' ', $this->year));
		//Debug::show($Volums);
		return $Volums;
	}
	
	public function Years() {
		$set   = new ArrayList();
		$year  = DB::getConn()->formattedDatetimeClause('"Date"', '%Y');
		
		//Debug::show($year);
		
		$query = new SQLQuery();
		$query->setSelect("DISTINCT Year")->addFrom('"PublicationVolume"');
		$query->setOrderBy('"Year" DESC');
	
		$years = $query->execute()->column();
	
		if (!in_array(date('Y'), $years)) {
			array_unshift($years, date('Y'));
		}
	
		foreach ($years as $year) {
			$set->push(new ArrayData(array(
					'Year'    => $year,
					'Link'    => $this->Link("archive/" . $year . "/"),
					'Current' => $year == $this->year
			)));
		}
	
		return $set;
	}
	
	public function MySearchForm(){
		
		$FormArray = array(
			'Keywords' => 'Keywords',
			'Editors' => 'Editors',
			'VolumeNumber' => 'Volume Number',
			'IssueNumber' => 'Issue Number',
			'ChapterTitle' => 'Chapter Title',

		);
		
		$fields = new FieldList(
			new TextField('SearchText',''),
			new DropdownField("SearchName",'',$FormArray)
		);
		
		$actions = new FieldList(
			new FormAction('MydoSearch','Search')
		);
		
		$form = new Form($this, 'MySearchForm', $fields, $actions);
		return $form;
	}
	public $SearchEnum = 0;
	public function MydoSearch($data, $form) {
		
		$SearchName = $data['SearchName'];
		$SearchText = $data['SearchText'];
		
		
		if ($SearchName == 'VolumeNumber') {
			$Result = PublicationVolume::get()->where(sprintf(' "VolumeNumber" like \'%%%s%%\' ', $SearchText));
		}
		
		if ($SearchName == 'Editors') {
			$Result = PublicationChapter::get()->where(sprintf(' "Editors" like \'%%%s%%\' ', $SearchText));
		}
		
		if ($SearchName == 'IssueNumber') {
			$Result = PublicationIssue::get()->where(sprintf(' "IssueNumbers" like \'%%%s%%\' ', $SearchText));
		}
		
		if ($SearchName == 'ChapterTitle') {
			$Result = PublicationChapter::get()->where(sprintf(' "PublicationChapter"."Title" like \'%%%s%%\' ', $SearchText));
		}
		
		if ($SearchName == 'Keywords') {

			$ResultID_array = array();
			
			$SS_Volumes = DB::query("
				SELECT SiteTree.ID,SiteTree.Created FROM PublicationVolume left join SiteTree on
				SiteTree.ID = PublicationVolume.ID
				where VolumeNumber like '%".$SearchText."%'
				order by SiteTree.Created DESC
			");
			$SS_Issues = DB::query("
				SELECT SiteTree.ID,SiteTree.Created FROM PublicationIssue left join SiteTree on
				SiteTree.ID = PublicationIssue.ID
				where IssueNumber like '%".$SearchText."%'
				order by SiteTree.Created DESC
			");
			$SS_Chapters = DB::query("
				SELECT SiteTree.ID,SiteTree.Created FROM PublicationChapter left join SiteTree on
				SiteTree.ID = PublicationChapter.ID
				where PublicationChapter.Title like '%".$SearchText."%'
				order by SiteTree.Created DESC
			");
			$enum = 0;
			foreach ($SS_Volumes as $Row) {
				$array_id_Created[$enum]['Created'] = strtotime($Row['Created']);
				$array_id_Created[$enum]['ID'] = intval($Row['ID']);
				$array_id_Created[$enum]['Class'] = "Volume";
				$enum++;
			}
			foreach ($SS_Issues as $Row) {
				$array_id_Created[$enum]['Created'] = strtotime($Row['Created']);
				$array_id_Created[$enum]['ID'] = intval($Row['ID']);
				$array_id_Created[$enum]['Class'] = "Issue";
				$enum++;
			}
			foreach ($SS_Chapters as $Row) {
				$array_id_Created[$enum]['Created'] = strtotime($Row['Created']);
				$array_id_Created[$enum]['ID'] = intval($Row['ID']);
				$array_id_Created[$enum]['Class'] = "Chapter";
				$enum++;
			}
			//if result array ID is empty  return
			if(empty($array_id_Created)) {
				$data = array(
						'Results' => "",
						'Query' => $SearchText,
						'Title' => 'Search Results'
				);
				return $this->customise($data)->renderWith(array('PublicationPage_results', 'Page'));
			}
			
			//sort to ID
			$res_id_Created = $this->array_sort($array_id_Created,'ID','desc');		
			foreach ($res_id_Created as $key => $value){
					
				//if class == Volum IDlist add self and all children
				if($res_id_Created[$key]['Class'] == 'Volume'){
			
					$ResultID_array[$this->SearchEnum] = intval($res_id_Created[$key]['ID']);
					$this->SearchEnum++;
					$Issue_Rows = DB::query("
					SELECT SiteTree.ID,SiteTree.Created FROM SiteTree
					where ParentID = ".intval($res_id_Created[$key]['ID'])."
					order by SiteTree.Created DESC
				");
					foreach($Issue_Rows as $Issue_Row) {
						$ResultID_array[$this->SearchEnum] = intval($Issue_Row['ID']);
						$this->SearchEnum++;
						$Chapter_Rows = DB::query("
						SELECT SiteTree.ID,SiteTree.Created FROM SiteTree
						where ParentID = ".$Issue_Row['ID']."
						order by SiteTree.Created DESC
					");
						foreach($Chapter_Rows as $Chapter_Row) {
							$ResultID_array[$this->SearchEnum] = intval($Chapter_Row['ID']);
							$this->SearchEnum++;
						}
						$this->SearchEnum++;
					}
					$this->SearchEnum++;
				}
					
				//if class == Issue IDlist add self and all children
				if($res_id_Created[$key]['Class'] == 'Issue'){
			
					$ResultID_array[$this->SearchEnum] = intval($res_id_Created[$key]['ID']);
					$this->SearchEnum++;
					$Chapter_Rows = DB::query("
					SELECT SiteTree.ID,SiteTree.Created FROM SiteTree
					where ParentID = ".intval($res_id_Created[$key]['ID'])."
					order by SiteTree.Created DESC
				");
					foreach($Chapter_Rows as $Chapter_Row) {
						$ResultID_array[$this->SearchEnum] = intval($Chapter_Row['ID']);
							
						$this->SearchEnum++;
					}
			
					$this->SearchEnum++;
				}
					
				//if class == Issue IDlist add self
				if($res_id_Created[$key]['Class'] == 'Chapter'){
					$ResultID_array[$this->SearchEnum] = intval($res_id_Created[$key]['ID']);
					$this->SearchEnum++;
				}
			}
			
			$i = 0;
			foreach($SS_Volumes as $Row) {
			
				$Volume_Rows[$Row['ID']] = strtotime($Row['Created']);
				$VolumeID_array[] = $Row['ID'];
					
				$Issue_Rows = DB::query("
				SELECT SiteTree.ID,SiteTree.Created FROM SiteTree
				where ParentID = ".$Row['ID']."
				order by SiteTree.Created DESC
			");
				foreach($Issue_Rows as $Issue_Row) {
					$VolumeID_array[] = $Issue_Row['ID'];
					$Chapter_Rows = DB::query("
					SELECT SiteTree.ID,SiteTree.Created FROM SiteTree
					where ParentID = ".$Issue_Row['ID']."
					order by SiteTree.Created DESC
				");
					foreach($Chapter_Rows as $Chapter_Row) {
						$VolumeID_array[] = $Chapter_Row['ID'];
					}
				}
			}
			
			$ResultID_array = array_unique($ResultID_array);
			
			$res_array = new ArrayList();
			foreach ($ResultID_array as $id){
				$res_array->push(SiteTree::get()->byID($id));
			}
			
			
			$Result = $res_array;
		}
		
		$data = array(
				'Results' => $Result,
				'Query' => $SearchText,
				'Title' => 'Search Results'
		);
		
		return $this->customise($data)->renderWith(array('PublicationPage_results', 'Page'));
		
	}
	public function array_sort($arr,$keys,$type='asc'){
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
		return $new_array;
	}

}
