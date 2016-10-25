<?php
/**
 * Application_Model_CignaDeductibleMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaDeductibleMapper
{
    /**
     * @var Application_Model_DbTable_CignaDeductible
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_CignaDeductible
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_CignaDeductible();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getCignaDeductible($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        $deductible = array();
        $deductible['user_id'] = $row->user_id;
        $deductible['deductible_amt'] = $row->deductible_amt;
        $deductible['deductible_met'] = $row->deductible_met;
        $deductible['deductible_remaining'] = $row->deductible_remaining;
        $deductible['out_of_pocket_amt'] = $row->out_of_pocket_amt;
        $deductible['out_of_pocket_met'] = $row->out_of_pocket_met;
        $deductible['out_of_pocket_remaining'] = $row->out_of_pocket_remaining;
            
        return $deductible;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function save(Application_Model_CignaDeductible $deductible)
    {
        $data = array(
            'user_id' => $deductible->getOption('user_id'),
            'deductible_amt' => $deductible->getOption('deductible_amt'),
            'deductible_met' => $deductible->getOption('deductible_met'),
            'deductible_remaining' => $deductible->getOption('deductible_remaining'),
            'out_of_pocket_amt' => $deductible->getOption('out_of_pocket_amt'),
            'out_of_pocket_met' => $deductible->getOption('out_of_pocket_met'),
            'out_of_pocket_remaining' => $deductible->getOption('out_of_pocket_remaining')
        );
        return $this->getTable()->insert($data);
    }
    
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function updateCignaDeductible(Application_Model_CignaDeductible $deductible)
    {
        $data = array(
            'deductible_amt' => $deductible->getDeductibleAmt(),
            'deductible_met' => $deductible->getDeductibleMet(),
            'deductible_remaining' => $deductible->getDeductibleRemaining(),
            'out_of_pocket_amt' => $deductible->getOutOfPocketAmt(),
            'out_of_pocket_met' => $deductible->getOutOfPocketMet(),
            'out_of_pocket_remaining' => $deductible->getOutOfPocketRemaining()
        );
        
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $deductible->getUserId(), 'INTEGER');
        
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
    
    public function getCignaDeductibleUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('cigna_deductible', array('user_id'));
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }

    
}