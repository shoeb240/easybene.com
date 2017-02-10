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
class ApiExpenseController extends My_Controller_ApiAbstract //Zend_Controller_Action
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
        try{
            $userId = $this->_getParam('user_id', null);
            $arr = array();
            
            $expenseMapper = new Application_Model_ExpenseMapper();
            $arr['expense'] = $expenseMapper->getExpenseByUser($userId);
            
            $documentMapper = new Application_Model_DocumentMapper();
            $arr['document'] = $documentMapper->getDocumentByUser($userId);

            //$this->getResponse()->setHttpResponseCode(My_Controller_ApiAbstract::RESPONSE_CREATED);
            //$this->getHelper('json')->sendJson($expenseInfo);
            echo json_encode($arr);
            
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
    }
    
    public function getAction()
    {
        try {
            $user_id = $this->_getParam('user_id', null);
            $expenseId = $this->_getParam('id', null);
            $act = $this->_getParam('act', null);

            if ($act == 'del') {
                $expenseMapper = new Application_Model_ExpenseMapper();
                $document_id = $expenseMapper->delete($user_id, $id);
            } else if ($act == 'save') {
                $price = $this->_getParam('data', null);
                $expenseMapper = new Application_Model_ExpenseMapper();
                $document_id = $expenseMapper->saveExpensePrice($user_id, $id, $price);
            } else if ($act == 'info') {
                $expenseMapper = new Application_Model_ExpenseMapper();
                $arr['expense'] = $expenseMapper->getExpense($expenseId);
                
                $expenseImageMapper = new Application_Model_ExpenseImageMapper();
                $arr['expense_image_arr'] = $expenseImageMapper->getExpenseImage($user_id, $expenseId);
                
                echo json_encode($arr);
            } else {
                $this->_error(My_Controller_ApiAbstract::ERROR_NOTFOUND, "GET - There is no such functionality at this moment");
                exit;
            }
        } catch (Exception $ex) {
            echo "Failed" . $ex->getMessage();
        }
    }

    public function postAction()
    {
        try {
            $user_id = $this->_getParam('user_id', null);
            $name = $this->_getParam('name', null);
            $expense_type = $this->_getParam('expense_type', null);
            $description = $this->_getParam('description', null);
            $date = $this->_getParam('date', null);
            $amount = $this->_getParam('amount', null);
            $additional_details = $this->_getParam('additional_details', null);

            $expenseMapper = new Application_Model_ExpenseMapper();
            $expense_id = $expenseMapper->saveExpense($user_id, $name, $expense_type, $description, $date, $amount, $additional_details);
            
            $image_list = $this->_getParam('image_list', null);
            $image_arr = explode(',', trim($image_list, ","));
            
            foreach($image_arr as $image) {
                $expenseImageMapper = new Application_Model_ExpenseImageMapper();
                $expenseImageMapper->saveExpenseImage($user_id, $expense_id, $image);
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