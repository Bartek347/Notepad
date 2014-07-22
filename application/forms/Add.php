<?php

class Application_Form_Add extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');

        $this->addElement('text', 'title', array(
                'label' => 'Tytul:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
        $this->addElement('textarea', 'content_data', array(
                'required' => true,
                'filters'    => array('StringTrim'),
            ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Dodaj',
            ));
    }
}

