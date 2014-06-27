<?php
/**
 * Copies resources from another location on the server and links them to resource
 * objects.
 */



class MigrationPublicationsTask extends BuildTask {
	
	static $allowed_extensions = array(
		'','ace','arc','arj','asf','au','avi','bmp','bz2','cab','cda','css','csv','dmg','doc','docx',
		'flv','gif','gpx','gz','hqx','htm','html','ico','jar','jpeg','jpg','js','kml', 'm4a','m4v',
		'mid','midi','mkv','mov','mp3','mp4','mpa','mpeg','mpg','ogg','ogv','pages','pcx','pdf','pkg',
		'png','pps','ppt','pptx','ra','ram','rm','rtf','sit','sitx','swf','tar','tgz','tif','tiff',
		'txt','wav','webm','wma','wmv','xhtml','xls','xlsx','xml','zip','zipx',
	);

	protected $title = 'Migration -- Publications Task';
	
	protected $FSConnector;
	
	protected $FSDBconfig = array(
		'type' => 'MySQLDatabase',
		'server' => 'localhost',
		'username' => 'anzrsai',
		'password' => 'mere4yet8adverb',
		'database' => 'anzrsai'
	);

	public function run($request) {
		
		
		
		
		
// 		die;C
		
		
		//migration is done!!! don't run this task anymore
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		increase_time_limit_to();
		
		$FSsystemPath = dirname(__FILE__) . '/documents/system/';
		$NewFilesPath = dirname(__FILE__) . '/documents/new-files/';
		$SSFileDefaultPath = 'Uploads/PublicationChapter';
		
		$FSConnector = new DBConnector($this->FSDBconfig);
		$this->FSConnector = $FSConnector;
		
		
		$ChapterDataArray = $this->GetChapterDataArray(dirname(__FILE__) . '/chapterdatalist2.csv');
		
// 		Debug::show($ChapterDataArray);die;
		
		//-------------------Phase 1-------------------//
		
		
// 		//copy resource 
//		$newFilesArray = $this->ResourcesMigration($FSsystemPath, $NewFilesPath);
		
// 		//create File dataobject
//		$this->CreateResources($NewFilesPath, $newFilesArray, $SSFileDefaultPath);
		
		
		
		
		//-------------------Phase 2-------------------//
		$done_chapter_no = 0;
		
		
		$AJRS_page_id = 10;	//AJRS = Australasian Journal of Regional Studies
		
		$AJRSdata = $FSConnector->GetBy('page', 'id', $AJRS_page_id);
		
		if($AJRSdata){
			$sub_pages = $FSConnector->query('SELECT * FROM "page" WHERE "parent_id" = '.$AJRS_page_id.' ORDER BY "page"."ordering" DESC ');
			
			$SS_Pub_Cate_Page_id = 51;
			
			foreach ($sub_pages as $FSpage){
				
				$year 	= 0;
				$vol	= 0;
				$issue	= 0;
				
				$title_break = explode(' ', $FSpage['title']);
				
				//find year 
				if(is_numeric($title_break[0])){
					$year = $title_break[0];
				}elseif($FSpage['id'] == '117'){
					$year = 2006;
				}else{
					echo "can't year for fs page id = {$FSpage['id']} -- {$FSpage['title']}" . '<br><br><br>';
					continue;
				}
				
				//find volume
				$vol_key = false;
				if($vol_key = array_search('Volume', $title_break)){
				}elseif($FSpage['id'] == '179'){
					$vol = 19;
				}elseif ($vol_key = array_search('Vol', $title_break)){
				}elseif ($vol_key = array_search('vol', $title_break)){
				}elseif ($vol_key = array_search('volume', $title_break)){
				}elseif ($vol_key = array_search('Voulme', $title_break)){
				}else{
					echo "can't find volume for fs page id = {$FSpage['id']} -- {$FSpage['title']}" . '<br><br><br>';
					continue;
				}
				
				$vol_key ++;
				if(!$vol && !is_numeric($title_break[$vol_key])){
					echo "volume no. is not int for fs page id = {$FSpage['id']} -- {$FSpage['title']}" . '<br><br><br>';
					continue;
				}elseif(!$vol){
					$vol = $title_break[$vol_key];
				}
				
				
				//find volume
				$issue_key = false;
				if($issue_key = array_search('No', $title_break)){
				}elseif($FSpage['id'] == '145'){
					$issue = 1;
				}elseif ($issue_key = array_search('no', $title_break)){
				}elseif ($issue_key = array_search('Issue', $title_break)){
				}elseif ($issue_key = array_search('issue', $title_break)){
				}elseif ($issue_key = array_search('No.', $title_break)){
				}elseif ($issue_key = array_search('Number', $title_break)){
				}else{
					echo "can't find issue for fs page id = {$FSpage['id']} -- {$FSpage['title']}" . '<br><br><br>';
							continue;
				}
				
				$issue_key ++;
				if(!$issue && !is_numeric($title_break[$issue_key])){
					echo "issue no. is not int for fs page id = {$FSpage['id']} -- {$FSpage['title']}" . '<br><br><br>';
					continue;
				}elseif(!$issue){
					$issue = $title_break[$issue_key];
				}
				
				
				//find or create issue page according to what we found
				$IssuePageDO = $this->FindOrCreateIssue($year, $vol, $issue, $SS_Pub_Cate_Page_id, $FSpage['id']);
				
				//check chapters
				$fspageid = $IssuePageDO->FSLegacyID;
				if($fspageid && isset($ChapterDataArray[$fspageid]) && count($ChapterDataArray[$fspageid])){
					$ThisChapterData = $ChapterDataArray[$fspageid];
					
					foreach ($ThisChapterData as $chapter){
						
						if(!$chapter['title']){
							continue;
						}
						
						$title			= $chapter['title'];
						$editors 		= $chapter['editors'];
						$page_number 	= $chapter['page_number'];
						$fileid 		= $chapter['fileid'];
						
						if(!$title){
							$title = $editors;
						}
						
// 						$ChapterPageDO = PublicationChapter::get()->filter(array(
// 							'Title' => $title
// 						))->first();
						
// 						if(!$ChapterPageDO){
							$FileDO = File::get()->filter(array('FSLegacyID' => $fileid))->first();
							
							if($FileDO && $FileDO->ID){
								$fileid = $FileDO->ID;
							}else{
								$fileid = false;
								echo "File not found - FSLegacyID = " . $chapter['fileid'] . '<br><br><br>'; 
							}
							
							$ChapterPageDO = new PublicationChapter();
							$ChapterPageDO->Title		= $title;
							$ChapterPageDO->Editors		= $editors;
							$ChapterPageDO->FileID		= $fileid;
							$ChapterPageDO->PageNumber	= $page_number;
							$ChapterPageDO->IssueID		= $IssuePageDO->ID;
							$ChapterPageDO->ParentID	= $IssuePageDO->ID;
							$ChapterPageDO->write();
							$ChapterPageDO->doPublish();
							
							$done_chapter_no++;
// 						}
					}
				}
			}
		}
		
// 		die;		

		DB::alteration_message("Done. Added $done_chapter_no chapters", 'created');
	}
	
	
	
