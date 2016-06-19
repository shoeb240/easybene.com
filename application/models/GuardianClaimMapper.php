<?php
/**
 * Application_Model_GuardianClaimMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianClaimMapper
{
    /**
     * @var Application_Model_DbTable_GuardianClaim
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_GuardianClaim
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_GuardianClaim();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getGuardianClaim($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $claim = array();
            $claim['user_id'] = $row->user_id;
            $claim['patient'] = $row->patient;
            $claim['coverage_type'] = $row->coverage_type;
            $claim['claim_number'] = $row->claim_number;
            $claim['patient_name'] = $row->patient_name;
            $claim['date_of_service'] = $row->date_of_service;
            $claim['paid_date'] = $row->paid_date;
            $claim['check_number'] = $row->check_number;
            $claim['provider_number'] = $row->provider_number;
            $claim['status'] = $row->status;
            $claim['submitted_charges'] = $row->submitted_charges;
            $claim['amount_paid'] = $row->amount_paid;
            $submittedCharges = str_replace(array('$', ','), '', $row->submitted_charges);
            $amountPaid = str_replace(array('$', ','), '', $row->amount_paid);
            $claim['i_owe'] = '$' . number_format($submittedCharges - $amountPaid, 0, '.', ',');
            
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
    public function insertGuardianClaim(Application_Model_GuardianClaim $claim)
    {
        $data = array(
            'user_id' => $claim->getUserId(),
            'patient' => trim($claim->getPatient()),
            'coverage_type' => trim($claim->getCoverageType()),
            'claim_number' => trim($claim->getClaimNumber()),
            'patient_name' => trim($claim->getPatientName()),
            'date_of_service' => trim($claim->getDateOfService()),
            'paid_date' => trim($claim->getPaidDate()),
            'check_number' => trim($claim->getCheckNumber()),
            'provider_number' => trim($claim->getProviderNumber()),
            'status' => trim($claim->getStatus()),
            'submitted_charges' => trim($claim->getSubmittedCharges()),
            'amount_paid' => trim($claim->getAmountPaid()),
        );
        echo '<pre>';
        print_r($data);
        echo '<pre>';
        
        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateGuardianClaim(Application_Model_GuardianClaim $claim)
    {
        $data = array(
            'deductible_amt' => $claim->getDeductibleAmt(),
            'deductible_met' => $claim->getDeductibleMet(),
            'deductible_remaining' => $claim->getDeductibleRemaining(),
            'out_of_pocket_amt' => $claim->getOutOfPocketAmt(),
            'out_of_pocket_met' => $claim->getOutOfPocketMet(),
            'out_of_pocket_remaining' => $claim->getOutOfPocketRemaining()
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
    public function deleteGuardianClaim($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getClaimUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('guardian_claim', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}