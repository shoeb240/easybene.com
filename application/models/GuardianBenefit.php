<?php
/**
 * Application_Model_CignaDeductible class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianBenefit
{
    protected $_id;
    protected $_userId;
    protected $_group_id;
    protected $_company_name;
    protected $_member_name;
    protected $_name;
    protected $_relationship;
    protected $_coverage;    
    protected $_original_effective_date;
    protected $_amounts;
    protected $_monthly_cost;
    
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
