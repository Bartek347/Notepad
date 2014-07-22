<?php

class Application_Model_DbTable_Notes extends Zend_Db_Table_Abstract
{

    protected $_name = 'notes';
    protected $_referenceMap = array(
    	'Users' => array(
    		'columns' 			=> array('u_id'),
    		'refTableClass'		=> 'Application_Model_DbTable_Users',
    		'refTableColumns'	=> array('u_id')
    		)
    	);
}

