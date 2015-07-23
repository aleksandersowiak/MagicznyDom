<?php

/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 12.05.15
 * Time: 13:10
 */
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');

        $email = new Zend_Form_Element_Text('email');
        $email->setRequired(true)
            ->setOptions(array(
                    'type' => 'email',
                    'id' => "inputEmail3",
                    'class' => 'form-control',
                    'name' => 'email',
                    'placeholder' => 'Email.',
                    'data-bv-notempty-message' => 'The password is required')
            )
            ->setDecorators(array('ViewHelper'))
            ->setAttribs(array('required' => true, 'type' => 'email'));

        $password = new Zend_Form_Element_Password ('password');
        $password->setRequired(true)
            ->setOptions(array(
                    'id' => 'inputPassword3',
                    'class' => 'form-control',
                    'name' => 'password',
                    'placeholder' => 'Password.',
                    'data-bv-notempty-message' => 'The password is required')
            )
            ->setDecorators(array('ViewHelper'))
            ->setAttrib('required', true);;

        $this->addElements(array(
            $email,
            $password,
        ));
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }
}