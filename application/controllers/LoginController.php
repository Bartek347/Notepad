<?php

class LoginController extends Zend_Controller_Action
{
    
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
        $form = new Application_Form_Login();
        if ($form->isValid($_POST)) {
            $adapter = new Zend_Auth_Adapter_DbTable(  
                null,
                'users',
                'username', 
                'password',
                'md5(?)'
                );  

            $adapter->setIdentity($form->getValue('username'));
            $adapter->setCredential($form->getValue('password'));

            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
            if ($result->isValid()) {
                //Zend_Session::rememberMe(60 * 10);
                Zend_Session::start();
                return $this->_helper->redirector(
                    'index',
                    'disp',
                    'default'
                );
            }
            $form->password->addError('Bledna proba logowania!');
        }
        
        $this->_helper->redirector(
                    'index',
                    'login',
                    'default'
        );
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        return $this->_helper->redirector(
            'index',
            'login',
            'default'
        );
    }


}





