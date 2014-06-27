<?php

global $project;
$project = 'mysite';

global $database;
$database = 'anzrsaiss';

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

MySQLDatabase::set_connection_charset('utf8');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();

//Add an extension to the siteconfig
Object::add_extension('DataObject', 'ContentAuthorExtension');
Object::add_extension('SiteConfig', 'SiteConfigExtension');
Object::add_extension('News', 'NewsExtension');
Object::add_extension('AddressablePage', 'Addressable');
Object::add_extension('AddressablePage', 'Geocodable');
Object::add_extension('SubscriptionPage', 'SubscriptionPageExtension');
Object::add_extension('ForumHolder', 'ForumHolderExtension');
Object::add_extension('Member', 'MemberExtension');
Object::add_extension('MultiFormSession', 'MultiFormSessionExtension');

Object::add_extension('BlogEntry', 'BlogEntryExtension');
Object::add_extension('BlogHolder_Controller', 'BlogHolderControllerExtension');
Object::add_extension('BlogHolder', 'BlogHolderExtension');
//hide blog entry page in Page section. all blog entry will be managered in BlogAdmin.
Object::add_extension("BlogHolder", "ExcludeChildren");
Config::inst()->update("BlogHolder", "excluded_children", array("BlogEntry"));

Object::add_extension('File', 'DataMigrationExtension');
Object::add_extension('SiteTree', 'DataMigrationExtension');

FulltextSearchable::enable();

NewsletterAdmin::$template_paths = "themes/anzrsai/templates/email";

// Addressable configuration.
// Addressable::set_allowed_states(array(
// 	'NSW' => 'New South Wales',
// 	'ACT' => 'Australian Capital Territory',
// 	'NT'  => 'Northern Territory',
// 	'QLD' => 'Queensland',
// 	'SA'  => 'South Australia',
// 	'TAS' => 'Tasmania',
// 	'VIC' => 'Victoria',
// 	'WA'  => 'Western Australia'
// ));

/**********For Payment  376438848@qq.com********/
//eWayRapidPayment::$username = '60CF3CIBtquhszrQmiFw5lx1sv0o/TrzHwnz5dvvWV9rMWa94N/MsC8sPs4V96EDl9ZsTi';
//eWayRapidPayment::$password = '1nTernetr1x!';
//RapidAPI::$check_SSL = false;

RecaptchaField::$public_api_key  = '6Lc3lM0SAAAAANdqoMyDnFSlG1ZM-ZuVjQKwuYFt';
RecaptchaField::$private_api_key = '6Lc3lM0SAAAAAGHHmsnjEfaXVI7eQ5_fmh-egmzd';
RecaptchaField::$js_options      = array('theme' => 'custom');
SpamProtectorManager::set_spam_protector("RecaptchaProtector");

Director::addRules(100, array(
	'account' => 'AccountController'
));

//newsletter config 
// MessageQueue::add_interface("default", array(
// 	"queues" => "/.*/",
// 	"implementation" => "SimpleDBMQ",
// 	"encoding" => "php_serialize",
// 	"send" => array(
// 		"onShutdown" => "all"
// 	),
// 	"delivery" => array(
// 		"onerror" => array(
// 			"log"
// 		)
// 	)
// ));

// MessageQueue::set_onshutdown_option('phppath', 'php');		//this is important!!!

// MessageQueue::set_debugging('/home/anzrsaiss/log');		//enable this if newsletters are not being sent out. 




//add payment URL
Object::add_extension('RenewMembershipPage_Controller', 'VPCPageControllerExtension');
Object::add_extension('ConferencePage_Controller', 'VPCPageControllerExtension');
Object::add_extension('MemberRegistrationFormPage_Controller', 'VPCPageControllerExtension');
//setup virtual client payment details

if(($_SERVER['SERVER_ADDR'] == '127.0.0.1' || $_SERVER['SERVER_ADDR'] == '110.173.154.238') && Director::isDev()){
	//use test mode on localhost server and sabre580.
	VPCPayment::SetTestMode('bbl7107147', '4F98B3DF', '3B7FFE758F0FA8183063B3CEF9253EAA');
	//for testing 
	Object::add_extension('Page_Controller', 'VPCPageControllerExtension');
	
}else{
	
	VPCPayment::SetLiveMode('bbl7107147', '2AC0A87A', '75575B65DF67DE1A6C9B43748E4819AD');
	//Advanced Merchant Administration Features (server to server)
	VPCPayment::SetupServer2ServerVerification('paymentcheck', 'ch@KthS!pmEt6');
	
}
