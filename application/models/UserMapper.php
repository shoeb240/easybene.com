<?php
/**
 * Application_Model_UserMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_UserMapper
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
            $this->_dbTable = new Application_Model_DbTable_User();
        }
        
        return $this->_dbTable;
    }
    
    /**
     * Get featured members count
     *
     * @return int
     */
    public function getMembersFeaturedCount()
    {
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('u' => 'job_user'), array('total_rows' => 'COUNT(u.user_id)'))
               ->where('u.is_premium = ?', 1);
        $row = $this->getTable()->fetchRow($select);
        
        return $row['total_rows'];
    }    
    
    /**
     * Get userId by username
     *
     * @param  int $username
     * @return int 
     */
    public function getUserId($username)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('user_id'))
               ->where('username = ?', $username);
        
        $row = $this->getTable()->fetchRow($select);
        
        return $row->user_id;
    }
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getUsername($userId)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('username'))
               ->where('user_id = ?', $userId);
        
        $row = $this->getTable()->fetchRow($select);
        
        return $row->username;
    }
    
    /**
     * Get user info
     *
     * @param  int   $userId
     * @return array $info   Array of Application_Model_User
     */
    public function getUser($userId)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('*'))
               ->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);

        $user = new Application_Model_User();
        $user->setUserId($row->user_id);
        $user->setUsername($row->username);
        $user->setFullName($row->full_name);
        $user->setEmail($row->email);

        return $user;
    }
    
    
    /**
     * Get user info
     *
     * @param  int   $userId
     * @return array $info   Array of Application_Model_User
     */
    public function getUserArr($userId)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('*'))
               ->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);

        $userInfo = array();
        $userInfo['user_id'] = $row->user_id;
        $userInfo['username'] = $row->username;
        $userInfo['api_token'] = $row->api_token;
        $userInfo['api_updated'] = $row->api_updated;
        $userInfo['cigna_user_id'] = $row->cigna_user_id;
        $userInfo['cigna_password'] = $row->cigna_password;
        $userInfo['cigna_execution_id'] = $row->cigna_execution_id;
        
        return $userInfo;
    }
    
    /**
     * Get user info
     *
     * @param  int   $userId
     * @return array $info   Array of Application_Model_User
     */
    public function getUserArrForClient($userId)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('*'))
               ->where('user_id = ?', $userId);
        $row = $this->getTable()->fetchRow($select);

        $userInfo = array();
        $userInfo['user_id'] = $row->user_id;
        $userInfo['username'] = $row->username;
        $userInfo['api_token'] = $row->api_token;
        $userInfo['api_updated'] = $row->api_updated;
        if (!empty($userInfo['cigna_user_id']) && !empty($userInfo['cigna_password'])) {
            $userInfo['cigna_exists'] = 'yes';
        } else {
            $userInfo['cigna_exists'] = 'no';
        }
        
        return $userInfo;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $user
     * @return int
     */
    public function saveUser(Application_Model_User $user)
    {
        $password = $this->getTable()->getAdapter()->quoteInto('MD5(?)', $user->getPassword());
        $data = array(
            'username' => $user->getUsername(),
            'password' => new Zend_Db_Expr($password),
            'api_token' => $user->getApiToken(),
            'api_updated' => $user->getApiUpdated(),
        );
        
        if ($this->getTable()->insert($data)) {
            unset($data['password']);
            return $data;
        }
        
        return false;
        
    }
    
    /**
     * Get bookmarked mebers by the user
     *
     * @param  int   $userId
     * @param  int   $searchType
     * @param  int   $startLimit
     * @param  int   $limit
     * @return array $info       Array of Application_Model_User
     */
    public function getUserAll($startLimit = 0, $limit = 4)
    {
        $select = $this->getTable()->select();
        $select->from('job_user', array('*'))
               ->limit($limit, $startLimit);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $user = new Application_Model_User();
            $user->setUserId($row->user_id);
            $user->setUsername($row->username);
            $user->setFullName($row->full_name);
            $user->setEmail($row->email);
            $user->setCignaUserId($row->cigna_user_id);
            $user->setCignaPassword($row->cigna_password);
            $user->setCignaMedicalExeid($row->cigna_medical_exeid);
            $user->setCignaDeductibleClaimExeid($row->cigna_deductible_claim_exeid);
            $user->setCignaClaimDetailsExeid($row->cigna_claim_details_exeid);
            $user->setGuardianUserId($row->guardian_user_id);
            $user->setGuardianPassword($row->guardian_password);
            $user->setGuardianClaimExeid($row->guardian_claim_exeid);
            $user->setGuardianBenefitExeid($row->guardian_benefit_exeid);
            $user->setAnthemUserId($row->anthem_user_id);
            $user->setAnthemPassword($row->anthem_password);
            $user->setAnthemExeid($row->anthem_exeid);
            $user->setAnthemClaimOverviewExeid($row->anthem_claim_overview_exeid);
            $info[] = $user;
        }
        
        return $info;
    }
    
    /**
     * Get searched members
     *
     * @param  int   $username
     * @return array $info      Array of Application_Model_User
     */
    public function getSearchedMembers($username)
    {
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('u' => 'job_user'), array('u.user_id', 'u.username', 'u.created_on', 
                                                      'u.country', 'u.is_premium',
                                                      'u.profile_image', 
                                                      'balance' => '(SELECT SUM(cb.balance) 
                                                                     FROM job_credit_balance cb 
                                                                     WHERE cb.user_id = u.user_id)'))
               ->join(array('p'=>'job_project'), 
                            "u.user_id = p.assigned_user_id AND (p.project_status = 'closed' OR p.project_status = 'opened')", 
                            array('closed_projects' => "SUM(CASE WHEN project_status LIKE '%closed%' THEN 1 ELSE 0 END)",
                                  'opened_projects' => "SUM(CASE WHEN project_status LIKE '%opened%' THEN 1 ELSE 0 END)"))
               ->joinLeft(array('pc' => 'job_primary_category'), 
                          'u.primary_category_id = pc.primary_category_id', 
                          array('pc.category_title'))
               ->where("u.username LIKE '%{$username}%'")
               ->where('u.status = ?', 1)
               ->group('u.user_id')
               ->order('u.username');
        $rowSets = $this->getTable()->fetchAll($select);

        $info = array();
        foreach($rowSets as $k => $row) {
            $user = new Application_Model_User();
            $user->setUserId($row->user_id);
            $user->setUsername($row->username);
            $user->setCreatedOn($row->created_on);
            $user->setCountry($row->country);
            $user->setIsPremium($row->is_premium);
            $user->setProfileImage($row->profile_image);
            $user->setOpenProjects($row->opened_projects);
            $user->setUserHired($row->closed_projects);
            $user->setBalance($row->balance);
            $user->setRating($this->getUserRating($row->balance));
            $primaryCategory = new Application_Model_PrimaryCategory();
            $primaryCategory->setCategoryTitle($row->category_title);
            $user->setPrimaryCategory($primaryCategory);
            $info[] = $user;
        }
        
        return $info;
    }
    
    /**
     * Get searched creative members who have completed projects
     *
     * @param  int   $username
     * @return array $info      Array of Application_Model_User
     */
    public function getSearchedCreatives($username)
    {
        $select = $this->getTable()->select();
        $select->setIntegrityCheck(false)
               ->from(array('u' => 'job_user'), array('u.user_id', 'u.username', 'u.created_on', 
                                                      'u.country', 'u.profile_image', 
                                                      'balance' => '(SELECT SUM(cb.balance) 
                                                                     FROM job_credit_balance cb 
                                                                     WHERE cb.user_id = u.user_id)'))
               ->join(array('p'=>'job_project'), 
                      "u.user_id = p.assigned_user_id AND p.project_status = 'closed'", 
                      array('closed_projects' => 'COUNT(p.project_status)'))
               ->joinLeft(array('pc' => 'job_primary_category'), 
                          'u.primary_category_id = pc.primary_category_id', 
                          array('pc.category_title'))

               ->where("u.username LIKE '%{$username}%'")
               ->where('u.status = ?', 1)
               ->group('u.user_id')
               ->order('u.username');
        $rowSets = $this->getTable()->fetchAll($select);

        $info = array();
        foreach($rowSets as $k => $row) {
            $user = new Application_Model_User();
            $user->setUserId($row->user_id);
            $user->setUsername($row->username);
            $user->setCreatedOn($row->created_on);
            $user->setCountry($row->country);
            $user->setProfileImage($row->profile_image);
            $user->setUserWorked($row->closed_projects);
            $user->setBalance($row->balance);
            $user->setRating($this->getUserRating($row->balance));
            $primaryCategory = new Application_Model_PrimaryCategory();
            $primaryCategory->setCategoryTitle($row->category_title);
            $user->setPrimaryCategory($primaryCategory);
            $info[] = $user;
        }
        
        return $info;
    }
    
    /**
     * Update user cigna_execution_id
     *
     * @param  int $userId
     * @param  int $subscrId
     * @return int 
     */
    public function updateExecutionId($userId, $exeId, $exeFieldName)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        if ($row) {
            $row->$exeFieldName = $exeId;
            return $row->save();
        }
        
        return 0;
    }
    
    /**
     * Update user cigna_execution_id
     *
     * @param  int $userId
     * @param  int $subscrId
     * @return int 
     */
    public function updateSiteCredentials($userId, $siteName, $siteType, $siteUserId, $sitePassword)
    {
        $select = $this->getTable()->select();
        $select->where('user_id = ?', $userId, 'INTEGER');
        $row = $this->getTable()->fetchRow($select);
        
        if ($row) {
            switch ($siteName) {
                case 'Cigna':
                    $row->cigna_user_id = $siteUserId;
                    $row->cigna_password = $sitePassword;
                    break;
                case 'Anthem':
                    $row->anthem_user_id = $siteUserId;
                    $row->anthem_password = $sitePassword;
                    break;
                case 'Guardian':
                    $row->guardian_user_id = $siteUserId;
                    $row->guardian_password = $sitePassword;
                    break;
            }
            switch ($siteType) {
                case 'Medical':
                    $row->medical_site = $siteName;
                    break;
                case 'Dental':
                    $row->dental_site = $siteName;
                    break;
                case 'Vision':
                    $row->vision_site = $siteName;
                    break;
            }
            $row->save();
        
            $userInfo = array();
            $userInfo['user_id'] = $row->user_id;
            $userInfo['username'] = $row->username;
            $userInfo['api_token'] = $row->api_token;
            $userInfo['api_updated'] = $row->api_updated;
            $userInfo['medical_site'] = $row->medical_site;
            $userInfo['dental_site'] = $row->dental_site;
            $userInfo['vision_site'] = $row->vision_site;
            
            return $userInfo;
        }
        
        return false;
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