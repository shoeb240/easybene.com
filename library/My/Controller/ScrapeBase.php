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

abstract class My_Controller_ScrapeBase extends Zend_Controller_Action
{
    protected $accountId = "17b650b4-4bd8-485d-9c83-cc84c542078a";
    
    protected $apiKey = "d927749cbc9bff7bcfc7beffd";

    protected $apiEndPoint = "https://api.dexi.io/";
    
    protected $cronKey = 'aG!s6*H';
    
    protected $cronRunning = false;
    
    protected $execute_res = true;
    
    protected $run_res = true;
    
    protected $ret_failed = array();
    
    protected $ret_succeeded = array();
    
    protected $provider_name;
    
    protected $provider_type;
    
    protected $runs = array();
    
    protected $runs_data = array();
    
    protected $run_count = 0;
    
    protected $execution_count = 0;
    
    protected $file_run_name;
    
    protected $file_run_field;
    
    protected $file_run_field_prefix;

    abstract public function runAction();
    
    abstract public function executeAction();
    
    abstract protected function prepare_id_card_data($text, $fileId);

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
            $this->ret_succeeded[] = $userProviderExeObj->id;
            $this->execution_count++;
        } else if ('FAILED' === $this->execute_res || 'STOPPED' === $this->execute_res) {
            $this->ret_failed[] = $userProviderExeObj->id;
        }

        return json_decode($result, true);
    }
    
    protected function myExecutionFileResult($userProviderExeObj, $headerArray, $fileId) 
    {
        $executionId = $userProviderExeObj->exe_id;
        
        $url = $this->apiEndPoint . "executions/{$executionId}/file/{$fileId}";
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);   
        $result = curl_exec($ch);
        
        //print_r($result);

        return $result;
    }

    protected function myRunWithInput($data_string, $headerArray, $runId, $bulk = false) 
    {
        if ($bulk) {
            $url = $this->apiEndPoint . "/runs/" . $runId . "/execute/bulk";
        } else {
            $url = $this->apiEndPoint . "/runs/" . $runId . "/execute/inputs";
        }
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
                'X-DexiIO-Access: ' . md5($this->accountId . $this->apiKey),
                'X-DexiIO-Account: ' . $this->accountId,
                'Accept: application/json',
                'Content-Type: application/json', 
                'Access-Control-Allow-Origin: *'
        );
    }
    
    protected function getHeaderFileArr()
    {
        return array(                                                                          
                'X-DexiIO-Access: ' . md5($this->accountId . $this->apiKey),
                'X-DexiIO-Account: ' . $this->accountId,
                'Accept: application/json',
                'Accept-Encoding: application/pdf', 
                'Access-Control-Allow-Origin: *'
        );
    }
    
    protected function prepareUsersForRun($providerName, $providerType)
    {
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        
        $userId = $this->_getParam('user_id', null);
        $providerId = $this->_getParam('id', null);
        
        if ($this->cronKey === $userId) {
            $this->cronRunning = true;
        }
        
        $usersAll = array();
        if (is_numeric($userId) && is_numeric($providerId)) {
            $usersAll = $userProviderExeMapper->getUserProviderRun($providerId, $userId);
        } else if ($this->cronRunning && $this->isCronRunSchedule()) {
            $usersAll = $userProviderExeMapper->getAllUserProvidersCronRun($providerName, $providerType);
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
        } else if ($this->cronRunning && $this->isCronExeSchedule()) {
            $usersAll = $userProviderExeMapper->getAllUserProvidersCronExe($providerName, $providerType);
        }
        
        return $usersAll;
    }
    
    protected function runEachScrapper($userObj, $runData, $runId, $runName)
    {
        $bulk = false;
        if (isset($runData[0]) && is_array($runData[0])) {
            $cnt = count($runData);
            for($i = 0; $i < $cnt; $i++) {
                $runData[$i]['user_id'] = $userObj->provider_user_id;
                $runData[$i]['password'] = $userObj->provider_password;
            }
            $bulk = true;
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
            $result = $this->myRunWithInput($data_string, $headerArray, $runId, $bulk);
        } catch (Exception $e) {
            $this->run_res = false;
        }

        $arr = json_decode($result, true);
        $exeId = isset($arr['_id']) ? $arr['_id'] : '';

        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        $exe_table_id = $userProviderExeMapper->updateSiteCredentials($userObj->id, $runName, $exeId);
        //echo $userObj->provider_user_id.', '.$exeId.', '.$runName.'==';

        if (empty($exeId)) {
            $this->run_res = false;
            $this->ret_failed[] = $exe_table_id;
        } else {
            $this->run_res = true;
            $this->ret_succeeded[] = $exe_table_id;
            $this->run_count++;
        }
    }
    
    protected function runAllUsers($usersAll, $runFile)
    {
        $cronConfig = $this->getCronConfig();
        
        foreach($usersAll as $userId => $userRuns) {
            if ($this->run_count >= $cronConfig->cron->run->each_time_run_count) break;
            if (count($userRuns) >= count($this->runs)) {
                // If rows for all runs are at user_provider_exe table
                echo '<br />=above=<br />';
                foreach($userRuns as $k => $userObj) {
                    if (empty($userObj->provider_user_id) || empty($userObj->provider_password)
                            || !$userObj->run_name) continue;
                    echo $userId . '==' . $userObj->exe_table_id . '==' . $userObj->failed . '==' . $userObj->executed . '==' . $userObj->timediff . '<br />';
                    
                    if (($userObj->failed == 1 && $userObj->timediff > $cronConfig->cron->run->failed->gap_sec)
                            || ($userObj->failed == 0 && $userObj->executed == 1 && $userObj->timediff > $cronConfig->cron->run->update->gap_sec)
                    ) { 
                        // if run was failed, and specified time has passed.
                        // if run was not failed, and was executed, and specified time has passed.
                        $this->run_res = true;
                        $run_name = $userObj->run_name;
                        $run_id = $this->runs[$run_name];
                        $eachRunData = isset($this->runs_data[$run_name]) ? $this->runs_data[$run_name] : array();
                        echo $run_name . '<br />';
                        $this->runEachScrapper($userObj, $eachRunData, $run_id, $run_name);

                        if ($this->cronRunning) {
                            $response[$userId][$run_name] = $this->run_res;
                        } else {
                            $response[$run_name] = $this->run_res;
                        }
                    }
                }
            } else {
                // If rows for all runs are NOT at user_provider_exe table
                echo '<br />=below=<br />';
                reset($this->runs);
                foreach($this->runs as $run_name => $run_id) {
                    if (empty($userRuns[0]->provider_user_id) || empty($userRuns[0]->provider_password)) continue;

                    $this->run_res = true;
                    $eachRunData = isset($this->runs_data[$run_name]) ? $this->runs_data[$run_name] : array();
                    echo $userId . '==' . $run_name . '<br />';
                    $this->runEachScrapper($userRuns[0], $eachRunData, $run_id, $run_name);

                    if ($this->cronRunning) {
                        $response[$userId][$run_name] = $this->run_res;
                    } else {
                        $response[$run_name] = $this->run_res;
                    }
                }
            }
        }
        
        /*if (!empty($this->ret_succeeded)) {
            $responseSucceededIds = implode(',', $this->ret_succeeded);
        }*/
        if (!empty($this->ret_failed)) {
            $responseFailedIds = implode(',', $this->ret_failed);
            $this->send_email($responseFailedIds);
        }

        return json_encode(array('response' => $response, 'response_failed_ids' => $responseFailedIds));
    }
    
    protected function executeAllUsers($usersAll)
    {
        $headerArray = $this->getHeaderArr();
        $cronConfig = $this->getCronConfig();
        /*echo '<pre>';
        print_r($usersAll);
        echo '<pre>';*/
        foreach($usersAll as $userId => $userObj) {
            if ($this->execution_count >= $cronConfig->cron->exe->each_time_execution_count) break;
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
                    
                    if ($this->file_run_name == $run_name) {
                        $headerFileArray = $this->getHeaderFileArr();
                        $file_run_field_val = $arr[$run_name]['rows'][0][2];
                        $tarr = explode(';', $file_run_field_val);
                        $fileId = $tarr[count($tarr) - 1];
                        //echo $fileId . '==';
                        $file_string = $this->myExecutionFileResult($userProviderExeObj, $headerFileArray, $fileId);
                        
                        file_put_contents(APPLICATION_PATH . '/../pdf_dl/'.$fileId.'.pdf', $file_string);
                        
                        // ID Card work
                        include APPLICATION_PATH . '/../pdfparser/vendor/autoload.php';

                        // Parse pdf file and build necessary objects.
                        $parser = new \Smalot\PdfParser\Parser();
                        $pdf    = $parser->parseFile(APPLICATION_PATH . '/../pdf_dl/'.$fileId.'.pdf');

                        $text = $pdf->getText();
                        /*echo '<pre>';
                        echo $text;
                        echo '</pre>';*/
                        
                        $arr[$run_name]['rows'][0] = $this->prepare_id_card_data($text, $fileId);
                        
                        /*echo '<pre>';
                        print_r($arr[$run_name]);
                        echo '</pre>';*/
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
        
        $userProviderExeMapper = new Application_Model_UserProviderExeMapper();
        if (!empty($this->ret_succeeded)) {
            $responseSucceededIds = implode(',', $this->ret_succeeded);
            $ok = $userProviderExeMapper->updateSucceeded($responseSucceededIds);
        }
        if (!empty($this->ret_failed)) {
            $responseFailedIds = implode(',', $this->ret_failed);
            $ok = $userProviderExeMapper->updateFailed($responseFailedIds);
            
            $this->send_email($responseFailedIds);
        }

        return json_encode(array('response' => $response, 'response_failed_ids' => $responseFailedIds));
    }
    
    protected function storeScrape($userId, $arr)
    {
        reset($this->runs);
        foreach($this->runs as $run_name => $run_id) {
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
            $mail = new Zend_Mail();
            $mail->setBodyText('Following user_provider_exe -> id failed while execution: ' . $failed);
            $mail->setFrom('easybenehelp@gmail.com', 'EasyBene');
            $mail->addTo('rod.brathwaite@gmail.com');
            $mail->addCc('shoeb240@gmail.com');
            $mail->setSubject('Easy Bene Failed Executions');
            $mail->send();
            
        } catch(Exception $e) {
            echo $e->getMessage() . 'error';
        }
    }
    
    protected function isCronRunSchedule()
    {
        $options = array();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cron.ini', 'production', $options);
        
        $run = false;
        $wday = date("w");
        $mday = date("j");
        
        if ($config->cron->run->schedule === 'weekly' && $wday == 1) { // runs on monday
            $run = true;
        } else if ($config->cron->run->schedule === 'monthly' && $mday == 1) { // runs on the first day of month
            $run = true;
        } else if ($config->cron->run->schedule === 'daily') {
            $run = true;
        }
        
        return $run;     
    }
    
    protected function isCronExeSchedule()
    {
        $options = array();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cron.ini', 'production', $options);
        
        $run = false;
        $wday = date("w");
        $mday = date("j");
        
        if ($config->cron->exe->schedule === 'weekly' && $wday == 1) { // runs on monday
            $run = true;
        } else if ($config->cron->exe->schedule === 'monthly' && $mday == 1) { // runs on the first day of month
            $run = true;
        } else if ($config->cron->exe->schedule === 'daily') {
            $run = true;
        }
        
        return $run;     
    }
    
    protected function getCronConfig()
    {
        $options = array();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cron.ini', 'production', $options);
        
        return $config;     
    }
    
}