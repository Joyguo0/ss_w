<?php
class PF_ProductCategoryExtension extends DataExtension {
	
	public function contentcontrollerInit($controller){
		//init will called the ProductCategoryControllerExtension->ContentControllerInit();
		$controller->ExtControllerInit();
	}
	
}



class PF_ProductCategoryControllerExtension extends DataExtension {
	
	private static $allowed_actions = array(
	);

	public function ExtControllerInit(){
		
		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('irx-swipestripe-productfilter/javascript/AjaxMore.js');
		
		//on init. set the sort, limit, orderBy
		//this function will be called before the following functions.
		$this->setProductListSort('"Created" DESC');
		
		//init start and length number
		$start = $this->owner->request->getVar('start');
		if( ! $start){
			$start = 0;
		}
		
		//init Page Length
		$data 	= $this->owner->data();
		
		$Length	= 2;
		
		if($data && $data->AjaxNumber){
			$Length = $data->AjaxNumber;
		}
		$this->setProductLimit($start, $Length);

	}
	
	
	public function index(){
		$products = '';
		
		Subsite::$disable_subsite_filter = true;
		
		$list = $this->owner->Products();
		
		$FilterForm = new ProductFilterForm($this->owner, 'ProductFilterForm', $list);
		$FilterForm->disableSecurityToken();
		$list = $FilterForm->getFilteredList();
	
		if($this->owner->request->isAjax()){
			//return products HTML content
			$htmlContent 	= false;
			$nextlink		= false;
			
			if($list && $list->Count()){
				foreach ($list as $itemDO){
					$htmlContent .= $itemDO->renderWith('ProductItem');
				}
				
				$nextlink	= $list->NextLink();
				$nextlink	= $nextlink ? $nextlink : false;
			}
			
			return Convert::array2json(
					array(
						'product_html' 	=> $htmlContent, 
						'nextlink' 		=> $nextlink,
						'filter_update' => false,
						"filter_html" 	=> ''
			));

		}else{
			//do normal things
			return $this->owner->customise(array(
					'Products' 			=> $list,
					'ProductFilterForm'	=> $FilterForm
			));
		}
	}
	
	
	public function setProductFilterConfig($name, $values){
		if( ! is_array($this->owner->PFconfig)){
			$this->owner->PFconfig = array($name, $values);
		}else{
			$config 		= $this->owner->PFconfig;
			$config[$name] 	= $values;
		}
		
		return $this->owner;
	}
	
	
	/**
	 * @return ProductCategory_Controller
	 */
	public function getProductFilterCconfig($name = null){
		if(is_array($this->owner->PFconfig)){
			$config 		= $this->owner->PFconfig;
			
			if($name !== null){
				if(isset($config[$name])){
					return $config[$name];
				}
			}else{
				return $config;
			}
		}
		
		return false;
	}
	
	
	/**
	 * @return ProductCategory_Controller
	 */
	public function setProductListSort($sort){
		
		$this->setProductFilterConfig('PL_sort', $sort);
		
		ProductCategory_Controller::$products_ordered_by = $sort;
		
		return $this->owner;
	}

	
	/**
	 * @return ProductCategory_Controller
	 */
	public function setProductLimit($start, $length){
		
		$this->setProductFilterConfig('PL_start', $start);
		$this->setProductFilterConfig('PL_length', $length);
		
		ProductCategory_Controller::$products_per_page = $length;
		
		return $this->owner;
	}
	
	
// 	/**
// 	 * Get product DataList from ProductCategoryController
// 	 *
// 	 * @param ProductFilterForm
// 	 */
// 	public function ProductFilterForm(DataList $DataList = null){
		
// 		$form = new ProductFilterForm($this->owner, 'ProductFilterForm', $DataList);
// 		$form->disableSecurityToken();
		
// 		return $form;
// 	}
	
	
	
	public function ChildrenCategories(){
	
		$childrenDL = $this->owner->Children();
	
		return $childrenDL->exclude('ClassName', 'Product');
	}
	
}