<?php

class ContactPage extends UserDefinedForm
{

    public static $icon = 'mysite/images/icons/formpage';

    private static $db = array(
            'Address' => 'Varchar(255)',
            'Call' => 'Varchar(255)',
            'Fax' => 'Varchar(255)',
            'Email' => 'Varchar(255)'
    );

    public function getCMSFields ()
    {
        $fields = parent::getCMSFields();
        
        $fields->addFieldsToTab('Root.Main', 
                array(
                        TextField::create('Address', 'Address'),
                        TextField::create('Call', 'Call'),
                        TextField::create('Fax', 'Fax'),
                        TextField::create('Email', 'Email'),
                ),'Content');
        
        return $fields;
    }
}

class ContactPage_Controller extends UserDefinedForm_Controller
{
}
