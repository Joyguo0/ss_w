<?php
class ProductBugFixExtension extends DataExtension {
	
	private static $db = array (
		'Category' 				=> 'Varchar'		//bug fixes for swipestripe-category (if the latest version add this one in their module. then remove this one.)
	);
	
}