	public function GetChapterDataArray($CSVfilePath){
		
		//this function is VERY ugly...........
		
		
		$enclosure = '"';
		$delimiterArray = array(",","\t");
		
		$headers 	= array();
		$csv		= array();
		
		foreach ($delimiterArray as $delimiter){
			//check ',' first
			$rowcount = 0;
			if (($handle = fopen($CSVfilePath, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, $delimiter, $enclosure)) !== FALSE) {
					$num = count($data);
					//echo "<p> $num fields in line $rowcount: <br /></p>\n";
					//there must be more than 3 fields. if it's equal to one return error.
					if($rowcount == 0 && $num < 3){
						break;
					}
		
					$rowcount++;
						
					$row = array();
						
					if($rowcount == 1){
						if(count($headers) > 3){
							$rowcount = 0;
							break;
						}else{
							for ($c=0; $c < $num; $c++) {
								$headers[] = $data[$c];
							}
						}
					}else{
						for ($c=0; $c < $num; $c++) {
							$headerValue 		= $headers[$c];
							$row[$headerValue] 	= $data[$c];
						}
		
						$csv[] = $row;
					}
				}
			}
			fclose($handle);
		}
		
		$count = 0;
		
		$all_result = array();
		
		$grouped_results = array();
		
		$currentID = 0;
		
		foreach($csv as $row) {
			
			if(!isset($row['fspageid'])){
				continue;
			}
			
			if(!$row['fspageid']){
				continue;
			}
			
			
			if($row['fspageid'] != $currentID){
				if($currentID){
					$all_result[$currentID] = $grouped_results;
				}
				
				$currentID = $row['fspageid'];
				$grouped_results = array();
				
			}
			
			$grouped_results[] = $row;
			$count++;
			
		}
		
		if(!empty($grouped_results)){
			$all_result[$currentID] = $grouped_results;
		}
		
