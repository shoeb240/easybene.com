<?php
/**
 * Application_Model_CignaIdCardMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaIdCardMapper
{
    /**
     * @var Application_Model_DbTable_CignaIdCard
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_CignaIdCard
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_CignaIdCard();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getCignaIdCard($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);
        
        $medical = array();
        $medical['user_id'] = $row->user_id;
        $medical['pdf_dl'] = $row->pdf_dl;
        $medical['name'] = $row->name;
        $medical['card_id'] = $row->card_id;
        $medical['group'] = $row->group;
        $medical['issuer'] = $row->issuer;
        $medical['RxBIN'] = $row->RxBIN;
        $medical['RxPCN'] = $row->RxPCN;
        $medical['RxGrp'] = $row->RxGrp;
        $medical['RxID'] = $row->RxID;
            
        return $medical;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function save(Application_Model_CignaIdCard $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'pdf_dl' => $medical->getOption('pdf_dl'),
            'name' => $medical->getOption('name'),
            'card_id' => $medical->getOption('card_id'),
            'group' => $medical->getOption('group'),
            'issuer' => $medical->getOption('issuer'),
            'RxBIN' => $medical->getOption('RxBIN'),
            'RxPCN' => $medical->getOption('RxPCN'),
            'RxGrp' => $medical->getOption('RxGrp'),
            'RxID' => $medical->getOption('RxID')
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
    
    public function getCignaIdCardUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('cigna_id_card', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}