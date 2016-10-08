<?php
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
class ApiDentalController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
            $arr = array();
            
            //$userMapper = new Application_Model_UserMapper();
            //$userInfo = $userMapper->getUserArrForClient($userId);
            $userProviderMapper = new Application_Model_UserProviderMapper();
            $userInfo = $userProviderMapper->getUserProviderArrForClient($userId);
            
            if ($userInfo['dental']->provider_name == 'cigna') {
                $arr['benefit'] = array();
                $arr['claim'] = array();
            }
            
            if ($userInfo['dental']->provider_name == 'guardian') {
                $benefitMapper = new Application_Model_GuardianBenefitMapper();
                $arr['benefit'] = $benefitMapper->getGuardianBenefit($userId);

                // guardian_claim
                $claimMapper = new Application_Model_GuardianClaimMapper();
                $arr['claim'] = $claimMapper->getGuardianClaim($userId);
            }

//            echo '<pre>';
//            print_r($arr);
//            echo '</pre>';
//            die();
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson($arr);
            
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
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "POST - There is no such functionality at this moment");        
        exit;
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