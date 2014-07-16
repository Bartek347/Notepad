<?php

class NoteController extends Zend_Controller_Action
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
        $Notes = new Application_Model_DbTable_Notes();
        $this->view->note = $Notes->fetchAll();
    }

    public function showAction()
    {
        $Notes = new Application_Model_DbTable_Notes();
        $id = $this->getRequest()->getParam('id');
        $this->view->note = $Notes->find($id)->current();
        //if(!$this->view->piosenka) {
        //    throw new Zend_Controller_Action_Exeption(sprinf('Błędne id notatki: %s', $id), 404);            
        //}
    }


}



