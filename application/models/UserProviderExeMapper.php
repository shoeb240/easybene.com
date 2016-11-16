<?php
/**
 * Application_Model_UserProviderMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_UserProviderExeMapper
{
    /**
     * @var Application_Model_DbTable_User
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_User
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_UserProviderExe();
        }
        
        return $this->_dbTable;
    }
    
    /**
     * Get user info
     *
     * @param  int   $userId
     * @return array $info   Array of Application_Model_User
     */
    public function getUserProviderExe($userProviderTableId, $userId)
    {
        $select = $this->getTable()->select();
        
        $select->setIntegrityCheck(false)
               ->from(array('upe' => 'user_provider_exe'), array('upe.*'))
               ->join(array('up' => 'user_provider'), 
                      'up.id = upe.user_provider_table_id',
                      array('user_id' => 'up.user_id'))
               ->where('upe.user_provider_table_id = ?', $userProviderTableId)
               ->where('upe.failed = ?', 0)
               ->where('up.user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);

        $exeInfo = array();
        foreach($rowSets as $k => $row) {
            $userProviderExeObj = new Application_Model_UserProviderExe();
            $userProviderExeObj->id = $row->id;
            $userProviderExeObj->user_provider_table_id = $row->user_provider_table_id;
            $userProviderExeObj->run_name = $row->run_name;
            $userProviderExeObj->exe_id = $row->exe_id;
            $userProviderExeObj->user_id = $row->user_id;
            $exeInfo[$row->user_id][$row->run_name] = $userProviderExeObj;
        }
        
        return $exeInfo;
    }
    
    public function getAllUserProvidersCronExe($providerName, $providerType)
    {
        $providerMapper = new Application_Model_ProviderListMapper();
        $providerInfo = $providerMapper->getProviderByNameType($providerName, $providerType);
        $providerId = $providerInfo->id;
        
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('upe' => 'user_provider_exe'), array('upe.*'))
               ->join(array('up' => 'user_provider'), 
                      'up.id = upe.user_provider_table_id',
                      array('user_id' => 'up.user_id'))
               ->where('upe.failed = ?', 0)
               ->where('up.provider_id = ?', $providerId);
        $rowSets = $this->getTable()->fetchAll($select);

        $exeInfo = array();
        foreach($rowSets as $k => $row) {
            $userProviderExeObj = new Application_Model_UserProviderExe();
            $userProviderExeObj->id = $row->id;
            $userProviderExeObj->user_provider_table_id = $row->user_provider_table_id;
            $userProviderExeObj->run_name = $row->run_name;
            $userProviderExeObj->exe_id = $row->exe_id;
            $userProviderExeObj->user_id = $row->user_id;
            $exeInfo[$row->user_id][$row->run_name] = $userProviderExeObj;
        }
        
        return $exeInfo;
    }
    
    public function updateSiteCredentials($userProviderTableId, $runName, $exeId)
    {
        $select = $this->getTable()->select();
        $select->from(array('upe' => 'user_provider_exe'), array('upe.*'));
        $select->where('upe.user_provider_table_id = ?', $userProviderTableId, 'INTEGER');
        $select->where('upe.run_name = ?', $runName);
        $row = $this->getTable()->fetchRow($select);
        
        if ($row) {
            $row->exe_id = $exeId;
            $row->failed = 0;
            
            return $row->save();
        } else {
            $data = array();
            $data['user_provider_table_id'] = $userProviderTableId;
            $data['run_name'] = $runName;
            $data['exe_id'] = $exeId;
            $data['failed'] = 0;
            
            return $this->getTable()->insert($data);
        }
        
        return false;        
    }
    
    public function updateFailed($responseFailedIds)
    {
        $data = array(
            'failed' => 1,
        );
        
        return $this->getTable()->update($data, 'id IN ('.$responseFailedIds.')');
    }
    
}