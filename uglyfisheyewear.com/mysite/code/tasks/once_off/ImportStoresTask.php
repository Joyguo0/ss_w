<?php

class ImportStoresTask extends BuildTask {
	
	protected $title = 'Import Stores Task';
	
	protected $description = '';
	
	public function run($request) {
		
		increase_time_limit_to();
		
		
		include dirname(__FILE__) . '/array_data/OldStoreData.php';
		
		$allowed_key_array = array('Title', 'Email', 'Website', 'Address', 'PhoneNumber', 'State', 'Postcode', 'FaxNumber', 'Riderz', 'Polarised', 'Safety', 'Prescription', 'Lat');
		
		
		$count = 0;
		
		foreach ($Store as $storeArray){
			
			$storeAddr 	= $storeArray['Address'];
			$storeTitle = $storeArray['Title'];
			
			$StoreDO = Store::get()->filter(array('Address' => $storeAddr, 'Title'=>$storeTitle))->first();
			
			if(!$StoreDO){
				$StoreDO = new Store();
				
				foreach ($storeArray as $key => $value){
					if(in_array($key, $allowed_key_array)){
						$StoreDO->$key = $value;
					}
				}
				
				$StoreDO->Suburb 	= $storeArray['City'];
				$StoreDO->Lng 		= $storeArray['Long'];
				$StoreDO->Country 	= 'AU';
				$StoreDO->LegacyID 	= $storeArray['ID'];
				
				$StoreDO->write();
				$StoreDO->doPublish();
				
				$count++;
			}
		}
		
		
		echo "<br><br> added $count stores <br><br>";
		
	}
	
}
