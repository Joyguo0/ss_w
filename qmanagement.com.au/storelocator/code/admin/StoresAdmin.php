<?php
class StoresAdmin extends ModelAdmin {

   	public static $title       = 'BuildingPages';
	public static $menu_title  = 'BuildingPages';
	public static $url_segment = 'BuildingPages';

	public static $managed_models  = array(   
									      'BuildingPage',
									   );

}
?>