function createUploader(){
    var uploader = new qq.FileUploader({
        multiple: false,
        element: document.getElementById('file-uploader-demo1'),
        onProgress: function(id, fileName, loaded, total){$('#loading').show();},
        onComplete: function(id, fileName, responseJSON)
        {
            filenameServer = ''+responseJSON['filename']+'';
            //alert(filenameServer);
            //$('#show_image_name').val(filenameServer);
            $('.qq-upload-list').hide();
            $('#loading').hide();
            $("#image").html($(document.createElement("img")).attr({src: baseUrl + 'images/profile_image/' + filenameServer,id:"jcrop",height: 160, width: 160})).show();
            $('.upload_preview').show();
            $('#portfolio_image').val(filenameServer);
        },
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        action: baseUrl + 'scripts/without-flash-uploader/php.php'
    });
}
window.onload = createUploader;


function trigger_input()
{
    $('.qq-upload-button').addClass('qq-upload-button-hover');
    $('.qq-upload-button input[name=file]').click();
}

$(document).ready(function(){
    $('#portfolio_image').val(portfolio_image);
    $("#image").html($(document.createElement("img")).attr({src: baseUrl + "images/profile_image/" + portfolio_image,id:"jcrop",height: 160, width: 160})).show();
    $('.upload_preview').show();
});

function submit_portfolio_func()
{   
    var portfolio_title       = document.getElementById('portfolio_title').value;
    var client_name       = document.getElementById('client_name').value;
    var project_url = document.getElementById('project_url').value;
    var project_description = document.getElementById('project_description').value;

    if(portfolio_title=='') {
        alert('Please insert a title!');
        return false;
    } else if(client_name=='') {
        alert('Please insert client name!');
        return false;
    } else if(project_url=='') {
        alert('Please insert your client url!');
        return false;
    } else if(!is_valid_url(project_url)) {
        alert('Please insert a valid url!');
        return false;
    } else if(project_description=='') {
        alert('Please insert your project description!');
        return false;
    } else {
        document.forms.portfolio_edit_form.submit();
    }
}

function is_valid_url(url)
{
    return url.match(/^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/);
}
