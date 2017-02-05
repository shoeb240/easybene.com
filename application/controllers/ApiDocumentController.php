<?php
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
class ApiDocumentController extends My_Controller_ApiAbstract //Zend_Controller_Action
{
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
    }
    
    public function indexAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "GET - There is no such functionality at this moment");
        exit;
    }
    
    public function getAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "GET - There is no such functionality at this moment");
        exit;
    }

    public function postAction()
    {
        try {
            $user_id = $this->_getParam('user_id', null);
            $name = $this->_getParam('name', null);
            $description = $this->_getParam('description', null);
            $additional_details = $this->_getParam('additional_details', null);

            $documentMapper = new Application_Model_DocumentMapper();
            $document_id = $documentMapper->saveDocument($user_id, $name, $description, $additional_details);

            $image_list = $this->_getParam('image_list', null);
            $image_arr = explode(',', $image_list);
            
            foreach($image_arr as $image) {
                $documentImageMapper = new Application_Model_DocumentImageMapper();
                $documentImageMapper->saveDocumentImage($user_id, $document_id, $image);
            }
            
            $this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            $this->getHelper('json')->sendJson('success');
            
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
    }

    public function putAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "PUT - There is no such functionality at this moment");
        exit;
    }

    public function deleteAction()
    {
        $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "DELETE - There is no such functionality at this moment");
        exit;
    }
    
    protected function getScraperConfig()
    {
        $options = array();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/scraper.ini', 'production', $options);
        
        return $config;     
    }
    
    
    
    
    
}