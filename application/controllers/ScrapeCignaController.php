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
class ScrapeCignaController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://api.dexi.io/";
    
    private $cronKey = 'aG$s6&*H';
    
    private $ret_res = true;
    
    private $ret_failed = array();
    
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
        
        //header('Access-Control-Allow-Origin: *'); 
    }
    
    private function myExecutionResult($executionId, $headerArray) 
    {
        $url = $this->apiEndPoint . "executions/{$executionId}/result";
        //echo $url;
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
        $result = curl_exec($ch);

        return $result;
    }

    private function myRunWithInput($data_string, $headerArray, $runId) 
    {
        $url = $this->apiEndPoint . "/runs/" . $runId . "/execute/inputs";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
        $result = curl_exec($ch);

        return $result;
    }

    private function getHeaderArr()
    {
        return array(                                                                          
                'X-CloudScrape-Access: ' . md5($this->accountId . $this->apiKey),
                'X-CloudScrape-Account: ' . $this->accountId,
                'Accept: application/json',
                'Content-Type: application/json', 
                'Access-Control-Allow-Origin: *'
        );
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        // Get user info
        //$userMapper = new Application_Model_UserMapper();
        $userProviderMapper = new Application_Model_UserProviderMapper();
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        
        $userId = $this->_getParam('user_id', null);
        $providerId = $this->_getParam('id', null);
        
        $usersAll = array();
        if (is_numeric($userId) && is_numeric($providerId)) {
            //$usersAll = $userMapper->getUserById($userId);
            $usersAll = $userProviderMapper->getUserProvider($providerId, $userId);
        } else if ($this->cronKey === $userId) {
            //$usersAll = $userMapper->getUserAll();
            $usersAll = $userProviderMapper->getAllUserProviders('cigna', 'medical');
        }
        
        $this->ret_res = true;
        foreach($usersAll as $k => $userObj) {
            $data['user_id'] = $userObj->provider_user_id;
            $data['password'] = $userObj->provider_password;
            $userProviderTableId = $userObj->id;
            if (empty($data['user_id']) || empty($data['password'])) continue;
            
            for($i = 0; $i < 3; $i++) {
                switch($i) {
                    case 0:
                        $runId = '6e1a629d-815b-4f5c-ae98-7145dd8ea815';
                        $exeFieldName = 'cigna_medical_exeid';
                        break;
                    case 1:
                        $runId = 'ca7fefc4-baf2-46cd-80b3-80433b488c00';
                        $exeFieldName = 'cigna_deductible_claim_exeid';
                        break;
                    case 2:
                        $data['view_claims_for'] = 'ALL';
                        $data['date_range'] = 'js-this-year';
                        $runId = '0758a9a6-647a-42ad-9ec3-4b64fd6cddfb';
                        $exeFieldName = 'cigna_claim_details_exeid';
                        break;
                }
                $data_string = json_encode($data);                                                                                   
                $headerArray = $this->getHeaderArr();
                try {
                    $result = $this->myRunWithInput($data_string, $headerArray, $runId);
                } catch (Exception $e) {
                    //echo $e->getMessage();
                    //die('catch');
                    $this->ret_res = false;
                }
                
                $arr = json_decode($result, true);
                $exeId = $arr['_id'];
                
                $userProviderExeMapper->updateSiteCredentials($userProviderTableId, $exeFieldName, $exeId);
                //echo $userObj->provider_user_id.', '.$exeId.', '.$exeFieldName.'==';
                
                if (empty($exeId)) {
                    $this->ret_res = false;
                }
            }
        }
        
        if ($this->ret_res) {
            echo json_encode(array('response' => true));
        } else {
            echo json_encode(array('response' => false));
        }
        
    }
    
    /**
     * Scrape default page action
     *
     * @return void
     */
    public function executeAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
       
        // Get user info
        //$userMapper = new Application_Model_UserMapper();
        //$userProviderMapper = new Application_Model_UserProviderMapper();
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        
        $userId = $this->_getParam('user_id', null);
        $userProviderTableId = $this->_getParam('id', null);
        
        $usersAll = array();
        if (is_numeric($userProviderTableId) && is_numeric($userId)) {
            //$usersAll = $userMapper->getUserById($userId);
            $usersAll = $userProviderExeMapper->getUserProviderExe($userProviderTableId, $userId);
        } else if ($this->cronKey === $userId) {
            //$usersAll = $userMapper->getUserAll();
            $usersAll = $userProviderExeMapper->getAllUserProvidersExe('cigna', 'medical');
        }
        
        $this->ret_res = true;
        foreach($usersAll as $userId => $userObj) {
            $headerArray = $this->getHeaderArr();
            try {
                $resultCignaMedical = $this->myExecutionResult($userObj['cigna_medical_exeid']->exe_id, $headerArray);
                $arr['cigna_medical'] = json_decode($resultCignaMedical, true);
                $resultCignaMedicalDeductibleClaim = $this->myExecutionResult($userObj['cigna_deductible_claim_exeid']->exe_id, $headerArray);
                $arr['cigna_deductible_claim'] = json_decode($resultCignaMedicalDeductibleClaim, true);
                $resultCignaMedicalDetails = $this->myExecutionResult($userObj['cigna_claim_details_exeid']->exe_id, $headerArray);
                $arr['cigna_medical_details'] = json_decode($resultCignaMedicalDetails, true);
            } catch (Exception $e) {
                //echo $e->getMessage();
                //die('catch');
                $this->ret_res = false;
            }
            /*echo '<pre>';
            print_r($arr);
            echo '</pre>';*/
            //die('here');
            $this->storeScrape($userId, $arr);
        }
        
        if ($this->ret_res) {
            echo json_encode(array('response' => true));
        } else {
            echo json_encode(array('response' => false));
        }        
    }
    
    private function storeScrape($userId, $arr)
    {
        try{
            // cingna_deductible - ok
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            $deductibleMapper->deleteCignaDeductible($userId);
            
            foreach($arr['cigna_deductible_claim']['rows'] as $k => $eachRow) {
                $deductibleAmt = $eachRow[array_search('deductible_amt', $arr['cigna_deductible_claim']['headers'])];
                $deductibleMet = $eachRow[array_search('deductible_met', $arr['cigna_deductible_claim']['headers'])];
                $deductibleRemaining = $eachRow[array_search('deductible_remaining', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketAmt = $eachRow[array_search('out_of_pocket_amt', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketMet = $eachRow[array_search('out_of_pocket_met', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketRemaining = $eachRow[array_search('out_of_pocket_remaining', $arr['cigna_deductible_claim']['headers'])];

                if (!empty($deductibleAmt) || !empty($deductibleMet) || !empty($deductibleRemaining)) {
                    $deductible = new Application_Model_CignaDeductible;
                    $deductible->setUserId($userId);
                    $deductible->setDeductibleAmt($deductibleAmt);
                    $deductible->setDeductibleMet($deductibleMet);
                    $deductible->setDeductibleRemaining($deductibleRemaining);
                    $deductible->setOutOfPocketAmt($outOfPocketAmt);
                    $deductible->setOutOfPocketMet($outOfPocketMet);
                    $deductible->setOutOfPocketRemaining($outOfPocketRemaining);

                    //echo 'insert...<br/>';
                    $deductibleId = $deductibleMapper->saveCignaDeductible($deductible);
                }
                if (empty($deductibleId)) {
                    $this->ret_res = false;
                }
            }

//            echo '<pre>';
//            print_r($arr['cigna_deductible_claim']);
//            echo '</pre>';
            
            // cingna_claim
            /*$claimMapper = new Application_Model_CignaClaimMapper();
            $claimMapper->deleteCignaClaim($userId);
            
            foreach($arr['cigna_deductible_claim']['rows'] as $k => $eachRow) {
                $serviceDate = $eachRow[array_search('service_date', $arr['cigna_deductible_claim']['headers'])];
                $providedBy = $eachRow[array_search('provided_by', $arr['cigna_deductible_claim']['headers'])];
                $for = $eachRow[array_search('for', $arr['cigna_deductible_claim']['headers'])];
                $status = $eachRow[array_search('status', $arr['cigna_deductible_claim']['headers'])];
                $amountBilled = $eachRow[array_search('amount_billed', $arr['cigna_deductible_claim']['headers'])];
                $whatYourPlanPaid = $eachRow[array_search('what_your_plan_paid', $arr['cigna_deductible_claim']['headers'])];
                $myAccountPaid = $eachRow[array_search('my_account_paid', $arr['cigna_deductible_claim']['headers'])];
                $whatIOwe = $eachRow[array_search('what_i_owe', $arr['cigna_deductible_claim']['headers'])];
                //$claimNumber = $eachRow[array_search('claim_number', $arr['cigna_deductible_claim']['headers'])];

                $claim = new Application_Model_CignaClaim;
                $claim->setUserId($userId);
                $claim->setServiceDate($serviceDate);
                $claim->setProvidedBy($providedBy);
                $claim->setFor($for);
                $claim->setStatus($status);
                $claim->setAmountBilled($amountBilled);
                $claim->setWhatYourPlanPaid($whatYourPlanPaid);
                $claim->setMyAccountPaid($myAccountPaid);
                $claim->setWhatIOwe($whatIOwe);
                //$claim->setClaimNumber($claimNumber);

                echo 'insert...<br/>';
                $claimId = $claimMapper->saveCignaClaim($claim);
            }*/
            
            // cingna_claim_details - ok
            $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
            $claimDetailsId = $claimDetailsMapper->deleteCignaClaimDetails($userId);
            
            foreach($arr['cigna_medical_details']['rows'] as $k => $eachRow) {
                $claimNumber = $eachRow[array_search('claim_number', $arr['cigna_medical_details']['headers'])];
                $providedByDetails = $eachRow[array_search('provided_by_details', $arr['cigna_medical_details']['headers'])];
                $for = $eachRow[array_search('for', $arr['cigna_medical_details']['headers'])];
                $claimProcessedOn = $eachRow[array_search('claim_processed_on', $arr['cigna_medical_details']['headers'])];
                $serviceDateType = $eachRow[array_search('service_date_type', $arr['cigna_medical_details']['headers'])];
                $serviceAmountBilled = $eachRow[array_search('service_amount_billed', $arr['cigna_medical_details']['headers'])];
                $serviceDiscount = $eachRow[array_search('service_discount', $arr['cigna_medical_details']['headers'])];
                $serviceCoveredAmount = $eachRow[array_search('service_covered_amount', $arr['cigna_medical_details']['headers'])];
                $serviceCopayDeductible = $eachRow[array_search('service_copay_deductible', $arr['cigna_medical_details']['headers'])];
                $serviceWhatYourPlanPaid = $eachRow[array_search('service_what_your_plan_paid', $arr['cigna_medical_details']['headers'])];
                $serviceCoinsurance = $eachRow[array_search('service_coinsurance', $arr['cigna_medical_details']['headers'])];
                $serviceWhatIOwe = $eachRow[array_search('service_what_i_owe', $arr['cigna_medical_details']['headers'])];
                $serviceSeeNotes = $eachRow[array_search('service_see_notes', $arr['cigna_medical_details']['headers'])];

                if (!empty($claimNumber) || !empty($for)) {
                    $claimDetails = new Application_Model_CignaClaimDetails;
                    $claimDetails->setUserId($userId);
                    $claimDetails->setClaimNumber($claimNumber);
                    $claimDetails->setProvidedByDetails($providedByDetails);
                    $claimDetails->setFor($for);
                    $claimDetails->setClaimProcessedOn($claimProcessedOn);
                    $claimDetails->setServiceDateType($serviceDateType);
                    $claimDetails->setServiceAmountBilled($serviceAmountBilled);
                    $claimDetails->setServiceDiscount($serviceDiscount);
                    $claimDetails->setServiceCoveredAmount($serviceCoveredAmount);
                    $claimDetails->setServiceCopayDeductible($serviceCopayDeductible);
                    $claimDetails->setServiceWhatYourPlanPaid($serviceWhatYourPlanPaid);
                    $claimDetails->setServiceCoinsurance($serviceCoinsurance);
                    $claimDetails->setServiceWhatIOwe($serviceWhatIOwe);
                    $claimDetails->setServiceSeeNotes($serviceSeeNotes);

                    $claimDetailsId = $claimDetailsMapper->saveCignaClaimDetails($claimDetails);
                }
                if (empty($claimDetailsId)) {
                    $this->ret_res = false;
                }
                //echo 'insert...<br/>';
            }
            
            // cingna_medical - ok
            $medicalMapper = new Application_Model_CignaMedicalMapper();
            $medicalId = $medicalMapper->deleteCignaMedical($userId);
             
            foreach($arr['cigna_medical']['rows'] as $k => $eachRow) {
                $whosCovered = $eachRow[array_search('whos_covered', $arr['cigna_medical']['headers'])];
                $dateOfBirth = $eachRow[array_search('date_of_birth', $arr['cigna_medical']['headers'])];
                $relationship = $eachRow[array_search('relationship', $arr['cigna_medical']['headers'])];
                $coverageFrom = $eachRow[array_search('coverage_from', $arr['cigna_medical']['headers'])];
                $to = $eachRow[array_search('to', $arr['cigna_medical']['headers'])];
                $primaryCarePhysician = $eachRow[array_search('primary_care_physician', $arr['cigna_medical']['headers'])];

                if (!empty($whosCovered)) {
                    $medical = new Application_Model_CignaMedical;
                    $medical->setUserId($userId);
                    $medical->setWhosCovered($whosCovered);
                    $medical->setDateOfBirth($dateOfBirth);
                    $medical->setRelationship($relationship);
                    $medical->setCoverageFrom($coverageFrom);
                    $medical->setTo($to);
                    $medical->setPrimaryCarePhysician($primaryCarePhysician);

                    $medicalId = $medicalMapper->saveCignaMedical($medical);
                }
                if (empty($medicalId)) {
                    $this->ret_res = false;
                }
                //echo 'insert...<br/>';
            }
        } catch (Exception $ex) {
            //echo "Failed" . $ex->getMessage();
            $this->ret_res = false;
        }
        
    }
    
    
}