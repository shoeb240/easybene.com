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

class ScrapeNaviaController extends Zend_Controller_Action
{
    private $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    private $apiKey = "d927749cbc9bff7bcfc7beffd";

    private $apiEndPoint = "https://api.dexi.io/";
    
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
        $userMapper = new Application_Model_UserMapper();
        $usersAll = $userMapper->getUserAll();

        foreach($usersAll as $k => $userObj) {
            if ( $userObj->getUserId() != 1 ) continue; // remove
            
            $u = $userObj->getNaviaUserId();
            $p = $userObj->getNaviaPassword();
            if (empty($u) || empty($p)) continue;
            
            for($i = 0; $i < 4; $i++) {
                $data = array();
                switch($i) {
                    case 0:
                        $data['user_id'] = $userObj->getNaviaUserId();
                        $data['password'] = $userObj->getNaviaPassword();
                        $runId = '32de3a3e-76f9-45e8-a37d-4ff66132f667';
                        $exeFieldName = 'navia_statements_exeid';
                        break;
                    case 1:
                        $data['user_id'] = $userObj->getNaviaUserId();
                        $data['password'] = $userObj->getNaviaPassword();
                        $runId = 'cff9b254-a1a3-4861-97dd-5eff1000582f';
                        $exeFieldName = 'navia_day_care_exeid';
                        break;
                    case 2:
                        $data['user_id'] = $userObj->getNaviaUserId();
                        $data['password'] = $userObj->getNaviaPassword();
                        $runId = 'b846427f-a72a-45a8-966e-990e42678bf2';
                        $exeFieldName = 'navia_health_care_exeid';
                        break;
                    case 3:
                        $data['user_id'] = $userObj->getNaviaUserId();
                        $data['password'] = $userObj->getNaviaPassword();
                        $runId = 'e51b26e3-6aa6-44f9-b6e3-8143d02a2f98';
                        $exeFieldName = 'navia_health_savings_exeid';
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

        foreach($usersAll as $k => $userObj) {
            if ( $userObj->getUserId() != 1 ) continue; // remove
            $headerArray = $this->getHeaderArr();
            try {
                $resultNaviaStatements = $this->myExecutionResult($userObj->getNaviaStatementsExeid(), $headerArray);
                $resultNaviaDayCare = $this->myExecutionResult($userObj->getNaviaDayCareExeid(), $headerArray);
                $resultNaviaHealthCare = $this->myExecutionResult($userObj->getNaviaHealthCareExeid(), $headerArray);
                $resultNaviaHealthSavings = $this->myExecutionResult($userObj->getNaviaHealthSavingsExeid(), $headerArray);
            } catch (Exception $e) {
                echo $e->getMessage();
                die('catch');
            }
            $arr = array();
            $arr['navia_statements'] = json_decode($resultNaviaStatements, true);
            $arr['navia_day_care'] = json_decode($resultNaviaDayCare, true);
            $arr['navia_health_care'] = json_decode($resultNaviaHealthCare, true);
            $arr['navia_health_savings'] = json_decode($resultNaviaHealthSavings, true);
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
            //die('here');
            $this->storeScrape($userObj->getUserId(), $arr);
            
            break;
        }
        
    }
    
    private function storeScrape($userId, $arr)
    {
        try{
            // navia_statements
            $naviaMapper = new Application_Model_NaviaStatementsMapper();
            $naviaMapper->deleteNaviaStatements($userId);
                
            foreach($arr['navia_statements']['rows'] as $k => $eachRow) {
                $naviaStatements = new Application_Model_NaviaStatements();
                $naviaStatements->setOption('user_id', $userId);
                $naviaStatements->setOption('DC_from_date', date("Y-m-d", strtotime(trim($eachRow[array_search('DC_from_date', $arr['navia_statements']['headers'])], ' -'))));
                $naviaStatements->setOption('DC_to_date', date("Y-m-d", strtotime($eachRow[array_search('DC_to_date', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('DC_claim', $eachRow[array_search('DC_claim', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('DC_annual_election', $eachRow[array_search('DC_annual_election', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('DC_last_day_incur_exp', date("Y-m-d", strtotime($eachRow[array_search('DC_last_day_incur_exp', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('DC_submit_claims', date("Y-m-d", strtotime($eachRow[array_search('DC_submit_claims', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('HC_date_from', date("Y-m-d", strtotime(trim($eachRow[array_search('HC_date_from', $arr['navia_statements']['headers'])], ' -'))));
                $naviaStatements->setOption('HC_date_to', date("Y-m-d", strtotime($eachRow[array_search('HC_date_to', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('HC_balance', $eachRow[array_search('HC_balance', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('HC_annual_election', $eachRow[array_search('HC_annual_election', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('HC_last_day_incur_exp', date("Y-m-d", strtotime($eachRow[array_search('HC_last_day_incur_exp', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('HC_last_day_submit_claims', date("Y-m-d", strtotime($eachRow[array_search('HC_last_day_submit_claims', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('HS_balance', $eachRow[array_search('HS_balance', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('HS_distributions', $eachRow[array_search('HS_distributions', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('HS_employee_contributions', $eachRow[array_search('HS_employee_contributions', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('HS_employer_contributions', $eachRow[array_search('HS_employer_contributions', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('TB_balance', $eachRow[array_search('TB_balance', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('TB_last_day_submit', date("Y-m-d", strtotime($eachRow[array_search('TB_last_day_submit', $arr['navia_statements']['headers'])])));
                $naviaStatements->setOption('PB_balance', $eachRow[array_search('PB_balance', $arr['navia_statements']['headers'])]);
                $naviaStatements->setOption('PB_last_day_submit', date("Y-m-d", strtotime($eachRow[array_search('PB_last_day_submit', $arr['navia_statements']['headers'])])));
                
                echo 'insert1...<br/>';
                try {
                    $naviaId = $naviaMapper->saveNaviaStatements($naviaStatements);
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
            }
            
            
            // navia_day_care
            $dayCareMapper = new Application_Model_NaviaDayCareMapper();
            $dayCareMapper->deleteNaviaDayCare($userId);
            
            foreach($arr['navia_day_care']['rows'] as $k => $eachRow) {
                $dayCare = new Application_Model_NaviaDayCare();
                $dayCare->setOption('user_id', $userId);
                $dayCare->setOption('claim', $eachRow[array_search('claim', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('annual_election', $eachRow[array_search('annual_election', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('reimbursed_to_date', $eachRow[array_search('reimbursed_to_date', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('date_posted', $eachRow[array_search('date_posted', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('transaction_type', $eachRow[array_search('transaction_type', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('claim_amount', $eachRow[array_search('claim_amount', $arr['navia_day_care']['headers'])]);
                $dayCare->setOption('amount', $eachRow[array_search('amount', $arr['navia_day_care']['headers'])]);

                echo 'insert2...<br/>';
                $id = $dayCareMapper->saveNaviaDayCare($dayCare);
            }
            
            
            // navia_health_care
            $healthCareMapper = new Application_Model_NaviaHealthCareMapper();
            $healthCareMapper->deleteNaviaHealthCare($userId);
            
            foreach($arr['navia_health_care']['rows'] as $k => $eachRow) {
                $healthCare = new Application_Model_NaviaHealthCare();
                $healthCare->setOption('user_id', $userId);
                $healthCare->setOption('balance', $eachRow[array_search('balance', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('annual_election', $eachRow[array_search('annual_election', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('reimbursed_to_date', $eachRow[array_search('reimbursed_to_date', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('date_posted', $eachRow[array_search('date_posted', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('transaction_type', $eachRow[array_search('transaction_type', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('claim_amount', $eachRow[array_search('claim_amount', $arr['navia_health_care']['headers'])]);
                $healthCare->setOption('amount', $eachRow[array_search('amount', $arr['navia_health_care']['headers'])]);

                echo 'insert3...<br/>';
                $id = $healthCareMapper->saveNaviaHealthCare($healthCare);
            }
            
            // navia_health_savings
            $healthSavingsMapper = new Application_Model_NaviaHealthSavingsMapper();
            $healthSavingsMapper->deleteNaviaHealthSavings($userId);
            
            foreach($arr['navia_health_savings']['rows'] as $k => $eachRow) {
                $healthSavings = new Application_Model_NaviaHealthSavings();
                $healthSavings->setOption('user_id', $userId);
                $healthSavings->setOption('balance', $eachRow[array_search('balance', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('portfolio_balance', $eachRow[array_search('portfolio_balance', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('total_balance', $eachRow[array_search('total_balance', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('contributions_YTD', $eachRow[array_search('contributions_YTD', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('employer_contributions_YTD', $eachRow[array_search('employer_contributions_YTD', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('total_contributions_YTD', $eachRow[array_search('total_contributions_YTD', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('employer_per_pay_amount', $eachRow[array_search('employer_per_pay_amount', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('employee_per_pay_amount', $eachRow[array_search('employee_per_pay_amount', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('transaction_date', $eachRow[array_search('transaction_date', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('transaction_type', $eachRow[array_search('transaction_type', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('description', $eachRow[array_search('description', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('transaction_amt', $eachRow[array_search('transaction_amt', $arr['navia_health_savings']['headers'])]);
                $healthSavings->setOption('HSA_transaction_type', $eachRow[array_search('HSA_transaction_type', $arr['navia_health_savings']['headers'])]);

                echo 'insert4...<br/>';
                $id = $healthSavingsMapper->saveNaviaHealthSavings($healthSavings);
            }
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
    }
    
    
}