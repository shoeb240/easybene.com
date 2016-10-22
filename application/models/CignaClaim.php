<?php
/**
 * Application_Model_CignaClaim class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaim
{
    protected $_id;
    protected $_userId;
    protected $_service_date;
    protected $_provided_by;
    protected $_for;
    protected $_status;
    protected $_amount_billed;
    protected $_what_your_plan_paid;
    protected $_my_account_paid;
    protected $_what_i_owe;
    protected $_claim_number;
    
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