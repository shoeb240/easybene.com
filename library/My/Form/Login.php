<?php
class My_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/index/login')
             ->setName('member_login')
             ->setAttrib('class', 'left')
             ->setAttrib('onsubmit', 'return validateStandard(this)')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->clearDecorators();
                
        $username = $this->createElement('text', 'username');
        $username->setLabel('Username or email :')
                 ->addFilters(array('StringTrim', 'Alnum'))
                 ->addValidators(array(
                     array('StringLength', false, array(6,10)),
                     array('NotEmpty', false),
                 ))
                 ->setRequired(true)
                 ->setDecorators(array('ViewHelper', 'LoginInput'))
                 ->setAttrib('class', 'normal_input')
                 ->setAttrib('placeholder', 'Username or Email')
                 ->setAttrib('required', 1);
        $this->addElement($username);
        
        $password = $this->createElement('password', 'password');
        $password->setLabel('Password :')
                 ->addValidators(array(
                     array('StringLength', false, array('min' => 6, 'max' => '12'))
                 ))
                 ->setRequired(true)
                 ->setDecorators(array('ViewHelper', 'LoginInput'))
                 ->setAttrib('class', 'normal_input')
                 ->setAttrib('placeholder', 'Password')
                 ->setAttrib('required', 1);
        $this->addElement($password);
        
        // checkbox
        $checkbox = new Zend_Form_Element_Checkbox('keep_loggedin');
        $checkbox->setLabel('Log me in for 2 weeks')
                 ->setCheckedValue('yes')
                 ->setUncheckedValue('No')
                 ->setDecorators(array('ViewHelper', 'CheckboxRight'))
                 ->setDescription('<p class="right sec"><span class="left">Forgot your password? </span>&nbsp;<a href="index/forgot_password" class="back_to right"> Click here to reset it.</a></p>
                     <div class="clear"></div>');
        $this->addElement($checkbox);
        
        $submit = new Zend_Form_Element_Submit('userLogin');
        $submit->setLabel('LOG ME IN!')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'round_gray_button right');
        $this->addElement($submit);
        
    }
}