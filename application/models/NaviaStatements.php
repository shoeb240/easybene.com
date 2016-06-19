<?php
/**
 * Application_Model_NaviaStatements class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaStatements
{
    protected $_id;
    protected $_user_id;
    protected $_DC_from_date;
    protected $_DC_to_date;
    protected $_DC_claim;
    protected $_DC_annual_election;
    protected $_DC_last_day_incur_exp;
    protected $_DC_submit_claims;    
    protected $_HC_date_from;
    protected $_HC_date_to;
    protected $_HC_balance;
    protected $_HC_annual_election;
    protected $_HC_last_day_incur_exp;
    protected $_HC_last_day_submit_claims;
    protected $_HS_balance;
    protected $_HS_distributions;
    protected $_HS_employee_contributions;
    protected $_HS_employer_contributions;
    protected $_TB_balance;
    protected $_TB_last_day_submit;
    protected $_PB_balance;
    protected $_PB_last_day_submit;
    
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