<?php
/**
 * Application_Model_GuardianBenefitMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianBenefitMapper
{
    /**
     * @var Application_Model_DbTable_GuardianBenefit
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_GuardianBenefit
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_GuardianBenefit();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getGuardianBenefit($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        $benefit = array();
        $benefit['user_id'] = $row->user_id;
        $benefit['group_id'] = $row->group_id;
        $benefit['company_name'] = $row->company_name;
        $benefit['member_name'] = $row->member_name;
        $benefit['name'] = $row->name;
        $benefit['relationship'] = $row->relationship;
        $benefit['coverage'] = $row->coverage;
        $benefit['original_effective_date'] = $row->original_effective_date;
        $benefit['amounts'] = $row->amounts;
        $benefit['monthly_cost'] = $row->monthly_cost;
        
        return $benefit;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function save(Application_Model_GuardianBenefit $benefit)
    {
        $data = array(
            'user_id' => $benefit->getOption('user_id'),
            'group_id' => $benefit->getOption('group_id'),
            'company_name' => trim($benefit->getOption('company_name')),
            'member_name' => trim($benefit->getOption('member_name')),
            'name' => trim($benefit->getOption('name')),
            'relationship' => trim($benefit->getOption('relationship')),
            'coverage' => trim($benefit->getOption('coverage')),
            'original_effective_date' => date("Y-m-d", strtotime(trim($benefit->getOption('original_effective_date')))),
            'amounts' => trim($benefit->getOption('amounts')),
            'monthly_cost' => trim($benefit->getOption('monthly_cost'))
        );
        
        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateGuardianBenefit(Application_Model_GuardianBenefit $benefit)
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
    public function delete($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getGuardianBenefitUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('guardian_benefit', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}