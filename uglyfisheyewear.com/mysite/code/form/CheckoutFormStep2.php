<?php

class CheckoutFormStep2 extends MultiFormStep {

   	public static $next_steps = 'CheckoutFormStep3';
   	
   	public function getFields() {
   		
   		$list = new FieldList();
   		$list->push(TextField::create('FirstName','* FIRST NAME'));
   		$list->push(TextField::create('LastName','* LAST NAME'));
   		$list->push(TextField::create('Company','Company'));
   		$list->push(TextField::create('Email','* EMAIL'));
   		$list->push(TextField::create('Address','* ADDRESS'));
   		$list->push(TextField::create('Address2',''));
   		
   		$list->push(TextField::create('City','* City'));
   		$list->push(TextField::create('State','* State/ Province'));
   		$list->push(TextField::create('PostalCode','* Zip/ Postal Code'));
   		$list->push(new DropdownField('Country','* Country',array('Australia'=>'Australia','Country'=>'Country',)));
   		
   		
   		$list->push(TextField::create('Tel','* Telephone'));
   		$list->push(TextField::create('Fax','* FAX'));
   		$list->push(PasswordField::create('Password',' Create a Password'));
   		$list->push(PasswordField::create('REPassword',' Re-Enter your password'));
   		$list->push(new OptionsetField('ShipAddress','',array('ThisAddress'=>' Ship to this Address ' , 'DiffAddress' =>'Ship to different Address')));
   		
   		return $list;
   }
   
}
