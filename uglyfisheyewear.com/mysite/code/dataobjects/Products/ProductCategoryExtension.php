<?php
class ProductCategoryExtension extends DataExtension {
	
	private static $allowed_children = array('ProductCategory');
	
	private static $icon = 'mysite/images/icons/tree';
	
	private static $extensions = array(
			"ExcludeChildren"
	);
	
	private static $excluded_children = array(
			'Product'
	);
	
	private static $db = array (
		'Desc' => 'Text'  //short description for category dropdown	
	);
	
	private static $has_one = array (
	);
	
	//old categories relationship
	private static $many_many = array (
	);
	
	
	public function updateCMSFields(FieldList $fields) {
		
		$fields->addFieldToTab('Root.Main', TextareaField::create('Desc', 'Short Description (appear in dropdown menu)')->setRows(5), 'Content');
		
	}
	
	
	public function MyListboxCrumb($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
		$page = $this;
		$pages = array();
		$crumb = '';
	
		while(
				$page
				&& (!$maxDepth || count($pages) < $maxDepth)
				&& (!$stopAtPageType || $page->ClassName != $stopAtPageType)
		) {
			if($showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
				$pages[] = $page;
			}
	
			$page = $page->Parent;
		}
	
		$i = 1;
		foreach ($pages as $page) {
	
			$crumb .= $page->getMenuTitle();
			if ($i++ < count($pages)) {
				$crumb .= ' > ';
			}
		}
		return $crumb;
	}
	
}



class ProductCategoryControllerExtension extends DataExtension {
	
	
}