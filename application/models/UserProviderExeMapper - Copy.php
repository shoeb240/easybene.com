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
    
    public function getUserProviderRun($providerId, $userId)
    {
        $select = $this->getTable()->select();
        /*$select->from(array('up' => 'user_provider'), array('up.*, AES_DECRYPT(up.provider_password, UNHEX(SHA2(\'my_secret\', 512))) as de_provider_password'))
               ->where('up.provider_id = ?', $providerId)
               ->where('up.user_id = ?', $userId);*/
        $select->setIntegrityCheck(false)
               ->from(array('up' => 'user_provider'), array('id' => 'up.id', 'user_id' => 'up.user_id', 'provider_id' => 'up.provider_id', 'provider_user_id' => 'up.provider_user_id',
                          'de_provider_password' => 'AES_DECRYPT(up.provider_password, UNHEX(SHA2(\'my_secret\', 512)))'))
               ->joinLeft(array('upe' => 'user_provider_exe'), 
                       'up.id = upe.user_provider_table_id',
                      array('exe_table_id' => 'upe.id', 'upe.run_name', 'upe.failed', 'upe.executed', 'timediff' => 'TIMESTAMPDIFF(SECOND, upe.run_time, NOW())'))
               ->where('up.provider_id = ?', $providerId)
               ->where('up.user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);

        $providersSelected = array();
        foreach($rowSets as $k => $row) {
            $userProvider = new Application_Model_UserProvider();
            $userProvider->id = $row->id;
            $userProvider->user_id = $row->user_id;
            $userProvider->provider_id = $row->provider_id;
            $userProvider->provider_user_id = $row->provider_user_id;
            $userProvider->provider_password = $row->de_provider_password;
            $userProvider->exe_table_id = $row->exe_table_id;
            $userProvider->run_name = $row->run_name;
            $userProvider->failed = $row->failed;  
            $userProvider->executed = $row->executed;  
            $userProvider->timediff = $row->timediff;
            $providersSelected[$row->user_id][] = $userProvider;
        }
        
        return $providersSelected;
    }

    public function getAllUserProvidersCronRun($providerName, $providerType)
    {
        $providerMapper = new Application_Model_ProviderListMapper();
        $providerInfo = $providerMapper->getProviderByNameType($providerName, $providerType);
        $providerId = $providerInfo->id;
        
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('up' => 'user_provider'), array('id' => 'up.id', 'user_id' => 'up.user_id', 'provider_id' => 'up.provider_id', 'provider_user_id' => 'up.provider_user_id',
                          'de_provider_password' => 'AES_DECRYPT(up.provider_password, UNHEX(SHA2(\'my_secret\', 512)))'))
               ->joinLeft(array('upe' => 'user_provider_exe'), 
                       'up.id = upe.user_provider_table_id',
                      array('exe_table_id' => 'upe.id', 'upe.run_name', 'upe.failed', 'upe.executed', 'timediff' => 'TIMESTAMPDIFF(SECOND, upe.run_time, NOW())'))
               ->where('up.provider_id = ?', $providerId);
        $rowSets = $this->getTable()->fetchAll($select);

        $providersSelected = array();
        foreach($rowSets as $k => $row) {
            $userProvider = new Application_Model_UserProviderExe();
            $userProvider->id = $row->id;
            $userProvider->user_id = $row->user_id;
            $userProvider->provider_id = $row->provider_id;
            $userProvider->provider_user_id = $row->provider_user_id;
            $userProvider->provider_password = $row->de_provider_password;
            $userProvider->exe_table_id = $row->exe_table_id;
            $userProvider->run_name = $row->run_name;
            $userProvider->failed = $row->failed;  
            $userProvider->executed = $row->executed;  
            $userProvider->timediff = $row->timediff;  
            
            $providersSelected[$row->user_id][] = $userProvider;
        }
        
        return $providersSelected;
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
               ->where('upe.executed = ?', 0)
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
               ->where('upe.executed = ?', 0)
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
        
        if (empty($exeId)) {
            $failed = 1;
        } else {
            $failed = 0;
        }

        if ($row) {
            $row->exe_id = $exeId;
            $row->run_time = new Zend_Db_Expr('NOW()');
            $row->executed = 0;
            $row->execution_time = 0;
            $row->failed = $failed;
            
            return $row->save();
        } else {
            $data = array();
            $data['user_provider_table_id'] = $userProviderTableId;
            $data['run_name'] = $runName;
            $data['exe_id'] = $exeId;
            $data['run_time'] = new Zend_Db_Expr('NOW()');
            $data['executed'] = 0;
            $data['execution_time'] = 0;
            $data['failed'] = $failed;
            
            return $this->getTable()->insert($data);
        }
        
        return false;        
    }
    
    public function updateFailed($responseFailedIds)
    {
        // Failed execution means run failed.
        $data = array(
            'failed' => 1,
        );
        
        return $this->getTable()->update($data, 'id IN ('.$responseFailedIds.')');
    }
    
    public function updateSucceeded($responseSucceededIds)
    {
        // Successful execution means app could store data.
        $data = array(
            'executed' => 1,
            'execution_time' => new Zend_Db_Expr('NOW()'),
        );
        
        return $this->getTable()->update($data, 'id IN ('.$responseSucceededIds.')');
    }
    
    /*public function runUpdateFailed($responseFailedIds)
    {
        // Failed run means could not create an exe_id
        $data = array(
            'run_time' => new Zend_Db_Expr('NOW()'),
            'failed' => 1,
        );
        
        return $this->getTable()->update($data, 'id IN ('.$responseFailedIds.')');
    }
    
    public function runUpdateSucceeded($responseSucceededIds)
    {
        // Successful run means new exe_id has been created
        $data = array(
            'run_time' => new Zend_Db_Expr('NOW()'),
            'failed' => 0
        );
        
        return $this->getTable()->update($data, 'id IN ('.$responseSucceededIds.')');
    }*/

    
}