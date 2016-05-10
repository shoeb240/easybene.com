<?php
//error_reporting(9);
class AuthController extends My_Controller_ApiAbstract
{
    public function init()
    {
        parent::init();
        // Disable layout and stop view rendering
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "INDEX - There is no such functionality at this moment");
        exit();
    }

    public function getAction()
    {
        $id = $this->getRequest()->getParam('id');
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "GET - There is no such functionality at this moment");
        exit();
    }

    public function postAction()
    {
        try {
            $username = $this->_getParam('username', null);
            $password = $this->_getParam('password', null);
            $act = $this->_getParam('act', null);
            $cigna_exists = null;
            if ($username && $password) {
                if ($act == 'login') {
                    $user = $this->_auth($username, $password);
                    $exp = strtotime($user->api_updated) + My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME;
                    $token = $user->api_token;
                    if (!empty($user->cigna_user_id) && !empty($user->cigna_password)) {
                        $cigna_exists = 'yes';
                    } else {
                        $cigna_exists = 'no';
                    }
                } else if ($act == 'register') {
                    $data = $this->_register($username, $password);
                    $exp = strtotime($data['api_updated']) + My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME;
                    $token = $data['api_token'];
                } else {
                    $this->_error(My_Controller_ApiAbstract::ERROR_DENIED);
                    exit;
                }
            } /*elseif ($token) {
                $user = $this->_checkAuth($token);
            }*/ else {
                $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "Trying to access without credentials");
            }
            
            $code = My_Controller_ApiAbstract::RESPONSE_CREATED;
            $result = array('token' => $token,
                            'token_expire' => $exp,
                            'cigna_exists' => $cigna_exists);
            
            $this->getResponse()->setHttpResponseCode($code);
            $this->getHelper('json')->sendJson($result);

        } catch (Zend_Controller_Exception $e) {
            $code = My_Controller_ApiAbstract::ERROR_INTERNAL;
            $result = array(
                'messages' => $e->getMessage()
            );
            $this->getResponse()
                ->setHttpResponseCode($code)
                ->appendBody(Zend_Json::encode($result));
        }
    }

    public function putAction()
    {
        $id = $this->getRequest()->getParam('id');
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "PUT - There is no such functionality at this moment");
        exit();
    }

    public function deleteAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "DELETE - There is no such functionality at this moment");
        exit();
        
        /*$username = $this->_getParam('username', null);
        $token = $this->_getParam('token', null);

        $userTable = new Application_Model_DbTable_User();
        $select = $userTable->select()
            ->where('login = ?', $username)
            ->where('api_token = ?', $token);
        $user = $userTable->fetchRow($select);
        if ($user) {
            $user->api_token = null;
            $user->api_updated = null;
            $result = $user->save();

            if ($result) {
                Zend_Auth::getInstance()->clearIdentity();
                $result = array(
                    'message' => 'Successful logout'
                );
                $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
                $this->getHelper('json')->sendJson($result);
            }
        } else {
            $result = array(
                'message' => 'Anauthorized action'
            );
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::ERROR_DENIED);
            $this->getHelper('json')->sendJson($result);
        }*/
    }

    /**
     * Authorization
     *
     * @param <type> $username
     * @param <type> $password
     * @return Zend_Db_Table_Row_Abstract
     */
    protected function _auth($username, $password)
    {
        $userTable = new Application_Model_DbTable_User();

        $p_username = trim(substr($username, 0, 32));
        $p_password = trim(substr($password, 0, 32));
        $p_password = md5($p_password);
        
        try {
            $user = $userTable->fetchRow(
                array(
                    "username = ?" => $username,
                    "password = ?" => $p_password
                )
            );

            if (empty($user)) {
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED);
                exit;
            } else {
                $token = $this->_generateToken();
                $user->api_token = $token;
                $user->api_updated = date('Y-m-d H:i:s');
                $user->save();

                return $user;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    /**
     * Authorization
     *
     * @param <type> $username
     * @param <type> $password
     * @return Zend_Db_Table_Row_Abstract
     */
    protected function _register($username, $password)
    {
        $userTable = new Application_Model_DbTable_User();

        $p_username = trim(substr($username, 0, 32));
        $p_password = trim(substr($password, 0, 32));

        try {
            $userExists = $userTable->fetchRow(
                array(
                    "username = ?" => $username,
                    "password = ?" => $p_password
                )
            );

            if (empty($userExists)) {
                $token = $this->_generateToken();
                
                $user = new Application_Model_User();
                $user->setUsername($username);
                $user->setPassword($p_password);
                $user->setApiToken($token);
                $user->setApiUpdated(date('Y-m-d H:i:s'));

                
                $userMapper = new Application_Model_UserMapper();
                $data = $userMapper->saveUser($user);
                
                return $data;
            } else {
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED);
                exit;
            }
        } catch(Exception $e) {
            //echo $e->getMessage();
            $this->_error(My_Controller_ApiAbstract::ERROR_DENIED);
            exit;
        }
    }

    /**
     * Check if user is authentificated by token
     * If it is true - regenerate token and store it to the database
     *
     * @param string $token
     * @return Default_Model_User
     */
    /*protected function _checkAuth($token)
    {
        $userTable = new Application_Model_DbTable_User();
        $user = $userTable->fetchRow(
            array(
                "api_token = ?" => $token
            )
        );

        if (empty($user)) {
            $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, "Token unrecognized");
        } else if (strtotime($user->api_updated) < (time() - My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME)) {
            $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, "Token has espired");
        } else {
            try {
                $token = $this->_generateToken();
                $user->api_token = $token;
                $user->api_updated = date('Y-m-d H:i:s');
                $user->save();
            } catch(Exception $e) {
                echo $e->getMessage();
            }
            return $user;
        }
    }*/

    /**
     * Generate token
     *
     * @return string
     */
    protected function _generateToken()
    {
        return md5(base64_encode(date('miHYsd') . chr(rand(34, 63)) . microtime()));
    }

}

