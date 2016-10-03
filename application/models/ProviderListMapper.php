<?php
/**
 * Application_Model_AnthemMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_ProviderListMapper
{
    /**
     * @var Application_Model_DbTable_Anthem
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_Anthem
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_ProviderList();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getProviderList($type = null)
    {
        $select = $this->getTable()->select();
        if ($type) {
            $select->where('provider_type = ?', $type);
        }
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $provider = array();
            $provider['id'] = $row->id;
            $provider['provider_type'] = $row->provider_type;
            $provider['label'] = $row->label;
            $provider['name'] = $row->name;
            $provider['url'] = $row->url;
            $provider['image'] = $row->image;
            $provider['status'] = $row->status;
            
            $info[] = $provider;
        }
        
        return $info;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveProviderList(Application_Model_ProviderList $providerList)
    {
        $data = array(
            'id' => $providerList->getOption('id'),
            'provider_type' => $providerList->getOption('provider_type'),
            'label' => $providerList->getOption('label'),
            'name' => $providerList->getOption('name'),
            'url' => trim($providerList->getOption('url')),
            'image' => trim($providerList->getOption('image')),
            'status' => trim($providerList->getOption('status')),
        );

        return $this->getTable()->insert($data);
    }
    
}