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
        
        $this->provider_name = 'anthem';
    
        $this->provider_type = 'medical';

        $this->runs = array('anthem', 'anthem_claim_overview');
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $usersAll = $this->prepareUsers($this->provider_name, $this->provider_type);

        $data = array();
        $data[0]['claims_benefit_coverage'] = '2016-01-01_0001-01-01';
        $data[0]['claims_deductible_for'] = 10;
        $runFile[0]['run_id'] = 'c6e8ec2a-466e-4a72-a269-c6586a3c25c6';
        $runFile[0]['run_name'] = $this->runs[0];

        $runFile[1]['run_id'] = 'b34f0574-bb01-44bf-9adb-8ca5ea962610';
        $runFile[1]['run_name'] = $this->runs[1];

        $ret = $this->runAllUsers($usersAll, $data, $runFile);
        
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