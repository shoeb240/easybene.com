<?php

/**
 * User row class
 *
 * @author Dmitriy Britan <dmitriy.britan@nixsolutions.com>
 */
class Application_Model_User extends Zend_Db_Table_Row_Abstract
{
    protected $_tableClass = 'Application_Model_DbTable_User';
    
    const USER_DISALLOW = 0;
    const USER_ALLOW    = 1;
    const USER_LABEL    = 2;
    
    const ROLE_MEMBER = 1;
    const ROLE_DJ     = 2;
    const ROLE_ARTIST = 4;
    const ROLE_LABEL = 8;
    const ROLE_ADMIN  = 64;
    
    const PAY_MODE_PAYPAL = "paypal";
    const PAY_MODE_AUTHORIZE = "creditcard";
    const PAY_MODE_MONEYORDER = "moneyorder";

    const USER_NOTIFY_SENDED = 8;
    const USER_NOTIFY_YES = 4;
    const USER_NOTIFY_NOT = 1;
    const USER_NOTIFY_UNSUBSCRIBE = 0;
    
    const CAN_USE_SITE = 1;
    const SHOULD_SUBSCRIBE = 2;
    const SHOULD_BE_PROCEEDED_MANUALLY = 4;

    public function save()
    {
        //password should be changed only if password was changed and login is not empty
        if (($this->isModified('password') && !empty($this->password)) && !empty($this->login)) {
            $this->password = $this->crypt($this->login, $this->password);
        } else {
            //if login was changed but password wasn't - don't changing anything
            $this->login = $this->_cleanData['login'];
            $this->password = $this->_cleanData['password'];
        }
        
        if (count($this->_modifiedFields) > 0) {
            $this->last_updated = date("Y-m-d H:i:s");
        }
        if (Zend_Auth::getInstance()->hasIdentity() && (Zend_Auth::getInstance()->getIdentity()->id == $this->id)) {
            Zend_Auth::getInstance()->getStorage()->write($this);
            if (!$this->isConnected()) {
                $this->setTable(new Application_Model_DbTable_User());
            }
        }

        return parent::save();
    }
    
    public static function getRoles()
    {
        return array(
            self::ROLE_MEMBER => self::ROLE_MEMBER,
            self::ROLE_DJ => self::ROLE_DJ,
            self::ROLE_ARTIST => self::ROLE_ARTIST,
            self::ROLE_LABEL => self::ROLE_LABEL,
            self::ROLE_ADMIN => self::ROLE_ADMIN
        );
    }
    
    public static function getRoleDescriptions()
    {
        return array(
            self::ROLE_MEMBER => 'Member',
            self::ROLE_DJ => 'DJ',
            self::ROLE_ARTIST => 'Artist',
            self::ROLE_LABEL => 'Label',
            self::ROLE_ADMIN => 'Admin'
        );
    }
    
    protected function isModified($key) 
    {
        //return $this->_modifiedFields[$key];
        return $this->_data[$key] != $this->_cleanData[$key];
    }
    
    /**
     * Saving subscription id to history if it modified
     */
    protected function _saveSubscriptionInHistory()
    {
        // Save subscription to history only if it have new id
        if ($this->_modifiedFields['auth_sub_id'] && $this->auth_sub_id != '') {
            $history = new Default_Model_DbTable_SubHist();
            
            $data = array(
                'user_id' => $this->id,
                'auth_sub_id' => $this->auth_sub_id,
                'date_added' => date('Y-m-d H:i:s')
            );
            
            $history->insert($data);
        }
    }
    
    /**
     * Saving user locks to history if it modified
     */
    protected function _saveLocksHistory()
    {
        if ($this->_modifiedFields['allow_user']) {
            // Cancelling subscription if user was deactivated
            if ($this->_cleanData['allow_user'] == 1 && $this->allow_user == 0) {
                //$payments = new Default_Model_Manager_Payments();
                //$payments->cancelSubscription($this, false);
                Default_Model_Manager_Mail::send('billing-deactivation', $this->toArray());
                Default_Model_Manager_Mail::send('deactivation', $this->toArray(), $this->email);
                $this->_updateLockOutTable($this->allow_user);
            } elseif ($this->_cleanData['allow_user'] == 0 && $this->allow_user == 1) {
                $this->_updateLockOutTable($this->allow_user);
                $transactionsManager = new Default_Model_Manager_Payments();
                try {
                    $lastPayment = $transactionsManager->getLastSuccesPayment($this);
                } catch (Exception $exception) {
                    $exception = $exception;
                }
                $toUser =  $lastPayment ? array_merge($this->toArray(), $lastPayment->toArray()) : $this->toArray();
                $toBilling = $lastPayment ? $this->toArray() : array_merge($this->toArray(), array('warning' => 'nopayment'));
                Default_Model_Manager_Mail::send('billing-activation', $toBilling);
                Default_Model_Manager_Mail::send('activation', $toUser, $this->email);                
            } elseif ($this->_cleanData['allow_user'] <> $this->allow_user){
                $this->_updateLockOutTable($this->allow_user);
            }
        }
    }

