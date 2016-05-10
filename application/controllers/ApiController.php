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
class ApiController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
            //$userId = 1;
            $userId = $this->_getParam('user_id', null);
            
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            $deductibleArr = $deductibleMapper->getCignaDeductible($userId);
            
            // cingna_claim
            $claimMapper = new Application_Model_CignaClaimMapper();
            $claimArr = $claimMapper->getCignaClaim($userId);

            // cingna_claim_details
            $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
            $claimDetailsArr = $claimDetailsMapper->getCignaClaimDetails($userId);

            // cingna_medical
            $medicalMapper = new Application_Model_CignaMedicalMapper();
            $medicalArr = $medicalMapper->getCignaMedical($userId);
            
//            echo '<pre>';
//            print_r($claimDetailsArr);
//            echo '</pre>';
            
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson($claimDetailsArr);
            
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