// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            location.href = "dashboard.html";
        }
    });
            
    $('#login_next2').on('click', function() {
        ProcessLogin();
    });
    
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

                    location.href = "dashboard.html";
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    ShowLoginFail(xhr.responseJSON);
                },
        });
    }
    
    
}());