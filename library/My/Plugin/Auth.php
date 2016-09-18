<?php

class My_Plugin_Auth
    extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
            $response = Zend_Controller_Front::getInstance()->getResponse();

            // RestFul Api
            if (stripos($request->getControllerName(), 'scrape') === false) {
                if ($request->isDelete()) {
                    $method = 'delete';
                } else if ($request->isGet()) {
                    //$method = 'post'; // for testing auth
                    $method = 'get'; // for api
                } else if ($request->isPost()) {
                    $method = 'post';
                } else if ($request->isPut()) {
                    $method = 'put';
                }
                
                switch ($method) {
                    // DELETE
                    case 'delete':
                        $id = $request->id;
                        if ($id) {
                            $request->setActionName('delete');
                            break;
                        }
                        $request->setActionName('deleteList');
                        break;
                    // GET
                    case 'get':
                        $id = $request->getParam('id', null);
                        if ($id) {
                            $request->setActionName('get');
                            break;
                        }
                        $request->setActionName('index');
                        break;
                    // HEAD
                    case 'head':
                        $id = $request->id;
                        if (!$id) {
                            $id = null;
                        }
                        $request->setActionName('head');
                        break;
                    // POST
                    case 'post':
                        $request->setActionName('post');
                        break;
                    // PUT
                    case 'put':
                        $id   = $request->id;
                        $data = $request->getParams();

                        if ($id) {
                            $request->setActionName('put');
                            break;
                        }

                        break;
                    // All others...
                    default:
                        $request->setActionName('index');
                        return $response;
                }
        
        
        
            }
            
                /*if ($request->username && $request->password ) { //&& $request->isPost()
                    //$request->setModuleName('index');
                    $request->setControllerName('auth');
                    $request->setActionName('post');
                    $request->setParams(array(
                        'username' => $request->username,
                        'password' => $request->password
                    ));

                } else */
            
            // Token authentication
            if (stripos($request->getControllerName(), 'api') !== false ||
                    (stripos($request->getControllerName(), 'scrape') !== false && empty($request->user_id))) {
                if ($request->username && $request->token) {
                    $userTable = new Application_Model_DbTable_User();
                    $adapter = new Zend_Auth_Adapter_DbTable($userTable->getAdapter());

                    $adapter
                        ->setTableName($userTable->info('name'))
                        ->setIdentityColumn('username')
                        ->setCredentialColumn('api_token')
                        ->setIdentity($request->username)
                        ->setCredential($request->token);

                    $storage = new Zend_Auth_Storage_NonPersistent;
                    Zend_Auth::getInstance()->setStorage($storage);

                    assert($request instanceof Zend_Controller_Request_Http);
                    assert($response instanceof Zend_Controller_Response_Http);

                    $result = Zend_Auth::getInstance()->authenticate($adapter);

                    if (!$result->isValid()) {
                        //$request->setModuleName('api');
                        $request->setControllerName('error');
                        $request->setActionName('error');
                        $error = new stdClass();
                        $error->type = '';
                        $request->setParam('error_handler', $error);
                    } else {
                        $select = $userTable->select()->where('username = ?', $result->getIdentity());
                        $user = $userTable->fetchRow($select);
                        $maxTokenLife = strtotime('-' . My_Controller_ApiAbstract::API_TOKEN_LIFE_TIME . ' seconds');

                        if (strtotime($user->api_updated) < $maxTokenLife) {
                            //$request->setModuleName('api');
                            $request->setControllerName('error');
                            $request->setActionName('error');
                            $error = new stdClass();
                            $error->type = My_Controller_ApiAbstract::ERROR_EXPIRED;
                            $request->setParam('error_handler', $error);
                        }
                        if (!$user) {
                            throw new Exception("User data not in system. Please check your username and password.");
                        }
                        Zend_Auth::getInstance()->getStorage()->write($user);
                        $request->setParam('user_id', $user->user_id);
                    }
                } else {
                    //$request->setModuleName('api');
                    $request->setControllerName('error');
                    $request->setActionName('error');
                    $error = new stdClass();
                    $error->type = My_Controller_ApiAbstract::BAD_REQUEST;
                    $error->data = array('username' => $request->username, 'token' => $request->token, 'post' => $_POST);
                    $request->setParam('error_handler', $error);
                }

            } 
        }
        
        
}