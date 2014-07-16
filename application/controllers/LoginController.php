<?php

class LoginController extends Zend_Controller_Action
{

    /*public function preDispatch()
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
    }*/

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->form = new Application_Form_Login();
    }

    public function loginAction()
    {
        $this->_helper->viewRenderer('index');
        $form = new Application_Form_Login();
        if ($form->isValid($this->getRequest()->getPost())) {

            $adapter = new Zend_Auth_Adapter_DbTable(  
                null,  
                'user',  
                'username',  
                'password',  
                'MD5(CONCAT(?, salt))'  
                );  

            $adapter->setIdentity($form->getValue('username'));
            $adapter->setCredential($form->getValue('password'));

            $auth = Zend_Auth::getInstance();

            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                return $this->_helper->redirector(
                    'login',
                    'index',
                    'default'
                );
            }
            $form->password->addError('Błędna próba logowania!');
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector(
            'login',
            'index',
            'default'
        );
    }


}





