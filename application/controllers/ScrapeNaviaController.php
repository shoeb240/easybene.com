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

class ScrapeNaviaController extends My_Controller_ScrapeBase
{
    /**
     * Initialize object
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    
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
        
        $this->provider_name = 'navia'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'funds'; // This must be exactly same like provider_list.provider_type

        // value should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // key is the run id from dexi
        $this->runs = array(
            'navia_statements' => '32de3a3e-76f9-45e8-a37d-4ff66132f667', 
            'navia_day_care' => 'cff9b254-a1a3-4861-97dd-5eff1000582f', 
            'navia_health_care' => 'b846427f-a72a-45a8-966e-990e42678bf2', 
            'navia_health_savings' => 'e51b26e3-6aa6-44f9-b6e3-8143d02a2f98'
        );
        
        $this->runs_data = array();
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $usersAll = $this->prepareUsersForRun($this->provider_name, $this->provider_type);

        /*$runFile = array();
        $i = 0;
        foreach($this->runs as $runId => $runName) {
            $runFile[$i]['run_id'] = $runId;
            $runFile[$i]['run_name'] = $runName;
            $i++;
        }*/

        $ret = $this->runAllUsers($usersAll);
        
        echo $ret;
    }
    
    /**
     * Scrape default page action
     *
     * @return void
     */
    public function executeAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
       
        $usersAll = $this->prepareUsersForExecution($this->provider_name, $this->provider_type);
        $ret = $this->executeAllUsers($usersAll);
        
        echo $ret;
    }
    
}