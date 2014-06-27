<?php

/**
 * A page that lists all member branches, allowing filtering by city or state.
 *
 * @package    gemcell
 * @subpackage pages
 */
class StoreLocatorPage extends Page
{

    private static $db = array(
            'MapHelp' => 'HTMLText'
    );

    private static $icon = 'storelocator/images/icons/storelocatorpage';

    private static $extensions = array(
            "ExcludeChildren"
    );

    private static $excluded_children = array(
            'Store',
            'Distributor',
            'OnlineStore'
    );

    public function requireDefaultRecords ()
    {
        parent::requireDefaultRecords();
        
        $StoreLocatorPageDO = StoreLocatorPage::get()->first();
        if (! $StoreLocatorPageDO) {
            $StoreLocatorPageDO = new StoreLocatorPage();
            $StoreLocatorPageDO->Title = 'Find a Store';
            $StoreLocatorPageDO->URLSegment = 'find-a-store';
            $StoreLocatorPageDO->write();
            $StoreLocatorPageDO->publish('Stage', 'Live');
            $StoreLocatorPageDO->flushCache();
        }
    }

    public function canDelete ($member = null)
    {
        return false;
    }

    public function canCreate ($member = null)
    {
        return false;
    }

    public function getCMSFields ()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.MapHelp', 
                new HtmlEditorField('MapHelp', 'Map Help Text', 15));
        
        return $fields;
    }
}

class StoreLocatorPage_Controller extends Page_Controller
{

    const MIN_SEARCH_RESULTS = 10;

    public static $allowed_actions = array(
            'suburb',
            'suggestsuburb',
            'view',
            'getStoreDetail'
    );

    public function init ()
    {
        parent::init();
        
        $this->ThemeDir = 'themes/' . SSViewer::current_theme() . '/';
        
        // echo THIRDPARTY_DIR;die;
        if (Director::fileExists($this->ThemeDir . "css/storelocator.css")) {
        	Requirements::css($this->ThemeDir . "css/storelocator.css");
        } else {
        	Requirements::css("storelocator/css/storelocator.css");
        }
        
        Requirements::javascript(
                'http://maps.google.com/maps/api/js?sensor=false');
        Requirements::javascript(
                $this->ThemeDir . '/javascript/jquery-ui/jquery.ui.core.js');
        Requirements::javascript(
                $this->ThemeDir . '/javascript/jquery-ui/jquery.ui.widget.js');
        Requirements::javascript(
                $this->ThemeDir . '/javascript/jquery-ui/jquery.ui.position.js');
        Requirements::javascript(
                $this->ThemeDir . '/javascript/jquery-ui/jquery.ui.dialog.js');
        Requirements::javascript(
                $this->ThemeDir .
                         '/javascript/jquery-ui/jquery.ui.autocomplete.js');
        Requirements::javascript(
                $this->ThemeDir . '/javascript/jquery-ui/jquery.ui.menu.js');
        Requirements::javascript(
                'storelocator/thirdparty/markerclusterer/markerclusterer.js');
        
        Requirements::javascript('framework/thirdparty/jquery-livequery/jquery.livequery.min.js');
        
        Requirements::javascript('storelocator/javascript/storelocator.js');
        
        // Requirements::css('storelocator/thirdparty/aristo/jquery-ui-1.8.5.custom.css');
        // Requirements::themedCSS('storelocator/css/storelocator');
    }

//     public function index ($request)
//     {
//         if($request->getVar('title')){
//             $result=$this->suburb($request);
//         }else{
//             $result=array(
//                 'Stores' => Store::get()
//             );
//         }
//         return $result;
//     }

