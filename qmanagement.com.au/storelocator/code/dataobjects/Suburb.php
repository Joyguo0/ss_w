<?php
/**
 * Contains a postcode, name and locality for a suburb.
 */
class Suburb extends DataObject {

	private static $db = array(
		'Postcode' => 'Int',
		'Name'     => 'Varchar(100)',
		'State'    => 'Varchar(5)',
		'Lat'      => 'Float',
		'Long'     => 'Float'
	);

	private static $indexes = array(
		'Postcode' => true
	);
	
	private static $default_records = array();
	
	public function requireDefaultRecords() {
		//directly run sql to insert default suburb value is much much quicker.
		$SuburRecordsCSVPath = BASE_PATH . '\storelocator\code\sql\Suburb.sql';
		
		if(!Suburb::get()->first() && file_exists($SuburRecordsCSVPath)){
			$sqlquery = file_get_contents($SuburRecordsCSVPath);
			
			$sqlquery = str_ireplace('`', '"', $sqlquery);
			
			$queryArray = explode(');', $sqlquery);
			
			foreach ($queryArray as $query){
				if(stripos($query, 'INSERT INTO') !== false){
					$query = $query . ')';
					DB::query($query);
				}
			}
		}
		
		parent::requireDefaultRecords();
	}

}