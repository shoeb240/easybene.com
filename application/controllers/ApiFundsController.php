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
class ApiFundsController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
            
            $userProviderMapper = new Application_Model_UserProviderMapper();
            $userInfo = $userProviderMapper->getUserProviderArrForClient($userId);
            
            //echo $userId;
            if ($userInfo['funds']->provider_name == 'navia') {
                $statementsMapper = new Application_Model_NaviaStatementsMapper();
                $statements = $statementsMapper->getNaviaStatements($userId);
                //print_r($statements);
                $arr['HS_balance'] = $statements['HS_balance'];

                $hsMapper = new Application_Model_NaviaHealthSavingsMapper();
                $hs = $hsMapper->getNaviaHealthSavings($userId);
                $arr['portfolio_balance'] = $hs[0]['portfolio_balance'];
                $arr['transaction_activity'] = $hs;
            }

            /*echo '<pre>';
            print_r($hs);
            echo '</pre>';
            die();*/
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