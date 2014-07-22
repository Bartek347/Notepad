<?php

class NoteController extends Zend_Controller_Action
{

    public function preDispatch()
    {
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            return $this->_helper->redirector(
                'index',
                'login',
                'default'
            );
        }
        $this->view->identity = $auth->getIdentity();
    }

    public function init()
    {   
        $auth = Zend_Auth::getInstance();  
        $server = new Zend_Rest_Server();
        $server->setClass('My_Note');
        $server->handle();
        exit;     
    }
}

?>