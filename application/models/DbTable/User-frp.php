<?php

/**
 * User table class
 *
 * @author Dmitriy Britan <dmitriy.britan@nixsolutions.com>
 */
class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{
    protected $_name     = 'recordpool_users';

    protected $_primary  = 'id';

    protected $_rowClass = 'Application_Model_User';

    /**
     * User searching
     * 
     * The search consist of 2 steps:
     * - Search by username & mail
     * - Search by creditcard information (if user subscribe over Autorize.net)
     * 
     * @author Taras Omelianenko <t.omelianenko@nixsolutions.com>
     * @param string $username
     * @param string $mail
     * @param string $cc_firstname
     * @param string $cc_address
     * @param string $cc_state
     * @param string $cc_email
     * @return Default_Model_User|bool User info or false
     */
    public function search($username, $mail, $cc_firstname = null, $cc_address = null, $cc_state = null, $cc_email = null){
        
        
        // User search
        $select = $this->select()
                       ->from("recordpool_users", array("id", "status" => "allow_user"))
                       ->where("LOWER(login) = ?", strtolower($username))
                       ->where("LOWER(email) = ?", strtolower($mail));
        
        $user = $this->getAdapter()->fetchRow($select);
        
        //If user was not founded by name & mail try search by credit card information 
        if (!$user){
            $select = $this->getAdapter()
               ->select()
               ->distinct()
               ->from("recordpool_cardInfo AS c", array("id" => "loginuser_id"))
               ->joinInner("recordpool_users AS u", "u.id = c.loginuser_id", array("status" => "allow_user"))
               ->where("LOWER(c.first_name) = ?", strtolower($cc_firstname))
               ->where("LOWER(c.address) = ?", strtolower($cc_address))
               ->where("LOWER(c.state) = ?", strtolower($cc_state))
               ->orWhere("LOWER(c.email) = ?", strtolower($cc_email))
               ->orWhere("LOWER(u.email) = ?", strtolower($cc_email))
               ->where("c.loginuser_id <> 0")
               ->order("u.id DESC")
               ->limit(1);

            $user = $this->getAdapter()->fetchRow($select);
        }
        
        // Get full user data
        if ($user){
            $user = $this->find($user["id"])->current();
        }
        
        return $user;
    }
    
    /**
     * Three part user search for silent post
     * 
     * @author Taras Omelianenko <t.omelianenko@nixsolutions.com>
     * @param type $email
     * @param type $firstname
     * @param type $lastname
     * @param type $address
     * @param type $state
     * @param type $phone
     * 
     * @return Default_Model_User|bool User info or false
     */
    public function searchAuthorize($email, $firstname, $lastname, $address, $state, $phone){
                          
            $select = $this->getAdapter()
                           ->select()
                           ->distinct()
                           ->from("recordpool_cardInfo AS c", array("id" => "loginuser_id"))
                           ->joinInner("recordpool_users AS u", "u.id = c.loginuser_id", array("status" => "allow_user"))
                           ->where("LOWER(c.first_name) = ?", strtolower($firstname))
                           ->where("LOWER(c.last_name) = ?", strtolower($lastname))
                           ->where("LOWER(c.address) = ?", strtolower($address))
                           ->where("LOWER(c.state) = ?", strtolower($state))
                           ->orWhere("LOWER(c.email) = ?", strtolower($email))
                           ->orWhere("LOWER(u.email) = ?", strtolower($email))
                           ->orWhere("REPLACE(REPLACE(REPLACE(c.phone,'(',''),')',''),'-','') = ?", str_replace("-","",str_replace(")","",str_replace("(","",$phone))))
                           ->where("c.loginuser_id <> 0")
                           ->order("u.id DESC")
                           ->limit(1);

            $user = $this->getAdapter()->fetchRow($select);
        
        // Get full user data
        if ($user){
            $user = $this->find($user["id"])->current();
        }
        
        return $user;
    }
    
    
    /**
     * User search for PayPal IPN
     * 
     * @param string $subscr_id 
     * @param tystringpe $payer_email
     * 
     * @return Default_Model_User 
     */
    public function searchPayPal($payer_email, $subscr_id = NULL, $userId = NULL)
    {

        $users = new Default_Model_DbTable_User();

        if (isset($userId)) {
            $user = $users->find($userId)->current();
            if (isset($user)) {
                return $user;
            }
        } else {
            $subscr_id = mysql_escape_string($subscr_id);
            $payer_email = mysql_escape_string($payer_email);

            $select = $users->select()
                    ->where("pay_mode = ?", Default_Model_User::PAY_MODE_PAYPAL);

            if (strlen($subscr_id) > 3) {
                $select->where("auth_sub_id = '{$subscr_id}' OR email = '{$payer_email}'");
            } else {
                $select->where("email = '{$payer_email}'");
            }


            $result = $users->fetchAll($select);

            if (count($result) == 1) {
                return $result->current();
            } else if (count($result) == 0) {
                throw new Frp_Exception("User wasn't find for this IPN", 500);
            } else {
                $num = count($result);
                throw new Frp_Exception("Was founded more {$num} users for this IPN", 500);
            }
        }
    }

