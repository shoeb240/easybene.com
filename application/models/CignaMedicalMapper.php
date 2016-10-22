<?php
/**
 * Application_Model_CignaMedicalMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaMedicalMapper
{
    /**
     * @var Application_Model_DbTable_CignaMedical
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_CignaMedical
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_CignaMedical();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getCignaMedical($userId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $medical = array();
            $medical['user_id'] = $row->user_id;
            $medical['whos_covered'] = $row->whos_covered;
            $medical['date_of_birth'] = $row->date_of_birth;
            $medical['relationship'] = $row->relationship;
            $medical['coverage_from'] = $row->coverage_from;
            $medical['to'] = $row->to;
            $medical['primary_care_physician'] = $row->primary_care_physician;
            
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
    public function save(Application_Model_CignaMedical $medical)
    {
        $data = array(
            'user_id' => $medical->getOption('user_id'),
            'whos_covered' => $medical->getOption('whos_covered'),
            'date_of_birth' => $medical->getOption('date_of_birth'),
            'relationship' => $medical->getOption('relationship'),
            'coverage_from' => $medical->getOption('coverage_from'),
            'to' => $medical->getOption('to'),
            'primary_care_physician' => mysql_escape_string($medical->getOption('primary_care_physician')),
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
    
    public function getCignaMedicalUserAll()
    {
        $select = $this->getTable()->select();
        $select->from('cigna_medical', array('user_id'))
               ->group('user_id');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $info[] = $row->user_id;
        }
        
        return $info;
    }
    
    
}