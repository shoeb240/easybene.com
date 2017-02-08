<?php
/**
 * Application_Model_ExpensesMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_ExpenseMapper
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
            $this->_dbTable = new Application_Model_DbTable_Expense();
        }
        
        return $this->_dbTable;
    }
    
    public function getExpense($expenseId)
    {
        $select = $this->getTable()->select();
        $select->from('expense', array('*'))
               ->where('id = ?', $expenseId);
        $row = $this->getTable()->fetchRow($select);
        
        return $row;
    }
    
    public function getExpenseByUser($userId)
    {
        $select = $this->getTable()->select();
        $select->from('expense', array('*'))
               ->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $expense = array();
            $expense['id'] = $row->id;
            $expense['name'] = $row->name;
            $expense['expense_type'] = $row->expense_type;
            $expense['description'] = $row->description;
            $expense['date'] = date("F j, Y", strtotime($row->date));  
            $expense['amount'] = $row->amount;
            $expense['additional_details'] = $row->additional_details;
            
            $info[] = $expense;
        }

        return $info;
    }
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getExpenseList($type = null)
    {
        $select = $this->getTable()->select();
        if ($type) {
            $select->where('expense_type = ?', $type);
        }
        $select->order('name asc');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $expense = array();
            $expense['id'] = $row->id;
            $expense['name'] = $row->name;
            $expense['expense_type'] = $row->expense_type;
            $expense['description'] = $row->description;
            $expense['date'] = date("F j, Y", strtotime($row->date)); 
            $expense['amount'] = $row->amount;
            $expense['additional_details'] = $row->additional_details;
            
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
    public function saveExpense($user_id, $name, $expense_type, $description, $date, $amount, $additional_details)
    {
        $data = array(
            'user_id' => $user_id,
            'name' => $name,
            'expense_type' => $expense_type,
            'description' => $description,
            'date' => date('Y-m-d', strtotime($date)),
            'amount' => $amount,
            'additional_details' => $additional_details,
        );

        return $this->getTable()->insert($data);
    }
    
    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveExpensePrice($user_id, $id, $price)
    {   echo $user_id .'='. $id .'='. $price;
    
        $data['amount'] = $price;
        $where = $this->getTable()->getAdapter()->quoteInto('user_id = ' . $user_id . ' AND id = ' . $id);
        
        return $this->getTable()->update($data, $where);
    }
    
    /**
     * Delete document
     *
     * @param  int $userId
     * @param  int $id
     * @return int 
     */
    public function delete($userId, $id)
    {
        $where = $this->getTable()->getAdapter()->quoteInto('id = ?', $id);
        return $this->getTable()->delete($where);
        
    }
}