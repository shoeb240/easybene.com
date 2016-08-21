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
            
            $userMapper = new Application_Model_UserMapper();
            $userInfo = $userMapper->getUserArrForClient($userId);
            
            $arr = array();
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            $cignaDeductible = $deductibleMapper->getCignaDeductible($userId);
            
            $deductibleAmt = str_replace(array('$', ','), '', $cignaDeductible['deductible_amt']);
            $deductibleMet = str_replace(array('$', ','), '', $cignaDeductible['deductible_met']);
            $cignaPercent = round($deductibleMet / $deductibleAmt * 100);
            
            // guardian_claim
            $claimMapper = new Application_Model_GuardianClaimMapper();
            $guardianClaim = $claimMapper->getGuardianClaim($userId);
            
            $count = count($guardianClaim);
            $submittedCharges = 0;
            $amountPaid = 0;
            for($i=0; $i < $count; $i++) {
                $submittedCharges += str_replace(array('$', ','), '', $guardianClaim[$i]['submitted_charges']);
                $amountPaid += str_replace(array('$', ','), '', $guardianClaim[$i]['amount_paid']);;
            }
            $guardianPercent = round((($amountPaid / $submittedCharges))*100);
            
            
            //$result['medical_site'] = $userInfo['medical_site'];
            //$result['dental_site'] = $userInfo['dental_site'];
            //$result['vision_site'] = $userInfo['vision_site'];
            
            if ($userInfo['medical_site'] == 'Cigna') {
                $result['medical_percent'] = $cignaPercent;
            }
            if ($userInfo['medical_site'] == 'Guardian') {
                $result['medical_percent'] = '';//$guardianPercent;
            }
            if ($userInfo['dental_site'] == 'Cigna') {
                $result['dental_percent'] = '';//$cignaPercent;
            }
            if ($userInfo['dental_site'] == 'Guardian') {
                $result['dental_percent'] = $guardianPercent;
            }
            
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson($result);
            
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