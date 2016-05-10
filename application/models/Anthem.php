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
class Application_Model_Anthem
{
    protected $_id;
    protected $_user_id;
    protected $_claims_benefit_coverage;
    protected $_claims_deductible_for;
    protected $_benefit_coverage;
    protected $_benefit_deductible_for;
    protected $_plan;
    protected $_primary_care_physian;    
    protected $_member_id;
    protected $_group_name;
    protected $_deductible_in_net_family_limit;
    protected $_deductible_in_net_family_accumulate;
    protected $_deductible_in_net_remaining;
    protected $_deductible_out_net_family_limit;
    protected $_deductible_out_net_family_accumulate;
    protected $_deductible_out_net_family_remaining;
    protected $_out_pocket_in_net_family_limit;
    protected $_out_pocket_out_net_family_accumulate;
    protected $_out_pocket_out_net_family_remaining;
    protected $_primary_care_physician;
    protected $_plan_name;
    protected $_eligibility_benefit_for;
    protected $_vision_member_id;
    protected $_claims_benefit_coverage1;
    protected $_claims_benefit_deductible_for;
    
    
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
