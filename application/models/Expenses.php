<?php
/**
 * Application_Model_Expenses class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_Expenses
{
    public $_id;
    public $_provider_type;
    public $_label;
    public $_name;
    public $_description;
    public $_url;
    public $_image;
    public $_status;
    public $_default;
        
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
