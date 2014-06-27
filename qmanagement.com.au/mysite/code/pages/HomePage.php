<?php

/**
 *
 */
class HomePage extends SiteTree
{

    public static $icon = 'mysite/images/icons/homepage';

    private static $db = array();

    private static $has_one = array();

    private static $has_many = array(
            'Gallerys' => 'Gallery',
            'Banners' => 'Banner'
    );

    public function getCMSFields ()
    {
        $fields = parent::getCMSFields();
        $GallerysSections = GridField::create('Slideshow', 'Slideshow', 
                $this->Gallerys(), GridFieldConfig_RelationEditor::create());
        $fields->addFieldToTab('Root.Slideshow', $GallerysSections);
        
        $BannersSections = GridField::create('Banners', 'Banners',
                $this->Banners(), GridFieldConfig_RelationEditor::create());
        $fields->addFieldToTab('Root.Banners', $BannersSections);
        return $fields;
    }
}

class HomePage_Controller extends Page_Controller
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
        $result=Store::get()->sort('"Title"');
        return $result;
    }
    
}
