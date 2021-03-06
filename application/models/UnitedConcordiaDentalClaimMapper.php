<?php
/**
 * Application_Model_UnitedConcordiaDentalClaimMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_UnitedConcordiaDentalClaimMapper
{
    /**
     * @var Application_Model_DbTable_UnitedConcordiaDentalClaim
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_UnitedConcordiaDentalClaim
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_UnitedConcordiaDentalClaim();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getUnitedConcordiaDentalClaim($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $select->order('paid_date desc');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $claim = array();
            $claim['user_id'] = $row->user_id;
            $claim['claim_number'] = $row->claim_number;
            $claim['patient_name'] = $row->patient_name;
            $claim['date_of_service'] = $row->date_of_service;
            $claim['dentist'] = $row->dentist;
            $claim['paid_date'] = $row->paid_date;
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
    public function save(Application_Model_UnitedConcordiaDentalClaim $claim)
    {
        $data = array(
            'user_id' => $claim->getOption('user_id'),
            'claim_number' => trim($claim->getOption('claim_number')),
            'patient_name' => trim($claim->getOption('patient_name')),
            'date_of_service' => date("Y-m-d", strtotime(trim($claim->getOption('date_of_service')))),
            'dentist' => trim($claim->getOption('dentist')),
            'paid_date' => date("Y-m-d", strtotime(trim($claim->getOption('paid_date')))),
            'status' => trim($claim->getOption('status')),
            'submitted_charges' => trim($claim->getOption('submitted_charges')),
            'amount_paid' => trim($claim->getOption('amount_paid')),
        );
//        echo '<pre>';
//        print_r($data);
//        echo '<pre>';
        
        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateUnitedConcordiaDentalClaim(Application_Model_UnitedConcordiaDentalClaim $claim)
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
    public function delete($userId)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $userId);
        return $this->getTable()->delete($where);
        
    }
    
    public function getUnitedConcordiaDentalClaimUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('united_concordia_dental_claim', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}