<?php
error_reporting(9);
/**
 * All account management actions
 * 
 * @category   Application
 * @package    Application_Controller
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @uses       Zend_Controller_Action
 * @version    1.0
 */
class ApiUserController extends My_Controller_ApiAbstract //Zend_Controller_Action
{
    /**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        // Disable layout and stop view rendering
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function indexAction()
    {
        try{
            $userId = $this->_getParam('user_id', null);
            
            $userMapper = new Application_Model_UserMapper();
            $userInfo = $userMapper->getUserArrForClient($userId);
            
            $userProviderMapper = new Application_Model_UserProviderMapper();
            $userInfo['providersSelected'] = $userProviderMapper->getUserProviderArrForClient($userId);
            
            $providerMapper = new Application_Model_ProviderListMapper();
            $userInfo['providerList'] = $providerMapper->getProviderList();
            
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson($userInfo);
            
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    public function getAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "GET - There is no such functionality at this moment");
        exit;
    }

    public function postAction()
    {
        //$this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "POST - There is no such functionality at this moment");        
        //exit;
        try{
            $userId = $this->_getParam('user_id', null);
            $siteName = $this->_getParam('site_name', null);
            $siteType = $this->_getParam('site_type', null);
            $siteUserId = $this->_getParam('site_user_id', null);
            $sitePassword = $this->_getParam('site_password', null);

            $userProviderMapper = new Application_Model_UserProviderMapper();
            $providerInfo = $userProviderMapper->updateSiteCredentials($userId, $siteName, $siteType, $siteUserId, $sitePassword);
            
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson($providerInfo);
            
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
    }

    public function putAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "PUT - There is no such functionality at this moment");
        exit;
    }

    public function deleteAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "DELETE - There is no such functionality at this moment");
        exit;
    }
    
    
    
    
    
}