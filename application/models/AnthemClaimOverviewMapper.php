<?php
/**
 * Application_Model_AnthemClaimMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_AnthemClaimOverviewMapper
{
    /**
     * @var Application_Model_DbTable_AnthemClaim
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_AnthemClaim
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_AnthemClaimOverview();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getAnthemClaim($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        $claim = array();
        $claim['user_id'] = $row->user_id;
        $claim['deductible_amt'] = $row->deductible_amt;
        $claim['deductible_met'] = $row->deductible_met;
        $claim['deductible_remaining'] = $row->deductible_remaining;
        $claim['out_of_pocket_amt'] = $row->out_of_pocket_amt;
        $claim['out_of_pocket_met'] = $row->out_of_pocket_met;
        $claim['out_of_pocket_remaining'] = $row->out_of_pocket_remaining;
            
        return $claim;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function insertAnthemClaim(Application_Model_AnthemClaim $claim)
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
    public function updateAnthemClaim(Application_Model_AnthemClaim $claim)
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
    public function deleteAnthemClaim($userArr)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('user_id IN (?)', $userArr);
        return $this->getTable()->delete($where);
        
    }
    
    public function getClaimOverviewUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('anthem_claim_overview', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}