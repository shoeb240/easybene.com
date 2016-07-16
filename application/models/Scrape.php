<?php
/**
 * Application_Model_Scrape class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_Scrape
{
    protected $_scrapeId;
    protected $_siteId;
    protected $_userId;
    protected $_medical1;
    protected $_medical2;
    
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
    
    public function setScrapeId($value)
    {
        $this->_scrapeId = $value;
    }
    
    public function getScrapeId()
    {
        return $this->_scrapeId;
    }
    
    public function setSiteId($value)
    {
        $this->_siteId = $value;
    }
    
    public function getSiteId()
    {
        return $this->_siteId;
    }
    
    public function setUserId($value)
    {
        $this->_userId = $value;
    }
    
     public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setMedical1($value)
    {
        $this->_medical1 = $value;
    }

    public function getMedical1()
    {
        return $this->_medical1;
    }
    
    public function setMedical2($value)
    {
        $this->_medical2 = $value;
    }

    public function getMedical2()
    {
        return $this->_medical2;
    }
}