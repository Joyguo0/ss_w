<?php
class ProductExtension extends DataExtension {
	
	private static $db = array (
		'ProductCode' => 'Varchar(255)',
		'ModelNumber' => 'Varchar(255)',
		'WholeSalePrice' => 'Decimal',
		
		'FrameDescription' => 'Varchar(255)',
		'LensDescription' => 'Varchar(255)',
		
		'AntiReflective' => 'Boolean',
		'Prescription' => 'Boolean',
	     
		'PrescriptionStrength' => 'Decimal',
		'Revo' => 'Varchar(255)',
		'Mirror' => 'Varchar(255)',
		'AdditionalDecsription' => 'HTMLText',
		
		'PackingContent' => '',
		
		'IsFreeShipping' => 'Boolean',
		
		// new product setting
		'NewStart' => 'Date',
		'NewEnd' => 'Date',
		
		// sale product setting
		'SaleStart' => 'Date',
		'SaleEnd' => 'Date',
		'SalePrice' => 'Decimal' 
	);
	private static $has_one = array (
		"Newsletter" => "Newsletter"
	);
	private static $has_many = array (
	     'TechSpecsOptions' => 'TechSpecsOption',
		'ProductImages' => 'ProductImage' 
	);
	
	private static $many_many = array (
		'RelatedProducts' => 'Product' 
	);
	
	private static $belongs_many_many = array (
		'RelatedProducts' => 'Product'
	);
	
	private static $summary_fields = array(
		'Amount.Nice' 		=> 'Price',
		'Title' 			=> 'Title',
		'CategoriesNames' 	=> 'Categories',
		'AttrForSummary' 	=> 'TechSpecs'	
	);
	
	private static $searchable_fields = array (
		'Title',
		'Category' => array(
			'field' => 'TextField',
			'filter' => 'ProductCategory_SearchFilter',
			'title' => 'Category'
		),
// 		'TechSpecs' => array(
// 				'field' => 'TextField',
// 				'filter' => 'ProductCategory_SearchFilter',
// 				'title' => 'TechSpecs'
// 		)
	);
	public function updaterequiresVariation(&$attributes){
        $variations=$this->owner->Variations();
        if (!($variations && $variations->exists())){
     	  $attributes=0;
        }
	}
	
	public function contentcontrollerInit($ProductController){
		Requirements::block ( THIRDPARTY_DIR . '/jquery/jquery.js' );
		Requirements::block ( 'swipestripe/javascript/ProductForm.js');
	}
	public function onBeforeWrite(){
		//make sure its under product listing page.
		
		$ProductListingPageDO = ProductListPage::get()->first();
		
		$this->owner->ParentID = $ProductListingPageDO->ID;
		
	}
	
