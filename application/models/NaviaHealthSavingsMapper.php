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
        $select->order('transaction_date desc');
        $rowSets = $this->getTable()->fetchAll($select);

        $info = array();
        foreach($rowSets as $k => $row) {
            $medical = array();
            $medical['user_id'] = $row->user_id;
            $medical['balance'] = $row->balance;
            $medical['portfolio_balance'] = $row->portfolio_balance;
            $medical['total_balance'] = $row->total_balance;
            $medical['contributions_YTD'] = $row->contributions_YTD;
            $medical['employer_contributions_YTD'] = $row->employer_contributions_YTD;
            $medical['total_contributions_YTD'] = $row->total_contributions_YTD;
            $medical['employer_per_pay_amount'] = $row->employer_per_pay_amount;
            $medical['employee_per_pay_amount'] = $row->employee_per_pay_amount;
            $medical['transaction_date'] = $row->transaction_date;
            $medical['transaction_type'] = $row->transaction_type;
            $medical['description'] = $row->description;
            $medical['transaction_amt'] = $row->transaction_amt;
            $medical['HSA_transaction_type'] = $row->HSA_transaction_type;
            
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
    public function save(Application_Model_NaviaHealthSavings $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'balance' => $medical->getOption('balance'),
            'portfolio_balance' => $medical->getOption('portfolio_balance'),
            'total_balance' => $medical->getOption('total_balance'),
            'contributions_YTD' =>$medical->getOption('contributions_YTD'),
            'employer_contributions_YTD' => $medical->getOption('employer_contributions_YTD'),
            'total_contributions_YTD' => $medical->getOption('total_contributions_YTD'),
            'employer_per_pay_amount' => $medical->getOption('employer_per_pay_amount'),
            'employee_per_pay_amount' => $medical->getOption('employee_per_pay_amount'),
            'transaction_date' => date("Y-m-d", strtotime($medical->getOption('transaction_date'))),
            'transaction_type' => $medical->getOption('transaction_type'),
            'description' => $medical->getOption('description'),
            'transaction_amt' => $medical->getOption('transaction_amt'),
            'HSA_transaction_type' => $medical->getOption('HSA_transaction_type'),
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
    
    public function getNaviaHealthSavingsUserAll()
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