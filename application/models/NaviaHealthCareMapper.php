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
            $medical['portfolio_balance'] = $row->portfolio_balance;
            $medical['total_balance'] = $row->total_balance;
            $medical['contributions_YTD'] = $row->contributions_YTD;
            $medical['employer_contributions_YTD'] = $row->employer_contributions_YTD;
            $medical['total_contributions_YTD'] = $row->total_contributions_YTD;
            $medical['employer_per_pay_amount'] = $row->employer_per_pay_amount;
            $medical['employee_per_pay_amount'] = $row->employee_per_pay_amount;
            
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
            'balance' => $medical->getOption('balance'),
            'portfolio_balance' => $medical->getOption('portfolio_balance'),
            'total_balance' => $medical->getOption('total_balance'),
            'contributions_YTD' =>$medical->getOption('contributions_YTD'),
            'employer_contributions_YTD' => $medical->getOption('employer_contributions_YTD'),
            'total_contributions_YTD' => $medical->getOption('total_contributions_YTD'),
            'employer_per_pay_amount' => $medical->getOption('employer_per_pay_amount'),
            'employee_per_pay_amount' => $medical->getOption('employee_per_pay_amount')            
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
    public function deleteNaviaHealthCare($userArr)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id IN (?)', $userArr);
        return $this->getTable()->delete($where);
        
    }
    
    public function getMedicalUserAll()
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