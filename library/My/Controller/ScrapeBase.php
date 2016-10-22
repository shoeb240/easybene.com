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

class My_Controller_ScrapeBase extends Zend_Controller_Action
{
    protected $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    protected $apiKey = "d927749cbc9bff7bcfc7beffd";

    protected $apiEndPoint = "https://api.dexi.io/";
    
    protected $cronKey = 'aG$s6&*H';
    
    protected $execute_res = true;
    
    protected $run_res = true;
    
    protected $ret_failed = array();
    
    protected $provider_name;
    
    protected $provider_type;
    
    protected $runs = array();
    
    protected $runs_data = array();
    
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
    
    protected function myExecutionCheck($executionId, $headerArray) 
    {
        $url = $this->apiEndPoint . "executions/{$executionId}";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
        $result = curl_exec($ch);
        
        $arr = json_decode($result);
        $state = $arr->state;
                
        return $state;
    }
    
    protected function myExecutionResult($userProviderExeObj, $headerArray) 
    {
        $executionId = $userProviderExeObj->exe_id;
        $execute_res = $this->myExecutionCheck($executionId, $headerArray);
        $result = array();
        if ('OK' === $execute_res) {
            $url = $this->apiEndPoint . "executions/{$executionId}/result";
            $ch = curl_init($url);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
            $result = curl_exec($ch);
        } else {
            $this->execute_res = $execute_res;
            $this->ret_failed[] = $userProviderExeObj->id;
        }

        return json_decode($result, true);
    }

    protected function myRunWithInput($data_string, $headerArray, $runId) 
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

    protected function getHeaderArr()
    {
        return array(                                                                          
                'X-CloudScrape-Access: ' . md5($this->accountId . $this->apiKey),
                'X-CloudScrape-Account: ' . $this->accountId,
                'Accept: application/json',
                'Content-Type: application/json', 
                'Access-Control-Allow-Origin: *'
        );
    }
    
    protected function prepareUsers($providerName, $providerType)
    {
        $userProviderMapper = new Application_Model_UserProviderMapper();
        
        $userId = $this->_getParam('user_id', null);
        $providerId = $this->_getParam('id', null);
        
        $usersAll = array();
        if (is_numeric($userId) && is_numeric($providerId)) {
            $usersAll = $userProviderMapper->getUserProvider($providerId, $userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userProviderMapper->getAllUserProviders($providerName, $providerType);
        }

        return $usersAll;
        
    }
    
    protected function prepareUsersForExecution($providerName, $providerType)
    {
        // Get user info
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        
        $userId = $this->_getParam('user_id', null);
        $userProviderTableId = $this->_getParam('id', null);
        
        $usersAll = array();
        if (is_numeric($userProviderTableId) && is_numeric($userId)) {
            $usersAll = $userProviderExeMapper->getUserProviderExe($userProviderTableId, $userId);
        } else if ($this->cronKey === $userId) {
            $usersAll = $userProviderExeMapper->getAllUserProvidersExe($providerName, $providerType);
        }
        
        return $usersAll;
    }
    
    protected function runEachScrapper($userObj, $runData, $runId, $runName)
    {
        $runData['user_id'] = $userObj->provider_user_id;
        $runData['password'] = $userObj->provider_password;
            
        $data_string = json_encode($runData);    
        $headerArray = $this->getHeaderArr();
        try {
            $result = $this->myRunWithInput($data_string, $headerArray, $runId);
        } catch (Exception $e) {
            $this->run_res = false;
        }

        $arr = json_decode($result, true);
        $exeId = $arr['_id'];

        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        $userProviderExeMapper->updateSiteCredentials($userObj->id, $runName, $exeId);
        //echo $userObj->provider_user_id.', '.$exeId.', '.$runName.'==';

        if (empty($exeId)) {
            $this->run_res = false;
        }
    }
    
    protected function runAllUsers($usersAll, $runFile)
    {
        $this->run_res = true;
        foreach($usersAll as $k => $userObj) {
            if (empty($userObj->provider_user_id) || empty($userObj->provider_password)) continue;
            
            reset($this->runs);
            foreach($this->runs as $run_id => $run_name) {
                $eachRunData = isset($this->runs_data[$run_name]) ? $this->runs_data[$run_name] : array();
                $this->runEachScrapper($userObj, $eachRunData, $run_id, $run_name);
            }
        }
        
        if ($this->run_res) {
            return json_encode(array('response' => true));
        } else {
            return json_encode(array('response' => false));
        }
    }
    
    protected function executeAllUsers($usersAll)
    {
        $headerArray = $this->getHeaderArr();
        foreach($usersAll as $userId => $userObj) {
            $arr = array();
            $this->execute_res = 'OK';
            foreach($userObj as $run_name => $userProviderExeObj) {
                try {
                    $arr[$run_name] = $this->myExecutionResult($userProviderExeObj, $headerArray);
                    if ('QUEUED' === $this->execute_res || 'PENDING' === $this->execute_res || 'RUNNING' === $this->execute_res) {
                        break;
                    }
                } catch (Exception $e) {
                    $this->ret_failed[] = $userProviderExeObj->id;
                }
            }
//            echo '<pre>';
//            print_r($arr);
//            echo '</pre>';
            $this->storeScrape($userId, $arr);
        }
        
        return json_encode(array('response' => $this->execute_res, 'response_failed_ids' => $this->ret_failed));
    }
    
    protected function storeScrape($userId, $arr)
    {
        reset($this->runs);
        foreach($this->runs as $run_name) {
            //echo '<br /><br /><br />'.$run_name.'<br />';
            if (!empty($arr[$run_name]['rows'])) {
                $mapper_class = 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $run_name))).'Mapper';
                //echo $mapper_class . '<br />';
                $mapper = new $mapper_class();
                $mapper->delete($userId);
            }
            
            foreach($arr[$run_name]['rows'] as $k => $eachRow) {
                $provider_class = 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $run_name)));
                $provider = new $provider_class();
                //echo $provider_class;
                foreach($arr[$run_name]['headers'] as $field_name) {
                    //echo  $field_name . '<br />';
                    $provider->setOption($field_name, $eachRow[array_search($field_name, $arr[$run_name]['headers'])]);
                }
                $provider->setOption('user_id', $userId);
                
                try {
//                    echo '<pre>';
//                    print_r($provider);
//                    echo '</pre>';
                    $providerId = $mapper->save($provider);
                } catch(Exception $e) {
                    echo $e->getMessage();
                }
                
                if (empty($providerId)) {
                    echo 'failed';
                }
            }
        }

    }

}