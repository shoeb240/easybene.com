// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            bottomMenu();
        }
    });
    
    function bottomMenu()
    {
        var medical_site = window.localStorage.getItem('medical_site').toLowerCase();
        var dental_site= window.localStorage.getItem('dental_site').toLowerCase();
        var vision_site = window.localStorage.getItem('vision_site').toLowerCase();
        
        if (medical_site && medical_site != 'null' && medical_site != 'undefined') {
            $("#bottom_link_medical").attr("href", medical_site + "-medical.html");
        }
        
        if (dental_site && dental_site != 'null' && dental_site != 'undefined') {
            $("#bottom_link_dental").attr("href", dental_site + "-dental.html");
        }
        
        if (vision_site && vision_site != 'null' && vision_site != 'undefined') {
            $("#bottom_link_vision").attr("href", vision_site + "-vision.html");
        }
    }
    //bottomMenu();
}());