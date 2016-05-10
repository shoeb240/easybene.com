<?php
/**
 * Application_Model_CignaClaim class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaim
{
    protected $_id;
    protected $_userId;
    protected $_service_date;
    protected $_provided_by;
    protected $_for;
    protected $_status;
    protected $_amount_billed;
    protected $_what_your_plan_paid;
    protected $_my_account_paid;
    protected $_what_i_owe;
    protected $_claim_number;
    
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
    
    public function setId($id)
    {
        $this->_id = $id;
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setServiceDate($serviceDate)
    {
        $this->_service_date = $serviceDate;
    }
    
     public function getServiceDate()
    {
        return $this->_service_date;
    }
    
    public function setProvidedBy($providedBy)
    {
        $this->_provided_by = $providedBy;
    }

    public function getProvidedBy()
    {
        return $this->_provided_by;
    }
    
    public function setFor($for)
    {
        $this->_for = $for;
    }

    public function getFor()
    {
        return $this->_for;
    }
    
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setAmountBilled($amountBilled)
    {
        $this->_amount_billed = $amountBilled;
    }

    public function getAmountBilled()
    {
        return $this->_amount_billed;
    }
    
    public function setWhatYourPlanPaid($whatYourPlanPaid)
    {
        $this->_what_your_plan_paid = $whatYourPlanPaid;
    }

    public function getWhatYourPlanPaid()
    {
        return $this->_what_your_plan_paid;
    }
    
    public function setMyAccountPaid($myAccountPaid)
    {
        $this->_my_account_paid = $myAccountPaid;
    }

    public function getMyAccountPaid()
    {
        return $this->_my_account_paid;
    }
    
    public function setWhatIOwe($whatIOwe)
    {
        $this->_what_i_owe = $whatIOwe;
    }

    public function getWhatIOwe()
    {
        return $this->_what_i_owe;
    }
    
    public function setClaimNumber($claimNumber)
    {
        $this->_claim_number = $claimNumber;
    }

    public function getClaimNumber()
    {
        return $this->_claim_number;
    }
    
    
}