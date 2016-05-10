<?php
class My_Decorator_CostDisplayGroup extends Zend_Form_Decorator_Abstract
{
   public function render($content)
   {
       $output = '<div class="left"><label class="field_title left">Budget<span style="color: red;">*</span> :</label>'
               . $content
               . '</div>';
       
       return $output;
   }
}