<?php
class ProductAdmin extends ModelAdmin {

   	public static $title       = 'Products';
	public static $menu_title  = 'Products';
	public static $url_segment = 'products';

	public static $managed_models  = array(   
									      'Product'
									   );
	public static $model_importers = array();
}
?>