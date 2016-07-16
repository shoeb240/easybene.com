<?php
/**
 * Application_Model_NaviaHealthCare class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaHealthCare
{
    protected $_id;
    protected $_user_id;
    protected $_balance;
    protected $_annual_election;
    protected $_reimbursed_to_date;
    protected $_date_posted;    
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