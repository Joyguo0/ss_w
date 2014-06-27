<?php
class ProductListPage extends ProductCategory {
	
    private static $allowed_children = array('ProductCategory');
    
    private static $extensions = array(
  		"ExcludeChildren"
    );
    
    private static $excluded_children = array(
    	'Product'
    );
    
    protected $numberToDisplay = 1;
    
    private static $icon = 'mysite/images/icons/glasses';
    
	private static $default_records = array(
		array(
			'Title' 		=> 'Products',
			'URLSegment' 	=> 'products',
			'ShowInMenus' 	=> false
		)
	);
	
	public function canCreate($member = null){
		return false;
	}
	
	public function canDelete($member = null){
		return false;
	}
	
	public function canDeleteFromLive($member = null){
		return false;
	}

	
	
	
	
}


class ProductListPage_Controller extends ProductCategory_Controller {
	
	private static $allowed_actions = array(
		'newproduct',
		'sale',
		'AjaxGetMore'	
	);
	
	public function newproduct(){
		
		
	}
	
	public function sale(){
	
	
	}	
	
	
	/**
	 * Orverwriting Products. Show all products here.
	 *
	 * @see Page_Controller::Products()
	 * @return FieldList
	 */
	public function Products() {
	
		$limit = self::$products_per_page;
		$orderBy = self::$products_ordered_by;
	
		$products = Product::get()
			->sort($orderBy)
			->leftJoin('ProductCategory_Products', "\"ProductCategory_Products\".\"ProductID\" = \"SiteTree\".\"ID\"");
	
		$list = PaginatedList::create($products, $this->request)
			->setPageLength($limit);
	
		return $list;
	}
	
}