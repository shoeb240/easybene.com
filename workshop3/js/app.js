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
            
    function welcomeSelection(showDentalVisionSites) {
        var token = window.localStorage.getItem('token');
        var token_expire = window.localStorage.getItem('token_expire');
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site = window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var funds_site = window.localStorage.getItem('funds_site');
        var unix = Math.round(+new Date()/1000);

        if (token_expire > unix) {
            if ((!medical_site || medical_site == 'null') && (!dental_site || dental_site == 'null') 
                    && (!vision_site || vision_site == 'null') && (!funds_site || funds_site == 'null')) {
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
    
}());