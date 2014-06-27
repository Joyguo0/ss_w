<?php

class SiteConfigExtension extends DataExtension
{

    private static $db = array(
            'FootContent1' => 'HTMLText',
            'FootContent2' => 'HTMLText',
            'FootContent3' => 'HTMLText',
            'FootContent4' => 'HTMLText',
            'FootLink' => 'HTMLText',
            'Copyright' => 'Varchar(200)',
            'ABN' => 'Varchar(100)'
    );

    private static $has_one = array(
            'Toplogo' => 'Image',
            'Footlogo' => 'Image'
    );

    private static $has_many = array();

    private static $many_many = array(
            'Resources' => 'Resource',
            'PageBanners' => 'PageBanner'
    );

    private static $many_many_extraFields = array(
            'Resources' => array(
                    'Sort' => 'Int'
            ),
            'PageBanners' => array(
                    'Sort' => 'Int'
            )
    );

    public function updateCMSFields (FieldList $fields)
    {
        $fields->addFieldsToTab("Root.Header", 
                array(
                        UploadField::create('Toplogo')->setFolderName(
                                'Uploads/Logo')
                ));
        $fields->addFieldsToTab("Root.Footer.General", 
                array(
                        UploadField::create('Footlogo')->setFolderName(
                                'Uploads/Logo')
                ));
        $fields->addFieldToTab('Root.Footer.General', 
                TextareaField::create('ABN'));
        $fields->addFieldToTab('Root.Footer.General', 
                TextareaField::create('Copyright'));
        
        $fields->addFieldsToTab("Root.Footer.Column1", 
                array(
                        HtmlEditorField::create('FootContent1', 
                                'Column 1 Content')
                ));
        $fields->addFieldsToTab("Root.Footer.Column2", 
                array(
                        HtmlEditorField::create('FootContent2', 
                                'Column 2 Content')
                ));
        $fields->addFieldsToTab("Root.Footer.Column3", 
                array(
                        HtmlEditorField::create('FootContent3', 
                                'Column 3 Content')
                ));
        $fields->addFieldsToTab("Root.Footer.Column4", 
                array(
                        HtmlEditorField::create('FootContent4', 
                                'Column 4 Content')
                ));
        
        /**
         * **********************************Page
         * Banners******************************************
         */
        $pBannersConfig = GridFieldConfig_RelationEditor::create()->addComponent(
                new GridFieldOrderableRows('Sort'))->addComponent(
                new GridFieldManyRelationHandler());
        $fields->addFieldToTab('Root.Defaults.PageBanners', 
                GridField::create('PageBanners', 'Page Banners', 
                        $this->owner->PageBanners()
                            ->sort(
                                array(
                                        'Sort' => 'ASC'
                                )), $pBannersConfig));
    /**
     * ****************************************************************************
     */
    }
    public function Resources() {
        return $this->owner->getManyManyComponents ( 'Resources' )->sort ( 'Sort' );
    }
    public function LoadSiteConfigResources() {
        return $this->Resources ();
    }
    public function PageBanners() {
        return $this->owner->getManyManyComponents ( 'PageBanners' )->sort ( 'Sort' );
    }
    public function LoadSiteConfigPageBanners() {
        return $this->PageBanners ();
    }
}
