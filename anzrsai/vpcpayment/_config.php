<?php

if(class_exists('Order')){
	Object::add_extension('Order', 'OrderExtension');
	Object::add_extension('VPCPayment', 'VPCOrderExtension');
}

if(class_exists('MultiFormSession')){
	Object::add_extension('MultiFormSession', 'VPCPMultiFormSessionExtension');
	Object::add_extension('VPCPayment', 'VPCMultiFormSessionExtension');
}



// please add VPCPageControllerExtension into the page controller handle the payment in mysite/_config.php
// Object::add_extension('Page_Controller', 'VPCPageControllerExtension');




// please put either one of the following in your mysite/_config.php

// VPCPayment::SetLiveMode('Merchant ID like BBLXXXXXXXXX', 'your live access code', 'your live Secure Hash Secret');

// or 

// VPCPayment::SetTestMode('Merchant ID like BBLXXXXXXXXX', 'your test Secure Hash Secret');