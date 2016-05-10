<?php
class My_Form_JobConfirm extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post')
             ->setAction('/project/project-submit-confirm')
             ->setName('submit_proj')
             ->setAttrib('onsubmit', 'return submit_project_func()')
             ->setElementDecorators(array('ViewHelper'));
                
        $projectId = $this->createElement('hidden', 'project_id');
        $this->addElement($projectId);

        $submit = new Zend_Form_Element_Submit('userLogin');
        $submit->setLabel('CONFIRM PROJECT SUBMISSION')
               ->removeDecorator('DtDdWrapper')
               ->setAttrib('class', 'red_button med_rounded left')
               ->addDecorators(array(array('HtmlTag', array('tag' => 'div', 'class' => 'clear'))));
        $this->addElement($submit);
        
    }
}