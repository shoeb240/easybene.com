<?php
class My_Form_ProjectBid extends Zend_Form
{
    private $_projectId;

    public function __construct(array $params = array())
    {
        $this->_projectId = $params['projectId'];
        parent::__construct();
    }
    
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/project/project-bid')
             ->setName('project_bid_Frm')
             ->setAttrib('onsubmit', 'return project_bid_func()')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
                
        $bidAmount = $this->createElement('text', 'bid_amount');
        $bidAmount->setLabel('Bid Amount')
                       ->addFilters(array('StringTrim', 'Digits'))
                       ->addValidators(array(
                           array('StringLength', false, array(1,20))
                       ))
                       ->setRequired(true)
                       ->addDecorator('NormalInput')
                       ->setAttrib('class', 'normal_input integer_check')
                       ->setAttrib('onchange', 'money_check(this.value)')
                       ->setAttrib('placeholder', 'e.g. Not more than $2000');
        
        $timePeriod = $this->createElement('text', 'time_period');
        $timePeriod->setLabel('Time Period')
                   ->addFilters(array('StringTrim', 'Digits'))
                   ->addValidators(array(
                       array('StringLength', false, array(1,50))
                   ))
                   ->setRequired(true)
                   ->addDecorator('NormalInput')
                   ->setAttrib('class', 'normal_input integer_check')
                   ->setAttrib('placeholder', 'e.g. 5 days');
        
        $message = $this->createElement('textarea', 'message');
        $message->setLabel('Message')
                           ->setRequired(true)
                           ->addDecorator('NormalInput')
                           ->setAttrib('style', 'width:450px;height:100px;')
                           ->setAttrib('placeholder', 'e.g. Your project information');
        

        
        
        
        $attachment = $this->createElement('hidden', 'attach1');
        $attachment->addDecorators(array('BidAttachment'));
        
        $projectId = $this->createElement('hidden', 'projectId');
        $projectId->setValue($this->_projectId);
        
        $this->addElements(array($bidAmount, $timePeriod, $message, $attachment, $projectId));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('SUBMIT MY BID NOW')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'round_gray_button')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'clear', 'style' => 'margin-left:170px;'))));
        $this->addElement($submit);
        
    }
}