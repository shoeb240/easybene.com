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
class ScrapeAnthemController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://app.cloudscrape.com/api/";
    
    private $anthemBenefitUserAll;
    
    private $anthemClaimUserAll;
    
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
        echo $url;
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

        $benefitMapper = new Application_Model_AnthemBenefitMapper();
        $this->anthemBenefitUserAll = $benefitMapper->getBenefitUserAll();
        
        $claimMapper = new Application_Model_AnthemClaimMapper();
        $this->anthemClaimUserAll = $claimMapper->getClaimUserAll();
        
        foreach($usersAll as $k => $userObj) {
            //$executionId = $userObj->getCignaMedicalExeid(); //"912b4ad0-de95-46c5-8e37-fd43643adc04";
            //if (!$userObj->getAnthemBenefitExeid()) continue;
            //echo $userObj->getAnthemClaimExeid() . '==';die();
            $headerArray = $this->getHeaderArr();
            try {
                //$result = '{"headers":["user_id","password","whos_covered","date_of_birth","relationship","coverage_from","to","error"],"rows":[["rbrathwaite29","bIMSHIRE79!","Madelyn Brathwaite","11/03/2012","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marcus Brathwaite","08/04/2006","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marlena Brathwaite","12/19/2010","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Roderick Brathwaite","08/29/1969","Subscriber","01/01/2016","*",null]]}';
                $resultAnthemBenefit = $this->myExecutionResult($userObj->getAnthemBenefitExeid(), $headerArray);
                $resultAnthemClaim = $this->myExecutionResult($userObj->getAnthemClaimExeid(), $headerArray);
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = array();
            $arr['anthem_benefit'] = json_decode($resultAnthemBenefit, true);
            $arr['anthem_claim'] = json_decode($resultAnthemClaim, true);
//            echo '<pre>';
//            print_r($arr);
//            echo '</pre>';
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
            $benefitMapper = new Application_Model_AnthemBenefitMapper();
            if ($this->anthemBenefitUserAll) {
                $benefitMapper->deleteAnthemBenefit($this->anthemBenefitUserAll);
            }
            foreach($arr['anthem_benefit']['rows'] as $k => $eachRow) {
                $groupId = $eachRow[array_search('group_id', $arr['anthem_benefit']['headers'])];
                $companyName = $eachRow[array_search('company_name', $arr['anthem_benefit']['headers'])];
                $memberName = $eachRow[array_search('member_name', $arr['anthem_benefit']['headers'])];
                $name = $eachRow[array_search('name', $arr['anthem_benefit']['headers'])];
                $relationship = $eachRow[array_search('relationship', $arr['anthem_benefit']['headers'])];
                $coverage = $eachRow[array_search('coverage', $arr['anthem_benefit']['headers'])];
                $originalEffectiveDate = $eachRow[array_search('original_effective_date', $arr['anthem_benefit']['headers'])];
                $amounts = $eachRow[array_search('amounts', $arr['anthem_benefit']['headers'])];
                $monthlyCost = $eachRow[array_search('monthly_cost', $arr['anthem_benefit']['headers'])];

                $benefit = new Application_Model_AnthemBenefit;
                $benefit->setUserId($userId);
                $benefit->setGroupId ($groupId);
                $benefit->setCompanyName($companyName);
                $benefit->setMemberName($memberName);
                $benefit->setName($name);
                $benefit->setRelationship($relationship);
                $benefit->setCoverage($coverage);
                $benefit->setOriginalEffectiveDate($originalEffectiveDate);
                $benefit->setAmounts($amounts);
                $benefit->setMonthlyCost($monthlyCost);

                echo 'insert...<br/>';
                try {
                    $benefitId = $benefitMapper->insertAnthemBenefit($benefit);
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
            }

            // cingna_claim
            $claimMapper = new Application_Model_AnthemClaimMapper();
            if ($this->anthemClaimUserAll) {
                $claimMapper->deleteAnthemClaim($this->anthemClaimUserAll);
            }
            foreach($arr['anthem_claim']['rows'] as $k => $eachRow) {
                $patient = $eachRow[array_search('patient', $arr['anthem_claim']['headers'])];
                $coverageType = $eachRow[array_search('coverage_type', $arr['anthem_claim']['headers'])];
                $claimNumber = $eachRow[array_search('claim_number', $arr['anthem_claim']['headers'])];
                $patientName = $eachRow[array_search('patient_name', $arr['anthem_claim']['headers'])];
                $dateOfService = $eachRow[array_search('date_of_service', $arr['anthem_claim']['headers'])];
                $paidDate = $eachRow[array_search('paid_date', $arr['anthem_claim']['headers'])];
                $checkNumber = $eachRow[array_search('check_number', $arr['anthem_claim']['headers'])];
                $providerNumber = $eachRow[array_search('provider_number', $arr['anthem_claim']['headers'])];
                $status = $eachRow[array_search('status', $arr['anthem_claim']['headers'])];
                $submittedCharges = $eachRow[array_search('submitted_charges', $arr['anthem_claim']['headers'])];
                $amountPaid = $eachRow[array_search('amount_paid', $arr['anthem_claim']['headers'])];

                $claim = new Application_Model_AnthemClaim;
                $claim->setUserId($userId);
                $claim->setPatient($patient);
                $claim->setCoverageType($coverageType);
                $claim->setClaimNumber($claimNumber);
                $claim->setPatientName($patientName);
                $claim->setDateOfService($dateOfService);
                $claim->setPaidDate($paidDate);
                $claim->setCheckNumber($checkNumber);
                $claim->setProviderNumber($providerNumber);
                $claim->setStatus($status);
                $claim->setSubmittedCharges($submittedCharges);
                $claim->setAmountPaid($amountPaid);

                echo 'insert...<br/>';
                $claimId = $claimMapper->insertAnthemClaim($claim);
            }
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}