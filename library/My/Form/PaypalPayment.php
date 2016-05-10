<?php
class My_Form_PaypalPayment extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post')
             ->setAction('https://www.sandbox.paypal.com/cgi-bin/webscr')
             ->addElementPrefixPath('My_Decorator', '/My/Decorator', 'decorator')
             ->setElementDecorators(array('ViewHelper'));
                
        $this->addElement('hidden', 'cmd', array('value' => '_xclick-subscriptions'));
        $this->addElement('hidden', 'business');
        $this->addElement('hidden', 'return');
        $this->addElement('hidden', 'rm', array('value' => 2));
        $this->addElement('hidden', 'cancel_return');
        $this->addElement('hidden', 'a3');
        $this->addElement('hidden', 'p3', array('value' => 1));
        $this->addElement('hidden', 't3', array('value' => 'Y'));
        $this->addElement('hidden', 'src', array('value' => 1));
        $this->addElement('hidden', 'sra', array('value' => 1));
        $this->addElement('hidden', 'currency_code');
        $this->addElement('hidden', 'lc', array('value' => 'US'));
        $this->addElement('hidden', 'payer_email');
        $this->addElement('hidden', 'charset', array('value' => 'utf-8'));
        $this->addElement('hidden', 'payer_id');
        $this->addElement('hidden', 'item_name');
        $this->addElement('hidden', 'item_id');
        $this->addElement('hidden', 'cbt', array('value' => 'Return to My Site'));
        $this->addElement('hidden', 'notify_url');
        $this->addElement('hidden', 'test_ipn', array('value' => 1));
        $this->addElement('submit', 'submit', array('value' => 'subscribe', 'style' => 'display:none;', 'id' => 'triggerBtn'));
    }
}