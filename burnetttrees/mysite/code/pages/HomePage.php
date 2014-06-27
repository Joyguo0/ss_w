<?php
/**
 *
 */
class HomePage extends Page {
	
	public static $icon = 'mysite/images/icons/homepage';
	
	private static $db = array(
		"SideBarTitle"		=> "Varchar(255)",
		"SideBarContent"	=> "HTMLText",
		'MapArea'			=> 'HTMLText',
	);
	
	private static $has_one = array(
		'SidebarLink1' => 'Link',
		'SidebarLink2' => 'Link',
		'MapAreaImage' => 'Image'
	);
	
	private static $has_many = array(
		'HomeLinks' => 'HomeLink'
	);
	
	public function getCMSFields(){
		
		
		$fields = parent::getCMSFields();
		
		$fields->removeByName('SideBar');
		
		$fields->addFieldToTab('Root.Slideshow', HeaderField::create('HomeLinks', 'Links on LHS'));
		$LinksConfig = GridFieldConfig_RelationEditor::create();
		$LinksSections = GridField::create('HomeLinks','HomeLinks', $this->HomeLinks(), $LinksConfig );
		$fields->addFieldToTab('Root.Slideshow', $LinksSections);
		
		/************************************ Middle Section**********************************************/
		$fields->addFieldToTab('Root.MiddleSection', TextField::create('SideBarTitle', 'SideBar Title'),'Content');
		$fields->addFieldToTab('Root.MiddleSection', HtmlEditorField::create('SideBarContent', 'SideBar Content')->setRows(6),'Content');
		
		$fields->addFieldToTab('Root.MiddleSection', HeaderField::create('SidebarLinks', 'Middle Links'));
		$fields->addFieldToTab('Root.MiddleSection', LinkField::create("SidebarLink1ID", "Middle Link 1"));
		$fields->addFieldToTab('Root.MiddleSection', LinkField::create("SidebarLink2ID", "Middle Link 2"));
		/**************************************************************************************/
		
		
		/************************************ Map Area **********************************************/
		$fields->addFieldToTab('Root.MapArea', UploadField::create('MapAreaImage')->setFolderName('Uploads/Logo'));
		$fields->addFieldToTab("Root.MapArea", new HtmlEditorField('MapArea','MapArea'));
		/**************************************************************************************/
		
		return $fields;
	}
}

class HomePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
		
	}
	
	public function TestLinkss(){
		$testvalue = $this->SidebarLink1();
		Debug::show($testvalue);
	}
}
