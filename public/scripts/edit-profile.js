function createUploader(){       
    var uploader = new qq.FileUploader({   
        element: document.getElementById('file-uploader-demo1'), 
        onProgress: function(id, fileName, loaded, total){$('#loading').show();},
        onComplete: function(id, fileName, responseJSON)
        { 
            filenameServer = ''+responseJSON['filename']+'';     
            //alert(filenameServer);
            $('#show_image_name').val(filenameServer);
            $('#loading').hide();
            $("#image").html($(document.createElement("img")).attr({src: "<?php echo $this->baseUrl('images/profile_image'); ?>/"+filenameServer,id:"jcrop",height: 160, width: 160})).show();                
        },
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        action: baseUrl + 'scripts/without-flash-uploader/php.php'
    });           
} 
window.onload = createUploader;       

function edit_profile_func()
{
    var full_name           = document.getElementById('full_name').value;
    var email               = document.getElementById('email').value;
    var contact_no          = document.getElementById('contact_no').value;

    re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(full_name=='') {
        alert('Please insert your full name!');
        return false;
    } else if(email=='') {
        alert('Please insert your email!');
        return false;
    } else if(re.test(email)!=true) {
        alert('Invalid email address!');
        return false;
    } else if(contact_no=='') {
        alert('Please insert a your contact number!');
        return false;
    } else {
        document.forms.edit_profile_form.submit();
    }
}
