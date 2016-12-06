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
class Application_Model_CignaIdCard
{
    protected $_id;
    protected $_user_id;
    protected $_pdf_dl;
    protected $_name;
    protected $_card_id;
    protected $_group;
    protected $_issuer;
    protected $_RxBIN;
    protected $_RxPCN;
    protected $_RxGrp;
    protected $_RxID;
    
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