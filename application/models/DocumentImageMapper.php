<?php
/**
 * Application_Model_DocumentImageMapper class
 * 
 * @category   Application
 * @package    Application_Model
 * @author     Shoeb Abdullah <shoeb240@gmail.com>
 * @copyright  Copyright (c) 2013, Shoeb Abdullah
 * @version    1.0
 */
class Application_Model_DocumentImageMapper
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
            $this->_dbTable = new Application_Model_DbTable_DocumentImage();
        }
        
        return $this->_dbTable;
    }
    
    public function getDocumentImage($documentId, $userId)
    {
        $select = $this->getTable()->select();
        $select->from('document_image', array('*'))
               ->where('document_id = ?', $documentId)
               ->where('user_id = ?', $userId);
        $rowSets = $this->getTable()->fetchAll($select);
        
        $info = array();
        foreach($rowSets as $k => $row) {
            $document = array();
            $document['id'] = $row->id;
            $document['user_id'] = $row->user_id;
            $document['document_id'] = $row->document_id;
            $document['image'] = $row->image;
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
    public function saveDocumentImage($user_id, $document_id, $image)
    {
        $data = array(
            'user_id' => $user_id,
            'document_id' => $document_id,
            'image' => trim($image),
            'date' => date('Y-m-d'),
        );

        return $this->getTable()->insert($data);
    }
    
}