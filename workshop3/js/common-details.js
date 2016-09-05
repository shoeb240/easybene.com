// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        topTabLinks();
    });
    
    function topTabLinks()
    {
        medical_site = window.localStorage.getItem('medical_site').toLowerCase();
        dental_site= window.localStorage.getItem('dental_site').toLowerCase();
        vision_site = window.localStorage.getItem('vision_site').toLowerCase();

        if (medical_site && medical_site != 'null' && medical_site != 'undefined') {
            $("#top_tab_link_medical").on("click", function() {
                location.href = medical_site + "-medical.html";
            });
        }

        if (dental_site && dental_site != 'null' && dental_site != 'undefined') {
            $("#top_tab_link_dental").on("click", function() {
                location.href = dental_site + "-dental.html"
            });
        }

        if (vision_site && vision_site != 'null' && vision_site != 'undefined') {
            $("#top_tab_link_vision").on("click", function() {
                location.href = vision_site + "-vision.html"
            });
        }
    }
    
    
}());    