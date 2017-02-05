<?php
/**
 * Application_Model_GuardianIdCardMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianIdCardMapper
{
    /**
     * @var Application_Model_DbTable_GuardianIdCard
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_GuardianIdCard
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_GuardianIdCard();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getGuardianIdCard($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);
        
        $medical = array();
        $medical['user_id'] = $row->user_id;
        $medical['pdf_dl'] = $row->pdf_dl;
        $medical['subscriber'] = $row->subscriber;
        $medical['card_id'] = $row->card_id;
        $medical['plan_number'] = $row->plan_number;
        $medical['member_id'] = $row->member_id;
        $medical['customer_response_unit'] = $row->customer_response_unit;
            
        return $medical;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function save(Application_Model_GuardianIdCard $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'pdf_dl' => $medical->getOption('pdf_dl'),
            'subscriber' => $medical->getOption('subscriber'),
            'card_id' => $medical->getOption('card_id'),
            'plan_number' => $medical->getOption('plan_number'),
            'member_id' => $medical->getOption('member_id'),
            'customer_response_unit' => $medical->getOption('customer_response_unit'),
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
    
    public function getGuardianIdCardUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('guardian_id_card', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}