    protected function _updateLockOutTable($state)
    {
        $messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
        $history = new Default_Model_DbTable_LockOutCount();

        $data = array(
            'user_id' => $this->id,
            'lockout_val' => $state,
            'lockout_date' => date('Y-m-d H:i:s')
        );
        $history->insert($data);
        $loginedUser = Zend_Auth::getInstance()->getIdentity();

        if (isset($loginedUser) && $loginedUser->hasRole(self::ROLE_ADMIN)){
            $messenger->addMessage('New lockout value ' . $state . ' stored');
        }
    }
    
    protected function _insert()
    {
        parent::_insert();
        //THIS part of code never executed
        //$this->_saveSubscriptionInHistory();
        //$this->_saveLocksHistory();
    }
        
    protected function _postUpdate()
    {
        $this->_saveSubscriptionInHistory();
        $this->_saveLocksHistory();
        parent::_postUpdate();
    }
    
    public static function crypt($username, $password)
    {
        return crypt(md5($password), md5(trim($username)));
    }
    
    /**
     * Activate/deactivate(lockout) user
     * 
     * @param int $status Use Default_Model_User::USER_ALLOW or Default_Model_User::USER_DISALLOW constant
     */
    public function changeStatus($status){
        
        $this->allow_user = $status;
        $this->save();
        
    }
    
    /**
     * 
     * @return bool
     */
    public function isAllow()
    {
        return $this->allow_user == self::USER_ALLOW;        
    }
    
    
    /**
     * Back charge member calculation
     * 
     * @return array Lockoutdate & owe monts
     */
    public function backCharge(){ 
        if ($this->allow_user == self::USER_ALLOW){
            return false;
        }
        
        $sql = "SELECT lockout_date, PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(lockout_date, '%Y%m')) AS OWEMONTHS FROM recordpool_lockoutCount  WHERE user_id = {$this->id} AND lockout_val = 0 ORDER BY lockoutCount_id DESC LIMIT 1;";
        $result = $this->getTable()->getAdapter()->query($sql)->fetch(PDO::FETCH_ASSOC);
        $result['amount'] = $result["OWEMONTHS"] * SUBSCRIPTION_AMOUNT_MONTHLY;
        return $result;
    }
   
    public function changePaymentDate($pay_date_last, $pay_date_next = NULL)
    {
        $this->pay_date_last = date("Y-m-d H:i:s", $pay_date_last);
        if (!isset($pay_date_next)){
            $todayDate = date("Y-m-d H:i:s", $pay_date_last);// current date
            // Add one month to today
            $pay_date_next = strtotime($todayDate . " +1 month");
        }
        
        $this->pay_date_next = date("Y-m-d H:i:s", $pay_date_next);
        
        return $this->save();
    }

    public function getLabelsIDs(){
        $userToLabel = new Default_Model_DbTable_UserToLabel();
        return $userToLabel->select()->where('userid = ?', $this->id);
    }

    public function hasRole($role)
    {

        if (($this->role & $role) > 0) {
            return true;
        }

        return false;
    }
    
    /**
     * Parse role assigned to the user
     *
     * @return array 
     */
    public function parseRoles()
    {
        $roles = array();
        if ($this->hasRole(self::ROLE_DJ)) {
            $roles[] = 'DJ';
        }
        if ($this->hasRole(self::ROLE_ARTIST)) {
            $roles[] = 'Artist';
        }
        if ($this->hasRole(self::ROLE_LABEL)) {
            $roles[] = 'Label';
        }
        if ($this->hasRole(self::ROLE_ADMIN)) {
            $roles[] = 'Admin';
        }

        return $roles;
    }
    
    /**
     * 
     * @return bool
     */
    public function isSubscriptionPaypal()
    {        
        return $this->pay_mode == self::PAY_MODE_PAYPAL;
    }
    
    /**
     * 
     * @return bool
     */
    public function isSubscriptionAuthorize()
    {        
        return $this->pay_mode == self::PAY_MODE_AUTHORIZE;
    }
    
    /**
     * Check if the user have ability to use site
     * 
     * @return int
     */
    public function checkAbilityToUseSite()
    {
        if ($this->hasRole(Default_Model_User::ROLE_DJ | Default_Model_User::ROLE_MEMBER)) {
            if ($this->allow_user) {
                return self::CAN_USE_SITE;
            } else {
                return self::SHOULD_SUBSCRIBE;
            }
            /*
            $lastPaymentDate = Default_Service_User::lastPaymentDate($this);
            if (is_null($lastPaymentDate)) {
                return self::SHOULD_SUBSCRIBE;
            }
            if (time() - strtotime($lastPaymentDate) > (86400 * 31)) {
                return self::SHOULD_BE_PROCEEDED_MANUALLY;
            } else {
                return self::SHOULD_SUBSCRIBE;
            }
        * 
        */
        }
        
        return self::CAN_USE_SITE;
    }
    
}
