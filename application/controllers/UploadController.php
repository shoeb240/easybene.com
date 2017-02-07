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
class UploadController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
        /*echo '<pre>';
        print_r($_FILES);
        print_r($_POST);
        echo '</pre>';*/
        
        $type = '.jpeg';
        switch ($_FILES['type']) {
            case 'image/jpeg':
                    $type = '.jpeg';
                brek;
            case 'image/png':
                    $type = '.png';
                brek;
        }
        $image_name = $_POST['value1'] . $type;
        
        try{
            $result = move_uploaded_file($_FILES["file"]["tmp_name"], APPLICATION_PATH . '/../camera/' . $image_name);            
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
        
        if ($result) {
            echo $image_name;
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
    
    
    
    
    
}