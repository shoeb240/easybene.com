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
class Application_Model_CignaDeductible
{
    protected $_id;
    protected $_user_id;
    protected $_deductible_amt;
    protected $_deductible_met;
    protected $_deductible_remaining;
    protected $_out_of_pocket_amt;
    protected $_out_of_pocket_met;
    protected $_out_of_pocket_remaining;
    
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