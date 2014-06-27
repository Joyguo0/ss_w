<?php

class AccountPageExtension extends DataExtension
{

    public function Addresses ()
    {
        if ($id = Customer::currentUserID()) {
            return Address::get()->where("\"MemberID\" = " . $id);
        }
        return false;
    }
}

class AccountPageExtension_Controller extends DataExtension
{

    static $allowed_actions = array(
            'editprofile',
            'MemberForm',
            'editaddress',
            'AddressForm'
    );

    public static $url_handlers = array(
            'editaddress/$id' => 'editaddress'
    );

    public function init ()
    {
        parent::init();
    }

    public function editprofile ()
    {
        $member = Member::currentUser();
        if (! $member) {
            return Security::permissionFailure();
        }
        return array(
                'Title' => 'Edit Profile'
        );
    }

    public function MemberForm ($type = "edit")
    {
        $member = Member::currentUser();
        $memberEmail = $member ? $member->Email : false;
        $fields = FieldList::create(
                ReadonlyField::create("Email", "Email", $memberEmail), 
                ConfirmedPasswordField::create('UpdatePassword', 
                        'Update Password (Leave it blank if you are not changing it)')->setCanBeEmpty(
                        true), TextField::create("FirstName", "First Name *"), 
                TextField::create("Surname", "Lastname *"));
        
        $actions = FieldList::create(
                FormAction::create("SaveProfile", "Update Profile"));
        
        $validator = RequiredFields::create(
                array(
                        "FirstName",
                        "Surname"
                ));
        $form = Form::create($this, "MemberForm", $fields, $actions, $validator)->setController(
                Controller::curr());
        
        $member = Member::currentUser();
        if ($member) {
            $form->loadDataFrom($member);
        }
        
        return $form;
    }

    public function SaveProfile ($data, $form)
    {
        $member = Member::currentUser();
        $form->saveInto($member);
        if (isset($data['UpdatePassword']['_Password']) &&
                 strlen($data['UpdatePassword']['_Password'])) {
            $member->changePassword($data['UpdatePassword']['_Password']);
        }
        
        $member->write();
        
        $form->sessionMessage('Your details were updated successfully', 'good');
        
        return $this->owner->redirectBack();
    }

    public function editaddress ()
    {
        $member = Member::currentUser();
        if (! $member) {
            return Security::permissionFailure();
        }
        return array(
                'Title' => 'Edit Address'
        );
    }

    public function AddressForm ()
    {
        $param = Controller::curr()->getRequest()->latestParams();
        
        $fields = new FieldList();
        
        $billingAddressFields = CompositeField::create(
                DropdownField::create('ClassName','BILLING/DELIVERY',array('Address_Shipping'=>'Shipping','Address_Billing'=>'Billing')),
                HiddenField::create('MemberID', 'MemberID', 
                        Member::currentUser()->ID), 
                TextField::create('FirstName', 
                        _t('CheckoutPage.FIRSTNAME', "First Name"))->setCustomValidationMessage(
                        _t('CheckoutPage.PLEASEENTERYOURFIRSTNAME', 
                                "Please enter your first name."))->addExtraClass(
                        'address-break'), 
                TextField::create('Surname', 
                        _t('CheckoutPage.SURNAME', "Surname"))->setCustomValidationMessage(
                        _t('CheckoutPage.PLEASEENTERYOURSURNAME', 
                                "Please enter your surname.")), 
                TextField::create('Company', 
                        _t('CheckoutPage.COMPANY', "Company")), 
                TextField::create('Address', 
                        _t('CheckoutPage.ADDRESS', "Address"))->setCustomValidationMessage(
                        _t('CheckoutPage.PLEASEENTERYOURADDRESS', 
                                "Please enter your address."))->addExtraClass(
                        'address-break'), 
                TextField::create('AddressLine2', '&nbsp;'), 
                TextField::create('City', _t('CheckoutPage.CITY', "City"))->setCustomValidationMessage(
                        _t('CheckoutPage.PLEASEENTERYOURCITY', 
                                "Please enter your city")), 
                TextField::create('PostalCode', 
                        _t('CheckoutPage.POSTALCODE', "Zip / Postal Code")), 
                TextField::create('State', 
                        _t('CheckoutPage.STATE', "State / Province"))->addExtraClass(
                        'address-break'), 
                DropdownField::create('CountryCode', 
                        _t('CheckoutPage.COUNTRY', "Country"), 
                        Country_Billing::get()->map('Code', 'Title')->toArray())->setCustomValidationMessage(
                        _t('CheckoutPage.PLEASEENTERYOURCOUNTRY', 
                                "Please enter your country.")),
                CheckboxField::create('Default','Default')
                )->setID('Address')->setName(
                'Address');
        
        $fields->push($billingAddressFields);
        if (isset($param['id']) && $id = $param['id']) {
            $fields->push(HiddenField::create('ID', 'ID', $param['id']));
        } 
        
        $actions = FieldList::create(
                FormAction::create("SaveAddress", "Save Address"));
        
        $validator = RequiredFields::create(
                array(
                        "FirstName",
                        "Surname",
                        "Company",
                        "Address",
                        "City",
                        "PostalCode",
                        'State'
                ));
        $form = Form::create($this, "AddressForm", $fields, $actions, 
                $validator)->setController(Controller::curr());
        $param = Controller::curr()->getRequest()->latestParams();
        if (isset($param['id']) && $id = $param['id']) {
            $address = Address::get()->byId($id);
            $form->loadDataFrom($address);
        }
        
        return $form;
    }

    public function SaveAddress ($data, $form){
        if ($data['ID']) {
            $address = Address::get()->byId($data['ID']);
        } else {
            $address = Address::create();
        }
        $form->saveInto($address);
        $address->write();
        
        $form->sessionMessage('Your details were updated successfully', 'good');
        
        return $this->owner->redirectBack();
    }
}

