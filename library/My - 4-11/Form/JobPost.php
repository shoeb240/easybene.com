<?php
class My_Form_JobPost extends Zend_Form
{
    private $_primaryCategories;

    public function __construct(array $params = array())
    {
        $this->_primaryCategories = $params['primaryCategories'];
        parent::__construct();
    }
    
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/project/project-submit')
             ->setName('submit_proj')
             ->setAttrib('class', 'left')
             ->setAttrib('onsubmit', 'return submit_project_func()')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->addDisplayGroupPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
                
        $projectTitle = $this->createElement('text', 'project_title');
        $projectTitle->setLabel('Project Title')
                     ->addFilters(array('StringTrim', 'Alnum'))
                     ->addValidators(array(
                         array('StringLength', false, array(6,50)),
                         array('NotEmpty', true),
                     ))
                     ->setRequired(true)
                     ->addDecorator('NormalInput')
                     ->setAttrib('class', 'normal_input')
                     ->setAttrib('placeholder', 'e.g. Title of Project');
        
        $projectDescription = $this->createElement('textarea', 'project_description');
        $projectDescription->setLabel('Description')
                           ->setRequired(true)
                           ->addDecorator('NormalInput')
                           ->setAttrib('class', 'small_rounded text_area')
                           ->setAttrib('style', 'width:450px;height:50px;')
                           ->setAttrib('placeholder', 'e.g. Your project information');
        
        $primaryCategoryId = $this->createElement('select', 'primary_category_id');
        $primaryCategoryId->setLabel('Primary Category')
                          ->addValidators(array(
                              array('NotEmpty', true),
                          ))
                          ->setRequired(true)
                          ->addDecorator('NormalInput')
                          ->setAttrib('class', 'dropdown left')
                          ->setAttrib('style', 'color: grey;')
                          ->addMultiOption('', 'Select Category');
        foreach($this->_primaryCategories as $primaryCategory) {
            $primaryCategoryId->addMultiOption($primaryCategory->getPrimaryCategoryId(), $primaryCategory->getCategoryTitle());
        }
        
        $cost = $this->createElement('text', 'cost');
        $cost->addFilters(array('StringTrim'))
             ->addValidators(array(
                 array('NotEmpty', true),
             ))
             ->setRequired(true)
             ->setAttrib('class', 'normal_input normal_input integer_check')
             ->setAttrib('placeholder', 'e.g. $1,000 - $2,000')
             ->setAttrib('onkeypress', 'getIt(this);');
        
        $currencyCode = $this->createElement('select', 'CurrencyCode');
        $currencyCode->setRequired(true)
                     ->setAttrib('style', 'color: grey;')
                     ->addMultiOption('USD', 'USD')
                     ->addMultiOption('SGD', 'SGD');
        
        $bidEndingDate = $this->createElement('text', 'bid_ending_date');
        $bidEndingDate->setLabel('Bid Ending Date')
                      ->addFilters(array('StringTrim'))
                      ->addValidators(array(
                          array('Date', false, array('format' => 'dd MM yyyy')),
                          array('NotEmpty', false),
                      ))
                      ->setRequired(true)
                      ->addDecorator('NormalInput')
                      ->setAttrib('class', 'normal_input')
                      ->setAttrib('placeholder', 'e.g. 09 May 2012');
        
        $additionalRemarks = $this->createElement('text', 'additional_remarks');
        $additionalRemarks->setLabel('Additional Remarks')
                          ->addFilters(array('StringTrim'))
                          ->addDecorator('NormalInput')
                          ->setAttrib('class', 'normal_input')
                          ->setAttrib('placeholder', 'e.g. Extra information required.');

        
        $attachment = $this->createElement('hidden', 'attach1');
        $attachment->addDecorators(array('Attachment'));
        
        $this->addElements(array($projectTitle, $projectDescription, $attachment, $primaryCategoryId, $cost, $currencyCode, $bidEndingDate, $additionalRemarks));

        $this->addDisplayGroup(array($primaryCategoryId), 'divLeft');
        $displayGroup = $this->getDisplayGroup('divLeft');
        $displayGroup->setDecorators(array('FormElements', array('HtmlTag', array('tag' => 'div', 'class' => 'left'))));
        
        $this->addDisplayGroup(array($cost, $currencyCode), 'divLeftCost');
        $displayGroup = $this->getDisplayGroup('divLeftCost');
        $displayGroup->setDecorators(array('FormElements', 'CostDisplayGroup'));
        
        $this->addDisplayGroup(array($bidEndingDate, $additionalRemarks), 'divLeft2');
        $displayGroup = $this->getDisplayGroup('divLeft2');
        $displayGroup->setDecorators(array('FormElements', 'LeftDisplayGroup'));
        
        $additionalInfo = $this->createElement('MultiCheckbox', 'additional_info');
        $additionalInfo->addMultiOption('Meet up required', 'Meet up required')
                       ->addMultiOption('Milestone payments', 'Milestone payments (e.g. deposit payments)')
                       ->addMultiOption('Require portfolio', 'Require portfolio / proposal for submission')
                       ->addDecorators(array('AdditionalInfo'));
        $this->addElement($additionalInfo);

        
        $submit = new Zend_Form_Element_Submit('userLogin');
        $submit->setLabel('SUBMIT MY PROJECT NOW')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'round_gray_button')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'clear'))));
        $this->addElement($submit);
        
    }
}