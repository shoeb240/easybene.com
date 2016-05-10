<?php
class My_Form_ReplyMessage extends Zend_Form
{
    private $_action;

    public function __construct($action = '')
    {
      $this->_action = $action;
      parent::__construct();
    }
  
    public function init()
    {
        $this->setMethod('post')
             ->setAction($this->_action)
             ->setName('reply_message_Frm');
        
        //Add message
        $replyMessage = new Zend_Form_Element_TextArea('reply_message');
        $replyMessage->addValidator('StringLength', false, array(0,500))
                         ->setAttrib('style', 'width:870px;height:100px;')
                         ->setRequired(true);
        $this->addElement($replyMessage);
        
        //Add submit button
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Post')
               ->setAttrib('class', 'round_gray_button left')
               ->setAttrib('onclick', 'reply_func()');
        $this->addElement($submit);

    }
}