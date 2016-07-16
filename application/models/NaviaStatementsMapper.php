<?php
/**
 * Application_Model_NaviaStatementsMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_NaviaStatementsMapper
{
    /**
     * @var Application_Model_DbTable_NaviaStatements
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_NaviaStatements
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_NaviaStatements();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getNaviaStatements($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);
        
        $medical = array();
        $medical['user_id'] = $row->user_id;
        $medical['DC_from_date'] = $row->DC_from_date;
        $medical['DC_to_date'] = $row->DC_to_date;
        $medical['DC_claim'] = $row->DC_claim;
        $medical['DC_annual_election'] = $row->DC_annual_election;
        $medical['DC_last_day_incur_exp'] = $row->DC_last_day_incur_exp;
        $medical['DC_submit_claims'] = $row->DC_submit_claims;
        $medical['HC_date_from'] = $row->HC_date_from;
        $medical['HC_date_to'] = $row->HC_date_to;
        $medical['HC_balance'] = $row->HC_balance;
        $medical['HC_annual_election'] = $row->HC_annual_election;
        $medical['HC_last_day_incur_exp'] = $row->HC_last_day_incur_exp;
        $medical['HC_last_day_submit_claims'] = $row->HC_last_day_submit_claims;
        $medical['HS_balance'] = $row->HS_balance;
        $medical['HS_distributions'] = $row->HS_distributions;
        $medical['HS_employee_contributions'] = $row->HS_employee_contributions;
        $medical['HS_employer_contributions'] = $row->HS_employer_contributions;
        $medical['TB_balance'] = $row->TB_balance;
        $medical['TB_last_day_submit'] = $row->TB_last_day_submit;
        $medical['PB_balance'] = $row->PB_balance;
        $medical['PB_last_day_submit'] = $row->PB_last_day_submit;
        
        return $medical;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveNaviaStatements(Application_Model_NaviaStatements $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'DC_from_date' => $medical->getOption('DC_from_date'),
            'DC_to_date' => $medical->getOption('DC_to_date'),
            'DC_claim' => $medical->getOption('DC_claim'),
            'DC_annual_election' =>$medical->getOption('DC_annual_election'),
            'DC_last_day_incur_exp' => $medical->getOption('DC_last_day_incur_exp'),
            'DC_submit_claims' => $medical->getOption('DC_submit_claims'),
            'HC_date_from' => $medical->getOption('HC_date_from'),
            'HC_date_to' => $medical->getOption('HC_date_to'),
            'HC_balance' => $medical->getOption('HC_balance'),
            'HC_annual_election' => $medical->getOption('HC_annual_election'),
            'HC_last_day_incur_exp' => $medical->getOption('HC_last_day_incur_exp'),
            'HC_last_day_submit_claims' => $medical->getOption('HC_last_day_submit_claims'),
            'HS_balance' => $medical->getOption('HS_balance'),
            'HS_distributions' => $medical->getOption('HS_distributions'),
            'HS_employee_contributions' => $medical->getOption('HS_employee_contributions'),
            'HS_employer_contributions' => $medical->getOption('HS_employer_contributions'),
            'TB_balance' => $medical->getOption('TB_balance'),
            'TB_last_day_submit' => $medical->getOption('TB_last_day_submit'),
            'PB_balance' => $medical->getOption('PB_balance'),
            'PB_last_day_submit' => $medical->getOption('PB_last_day_submit'),
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
    public function deleteNaviaStatements($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getNaviaStatementsUserAll()
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