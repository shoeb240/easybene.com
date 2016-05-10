var upload_button_name  = 'Select Photo';

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
            $("#image").html($(document.createElement("img")).attr({src: baseUrl + 'images/profile_image/'+filenameServer,id:"jcrop",height: 160, width: 160})).show();                
        },
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        action: baseUrl + 'scripts/without-flash-uploader/php.php'
    });           
} 
window.onload = createUploader;       



function set_premium_option_value(option)
{
    $('#membership_id').val(option);
}

function set_primary_category_option_value(option)
{
    $('#primary_category_id').val(option);
}

function suign_up_func()
{
    var username            = document.getElementById('username').value;
    var full_name           = document.getElementById('full_name').value;
    var email               = document.getElementById('email').value;
    var password            = document.getElementById('password').value;
    var retype_password     = document.getElementById('retype_password').value;
    var contact_no          = document.getElementById('contact_no').value;
    var primary_category_id = document.getElementById('primary_category_id').value;

    re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if(username == '') {
        alert('Please insert your username!');
        return false;
    } else if(full_name=='') {
        alert('Please insert your full name!');
        return false;
    } else if(email=='') {
        alert('Please insert your email!');
        return false;
    } else if(re.test(email)!=true) {
        alert('Invalid email address!');
        return false;
    } else if(password=='') {
        alert('Please insert your password!');
        return false;
    } else if(password != retype_password) {
        alert('Password not match!');
        return false;
    } else if(contact_no=='') {
        alert('Please insert a your contact number!');
        return false;
    } else if(primary_category_id=='') {
        alert('Please select your primary category!');
        return false;
    } else {
        var username  = $('#username').val();
        var email  = $('#email').val();

        $.ajax({
            type: "POST",
            url: baseUrl + 'authentication/check_user',
            data:{
                'username':username,
                'email':email
            },
            success: function(html_data)
            {
                if (html_data == '') {
                    //$('#total_found').html(html_data);
                    document.forms.sign_up_form.submit();
                } else {
                    alert(html_data);
                    return false;
                }
            }
        });
    }
}

jQuery('#countryobirth').change(function(){
    if(jQuery('#countryobirth').val()!='US' && jQuery('#countryobirth').val()!='CA') {
        jQuery('#statediv').hide('slow');
    } else {
        jQuery('#statediv').show('slow');
    }
});
var countryobirth = jQuery('#countryobirth').val();

if(countryobirth && (countryobirth == 'US' || countryobirth == 'CA')) {
    $('#statediv').show();
}

function profile_image_input()
{
    $('#file').click();
}


var fixed = 1;
var size = 160;

function ajaxFileUpload()
{
    $("#loading").ajaxStart(function(){
        $(this).show();
    }).ajaxComplete(function(){
        $(this).hide();
    });

    $.ajaxFileUpload({
        url: baseUrl + 'account/ajaxUpload/upload',
        secureuri:false,
        fileElementId:'file',
        dataType: 'json',
        success: function (data, status)
        {
            if(typeof(data.error) != 'undefined') {
                if(data.error != '') alert(data.error);
            } else {					
                $('#show_image_name').val(data.msg);
                $("#fname").val(data.msg); //get filename from the response
                $("#image").html($(document.createElement("img")).attr({src: baseUrl + "images/profile_image/"+data.msg,id:"jcrop", height: 160, width: 160})).show(); // create image and append the html inside <div id=#image>
            }
        }			
    })
    return false;
}

/* function jCrop(f)
*  used to initialize jCrop plugin
*  f = id of image on which jCrop should work
*  boxWidth = 475
* */
function jCrop(f) {
    $(f).Jcrop({
        onChange: updateCoords,
        onSelect: updateCoords,
        aspectRatio: 1,
        boxWidth: 475 //maximum width of image
    });
}

/*
 * function updateCoords(c)
 * updates the selection in jCrop image
 * also prepares live preview
 */

