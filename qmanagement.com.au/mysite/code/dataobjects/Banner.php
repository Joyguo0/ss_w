<?php

class Banner extends DataObject
{

    private static $singular_name = 'Banner Image';

    private static $plural_name = 'Banner Images';

    private static $db = array(
            'Title' => 'Varchar(255)',
            'Content'		=> 'HTMLText'
    );
    
    private static $summary_fields = array(
    		'Image.CMSThumbnail' => 'Image',
    		'Title' => 'Title',
    		'Link' => 'Link'
    );

    private static $has_one = array(
            'Page' => 'SiteTree',
            'SiteConfig' => 'SiteConfig',
            'Link' => 'Link',
            'Image' => 'Image'
    );

    public function getCMSFields ()
    {
        $fields = new FieldList(new TabSet('Root'));
        
        $fields->addFieldsToTab('Root.Main', 
                array(
                        TextField::create('Title'),
                        LinkField::create('LinkID', 'Link'),
                        UploadField::create('Image')->setFolderName(
                                'Uploads/Banner'),
                        HtmlEditorField::create('Content'),
                ));
        
        return $fields;
    }
}