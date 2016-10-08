<?php
error_reporting(9);
/**
 * Application_Model_UserProviderMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_UserProviderMapper
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
            $this->_dbTable = new Application_Model_DbTable_UserProvider();
        }
        
        return $this->_dbTable;
    }
    
    /**
     * Get user info
     *
     * @param  int   $userId
     * @return array $info   Array of Application_Model_User
     */
    public function getUserProviderArrForClient($userId)
    {
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('up' => 'user_provider'), array('up.*'))
               ->join(array('pl'=>'provider_list'), 
                      "pl.id = up.provider_id", 
                      array('provider_type' => 'pl.provider_type',
                            'provider_label' => 'pl.label',
                            'provider_name' => 'pl.name',
                            'scrapper_script_path' => 'pl.scrapper_script_path'))
               ->where('up.user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);

        $providersSelected = array();
        foreach($rowSets as $k => $row) {
            $userProvider = new Application_Model_UserProvider();
            $userProvider->id = $row->id;
            $userProvider->user_id = $row->user_id;
            $userProvider->provider_id = $row->provider_id;
            $userProvider->provider_type = $row->provider_type;
            $userProvider->provider_name = $row->provider_name; //str_replace(array(',', '&', '-', ' '), array('', '', '_', '_'), $row->provider_name);
            $userProvider->provider_label = $row->provider_label;
            $userProvider->scrapper_script_path = $row->scrapper_script_path;
            $userProvider->provider_user_id = $row->provider_user_id;
            $userProvider->provider_password = $row->provider_password;
            $userProvider->status = $row->status;
            $providersSelected[$userProvider->provider_type] = $userProvider;
        }
        
        return $providersSelected;
    }
    
    public function getUserProvider($providerId, $userId)
    {
        $select = $this->getTable()->select();
        $select->from(array('up' => 'user_provider'), array('up.*'))
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
            $userProvider->provider_password = $row->provider_password;
            $userProvider->status = $row->status;
            $providersSelected[$row->user_id] = $userProvider;
        }
        
        return $providersSelected;
    }
    
    public function getAllUserProviders($providerName, $providerType)
    {
        $providerMapper = new Application_Model_ProviderListMapper();
        $providerInfo = $providerMapper->getProviderByNameType($providerName, $providerType);
        $providerId = $providerInfo->id;
        
        $select = $this->getTable()->select();
        $select->from(array('up' => 'user_provider'), array('up.*'))
               ->where('up.provider_id = ?', $providerId);
        $rowSets = $this->getTable()->fetchAll($select);

        $providersSelected = array();
        foreach($rowSets as $k => $row) {
            $userProvider = new Application_Model_UserProvider();
            $userProvider->id = $row->id;
            $userProvider->user_id = $row->user_id;
            $userProvider->provider_id = $row->provider_id;
            $userProvider->provider_user_id = $row->provider_user_id;
            $userProvider->provider_password = $row->provider_password;
            $userProvider->status = $row->status;
            $providersSelected[$row->user_id] = $userProvider;
        }
        
        return $providersSelected;
    }
    
    public function updateSiteCredentials($userId, $providerName, $providerType, $providerUserId, $providerPassword)
    {
        $providerMapper = new Application_Model_ProviderListMapper();
        $providerInfo = $providerMapper->getProviderByNameType($providerName, $providerType);
        $providerId = $providerInfo->id;
        $scrapperScriptPath = $providerInfo->scrapper_script_path;
        
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('up' => 'user_provider'), array('up.*'))
               ->join(array('pl'=>'provider_list'), 
                      "pl.id = up.provider_id", 
                      array('provider_name' => 'pl.name', 'scrapper_script_path' => 'pl.scrapper_script_path'));
        $select->where('up.user_id = ?', $userId, 'INTEGER');
        //$select->where('up.provider_id = ?', $providerId, 'INTEGER');
        $select->where('pl.provider_type = ?', $providerType);
        
        $row = $this->getTable()->fetchRow($select);
        
        if ($row) {
            $data = array();
            $data['user_id'] = $userId;
            $data['provider_id'] = $providerId;
            $data['provider_user_id'] = $providerUserId;
            $data['provider_password'] = $providerPassword;
            
            $where = $this->getTable()->getAdapter()->quoteInto('id = ?', $row->id, 'INTEGER');
            
            $ok = $this->getTable()->update($data, $where);
            
            $userProviderExeTable = new Application_Model_DbTable_UserProviderExe();
            $where = $userProviderExeTable->getAdapter()->quoteInto('user_provider_table_id = ?', $row->id);
            $userProviderExeTable->delete($where);        
        } else {
            $data = array();
            $data['user_id'] = $userId;
            $data['provider_id'] = $providerId;
            $data['provider_user_id'] = $providerUserId;
            $data['provider_password'] = $providerPassword;
            
            $ok = $this->getTable()->insert($data);
        }
        
        $providerInfo = array();
        $providerInfo['provider_id'] = $providerId;
        $providerInfo['provider_type'] = $providerType;
        $providerInfo['provider_name'] = $providerName;
        $providerInfo['scrapper_script_path'] = $scrapperScriptPath;

        return $providerInfo;
    }
    
    public function updateExecutionId($userId, $userProviderTableId, $exeId)
    {
        $select = $this->getTable()->select();
        $select->where('id = ?', $userProviderTableId, 'INTEGER');
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        if ($row) {
            $row->exeid = $exeId;
            return $row->save();
        }
        
        return 0;
    }
    
}