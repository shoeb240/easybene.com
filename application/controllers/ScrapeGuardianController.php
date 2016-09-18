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
class ScrapeGuardianController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://api.dexi.io/";
    
    private $cronKey = 'aG$s6&*H';
    
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
    
    private function myRunWithBulk($data_string, $headerArray, $runId) 
    {
        $url = $this->apiEndPoint . "/runs/" . $runId . "/execute/bulk";
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
        $userId = $this->_getParam('user_id', null);
        
        $usersAll = array();
        if (is_numeric($userId)) {
            $usersAll = $userMapper->getUserById($userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userMapper->getUserAll();
        }
        
        $ret_res = true;
        foreach($usersAll as $k => $userObj) {
            $u = $userObj->getGuardianUserId();
            $p = $userObj->getGuardianPassword();
            if (empty($u) || empty($p)) continue;
            
            for($i = 0; $i < 2; $i++) {
                $data = array();
                switch($i) {
                    case 0:
                        $data['user_id'] = $userObj->getGuardianUserId();
                        $data['password'] = $userObj->getGuardianPassword();
                        $runId = 'ece66e5d-c737-4136-bea7-8b2654816f4e';
                        $exeFieldName = 'guardian_benefit_exeid';
                        
                        $data_string = json_encode($data);                                                                                   
                        $headerArray = $this->getHeaderArr();
                        try {
                            $result = $this->myRunWithInput($data_string, $headerArray, $runId);
                        } catch (Exception $e) {
                        }
                        break;
                    case 1:
                        $data[0]['user_id'] = $userObj->getGuardianUserId();
                        $data[0]['password'] = $userObj->getGuardianPassword();
                        $data[0]['patient'] = 0;
                        $data[0]['coverage_type'] = 'D';
                        $data[1]['user_id'] = $userObj->getGuardianUserId();
                        $data[1]['password'] = $userObj->getGuardianPassword();
                        $data[1]['patient'] = 1;
                        $data[1]['coverage_type'] = 'D';
                        $data[2]['user_id'] = $userObj->getGuardianUserId();
                        $data[2]['password'] = $userObj->getGuardianPassword();
                        $data[2]['patient'] = 2;
                        $data[2]['coverage_type'] = 'D';
                        $data[3]['user_id'] = $userObj->getGuardianUserId();
                        $data[3]['password'] = $userObj->getGuardianPassword();
                        $data[3]['patient'] = 3;
                        $data[3]['coverage_type'] = 'D';
                        $runId = 'ca638336-786a-4550-b80a-4b045ba3892f';
                        $exeFieldName = 'guardian_claim_exeid';
                        
                        $data_string = json_encode($data);                                                                                   
                        $headerArray = $this->getHeaderArr();
                        try {
                            $result = $this->myRunWithBulk($data_string, $headerArray, $runId);
                        } catch (Exception $e) {
                            //echo $e->getMessage();
                            //die('catch');
                        }
                        
                        break;
                }
                
                $arr = json_decode($result, true);
                $exeId = $arr['_id'];
                $userMapper = new Application_Model_UserMapper();
                $usersAll = $userMapper->updateExecutionId($userObj->getUserId(), $exeId, $exeFieldName);
                if (empty($exeId)) {
                    $ret_res = false;
                }
            }
            
        }
        
        if ($ret_res) {
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
        $userMapper = new Application_Model_UserMapper();
        $userId = $this->_getParam('user_id', null);
        
        $usersAll = array();
        if (is_numeric($userId)) {
            $usersAll = $userMapper->getUserById($userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userMapper->getUserAll();
        }
        
        $ret_res = true;
        foreach($usersAll as $k => $userObj) {
            $headerArray = $this->getHeaderArr();
            try {
                //$result = '{"headers":["user_id","password","whos_covered","date_of_birth","relationship","coverage_from","to","error"],"rows":[["rbrathwaite29","bIMSHIRE79!","Madelyn Brathwaite","11/03/2012","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marcus Brathwaite","08/04/2006","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marlena Brathwaite","12/19/2010","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Roderick Brathwaite","08/29/1969","Subscriber","01/01/2016","*",null]]}';
                $resultGuardianBenefit = $this->myExecutionResult($userObj->getGuardianBenefitExeid(), $headerArray);
                $resultGuardianClaim = $this->myExecutionResult($userObj->getGuardianClaimExeid(), $headerArray);
            } catch (Exception $e) {
                //echo $e->getMessage() . '<br />';
                //die('catch');
            }
            $arr = array();
            $arr['guardian_benefit'] = json_decode($resultGuardianBenefit, true);
            $arr['guardian_claim'] = json_decode($resultGuardianClaim, true);
            /*echo '<pre>';
            print_r($arr);
            echo '</pre>';*/
            //die('here');
            $this->storeScrape($userObj->getUserId(), $arr);
        }
        
    }
    
    private function storeScrape($userId, $arr)
    {
        try{
            // cingna_deductible
            $benefitMapper = new Application_Model_GuardianBenefitMapper();
            $benefitMapper->deleteGuardianBenefit($userId);
            
            foreach($arr['guardian_benefit']['rows'] as $k => $eachRow) {
                $groupId = $eachRow[array_search('group_id', $arr['guardian_benefit']['headers'])];
                $companyName = $eachRow[array_search('company_name', $arr['guardian_benefit']['headers'])];
                $memberName = $eachRow[array_search('member_name', $arr['guardian_benefit']['headers'])];
                $name = $eachRow[array_search('name', $arr['guardian_benefit']['headers'])];
                $relationship = $eachRow[array_search('relationship', $arr['guardian_benefit']['headers'])];
                $coverage = $eachRow[array_search('coverage', $arr['guardian_benefit']['headers'])];
                $originalEffectiveDate = $eachRow[array_search('original_effective_date', $arr['guardian_benefit']['headers'])];
                $amounts = $eachRow[array_search('amounts', $arr['guardian_benefit']['headers'])];
                $monthlyCost = $eachRow[array_search('monthly_cost', $arr['guardian_benefit']['headers'])];

                $benefit = new Application_Model_GuardianBenefit;
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

                //echo 'insert...<br/>';
                try {
                    $benefitId = $benefitMapper->saveGuardianBenefit($benefit);
                } catch(Exception $e) {
                    //echo $e->getMessage();
                }
            }

            // cingna_claim
            $claimMapper = new Application_Model_GuardianClaimMapper();
            $claimMapper->deleteGuardianClaim($userId);
            
            foreach($arr['guardian_claim']['rows'] as $k => $eachRow) {
                $patient = $eachRow[array_search('patient', $arr['guardian_claim']['headers'])];
                $coverageType = $eachRow[array_search('coverage_type', $arr['guardian_claim']['headers'])];
                $claimNumber = $eachRow[array_search('claim_number', $arr['guardian_claim']['headers'])];
                $patientName = $eachRow[array_search('patient_name', $arr['guardian_claim']['headers'])];
                $dateOfService = $eachRow[array_search('date_of_service', $arr['guardian_claim']['headers'])];
                $paidDate = $eachRow[array_search('paid_date', $arr['guardian_claim']['headers'])];
                $checkNumber = $eachRow[array_search('check_number', $arr['guardian_claim']['headers'])];
                $providerNumber = $eachRow[array_search('provider_number', $arr['guardian_claim']['headers'])];
                $status = $eachRow[array_search('status', $arr['guardian_claim']['headers'])];
                $submittedCharges = $eachRow[array_search('submitted_charges', $arr['guardian_claim']['headers'])];
                $amountPaid = $eachRow[array_search('amount_paid', $arr['guardian_claim']['headers'])];

                $claim = new Application_Model_GuardianClaim;
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

                //echo 'insert...<br/>';
                $claimId = $claimMapper->saveGuardianClaim($claim);
            }
        } catch (Exception $ex) {
            //echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}