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
    protected $_userId;
    protected $_deductible_amt;
    protected $_deductible_met;
    protected $_deductible_remaining;
    protected $_out_of_pocket_amt;
    protected $_out_of_pocket_met;
    protected $_out_of_pocket_remaining;
    
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
    
    public function setDeductibleAmt($deductibleAmt)
    {
        $this->_deductible_amt = $deductibleAmt;
    }
    
    public function getDeductibleAmt()
    {
        return $this->_deductible_amt;
    }
    
    public function setDeductibleMet($deductibleMet)
    {
        $this->_deductible_met = $deductibleMet;
    }
    
    public function getDeductibleMet()
    {
        return $this->_deductible_met;
    }
    
    public function setDeductibleRemaining($deductibleRemaining)
    {
        $this->_deductible_remaining = $deductibleRemaining;
    }
    
     public function getDeductibleRemaining()
    {
        return $this->_deductible_remaining;
    }
    
    public function setOutOfPocketAmt($outOfPocketAmt)
    {
        $this->_out_of_pocket_amt = $outOfPocketAmt;
    }

    public function getOutOfPocketAmt()
    {
        return $this->_out_of_pocket_amt;
    }
    
    public function setOutOfPocketMet($outOfPocketMet)
    {
        $this->_out_of_pocket_met = $outOfPocketMet;
    }

    public function getOutOfPocketMet()
    {
        return $this->_out_of_pocket_met;
    }
    
    public function setOutOfPocketRemaining($outOfPocketRemaining)
    {
        $this->_out_of_pocket_remaining = $outOfPocketRemaining;
    }

    public function getOutOfPocketRemaining()
    {
        return $this->_out_of_pocket_remaining;
    }
}