    /**
     *
     * @return Zend_Db_Table_Select 
     */
    public function findAll()
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(
                array('ru' => $this->info('name')),
                array('*')
            );
        return $select;
    }
    
    /**
     *
     * @param array $filter
     * @return Zend_Db_Table_Select 
     */
    public function filter(array $filter = array())
    {
        $select = $this->findAllWithDj();
        if (!empty($filter['id'])) {
            $select->where('ru.id = ?', $filter['id']);
        }
        if (!empty($filter['login'])) {
            $select->where('ru.login LIKE ?', '%' . $filter['login'] . '%');
        }
        if (!empty($filter['name'])) {
            $select->where('ru.name LIKE ?', '%' . $filter['name'] . '%');
        }
        if (!empty($filter['email'])) {
            $select->where('ru.email LIKE ?', '%' . $filter['email'] . '%');
        }
        if (isset($filter['allow_user']) && $filter['allow_user'] > -1) {
            $select->where('ru.allow_user = ?', $filter['allow_user']);
        }
        if (isset($filter['role']) && $filter['role'] > 0) {
            $select->where('role & ?', $filter['role']);
        }
        if (!empty($filter['date_added'])) {
            $select->where('date_added = ?', $filter['date_added']);
        }
        if (!empty($filter['date_added_from'])) {
            $select->where('date_added >= ?', $filter['date_added_from']);
        }
        if (!empty($filter['date_added_to'])) {
            $select->where('date_added <= ?', $filter['date_added_to']);
        }
        
        return $select;
    }

    public function findAllAllowed()
    {
        $select = $this->findAll()
            ->where('ru.allow_user = ?', Default_Model_User::USER_ALLOW);
        return $select;
    }

    public function findAllAllowedAndSubscribed()
    {
        $select = $this->findAllAllowed()
            ->joinleft(
                array('rgn' => 'recordpool_geniuslist_notifications'),
                'ru.id = rgn.userid',
                array('rgn.sectionid', 'rgn.typeid')
            )
            ->where('rgn.sectionid = ?', GeniusList_Model_Notifications::SECTION_FRP)
            ->where('rgn.typeid = ?', GeniusList_Model_Notifications::TYPE_EMAIL);
        return $select;
    }

    public function getAllAllowed()
    {
        return $this->fetchAll($this->findAllAllowed());
    }

    public function getAllAllowedAndSubscribed()
    {
        return $this->fetchAll($this->findAllAllowedAndSubscribed());
    }

    public function findAllSubscribed()
    {
        $select = $this->findAll()
            ->joinInner(
                array('rgn' => 'recordpool_geniuslist_notifications'),
                'ru.id = rgn.userid',
                array()
            )
            ->joinLeft(
                array('rd' => 'recordpool_djs'),
                'ru.id = rd.userid',
                array('djname' => 'rd.name')
            )
            ->where('rgn.sectionid = ?', GeniusList_Model_Notifications::SECTION_REGION)
            ->where('rgn.typeid = ?', GeniusList_Model_Notifications::TYPE_EMAIL)
            ->where('ru.allow_user = ?', Default_Model_User::USER_ALLOW)
            ->group('ru.id');
        return $select;
    }

    public function findAllSubscribedByRegions()
    {
        $select = $this->findAllSubscribed()
            ->joinLeft(
                array('rstr' => 'recordpool_subscribe_to_map'),
                'ru.id = rstr.userid',
                array(
                    'regionIds' => new Zend_Db_Expr('GROUP_CONCAT(rstr.item_id)')
                )
            );
        //echo $select->__toString();exit;
        return $select;
    }

    public function getAllSubscribedByRegions()
    {
        return $this->fetchAll($this->findAllSubscribedByRegions());
    }

    public function findAllSubscribedByGenres()
    {
        $select = $this->findAllSubscribed()
            ->joinLeft(
                array('rstg' => 'recordpool_subscribe_to_genre'),
                'ru.id = rstg.userid',
                array(
                    'genreIds' => new Zend_Db_Expr('GROUP_CONCAT(rstg.genreid)')
                )
            );
        //echo $select->__toString();exit;
        return $select;
    }

    public function getAllSubscribedByGenres()
    {
        return $this->fetchAll($this->findAllSubscribedByGenres());
    }
    
    public function findAllAllowedWithDj()
    {
        $djTable = new Default_Model_DbTable_Dj();
        $select = $this->findAll()
            ->reset(Zend_Db_Select::COLUMNS)
            ->columns(array('ru.id', 'djAvatar' => 'ru.avatar', 'country', 'state'))
            ->join(
                array('rd' => $djTable->info(Zend_Db_Table::NAME)), "ru.id = rd.userid", 
                array('djname' => 'rd.name', 'djid' => 'rd.id')
            )
            ->joinLeft(
                array('countries' => 'recordpool_countries'), 'ru.country_id = countries.id',
                array('countries.code3')
            )
            ->joinLeft(
                array('regions' => 'recordpool_regions'), 'ru.region_id = regions.id AND ru.country_id = regions.country_id',
                array('countries.code3', 'region_code' => 'regions.code')
            )
            ->where('ru.allow_user = ?', Default_Model_User::USER_ALLOW);
        
        return $select;
    }
    
    /**
     * 
     * @return Zend_Db_Table_Select
     */
    public function findAllWithDj()
    {
        $djTable = new Default_Model_DbTable_Dj();
        $select = $this->findAll()
            ->joinLeft(
                array('rd' => $djTable->info(Zend_Db_Table::NAME)), "ru.id = rd.userid", 
                array('djname' => 'rd.name')
            );
        //fb($select->__toString());
        return $select;
    }
    
    /**
     *
     * @param int $userid
     * @return Zend_Db_Table_Select 
     */
    public function findAllAllowedWithDjById($userid)
    {
        $select = $this->findAllWithDjById($userid)
            ->where('ru.allow_user = ?', Default_Model_User::USER_ALLOW);
        return $select;
    }
    
    /**
     *
     * @param int $userid
     * @return Zend_Db_Table_Select 
     */
    public function findAllWithDjById($userid)
    {
        $select = $this->findAllWithDj()
            ->where('ru.id = ?', $userid);
        //fb($select->__toString());
        return $select;
    }

    public function getRelations($userid){
        $select = $this->getAdapter()
            ->select()
            ->from(array('u' => 'recordpool_users'), array('id'))
            ->joinLeft(array('u2l' => 'recordpool_users_to_labels'), 'u2l.userid = u.id', 'u2l.labelid')
            ->joinLeft(array('l' => 'recordpool_labels'), 'l.id = u2l.labelid', array('label_name' => 'l.name'))
            ->joinLeft(array('djs' => 'recordpool_djs'), 'djs.userid = u.id', array('dj_id' => 'djs.id', 'dj_name' => 'djs.name'))
            ->where('u.id = ?', $userid);

        $userRelations = $this->getAdapter()->fetchAll($select);

            foreach ($userRelations as $relation){
                if (isset($relation['dj_id'])){
                    $relations['dj'] = array('id' => $relation['dj_id'], 'name' => $relation['dj_name'], 'value' => $relation['dj_id'] . ":" . $relation['dj_name']);
                }

                if (isset($relation['labelid'])){
                    $relations['labels'] = array('id' => $relation['labelid'], 'name' => $relation['label_name'], 'value' => $relation['labelid'] . ":" . $relation['label_name']);
                }
            }

        return $relations;
    }
}
