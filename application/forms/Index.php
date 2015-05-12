<?php
/**
 * Created by PhpStorm.
 * User: aso@ccp
 * Date: 12.05.15
 * Time: 13:10
 */
class Application_Form_Index extends Zend_Form
{
    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
//        $decors = array(
//            array('Label', array('tag' => 'dt', 'class' => 'col-sm-2 control-label')),
//            array('HtmlTag', array('tag' => 'dd', 'class' => 'col-sm-10')),
//        );
            // Add an email element

        $email = new Zend_Form_Element_Text ('email');
        $email-> setRequired(true)
              -> setOptions(array(
                    'type'=>'email',
                    'id'=>"inputEmail3",
                                    'class' => 'form-control',
                                    'name' => 'email',
                                    'placeholder' => 'Email.',
                                    'data-bv-notempty-message' => 'The password is required')
        )
              ->setDecorators(array('ViewHelper'))
              ->setAttribs(array('required' => true, 'type' => 'email'));

        $password = new Zend_Form_Element_Password ('password');
        $password   -> setRequired(true)
                    -> setOptions(array(
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


//        // Add the comment element
//        $this->addElement('textarea', 'comment', array(
//            'label'      => 'Please Comment:',
//            'required'   => true,
//            'validators' => array(
//                array('validator' => 'StringLength', 'options' => array(0, 20))
//            )
//        ));
//
//        // Add a captcha
//        $this->addElement('captcha', 'captcha', array(
//            'label'      => 'Please enter the 5 letters displayed below:',
//            'required'   => true,
//            'captcha'    => array(
//                'captcha' => 'Figlet',
//                'wordLen' => 5,
//                'timeout' => 300
//            )
//        ));
//
//        // Add the submit button
//        $this->addElement('submit', 'submit', array(
//            'ignore'   => true,
//            'label'    => 'Sign Guestbook',
//        ));
//
//        // And finally add some CSRF protection
//        $this->addElement('hash', 'csrf', array(
//            'ignore' => true,
//        ));
    }
}