// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    
    if (username) {
        var token = window.localStorage.getItem('token');
        var token_expire = window.localStorage.getItem('token_expire');
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site = window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var unix = Math.round(+new Date()/1000);
        //alert(medical_site.length + '==' + dental_site);
        if (token_expire > unix) {
            if (medical_site === 'undefined' || medical_site === null) {
                ShowMedicalSiteLinks();
            } else if (dental_site === 'undefined' || dental_site === null) {
                ShowDentalSiteLinks();
            } else if (vision_site === 'undefined' || vision_site === null) {
                ShowVisionSiteLinks();
            } else {
                ShowWelcome();
            }
        } else {
            ShowLogin();
        }
        //alert(unix);
    } else {
        ShowReg(null);
    }
    
    $('#login_next1').on('click', function() {
        ShowLoginStep2();
    });
    
    $('#login_next2').on('click', function() {
        ProcessLogin();
    });
    
    $('#reg_next1').on('click', function() {
        ShowRegStep2();
    });
    
    $('#reg_next2').on('click', function() {
        ProcessReg();
    });
    
    $('.logout').on('click', function() {
        ProcessLogout();
    });
    
    $('#login').on('click', function() {
        ShowLogin();
    });
    
    $('#cigna_medical').on('click', function() {
        ShowSiteReg('Medical', 'Cigna', 'cigna_logo.jpg');
    });
    
    $('#anthem_medical').on('click', function() {
        ShowSiteReg('Medical', 'Anthem', 'anthem_logo.png');
    });
    
    $('#guardian_medical').on('click', function() {
        ShowSiteReg('Medical', 'Guardian', 'guardian_logo.jpg');
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
    
    $('#site_register').on('click', function() {
        RegisterSite();
    });
    
    /* ---------------------------------- Local Functions ---------------------------------- */
    /* function findByName() {
        service.findByName($('.search-key').val()).done(function (response) {
            rob = JSON.parse(response);
            var l = rob.rows.length;
            $('.employee-list').empty();
            var row;
            var m;
            for (var i = 0; i < l; i++) {
                row = rob.rows[i];
                m = row.length;
                $('.employee-list').append('<li>');
                for (var j = 2; j < m; j++) {
                    $('.employee-list').append("=="+row[j]+"==");
                }
                $('.employee-list').append('</li>');
            }
        });
    } */
    
    function hideAll() {
        $('#login_div_step1').css('display', 'none');
        $('#login_div_step2').css('display', 'none');
        $('#login_div_success').css('display', 'none');
        $('#login_div_fail').css('display', 'none');
        
        $('#reg_div_step1').css('display', 'none');
        $('#reg_div_step2').css('display', 'none');
        $('#reg_div_success').css('display', 'none');
        $('#reg_div_fail').css('display', 'none');
        
        $('#welcome_div').css('display', 'none');
        $('#site_choice_medical_div').css('display', 'none');   
        $('#site_choice_dental_div').css('display', 'none');   
        $('#site_choice_vision_div').css('display', 'none');   
        
        $('#site_reg_div').css('display', 'none');   
        $('#site_reg_fail_div').css('display', 'none');   
    }
    
    function ShowReg(error) {
        hideAll();
        $('#reg_step1_error_div').html(error);
        $('#reg_div_step1').css('display', 'block');
    }
    
    function ShowRegStep2() {
        hideAll();
        $('#reg_div_step2').css('display', 'block');
        
        var email_text = $('#email').val();
        $('#email_text').html(email_text);
    }
    
    function ShowRegSuccess() {
        hideAll();
        $('#reg_div_success').css('display', 'block');
    }
    
    function ShowRegFail() {
        hideAll();
        $('#reg_div_fail').css('display', 'block');
    }
    
    function ShowLogin() {
        hideAll(); 
        $('#login_div_step1').css('display', 'block');
    }
    
    function ShowLoginFail() {
        hideAll(); 
        $('#login_div_fail').css('display', 'block');
    }

    function ShowLoginStep2() {
        hideAll(); 
        $('#login_div_step2').css('display', 'block');
        
        var email_text = $('#login_email').val();
        $('#email_text').html(email_text);
    }
    
    function ShowWelcome() {
        hideAll(); 
        $('#welcome_div').css('display', 'block');
    }
    
    function ShowMedicalSiteLinks() {
        hideAll(); 
        $('#site_choice_medical_div').css('display', 'block');
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
    
    function ShowSitelRegFail() {
        hideAll();
        $('#site_reg_fail_div').css('display', 'block');
        $('#site_failed_type_name').html($('#site_selected_type_name').html());
        //$('#site_selected_name').html($('#site_selected_name').html());
        $('#site_failed_type_image').attr("src", $('#site_selected_type_image').attr("src"));
    }
    
    function ProcessReg() {
        var email = $('#reg_email').val();
        var password = $('#reg_password').val();
        async: false,
        $.ajax({
            url: 'http://www.easybene.com/index.php/auth',
            type: "POST",
            data: 'username='+email+'&password='+password,
            dataType: 'json',
            success: function(result) {
                    //console.log(result);
                    window.localStorage.setItem("username", email);
                    window.localStorage.setItem("token", result.token);
                    window.localStorage.setItem("token_expire", result.token_expire);
                    ShowRegSuccess();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    ShowRegFail();
                },
        });
    }

    function ProcessLogin() {
        var email = $('#login_email').val();
        var password = $('#login_password').val();
        $.ajax({
            url: 'http://www.easybene.com/index.php/auth',
            type: "POST",
            data: 'username='+email+'&password='+password,
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    window.localStorage.setItem("username", email);
                    window.localStorage.setItem("token", result.token);
                    window.localStorage.setItem("token_expire", result.token_expire);
                    window.localStorage.setItem('cigna_exists', result.cigna_exists);
                    if (result.cigna_exists == 'yes') {
                        ShowWelcome();
                    } else {
                        ShowMedicalSiteLinks();
                    }
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    ShowLoginFail();
                },
        });
    }
    
    function ProcessLogout() {
        window.localStorage.removeItem('username');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('token_expire');
        window.localStorage.removeItem('cigna_exists');
        ShowLogin();
    }
    
    function RegisterSite() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var site_type = $('#site_selected_type_name').html();
        var site_name = $('#site_selected_name').val();
        var site_user_id = $('#site_selected_user_id').val();
        var site_password = $('#site_selected_password').val();
        alert(site_name+'=='+site_user_id+'=='+site_password);
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
                    if (result.medical_site === 'undefined' || result.medical_site === null) {
                        ShowMedicalSiteLinks();
                    } else if (result.dental_site === 'undefined' || result.dental_site === null) {
                        ShowDentalSiteLinks();
                    } else if (result.vision_site === 'undefined' || result.vision_site === null) {
                        ShowVisionSiteLinks();
                    } else {
                        ShowWelcome();
                    }
                    //ShowGuardianReg();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                    ShowSitelRegFail();
                },
        });
    }
    
}());