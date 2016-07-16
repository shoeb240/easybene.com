// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            welcomeSelection();
            //ShowMedicalSiteLinks(); // remove
        } else {
            ShowReg(null);
        }
    });
            


    $('#login_next1').on('click', function() {
        ShowLoginStep2();
    });
    
    $('#login_next2').on('click', function() {
        ProcessLogin();
    });
    
    $('#show_reg').on('click', function() {
        ShowReg('');
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
    
    $('#cigna_medical_search').on('change', function() {
        //ShowSiteReg('Medical', 'Cigna', 'cigna_logo.jpg');
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
    
    $('#skip_dental').on('click', function() {
        ShowVisionSiteLinks();
    });
    
    $('#skip_vision').on('click', function() {
        ShowWelcome();
    });
    
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
        
        $('#reg_div_success').css('display', 'none');
        //$('#reg_span_succ').css('display', 'none');
        $('#reg_span_fail').css('display', 'none');
        $('#login_span_fail').html('');   
    }
    
    function welcomeSelection() {
        var token = window.localStorage.getItem('token');
        var token_expire = window.localStorage.getItem('token_expire');
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site = window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var unix = Math.round(+new Date()/1000);
        if (token_expire > unix) {
            if (typeof(medical_site) === 'undefined' || medical_site == 'null' || !medical_site) {
                ShowMedicalSiteLinks();
            //} else if (typeof(dental_site) === 'undefined' || dental_site == 'null' || !dental_site) {
            //    ShowDentalSiteLinks();
            //} else if (typeof(vision_site) === 'undefined' || vision_site == 'null' || !vision_site) {
            //    ShowVisionSiteLinks();
            } else {
                ShowWelcome();
            }
        } else {
            ShowLogin();
        }
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
    
    function ShowRegFail(msg) {
        hideAll();
        $('#reg_div_step1').css('display', 'block');
        $('#reg_span_fail').css('display', 'block');
    }
    
    function ShowLogin() {
        hideAll(); 
        $('#login_div_step1').css('display', 'block');
    }
    
    function ShowLoginFail(msg) {
        hideAll(); 
        $('#login_div_step1').css('display', 'block');
        $('#login_span_fail').html(msg);
    }

    //function ShowLoginRegSucc() {
    //    hideAll(); 
    //    $('#reg_span_succ').css('display', 'block');
    //    $('#login_div_step1').css('display', 'block');
    //}

    function ShowLoginStep2() {
        hideAll(); 
        $('#login_div_step2').css('display', 'block');
        
        var email_text = $('#login_email').val();
        $('#email_text').html(email_text);
    }
    
    function ShowWelcome() {
        hideAll(); 
        PrepareWelcomeData();
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
        $('#site_failed_type_image').attr("src", $('#site_selected_type_image').attr("src"));
    }
    
    function ProcessReg() {
        var email = $('#reg_email').val();
        var password = $('#reg_password').val();
        async: false,
        $.ajax({
            url: 'http://www.easybene.com/index.php/auth/register',
            type: "POST",
            data: 'username='+email+'&password='+password,
            dataType: 'json',
            success: function(result) {
                    //console.log(result);
                    //ShowLoginRegSucc();
                    window.localStorage.setItem("username", email);
                    window.localStorage.setItem("token", result.token);
                    window.localStorage.setItem("token_expire", result.token_expire);

                    welcomeSelection();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    ShowRegFail(xhr.responseJSON);
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
                    window.localStorage.setItem('medical_site', result.medical_site);
                    window.localStorage.setItem('dental_site', result.dental_site);
                    window.localStorage.setItem('vision_site', result.vision_site);

                    welcomeSelection();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    ShowLoginFail(xhr.responseJSON);
                },
        });
    }
    
    function ProcessLogout() {
        window.localStorage.removeItem('username');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('token_expire');
        window.localStorage.removeItem('medical_site');
        window.localStorage.removeItem('dental_site');
        window.localStorage.removeItem('vision_site');
        ShowLogin();
    }
    
    function RegisterSite() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var site_type = $('#site_selected_type_name').html();
        var site_name = $('#site_selected_name').val();
        var site_user_id = $('#site_selected_user_id').val();
        var site_password = $('#site_selected_password').val();
        
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
                    welcomeSelection();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                    ShowSitelRegFail();
                },
        });
    }
    
    function PrepareWelcomeData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        if (!username || !token) return false;
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-summary/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                //console.log(result.guardian_percent);
                $("#abc1").data('easyPieChart').update(result.cigna_percent);
                if (result.cigna_percent > 0) {
                    $("#abc1 span").html(result.cigna_percent+'%');
                } else {
                    $("#abc1 span").html('Pending');
                }
                
                $("#abc2").data('easyPieChart').update(result.guardian_percent);
                if (result.guardian_percent > 0) {
                    $("#abc2 span").html(result.guardian_percent+'%');
                } else {
                    $("#abc2 span").html('Pending');
                }
                
                $("#abc3").data('easyPieChart').update(0);
                if (!1) { // TODO
                    $("#abc3 span").html(result.guardian_percent+'%');
                } else {
                    $("#abc3 span").html('Pending');
                }

                //ShowWelcome();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
}());