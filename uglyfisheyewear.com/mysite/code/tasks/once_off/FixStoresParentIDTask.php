<?php

class FixStoresParentIDTask extends BuildTask {
	
	protected $title = 'Fix Stores ParentID Task';
	
	protected $description = '';
	
	public function run($request) {
		
		increase_time_limit_to();
		
		$count = 0;
		
		$storePageDO = StoreLocatorPage::get()->first();
		
		$storeDL = Store::get();
		
		foreach ($storeDL as $storeDO){
			
			$storeDO->ParentID = $storePageDO->ID;
			
			$storeDO->write();
			$storeDO->doPublish();
			
			$count++;
		}
		
		
		echo "<br><br> added $count stores <br><br>";
		
	}
	
}
