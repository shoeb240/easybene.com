<?php
class My_Decorator_LeftDisplayGroup extends Zend_Form_Decorator_Abstract
{
   public function render($content)
   {
       $output = '<div class="left">'
               . $content
               . '</div><div class="clear"></div>';
       
       return $output;
   }
}