		return $all_result;
	}

	

	public function ResourcesMigration($FSsystemPath, $NewFilesPath){
		$FSConnector = $this->FSConnector;

		//copy all files to new location.
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($FSsystemPath),
				RecursiveIteratorIterator::SELF_FIRST);
		
		$newFilesArray = array();
		
		foreach ($iterator as $name => $object){
			if (!$object->isDir()){
				$fileName = $object->getBasename();
				$cleanFileName = $this->CleanWord($fileName);
					
				//str_replace($fileName, $cleanFileName, $name);
		
// 				echo "File " . "$name \n";
					
				
				$last = strrpos($name, "/");
				$next_to_last = strrpos($name, "/", $last - strlen($name) - 1);
					
				$diff = $last - ($next_to_last + 1);
					
				$folder = substr($name, ($next_to_last + 1), $diff);
				$id = substr($folder, 1);
				
				//check if its under windows
				if(!intval($id) && strpos($name, "\\") !== false){
					$last = strrpos($name, "\\");
					$next_to_last = strrpos($name, "\\", $last - strlen($name) - 1);
						
					$diff = $last - ($next_to_last + 1);
						
					$folder = substr($name, ($next_to_last + 1), $diff);
					$id = substr($folder, 1);
				}
					
// 				echo "Folder " . "$folder \n";
// 				echo "ID " . "$id \n";
					
				//now we need to move the file to into the parent of this folder
				if($folder != null && substr($folder, 0, 1) == 'o')
				{
		
					$oldpath = $object->__toString();
					$newPath = $NewFilesPath . $id . "." . $cleanFileName;
		
// 					echo "OLD Folder " . "$oldpath \n";
// 					echo "NEW Folder " . "$newPath \n";
		
					if(!file_exists($newPath)){
						copy($oldpath, $newPath);
					}
		
					$newFilesArray[$id]['name'] = $cleanFileName;
					$newFilesArray[$id]['path'] = $newPath;
				}
			}
		}
		
		return $newFilesArray;
		
	}
	
	public function CleanWord($title){
		$title = str_replace(' ', '-',$title);
		$title = preg_replace('/[^a-zA-Z0-9\.]/','',$title);
		//$title = str_replace("/", "\/", $title);
		//$title = str_replace(">", "", $title);
		//$title = str_replace("<", "", $title);
		//$title = str_replace("|", "", $title);
		//$title = str_replace(":", "", $title);
		//$title = str_replace("&", "", $title);
		//$title = str_replace(" ", "-", $title);
		//$title = str_replace("(", "", $title);
		//$title = str_replace(")", "", $title);
		//$title = str_replace("@", "", $title);
		//$title = str_replace("#", "", $title);
		//$title = str_replace("%", "", $title);
		//$title = str_replace("[", "", $title);
		//$title = str_replace("]", "", $title);
		//$title = str_replace("{", "", $title);
		//$title = str_replace("}", "", $title);
		//$title = str_replace("!", "", $title);
		//$title = str_replace("_", "", $title);
	
		return $title;
	}
	
	
	
	public function CreateResources($NewFilesPath, $newFilesArray, $SSFileDefaultPath){
		$FSConnector = $this->FSConnector;
		
		$lib = $FSConnector->query('SELECT * FROM "lib"');
		
		$folder = Folder::find_or_make($SSFileDefaultPath);
		
		$copied = 0;
		$skipped = 0;
		
		foreach($lib as $legFile){
			$id 			= (int) $legFile['id'];
			$title  		= $legFile['title'];
			$leg_folder_id  = $legFile['folder_id'];
				
			if(!isset($newFilesArray[$id])){
				$skipped++; continue;
			}
			$name	  		= $newFilesArray[$id]['name'];
				
			$type = $legFile['mime_type'];
			$type = substr($type, 0, strpos($type, "/"));
				
			//			echo $id . " " . $title . " " . $type . " </br>";
			//need to check file with same legacy id doesnt exist
			if(DataObject::get_one('File', "\"ClassName\" = 'File' AND \"FSLegacyID\" = $id"))
			{
				continue;
			}
				
			if($type == 'image')
				$file = new Image();
			else
				$file = new File();
		
			$file->ParentID 	= $folder->ID;
			$file->Title    	= $title;
			$file->FSLegacyID 	= $id;
			$file->Name     	= $id . '-' . $name;
			$ext = strtolower($file->getExtension());
			
			$newPath = $file->getFullPath();
			
			if(in_array($ext, self::$allowed_extensions) && !file_exists($newPath)) {
				$file->write();
			}else {
				$skipped++; continue;
			}
			
				
			if (copy($newFilesArray[$id]['path'], $newPath))
				$copied++;
			
			
			echo $newFilesArray[$id]['path'] . " ---------------- " . $newPath . " </br></br></br>";
		}
		
	}
	
	
	public function FindOrCreateIssue($year, $vol, $issue, $SS_Pub_Cate_Page_id, $issueLegacyID){
		//find volume
		$volumePageDO = PublicationVolume::get()->filter(array(
			'VolumeNumber' 	=> $vol,
			'Year' 			=> $year,
			'ParentID' 		=> $SS_Pub_Cate_Page_id
		))->first();
		
		if(!$volumePageDO){
			$volumePageDO = new PublicationVolume();
			$volumePageDO->VolumeNumber	= $vol;
			$volumePageDO->Year			= $year;
			$volumePageDO->ParentID		= $SS_Pub_Cate_Page_id;
			$volumePageDO->CategoryID	= $SS_Pub_Cate_Page_id;
			$volumePageDO->write();
			$volumePageDO->doPublish();
		}
		
		
		//find issue
		$IssuePageDO = PublicationIssue::get()->filter(array(
			'IssueNumber' 	=> $issue,
			'ParentID' 		=> $volumePageDO->ID
		))->first();
		
		if(!$IssuePageDO){
			$IssuePageDO = new PublicationIssue();
			$IssuePageDO->IssueNumber	= $issue;
			$IssuePageDO->ParentID		= $volumePageDO->ID;
			$IssuePageDO->VolumeID		= $volumePageDO->ID;
			$IssuePageDO->FSLegacyID	= $issueLegacyID;
			$IssuePageDO->write();
			$IssuePageDO->doPublish();
		}
		
		
		return $IssuePageDO;
	}
	
	
	
}