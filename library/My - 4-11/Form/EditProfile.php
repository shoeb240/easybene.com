<?php
class My_Form_EditProfile extends Zend_Form
{
    private $_profileImage;
    private $_imagePath;

    public function __construct(array $params = array())
    {
        $this->_profileImage = $params['profileImage'];
        $this->_imagePath = $params['imagePath'];
        parent::__construct();
    }
    
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/account/edit-profile')
             ->setName('edit_profile_form')
             ->setAttrib('class', 'left')
             ->setAttrib('onsubmit', 'return edit_profile_func()')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
        
        $profileImage = $this->createElement('hidden', 'profile_image');
        $profileImage->setAttrib('class', 'normal_input')
                     ->setAttrib('id', 'show_image_name')
                     ->setValue($this->_profileImage)
                     ->setDecorators(array(array(
                         'ViewScript', 
                         array('viewScript' => 'account/_edit-profile-image.phtml',
                               'class'      => 'foto_box',
                               'loadingImage' => '/images/loading.gif',
                               'profileImage' => $this->_profileImage,
                               'imagePath' => $this->_imagePath)
                     )));
        
        $fullName = $this->createElement('text', 'full_name');
        $fullName->setLabel('Full Name')
                     ->addFilters(array('StringTrim'))
                     ->addValidators(array(
                         array('NotEmpty', true),
                     ))
                     ->setRequired(true)
                     ->addDecorator('NormalInput')
                     ->setAttrib('class', 'normal_input')
                     ->setAttrib('placeholder', 'e.g. John Doe');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email Address')
                     ->addFilters(array('StringTrim'))
                     ->addValidators(array(
                         'EmailAddress'
                     ))
                     ->setRequired(true)
                     ->addDecorator('NormalInput')
                     ->setAttrib('class', 'normal_input')
                     ->setAttrib('placeholder', 'e.g. john@domain.com');
        
        $contactNo = $this->createElement('text', 'contact_no');
        $contactNo->setLabel('Contact Number')
                  ->addFilters(array('StringTrim'))
                  ->addValidators(array(
                      array('StringLength', false, array(6,30)),
                  ))
                  ->setRequired(true)
                  ->addDecorator('NormalInput')
                  ->setAttrib('class', 'normal_input')
                  ->setAttrib('placeholder', 'e.g. +65 9000 0000');
        
        $company = $this->createElement('text', 'company');
        $company->setLabel('Company')
                ->addFilters(array('StringTrim'))
                ->addDecorator('NormalInput')
                ->setAttrib('class', 'normal_input')
                ->setAttrib('placeholder', 'e.g. 3lance Holdings Pte Ltd');
        
        $nricRocNumber = $this->createElement('text', 'NRIC_ROC_number');
        $nricRocNumber->setLabel('NRIC / ROC Number')
                      ->addFilters(array('StringTrim'))
                      ->addDecorator('NormalInput')
                      ->setAttrib('class', 'normal_input')
                      ->setAttrib('placeholder', 'e.g. S801234D');
        
        
        $this->addElements(array($profileImage, $fullName, $email, $contactNo, $company, $nricRocNumber));
        
        $submit = new Zend_Form_Element_Submit('user_signup');
        $submit->setLabel('Update Profile')
               ->setAttrib('class', 'round_gray_button left')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'clear'))));
        $this->addElement($submit);
        
        $this->addDisplayGroup(array($fullName, $email, $contactNo, $company, $nricRocNumber, $submit), 'divFields');
        $displayGroup = $this->getDisplayGroup('divFields');
        $displayGroup->setDecorators(array('FormElements', array('HtmlTag', array('tag' => 'div', 'class' => 'left', 'id' => 'registration_form'))));
        
    }
}