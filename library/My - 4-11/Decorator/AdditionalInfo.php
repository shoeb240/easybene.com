<?php
class My_Decorator_AdditionalInfo extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        if ( null == ($element = $this->getElement())) {
            return $content;
        }
        
        $decPre = '<h2>OPTIONAL</h2>
                <p class="left">
                    <label class="field_title">Additional Information :</label>
                    <span class="note add_option">
                        (This allows bidders to know
                        your specific requirements
                        a little better, e.g. if there is a
                        need for meet-up, etc.)
                    </span>
                </p>
                <p class="left optinal project_info">';
        
        $decPost = '</p>
                 <div class="clear"></div>';
        
        return $decPre . $content . $decPost;
    }
}