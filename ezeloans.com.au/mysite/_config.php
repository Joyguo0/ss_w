<?php

global $project;
$project = 'mysite';

global $database;
$database = 'ezeloans';

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

MySQLDatabase::set_connection_charset('utf8');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();

//Add an extension to the siteconfig
Object::add_extension('SiteConfig', 'SiteConfigExtension');

FulltextSearchable::enable();

// Addressable configuration.
//Addressable::set_allowed_states(array(
//	'ACT' => 'Australian Capital Territory',
//	'NSW' => 'New South Wales',
//	'NT'  => 'Northern Territory',
//	'QLD' => 'Queensland',
//	'SA'  => 'South Australia',
//	'TAS' => 'Tasmania',
//	'VIC' => 'Victoria',
//	'WA'  => 'Western Australia'
//));

RecaptchaField::$public_api_key  = '6Lc3lM0SAAAAANdqoMyDnFSlG1ZM-ZuVjQKwuYFt';
RecaptchaField::$private_api_key = '6Lc3lM0SAAAAAGHHmsnjEfaXVI7eQ5_fmh-egmzd';
RecaptchaField::$js_options      = array('theme' => 'white');

// log errors and warnings
if(Director::get_environment_type() == 'live'){
	SS_Log::add_writer(new SS_LogEmailWriter('errors@internetrix.com.au'), SS_Log::WARN, '<=');
}

