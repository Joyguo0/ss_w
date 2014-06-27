<?php

class NewsletterExtension extends DataExtension {

	private static $db = array (	
	);
	private static $has_one = array (
		'HeadLink' => 'Link',
		'Toplogo' => 'Image'
	);
	
	private static $has_many = array (
		"NewsletterStorys" => "NewsletterStory"
	);
	
	private static $many_many = array (
		'RelatedProducts' => 'Product' 
	);
	
	private static $belongs_many_many = array (
		'RelatedProducts' => 'Product'
	);

	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldsToTab ( "Root.Main",UploadField::create( 'Toplogo' )->setFolderName('Uploads/Logo'));
		$fields->addFieldToTab ( 'Root.Main', LinkField::create ( 'HeadLinkID', 'Head Link' ) );
		
		if($this->owner->exists()){
			
			$RelatedProducts = GridFieldConfig_RelationEditor::create()
				->addComponent(new GridFieldOrderableRows('Sort'))
				->addComponent(new GridFieldManyRelationHandler());
			
			$fields->addFieldToTab('Root.RelatedProducts', 
									GridField::create( 
											'RelatedProducts',
											'Related Product',
											$this->owner->RelatedProducts(), 
											$RelatedProducts 
									)
			);
			
		}
		$NewsletterStorySections = GridField::create ( 'NewsletterStorys', 'NewsletterStorys', $this->owner->NewsletterStorys(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.NewsletterStorys', $NewsletterStorySections );
	
	}
	

	
	//************ Category controller ********************//
	public function AllProductCategories($forMenu = true) {
		$ProductListPageDO = ProductListPage::get ()->first ();
	
		$CategoriesDOS = ProductCategory::get ()->filter ( array (
				'ParentID' => $ProductListPageDO->ID
		) );
	
		$categoryArray = array ();
	
		if ($forMenu === true && $CategoriesDOS && $CategoriesDOS->Count ()) {
			$newLink = new DataObject();
			$newLink->SppMenuTitle = 'New';
			$newLink->Children = false;
			$newLink->Link = $ProductListPageDO->Link( 'newproduct' ); // check
	
			$saleLink = new DataObject ();
			$saleLink->SppMenuTitle = 'Sale';
			$saleLink->Children = false;
			$saleLink->Link = $ProductListPageDO->Link( 'sale' );
	
			// add 'New' link as first one
			$categoryArray[] = $newLink;
	
			foreach ( $CategoriesDOS as $CategoriesDO ) {
				if (strcasecmp ( $CategoriesDO->Title, 'lifestyle' ) == 0) {
					$categoryArray[] = $CategoriesDO;
				}
	
				if (strcasecmp ( $CategoriesDO->Title, 'range' ) == 0) {
					$RangeChildrenDOS = $CategoriesDO->Children();
	
					if ($RangeChildrenDOS && $RangeChildrenDOS->Count()) {
						foreach ( $RangeChildrenDOS as $RageCateDO ) {
							$categoryArray[] = $RageCateDO;
						}
					}
				}
			}
	
			// add 'Sale' link as last one
			$categoryArray [] = $saleLink;
	
			$CategoriesDOS = new ArrayList ( $categoryArray );
		}
	
		return ! empty ( $categoryArray ) ? $CategoriesDOS : false;
	}

	public function isMainSite() {
		return ! Subsite::currentSubsiteID();
	}
	
	
}
