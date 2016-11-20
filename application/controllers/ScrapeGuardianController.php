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

class ScrapeGuardianController extends My_Controller_ScrapeBase
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
        
        $this->provider_name = 'guardian'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'dental'; // This must be exactly same like provider_list.provider_type

        // value should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // key is the run id from dexi
        $this->runs = array(
            'ece66e5d-c737-4136-bea7-8b2654816f4e' => 'guardian_benefit', 
            'ca638336-786a-4550-b80a-4b045ba3892f' => 'guardian_claim'
        );
        
        $this->runs_data = array(
            'guardian_claim' => array(
                array(
                    'patient' => 0,
                    'coverage_type' => 'D',
                    'date_of_service_from' => '01/01/'.date("Y"),
                    'date_of_service_to' =>  date("m/d/Y")
                ),
                array(
                    'patient' => 1,
                    'coverage_type' => 'D',
                    'date_of_service_from' => '01/01/'.date("Y"),
                    'date_of_service_to' => date("m/d/Y")
                ),
                array(
                    'patient' => 2,
                    'coverage_type' => 'D',
                    'date_of_service_from' => '01/01/'.date("Y"),
                    'date_of_service_to' =>  date("m/d/Y")
                ),
                array(
                    'patient' => 3,
                    'coverage_type' => 'D',
                    'date_of_service_from' => '01/01/'.date("Y"),
                    'date_of_service_to' =>  date("m/d/Y")
                ),
            )
        );
        
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $usersAll = $this->prepareUsersForRun($this->provider_name, $this->provider_type);

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