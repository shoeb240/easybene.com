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
class Application_Model_AnthemClaimOverview
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
    
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }
    
    public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setPatient($patient)
    {
        $this->_patient = $patient;
    }
    
    public function getPatient()
    {
        return $this->_patient;
    }
    
    public function setCoverageType($coverageType)
    {
        $this->_coverage_type = $coverageType;
    }
    
    public function getCoverageType()
    {
        return $this->_coverage_type;
    }
    
    public function setClaimNumber($claimNumber)
    {
        $this->_claim_number = $claimNumber;
    }
    
    public function getClaimNumber()
    {
        return $this->_claim_number;
    }
    
    public function setPatientName($patientName)
    {
        $this->_patient_name = $patientName;
    }
    
    public function getPatientName()
    {
        return $this->_patient_name;
    }
    
    public function setDateOfService($dateOfService)
    {
        $this->_date_of_service = $dateOfService;
    }
    
    public function getDateOfService()
    {
        return $this->_date_of_service;
    }
    
    public function setPaidDate($paidDate)
    {
        $this->_paid_date = $paidDate;
    }
    
     public function getPaidDate()
    {
        return $this->_paid_date;
    }
    
    public function setCheckNumber($checkNumber)
    {
        $this->_check_number = $checkNumber;
    }

    public function getCheckNumber()
    {
        return $this->_check_number;
    }
    
    public function setProviderNumber($providerNumber)
    {
        $this->_provider_number = $providerNumber;
    }

    public function getProviderNumber()
    {
        return $this->_provider_number;
    }
    
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    public function getStatus()
    {
        return $this->_status;
    }
    
    public function setSubmittedCharges($submittedCharges)
    {
        $this->_submitted_charges = $submittedCharges;
    }

    public function getSubmittedCharges()
    {
        return $this->_submitted_charges;
    }
    
    public function setAmountPaid($amountPaid)
    {
        $this->_amount_paid = $amountPaid;
    }

    public function getAmountPaid()
    {
        return $this->_amount_paid;
    }
}