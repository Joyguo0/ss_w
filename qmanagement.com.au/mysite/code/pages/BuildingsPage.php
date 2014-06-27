<?php
class BuildingsPage extends Page
{
	public static $icon = 'mysite/images/icons/buildingspage';

    public function getOneBuilding($state='current'){
        return BuildingPage::get()->filter('DateState',$state)->first();
    }
 
}

class BuildingsPage_Controller extends Page_Controller
{
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
    
    }
   
    public function BuildingAddresses ()
    {
        $result=BuildingPage::get()->sort('"Title"');
        return $result;
    }
    
    public function SubBuildingListPages(){
    	return BuildingListPage::get()->filter(array('ParentID' => $this->ID))->sort('"BuildingSource" ASC');
    }
    
}
