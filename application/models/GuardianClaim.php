<?php
/**
 * Application_Model_CignaDeductible class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_GuardianClaim
{
    protected $_id;
    protected $_userId;
    protected $_patient;
    protected $_coverage_type;
    protected $_claim_number;
    protected $_patient_name;
    protected $_date_of_service;
    protected $_paid_date;
    protected $_check_number;
    protected $_provider_number;
    protected $_status;
    protected $_submitted_charges;
    protected $_amount_paid;
    
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
    
    public function setPatient($value)
    {
        $this->_patient = $value;
    }
    
    public function getPatient()
    {
        return $this->_patient;
    }
    
    public function setCoverageType($value)
    {
        $this->_coverage_type = $value;
    }
    
    public function getCoverageType()
    {
        return $this->_coverage_type;
    }
    
    public function setClaimNumber($value)
    {
        $this->_claim_number = $value;
    }
    
    public function getClaimNumber()
    {
        return $this->_claim_number;
    }
    
    public function setPatientName($value)
    {
        $this->_patient_name = $value;
    }
    
    public function getPatientName()
    {
        return $this->_patient_name;
    }
    
    public function setDateOfService($value)
    {
        $this->_date_of_service = $value;
    }
    
    public function getDateOfService()
    {
        return $this->_date_of_service;
    }
    
    public function setPaidDate($value)
    {
        $this->_paid_date = $value;
    }
    
     public function getPaidDate()
    {
        return $this->_paid_date;
    }
    
    public function setCheckNumber($value)
    {
        $this->_check_number = $value;
    }

    public function getCheckNumber()
    {
        return $this->_check_number;
    }
    
    public function setProviderNumber($value)
    {
        $this->_provider_number = $value;
    }

    public function getProviderNumber()
    {
        return $this->_provider_number;
    }
    
    public function setStatus($value)
    {
        $this->_status = $value;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setSubmittedCharges($value)
    {
        $this->_submitted_charges = $value;
    }

    public function getSubmittedCharges()
    {
        return $this->_submitted_charges;
    }
    
    public function setAmountPaid($value)
    {
        $this->_amount_paid = $value;
    }

    public function getAmountPaid()
    {
        return $this->_amount_paid;
    }
}