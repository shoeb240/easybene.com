<?php
/**
 * Application_Model_NaviaHealthCareMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaHealthCareMapper
{
    /**
     * @var Application_Model_DbTable_NaviaHealthCare
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_NaviaHealthCare
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_NaviaHealthCare();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getNaviaHealthCare($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $medical = array();
            $medical['user_id'] = $row->user_id;
            $medical['balance'] = $row->balance;
            $medical['annual_election'] = $row->annual_election;
            $medical['reimbursed_to_date'] = $row->reimbursed_to_date;
            $medical['date_posted'] = date("Y-m-d", strtotime($row->date_posted));
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
    public function saveNaviaHealthCare(Application_Model_NaviaHealthCare $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'balance' => trim($medical->getOption('balance')),
            'annual_election' => trim($medical->getOption('annual_election')),
            'reimbursed_to_date' => trim($medical->getOption('reimbursed_to_date')),
            'date_posted' => date("Y-m-d", strtotime($medical->getOption('date_posted'))),
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
    public function deleteNaviaHealthCare($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getNaviaHealthCareUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('navia_statements', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}