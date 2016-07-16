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
        $benefit['benefit_coverage'] = $row->benefit_coverage;
        $benefit['benefit_deductible_for'] = $row->benefit_deductible_for;
        $benefit['plan'] = $row->plan;
        $benefit['primary_care_physian'] = $row->primary_care_physian;
        $benefit['member_id'] = $row->member_id;
        $benefit['group_name'] = $row->group_name;
        $benefit['deductible_in_net_family_limit'] = $row->deductible_in_net_family_limit;
        $benefit['deductible_in_net_family_accumulate'] = $row->deductible_in_net_family_accumulate;
        $benefit['deductible_in_net_remaining'] = $row->deductible_in_net_remaining;
        $benefit['deductible_out_net_family_limit'] = $row->deductible_out_net_family_limit;
        $benefit['deductible_out_net_family_accumulate'] = $row->deductible_out_net_family_accumulate;
        $benefit['deductible_out_net_family_remaining'] = $row->deductible_out_net_family_remaining;
        $benefit['out_pocket_in_net_family_limit'] = $row->out_pocket_in_net_family_limit;
        $benefit['out_pocket_out_net_family_accumulate'] = $row->out_pocket_out_net_family_accumulate;
        $benefit['out_pocket_out_net_family_remaining'] = $row->out_pocket_out_net_family_remaining;
        $benefit['primary_care_physician'] = $row->primary_care_physician;
        $benefit['plan_name'] = $row->plan_name;
        $benefit['eligibility_benefit_for'] = $row->eligibility_benefit_for;
        $benefit['vision_member_id'] = $row->vision_member_id;
        $benefit['claims_benefit_coverage1'] = $row->claims_benefit_coverage1;
        $benefit['claims_benefit_deductible_for'] = $row->claims_benefit_deductible_for;
        
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
            'benefit_coverage' => trim($anthem->getOption('benefit_coverage')),
            'benefit_deductible_for' => trim($anthem->getOption('benefit_deductible_for')),
            'plan' => trim($anthem->getOption('plan')),
            'primary_care_physian' => trim($anthem->getOption('primary_care_physian')),
            'member_id' => trim($anthem->getOption('member_id')),
            'group_name' => trim($anthem->getOption('group_name')),
            'deductible_in_net_family_limit' => trim($anthem->getOption('deductible_in_net_family_limit')),
            'deductible_in_net_family_accumulate' => trim($anthem->getOption('deductible_in_net_family_accumulate')),
            'deductible_in_net_remaining' => trim($anthem->getOption('deductible_in_net_remaining')),
            'deductible_out_net_family_limit' => trim($anthem->getOption('deductible_out_net_family_limit')),
            'deductible_out_net_family_accumulate' => trim($anthem->getOption('deductible_out_net_family_accumulate')),
            'deductible_out_net_family_remaining' => trim($anthem->getOption('deductible_out_net_family_remaining')),
            'out_pocket_in_net_family_limit' => trim($anthem->getOption('out_pocket_in_net_family_limit')),
            'out_pocket_out_net_family_accumulate' => trim($anthem->getOption('out_pocket_out_net_family_accumulate')),
            'out_pocket_out_net_family_remaining' => trim($anthem->getOption('out_pocket_out_net_family_remaining')),
            'primary_care_physician' => trim($anthem->getOption('primary_care_physician')),
            'plan_name' => trim($anthem->getOption('plan_name')),
            'eligibility_benefit_for' => trim($anthem->getOption('eligibility_benefit_for')),
            'vision_member_id' => trim($anthem->getOption('vision_member_id')),
            'claims_benefit_coverage1' => trim($anthem->getOption('claims_benefit_coverage1')),
            'claims_benefit_deductible_for' => trim($anthem->getOption('claims_benefit_deductible_for')),
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