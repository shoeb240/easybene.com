<?php
error_reporting(9);
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
            $token = null;
            $exp = null;
            $recovery_code = $this->_getParam('code', null);
            
            if ($username && $password) {
                if ($act == 'login') {
                    $user = $this->_auth($username, $password);
                    $exp = strtotime($user->api_updated) + My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME;
                    $token = $user->api_token;
                    
                    $userProviderMapper = new Application_Model_UserProviderMapper();
                    $providersSelected = $userProviderMapper->getUserProviderArrForClient($user->user_id);
                    $result['medical_site'] = isset($providersSelected['medical']->provider_name) ? $providersSelected['medical']->provider_name : '';
                    $result['dental_site'] = isset($providersSelected['dental']->provider_name) ? $providersSelected['dental']->provider_name : '';
                    $result['vision_site'] = isset($providersSelected['vision']->provider_name) ? $providersSelected['vision']->provider_name : '';
                    $result['funds_site'] = isset($providersSelected['funds']->provider_name) ? $providersSelected['funds']->provider_name : '';
                } else if ($act == 'register') {
                    $data = $this->_register($username, $password);
                    $exp = strtotime($data['api_updated']) + My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME;
                    $token = $data['api_token'];
                } else {
                    $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'Invalid action');
                    exit;
                }
            } elseif ($username && $act == 'forgetpass') {
                $this->_forgetpass($username);
            } elseif ($recovery_code && $act == 'checkcode') {
                $this->_checkcode($recovery_code);
            } else if ($recovery_code && $password && $act == 'setpass') {
                    $data = $this->_setpass($password, $recovery_code);
                    $exp = strtotime($data['api_updated']) + My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME;
                    $token = $data['api_token'];
            } 
            
            /*elseif ($token) {
                $user = $this->_checkAuth($token);
            }*/ else {
                $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "Trying to access without credentials");
            }
            
            $code = My_Controller_ApiAbstract::RESPONSE_CREATED;
            $result['token'] = $token;
            $result['token_expire'] = $exp;
            
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
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'User does not exist');
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
                    "password = ?" => md5($p_password)
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
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'This username already exists');
                exit;
            }
        } catch(Exception $e) {
            $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'Registration failed.'); // $e->getMessage()
            exit;
        }
    }
    
    
    protected function _forgetpass($username)
    {
        $userTable = new Application_Model_DbTable_User();

        $p_username = trim(substr($username, 0, 32));
        
        try {
            $user = $userTable->fetchRow(
                array(
                    "username = ?" => $p_username,
                )
            );

            if (empty($user)) {
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'User does not exist');
                exit;
            } else {
                $recovery_code = substr($this->_generateToken(), 1, 6);//md5(substr($p_username, 2, 5).time());
                $this->send_email($p_username, $recovery_code);
                
                $user->code = md5($recovery_code);
                $user->save();

                return $user;
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    protected function _checkcode($code)
    {
        $userTable = new Application_Model_DbTable_User();

        try {
            $user = $userTable->fetchRow(
                array(
                    "code = ?" => md5($code),
                )
            );

            if (empty($user)) {
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'Code does not match');
                exit;
            }
            
            return true;
            
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    protected function _setpass($password, $code)
    {
        $userTable = new Application_Model_DbTable_User();

        $p_password = trim(substr($password, 0, 32));
        
        try {
            $user = $userTable->fetchRow(
                array(
                    "code = ?" => md5($code)
                )
            );

            if (!empty($user)) {
                $user->password = md5($p_password);
                $user->code = '';
                $user->save();
                
                return $user;
            } else {
                $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'Failed to reset password');
                exit;
            }
        } catch(Exception $e) {
            $this->_error(My_Controller_ApiAbstract::ERROR_DENIED, 'Password reset failed.' . $e->getMessage()); // $e->getMessage()
            exit;
        }
    }
    
    protected function send_email($email, $code)
    {
        try {
            $mail = new Zend_Mail();
            $mail->setBodyHtml($this->get_html_body($code));
            $mail->setBodyText('Recovery Code: ' . $code . '

or click on the link below

https://easybene.com/forgetpass.html?code=' . $code);
            $mail->setFrom('easybenehelp@gmail.com', 'EasyBene');
            $mail->addTo($email);
            $mail->setSubject('EasyBene Password Recovery');
            $mail->send();
            
        } catch(Exception $e) {
            echo $e->getMessage() . 'error';
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
    
    private function get_html_body($code)
    {
        
        $doc = <<<AAA

        <table align="center"  cellpadding="0" cellspacing="0" width="600"  style="border-collapse: collapse; ">
            <tr>
                <td bgcolor="#08598d" style="font-size: 0; line-height: 0;" height="5">&nbsp;</td>
            </tr>
            
            <tr>
                <td bgcolor="#10c6ed" style="color: #fff; font-size: 20px; line-height: 25px; text-align: center;font-family: Verdana,Arial, sans-serif, helvetica; " align="center" height="40">PASSWORD RECOVERY</td>
            </tr>
            
            <tr>
                <td bgcolor="#f6f4fa" style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
            </tr>
            
            <tr>
                <td align="center" bgcolor="#f6f4fa" >
                    <a href="http://www.easybene.com/"><img src="https://easybene.com/images/logo.png" alt="Easy bene" width="70" height="50" style="display: block;" border="0" /></a>
                </td>
            </tr>
            
            <tr>
                <td bgcolor="#f6f4fa"  style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
            </tr>

            <tr>
                <td bgcolor="#f6f4fa">
                    <table width="100%">
                        <tr>
                            <td width="2"></td>
                            <td width="92">
                                <table>
                                    <tr>
                                        <td style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">Thank you for requesting password recovery for access to your account.</td>
                                    </tr>
                                    
                                    <tr>
                                        <td  style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <table width="100%">
                                                <tr>
                                                    <td width="20"></td>
                                                    <td width="60" height="40"  align="left" bgcolor="#d5d8d8" >
                                                        <table width="100%">
                                                            <tr>
                                                                <td width="10%"></td>
                                                                <td width="40%" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 15px;"><b>Recovery Code:</b></td>
                                                                <td width="10%"></td>
                                                                <td width="40%" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 15px; color: #10c6ed; font-weight: bold;" >$code</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="20"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
									
									<tr>
                                        <td  style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">or click on the link below</td>
                                    </tr>
									
									<tr>
                                        <td  style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;" height="10"><a href="https://easybene.com/forgetpass.html?code=$code">https://easybene.com/forgetpass.html?code=$code</a></td>
                                    </tr>
                                    
                                    <tr>
                                        <td  style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td  style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">For personal information security reasons, please do not share your account ID or password with anyone. </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="30" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">Thank you for using our online solution! </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="30" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">Sincerely, </td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="30" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">Your EasyBene Team</td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="30" style="font-family: Verdana,Arial, sans-serif, helvetica; font-size: 13px;">
                                            Please Note: This is an automated message. Please do not reply to it.</td>
                                    </tr>
                                    
                                </table>
                            </td>
                            <td width="5"></td>
                        </tr>
                        
                    </table>
                </td>
            </tr>


            <tr>
                <td bgcolor="#10c6ed" style="font-size: 0; line-height: 0;" height="30">&nbsp;</td>
            </tr>
            
            <tr>
                <td bgcolor="#08598d" style="font-size: 0; line-height: 0;" height="5">&nbsp;</td>
            </tr>
            
        </table>
                    
                
AAA;

        return $doc;
    }

}

