<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->addElement('text','username', array(
            'label'=> 'Benutzername',
            'required'=> true
        ));
        $this->addElement('text', 'passwort', array(
            'label'=>'Passwort',
            'required'=>true
        ));
    }


}

