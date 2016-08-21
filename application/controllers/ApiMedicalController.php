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
class ApiMedicalController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
            
            $userMapper = new Application_Model_UserMapper();
            $userInfo = $userMapper->getUserArrForClient($userId);
            
            if ($userInfo['medical_site'] == 'Cigna') {
                $deductibleMapper = new Application_Model_CignaDeductibleMapper();
                $arr['deductible'] = $deductibleMapper->getCignaDeductible($userId);

                $deductibleAmt = str_replace(array('$', ','), '', $arr['deductible']['deductible_amt']);
                $deductibleMet = str_replace(array('$', ','), '', $arr['deductible']['deductible_met']);
                $arr['cigna_deductible_met'] = $arr['deductible']['deductible_met'];
                $arr['cigna_deductible_percent'] = round($deductibleMet / $deductibleAmt * 100);

                $outOfPocketAmt = str_replace(array('$', ','), '', $arr['deductible']['out_of_pocket_amt']);
                $outOfPocketMet = str_replace(array('$', ','), '', $arr['deductible']['out_of_pocket_met']);
                $arr['cigna_out_of_pocket_met'] = $arr['deductible']['out_of_pocket_met'];
                $arr['cigna_out_of_pocket_percent'] = round($outOfPocketMet / $outOfPocketAmt * 100);

                // cingna_claim
                /*$claimMapper = new Application_Model_CignaClaimMapper();
                $arr['claim'] = $claimMapper->getCignaClaim($userId);*/

                // cingna_claim_details
                $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
                $arr['claim_details'] = $claimDetailsMapper->getCignaClaimDetails($userId);

                // cingna_medical
                $medicalMapper = new Application_Model_CignaMedicalMapper();
                $arr['medical_summary'] = $medicalMapper->getCignaMedical($userId);
            }
            
            if ($userInfo['medical_site'] == 'Guardian') {
                $arr['cigna_deductible_met'] = '';
                $arr['cigna_deductible_percent'] = '';
                
                $arr['cigna_out_of_pocket_met'] = '';
                $arr['cigna_out_of_pocket_percent'] = '';
                
                $arr['claim'] = array();
                
            }
            
            if ($userInfo['medical_site'] == 'Anthem') {
                // cingna_claim_details
                $claimDetailsMapper = new Application_Model_AnthemClaimOverviewMapper();
                $arr['claim_details'] = $claimDetailsMapper->getAnthemClaim($userId);

                // cingna_medical
                $medicalMapper = new Application_Model_AnthemMapper();
                $arr['anthem'] = $medicalMapper->getAnthem($userId);
                
                $deductibleAmt = str_replace(array('$', ','), '', $arr['anthem']['CD_deductible_in_net_family_limit']);
                $deductibleMet = str_replace(array('$', ','), '', $arr['anthem']['CD_deductible_in_net_family_accumulate']);
                $arr['CD_deductible_in_net_family_accumulate'] = $arr['anthem']['CD_deductible_in_net_family_accumulate'];
                $arr['deductible_percent'] = round($deductibleMet / $deductibleAmt * 100);

                $outOfPocketAmt = str_replace(array('$', ','), '', $arr['anthem']['CD_out_pocket_in_net_family_limit']);
                $outOfPocketMet = str_replace(array('$', ','), '', $arr['anthem']['CD_out_pocket_in_net_family_accumulate']);
                $arr['CD_out_pocket_in_net_family_accumulate'] = $arr['anthem']['CD_out_pocket_in_net_family_accumulate'];
                $arr['out_of_pocket_percent'] = round($outOfPocketMet / $outOfPocketAmt * 100);
                
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