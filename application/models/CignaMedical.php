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
    protected $_primary_care_physician;
    
    public function setOption($field, $value)
    {
        $key = '_' . $field;
        $this->$key = $value;
    }
    
    public function getOption($field)
    {
        $key = '_' . $field;
        return $this->$key;
    }
}