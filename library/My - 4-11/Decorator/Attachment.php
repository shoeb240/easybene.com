<?php
class My_Decorator_Attachment extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        if ( null == ($element = $this->getElement())) {
            return $content;
        }
        
        $decPre = ' <div class="message_attachment" style="margin-left:5px;float:right;">
                    <h5>ATTACHMENT</h5>

                    <script>
                        var upload_button_name  = "Select Attachment";
                    </script>       

                    <link href="/scripts/without-flash-uploader/fileuploader.css" rel="stylesheet" type="text/css">      
                    <style>
                         .qq-upload-list li{display:none;} 
                    </style>
                    <div id="file-uploader-demo1" style="width:178px;float:left;"></div>  
                    <div style="width:15px;float:left;">
                        <img id="loading1" src="/images/loading.gif" style="display:none;">
                    </div> 
                    <div style="width:60px;float:left;font-size:12px;color:green;">
                         <span id="show_image_name"> </span> 
                    </div>    
                    <script src="/scripts/without-flash-uploader/fileuploader.js" type="text/javascript"></script>
                    <script type="text/javascript"> 
                        function createUploader(){   
                            var uploader = new qq.FileUploader({   
                                element: document.getElementById("file-uploader-demo1"), 
                                onProgress: function(id, fileName, loaded, total){$("#loading1").show();},
                                onComplete: function(id, fileName, responseJSON)
                                { 
                                    filenameServer = ""+responseJSON["filename"]+""; 
                                    //alert(filenameServer); 
                                    $("#loading1").hide();  
                                    $("#show_image_name").html(filenameServer); 
                                    $("#attach1").val(filenameServer); 
                                },
                                allowedExtensions: ["pdf","doc","docx","txt","jpg", "jpeg", "png", "gif"],
                                action: "/scripts/without-flash-uploader/php_attachment.php"
                            });           
                        } 
                        window.onload = createUploader;       
                    </script>';
        
        $decPost = '     <div class="clear"></div>
                         <span class="note">(Upload attachments for bidders to see more of your project information)</span>
                     </div><!-- END message_attachment   -->';
        
        return $decPre . $content . $decPost;
    }
}