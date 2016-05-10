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
class ScrapeController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://app.cloudscrape.com/api/";
    
    private $cignaDeductibleUserAll;
    
    private $cignaClaimUserAll;
    
    private $cignaClaimDetailsUserAll;
    
    private $cignaMedicalUserAll;
    
    private $runId = "5facd97f-895a-412c-951e-0f5cf27978c6";
    
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
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
        $result = curl_exec($ch);

        return $result;
    }

    private function myRunWithInput($data_string, $headerArray) 
    {
        $url = $this->apiEndPoint . "/runs/" . $this->runId . "/execute/inputs";
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
            $data['username'] = $userObj->getCignaUserId(); // 'rbrathwaite29'
            $data['password'] = $userObj->getCignaPassword(); // 'bIMSHIRE79!'
            $data['view_claims_for'] = 'ALL';
            $data_string = json_encode($data);                                                                                   
            $headerArray = $this->getHeaderArr();
            try {
                $result = $this->myRunWithInput($data_string, $headerArray);
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = json_decode($result, true);
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            
            $cignaExecutionId = $arr['_id'];
            $userMapper = new Application_Model_UserMapper();
            $usersAll = $userMapper->updateExecutionId($userObj->getUserId(), $cignaExecutionId);
            break;
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
            $executionId = $userObj->getCignaExecutionId(); //"912b4ad0-de95-46c5-8e37-fd43643adc04";
            $headerArray = $this->getHeaderArr();
            try {
                //$result = '{"headers":["user_id","password","whos_covered","date_of_birth","relationship","coverage_from","to","error"],"rows":[["rbrathwaite29","bIMSHIRE79!","Madelyn Brathwaite","11/03/2012","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marcus Brathwaite","08/04/2006","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marlena Brathwaite","12/19/2010","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Roderick Brathwaite","08/29/1969","Subscriber","01/01/2016","*",null]]}';
                $result = $this->myExecutionResult($executionId, $headerArray);
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = json_decode($result, true);
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            
            $this->storeScrape($userObj->getUserId(), $arr);
            
            break;
        }
        
    }
    
    private function storeScrape($userId, $arr)
    {
        
        //echo $arr['rows'][0][array_search('whos_covered', $arr['headers'])];
        try{
            $firstRow = $arr['rows'][0];

            $user = $firstRow[array_search('deductible_amt', $arr['headers'])];

            // cingna_deductible
            $deductibleAmt = $firstRow[array_search('deductible_amt', $arr['headers'])];
            $deductibleMet = $firstRow[array_search('deductible_met', $arr['headers'])];
            $deductibleRemaining = $firstRow[array_search('deductible_remaining', $arr['headers'])];
            $outOfPocketAmt = $firstRow[array_search('out_of_pocket_amt', $arr['headers'])];
            $outOfPocketMet = $firstRow[array_search('out_of_pocket_met', $arr['headers'])];
            $outOfPocketRemaining = $firstRow[array_search('out_of_pocket_remaining', $arr['headers'])];
            
            $deductible = new Application_Model_CignaDeductible;
            $deductible->setUserId($userId);
            $deductible->setDeductibleAmt($deductibleAmt);
            $deductible->setDeductibleMet($deductibleMet);
            $deductible->setDeductibleRemaining($deductibleRemaining);
            $deductible->setOutOfPocketAmt($outOfPocketAmt);
            $deductible->setOutOfPocketMet($outOfPocketMet);
            $deductible->setOutOfPocketRemaining($outOfPocketRemaining);
            
            $deductibleMapper = new Application_Model_CignaDeductibleMapper();
            if (in_array($userId, $this->cignaDeductibleUserAll)) {
                echo 'update...<br/>';
                $deductibleId = $deductibleMapper->updateCignaDeductible($deductible);
            } else {
                echo 'insert...<br/>';
                $deductibleId = $deductibleMapper->insertCignaDeductible($deductible);
            }
            
            
            // cingna_claim
            $serviceDate = $firstRow[array_search('service_date', $arr['headers'])];
            $providedBy = $firstRow[array_search('provided_by', $arr['headers'])];
            $for = $firstRow[array_search('deductible_amt', $arr['headers'])];
            $status = $firstRow[array_search('status', $arr['headers'])];
            $amountBilled = $firstRow[array_search('amount_billed', $arr['headers'])];
            $whatYourPlanPaid = $firstRow[array_search('what_your_plan_paid', $arr['headers'])];
            $myAccountPaid = $firstRow[array_search('my_account_paid', $arr['headers'])];
            $whatIOwe = $firstRow[array_search('what_i_owe', $arr['headers'])];
            $claimNumber = $firstRow[array_search('claim_number', $arr['headers'])];

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
            $claim->setClaimNumber($claimNumber);

            $claimMapper = new Application_Model_CignaClaimMapper();
            if (in_array($userId, $this->cignaClaimUserAll)) {
                echo 'update...<br/>';
                $claimId = $claimMapper->updateCignaClaim($claim);
            } else {
                echo 'insert...<br/>';
                $claimId = $claimMapper->insertCignaClaim($claim);
            }

            // cingna_claim_details
            $claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
            if ($this->cignaClaimDetailsUserAll) {
                $claimDetailsId = $claimDetailsMapper->deleteCignaClaimDetails($this->cignaClaimDetailsUserAll);
            }

            foreach($arr['rows'] as $k => $eachRow) {
                $serviceDateType = $eachRow[array_search('service_date_type', $arr['headers'])];
                $serviceAmountBilled = $eachRow[array_search('service_amount_billed', $arr['headers'])];
                $serviceDiscount = $eachRow[array_search('service_discount', $arr['headers'])];
                $serviceCoveredAmount = $eachRow[array_search('service_covered_amount', $arr['headers'])];
                $serviceCopayDeductible = $eachRow[array_search('service_copay_deductible', $arr['headers'])];
                $serviceWhatYourPlanPaid = $eachRow[array_search('service_what_your_plan_paid', $arr['headers'])];
                $serviceCoinsurance = $eachRow[array_search('service_coinsurance', $arr['headers'])];
                $serviceWhatIOwe = $eachRow[array_search('service_what_i_owe', $arr['headers'])];
                $serviceSeeNotes = $eachRow[array_search('service_see_notes', $arr['headers'])];

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
                
                //$claimDetailsMapper = new Application_Model_CignaClaimDetailsMapper();
                $claimDetailsId = $claimDetailsMapper->saveCignaClaimDetails($claimDetails);
                echo 'insert...<br/>';
            }
            
            
            // cingna_medical
            /*$medicalMapper = new Application_Model_CignaMedicalMapper();
            if ($this->cignaMedicalUserAll) {
                $medicalId = $medicalMapper->deleteCignaMedical($this->cignaClaimDetailsUserAll);
            }

            foreach($arr['rows'] as $k => $eachRow) {
                $whosCovered = $eachRow[array_search('whos_covered', $arr['headers'])];
                $dateOfBirth = $eachRow[array_search('date_of_birth', $arr['headers'])];
                $relationship = $eachRow[array_search('relationship', $arr['headers'])];
                $coverageFrom = $eachRow[array_search('coverage_from', $arr['headers'])];
                $to = $eachRow[array_search('to', $arr['headers'])];

                $medical = new Application_Model_CignaMedical;
                $medical->setUserId($userId);
                $medical->setWhosCovered($whosCovered);
                $medical->setDateOfBirth($dateOfBirth);
                $medical->setRelationship($relationship);
                $medical->setCoverageFrom($coverageFrom);
                $medical->setTo($to);
                
                //$medicalMapper = new Application_Model_CignaMedicalMapper();
                $medicalId = $medicalMapper->saveCignaMedical($medical);
                echo 'insert...<br/>';
            }*/
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}