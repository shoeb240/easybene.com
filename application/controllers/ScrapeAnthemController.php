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

class ScrapeAnthemController extends My_Controller_ScrapeBase
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
        
        $this->provider_name = 'anthem'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'medical'; // This must be exactly same like provider_list.provider_type

        // value should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // key is the run id from dexi
        $this->runs = array(
            'anthem' => 'c6e8ec2a-466e-4a72-a269-c6586a3c25c6', 
            'anthem_claim_overview' => 'b34f0574-bb01-44bf-9adb-8ca5ea962610'
        );
        
        $this->runs_data = array(
            'anthem' => array(
                'claims_benefit_coverage' => '2016-01-01_0001-01-01',
                'claims_deductible_for' => 10
            )
        );
        
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $usersAll = $this->prepareUsersForRun($this->provider_name, $this->provider_type);

        /*$data = array();
        $data[0]['claims_benefit_coverage'] = '2016-01-01_0001-01-01';
        $data[0]['claims_deductible_for'] = 10;*/
        
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