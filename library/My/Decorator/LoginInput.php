<?php
class My_Decorator_LoginInput extends Zend_Form_Decorator_Abstract
{
   public function buildLabel()
   {
       $element = $this->getElement();
       $label = $element->getLabel();
       if ($translator = $element->getTranslator()) {
           $label = $translator->translate($label);
       }
       
       if (empty($label)) return '';
       
       return '<label class="field_title">'.$label.'</label>';
   }
   
   public function buildErrors()
   {
       $element = $this->getElement();
       $messages = $element->getMessages();
       if (empty($messages)) {
           return '';
       }
       return '<div class="errors">' . $element->getView()->formErrors($messages) 
                                     . '</div>';
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
       $placement = $this->getPlacement();
       $separator = $this->getSeparator();
       
       $label = $this->buildLabel();
       $errors = $this->buildErrors();
       $description = $this->buildDescription();
       
       $output = $label
               . $content
               . $errors
               . $description
               . '<div class="clear"></div>';
       return $output;
   }
}