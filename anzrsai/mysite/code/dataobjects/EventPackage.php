<?php
class EventPackage extends DataObject {
	private static $db = array('Title' => 'Text');
	private static $has_many = array('EventTicket' => 'EventTicket');
	
}