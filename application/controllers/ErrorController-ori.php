<?php
/**
 * Error handler
 * 
 * @category   Application
 * @package    Application_Controller
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @uses       Zend_Controller_Action
 * @version    1.0
 */
class ErrorController extends Zend_Controller_Action
{
    /**
     * Shows error page
     *
     * @return void
     */    
    public function errorAction()
    {
        $errors = $this->_getParams('error_handler');        
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                    $this->getResponse()->setHttpResponseCode(404);
                    $this->view->message = 'page not found';
                break;
            
            default:
                    $this->getResponse()->setHttpResponseCode(500);
                    $this->message = 'application erro';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request = $error->request;
        
    }
}