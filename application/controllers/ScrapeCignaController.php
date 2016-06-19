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
class ScrapeCignaController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://api.dexi.io/";
    
    private $cignaDeductibleUserAll;
    
    private $cignaClaimUserAll;
    
    private $cignaClaimDetailsUserAll;
    
    private $cignaMedicalUserAll;
    
    //private $runId = "5facd97f-895a-412c-951e-0f5cf27978c6";
    
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
        echo $url;
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
        $userMapper = new Application_Model_UserMapper();
        $usersAll = $userMapper->getUserAll();

        foreach($usersAll as $k => $userObj) {
            
            if ( $userObj->getUserId() != 84 ) continue; // remove
            
            $data['user_id'] = $userObj->getCignaUserId();
            $data['password'] = $userObj->getCignaPassword();
            if (empty($data['user_id']) || empty($data['password'])) continue;
            
            for($i = 0; $i < 3; $i++) {
                switch($i) {
                    case 0:
                        $runId = '6e1a629d-815b-4f5c-ae98-7145dd8ea815';
                        $exeFieldName = 'cigna_medical_exeid';
                        break;
                    case 1:
                        $data['view_claims_for'] = 'ALL';
                        $runId = '5cef5526-4008-46e1-a2c6-6a37a0d3d51b';
                        $exeFieldName = 'cigna_deductible_claim_exeid';
                        break;
                    case 2:
                        $data['view_claims_for'] = 'ALL';
                        $runId = 'e8494657-90f1-4651-89ea-53f117b4a90e';
                        $exeFieldName = 'cigna_claim_details_exeid';
                        break;
                }
                $data_string = json_encode($data);                                                                                   
                $headerArray = $this->getHeaderArr();
                try {
                    $result = $this->myRunWithInput($data_string, $headerArray, $runId);
                } catch (Exception $e) {
                    echo $e->getMessage();
                    die('catch');
                }
                $arr = json_decode($result, true);
                echo '<pre>';
                print_r($arr);
                echo '</pre>';
                $exeId = $arr['_id'];
                $userMapper = new Application_Model_UserMapper();
                $usersAll = $userMapper->updateExecutionId($userObj->getUserId(), $exeId, $exeFieldName);
            }
            break; // remove
            echo 'Done';
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
        $userMapper = new Application_Model_UserMapper();
        $usersAll = $userMapper->getUserAll();

        $deductibleMapper = new Application_Model_CignaDeductibleMapper();
        $this->cignaDeductibleUserAll = $deductibleMapper->getDeductibleUserAll();
        
        $claimMapper = new Application_Model_CignaClaimMapper();
        $this->cignaClaimUserAll = $claimMapper->getClaimUserAll();
        
        $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
        $this->cignaClaimDetailsUserAll = $claimDetailsMapper->getClaimDetailsUserAll();
        
        $medicalMapper = new Application_Model_CignaMedicalMapper();
        $this->cignaMedicalUserAll = $medicalMapper->getMedicalUserAll();
        
        foreach($usersAll as $k => $userObj) {
            //$executionId = $userObj->getCignaMedicalExeid(); //"912b4ad0-de95-46c5-8e37-fd43643adc04";
            $headerArray = $this->getHeaderArr();
            try {
                //$result = '{"headers":["user_id","password","whos_covered","date_of_birth","relationship","coverage_from","to","error"],"rows":[["rbrathwaite29","bIMSHIRE79!","Madelyn Brathwaite","11/03/2012","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marcus Brathwaite","08/04/2006","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marlena Brathwaite","12/19/2010","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Roderick Brathwaite","08/29/1969","Subscriber","01/01/2016","*",null]]}';
                //$resultCignaMedical = $this->myExecutionResult($userObj->getCignaMedicalExeid(), $headerArray);
                $resultCignaMedicalDeductibleClaim = $this->myExecutionResult($userObj->getCignaDeductibleClaimExeid(), $headerArray);
                echo '<pre>';
                print_r($resultCignaMedicalDeductibleClaim);
                echo '</pre>';
                die();

                //$resultCignaMedicalDetails = $this->myExecutionResult($userObj->getCignaClaimDetailsExeid(), $headerArray);
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = array();
            $arr['cigna_medical'] = json_decode($resultCignaMedical, true);
            $arr['cigna_deductible_claim'] = json_decode($resultCignaMedicalDeductibleClaim, true);
            $arr['cigna_medical_details'] = json_decode($resultCignaMedicalDetails, true);
            /*echo '<pre>';
            print_r($arr);
            echo '</pre>';*/
            //die('here');
            $this->storeScrape($userObj->getUserId(), $arr);
            
            break;
        }
        
    }
    
    private function storeScrape($userId, $arr)
    {
        
        //echo $arr['rows'][0][array_search('whos_covered', $arr['headers'])];
        try{
            // cingna_deductible
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            if ($this->cignaDeductibleUserAll) {
                $deductibleMapper->deleteCignaDeductible($userId);
            }
            foreach($arr['cigna_deductible_claim']['rows'] as $k => $eachRow) {
                $deductibleAmt = $eachRow[array_search('deductible_amt', $arr['cigna_deductible_claim']['headers'])];
                $deductibleMet = $eachRow[array_search('deductible_met', $arr['cigna_deductible_claim']['headers'])];
                $deductibleRemaining = $eachRow[array_search('deductible_remaining', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketAmt = $eachRow[array_search('out_of_pocket_amt', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketMet = $eachRow[array_search('out_of_pocket_met', $arr['cigna_deductible_claim']['headers'])];
                $outOfPocketRemaining = $eachRow[array_search('out_of_pocket_remaining', $arr['cigna_deductible_claim']['headers'])];

                $deductible = new Application_Model_CignaDeductible;
                $deductible->setUserId($userId);
                $deductible->setDeductibleAmt($deductibleAmt);
                $deductible->setDeductibleMet($deductibleMet);
                $deductible->setDeductibleRemaining($deductibleRemaining);
                $deductible->setOutOfPocketAmt($outOfPocketAmt);
                $deductible->setOutOfPocketMet($outOfPocketMet);
                $deductible->setOutOfPocketRemaining($outOfPocketRemaining);

                /*$deductibleMapper = new Application_Model_CignaDeductibleMapper();
                if (in_array($userId, $this->cignaDeductibleUserAll)) {
                    echo 'update...<br/>';
                    $deductibleId = $deductibleMapper->updateCignaDeductible($deductible);
                } else {*/
                    echo 'insert...<br/>';
                    $deductibleId = $deductibleMapper->insertCignaDeductible($deductible);
                //}
            }

            echo '<pre>';
            print_r($arr['cigna_deductible_claim']);
            echo '</pre>';
            
            // cingna_claim
            /*$claimMapper = new Application_Model_CignaClaimMapper();
            if ($this->cignaClaimUserAll) {
                $claimMapper->deleteCignaClaim($this->cignaClaimUserAll);
            }
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
                $claimId = $claimMapper->insertCignaClaim($claim);
            }
            
            // cingna_claim_details
            $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
            if ($this->cignaClaimDetailsUserAll) {
                $claimDetailsId = $claimDetailsMapper->deleteCignaClaimDetails($this->cignaClaimDetailsUserAll);
            }
            foreach($arr['cigna_medical_details']['rows'] as $k => $eachRow) {
                $serviceDateType = $eachRow[array_search('service_date_type', $arr['cigna_medical_details']['headers'])];
                $serviceAmountBilled = $eachRow[array_search('service_amount_billed', $arr['cigna_medical_details']['headers'])];
                $serviceDiscount = $eachRow[array_search('service_discount', $arr['cigna_medical_details']['headers'])];
                $serviceCoveredAmount = $eachRow[array_search('service_covered_amount', $arr['cigna_medical_details']['headers'])];
                $serviceCopayDeductible = $eachRow[array_search('service_copay_deductible', $arr['cigna_medical_details']['headers'])];
                $serviceWhatYourPlanPaid = $eachRow[array_search('service_what_your_plan_paid', $arr['cigna_medical_details']['headers'])];
                $serviceCoinsurance = $eachRow[array_search('service_coinsurance', $arr['cigna_medical_details']['headers'])];
                $serviceWhatIOwe = $eachRow[array_search('service_what_i_owe', $arr['cigna_medical_details']['headers'])];
                $serviceSeeNotes = $eachRow[array_search('service_see_notes', $arr['cigna_medical_details']['headers'])];

                $claimDetails = new Application_Model_CignaClaimDetails;
                $claimDetails->setUserId($userId);
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
                echo 'insert...<br/>';
            }
            
            // cingna_medical
            $medicalMapper = new Application_Model_CignaMedicalMapper();
            if ($this->cignaMedicalUserAll) {
                $medicalId = $medicalMapper->deleteCignaMedical($this->cignaClaimDetailsUserAll);
            }
            foreach($arr['cigna_medical']['rows'] as $k => $eachRow) {
                $whosCovered = $eachRow[array_search('whos_covered', $arr['cigna_medical']['headers'])];
                $dateOfBirth = $eachRow[array_search('date_of_birth', $arr['cigna_medical']['headers'])];
                $relationship = $eachRow[array_search('relationship', $arr['cigna_medical']['headers'])];
                $coverageFrom = $eachRow[array_search('coverage_from', $arr['cigna_medical']['headers'])];
                $to = $eachRow[array_search('to', $arr['cigna_medical']['headers'])];

                $medical = new Application_Model_CignaMedical;
                $medical->setUserId($userId);
                $medical->setWhosCovered($whosCovered);
                $medical->setDateOfBirth($dateOfBirth);
                $medical->setRelationship($relationship);
                $medical->setCoverageFrom($coverageFrom);
                $medical->setTo($to);
                
                $medicalId = $medicalMapper->saveCignaMedical($medical);
                echo 'insert...<br/>';
            }*/
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}