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
class Application_Model_ExpensesMapper
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
            $this->_dbTable = new Application_Model_DbTable_Expenses();
        }
        
        return $this->_dbTable;
    }
    
    public function getExpense($expenseId)
    {
        $select = $this->getTable()->select();
        $select->from('expenses', array('*'))
               ->where('id = ?', $expenseId);
        $row = $this->getTable()->fetchRow($select);
        
        return $row;
    }
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getExpenses($type = null)
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
            $expense['expense_type'] = $row->expense_type;
            $expense['description'] = $row->description;
            $expense['date'] = $row->date; 
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
    public function saveExpenses(Application_Model_Expenses $expenses)
    {
        $data = array(
            'id' => $expenses->getOption('id'),
            'expense_type' => $expenses->getOption('expense_type'),
            'description' => $expenses->getOption('description'),
            'date' => $expenses->getOption('date'),
            'amount' => trim($expenses->getOption('amount')),
            'additional_details' => trim($expenses->getOption('additional_details')),
        );

        return $this->getTable()->insert($data);
    }
    
}