<?php
/**
 * Application_Model_AnthemBenefitMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_AnthemBenefitMapper
{
    /**
     * @var Application_Model_DbTable_AnthemBenefit
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_AnthemBenefit
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_AnthemBenefit();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getAnthemBenefit($userId)
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
    public function insertAnthemBenefit(Application_Model_AnthemBenefit $benefit)
    {
        $data = array(
            'user_id' => $benefit->getUserId(),
            'group_id' => $benefit->getGroupId(),
            'company_name' => trim($benefit->getCompanyName()),
            'member_name' => trim($benefit->getMemberName()),
            'name' => trim($benefit->getName()),
            'relationship' => trim($benefit->getRelationship()),
            'coverage' => trim($benefit->getCoverage()),
            'original_effective_date' => trim($benefit->getOriginalEffectiveDate()),
            'amounts' => trim($benefit->getAmounts()),
            'monthly_cost' => trim($benefit->getMonthlyCost())
        );
        
        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateAnthemBenefit(Application_Model_AnthemBenefit $benefit)
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
    public function deleteAnthemBenefit($userArr)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id IN (?)', $userArr);
        return $this->getTable()->delete($where);
        
    }
    
    public function getBenefitUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('anthem_benefit', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}