    /**
     * Gets all branches in a suburb, as well as the closest ones to bring the
     * total up.
     *
     * @return string
     */
    public function suburb ($request)
    {
        $id = (int) $request->getVar('suburb');
        $safety = Convert::raw2sql($request->getVar('safety'));
        $riderz = Convert::raw2sql($request->getVar('motorcycle'));
        $pol = Convert::raw2sql($request->getVar('polarised'));
        $pres = Convert::raw2sql($request->getVar('prescription'));
        $search_state = Convert::raw2sql($request->getVar('search_state'));
        $title = Convert::raw2sql($request->getVar('title'));
        $suburb = Suburb::get()->byId($id);
  
        /*
         * if (!$suburb) { return new SS_HTTPResponse(null, 400, 'That postcode
         * could not ' . 'be found. Please ensure that you have entered a valid
         * ' . 'suburb ID.'); }
         */
        if ($suburb) {
            $postcode = $suburb->Postcode;
        } else {
            $postcode = 0;
            $suburb = Suburb::create();
        }
        
        $query = new SQLQuery();
        $query->setSelect('*');
        $query->setFrom('"Store"');
        $query->addInnerJoin("SiteTree", '"SiteTree"."id"="Store"."id"');
        $this->ProcessQuery($postcode,$safety, $riderz, $pol, $pres, $search_state, $title, $query);
        if ($title) {
            $query->setWhere("\"SiteTree\".\"Title\" like '%$title%'");
        }

        $matched = $query->execute();  
        $result = new ArrayList();
        foreach ($matched as $match) {
            $result->push($match);
        }
        
        if ($result->count() < self::MIN_SEARCH_RESULTS) {
            
            $haversine = sprintf(
                    '(6371 * ACOS(COS(RADIANS(%F)) * COS(RADIANS("Lat"))* COS(RADIANS("lng") - RADIANS(%F)) + SIN(RADIANS(%1$F))* SIN(RADIANS("Lat"))))', 
                    $suburb->Lat, $suburb->Lng);
            $query = new SQLQuery();
            $query->setSelect('"ID"', '"Title"', '"Postcode"', '"Lat"', '"Lng"');
            $query->selectField($haversine, "Distance");
            $query->setFrom('"Store"');
            $this->ProcessQuery($postcode,$safety, $riderz, $pol, $pres, $search_state, $title, $query);
            if ($title) {
                $query->setWhere("\"Postcode\" like '%$title%'");
            }
            $query->setOrderBy('"Distance"');
            $query->setLimit(self::MIN_SEARCH_RESULTS - $matched->numRecords());
            foreach ($query->execute() as $match) {
                $match['Distance'] = $match['Distance'];
                $result->push($match);
            }
        }
      
        
        $resArray = array(
        	'Suburb' => $suburb,
        	'Stores' => $result
        );
        
        
        if($this->request->isAjax()){
        	// StoresList.ss
        	return $this->customise($resArray)->renderWith('StoresList');
        }else{
        	// StoreLocatorPage_suburb.ss
			return $this->customise($resArray);
        }
    }
    
    
    
    private function ProcessQuery ($postcode,$safety, $riderz, $pol, $pres, $search_state,$title, &$query)
    {
        $con=' 1 ';
        if($postcode){
            $con.=" And \"Postcode\" <> '$postcode'";
        }
        if ($safety == 'on') {
            $con.=' And "Safety"=1';
        }
        if ($riderz == 'on') {
            $con.='  And "Riderz"=1';
        }
        if ($pol == 'on') {
            $con.='  And "Polarised"=1';
        }
        if ($pres == 'on') {
            $con.='  And "Prescription"=1';
        }
        if ($search_state) {
            $con.="  And \"State\"='".$search_state."'";
        }
        $query->setWhere($con);
        
    }


    /**
     * Returns autocomplete suggestions for the suburb search box.
     *
     * @return string
     */
    public function suggestsuburb ($request)
    {
        $term = $request->getVar('term');
        $result = array();
        
        if (strlen($term) < 3) {
            $this->httpError(404, 'You must specify a search term.');
        }
        
        $suburbs = DataObject::get('Suburb', 
                sprintf(
                        '"Postcode" LIKE \'%%%1$s%%\' OR "Name" LIKE \'%%%1$s%%\'', 
                        Convert::raw2sql($term)));
        
        if ($suburbs)
            foreach ($suburbs as $suburb) {
                $result[] = array(
                        'value' => $suburb->ID,
                        'label' => "$suburb->Name $suburb->State $suburb->Postcode"
                );
            }
        
        return Convert::array2json($result);
    }

    public function getStoreDetail ($request)
    {
        $id = (int) $request->getVar('store_id');
        
        $result = new ArrayList();
        $query = new SQLQuery();
        $query->setSelect('*');
        $query->setFrom('Store');
        $query->addLeftJoin('SiteTree', 'SiteTree.id=Store.id');
        $query->setWhere("Store.id =$id");
        $matched = $query->execute();
        foreach ($matched as $match) {
            $result->push($match);
        }
        return array(
                'StoreDetail' => $result
        );
    }

    /**
     * Handles viewing an individial branch page.
     *
     * @return array
     */
    public function view ($request)
    {
        $id = (int) $request->param('ID');
        
        if (! $id || ! $store = Store::get()->byID($id)) {
            $this->httpError(404, 'The requested agent could not be found.');
        }
        
        return array(
                'Title' => $store->Title,
                'Store' => $store
        );
    }

    /**
     *
     * @return Stockist[]
     */
    public function Stores ()
    {
        return Store::get()->filter(
                array(
                		'ClassName' => 'Store',
                        'ParentID' => $this->ID
                ))->sort('"Title"');
    }

    public function Distributors ()
    {
        return Distributor::get()->filter(
                array(
                        'ParentID' => $this->ID
                ));
    }

    public function OnlineStores ()
    {
        return OnlineStore::get()->filter(
                array(
                        'ParentID' => $this->ID
                ));
    }
}