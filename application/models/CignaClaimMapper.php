<?php
/**
 * Application_Model_CignaClaimMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaimMapper
{
    /**
     * @var Application_Model_DbTable_CignaClaim
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_CignaClaim
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_CignaClaim();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getCignaClaim($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $select->order('service_date desc');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $claim = array();
            $claim['user_id'] = $row->user_id;
            $claim['service_date'] = $row->service_date;
            $claim['provided_by'] = $row->provided_by;
            $claim['for'] = $row->for;
            $claim['status'] = $row->status;
            $claim['amount_billed'] = $row->amount_billed;
            $claim['what_your_plan_paid'] = $row->what_your_plan_paid;
            $claim['my_account_paid'] = $row->my_account_paid;
            $claim['what_i_owe'] = $row->what_i_owe;
            $claim['claim_number'] = $row->claim_number;
            
            $info[] = $claim;
        }
        
        return $info;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveCignaClaim(Application_Model_CignaClaim $claim)
    {
        $data = array(
            'user_id' => $claim->getUserId(),
            'service_date' => date("Y-m-d", strtotime($claim->getServiceDate())),
            'provided_by' => $claim->getProvidedBy(),
            'for' => $claim->getFor(),
            'status' => $claim->getStatus(),
            'amount_billed' => $claim->getAmountBilled(),
            'what_your_plan_paid' => $claim->getWhatYourPlanPaid(),
            'my_account_paid' => $claim->getMyAccountPaid(),
            'what_i_owe' => $claim->getWhatIOwe(),
            'claim_number' => $claim->getClaimNumber()
        );
        
        return $this->getTable()->insert($data);
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateCignaClaim(Application_Model_CignaClaim $claim)
    {
        $data = array(
            'user_id' => $claim->getUserId(),
            'service_date' => $claim->getServiceDate(),
            'provided_by' => $claim->getProvidedBy(),
            'for' => $claim->getFor(),
            'status' => $claim->getStatus(),
            'amount_billed' => $claim->getAmountBilled(),
            'what_your_plan_paid' => $claim->getWhatYourPlanPaid(),
            'my_account_paid' => $claim->getMyAccountPaid(),
            'what_i_owe' => $claim->getWhatIOwe(),
            'claim_number' => $claim->getClaimNumber()
        );
        
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $claim->getUserId(), 'INTEGER');
        
        return $this->getTable()->update($data, $where);
    }
    
    /**
     * Update user subscription
     *
     * @param  int $userId
     * @param  int $subscrId
     * @return int 
     */
    public function deleteCignaClaim($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getCignaClaimUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('cigna_claim', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
    
}