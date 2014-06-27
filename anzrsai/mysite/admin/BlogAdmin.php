<?php
class BlogAdmin extends ModelAdmin {
	
	private static $title       = 'Blog Admin';
	private static $menu_title  = 'Blog Admin';
	private static $url_segment = 'blogadmin';

	private static $managed_models  =  array('BlogEntry');
	private static $model_importers = array();
	
}