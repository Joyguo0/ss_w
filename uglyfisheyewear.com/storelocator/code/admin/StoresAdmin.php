<?php
class StoresAdmin extends ModelAdmin {

   	public static $title       = 'Stores';
	public static $menu_title  = 'Stores';
	public static $url_segment = 'stores';

	public static $managed_models  = array(   
									      'Store',
									      'OnlineStore',
	                                       'Distributor'
									   );

}
?>