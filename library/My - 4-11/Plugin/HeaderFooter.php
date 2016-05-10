<?php
class My_Plugin_HeaderFooter extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (!$request->isXmlHttpRequest()) {
            $response = $this->getResponse();
            $view = new Zend_View();
            $view->setBasePath(APPLICATION_PATH . '/views/');

            $response->prepend('header', $view->render('header.phtml'));
        }
    }
 
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        if (!$request->isXmlHttpRequest()) {
            $response = $this->getResponse();
            $view = new Zend_View();
            $view->setBasePath(APPLICATION_PATH . '/views/');

            $response->append('footer', $view->render('footer.phtml'));
        }
    }
}