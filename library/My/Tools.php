<?php

class My_Tools {

    public function getUser() 
    {
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity())
        {
            $user = $auth->getIdentity();
        }  
        return $user;
    }

    public function createXml($tab) {

    	$json = json_encode($tab);
        $xml = '<a>' . '<![CDATA[' . $json . ']]>' . '</a>';
        $result = simplexml_load_string($xml);
        return $result;
    }
}

?>