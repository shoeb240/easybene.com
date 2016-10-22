<?php
/**
 * Application_Model_CignaClaimDetails class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaimDetails
{
    protected $_id;
    protected $_userId;
    protected $_claim_number;
    protected $_provided_by;
    protected $_for;
    protected $_claim_processed_on;
    protected $_service_date_type;
    protected $_service_amount_billed;
    protected $_service_discount;
    protected $_service_covered_amount;
    protected $_service_copay_deductible;
    protected $_service_what_your_plan_paid;
    protected $_service_coinsurance;
    protected $_service_what_i_owe;
    protected $_service_see_notes;
    
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