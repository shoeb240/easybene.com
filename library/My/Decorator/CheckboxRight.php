<?php
class My_Decorator_CheckboxRight extends Zend_Form_Decorator_Abstract
{
   public function buildLabel()
   {
       $element = $this->getElement();
       $label = $element->getLabel();
       if ($translator = $element->getTranslator()) {
           $label = $translator->translate($label);
       }
       
       if (empty($label)) return '';
       
       return '<label class="project_info">' . $label . '</label>';
   }
   
   public function buildDescription()
   {
       $element = $this->getElement();
       $description = $element->getDescription();
       if (empty($description)) {
           return '';
       }
       return '<div class="description">' . $description . '</div>';
   }
   
   public function render($content)
   {
       $label = $this->buildLabel();
       $description = $this->buildDescription();
       
       $output = '<p class="right">'
               . $content
               . $label
               . $description
               . '</p>'
               . '<div class="clear"></div>';
       
       return $output;
   }
}