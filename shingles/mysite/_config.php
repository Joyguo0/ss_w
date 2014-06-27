<?php

global $project;
$project = 'mysite';

global $database;
$database = 'americanshingle';

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

MySQLDatabase::set_connection_charset('utf8');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();

//Add an extension to the siteconfig
Object::add_extension('SiteConfig', 'SiteConfigExtension');
Object::add_extension('FormField', 'FormFieldExtension');
Object::add_extension('MultiFormStep', 'MultiFormStepExtension');
Object::add_extension('MultiFormSession', 'MultiFormSessionExtension');
Object::add_extension('FormTypePage', 'Addressable');
Object::add_extension('FormTypePage', 'Geocodable');
Addressable::set_allowed_countries('AU');
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


FulltextSearchable::enable();


if($_SERVER['REMOTE_ADDR'] == '165.228.11.252'){
	//test
	eWayRapidPayment::$username = '60CF3CIBtquhszrQmiFw5lx1sv0o/TrzHwnz5dvvWV9rMWa94N/MsC8sPs4V96EDl9ZsTi';
	eWayRapidPayment::$password = '1nTernetr1x!';
	eWayRapidPayment::$testMode = true;
	eWayRapidPayment::$testValues = false;
	RapidAPI::$check_SSL = false;
}else{
	//live
	eWayRapidPayment::$username = '60CF3A62Kxs8WPKi3/vVNqnO704houeMRBiCL5fuP44ml4z8v1aru02B5JMJvGgVimzwux';
	eWayRapidPayment::$password = 'Irx1@3Sh!ngles';
	eWayRapidPayment::$testMode = false;
	eWayRapidPayment::$testValues = false;
	RapidAPI::$check_SSL = true;
}


RecaptchaField::$public_api_key  = '6Lc3lM0SAAAAANdqoMyDnFSlG1ZM-ZuVjQKwuYFt';
RecaptchaField::$private_api_key = '6Lc3lM0SAAAAAGHHmsnjEfaXVI7eQ5_fmh-egmzd';
RecaptchaField::$js_options      = array('theme' => 'white');

