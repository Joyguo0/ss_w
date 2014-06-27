<?php
class PF_OptionExtension extends DataExtension {
	
	public function getAF_Title(){
		if($this->owner->AF_Price){
			$shopConfigDO 	= ShopConfig::current_shop_config();
				
			$dollarSymbol 	= $shopConfigDO->BaseCurrencySymbol	 ? $shopConfigDO->BaseCurrencySymbol : '$';
			$Currency 		= $shopConfigDO->BaseCurrency	 ? $shopConfigDO->BaseCurrency : 'AUD';
			$stroke			= ' - ';
	
			$startAmount	= $dollarSymbol . $this->owner->getField('AF_StartAmount') . " $Currency";
			$endAmount		= $dollarSymbol . $this->owner->getField('AF_EndAmount') . " $Currency";
				
			return "{$startAmount}{$stroke}{$endAmount}";
			
		}else{
			
		return $this->owner->getField('AF_Title');
		}
	}
	
	
	public function LinkWithParam(){
		$requestDO = Controller::curr()->request;
		
		
		
	}
	
	
	public function FilterParamForOption(){
		$requestDO = Controller::curr()->request;
		
		$GETs = $requestDO->getVar('pf');
		
		
		
		
		
		
	}
	
	
}