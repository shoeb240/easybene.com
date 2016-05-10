<?php
class My_Decorator_PortfolioImage extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        if ( null == ($element = $this->getElement())) {
            return $content;
        }
        
        $decPre = '<div class="contain_buttons">
                        <center>
                            <img id="loading" src="/images/loading.gif" style="display:none;">
                        </center>

                        <script type="text/javascript">
                            var upload_button_name  = "Select Photo";
                        </script>

                        <link href="/scripts/without-flash-uploader/fileuploader.css" 
                              rel="stylesheet" type="text/css">
                        <style type="text/javascript">
                          .qq-upload-list li{display:none;}
                        </style>
                        <div id="file-uploader-demo1"></div>
                        <script src="/scripts/without-flash-uploader/fileuploader.js" 
                                type="text/javascript"></script>

                        <script type="text/javascript">
                            function createUploader(){
                                var uploader = new qq.FileUploader({
                                    multiple: false,
                                    element: document.getElementById("file-uploader-demo1"),
                                    onProgress: function(id, fileName, loaded, total){$("#loading").show();},
                                    onComplete: function(id, fileName, responseJSON)
                                    {
                                        filenameServer = ""+responseJSON["filename"]+"";
                                        //alert(filenameServer);
                                        //$("#show_image_name").val(filenameServer);
                                        $(".qq-upload-list").hide();
                                        $("#loading").hide();
                                        $("#image").html($(document.createElement("img")).attr({src: "/images/profile_image/"+filenameServer,id:"jcrop",height: 160, width: 160})).show();
                                        $(".upload_preview").show();
                                        $("#portfolio_image").val(filenameServer);
                                    },
                                    allowedExtensions: ["jpg", "jpeg", "png", "gif"],
                                    action: "/scripts/without-flash-uploader/php.php"
                                });
                            }
                            window.onload = createUploader;
                          </script>

                        <p>(Only jpg, gif, and png image formats)</p>

                        <br/>
                        <div id="upload">
                            <input type="hidden" class="normal_input" name="profile_image" id="show_image_name"/>
                        </div>';
        
        $decPost = '     </div>';
        
        return $decPre . $content . $decPost;
    }
}