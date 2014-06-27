<?php
class ItemExtension extends DataExtension {
	
    public function updatePrice($amount){
        
        $product=Product::get_by_id('Product', $this->owner->ProductID);
        if(Member::CurrentUser()&&Member::currentUser()->inGroup('reseller')){
            $amount->setAmount($product->WholeSalePrice);
        }
        if($product->IsSale()){
            $amount->setAmount($product->SalePrice);
        }
    }
    public function updateAmount($amount){
        $product=Product::get_by_id('Product', $this->owner->ProductID);
        if(Member::CurrentUser()&&Member::currentUser()->inGroup('reseller')){
            $amount->setAmount($product->WholeSalePrice);
        }
        if($product->IsSale()){
            $amount->setAmount($product->SalePrice);
        }
    }
}

