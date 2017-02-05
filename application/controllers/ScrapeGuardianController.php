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
            'guardian_benefit' => 'ece66e5d-c737-4136-bea7-8b2654816f4e', 
            'guardian_claim' => 'ca638336-786a-4550-b80a-4b045ba3892f',
            'guardian_id_card' => '71687795-eb12-40b7-bc7f-f878569102d7'
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
        
        $this->file_run_name = 'guardian_id_card';
        $this->file_run_field = 'pdf_dl';
        $this->file_run_field_prefix = 'FILE:text/plain;';
        
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
        preg_match('/Subscriber:\W+([^\n]+)dependents/i', $text, $matches1);
        preg_match('/CARD\W+([^\n]+)/i', $text, $matches2);
        preg_match('/Plan Number:\W+([^\n]+)/i', $text, $matches3);
        preg_match('/Member ID\W+([^\n]+)/i', $text, $matches4);
        preg_match('/Customer Response Unit:\W+([\d\-]+)/i', $text, $matches5);


        $arr_run_name_rows_0[2] = $fileId;
        $arr_run_name_rows_0[3] = $matches1[1];
        $arr_run_name_rows_0[4] = $matches2[1];
        $arr_run_name_rows_0[5] = $matches3[1];
        $arr_run_name_rows_0[6] = $matches4[1];
        $arr_run_name_rows_0[7] = $matches5[1];
        
        return $arr_run_name_rows_0;
    }
    
}