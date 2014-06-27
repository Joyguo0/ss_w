<?php

global $project;
$project = 'mysite';

global $database;
$database = 'keiraview'; 

require_once BASE_PATH . '/mysite/conf/MyConfigureFromEnv.php';

// Set the site locale
i18n::set_locale('en_US');
// Director::set_environment_type("dev");		//set this in config file.
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
Object::add_extension('Page', 'Addressable');
Object::add_extension('Page', 'Geocodable');
SS_Log::add_writer(new SS_LogEmailWriter('errors@internetrix.com.au'), SS_Log::WARN, '<=');