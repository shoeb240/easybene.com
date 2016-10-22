<?php
/**
 * Application_Model_CignaClaimDetailsMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaimDetailsMapper
{
    /**
     * @var Application_Model_DbTable_CignaClaimDetails
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_CignaClaimDetails
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_CignaClaimDetails();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getCignaClaimDetails($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);

        $info = array();
        foreach($rowSets as $k => $row) {
            $claimDetails = array();
            $claimDetails['user_id'] = $row->user_id;
            $claimDetails['claim_number'] = $row->claim_number;
            $claimDetails['provided_by_details'] = $row->provided_by_details;
            $claimDetails['for'] = $row->for;
            $claimDetails['claim_processed_on'] = $row->claim_processed_on;
            $claimDetails['service_date_type'] = $row->service_date_type;
            $claimDetails['service_amount_billed'] = $row->service_amount_billed;
            $claimDetails['service_discount'] = $row->service_discount;
            $claimDetails['service_covered_amount'] = $row->service_covered_amount;
            $claimDetails['service_copay_deductible'] = $row->service_copay_deductible;
            $claimDetails['service_what_your_plan_paid'] = $row->service_what_your_plan_paid;
            $claimDetails['service_coinsurance'] = $row->service_coinsurance;
            $claimDetails['service_what_i_owe'] = $row->service_what_i_owe;
            $claimDetails['service_see_notes'] = $row->service_see_notes;
            
            $info[] = $claimDetails;
        }
        
        return $info;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function save(Application_Model_CignaClaimDetails $claimDetails)
    {
        $data = array(
            'user_id' => $claimDetails->getOption('user_id'),
            'claim_number' => $claimDetails->getOption('claim_number'),
            'provided_by_details' => $claimDetails->getOption('provided_by_details'),
            'for' => $claimDetails->getOption('for'),
            'claim_processed_on' => $claimDetails->getOption('claim_processed_on'),
            'service_date_type' => $claimDetails->getOption('service_date_type'),
            'service_amount_billed' => $claimDetails->getOption('service_amount_billed'),
            'service_discount' => $claimDetails->getOption('service_discount'),
            'service_covered_amount' => $claimDetails->getOption('service_covered_amount'),
            'service_copay_deductible' => $claimDetails->getOption('service_copay_deductible'),
            'service_what_your_plan_paid' => $claimDetails->getOption('service_what_your_plan_paid'),
            'service_coinsurance' => $claimDetails->getOption('service_coinsurance'),
            'service_what_i_owe' => $claimDetails->getOption('service_what_i_owe'),
            'service_see_notes' => $claimDetails->getOption('service_see_notes')
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
    
    public function getCignaClaimDetailsUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('cigna_claim_details', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}