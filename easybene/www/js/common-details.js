// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        topTabLinks();
    });
    
    function topTabLinks()
    {
        medical_site = window.localStorage.getItem('medical_site');
        dental_site= window.localStorage.getItem('dental_site');
        vision_site = window.localStorage.getItem('vision_site');
        funds_site = window.localStorage.getItem('funds_site');

        if (medical_site && medical_site != 'null' && medical_site != 'undefined') {
            $("#top_tab_link_medical, #medical_bottom_link").on("click", function() {
                location.href = medical_site + "-medical.html";
            });
        }

        if (dental_site && dental_site != 'null' && dental_site != 'undefined') {
            $("#top_tab_link_dental, #dental_bottom_link").on("click", function() {
                location.href = dental_site + "-dental.html"
            });
        }

        if (vision_site && vision_site != 'null' && vision_site != 'undefined') {
            $("#top_tab_link_vision, #vision_bottom_link").on("click", function() {
                //location.href = vision_site + "-vision.html"
                $('#top_tab_link_vision').blur();
            });
        }

        if (funds_site && funds_site != 'null' && funds_site != 'undefined') {
            $("#funds_bottom_link").on("click", function() {
                //location.href = funds_site + "-funds.html";
                location.href = "funds.html"
            });
        }
    }
    
    
}());    