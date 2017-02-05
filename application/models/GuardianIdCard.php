<?php
/**
 * Application_Model_GuardianMedical class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianIdCard
{
    protected $_id;
    protected $_user_id;
    protected $_pdf_dl;
    protected $_subscriber;
    protected $_card_id;
    protected $_plan_number;
    protected $_member_id;
    protected $_customer_response_unit;
    
    public function setOption($field, $value)
    {
        $key = '_' . $field;
        $this->$key = $value;
    }
    
    public function getOption($field)
    {
        $key = '_' . $field;
        return $this->$key;
    }
}