	public function onAfterWrite(){
		
		if(!$this->owner->PageIsWrtingToStage){
			$this->owner->PageIsWrtingToStage = true;
			$this->owner->writeToStage('Stage');
		}
		
		if(!$this->owner->IsDoingPublish && !$this->owner->PageIsWrtingToStage){
			$this->owner->IsDoingPublish = true;
			$this->owner->doPublish();
		}
	
	}
	
	
	public function updateCMSFields(FieldList $fields) {
		$fields->removeByName ( 'ProductCategories' );
		

		// product Images
		$Bulkconfig = new GridFieldBulkUpload();
		$Bulkconfig->setConfig('folderName', 'Uploads/Product');
		
		$PImagesConfig = GridFieldConfig_RelationEditor::create ()			
			->addComponent(new GridFieldOrderableRows('Sort'))
			->addComponent(new GridFieldBulkManager())
			->addComponent($Bulkconfig);
		
		$PImages = GridField::create ( 'ProductImages', 'Product Images', $this->owner->ProductImages (),  $PImagesConfig);
		
		$fields->addFieldToTab ( 'Root.Images', $PImages );
		
		
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
		
		$fields->addFieldToTab ( 'Root.Main',TextField::create ( 'WholeSalePrice' ),'Content');
		$fields->addFieldToTab ( "Root.Main",  DateField::create( "SaleStart" )->setConfig ( 'showcalendar', true )->setConfig ( 'dateformat', 'dd/MM/YYYY' ), "Content" );
		$fields->addFieldToTab ( "Root.Main", $SaleEnd= new DateField ( "SaleEnd" ), "Content" );
		$SaleEnd->setConfig ( 'showcalendar', true );
		$SaleEnd->setConfig ( 'dateformat', 'dd/MM/YYYY' );
		
		$fields->addFieldToTab ( 'Root.Main',TextField::create ( 'SalePrice' ),'Content');
		$fields->addFieldToTab ( "Root.Main",  DateField::create( "NewStart" )->setConfig ( 'showcalendar', true )->setConfig ( 'dateformat', 'dd/MM/YYYY' ), "Content" );
		$fields->addFieldToTab ( "Root.Main",  DateField::create( "NewEnd" )->setConfig ( 'showcalendar', true )->setConfig ( 'dateformat', 'dd/MM/YYYY' ), "Content" );
		
		$TechSpecsOptions = GridField::create ( 'TechSpecsOptions', 'TechSpecsOptions', $this->owner->TechSpecsOptions(), GridFieldConfig_RelationEditor::create () );
		$fields->addFieldToTab ( 'Root.TechSpecsOptions', $TechSpecsOptions );
		return $fields;
	}
	public function IsSale(){
	    $SaleStart=strtotime($this->owner->SaleStart);
	    $SaleEnd=strtotime($this->owner->SaleEnd);
	    $now=time();
	    if(($SaleStart && $SaleEnd && $SaleStart<=$now && $now<$SaleEnd) ||
	    (!$SaleStart && $SaleEnd && $now<$SaleEnd)||
	    (!$SaleEnd && $SaleStart && $now>=$SaleStart)
	    ){
	       return true;
	    } 
	    return false;
	}
	public function IsNewPro(){
	    $NewStart=strtotime($this->owner->NewStart);
	    $NewEnd=strtotime($this->owner->NewEnd);
	    $now=time();
	    if(($NewStart && $NewEnd && $NewStart<=$now && $now<$NewEnd) ||
	    (!$NewStart && $NewEnd && $now<$NewEnd)||
	    (!$NewEnd && $NewStart && $now>=$NewStart)
	    ){
	        return true;
	    }
	    return false;
	}
	public function getUglyPrice(){
        $amount = $this->owner->Amount();
	    if(Member::CurrentUser()&&Member::currentUser()->inGroup('reseller')){
	        $amount->setAmount($this->owner->WholeSalePrice);
	        return $amount->Nice();
	    }
	    if($this->IsSale()){
	        $amount->setAmount($this->owner->SalePrice);
	        return $amount->Nice();
	    }
	    return $this->owner->Price()->Nice();
	        
	}
	
	public function getProductThumbnail() {
		if (! $this->owner->ProductImages ()->count ()) {
			return false;
		}
		
		$SelectedImageDO = $this->owner->ProductImages ()->filter ( array (
				'Thumbnail' => true 
		) )->first ();
		
		if (! $SelectedImageDO) {
			$SelectedImageDO = $this->owner->ProductImages ()->first ();
		}
		
		$ImageDO = $SelectedImageDO->Image ();
		return $ImageDO ? $ImageDO : false;
	}
	
	
	public function CategoriesNames(){
		$categoriesDL = $this->owner->ProductCategories()->sort('"ID" ASC');
		
		$cateNamesArray = array();
		
		if($categoriesDL && $categoriesDL->Count()){
			$cateNamesArray = $categoriesDL->map()->toArray();
		}
		
		return empty($cateNamesArray) ? '' : implode(', ', $cateNamesArray);
	}

	
	public function AttrForSummary(){
		$AttributesDL = $this->owner->Attributes()->sort('"Title" ASC');
		
		$attrStringArray = array();
		
		if($AttributesDL && $AttributesDL->Count()){
			foreach ($AttributesDL as $attrDO){
				$optionsDL = $attrDO->Options();
				
				$optionString = '';
				$optionStringArray=array();
				if($optionsDL && $optionsDL->exists()){
					$optionStringArray = $optionsDL->map()->toArray();
				}
				
				$attrStringArray[] = $attrDO->Title . ' : ' . implode(', ', $optionStringArray);
			}
			
			return '<p>' . implode('<br>', $attrStringArray) . '</p>';
		}
		
		return '';
	}
}
class ProductExtension_Controller extends DataExtension {
	private static $allowed_actions = array(
		'linkProductInfo'
	);
	public static $url_handlers = array(
			'linkProductInfo/$Id'		=> 'linkProductInfo',
	);
	
	public function linkProductInfo($request){
		$ItemDLP=DataObject::get_by_id('Product',$request->latestParam('Id'))->ProductImages();
		$htmlContent = false;
	
		if($ItemDLP && $ItemDLP->Count()){
			foreach ($ItemDLP as $itemDO){
				$htmlContent .= '<li><img src="'.$itemDO->Image()->getURL().'"  data-zoom-image="'.$itemDO->Image()->getURL().'" class="product-image"/></li>';
			}
		}
	
		return Convert::array2json(array('image' =>$htmlContent));

	}
}

