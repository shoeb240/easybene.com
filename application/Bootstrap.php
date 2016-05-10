<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected $_appNamespace = 'Application';
    
    protected function _initPlaceholders()
    {
        //Zend_Session::setOptions(array('strict' => true));
        
        //Zend_Registry::set('Zend_Locale', 'bn_BD');
        
        $this->bootstrap('view');
        $view = $this->getResource('view');
        
        $view->docType('XHTML1_STRICT');
        $view->headTitle('Easy Bene Fits')
             ->setSeparator('::');
        $view->headLink()->prependStylesheet('/styles/style_sheet2.css')
                         ->appendStylesheet('/styles/custom_table.css')
                         ->appendStylesheet('/styles/message.css')
                         ->appendStylesheet('/styles/submodal/style.css')
                         ->appendStylesheet('/scripts/jQueryUI/themes/base/ui.all.css')
                         ->appendStylesheet('/styles/submodal/subModal.css')
                         ->appendStylesheet('/styles/submodal/style.css');
        
        $view->headScript()->prependFile('/scripts/jquery-1.7.1.min.js')
                           ->appendFile('/scripts/jquery.placeholder.js')
                           ->appendFile('/scripts/hoverIntent.js')
                           ->appendFile('/scripts/superfish.js')
                           ->appendFile('/scripts/js_sheet.js')
                           ->appendFile('/scripts/country.js')
                           ->appendFile('/scripts/ajaxfileupload.js')
                           ->appendFile('/scripts/jsval.js')
                           ->appendFile('/scripts/integer_check.js')
                           ->appendFile('/scripts/jQueryUI/ui/ui.datepicker.js')
                           ->appendFile('/scripts/job_search.js')
                           ->appendFile('/scripts/member_search.js')
                           ->appendFile('/scripts/submodal/common.js')
                           ->appendFile('/scripts/submodal/subModal.js');
    }
    
}