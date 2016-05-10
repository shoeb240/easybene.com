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
    public function saveCignaClaimDetails(Application_Model_CignaClaimDetails $claimDetails)
    {
        $data = array(
            'user_id' => $claimDetails->getUserId(),
            'service_date_type' => $claimDetails->getServiceDateType(),
            'service_amount_billed' => $claimDetails->getServiceAmountBilled(),
            'service_discount' => $claimDetails->getServiceDiscount(),
            'service_covered_amount' =>$claimDetails->getServiceCoveredAmount(),
            'service_copay_deductible' => $claimDetails->getServiceCopayDeductible(),
            'service_what_your_plan_paid' => $claimDetails->getServiceWhatYourPlanPaid(),
            'service_coinsurance' => $claimDetails->getServiceCoinsurance(),
            'service_what_i_owe' => $claimDetails->getServiceWhatIOwe(),
            'service_see_notes' => $claimDetails->getServiceSeeNotes()
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
    public function deleteCignaClaimDetails($userArr)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id IN (?)', $userArr);
        return $this->getTable()->delete($where);
        
    }
    
    public function getClaimDetailsUserAll()
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