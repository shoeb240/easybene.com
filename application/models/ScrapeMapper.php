<?php
/**
 * Application_Model_ScrapeMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_ScrapeMapper
{
    /**
     * @var Application_Model_DbTable_Scrape
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_Scrape
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_Scrape();
        }
        
        return $this->_dbTable;
    }
    
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getScrape($userId)
    {
        $select = $this->getTable()->select();
        $select->from('scrape', array('*'))
               ->where('user_id = ?', $userId);
        
        $row = $this->getTable()->fetchRow($select);
        
        return $row->username;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveScrape(Application_Model_Scrape $scrape)
    {
        $data = array(
            'site_id' => $scrape->getSiteId(),
            'user_id' => $scrape->getUserId(),
            'medical1' => $scrape->getMedical1(),
            'medical2' => $scrape->getMedical2(),
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
    public function updateScrape($userId, $subscrId)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        if ($row && $row->is_premium == 0) {
            $row->is_premium = 1;
            $row->subscr_id = $subscrId;
            $row->subscription_start_date = date('Y-m-d H:i:s',time());

            return $row->save();
        }
        
        return 0;
    }
    
    /**
     * Update user info
     *
     * @param  Application_Model_User $user
     * @return int
     */
    public function updateUser(Application_Model_User $user)
    {
        $data = array(
            'full_name' => $user->getFullName(),
            'profile_image' => $user->getProfileImage(),
            'email' => $user->getEmail(),
            'contact_no' => $user->getContactNo(),
            'company' => $user->getCompany(),
            'NRIC_ROC_number' => $user->getNricRocNumber()
        );
        
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ?', $user->getUserId(), 'INTEGER');
        
        return $this->getTable()->update($data, $where);
    }
    
    
    
}