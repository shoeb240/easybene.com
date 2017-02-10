<?php
/**
 * Application_Model_ExpenseImageMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_ExpenseImageMapper
{
    /**
     * @var Application_Model_DbTable_Anthem
     */
    private $_dbTable = null;
    
    /**
     * Create Zend_Db_Adapter_Abstract object
     *
     * @return Application_Model_DbTable_Anthem
     */
    public function getTable()
    {
        if (null == $this->_dbTable) {
            $this->_dbTable = new Application_Model_DbTable_ExpenseImage();
        }
        
        return $this->_dbTable;
    }
    
    public function getExpenseImage($userId, $expenseId)
    {
        $select = $this->getTable()->select();
        $select->from('expense_image', array('*'))
               ->where('expense_id = ?', $expenseId)
               ->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $expense = array();
            $expense['id'] = $row->id;
            $expense['user_id'] = $row->user_id;
            $expense['expense_id'] = $row->expense_id;
            $expense['image'] = $row->image;
            $expense['date'] = date("F j, Y", strtotime($row->date)); 
            
            $info[] = $expense;
        }

        return $info;
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveExpenseImage($user_id, $expense_id, $image)
    {
        $data = array(
            'user_id' => $user_id,
            'expense_id' => $expense_id,
            'image' => trim($image),
            'date' => date('Y-m-d'),
        );

        return $this->getTable()->insert($data);
    }
    
}