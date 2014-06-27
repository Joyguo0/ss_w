<?php

class Store extends Page {

	private static $db = array(
		'Email'            => 'Varchar(255)',
		'Website'          => 'Varchar(255)',
		'PhoneNumber'      => 'Varchar(255)',
		'FaxNumber'        => 'Varchar(255)',
	    'IconClass'        => 'Varchar(255)',
	        
		'Riderz'      	   => 'Boolean',
		'Polarised'        => 'Boolean',
		'Prescription'     => 'Boolean',
		'Safety'      	   => 'Boolean',
			
		'LegacyID'		   => 'Int'	
	);

	private static $default_sort = '"Title"';

	private static $extensions = array(
		'Addressable',
		'Geocodable'
	);

	private static $searchable_fields = array(
		'Title',
		'State'
	);

	private static $summary_fields = array(
		'Title',
		'City',
		'State'
	);
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		
		$storeLocatorPageDO = StoreLocatorPage::get()->first();
		
		$this->ParentID = $storeLocatorPageDO->ID;
	}
	
	public function onAfterWrite(){
		parent::onAfterWrite();
	
		if(!$this->IsDoingPublish){
			$this->IsDoingPublish = true;
			$this->writeToStage('Live');
		}
	
	}

	/**
	 * @return FieldSet
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('LegacyID');
		$fields->addFieldsToTab ( 'Root.Main', array (
		        TextField::create ( 'IconClass' )
		), 'Content' );
		return $fields;
	}

	/**
	 * @return string
	 */
	public function getFullAddress() {
		return implode(', ',
			array($this->Address, $this->City, $this->State, $this->Postcode));
	}

	/**
	 * @return string
	 */
	public function getWebsiteUrl() {
		if (!preg_match('~^[a-z]+://~i', $this->Website)) {
			return 'http://' . $this->Website;
		} else {
			return $this->Website;
		}
	}

	/**
	 * @return string
	 */
	public function getWebsiteName() {
		return rtrim(preg_replace('~^[a-z]+://~i', null, $this->Website), '/');
	}

	public function getGeocodingAddress() {
		return $this->getFullAddress();
	}

	public function getGeocodingRegion() {
		return 'au';
	}

	/**
	 * @return string
	 */
	public function Link() {
		$page = StoreLocatorPage::get()->first();
		return Controller::join_links($page->Link(), 'view', $this->ID);
	}
	
	public function SpecialisingIn()
	{
		if($this->Riderz || $this->Polarised || $this->Prescription || $this->Safety)
			return true;
		
		return false;
	}

}



class Store_Controller extends Page_Controller {

	
}	