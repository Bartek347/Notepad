<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');

        $this->addElement('hidden', 'plaintext', array(
            'description' => 'Zaloguj się',
            'ignore' => true,
            'decorators' => array(
            array('Description', array('escape'=>false, 'tag'=>'h1')),
                ),
            
        ));
        
        $user = $this->addElement('text', 'username', array(
                'required' => true,
                'filters'    => array('StringTrim'),
                'label'    => false,
                'placeholder' => 'Nazwa Użytkownika',

            ));
        $user->removeDecorator('label');

        $pass = $this->addElement('password', 'password', array(
            'required' => true,
            'placeholder' => 'Hasło',
            ));
 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Zaloguj się',
            ));

       

             $this->clearDecorators();
             $this->addDecorator('FormElements')
                  ->addDecorator('HtmlTag', array('tag' => 'div'))
                  ->addDecorator('Form');


    }
}

