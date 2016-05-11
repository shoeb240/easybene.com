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
    
    private $anthemUserAll;
    
    private $anthemClaimOverviewUserAll;
    
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
        //echo $url;
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

        $anthemMapper = new Application_Model_AnthemMapper();
        $this->anthemUserAll = $anthemMapper->getAnthemUserAll();
        
        $claimMapper = new Application_Model_AnthemClaimOverviewMapper();
        $this->anthemClaimOverviewUserAll = $claimMapper->getClaimOverviewUserAll();

        foreach($usersAll as $k => $userObj) {
            //if (!$userObj->getAnthemExeid()) continue;
            //echo $userObj->getAnthemClaimOverviewExeid() . '==';            die('here');
            $headerArray = $this->getHeaderArr();
            try {
                //$result = '{"headers":["user_id","password","whos_covered","date_of_birth","relationship","coverage_from","to","error"],"rows":[["rbrathwaite29","bIMSHIRE79!","Madelyn Brathwaite","11/03/2012","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marcus Brathwaite","08/04/2006","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Marlena Brathwaite","12/19/2010","Dependent","01/01/2016","*",null],["rbrathwaite29","bIMSHIRE79!","Roderick Brathwaite","08/29/1969","Subscriber","01/01/2016","*",null]]}';
                $resultAnthem = $this->myExecutionResult($userObj->getAnthemExeid(), $headerArray);
                $resultAnthemClaimOverview = $this->myExecutionResult($userObj->getAnthemClaimOverviewExeid(), $headerArray);
                echo '<pre>';
                print_r($resultAnthemClaimOverview);
                echo '</pre>';
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = array();
            $arr['anthem'] = json_decode($resultAnthem, true);
            $arr['anthem_claim_overview'] = json_decode($resultAnthemClaimOverview, true);
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
            $anthemMapper = new Application_Model_AnthemMapper();
            if ($this->anthemUserAll) {
                $anthemMapper->deleteAnthem($this->anthemUserAll);
            }
            foreach($arr['anthem']['rows'] as $k => $eachRow) {
                $claims_benefit_coverage = $eachRow[array_search('claims_benefit_coverage', $arr['anthem']['headers'])];
                $claims_deductible_for = $eachRow[array_search('claims_deductible_for', $arr['anthem']['headers'])];
                $benefit_coverage = $eachRow[array_search('benefit_coverage', $arr['anthem']['headers'])];
                $benefit_deductible_for = $eachRow[array_search('benefit_deductible_for', $arr['anthem']['headers'])];
                $plan = $eachRow[array_search('plan', $arr['anthem']['headers'])];
                $primary_care_physian = $eachRow[array_search('primary_care_physian', $arr['anthem']['headers'])];
                $member_id = $eachRow[array_search('member_id', $arr['anthem']['headers'])];
                $group_name = $eachRow[array_search('group_name', $arr['anthem']['headers'])];
                $deductible_in_net_family_limit = $eachRow[array_search('deductible_in_net_family_limit', $arr['anthem']['headers'])];
                $deductible_in_net_family_accumulate = $eachRow[array_search('deductible_in_net_family_accumulate', $arr['anthem']['headers'])];
                $deductible_in_net_remaining = $eachRow[array_search('deductible_in_net_remaining', $arr['anthem']['headers'])];
                $deductible_out_net_family_limit = $eachRow[array_search('deductible_out_net_family_limit', $arr['anthem']['headers'])];
                $deductible_out_net_family_accumulate = $eachRow[array_search('deductible_out_net_family_accumulate', $arr['anthem']['headers'])];
                $deductible_out_net_family_remaining = $eachRow[array_search('deductible_out_net_family_remaining', $arr['anthem']['headers'])];
                $out_pocket_in_net_family_limit = $eachRow[array_search('out_pocket_in_net_family_limit', $arr['anthem']['headers'])];
                $out_pocket_out_net_family_accumulate = $eachRow[array_search('out_pocket_out_net_family_accumulate', $arr['anthem']['headers'])];
                $out_pocket_out_net_family_remaining = $eachRow[array_search('out_pocket_out_net_family_remaining', $arr['anthem']['headers'])];
                $primary_care_physician = $eachRow[array_search('primary_care_physician', $arr['anthem']['headers'])];
                $plan_name = $eachRow[array_search('plan_name', $arr['anthem']['headers'])];
                $eligibility_benefit_for = $eachRow[array_search('eligibility_benefit_for', $arr['anthem']['headers'])];
                $vision_member_id = $eachRow[array_search('vision_member_id', $arr['anthem']['headers'])];
                $claims_benefit_coverage1 = $eachRow[array_search('claims_benefit_coverage1', $arr['anthem']['headers'])];
                $claims_benefit_deductible_for = $eachRow[array_search('claims_benefit_deductible_for', $arr['anthem']['headers'])];

                $anthem = new Application_Model_Anthem();
                $anthem->setOption('user_id', $userId);
                $anthem->setOption('claims_benefit_coverage', $claims_benefit_coverage);
                $anthem->setOption('claims_deductible_for', $claims_deductible_for);
                $anthem->setOption('benefit_coverage', $benefit_coverage);
                $anthem->setOption('benefit_deductible_for', $benefit_deductible_for);
                $anthem->setOption('plan', $plan);
                $anthem->setOption('primary_care_physian', $primary_care_physian);
                $anthem->setOption('member_id', $member_id);
                $anthem->setOption('group_name', $group_name);
                $anthem->setOption('deductible_in_net_family_limit', $deductible_in_net_family_limit);
                $anthem->setOption('deductible_in_net_family_accumulate', $deductible_in_net_family_accumulate);
                $anthem->setOption('deductible_in_net_remaining', $deductible_in_net_remaining);
                $anthem->setOption('deductible_out_net_family_limit', $deductible_out_net_family_limit);
                $anthem->setOption('deductible_out_net_family_accumulate', $deductible_out_net_family_accumulate);
                $anthem->setOption('deductible_out_net_family_remaining', $deductible_out_net_family_remaining);
                $anthem->setOption('out_pocket_in_net_family_limit', $out_pocket_in_net_family_limit);
                $anthem->setOption('out_pocket_out_net_family_accumulate', $out_pocket_out_net_family_accumulate);
                $anthem->setOption('out_pocket_out_net_family_remaining', $out_pocket_out_net_family_remaining);
                $anthem->setOption('primary_care_physician', $primary_care_physician);
                $anthem->setOption('plan_name', $plan_name);
                $anthem->setOption('eligibility_benefit_for', $eligibility_benefit_for);
                $anthem->setOption('vision_member_id', $vision_member_id);
                $anthem->setOption('claims_benefit_coverage1', $claims_benefit_coverage1);
                $anthem->setOption('claims_benefit_deductible_for', $claims_benefit_deductible_for);
                
                echo 'insert1...<br/>';
                try {
                    $anthemId = $anthemMapper->insertAnthem($anthem);
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
            }

            // cingna_claim
            $claimMapper = new Application_Model_AnthemClaimOverviewMapper();
            if ($this->anthemClaimOverviewUserAll) {
                $claimMapper->deleteAnthemClaimOverview($this->anthemClaimOverviewUserAll);
            }
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

                echo 'insert2...<br/>';
                $claimId = $claimMapper->insertAnthemClaimOverview($claim);
            }
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}