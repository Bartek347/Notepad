<?php

class NoteClass 
{
    public function sayHello($name)
    {
        $message = 'Hello '.$name;
        return $message;
    }

    public function index() 
    {   
        $Notes = new Application_Model_DbTable_Notes(); 
        $notes = $Notes->fetchAll();

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
        }  

        $json_tab = array();
        $i = 0;
        foreach ($notes as $note) {
            $users = $note->findParentRow('Application_Model_DbTable_Users');

            $id = $note['id'];
            $tytul = $note['title'];
            $data = $note['date'];
            $content = $note['content_data'];
            $nazwa = $users['username'];

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
        $notes = $Notes->find($id)->current();
        $users = $notes->findParentRow('Application_Model_DbTable_Users');        

        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
        }  

        $id = $notes['id'];
        $tytul = $notes['title'];
        $content = $notes['content_data'];
        $data = $notes['date'];
        $nazwa = $users['username'];

        $tab = array(
                'id' => $id,
                'title' => $tytul,
                'description' => $content,
                'time' => $data, 
                'author' => $nazwa,
                'username' => $user
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
}

?>