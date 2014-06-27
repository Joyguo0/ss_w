<?php
class OrderAdmin extends ModelAdmin {
	
	private static $title       = 'Order Admin';
	private static $menu_title  = 'Order Admin';
	private static $url_segment = 'orderadmin';

	private static $managed_models  =  array('Order', 'VPCPayment');
	private static $model_importers = array();
	
}