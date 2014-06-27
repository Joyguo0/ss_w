<?php

/**
 *
 */
class BuildingPage extends Store
{
	public static $icon = 'mysite/images/icons/buildingpage';
	
	private static $can_be_root = false;

    private static $db = array(
            'DateState' => 'enum("current,upcoming","current")'
    );

    private static $has_one = array(
            'Image' => 'Image',
            'Page' => 'SiteTree'
    );

    public function canCreate ($member = null)
    {
        return true;
    }

    public function getCMSFields ()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', UploadField::create('Image'), 
                'Content');
        $fields->addFieldToTab('Root.Main', 
                OptionsetField::create('DateState', 'Current Or Upcoming', 
                        $this->dbObject('DateState')
                            ->enumValues()), 'Content');
       
        if(!$this->isPublished()||!$this->existsSubsite()){
	        $fields->addFieldToTab('Root.Main', 
	                CheckboxField::create('CreateSubsite', 'Create Subsite'), 
	                'Content');
	        
        }
        return $fields;
    }
	public function existsSubsite(){
		$result= Subsite::get()->filter('title',$this->Title);
		if($result->exists()){
			return true;
		}
		return false;
	}
    public function onAfterWrite ()
    {
        if ($this->CreateSubsite) {
            $this->CreateSubsite = 0;
            $subsiteDO = new Subsite();
            $subsiteDO->Title = $this->Title;
            $subsiteDO->IsPublic = true;
            $subsiteDO->write();
            
            // create siteconfig for this subsite.
            $scDO = clone SiteConfig::current_site_config();
            $scDO->SubsiteID = $subsiteDO->ID;
            $scDO->Title = $subsiteDO->Title;
            $scDO->Tagline = "Your tagline for '$subsiteDO->Title'";
            $scDO->write();
            $domain = new SubsiteDomain();
            $domain->SubsiteID = $subsiteDO->ID;
            $domain->IsPrimary = true;
            $domain->Domain = strtolower(
                    preg_replace('/[\s　]/', '_', $this->Title)) .
                     '.qmanagement.com.au';
            $domain->write();
            // duplicate to new subsite
            
            $this->generateSubsiteHome($subsiteDO->ID);
        }
        parent::onAfterWrite();
    }

    /**
     * Create a duplicate of this page and save it to another subsite
     * 
     * @param $subsiteID int|Subsite
     *            The Subsite to copy to, or its ID
     */
    private function generateSubsiteHome ($subsiteID = null)
    {
        if (is_object($subsiteID)) {
            $subsite = $subsiteID;
            $subsiteID = $subsite->ID;
        } else
            $subsite = DataObject::get_by_id('Subsite', $subsiteID);
        
        $oldSubsite = Subsite::currentSubsiteID();
        if ($subsiteID) {
            Subsite::changeSubsite($subsiteID);
        } else {
            $subsiteID = $oldSubsite;
        }
        
        $page = new BuildingLandingPage();
        $page->Title=$this->Title;
        $page->Address=$this->Address;
        $page->CheckedPublicationDifferences = $page->AddedToStage = true;
        $subsiteID = ($subsiteID ? $subsiteID : $oldSubsite);
        $page->SubsiteID = $subsiteID;
        $page->URLSegment = 'home';
        
        $page->Address=$this->Address;
        $page->Suburb=$this->Suburb;
        $page->State=$this->State;
        $page->Postcode=$this->Postcode;
        // MasterPageID is here for legacy purposes, to satisfy the
        // subsites_relatedpages module
        $page->MasterPageID = $this->owner->ID;
        $page->write();
        
        Subsite::changeSubsite($oldSubsite);
        
        return $page;
    }

  	public function BuildingListLink(){
  		return Director::baseURL().'buildinglist?state='.$this->DateState;
  	}
}

class BuildingPage_Controller extends Store_Controller
{
}
