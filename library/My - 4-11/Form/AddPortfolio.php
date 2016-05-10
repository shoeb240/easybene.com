<?php
class My_Form_AddPortfolio extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/account/add-portfolio')
             ->setName('portfolio_add')
             ->setAttrib('class', 'left')
             ->setAttrib('onsubmit', 'return submit_portfolio_func()')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
                
        $portfolioTitle = $this->createElement('text', 'portfolio_title');
        $portfolioTitle->setLabel('Title')
                       ->addFilters(array('StringTrim'))
                       ->addValidators(array(
                           array('StringLength', false, array(6,50)),
                           array('NotEmpty', true),
                       ))
                       ->setRequired(true)
                       ->addDecorator('NormalInput')
                       ->setAttrib('class', 'normal_input right')
                       ->setAttrib('placeholder', 'e.g. My first portfolio');
        
        $clientName = $this->createElement('text', 'client_name');
        $clientName->setLabel('Client Name')
                   ->addFilters(array('StringTrim'))
                   ->addValidators(array(
                       array('StringLength', false, array(6,50)),
                       array('NotEmpty', true),
                   ))
                   ->setRequired(true)
                   ->addDecorator('NormalInput')
                   ->setAttrib('class', 'normal_input right')
                   ->setAttrib('placeholder', 'e.g. John Doe');
        
        $projectUrl = $this->createElement('text', 'project_url');
        $projectUrl->setLabel('Project URL')
                   ->addFilters(array('StringTrim'))
                   ->addValidators(array(
                       array('StringLength', false, array(4,200)),
                       array('NotEmpty', true),
                   ))
                   ->setRequired(true)
                   ->addDecorator('NormalInput')
                   ->setAttrib('class', 'normal_input right')
                   ->setAttrib('placeholder', 'e.g. http://www.website.com');
        
        $projectDescription = $this->createElement('textarea', 'project_description');
        $projectDescription->setLabel('Description')
                           ->setRequired(true)
                           ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'right small_rounded text_aread'))
                           ->addDecorator('NormalInput')
                           ->setAttrib('class', 'normal_input')
                           ->setAttrib('placeholder', 'e.g. Information about your project');
        

        
        
        
        $portfolioImage = $this->createElement('hidden', 'portfolio_image');
        $portfolioImage->addDecorators(array('PortfolioImage'));
        
        $this->addElements(array($portfolioTitle, $clientName, $projectUrl, $projectDescription, $portfolioImage));

        $submit = new Zend_Form_Element_Submit('userLogin');
        $submit->setLabel('SUBMIT ITEM')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'round_gray_button left full_width submit_add_port')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'contain_buttons clear'))));
        $this->addElement($submit);
        
    }
}