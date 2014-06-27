<?php

class PageBanner extends DataObject
{

    private static $db = array(
            'Title' => 'Varchar(255)',
            'Content' => 'HTMLText'
    );

    private static $has_one = array(
            'Link' => 'Link',
            'Image' => 'Image'
    );

    private static $belongs_many_many = array(
            'Pages' => 'Page',
            'SiteConfigs' => 'SiteConfig'
    );

    private static $summary_fields = array(
            'Image.CMSThumbnail' => 'Image',
            'Title' => 'Title',
            'Link' => 'Link'
    );

    public function getCMSFields ()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('SiteConfigs');
        $fields->removeByName('Pages');
        $fields->addFieldToTab('Root.Main', TextField::create('Title'));
        $fields->addFieldToTab('Root.Main',HtmlEditorField::create('Content'));
        $fields->addFieldToTab('Root.Main', 
                LinkField::create('LinkID', 'Link'));
        $fields->addFieldToTab('Root.Main', 
                UploadField::create('Image')->setFolderName('Uploads/Banner'));
        
        return $fields;
    }
    
    // this function creates the thumnail for the summary fields to use
    public function getThumbnail ()
    {
        return $this->Image()->CMSThumbnail();
    }
}