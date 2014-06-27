<?php

class Verification extends DataObject {
	private static $db = array(
		'CVN' 		=> 'Enum("Valid, Invalid, Unchecked", "Unchecked")',
		'Address' 	=> 'Enum("Valid, Invalid, Unchecked", "Unchecked")',
		"Email" 	=> 'Enum("Valid, Invalid, Unchecked", "Unchecked")',
		'Mobile'	=> 'Enum("Valid, Invalid, Unchecked", "Unchecked")',
		'Phone'		=> 'Enum("Valid, Invalid, Unchecked", "Unchecked")'
	);
}