<?php
/**
 * Application_Model_UnitedConcordiaDentalClaim class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_UnitedConcordiaDentalClaim
{
    protected $_id;
    protected $_userId;
    protected $_claim_number;
    protected $_patient_name;
    protected $_date_of_service;
    protected $_dentist;
    protected $_paid_date;
    protected $_status;
    protected $_submitted_charges;
    protected $_amount_paid;
    
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