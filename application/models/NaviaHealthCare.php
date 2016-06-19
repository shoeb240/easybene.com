<?php
/**
 * Application_Model_NaviaHealthSavings class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaHealthSavings
{
    protected $_id;
    protected $_user_id;
    protected $_balance;
    protected $_portfolio_balance;
    protected $_total_balance;
    protected $_contributions_YTD;
    protected $_employer_contributions_YTD;
    protected $_total_contributions_YTD;    
    protected $_employer_per_pay_amount;
    protected $_employee_per_pay_amount;
    
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