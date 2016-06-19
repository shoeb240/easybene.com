<?php
/**
 * Application_Model_NaviaHealthSavingsMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaHealthSavingsMapper
{
    /**
     * @var Application_Model_DbTable_NaviaHealthSavings
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_NaviaHealthSavings
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_NaviaHealthSavings();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getNaviaHealthSavings($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $medical = array();
            $medical['user_id'] = $row->user_id;
            $medical['claim'] = $row->claim;
            $medical['annual_election'] = $row->annual_election;
            $medical['balance'] = $row->balance;
            $medical['election'] = $row->election;
            $medical['reimburse_date'] = $row->reimburse_date;
            $medical['date_posted'] = $row->date_posted;
            $medical['transaction_type'] = $row->transaction_type;
            $medical['claim_amount'] = $row->claim_amount;
            $medical['amount'] = $row->amount;
            
            $info[] = $medical;
        }
        
        return $info;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveNaviaHealthSavings(Application_Model_NaviaHealthSavings $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'claim' => $medical->getOption('claim'),
            'annual_election' => $medical->getOption('annual_election'),
            'balance' => $medical->getOption('balance'),
            'election' =>$medical->getOption('election'),
            'reimburse_date' => $medical->getOption('reimburse_date'),
            'date_posted' => $medical->getOption('date_posted'),
            'transaction_type' => $medical->getOption('transaction_type'),
            'claim_amount' => $medical->getOption('claim_amount'),
            'amount' => $medical->getOption('amount')
        );
        
        return $this->getTable()->insert($data);
    }
    
    /**
     * Update user subscription
     *
     * @param  int $userId
     * @param  int $subscrId
     * @return int 
     */
    public function deleteNaviaHealthSavings($userArr)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id IN (?)', $userArr);
        return $this->getTable()->delete($where);
        
    }
    
    public function getMedicalUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('navia_health_savings', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}