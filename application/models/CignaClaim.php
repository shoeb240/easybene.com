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
    
    public function setUserId($value)
    {
        $this->_userId = $value;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setServiceDate($value)
    {
        $this->_service_date = $value;
    }
    
     public function getServiceDate()
    {
        return $this->_service_date;
    }
    
    public function setProvidedBy($value)
    {
        $this->_provided_by = $value;
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
    
    public function setStatus($value)
    {
        $this->_status = $value;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setAmountBilled($value)
    {
        $this->_amount_billed = $value;
    }

    public function getAmountBilled()
    {
        return $this->_amount_billed;
    }
    
    public function setWhatYourPlanPaid($value)
    {
        $this->_what_your_plan_paid = $value;
    }

    public function getWhatYourPlanPaid()
    {
        return $this->_what_your_plan_paid;
    }
    
    public function setMyAccountPaid($value)
    {
        $this->_my_account_paid = $value;
    }

    public function getMyAccountPaid()
    {
        return $this->_my_account_paid;
    }
    
    public function setWhatIOwe($value)
    {
        $this->_what_i_owe = $value;
    }

    public function getWhatIOwe()
    {
        return $this->_what_i_owe;
    }
    
    public function setClaimNumber($value)
    {
        $this->_claim_number = $value;
    }

    public function getClaimNumber()
    {
        return $this->_claim_number;
    }
    
    
}