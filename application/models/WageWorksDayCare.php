<?php
/**
 * Application_Model_WageWorksDayCare class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_WageWorksDayCare
{
    protected $_id;
    protected $_user_id;
    protected $_claim;
    protected $_annual_election;
    protected $_available_balance;
    protected $_date_posted_d;
    protected $_date_posted_M;
    protected $_date_posted_Y;
    protected $_transaction_type;
    protected $_claim_amount;    
    protected $_amount;
    
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