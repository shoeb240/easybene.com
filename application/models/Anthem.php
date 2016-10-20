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
    protected $_BM_benefit_coverage_period;
    protected $_BM_benefit_deductible_for;
    protected $_BM_plan;
    protected $_BM_primary_care_physian;    
    protected $_BM_member_id;
    protected $_BM_group_name;
    protected $_CD_deductible_in_net_family_limit;
    protected $_CD_deductible_in_net_family_accumulate;
    protected $_CD_deductible_in_net_remaining;
    protected $_CD_deductible_out_net_family_limit;
    protected $_CD_deductible_out_net_family_accumulate;
    protected $_CD_deductible_out_net_family_remaining;
    protected $_CD_out_pocket_in_net_family_limit;
    protected $_CD_out_pocket_out_net_family_accumulate;
    protected $_CD_out_pocket_out_net_family_remaining;
    protected $_HP_primary_care_physician;
    protected $_BV_plan_name;
    protected $_BV_eligibility_benefit_for;
    protected $_BV_vision_member_id;
    protected $_CD_claims_benefit_coverage;
    protected $_CD_claims_benefit_deductible_for;
    
    
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
