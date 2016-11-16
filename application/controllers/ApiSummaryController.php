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
            
            //$userMapper = new Application_Model_UserMapper();
            //$userInfo = $userMapper->getUserArrForClient($userId);
            $userProviderMapper = new Application_Model_UserProviderMapper();
            $userInfo = $userProviderMapper->getUserProviderArrForClient($userId);
            
            $arr = array();
            $result['medical_percent'] = '';
            $result['medical_deductible'] = '';
            $result['medical_deductible_met'] = '';
            $result['medical_data_exists'] = '';
            $result['dental_percent'] = '';
            $result['dental_deductible'] = '';
            $result['dental_deductible_met'] = '';
            $result['dental_data_exists'] = '';
            $result['vision_percent'] = '';
            $result['vision_deductible'] = '';
            $result['vision_deductible_met'] = '';
            $result['vision_data_exists'] = '';
            
            // MEDICAL
            if ($userInfo['medical']->provider_name == 'cigna') {
                
                $deductibleMapper = new Application_Model_CignaDeductibleMapper();
                $cignaDeductible = $deductibleMapper->getCignaDeductible($userId);
                
                $result['medical_deductible'] = str_replace(array('$', ','), '', $cignaDeductible['deductible_amt']);
                $result['medical_deductible_met'] = str_replace(array('$', ','), '', $cignaDeductible['deductible_met']);
                $result['medical_percent'] = round($result['medical_deductible_met'] / $result['medical_deductible'] * 100);
                $result['medical_data_exists'] = !empty($cignaDeductible['user_id']) ? 'yes' : '';
                
            } else if ($userInfo['medical']->provider_name == 'guardian') {
                
            } else if ($userInfo['medical']->provider_name == 'anthem') {
                
                // cingna_medical
                $medicalMapper = new Application_Model_AnthemMapper();
                $anthemDeductible = $medicalMapper->getAnthem($userId);
                
                $result['medical_deductible'] = str_replace(array('$', ','), '', $anthemDeductible['CD_deductible_in_net_family_limit']);
                $result['medical_deductible_met'] = str_replace(array('$', ','), '', $anthemDeductible['CD_deductible_in_net_family_accumulate']);
                $result['medical_percent'] = round($result['medical_deductible_met'] / $result['medical_deductible'] * 100);
                $result['medical_data_exists'] = !empty($anthemDeductible['user_id']) ? 'yes' : '';
            }
            
            
            //DENTAL
            if ($userInfo['dental']->provider_name == 'cigna') {
                
            } else if ($userInfo['dental']->provider_name == 'guardian') {
                
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
                
                $result['dental_deductible'] = $submittedCharges;
                $result['dental_deductible_met'] = $amountPaid;
                $result['dental_percent'] = round((($amountPaid / $submittedCharges))*100);
                $result['dental_data_exists'] = !empty($guardianClaim[0]['user_id']) ? 'yes' : '';
                
            } else if ($userInfo['dental']->provider_name == 'anthem') {
                
            }
            
            // VISION
            if ($userInfo['vision']->provider_name == 'cigna') {
                
            } else if ($userInfo['vision']->provider_name == 'guardian') {
                
            } else if ($userInfo['vision']->provider_name == 'anthem') {
                
            }
            
            // FUNDS
            if ($userInfo['funds']->provider_name == 'navia') {
                
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
        $responseFailedIds = $this->_getParam('response_failed_ids', null);
        
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        $ok = $userProviderExeMapper->updateFailed($responseFailedIds);
        
        echo json_encode(array('response' => $ok));
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