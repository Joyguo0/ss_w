<?php
/**
 *
 */
class DownloadsPage extends Page {
	
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $has_many = array(
    	'DownloadFiles' => 'DownloadFile'
	);
	
	public function DownloadFiles(){
		return $this->owner->getComponents('DownloadFiles')->sort('Sort');
	}
	
	public function getCMSFields(){
		
		$fields = parent::getCMSFields();

		/*************************************** Plans ****************************************/
		$DownloadFilesConfig = GridFieldConfig_RelationEditor::create()
			->addComponent(new GridFieldSortableRows('Sort'));
		$DownloadFilesSections = GridField::create( 'DownloadFiles','DownloadFiles', $this->DownloadFiles(), $DownloadFilesConfig );
		$fields->addFieldToTab('Root.DownloadFiles', $DownloadFilesSections);
		
		return $fields;
	}

}

class DownloadsPage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
}
