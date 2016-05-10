<?php
/**
 * Application_Model_CignaMedical class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_CignaMedical
{
    protected $_id;
    protected $_user_id;
    protected $_whos_covered;
    protected $_date_of_birth;
    protected $_relationship;
    protected $_coverage_from;
    protected $_to;
    
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
        $this->_user_id = $userId;
    }
    
    public function getUserId()
    {
        return $this->_user_id;
    }
    
    public function setWhosCovered($whosCovered)
    {
        $this->_whos_covered = $whosCovered;
    }
    
    public function getWhosCovered()
    {
        return $this->_whos_covered;
    }
    
    public function setDateOfBirth($dateOfBirth)
    {
        $this->_date_of_birth = $dateOfBirth;
    }
    
    public function getDateOfBirth()
    {
        return $this->_date_of_birth;
    }
    
    public function setRelationship($relationship)
    {
        $this->_relationship = $relationship;
    }
    
     public function getRelationship()
    {
        return $this->_relationship;
    }
    
    public function setCoverageFrom($coverageFrom)
    {
        $this->_coverage_from = $coverageFrom;
    }

    public function getCoverageFrom()
    {
        return $this->_coverage_from;
    }
    
    public function setTo($to)
    {
        $this->_to = $to;
    }

    public function getTo()
    {
        return $this->_to;
    }
}