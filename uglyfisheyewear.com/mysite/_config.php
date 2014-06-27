<?php

global $project;
$project = 'mysite';

global $database;
$database = 'uglyfish2014';

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

MySQLDatabase::set_connection_charset('utf8');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();

//Add an extension to the siteconfig
Object::add_extension('SiteConfig', 'SiteConfigExtension');
Object::add_extension('File', 'FileExtension');
Object::add_extension('ProductCategory', 'ProductCategoryExtension');
Object::add_extension('ProductCategory_Controller', 'ProductCategoryControllerExtension');
Object::add_extension('AccountPage', 'AccountPageExtension');
Object::add_extension('AccountPage_Controller', 'AccountPageExtension_Controller');
Object::add_extension('Product', 'ProductExtension');
Object::add_extension('Attribute', 'AttributeExtension');
Object::add_extension('Variation', 'VariationExtension');
Object::add_extension('ProductForm', 'ProductFormExtension');
Object::add_extension('Product_Controller', 'ProductExtension_Controller');
Object::add_extension('Item', 'ItemExtension');
Object::add_extension('NewsletterEmail', 'NewsletterEmailExtension');

//has to use this ugly way to add 'ProductExtension' as last element in extension array.
$ProductExts = Config::inst()->get('Product', 'extensions');
if(!empty($ProductExts)){
	$ProductExts[] = 'Product_Form_Extension';
	Config::inst()->update('Product', 'extensions', null);
	Config::inst()->update('Product', 'extensions', $ProductExts);
}

FulltextSearchable::enable();

// Addressable configuration.
// Addressable::set_allowed_states(array(
// 	'ACT' => 'Australian Capital Territory',
// 	'NSW' => 'New South Wales',
// 	'NT'  => 'Northern Territory',
// 	'QLD' => 'Queensland',
// 	'SA'  => 'South Australia',
// 	'TAS' => 'Tasmania',
// 	'VIC' => 'Victoria',
// 	'WA'  => 'Western Australia'
// ));

RecaptchaField::$public_api_key  = '6Lc3lM0SAAAAANdqoMyDnFSlG1ZM-ZuVjQKwuYFt';
RecaptchaField::$private_api_key = '6Lc3lM0SAAAAAGHHmsnjEfaXVI7eQ5_fmh-egmzd';
RecaptchaField::$js_options      = array('theme' => 'white');

ini_set("memory_limit", "256M");