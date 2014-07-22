<?php

require_once 'Zend/Tool/Project/Provider/Abstract.php';
require_once 'Zend/Tool/Project/Provider/Exception.php';

class UsersProvider extends Zend_Tool_Project_Provider_Abstract
{
    public function create($username = '', $password = '')  
    {

        $username = trim(strtolower($username));  
        $password = trim(strtolower($password));  
  
        if ((!$username) || (!$password)) {  
            $this->_registry  
                ->getResponse()  
                ->appendContent("Podaj nazwe konta i haslo.");  
            return;  
        }  
  
        defined('APPLICATION_PATH')  
            || define('APPLICATION_PATH', realpath(dirname(__FILE__) .  
                '/../application'));  
  
        defined('APPLICATION_ENV')  
            || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?  
                getenv('APPLICATION_ENV') : 'development'));  
  
        set_include_path(implode(PATH_SEPARATOR, array(  
            realpath(APPLICATION_PATH . '/../library'),  
            get_include_path(),  
        )));  
  
        require_once 'Zend/Application.php';  
  
        $application = new Zend_Application(  
            APPLICATION_ENV,  
            APPLICATION_PATH . '/configs/application.ini'  
        );  
        $application->bootstrap('db');  
  
        $Users = new Application_Model_DbTable_Users();  
  
        $dane = array(  
            'username' => $username,  
            'password' => $password,  
        );  
  
        $User->createRow($dane)->save(); 
    }
}

