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
    
    protected $cronRunning = false;
    
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
        $this->execute_res = $this->myExecutionCheck($executionId, $headerArray);
        //echo $this->execute_res . '==' . $executionId . '<br />';
        $result = array();
        if ('OK' === $this->execute_res) {
            $url = $this->apiEndPoint . "executions/{$executionId}/result";
            $ch = curl_init($url);                                                                      
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);                                                                                                                   
            $result = curl_exec($ch);
        } else if ('FAILED' === $this->execute_res || 'STOPPED' === $this->execute_res) {
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
        
        if ($this->cronKey === $userId) {
            $this->cronRunning = true;
        }
        
        $usersAll = array();
        if (is_numeric($userId) && is_numeric($providerId)) {
            $usersAll = $userProviderMapper->getUserProviderRun($providerId, $userId);
        } else if ($this->cronRunning) {
            $usersAll = $userProviderMapper->getAllUserProvidersCronRun($providerName, $providerType);
        }

        return $usersAll;
        
    }
    
    protected function prepareUsersForExecution($providerName, $providerType)
    {
        // Get user info
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        
        $userId = $this->_getParam('user_id', null);
        $userProviderTableId = $this->_getParam('id', null);
        
        if ($this->cronKey === $userId) {
            $this->cronRunning = true;
        }
        
        $usersAll = array();
        if (is_numeric($userProviderTableId) && is_numeric($userId)) {
            $usersAll = $userProviderExeMapper->getUserProviderExe($userProviderTableId, $userId);
        } else if ($this->cronRunning) {
            $usersAll = $userProviderExeMapper->getAllUserProvidersCronExe($providerName, $providerType);
        }
        
        return $usersAll;
    }
    
    protected function runEachScrapper($userObj, $runData, $runId, $runName)
    {
        if (isset($runData[0]) && is_array($runData[0])) {
            $cnt = count($runData);
            for($i = 0; $i < $cnt; $i++) {
                $runData[$i]['user_id'] = $userObj->provider_user_id;
                $runData[$i]['password'] = $userObj->provider_password;
            }
            
        } else {
            $runData['user_id'] = $userObj->provider_user_id;
            $runData['password'] = $userObj->provider_password;
        }
        
        $data_string = json_encode($runData);    
        /*echo '<pre>';
        print_r($data_string);
        echo '</pre>';*/
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
                /*echo '<pre>';
                print_r($eachRunData);
                echo '</pre>';*/
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
            //$this->execute_res = 'OK';
            foreach($userObj as $run_name => $userProviderExeObj) {
                try {
                    $arr[$run_name] = $this->myExecutionResult($userProviderExeObj, $headerArray);
                    // If any execution is not complete for this user, we are skipping all remaining runs for the user. 
                    // This is not for FAILED ro STOPPED
                    if ('QUEUED' === $this->execute_res || 'PENDING' === $this->execute_res || 'RUNNING' === $this->execute_res) {
                        break;
                    }
                } catch (Exception $e) {
                    $this->ret_failed[] = $userProviderExeObj->id;
                }
            }
            
            if ($this->cronRunning) {
                $response[$userId] = $this->execute_res;
            } else {
                $response = $this->execute_res;
            }
//            echo '<pre>';
//            print_r($arr);
//            echo '</pre>';
            $this->storeScrape($userId, $arr);
        }
        
        if (!empty($this->ret_failed)) {
            $responseFailedIds = implode(',', $this->ret_failed);
            $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
            $ok = $userProviderExeMapper->updateFailed($responseFailedIds);
            
            //$this->send_email($responseFailedIds);
        }

        return json_encode(array('response' => $response, 'response_failed_ids' => $responseFailedIds));
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
    
    protected function send_email($failed)
    {
        try {
            $this->load->library('email');

            $this->email->from('shoeb240@gmail.com', 'Easy Bene');
            $this->email->to('shoeb240@gmail.com');
            $this->email->cc('shoeb56@gmail.com');

            $this->email->subject('Easy Bene Failed Executions');
            $this->email->message('Following user_provider_exe.id failed while execution: ' . $failed);

            if ( ! $this->email->send())
            {
                echo 'Could not send email';
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

}