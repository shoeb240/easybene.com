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
    
    public function setScrapeId($scrapeId)
    {
        $this->_scrapeId = $scrapeId;
    }
    
    public function getScrapeId()
    {
        return $this->_scrapeId;
    }
    
    public function setSiteId($siteId)
    {
        $this->_siteId = $siteId;
    }
    
    public function getSiteId()
    {
        return $this->_siteId;
    }
    
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }
    
     public function getUserId()
    {
        return $this->_userId;
    }
    
    public function setMedical1($medical1)
    {
        $this->_medical1 = $medical1;
    }

    public function getMedical1()
    {
        return $this->_medical1;
    }
    
    public function setMedical2($medical2)
    {
        $this->_medical2 = $medical2;
    }

    public function getMedical2()
    {
        return $this->_medical2;
    }
}