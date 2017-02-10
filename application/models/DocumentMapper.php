<?php
/**
 * Application_Model_DocumentMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_DocumentMapper
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
            $this->_dbTable = new Application_Model_DbTable_Document();
        }
        
        return $this->_dbTable;
    }
    
    public function getDocument($documentId)
    {
        $select = $this->getTable()->select();
        $select->where('id = ?', $documentId);
        $row = $this->getTable()->fetchRow($select);
        
        $document = array();
        $document['id'] = $row->id;
        $document['user_id'] = $row->user_id;
        $document['name'] = $row->name;
        $document['description'] = $row->description;
        $document['date'] = date("m-d-Y", strtotime($row->date));
        $document['additional_details'] = $row->additional_details;
        
        return $document;
    }
    
    public function getDocumentByUser($userId)
    {
        $select = $this->getTable()->select();
        $select->from('document', array('*'))
               ->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $document = array();
            $document['id'] = $row->id;
            $document['name'] = $row->name;
            $document['description'] = $row->description;
            $document['additional_details'] = $row->additional_details;
            $document['date'] = date("F j, Y", strtotime($row->date)); 
            
            $info[] = $document;
        }

        return $info;
    }
    
    /**
     * Get username by userId
     *
     * @param  int    $userId
     * @return string
     */
    public function getDocumentList()
    {
        $select = $this->getTable()->select();
        $select->order('description asc');
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $document = array();
            $document['id'] = $row->id;
            $document['name'] = $row->name;
            $document['description'] = $row->description;
            $document['additional_details'] = $row->additional_details;
            $document['date'] = date("F j, Y", strtotime($row->date)); 
            
            $info[] = $document;
        }

        return $info;
    }

    /**
     * Save user
     *
     * @param  Application_Model_User $scrape
     * @return int
     */
    public function saveDocument($user_id, $name, $description, $additional_details)
    {
        $data = array(
            'user_id' => $user_id,
            'name' => $name,
            'description' => $description,
            'additional_details' => $additional_details,
            'date' => date('Y-m-d'),
        );

        return $this->getTable()->insert($data);
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