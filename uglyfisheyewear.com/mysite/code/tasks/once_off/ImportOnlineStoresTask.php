<?php

class ImportOnlineStoresTask extends BuildTask {
	
	protected $title = 'Import Online Stores Task';
	
	protected $description = '';
	
	public function run($request) {
		
		increase_time_limit_to();
		
		
		include dirname(__FILE__) . '/array_data/OldOnlineStoreData.php';
		
		$allowed_key_array = array('Title', 'Email', 'Website', 'PhoneNumber', 'FaxNumber', 'Riderz', 'Polarised', 'Safety', 'Prescription');
		
		$count = 0;
		
		foreach ($OnlineStore as $storeArray){
			
			$storeWebsite = $storeArray['Website'];
			
			$StoreDO = OnlineStore::get()->filter(array('Website'=>$storeWebsite))->first();
			
			if(!$StoreDO){
				$StoreDO = new OnlineStore();
				
				foreach ($storeArray as $key => $value){
					if(in_array($key, $allowed_key_array)){
						$StoreDO->$key = $value;
					}
				}
				
				$StoreDO->write();
				$StoreDO->doPublish();
				
				$count++;
			}
		}
		
		
		echo "<br><br> added $count stores <br><br>";
		
	}
	
}
