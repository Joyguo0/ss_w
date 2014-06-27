<?php

class PageControllerExtension extends Extension {
	
	public function setMessage($type, $message)
    {  
        Session::set('Message', array(
            'MessageType' => $type,
            'Message' => $message
        ));
    }
 
    public function getMessage()
    {
        if($message = Session::get('Message')){
            Session::clear('Message');
            $array = new ArrayData($message);
            return $array->renderWith('Message');
        }
    }
	
}