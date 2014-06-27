<?php

class ImportCategoriesTask extends BuildTask {
	
	protected $title = 'Import uglyfish categories';
	
	protected $description = '';
	
	public function run($request) {
		
		$json_string = '{ "Range": { "safety": { "SPARE PARTS": { "LENS": null, "POSITIVE SEAL": null, "ARMS": null, "STRAP": null }, "MEN\'S": { "POSITIVE SEAL": null, "SUNGLASSES": null, "ADJUSTABLE NOSE PAD": null, "ADJUSTABLE TEMPLE": null, "ANTI-FOG": null, "PHOTOCHROMATIC": null, "POLARISED": null, "MULTI-FUNCTIONAL": null }, "PRESCRIPTION": { "DIRECT IN FRAME": null, "GASKET INSERT": null }, "WOMEN\'S": { "POSITIVE SEAL": null, "SUNGLASSES": null, "ADJUSTABLE NOSE PAD": null, "ADJUSTABLE TEMPLE": null, "ANTI-FOG": null, "PHOTOCHROMATIC": null, "POLARISED": null, "MULTI-FUNCTIONAL": null } }, "prescription": { "MEN\'S": { "POLARISED FIT OVER": null, "SAFETY GLASSES": null, "POLARISED SUNGLASSES": null, "POLARISED BIFOCAL": null, "MOTORCYLE SUNGLASSES": null, "MOTORCYLE GOGGLES": null }, "JUNIOR": { "POLARISED SUNGLASSES": null }, "OTHER": { "accessories": null, "RX GASKET": null }, "WOMEN\'S": { "POLARISED FIT OVER": null, "SAFETY GLASSES": null, "POLARISED SUNGLASSES": null, "POLARISED BIFOCAL": null, "MOTORCYLE SUNGLASSES": null, "MOTORCYLE GOGGLES": null } }, "polarised": { "MEN\'S": { "BIFOCAL": null, "SPORT": null, "PHOTOCHROMIC": null, "LEISURE": null, "FIT OVER": null }, "PRESCRIPTION": { "FIT OVER": null, "BIFOCAL": null }, "JUNIOR": { "BOYS": null, "GIRLS": null }, "WOMEN\'S": { "BIFOCAL": null, "SPORT": null, "PHOTOCHROMIC": null, "LEISURE": null, "FIT OVER": null } }, "motorcyle": { "SPARE PARTS": { "LENS": null, "FOAM": null, "ARMS": null, "STRAP": null }, "MEN\'S": { "GOGGLES": null, "SUNGLASSES": null, "WOMEN\'S": null }, "PRESCRIPTION": { "GOGGLES": null, "SUNGLASSES": null, "RX GASKET": null } } }, "lifestyle": { "GEAR UP": { "OUTDOOR WORKER": null, "INDOOR WORKER": null, "MINER": null }, "play hard": { "SKY DIVING": null, "RUNNING": null, "CYCLING": null, "CRICKET": null, "GOLD": null }, "GET A LIFE": { "WALKING": null, "AT THE BEACH": null, "CASUAL": null }, "HIT THE ROAD": { "DRIVING": null, "TRUCKING": null }, "GET WET": { "BOATING": null, "FISHING": null, "JET SKI": null }, "TAKE A RIDE": { "road bike": null, "cruiser": null } } }';
		
		$categoryArray = Convert::json2array($json_string);
		
		$ProductListingPageDO = ProductListPage::get()->first();
		
		$this->CreateSubCategories($categoryArray, $ProductListingPageDO);
		
		
	}
	
	
	public function CreateSubCategories($array, $parentDO){

		foreach ($array as $category => $subArray){
			
			$category_sql = Convert::raw2sql($category);
			
			$category = $this->ucname($category);
			
			$categoryDO = ProductCategory::get()->where("LOWER(\"Title\") = LOWER('$category_sql') AND \"ParentID\" = " . $parentDO->ID)->first();
	
			if(!$categoryDO){
				$categoryDO = new ProductCategory();
				$categoryDO->Title = $category;
				$categoryDO->ParentID = $parentDO->ID;
				$categoryDO->write();
				$categoryDO->doPublish();
			}
			
			if(is_array($subArray)){
				$this->CreateSubCategories($subArray, $categoryDO);
			}
			
		}
		
	}
	
	function ucname($string) {
		$string =ucwords(strtolower($string));
	
		foreach (array('-', '\'') as $delimiter) {
			if (strpos($string, $delimiter)!==false) {
				$string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
			}
		}
		return $string;
	}
	
}
