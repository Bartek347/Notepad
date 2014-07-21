<?php

class NoteClass 
{
    /**
    * Write to a file
    *
    * @param string $string
    * @return string Some return message
    */
    public function sayHello($name)
    {
        $message = 'Hello '.$name;
        return $message;
    }

    public function index() 
    {   
        $Notes = new Application_Model_DbTable_Notes();
        $Users = new Application_Model_DbTable_Users(); 
        $not = $Notes->fetchAll();
        $usr = $Users->fetchAll();

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
        }  

        $json_tab = array();
        $i = 0;
        foreach ($not as $n) {
            $id = $n['id'];
            $tytul = $n['title'];
            $data = $n['date'];
            foreach ($usr as $u) {
                if($u['u_id'] === $n['u_id'])
                {                  
                    $nazwa = $u['username'];
                }
            } 
            $content = $n['content_data'];

            $tab = array(
                'id' => $id,
                'title' => $tytul,
                'description' => $content,
                'time' => $data, 
                'author' => $nazwa,  
                'username' => $user
            );
            $json_tab[$i] = $tab;
            $i++;
        }

        $json = json_encode($json_tab);
        $xml = '<a>' . $json.'</a>';
        $show = simplexml_load_string($xml);
        return $show;
    }

    public function show($id)
    {
        $Notes = new Application_Model_DbTable_Notes();
        $Users = new Application_Model_DbTable_Users(); 
        $not = $Notes->select()->where('id = ?', $id);
        $row = $Notes->fetchRow($not);
        $usr = $Users->fetchAll();
        
        $id = $row['id'];
        $tytul = $row['title'];
        $data = $row['date'];
        $content = $row['content_data'];
        foreach ($usr as $u) {
            if($u['u_id'] === $row['u_id'])
                {                  
                    $nazwa = $u['username'];
                }
        }

        $tab = array(
                'id' => $id,
                'title' => $tytul,
                'description' => $content,
                'time' => $data, 
                'author' => $nazwa
        );

        $show = json_encode($tab);
        $result = '[' . $show . ']';
        $xml = '<a>' . $result.'</a>';
        $show = simplexml_load_string($xml);
        return $show;
    }

    public function add($title, $content)
    {
        $Notes = new Application_Model_DbTable_Notes();
        $Users = new Application_Model_DbTable_Users();

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
        }  
        $select = $Users->select()
            ->from('users', array('u_id'))
            ->where('username = ?', $user);

        $user_id = $Users->fetchRow($select);

        $data = array(
            'title'         => $title,
            'content_data'  => $content,
            'date'          => new Zend_Db_Expr('NOW()'),
            'u_id'          => $user_id->u_id
            );
        $id = $Notes->insert($data);
    }

    public function delete($id)
    {
        $Notes = new Application_Model_DbTable_Notes();
        $row = $Notes->find($id)->current();
        $row->delete();
    }
}



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
        $server->setClass('NoteClass');
        $server->handle();
        exit;     
    }

    /*public function indexAction()
    {
        
    }
    public function showAction()
    {   
        $Notes = new Application_Model_DbTable_Notes();
        $id = $this->getRequest()->getParam('id');
        $this->view->note = $Notes->find($id)->current();

        //$id = $this->_getParam('id'); 
        //echo Zend_Json::encode($this->_todo[$id]); 
        $server = new Zend_Rest_Server();
        $server->setClass('NoteClass');
        $server->handle();
        exit;

    }

    public function createAction()
    {
        if($this->getRequest()->isPost()) {
            $form = new Application_Form_Add();
            if($form->isValid($this->getRequest()->getPost())) {

                $tit = $form->getValue(title);
                $da = $form->getValue(content_data);

                $Notes = new Application_Model_DbTable_Notes();
                $Users = new Application_Model_DbTable_Users();

                $auth = Zend_Auth::getInstance();
                if($auth->hasIdentity())
                {
                    $user = $auth->getIdentity();
                    $this->view->username = $user;
                }  
                $select = $Users->select()
                    ->from('users', array('u_id'))
                    ->where('username = ?', $user);

                $user_id = $Users->fetchRow($select);

                $data = array(
                    'title'         => $tit,
                    'content_data'  => $da,
                    'date'          => new Zend_Db_Expr('NOW()'),
                    'u_id'          => $user_id->u_id
                    );
                $id = $Notes->insert($data);
                return $this->_helper->redirector(
                    'show',
                    'note',
                    null,
                    array('id' => $id)
                );
            }
        }
    }

    public function postAction()
    {
        $this->view->form = new Application_Form_Add();
        $url = $this->view->url(array('action' => 'create'));
        $this->view->form->setAction($url);
    }

    public function putAction()
    {

    }

    public function deleteAction()
    {

    }*/


}







