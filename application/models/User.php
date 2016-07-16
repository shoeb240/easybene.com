<?php
/**
 * Application_Model_User class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_User
{
    protected $_user_id;
    protected $_username;
    protected $_fullName;
    protected $_email;
    protected $_password;
    protected $_createdOn;
    protected $_status;
    protected $_api_token;
    protected $_api_updated;
    protected $_medical_site;
    protected $_dental_site;
    protected $_vision_site;
    protected $_cigna_user_id;
    protected $_cigna_password;
    protected $_cigna_medical_exeid;
    protected $_cigna_deductible_claim_exeid;
    protected $_cigna_claim_details_exeid;
    protected $_guardian_user_id;
    protected $_guardian_password;    
    protected $_guardian_benefit_exeid;
    protected $_guardian_claim_exeid;
    protected $_anthem_user_id;
    protected $_anthem_password;
    protected $_anthem_exeid;
    protected $_anthem_claim_overview_exeid;
    protected $_navia_user_id;
    protected $_navia_password;
    protected $_navia_statements_exeid;
    protected $_navia_day_care_exeid;
    protected $_navia_health_care_exeid;
    protected $_navia_health_savings_exeid;
    
    
    public function __construct($options = null)
    {
        if (is_array($options)) $this->setOptions($options);
    }
    
    public function setOptions($options)
    {
        $methods = get_class_methods($this);
        foreach($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setUsername($username)
    {
        $this->_username = $username;
    }
    
    public function getUsername()
    {
        return $this->_username;
    }
    
    public function setFullName($fullName)
    {
        $this->_fullName = $fullName;
    }
    
    public function getFullName()
    {
        return $this->_fullName;
    }
    
    public function setEmail($email)
    {
        $this->_email = $email;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setPassword($password)
    {
        $this->_password = $password;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }
    
    public function setCreatedOn($createdOn)
    {
        $this->_createdOn = $createdOn;
    }
    
    public function getCreatedOn()
    {
        return $this->_createdOn;
    }
    
    public function setStatus($status)
    {
        $this->_status = $status;
    }
    
    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setApiToken($apiToken)
    {
        $this->_api_token = $apiToken;
    }
    
    public function getApiToken()
    {
        return $this->_api_token;
    }
    
    public function setApiUpdated($apiUpdated)
    {
        $this->_api_updated = $apiUpdated;
    }
    
    public function getApiUpdated()
    {
        return $this->_api_updated;
    }
    
    public function setCignaUserId($cignaUserId)
    {
        $this->_cigna_user_id = $cignaUserId;
    }
    
    public function getCignaUserId()
    {
        return $this->_cigna_user_id;
    }
    
    public function setCignaPassword($cignaPassword)
    {
        $this->_cigna_password = $cignaPassword;
    }
    
    public function getCignaPassword()
    {
        return $this->_cigna_password;
    }
    
    public function setCignaMedicalExeid($cignaMedicalExeid)
    {
        $this->_cigna_medical_exeid = $cignaMedicalExeid;
    }
    
    public function getCignaMedicalExeid()
    {
        return $this->_cigna_medical_exeid;
    }
    
    public function setCignaDeductibleClaimExeid($cignaDeductibleClaimExeid)
    {
        $this->_cigna_deductible_claim_exeid = $cignaDeductibleClaimExeid;
    }
    
    public function getCignaDeductibleClaimExeid()
    {
        return $this->_cigna_deductible_claim_exeid;
    }
    
    public function setCignaClaimDetailsExeid($cignaClaimDetailsExeid)
    {
        $this->_cigna_claim_details_exeid = $cignaClaimDetailsExeid;
    }
    
    public function getCignaClaimDetailsExeid()
    {
        return $this->_cigna_claim_details_exeid;
    }
    
    public function setGuardianUserId($guardianUserId)
    {
        $this->_guardian_user_id = $guardianUserId;
    }
    
    public function getGuardianUserId()
    {
        return $this->_guardian_user_id;
    }
    
    public function setGuardianPassword($guardianPassword)
    {
        $this->_guardian_password = $guardianPassword;
    }
    
    public function getGuardianPassword()
    {
        return $this->_guardian_password;
    }
    
    public function setGuardianBenefitExeid($guardianBenefitExeid)
    {
        $this->_guardian_benefit_exeid = $guardianBenefitExeid;
    }
    
    public function getGuardianBenefitExeid()
    {
        return $this->_guardian_benefit_exeid;
    }
    
    public function setGuardianClaimExeid($guardianClaimExeid)
    {
        $this->_guardian_claim_exeid = $guardianClaimExeid;
    }
    
    public function getGuardianClaimExeid()
    {
        return $this->_guardian_claim_exeid;
    }
    
    public function setAnthemUserId($anthemUserId)
    {
        $this->_anthem_user_id = $anthemUserId;
    }
    
    public function getAnthemUserId()
    {
        return $this->_anthem_user_id;
    }
    
    public function setAnthemPassword($anthemPassword)
    {
        $this->_anthem_password = $anthemPassword;
    }
    
    public function getAnthemPassword()
    {
        return $this->_anthem_password;
    }
    
    public function setAnthemExeid($anthemExeid)
    {
        $this->_anthem_exeid = $anthemExeid;
    }
    
    public function getAnthemExeid()
    {
        return $this->_anthem_exeid;
    }
    
    public function setAnthemClaimOverviewExeid($anthemClaimOverviewExeid)
    {
        $this->_anthem_claim_overview_exeid = $anthemClaimOverviewExeid;
    }
    
    public function getAnthemClaimOverviewExeid()
    {
        return $this->_anthem_claim_overview_exeid;
    }
    
    public function setNaviaUserId($value)
    {
        $this->_navia_user_id = $value;
    }
    
    public function getNaviaUserId()
    {
        return $this->_navia_user_id;
    }
    
    public function setNaviaPassword($value)
    {
        $this->_navia_password = $value;
    }
    
    public function getNaviaPassword()
    {
        return $this->_navia_password;
    }
    
    public function setNaviaStatementsExeid($value)
    {
        $this->_navia_statements_exeid = $value;
    }
    
    public function getNaviaStatementsExeid()
    {
        return $this->_navia_statements_exeid;
    }
    
    public function setNaviaDayCareExeid($value)
    {
        $this->_navia_day_care_exeid = $value;
    }
    
    public function getNaviaDayCareExeid()
    {
        return $this->_navia_day_care_exeid;
    }
    
    public function setNaviaHealthCareExeid($value)
    {
        $this->_navia_health_care_exeid = $value;
    }
    
    public function getNaviaHealthCareExeid()
    {
        return $this->_navia_health_care_exeid;
    }
    
    public function setNaviaHealthSavingsExeid($value)
    {
        $this->_navia_health_savings_exeid = $value;
    }
    
    public function getNaviaHealthSavingsExeid()
    {
        return $this->_navia_health_savings_exeid;
    }
    
    
    
    
    
}