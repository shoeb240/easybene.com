<?php
/**
 * Application_Model_AnthemMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_AnthemMapper
{
    /**
     * @var Application_Model_DbTable_Anthem
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_Anthem
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Anthem();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getAnthem($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        $benefit = array();
        $benefit['user_id'] = $row->user_id;
        $benefit['claims_benefit_coverage'] = $row->claims_benefit_coverage;
        $benefit['claims_deductible_for'] = $row->claims_deductible_for;
        $benefit['BM_benefit_coverage_period'] = $row->BM_benefit_coverage_period;
        $benefit['BM_benefit_deductible_for'] = $row->BM_benefit_deductible_for;
        $benefit['BM_plan'] = $row->BM_plan;
        $benefit['BM_primary_care_physian'] = $row->BM_primary_care_physian;
        $benefit['BM_member_id'] = $row->BM_member_id;
        $benefit['BM_group_name'] = $row->BM_group_name;
        $benefit['CD_deductible_in_net_family_limit'] = $row->CD_deductible_in_net_family_limit;
        $benefit['CD_deductible_in_net_family_accumulate'] = $row->CD_deductible_in_net_family_accumulate;
        $benefit['CD_deductible_in_net_remaining'] = $row->CD_deductible_in_net_remaining;
        $benefit['CD_deductible_out_net_family_limit'] = $row->CD_deductible_out_net_family_limit;
        $benefit['CD_deductible_out_net_family_accumulate'] = $row->CD_deductible_out_net_family_accumulate;
        $benefit['CD_deductible_out_net_family_remaining'] = $row->CD_deductible_out_net_family_remaining;
        $benefit['CD_out_pocket_in_net_family_limit'] = $row->CD_out_pocket_in_net_family_limit;
        $benefit['CD_out_pocket_out_net_family_accumulate'] = $row->CD_out_pocket_out_net_family_accumulate;
        $benefit['CD_out_pocket_out_net_family_remaining'] = $row->CD_out_pocket_out_net_family_remaining;
        $benefit['HP_primary_care_physician'] = $row->HP_primary_care_physician;
        $benefit['BV_plan_name'] = $row->BV_plan_name;
        $benefit['BV_eligibility_benefit_for'] = $row->BV_eligibility_benefit_for;
        $benefit['BV_vision_member_id'] = $row->BV_vision_member_id;
        $benefit['CD_claims_benefit_coverage'] = $row->CD_claims_benefit_coverage;
        $benefit['CD_claims_benefit_deductible_for'] = $row->CD_claims_benefit_deductible_for;
        
        return $benefit;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveAnthem(Application_Model_Anthem $anthem)
    {
        $data = array(
            'user_id' => $anthem->getOption('user_id'),
            'claims_benefit_coverage' => $anthem->getOption('claims_benefit_coverage'),
            'claims_deductible_for' => $anthem->getOption('claims_deductible_for'),
            'BM_benefit_coverage_period' => trim($anthem->getOption('BM_benefit_coverage_period')),
            'BM_benefit_deductible_for' => trim($anthem->getOption('BM_benefit_deductible_for')),
            'BM_plan' => trim($anthem->getOption('BM_plan')),
            'BM_primary_care_physian' => trim($anthem->getOption('BM_primary_care_physian')),
            'BM_member_id' => trim($anthem->getOption('BM_member_id')),
            'BM_group_name' => trim($anthem->getOption('BM_group_name')),
            'CD_deductible_in_net_family_limit' => trim($anthem->getOption('deductible_in_net_family_limit')),
            'CD_deductible_in_net_family_accumulate' => trim($anthem->getOption('deductible_in_net_family_accumulate')),
            'CD_deductible_in_net_remaining' => trim($anthem->getOption('deductible_in_net_remaining')),
            'CD_deductible_out_net_family_limit' => trim($anthem->getOption('deductible_out_net_family_limit')),
            'CD_deductible_out_net_family_accumulate' => trim($anthem->getOption('deductible_out_net_family_accumulate')),
            'CD_deductible_out_net_family_remaining' => trim($anthem->getOption('deductible_out_net_family_remaining')),
            'CD_out_pocket_in_net_family_limit' => trim($anthem->getOption('out_pocket_in_net_family_limit')),
            'CD_out_pocket_out_net_family_accumulate' => trim($anthem->getOption('out_pocket_out_net_family_accumulate')),
            'CD_out_pocket_out_net_family_remaining' => trim($anthem->getOption('out_pocket_out_net_family_remaining')),
            'HP_primary_care_physician' => trim($anthem->getOption('HP_primary_care_physician')),
            'BV_plan_name' => trim($anthem->getOption('BV_plan_name')),
            'BV_eligibility_benefit_for' => trim($anthem->getOption('BV_eligibility_benefit_for')),
            'BV_vision_member_id' => trim($anthem->getOption('BV_vision_member_id')),
            'CD_claims_benefit_coverage' => trim($anthem->getOption('CD_claims_benefit_coverage')),
            'CD_claims_benefit_deductible_for' => trim($anthem->getOption('CD_claims_benefit_deductible_for')),
        );

        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateAnthem(Application_Model_Anthem $benefit)
    {
        $data = array(
            'deductible_amt' => $benefit->getDeductibleAmt(),
            'deductible_met' => $benefit->getDeductibleMet(),
            'deductible_remaining' => $benefit->getDeductibleRemaining(),
            'out_of_pocket_amt' => $benefit->getOutOfPocketAmt(),
            'out_of_pocket_met' => $benefit->getOutOfPocketMet(),
            'out_of_pocket_remaining' => $benefit->getOutOfPocketRemaining()
        );
        
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $benefit->getUserId(), 'INTEGER');
        
        return $this->getTable()->update($data, $where);
    }
    
    /**
     * Update user subscription
     *
     * @param  int $userId
     * @param  int $subscrId
     * @return int 
     */
    public function deleteAnthem($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getAnthemUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('anthem', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}