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

error_reporting(9);

class ScrapeAnthemController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://api.dexi.io/";
    
    private $cronKey = 'aG$s6&*H';
    
    private $ret_res = true;
    
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
        $userId = $this->_getParam('user_id', null);
        
        $usersAll = array();
        if (is_numeric($userId)) {
            $usersAll = $userMapper->getUserById($userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userMapper->getUserAll();
        }
        
        $this->ret_res = true;
        foreach($usersAll as $k => $userObj) {
            $u = $userObj->getAnthemUserId();
            $p = $userObj->getAnthemPassword();
            if (empty($u) || empty($p)) continue;
            
            for($i = 0; $i < 2; $i++) {
                $data = array();
                switch($i) {
                    case 0:
                        $data['user_id'] = $userObj->getAnthemUserId();
                        $data['password'] = $userObj->getAnthemPassword();
                        $data['claims_benefit_coverage'] = '2016-01-01_0001-01-01';
                        $data['claims_deductible_for'] = 10;
                        $runId = 'c6e8ec2a-466e-4a72-a269-c6586a3c25c6';
                        $exeFieldName = 'anthem_exeid';
                        break;
                    case 1:
                        $data['user_id'] = $userObj->getAnthemUserId();
                        $data['password'] = $userObj->getAnthemPassword();
                        $runId = 'b34f0574-bb01-44bf-9adb-8ca5ea962610';
                        $exeFieldName = 'anthem_claim_overview_exeid';
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
                $userMapper = new Application_Model_UserMapper();
                $usersAll = $userMapper->updateExecutionId($userObj->getUserId(), $exeId, $exeFieldName);
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
        $userMapper = new Application_Model_UserMapper();
        $userId = $this->_getParam('user_id', null);
        
        $usersAll = array();
        if (is_numeric($userId)) {
            $usersAll = $userMapper->getUserById($userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userMapper->getUserAll();
        }
        
        $this->ret_res = true;
        foreach($usersAll as $k => $userObj) {
            $headerArray = $this->getHeaderArr();
            try {
                $resultAnthem = $this->myExecutionResult($userObj->getAnthemExeid(), $headerArray);
                $resultAnthemClaimOverview = $this->myExecutionResult($userObj->getAnthemClaimOverviewExeid(), $headerArray);
            } catch (Exception $e) {
                $this->ret_res = false;
            }
            $arr = array();
            $arr['anthem'] = json_decode($resultAnthem, true);
            $arr['anthem_claim_overview'] = json_decode($resultAnthemClaimOverview, true);
//            echo '<pre>';
//            print_r($arr);
//            echo '</pre>';
            //die('here');
            $this->storeScrape($userObj->getUserId(), $arr);
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
            // cingna_deductible
            $anthemMapper = new Application_Model_AnthemMapper();
            $anthemMapper->deleteAnthem($userId);
            
            foreach($arr['anthem']['rows'] as $k => $eachRow) {
                $claims_benefit_coverage = $eachRow[array_search('claims_benefit_coverage', $arr['anthem']['headers'])];
                $claims_deductible_for = $eachRow[array_search('claims_deductible_for', $arr['anthem']['headers'])];
                $benefit_coverage = $eachRow[array_search('BM_benefit_coverage_period', $arr['anthem']['headers'])];
                $benefit_deductible_for = $eachRow[array_search('BM_benefit_deductible_for', $arr['anthem']['headers'])];
                $plan = $eachRow[array_search('BM_plan', $arr['anthem']['headers'])];
                $primary_care_physian = $eachRow[array_search('BM_primary_care_physian', $arr['anthem']['headers'])];
                $member_id = $eachRow[array_search('BM_member_id', $arr['anthem']['headers'])];
                $group_name = $eachRow[array_search('BM_group_name', $arr['anthem']['headers'])];
                $deductible_in_net_family_limit = $eachRow[array_search('CD_deductible_in_net_family_limit', $arr['anthem']['headers'])];
                $deductible_in_net_family_accumulate = $eachRow[array_search('CD_deductible_in_net_family_accumulate', $arr['anthem']['headers'])];
                $deductible_in_net_remaining = $eachRow[array_search('CD_deductible_in_net_remaining', $arr['anthem']['headers'])];
                $deductible_out_net_family_limit = $eachRow[array_search('CD_deductible_out_net_family_limit', $arr['anthem']['headers'])];
                $deductible_out_net_family_accumulate = $eachRow[array_search('CD_deductible_out_net_family_accumulate', $arr['anthem']['headers'])];
                $deductible_out_net_family_remaining = $eachRow[array_search('CD_deductible_out_net_family_remaining', $arr['anthem']['headers'])];
                $out_pocket_in_net_family_limit = $eachRow[array_search('CD_out_pocket_in_net_family_limit', $arr['anthem']['headers'])];
                $out_pocket_out_net_family_accumulate = $eachRow[array_search('CD_out_pocket_out_net_family_accumulate', $arr['anthem']['headers'])];
                $out_pocket_out_net_family_remaining = $eachRow[array_search('CD_out_pocket_out_net_family_remaining', $arr['anthem']['headers'])];
                $primary_care_physician = $eachRow[array_search('HP_primary_care_physician', $arr['anthem']['headers'])];
                $plan_name = $eachRow[array_search('BV_plan_name', $arr['anthem']['headers'])];
                $eligibility_benefit_for = $eachRow[array_search('BV_eligibility_benefit_for', $arr['anthem']['headers'])];
                $vision_member_id = $eachRow[array_search('BV_vision_member_id', $arr['anthem']['headers'])];
                $claims_benefit_coverage1 = $eachRow[array_search('CD_claims_benefit_coverage', $arr['anthem']['headers'])];
                $claims_benefit_deductible_for = $eachRow[array_search('CD_claims_benefit_deductible_for', $arr['anthem']['headers'])];

                $anthem = new Application_Model_Anthem();
                $anthem->setOption('user_id', $userId);
                $anthem->setOption('claims_benefit_coverage', $claims_benefit_coverage);
                $anthem->setOption('claims_deductible_for', $claims_deductible_for);
                $anthem->setOption('BM_benefit_coverage_period', $benefit_coverage);
                $anthem->setOption('BM_benefit_deductible_for', $benefit_deductible_for);
                $anthem->setOption('BM_plan', $plan);
                $anthem->setOption('BM_primary_care_physian', $primary_care_physian);
                $anthem->setOption('BM_member_id', $member_id);
                $anthem->setOption('BM_group_name', $group_name);
                $anthem->setOption('CD_deductible_in_net_family_limit', $deductible_in_net_family_limit);
                $anthem->setOption('CD_deductible_in_net_family_accumulate', $deductible_in_net_family_accumulate);
                $anthem->setOption('CD_deductible_in_net_remaining', $deductible_in_net_remaining);
                $anthem->setOption('CD_deductible_out_net_family_limit', $deductible_out_net_family_limit);
                $anthem->setOption('CD_deductible_out_net_family_accumulate', $deductible_out_net_family_accumulate);
                $anthem->setOption('CD_deductible_out_net_family_remaining', $deductible_out_net_family_remaining);
                $anthem->setOption('CD_out_pocket_in_net_family_limit', $out_pocket_in_net_family_limit);
                $anthem->setOption('CD_out_pocket_out_net_family_accumulate', $out_pocket_out_net_family_accumulate);
                $anthem->setOption('CD_out_pocket_out_net_family_remaining', $out_pocket_out_net_family_remaining);
                $anthem->setOption('HP_primary_care_physician', $primary_care_physician);
                $anthem->setOption('BV_plan_name', $plan_name);
                $anthem->setOption('BV_eligibility_benefit_for', $eligibility_benefit_for);
                $anthem->setOption('BV_vision_member_id', $vision_member_id);
                $anthem->setOption('CD_claims_benefit_coverage', $claims_benefit_coverage1);
                $anthem->setOption('CD_claims_benefit_deductible_for', $claims_benefit_deductible_for);
                
                //echo 'insert1...<br/>';
                try {
                    $anthemId = $anthemMapper->saveAnthem($anthem);
                    if (empty($anthemId)) {
                        $this->ret_res = false;
                    }
                } catch(Exception $e) {
                    //echo $e->getMessage();
                    $this->ret_res = false;
                }
            }

            // cingna_claim
            $claimMapper = new Application_Model_AnthemClaimOverviewMapper();
            $claimMapper->deleteAnthemClaimOverview($userId);
            
            foreach($arr['anthem_claim_overview']['rows'] as $k => $eachRow) {
                $number = $eachRow[array_search('number', $arr['anthem_claim_overview']['headers'])];
                $date = $eachRow[array_search('date', $arr['anthem_claim_overview']['headers'])];
                $for = $eachRow[array_search('for', $arr['anthem_claim_overview']['headers'])];
                $type = $eachRow[array_search('type', $arr['anthem_claim_overview']['headers'])];
                $doctor_facility = $eachRow[array_search('doctor_facility', $arr['anthem_claim_overview']['headers'])];
                $total = $eachRow[array_search('total', $arr['anthem_claim_overview']['headers'])];
                $member_responsibility = $eachRow[array_search('member_responsibility', $arr['anthem_claim_overview']['headers'])];
                $status = $eachRow[array_search('status', $arr['anthem_claim_overview']['headers'])];
                $status = $eachRow[array_search('status', $arr['anthem_claim_overview']['headers'])];
                if (empty($number)) continue;
                
                $claim = new Application_Model_AnthemClaimOverview;
                $claim->setOption('user_id', $userId);
                $claim->setOption('number', $number);
                $claim->setOption('date', $date);
                $claim->setOption('for', $for);
                $claim->setOption('type', $type);
                $claim->setOption('doctor_facility', $doctor_facility);
                $claim->setOption('total', $total);
                $claim->setOption('member_responsibility', $member_responsibility);
                $claim->setOption('status', $status);
                $claim->setOption('status', $status);

                //echo 'insert2...<br/>';
                $claimId = $claimMapper->saveAnthemClaimOverview($claim);
                if (empty($claimId)) {
                    $this->ret_res = false;
                }
            }
        } catch (Exception $ex) {
            //echo "Failed" . $ex->getMessage();
            $this->ret_res = false;
        }
        
    }
    
    
}