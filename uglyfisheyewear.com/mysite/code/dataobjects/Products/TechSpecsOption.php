<?php

class TechSpecsOption extends DataObject
{
    private static $db = array(
            'Title' => 'Varchar(255)',
            'Description' => 'Text',
            'SortOrder' => 'Int',
    );

    private static $has_one = array(
            'Product' => 'Product',
            'Image' => 'Image'
    );

    public function getCMSFields ()
    {
        $fields = new FieldList(new TabSet('Root'));
        
        $fields->addFieldsToTab('Root.Main', 
                array(
                        TextField::create('Title'),
                        UploadField::create('Image')->setFolderName(
                                'Uploads/Banner'),
                        TextareaField::create('Description'),
                ));
        
        return $fields;
    }
}