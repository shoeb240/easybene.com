<?php
class My_Form_Signup extends Zend_Form
{
    private $_primaryCategories;
    private $_membershipList;

    public function __construct(array $params = array())
    {
        $this->_primaryCategories = $params['primaryCategories'];
        $this->_membershipList = $params['membershipList'];
        parent::__construct();
    }
    
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/index/signup')
             ->setName('sign_up_form')
             ->setAttrib('class', 'left')
             ->setAttrib('onsubmit', 'return suign_up_func()')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
        
        $profileImage = $this->createElement('hidden', 'profile_image');
        $profileImage->setAttrib('class', 'normal_input')
                     ->setDecorators(array(array(
                         'ViewScript', 
                         array('viewScript' => 'index/_signup-profile-image.phtml',
                               'class'      => 'foto_box',
                               'loadingImage' => '/images/loading.gif')
                     )));
        
        $username = $this->createElement('text', 'username');
        $username->setLabel('Username')
                     ->addFilters(array('StringTrim'))
                     ->addValidators(array(
                         array('StringLength', false, array(3,50)),
                     ))
                     ->setRequired(true)
                     ->addDecorator('NormalInput')
                     ->setAttrib('class', 'normal_input')
                     ->setAttrib('placeholder', 'Username');
        
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
        
        $country = $this->createElement('select', 'country');
        $country->setLabel('Country')
                ->setRegisterInArrayValidator(false) 
                ->addValidators(array(
                    array('NotEmpty', true),
                ))
                ->setRequired(true)
                ->setDecorators(array(array('ViewScript', array(
                         'viewScript' => 'index/_country-dropdown.phtml',
                         'class'      => 'drop'
                       ))));
//                          ->addDecorator('NormalInput')
//                          ->setAttrib('class', 'drop')
//                          ->addMultiOption('', 'Select Category')
//                          ->addMultiOption('abc', 'ABC')
//                          ->addMultiOption('def', 'DEF');

        $state = $this->createElement('text', 'state');
        $state->setLabel('State/Province')
              ->addFilters(array('StringTrim'))
              ->addDecorator('NormalInput')
              ->setAttrib('class', 'normal_input')
              ->setAttrib('placeholder', 'e.g. Alabama');
        
        $city = $this->createElement('text', 'city');
        $city->setLabel('City/Town')
             ->addFilters(array('StringTrim'))
             ->addDecorator('NormalInput')
             ->setAttrib('class', 'normal_input')
             ->setAttrib('placeholder', 'e.g. London');
        
        $password = $this->createElement('password', 'password');
        $password->setLabel('Password')
                 ->addValidators(array(
                     array('NotEmpty', true),
                 ))
                 ->setRequired(true)
                 ->addDecorator('NormalInput')
                 ->setAttrib('class', 'normal_input')
                 ->setAttrib('placeholder', 'e.g. 123456');
        
        $retypePassword = $this->createElement('password', 'retype_password');
        $retypePassword->setLabel('Retype Password')
                       ->addValidators(array(
                           array('identical', false, array('token' => 'password'))
                       ))
                       ->setRequired(true)
                       ->addDecorator('NormalInput')
                       ->setAttrib('class', 'normal_input')
                       ->setAttrib('placeholder', 'retype your password');
        
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
        
        
        $primaryCategoryId = $this->createElement('select', 'primary_category_id');
        $primaryCategoryId->setLabel('Primary Category')
                          ->setRequired(true)
                          ->addDecorator('NormalInput')
                          ->setAttrib('class', 'dropdown left')
                          ->setAttrib('style', 'color: grey;')
                          ->addMultiOption('', 'Select Category');
        foreach($this->_primaryCategories as $primaryCategory) {
            $primaryCategoryId->addMultiOption($primaryCategory->getPrimaryCategoryId(), $primaryCategory->getCategoryTitle());
        }
        
        
        $membershipId = $this->createElement('select', 'membership_id');
        $membershipId->setLabel('Premium Membership')
                     ->addDecorator('NormalInput')
                     ->setAttrib('class', 'dropdown left')
                     ->setAttrib('style', 'color: grey;')
                     ->addMultiOption('', 'Select Category')
                     ->setDecorators(array(
                         'ViewScript', 
                         array('abc' => 'ViewScript', 
                               array('viewScript' => 'index/_membership-dropdown.phtml',
                                     'display' => (!empty($this->_membershipList) ? true : false)
                         )
                     )));
        foreach($this->_membershipList as $membership) {
            $membershipId->addMultiOption($membership->getMembershipId(), $membership->getMembership());
        }
        

        $this->addElements(array($profileImage, $username, $fullName, $email, $country, $state, $city, $password, $retypePassword, $contactNo, $company, $nricRocNumber, $primaryCategoryId, $membershipId));
        
        $submit = new Zend_Form_Element_Submit('user_signup');
        $submit->setLabel('SIGN UP NOW, WHY WAIT?')
               ->setAttrib('class', 'round_gray_button left')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'clear'))));
        $this->addElement($submit);
        
        $this->addDisplayGroup(array($username, $fullName, $email, $country, $state, $city, $password, $retypePassword, $contactNo, $company, $nricRocNumber, $primaryCategoryId, $membershipId, $submit), 'divFields');
        $displayGroup = $this->getDisplayGroup('divFields');
        $displayGroup->setDecorators(array('FormElements', array('HtmlTag', array('tag' => 'div', 'class' => 'left'))));
        
    }
}