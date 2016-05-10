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

            $('#cover_image').val(filenameServer);

            $.ajax({
                type: "POST",
                url: baseUrl + 'account/update_cover',
                data:
                {
                    'cover_image':filenameServer
                },
                success: function(html_data)
                {
                    if (html_data == 'COVER_UPDATED') {
                        $("#cover_image_span").html($(document.createElement("img")).attr({src: baseUrl + "images/profile_image/"+filenameServer,id:"jcrop",height: 385, width: 980})).show();
                        $('#loading').hide();
                        return false;
                    } else if(html_data == 'COVER_NOT_UPDATED') {
                        alert('Something went wrong.');
                    }
                }
            });

        },
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        action: baseUrl+'scripts/without-flash-uploader/php.php'
    });
}
window.onload = createUploader;


$(document).ready(function() {
    $(".fancybox").fancybox({
        'width': 830,
        'autoScale': false,
        'type': 'iframe'
    });
});

$(function() {
    $(".portfolio_gal").jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
});

 