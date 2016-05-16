// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* ---------------------------------- Local Variables ---------------------------------- */
    var service = new EmployeeService();
    service.initialize("http://www.themercerpool.com/easybenefits2/api.php").done(function () {
        console.log("Service initialized");
    });

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    if (username) {
        var token = window.localStorage.getItem('token');
        var token_expire = window.localStorage.getItem('token_expire');
        var cigna_exists = window.localStorage.getItem('cigna_exists');
        var unix = Math.round(+new Date()/1000);
        if (token_expire > unix) {
            if (cigna_exists == 'yes') {
                ShowWelcome();
            } else {
                ShowSiteLinks();
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
    
    $('#cigna').on('click', function() {
        ShowCignaReg();
    });
    
    $('#cigna_register').on('click', function() {
        RegisterCigna();
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
        $('#site_credentials_div').css('display', 'none');   
        $('#cigna_reg_div').css('display', 'none');   
        $('#cigna_reg_fail_div').css('display', 'none');   
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
        
        var email_text = $('#email').val();
        $('#email_text').html(email_text);
    }
    
    function ShowWelcome() {
        hideAll(); 
        $('#welcome_div').css('display', 'block');
    }
    
    function ShowSiteLinks() {
        hideAll(); 
        $('#site_credentials_div').css('display', 'block');
    }
    
    function ShowCignaReg() {
        hideAll();
        $('#cigna_reg_div').css('display', 'block');
    }
    
    function ShowCignaRegFail() {
        hideAll();
        $('#cigna_reg_fail_div').css('display', 'block');
    }
    
    function ShowGuardianReg() {
        hideAll();
        $('#guardian_reg_div').css('display', 'block');
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
                    console.log(result);
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
                    console.log(result);
                    window.localStorage.setItem("username", email);
                    window.localStorage.setItem("token", result.token);
                    window.localStorage.setItem("token_expire", result.token_expire);
                    window.localStorage.setItem('cigna_exists', result.cigna_exists);
                    if (result.cigna_exists == 'yes') {
                        ShowWelcome();
                    } else {
                        ShowSiteLinks();
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
    
    function RegisterCigna() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var cigna_user_id = $('#cigna_user_id').val();
        var cigna_password = $('#cigna_password').val();
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-user/'+username+'/'+token,
            type: "POST",
            data: 'cigna_user_id='+cigna_user_id+'&cigna_password='+cigna_password,
            dataType: 'json',
            async: false,
            success: function(result) {
                    console.log(result);
                    window.localStorage.setItem('cigna_exists', result.cigna_exists);
                    if (result.cigna_exists == 'yes') {
                        ShowWelcome();
                    } else {
                        ShowSiteLinks();
                    }
                    ShowGuardianReg();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                    ShowCignaRegFail();
                },
        });
    }
    
}());