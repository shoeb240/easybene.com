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
class ApiSummaryController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            $arr['cigna_deductible'] = $deductibleMapper->getCignaDeductible($userId);
            
            $deductibleAmt = str_replace(array('$', ','), '', $arr['cigna_deductible']['deductible_amt']);
            $deductibleMet = str_replace(array('$', ','), '', $arr['cigna_deductible']['deductible_met']);
            $arr['cigna_percent'] = round($deductibleMet / $deductibleAmt * 100);
            
            // guardian_claim
            $claimMapper = new Application_Model_GuardianClaimMapper();
            $arr['guardian_claim'] = $claimMapper->getGuardianClaim($userId);
            
            $count = count($arr['guardian_claim']);
            $submittedCharges = 0;
            $amountPaid = 0;
            for($i=0; $i < $count; $i++) {
                $submittedCharges += $arr['guardian_claim']['submitted_charges'];
                $amountPaid += $arr['guardian_claim']['amount_paid'];
            }
            $arr['guardian_percent'] = round(1 - ($amountPaid / $submittedCharges));
            
//            echo '<pre>';
//            print_r($arr['guardian_claim']);
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