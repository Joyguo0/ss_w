<?php

global $project;
$project = 'mysite';

global $database;
$database = 'burnetts';

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

MySQLDatabase::set_connection_charset('utf8');

i18n::set_locale('en_AU');

// Set the current theme. More themes can be downloaded from
// http://www.silverstripe.org/themes/
SSViewer::set_theme('burnetts');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();

//Add an extension to the siteconfig
Object::add_extension('SiteConfig', 'SiteConfigExtension');
Object::add_extension('File', 'FileExtension');
Object::add_extension('SiteConfig', 'Addressable');
Object::add_extension('SiteConfig', 'Geocodable');


FulltextSearchable::enable();

// Addressable configuration.
Addressable::set_allowed_states(array(
	'ACT' => 'Australian Capital Territory',
	'NSW' => 'New South Wales',
	'NT'  => 'Northern Territory',
	'QLD' => 'Queensland',
	'SA'  => 'South Australia',
	'TAS' => 'Tasmania',
	'VIC' => 'Victoria',
	'WA'  => 'Western Australia'
));

RecaptchaField::$public_api_key  = '6Lc3lM0SAAAAANdqoMyDnFSlG1ZM-ZuVjQKwuYFt';
RecaptchaField::$private_api_key = '6Lc3lM0SAAAAAGHHmsnjEfaXVI7eQ5_fmh-egmzd';
RecaptchaField::$js_options      = array('theme' => 'white');

