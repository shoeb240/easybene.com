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

class ScrapeCignaController extends My_Controller_ScrapeBase
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
        
        $this->provider_name = 'cigna'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'medical'; // This must be exactly same like provider_list.provider_type

        // value should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // key is the run id from dexi
        $this->runs = array(
            'cigna_medical' => '6e1a629d-815b-4f5c-ae98-7145dd8ea815', 
            'cigna_deductible' => 'ca7fefc4-baf2-46cd-80b3-80433b488c00',
            'cigna_claim_details' => '0758a9a6-647a-42ad-9ec3-4b64fd6cddfb'
        );
        
        $this->runs_data = array(
            'cigna_claim_details' => array(
                'view_claims_for' => 'ALL',
                'date_range' => 'js-this-year'
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