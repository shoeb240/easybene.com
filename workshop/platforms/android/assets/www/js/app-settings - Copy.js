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
    
    $('#site_register').on('click', function() {
        RegisterSite();
    });
    
    function hideAll() {
        $('#welcome_div').css('display', 'none');
        $('#site_choice_dental_div').css('display', 'none');   
        $('#site_choice_vision_div').css('display', 'none');   
        
        $('#site_reg_div').css('display', 'none');   
        $('#site_reg_fail_div').css('display', 'none');   
    }
    
    function ShowWelcome() {
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
    
    function ShowSitelRegFail() {
        hideAll();
        $('#site_reg_fail_div').css('display', 'block');
        $('#site_failed_type_name').html($('#site_selected_type_name').html());
        $('#site_failed_type_image').attr("src", $('#site_selected_type_image').attr("src"));
    }
    
    function ProcessLogout() {
        window.localStorage.removeItem('username');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('token_expire');
        window.localStorage.removeItem('cigna_exists');
        window.localStorage.removeItem('medical_site');
        window.localStorage.removeItem('dental_site');
        window.localStorage.removeItem('vision_site');
        location.href = 'index.php';
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
                    ShowWelcome();
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