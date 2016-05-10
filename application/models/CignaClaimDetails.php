<?php
/**
 * Application_Model_CignaClaimDetails class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaClaimDetails
{
    protected $_id;
    protected $_userId;
    protected $_service_date_type;
    protected $_service_amount_billed;
    protected $_service_discount;
    protected $_service_covered_amount;
    protected $_service_copay_deductible;
    protected $_service_what_your_plan_paid;
    protected $_service_coinsurance;
    protected $_service_what_i_owe;
    protected $_service_see_notes;
    
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
    
    public function setServiceDateType($serviceDateType)
    {
        $this->_service_date_type = $serviceDateType;
    }
    
    public function getServiceDateType()
    {
        return $this->_service_date_type;
    }
    
    public function setServiceAmountBilled($serviceAmountBilled)
    {
        $this->_service_amount_billed = $serviceAmountBilled;
    }
    
    public function getServiceAmountBilled()
    {
        return $this->_service_amount_billed;
    }
    
    public function setServiceDiscount($serviceDiscount)
    {
        $this->_service_discount = $serviceDiscount;
    }
    
     public function getServiceDiscount()
    {
        return $this->_service_discount;
    }
    
    public function setServiceCoveredAmount($serviceCoveredAmount)
    {
        $this->_service_covered_amount = $serviceCoveredAmount;
    }

    public function getServiceCoveredAmount()
    {
        return $this->_service_covered_amount;
    }
    
    public function setServiceCopayDeductible($serviceCopayDeductible)
    {
        $this->_service_copay_deductible = $serviceCopayDeductible;
    }

    public function getServiceCopayDeductible()
    {
        return $this->_service_copay_deductible;
    }
    
    public function setServiceWhatYourPlanPaid($serviceWhatYourPlanPaid)
    {
        $this->_service_what_your_plan_paid = $serviceWhatYourPlanPaid;
    }

    public function getServiceWhatYourPlanPaid()
    {
        return $this->_service_what_your_plan_paid;
    }
    
    public function setServiceCoinsurance($serviceCoinsurance)
    {
        $this->_service_coinsurance = $serviceCoinsurance;
    }

    public function getServiceCoinsurance()
    {
        return $this->_service_coinsurance;
    }
    
    public function setServiceWhatIOwe($serviceWhatIOwe)
    {
        $this->_service_what_i_owe = $serviceWhatIOwe;
    }

    public function getServiceWhatIOwe()
    {
        return $this->_service_what_i_owe;
    }
    
    public function setServiceSeeNotes($serviceSeeNotes)
    {
        $this->_service_see_notes = $serviceSeeNotes;
    }

    public function getServiceSeeNotes()
    {
        return $this->_service_see_notes;
    }
    
}