// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    //alert(username+'=='+token);
    $(window).load(function(){
        if (username && token) {
            welcomeSelection(false);
        } 
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
        var funds_site = window.localStorage.getItem('funds_site');
        var unix = Math.round(+new Date()/1000);

        if (token_expire > unix) {
            /*if (typeof(medical_site) === 'undefined' || medical_site == 'null' || !medical_site) {
                ShowMedicalSiteLinks();
            } else if (showDentalVisionSites && (typeof(dental_site) === 'undefined' || dental_site == 'null' || !dental_site)) {
                ShowDentalSiteLinks();
            } else if (showDentalVisionSites && (typeof(vision_site) === 'undefined' || vision_site == 'null' || !vision_site)) {
                ShowVisionSiteLinks();
            } else if (showDentalVisionSites && (typeof(funds_site) === 'undefined' || funds_site == 'null' || !funds_site)) {
                ShowFundsSiteLinks();
            } else {
                ShowDashboard();
            }*/
            if (!medical_site && !dental_site && !vision_site && !funds_site) {
                ShowMedicalSiteLinks();
            } else {
                ShowDashboard();
            }
        } else {
            
        }
    }
    
    function ShowWelcome() {
        hideAll(); 
        PrepareWelcomeData();
        $('#welcome_div').css('display', 'block');
    }
    
    function ShowDashboard() {
        //PrepareWelcomeData();
        location.href = "dashboard.html";
    }
    
    function ShowMedicalSiteLinks() {
        location.href = "welcome.html";
    }
    
    function ShowDentalSiteLinks() {
        location.href = "welcome.html";
    }
    
    function ShowVisionSiteLinks() {
        location.href = "welcome.html";
    }
    
    function ShowFundsSiteLinks() {
        location.href = "welcome.html";
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
                    window.localStorage.setItem('funds_site', result.funds_site);
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
    
}());