// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            ShowWelcome();
        }
    });
            
    $('.logout').on('click', function() {
        ProcessLogout();
    });
    
    $('#dental_link').on('click', function() {
        ShowDentalSiteLinks();
    });
    
    $('#cigna_dental').on('click', function() {
        ShowSiteReg('Dental', 'Cigna', 'cigna_logo.jpg');
    });
    
    $('#anthem_dental').on('click', function() {
        ShowSiteReg('Dental', 'Anthem', 'anthem_logo.png');
    });
    
    $('#guardian_dental').on('click', function() {
        ShowSiteReg('Dental', 'Guardian', 'guardian_logo.jpg');
    });
    
    $('#cigna_vision').on('click', function() {
        ShowSiteReg('Vision', 'Cigna', 'cigna_logo.jpg');
    });
    
    $('#anthem_vision').on('click', function() {
        ShowSiteReg('Vision', 'Anthem', 'anthem_logo.png');
    });
    
    $('#guardian_vision').on('click', function() {
        ShowSiteReg('Vision', 'Guardian', 'guardian_logo.jpg');
    });
    
    $('#medical_register').on('click', function() {
        var site_type = 'Medical';
        var site_name = $('#medical_selected_name').val();
        var site_user_id = $('#medical_selected_user_id').val();
        var site_password = $('#medical_selected_password').val();

        RegisterSite(site_type, site_name, site_user_id, site_password);
    });
    
    $('#dental_register').on('click', function() {
        var site_type = 'Dental';
        var site_name = $('#dental_selected_name').val();
        var site_user_id = $('#dental_selected_user_id').val();
        var site_password = $('#dental_selected_password').val();

        RegisterSite(site_type, site_name, site_user_id, site_password);
    });
    
    $('#vision_register').on('click', function() {
        var site_type = 'Vision';
        var site_name = $('#vision_selected_name').val();
        var site_user_id = $('#vision_selected_user_id').val();
        var site_password = $('#vision_selected_password').val();

        RegisterSite(site_type, site_name, site_user_id, site_password);
    });
    
    $('#funds_register').on('click', function() {
        var site_type = 'Funds';
        var site_name = 'Navia'; //$('#funds_selected_name').val();
        var site_user_id = $('#funds_selected_user_id').val();
        var site_password = $('#funds_selected_password').val();

        RegisterSite(site_type, site_name, site_user_id, site_password);
    });
    
    function hideAll() {
        $('#welcome_div').css('display', 'none');
        $('#site_choice_dental_div').css('display', 'none');   
        $('#site_choice_vision_div').css('display', 'none');   
        
        $('#site_reg_div').css('display', 'none');   
        $('#site_reg_fail_div').css('display', 'none');   
    }
    
    function ShowWelcome() {
        GetUserData();
        hideAll(); 
        $('#welcome_div').css('display', 'block');
    }
    
    function ShowDentalSiteLinks() {
        hideAll(); 
        $('#site_choice_dental_div').css('display', 'block');
    }
    
    function ShowVisionSiteLinks() {
        hideAll(); 
        $('#site_choice_vision_div').css('display', 'block');
    }
    
    function ShowSiteReg(type, site, image) {
        hideAll();
        $('#site_reg_div').css('display', 'block');
        $('#site_selected_type_name').html(type);
        $('#site_selected_name').val(site);
        $('#site_selected_type_image').attr("src", "assets/images/" + image);
    }
    
     function ProcessLogout() {
        window.localStorage.removeItem('username');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('token_expire');
        window.localStorage.removeItem('medical_site');
        window.localStorage.removeItem('dental_site');
        window.localStorage.removeItem('vision_site');
        location.href = "index.html";
    }
    
    function GetUserData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-user/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    select_code = '<select id="medical_selected_name" class="form-control underline-input">' +
                                        '<option>--Select Provider--</option>';
                    if (result.medical_site == 'Cigna') {
                            medical_user_id = result.cigna_user_id;
                            medical_password = result.cigna_password;
                            select_code += '<option selected>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else if (result.medical_site == 'Anthem') {
                            medical_user_id = result.anthem_user_id;
                            medical_password = result.anthem_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option selected>Anthem</option>';
                    } else if (result.medical_site == 'Guardian') {
                            medical_user_id = result.guardian_user_id;
                            medical_password = result.guardian_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option selected>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else {
                        select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                    }
                    select_code += '</select>';
                    
                    $('#medical_provider_div').html(select_code);
                    $('#medical_selected_user_id').val(medical_user_id);
                    $('#medical_selected_password').val(medical_password);
                    
                    
                    select_code = '<select id="dental_selected_name" class="form-control underline-input">' +
                                        '<option>--Select Provider--</option>';
                    if (result.dental_site == 'Cigna') {
                            dental_user_id = result.cigna_user_id;
                            dental_password = result.cigna_password;
                            select_code += '<option selected>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else if (result.dental_site == 'Anthem') {
                            dental_user_id = result.anthem_user_id;
                            dental_password = result.anthem_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option selected>Anthem</option>';
                    } else if (result.dental_site == 'Guardian') {
                            dental_user_id = result.guardian_user_id;
                            dental_password = result.guardian_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option selected>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else {
                        select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                    }
                    select_code += '</select>';
                    
                    $('#dental_provider_div').html(select_code);
                    $('#dental_selected_user_id').val(dental_user_id);
                    $('#dental_selected_password').val(dental_password);
                    
                    
                    select_code = '<select id="vision_selected_name" class="form-control underline-input">' +
                                        '<option>--Select Provider--</option>';
                    if (result.vision_site == 'Cigna') {
                            vision_user_id = result.cigna_user_id;
                            vision_password = result.cigna_password;
                            select_code += '<option selected>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else if (result.vision_site == 'Anthem') {
                            vision_user_id = result.anthem_user_id;
                            vision_password = result.anthem_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option selected>Anthem</option>';
                    } else if (result.vision_site == 'Guardian') {
                            vision_user_id = result.guardian_user_id;
                            vision_password = result.guardian_password;
                            select_code += '<option>Cigna</option>' +
                                           '<option selected>Guardian</option>' +
                                           '<option>Anthem</option>';
                    } else {
                            select_code += '<option>Cigna</option>' +
                                           '<option>Guardian</option>' +
                                           '<option>Anthem</option>';
                        
                    }
                    select_code += '</select>';
                    
                    $('#vision_provider_div').html(select_code);
                    $('#vision_selected_user_id').val(vision_user_id);
                    $('#vision_selected_password').val(vision_password);
                    
                    funds_user_id = result.navia_user_id;
                    funds_password = result.navia_password;
                    //$('#funds_provider_div').html(select_code);
                    $('#funds_selected_user_id').val(funds_user_id);
                    $('#funds_selected_password').val(funds_password);
                    //welcomeSelection();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                    ShowSitelRegFail();
                },
        });
    }
    
    function RegisterSite(site_type, site_name, site_user_id, site_password) {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-user/'+username+'/'+token,
            type: "POST",
            data: 'site_name='+site_name+'&site_type='+site_type+'&site_user_id='+site_user_id+'&site_password='+site_password,
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    window.localStorage.setItem('medical_site', result.medical_site);
                    window.localStorage.setItem('dental_site', result.dental_site);
                    window.localStorage.setItem('vision_site', result.vision_site);
                    
                    $("#" + site_type.toLowerCase() + "_success").css('color', 'blue');
                    $("#" + site_type.toLowerCase() + "_success").html('Successfully Updated');
                    
                    ShowWelcome();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                    $("#" + site_type.toLowerCase() + "_success").css('color', 'red');
                    $("#" + site_type.toLowerCase() + "_success").html('Update Failed');
                },
        });
    }
    
    
}());