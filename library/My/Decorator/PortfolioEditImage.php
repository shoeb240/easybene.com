<?php
class My_Decorator_PortfolioEditImage extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        if ( null == ($element = $this->getElement())) {
            return $content;
        }
        
        $decPre = ' <div class="contain_buttons">
                        <br/>
                        <div id="upload">
                            <input type="hidden" class="normal_input" name="profile_image" id="show_image_name"/>
                        </div>
                ';
        
        $decPost = '     </div>';
        
        return $decPre . $content . $decPost;
    }
}