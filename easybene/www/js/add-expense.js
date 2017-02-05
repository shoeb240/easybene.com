// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            var page = getQueryString('page');
            $('#name_div').html(username);
            $('#name').val(username);
            $('#name_document_div').html(username);
            $('#name_document').val(username);
            selectExpenseNote(page);
        } else {
            ShowLogin();
        }
    });

    $('#expense_type_button').on('click', function(){
        var exp_type = $('#expense_type_select').val();
        $('#expense_type').val(exp_type);   
        $('#expense_type_prompt').html(exp_type);
        $('#select-expense').modal('hide');
    });

    var getQueryString = function ( field ) {
        var href = window.location.href;
        var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
        var string = reg.exec(href);
        return string ? string[1] : null;
    };
    
    function ShowLogin() {
        location.href = 'index.html';
    }
    
    function selectExpenseNote(page) {
        if (page == 'document') {
            $('#note_div').css('display', 'block');
            $('#expense_div').css('display', 'none');
            $('#page').val('document');
        } else {
            $('#note_div').css('display', 'none');
            $('#expense_div').css('display', 'block');
            $('#page').val('expense');
        }
    }
    
    function setOptions(srcType) {
        var options = {
            // Some common settings are 20, 50, and 100
            quality: 50,
            destinationType: Camera.DestinationType.FILE_URI,
            // In this app, dynamically set the picture source, Camera or photo gallery
            sourceType: srcType,
            encodingType: Camera.EncodingType.JPEG,
            mediaType: Camera.MediaType.PICTURE,
            allowEdit: true,
            targetWidth: 100,
            targetHeight: 100,
            correctOrientation: true  //Corrects Android orientation quirks
        }
        return options;
    }

    function openCamera() {
        alert('opening camera');
        var srcType = Camera.PictureSourceType.CAMERA;
        var options = setOptions(srcType);

        navigator.camera.getPicture(cameraSuccess, cameraError, options);

        $('#cameraModal').modal('hide');
    }

    function fromLibrary() {
        alert('From library');
        var srcType = Camera.PictureSourceType.SAVEDPHOTOALBUM;
        var options = setOptions(srcType);

        navigator.camera.getPicture(cameraSuccess, cameraError, options);

        $('#cameraModal').modal('hide');
    }

    function cameraSuccess(imageUri) {

        alert(imageUri);

        uploaded_img_name = uploadPhoto(imageUri);

        displayImage(imageUri, uploaded_img_name);
    }

    function cameraError(error) {
        //console.debug("Unable to obtain picture: " + error, "app");
        alert("Unable to obtain picture: " + error);

    }

            // Below one succeeded
    function uploadPhoto(imageURI) {
        alert('in the function');
        var options = new FileUploadOptions();
        options.fileKey="file";
        options.fileName=imageURI.substr(imageURI.lastIndexOf('/')+1);
        options.mimeType="image/jpeg";
        alert('settings parms');
        //var params = new Object();
        var params = {};
        params.value1 = "img" + Date.now();
        params.value2 = "param";

        options.params = params;
        options.chunkedMode = false;
        alert('transferring...');

        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");

        var ft = new FileTransfer();
        ft.upload(imageURI, 'https://easybene.com/index.php/upload/'+username+'/'+token, win, fail, options);
        
        return params.value1;
    }

    function win(r) {
        alert(r.response);
    }

    function fail(error) {
        alert("An error has occurred: Code = " + error.code);
    }

    function displayImage(imgUri, uploaded_img_name) {
        var elem = '';
        var page = $('#page').val();
        
        if (page == 'expense') {
            elem = '<li><img src="'+imgUri+'" alt="expense"/></li>';
            $("#expenseImageFile").append(elem);
            $("#expense_image_name_list").val($("#expense_image_name_list").val() + ',' + uploaded_img_name);
        } else {
            elem = '<li><img src="'+imgUri+'" alt="document"/></li>';
            $("#documentImageFile").append(elem);
            $("#document_image_name_list").val($("#document_image_name_list").val() + ',' + uploaded_img_name);
        }
        
    }




    $('#save_expense').on('click', function () {
        if (validation_check_expense()) {
            SaveExpense();
        }
    });
    
    $('#save_document').on('click', function () {
        if (validation_check_document()) {
            SaveDocument();
        }
    });

    $('#expense_type').on("change", function () {
        show_ok();
    });
    
    $('#description').on("change", function () {
        show_ok();
    });
    
    $('#datepicker').on("change", function () {
        show_ok();
    });
    
    $('#amount').on("change", function () {
        show_ok();
    });
    
    $('#description_document').on("change", function () {
        show_ok();
    });
    
    function validation_check_expense(msg) {
        var valid = true;
        
        if ($('#expense_type').val() == '') {
            show_error();
            valid = false;
        } else if ($('#description').val().length < 2) {
            show_error();
            valid = false;
        } else if ($('#datepicker').val().length < 10) {
            show_error();
            valid = false;
        } else if ($('#amount').val() == '') {
            show_error();
            valid = false;
        } else {
            show_ok();
        }

        return valid;
    }
    
    function validation_check_document(msg) {
        var valid = true;
        
        if ($('#description_document').val().length < 2) {
            show_error();
            valid = false;
        } else {
            show_ok();
        }

        return valid;
    }

    function show_error(ths)
    {
        $("#error_after_submit").css("display", "block");
    }

    function show_ok(ths)
    {
        $("#error_after_submit").css("display", "none");
    }

    function SaveExpense() {
        var username = window.localStorage.getItem('username');
        var token = window.localStorage.getItem("token");

        var name = $('#name').val();
        var expense_type = $('#expense_type').val();
        var description = $('#description').val();
        var date = $('#datepicker').val();
        var amount = $('#amount').val();
        var additional_details = $('#additional_details').val();
        var image_list = $("#expense_image_name_list").val();

        $.ajax({
            url: 'https://easybene.com/index.php/api-expense/'+username+'/'+token,
            type: "POST",
            data: 'name=' + name + '&expense_type=' + expense_type + '&description=' + description + '&date=' + date + '&amount=' + amount + '&additional_details=' + additional_details + '&image_list=' + image_list,
            dataType: 'json',
            async: false,
            success: function (result) {
                location.href = "expense.html?page=expense";
            },
            error: function (xhr, textStatus, thrownError) {
            },
        });
    }
    
    function SaveDocument() {
        var username = window.localStorage.getItem('username');
        var token = window.localStorage.getItem("token");

        var name_document = $('#name_document').val();
        var description_document = $('#description_document').val();
        var additional_details_document = $('#additional_details_document').val();
        var image_list = $("#document_image_name_list").val();

        $.ajax({
            url: 'https://easybene.com/index.php/api-document/'+username+'/'+token,
            type: "POST",
            data: 'name=' + name_document + '&description=' + description_document + '&additional_details=' + additional_details_document + '&image_list=' + image_list,
            dataType: 'json',
            async: false,
            success: function (result) {
                location.href = "expense.html";
            },
            error: function (xhr, textStatus, thrownError) {
            },
        });
    }
    
    
}());