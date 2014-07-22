<?php

class My_Note
{
    public function index() 
    {   
        $Notes = new Application_Model_DbTable_Notes(); 
        $notes = $Notes->fetchAll();

        $tool = new My_Tools();
        $user = $tool->getUser(); 

        $json_tab = array();
        $i = 0;
        foreach ($notes as $note) {

            $users = $note->findParentRow('Application_Model_DbTable_Users');

            $tab = array(
                'id' => $note['id'],
                'title' => $note['title'],
                'description' => $note['content_data'],
                'time' => $note['date'], 
                'author' => $users['username'],  
                'username' => $user
            );
            $json_tab[$i] = $tab;
            $i++;
        }

        $show = $tool->createXml1($json_tab); 
        
        return $show;
    }

    public function show($id)
    {
        $Notes = new Application_Model_DbTable_Notes();
        $notes = $Notes->find($id)->current();
        $users = $notes->findParentRow('Application_Model_DbTable_Users');        

        $tool = new My_Tools();
        $user = $tool->getUser(); 

        $json_tab = array(
                'id' => $notes['id'],
                'title' => $notes['title'],
                'description' => $notes['content_data'],
                'time' => $notes['date'], 
                'author' => $users['username'],
                'username' => $user
        );

        $show = $tool->createXml2($json_tab); 
        return $show;
    }

    public function add($title, $content)
    {
        $Notes = new Application_Model_DbTable_Notes();
        $Users = new Application_Model_DbTable_Users();

        $tool = new My_Tools();
        $user = $tool->getUser(); 

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

?>