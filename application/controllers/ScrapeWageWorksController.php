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

class ScrapeWageWorksController extends My_Controller_ScrapeBase
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
        
        $this->provider_name = 'WageWorks'; // This must be exactly same like provider_list.name
    
        $this->provider_type = 'funds'; // This must be exactly same like provider_list.provider_type

        // key should be same as user_provider_exe.run_name
        // mapper model name must be same as 'Application_Model_'.  str_replace(' ', '', ucwords(str_replace('_', ' ', $eachRun))).'Mapper';
        // 
        // value is the run id from dexi
        $this->runs = array(
            'WageWorksDayCare' => 'd6dd3d7b-0c86-4fc3-80fe-7617eb58d51a', 
            'WageWorksHealthCare' => '2cd22404-ed16-49c4-9397-6587d554e60e', 
        );
        
        $this->runs_data = array();
    }
    
    public function runAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        
        $usersAll = $this->prepareUsersForRun($this->provider_name, $this->provider_type);
        /*echo '==';
        print_r($usersAll);
        die('xxx');*/
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
    
    protected function prepare_id_card_data($text, $fileId)
    {
        return null;
    }
}