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

class ScrapeUnitedConcordiaDentalController extends My_Controller_ScrapeBase
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
        
        $this->provider_name = 'UnitedConcordiaDental'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'dental'; // This must be exactly same like provider_list.provider_type

        // value should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // key is the run id from dexi
        $this->runs = array(
            //'UnitedConcordiaDentalBenefit' => 'ece66e5d-c737-4136-bea7-8b2654816f4e', 
            'UnitedConcordiaDentalClaim' => '553c0172-2aa0-4b2f-abe6-a702d6047b57'
        );
        
        $this->runs_data = array();
        
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
    
    protected function prepare_id_card_data($text, $fileId)
    {
        return null;
    }
    
}