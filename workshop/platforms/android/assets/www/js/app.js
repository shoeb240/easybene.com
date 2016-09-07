// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        alert("cxvx");
        if (username && token) {
            welcomeSelection(false);
            alert("dsf");
            //summaryLinks();
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
    
    $('#do_search_link_medical').on('click', function() {
        var name = $("#medical_search_chosen .search-choice span").html();
        var image_name = name.toLowerCase() + "_logo.jpg";
        ShowSiteReg('Medical', name, image_name);
    });
    
    $('#do_search_link_dental').on('click', function() {
        var name = $("#dental_search_chosen .search-choice span").html();
        var image_name = name.toLowerCase() + "_logo.jpg";
        ShowSiteReg('Dental', name, image_name);
    });
    
    $('#do_search_link_vision').on('click', function() {
        var name = $("#vision_search_chosen .search-choice span").html();
        var image_name = name.toLowerCase() + "_logo.jpg";
        ShowSiteReg('Vision', name, image_name);
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
    
    function welcomeSelection(showDentalVisionSites) {
        var token = window.localStorage.getItem('token');
        var token_expire = window.localStorage.getItem('token_expire');
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site = window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var unix = Math.round(+new Date()/1000);
        if (token_expire > unix) {
            if (typeof(medical_site) === 'undefined' || medical_site == 'null' || !medical_site) {
                //ShowMedicalSiteLinks();
                ShowWelcome(); // remove
            } else if (showDentalVisionSites && (typeof(dental_site) === 'undefined' || dental_site == 'null' || !dental_site)) {
                ShowDentalSiteLinks();
            } else if (showDentalVisionSites && (typeof(vision_site) === 'undefined' || vision_site == 'null' || !vision_site)) {
                ShowVisionSiteLinks();
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
        if (msg != '') {
            $('#reg_span_fail').html(msg);
        }
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

                    welcomeSelection(true);
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

                    welcomeSelection(false);
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
                    welcomeSelection(true);
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
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site= window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        
        if (!username || !token) return false;
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-summary/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                //console.log(result);
                $("#medical_chart").data('easyPieChart').update(result.medical_percent);
                
                if (!medical_site || medical_site == 'null' || medical_site == 'undefined') {
                //if (!result.medical_site) {
                    $("#medical_chart span").html('No Provider');
                } else {
                    var medical_image_name = medical_site.toLowerCase() + "_logo.jpg";
                    $("#medical_image").attr("src", "assets/images/" + medical_image_name);
                    if (result.medical_percent > 0) {
                        $("#medical_chart span").html(result.medical_percent+'%');
                    } else {
                        $("#medical_chart span").html('Pending');
                    }
                }
                
                $("#dental_chart").data('easyPieChart').update(result.dental_percent);
                if (!dental_site || dental_site == 'null' || dental_site == 'undefined') {
                //if (!result.dental_site) {
                    $("#dental_chart span").html('No Provider');
                } else {
                    var dental_image_name = dental_site.toLowerCase() + "_logo.jpg";
                    $("#dental_image").attr("src", "assets/images/" + dental_image_name);
                    if (result.dental_percent > 0) {
                        $("#dental_chart span").html(result.dental_percent+'%');
                    } else {
                        $("#dental_chart span").html('Pending');
                    }
                }
                
                $("#vision_chart").data('easyPieChart').update(0);
                if (!vision_site || vision_site == 'null' || vision_site == 'undefined') {
                //if (!result.vision_site) {
                    $("#vision_chart span").html('No Provider');
                } else {
                    var vision_image_name = vision_site.toLowerCase() + "_logo.jpg";
                    $("#vision_image").attr("src", "assets/images/" + vision_image_name);
                    if (!1) { // TODO
                        $("#vision_chart span").html(result.dental_percent+'%');
                    } else {
                        $("#vision_chart span").html('Pending');
                    }
                }
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
            },
        });
    }
    
    function summaryLinks()
    {
        medical_site = window.localStorage.getItem('medical_site').toLowerCase();
        dental_site= window.localStorage.getItem('dental_site').toLowerCase();
        vision_site = window.localStorage.getItem('vision_site').toLowerCase();
        
        if (medical_site && medical_site != 'null' && medical_site != 'undefined') {
            $("#summary_link_medical").attr("href", medical_site + "-medical.html");
        }
        
        if (dental_site && dental_site != 'null' && dental_site != 'undefined') {
            $("#summary_link_dental").attr("href", dental_site + "-dental.html");
        }
        
        if (vision_site && vision_site != 'null' && vision_site != 'undefined') {
            $("#summary_link_vision").attr("href", vision_site + "-vision.html");
        }
    }
    
}());