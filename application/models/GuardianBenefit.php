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
class Application_Model_GuardianBenefit
{
    protected $_id;
    protected $_userId;
    protected $_group_id;
    protected $_company_name;
    protected $_member_name;
    protected $_name;
    protected $_relationship;
    protected $_coverage;    
    protected $_original_effective_date;
    protected $_amounts;
    protected $_monthly_cost;
    
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
    
    public function setGroupId($value)
    {
        $this->_group_id = $value;
    }
    
    public function getGroupId()
    {
        return $this->_group_id;
    }
    
    public function setCompanyName($value)
    {
        $this->_company_name = $value;
    }
    
    public function getCompanyName()
    {
        return $this->_company_name;
    }
    
    public function setMemberName($value)
    {
        $this->_member_name = $value;
    }
    
     public function getMemberName()
    {
        return $this->_member_name;
    }
    
    public function setName($value)
    {
        $this->_name = $value;
    }

    public function getName()
    {
        return $this->_name;
    }
    
    public function setRelationship($value)
    {
        $this->_relationship = $value;
    }

    public function getRelationship()
    {
        return $this->_relationship;
    }
    
    public function setCoverage($value)
    {
        $this->_coverage = $value;
    }

    public function getCoverage()
    {
        return $this->_coverage;
    }
    
    public function setOriginalEffectiveDate($value)
    {
        $this->_original_effective_date = $value;
    }

    public function getOriginalEffectiveDate()
    {
        return $this->_original_effective_date;
    }
    
    public function setAmounts($value)
    {
        $this->_amounts = $value;
    }

    public function getAmounts()
    {
        return $this->_amounts;
    }
    
    public function setMonthlyCost($value)
    {
        $this->_monthly_cost = $value;
    }

    public function getMonthlyCost()
    {
        return $this->_monthly_cost;
    }
}
