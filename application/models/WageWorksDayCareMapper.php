<?php
/**
 * Application_Model_WageWorksDayCareMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_WageWorksDayCareMapper
{
    /**
     * @var Application_Model_DbTable_WageWorksDayCare
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_WageWorksDayCare
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_WageWorksDayCare();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getWageWorksDayCare($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $medical = array();
            $medical['user_id'] = $row->user_id;
            //$medical['claim'] = $row->claim;
            $medical['annual_election'] = $row->annual_election;
            $medical['available_balance'] = $row->available_balance;
            $medical['date_posted'] = $row->date_posted_d . ' ' . $row->date_posted_M . ' ' . $row->date_posted_Y;
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
    public function save(Application_Model_WageWorksDayCare $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            //'claim' => trim($medical->getOption('claim')),
            'annual_election' => trim($medical->getOption('annual_election')),
            'available_balance' => trim($medical->getOption('available_balance')),
            'transaction_type' => $medical->getOption('transaction_type'),
            'date_posted_d' => $medical->getOption('date_posted_d'),
            'date_posted_M' => $medical->getOption('date_posted_M'),
            'date_posted_Y' => $medical->getOption('date_posted_Y'),
            'claim_amount' => $medical->getOption('claim_amount'),
            'amount' => $medical->getOption('amount'),
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
    public function delete($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getWageWorksDayCareUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('wageworks_day_care', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}