<?php

class ErrorController extends Zend_Controller_Action
{
    private $_notifier;  
    private $_error;  
    private $_environment;  
  
    public function init()  
    {
        //$this->_initForceSSL();
        $this->_helper->viewRenderer->setNoRender(true);

        parent::init();

        $bootstrap = $this->getInvokeArg('bootstrap');
        $environment = $bootstrap->getEnvironment();   
        
        if ($error = $this->_getParam('error_handler')){
            /*
            $mailer = new Zend_Mail();  
            $session = new Zend_Session_Namespace();  
            $database = $bootstrap->getResource('db');  
            $profiler = $database->getProfiler(); 

            $this->_notifier = new Frp_Service_Notifier_Error(  
                $environment,  
                $error,  
                $mailer,  
                $session,  
                $profiler,  
                $_SERVER  
            );*/

            $this->_error = $error;  
            $this->_environment = $environment;      
        }

        $this->_helper->contextSwitch()
            ->addActionContext('error', array('json'))
            ->setAutoJsonSerialization(true)
            ->initContext();
         
    }
    protected function _initForceSSL()
    {
        if($_SERVER['SERVER_PORT'] != '443') {
            header('Location: https://' . $_SERVER['HTTP_HOST'] .
                $_SERVER['REQUEST_URI']);
            exit();
        }
    }
  
    public function errorAction()  
    {
        switch ($this->_error->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:  
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION: 
                $this->getResponse()
                    ->setHttpResponseCode(My_Controller_ApiAbstract::ERROR_NOTFOUND);
                $this->getHelper('json')->sendJson(array('messages' => 'Not found'));
                break;
            case My_Controller_ApiAbstract::ERROR_EXPIRED:
                $this->getResponse()
                    ->setHttpResponseCode(My_Controller_ApiAbstract::ERROR_EXPIRED);
                $this->getHelper('json')->sendJson(array('messages' => 'Token expired'));
                break;
            case My_Controller_ApiAbstract::BAD_REQUEST:
                $this->getResponse()
                    ->setHttpResponseCode(My_Controller_ApiAbstract::BAD_REQUEST);
                $this->getHelper('json')->sendJson(array_merge(array('messages' => 'No token'), $this->_error->data));
                break;
            case My_Controller_ApiAbstract::ERROR_INSECURE_REQUEST:
                $this->getResponse()
                    ->setHttpResponseCode(My_Controller_ApiAbstract::ERROR_INSECURE_REQUEST);
                $this->getHelper('json')->sendJson(array_merge(array('messages' => 'Insecure request')));
                break;
            default:
                $this->getResponse()
                    ->setHttpResponseCode(My_Controller_ApiAbstract::ERROR_DENIED);
                $this->getHelper('json')->sendJson(array('messages' => 'Authorization Required'));
                break;
        }

        // Log exception, if logger available
        if ($log = $this->_getLog()) {  
            $log->crit($this->view->message, $this->_error->exception);  
        }  
    }  
  
    private function _applicationError()  
    {  
  
        switch ($this->_environment) {  
            case 'production':  
                $this->view->message = $this->_notifier->getShortErrorMessage();  
                break;  
//            case 'test':  
//                $this->_helper->layout->setLayout('blank');  
//                $this->_helper->viewRenderer->setNoRender();  
//  
//                $this->getResponse()->appendBody($shortMessage);  
//                break;  
            default:  
                $this->view->message = nl2br($this->_notifier->getFullErrorMessage());  
        }  
        
        $this->_notifier->notify();  
    }  
  
    private function _getLog()  
    {  
        $bootstrap = $this->getInvokeArg('bootstrap');  
        if (!$bootstrap->hasPluginResource('Log')) {  
            return false;  
        }  
        $log = $bootstrap->getResource('Log');  
        return $log;  
    }  

    public function notfoundAction()
    {
        
    }
    
    public function deniedAction()
    {
        $this->getResponse()->setHttpResponseCode(403);   
    }
}