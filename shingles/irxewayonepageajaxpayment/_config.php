<?php
Object::add_extension('Page_Controller', 'PageControllerExtension');


/**********Copy the below to mysite/_config.php and populate with live data********
eWayRapidPayment::$username = 'USERNAME';
eWayRapidPayment::$password = 'PASSWORD';

//put this one to mysite/_config.php if curl can't verify ssl (only for localhost or dev server)
RapidAPI::$check_SSL = false;
/**********************************************************************************/
