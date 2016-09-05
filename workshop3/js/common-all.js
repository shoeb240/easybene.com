// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        sideMenu();
    });
    
    function sideMenu()
    {
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site= window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');

        var li_html = '<li><a href="welcome.html">Welcome</a></li>';
        li_html += '<li><a href="provider-login.html">Provider login</a></li>';
        li_html += '<li><a href="search-provider.html">Search Provider</a></li>';
        //li_html += '<li><a href="linking.html">Linking Account</a></li>';
        //li_html += '<li><a href="complete-linking.html">Complete Linking</a></li>';
        li_html += '<li><a href="dashboard.html">Dashboard</a></li>';
        if (medical_site && medical_site != 'null' && medical_site != 'undefined') {
            li_html += '<li><a href="' + medical_site.toLowerCase() + '-medical.html">Medical</a></li>';
        }
        if (dental_site && dental_site != 'null' && dental_site != 'undefined') {
            li_html += '<li><a href="' + dental_site.toLowerCase() + '-dental.html">Dental</a></li>';
        }

        if (vision_site && vision_site != 'null' && vision_site != 'undefined') {
            li_html += '<li><a href="' + vision_site.toLowerCase() + '-vision.html">Vision</a></li>';
        }
        li_html += '<li><a href="funds.html">Funds</a></li>';
        li_html += '<!--<li><a href="test.html">Graph</a></li>';
        li_html += '<li><a href="test-2.html">Table</a></li>-->';
        li_html += '<li><a href="test-3.html">ID Card</a></li>';
        li_html += '<li><a class="logout" href="logout.html">Logout</a></li>';

        $(".sb-menu").html(li_html);
    }
    
//    function ProcessLogout() {
//        window.localStorage.removeItem('username');
//        window.localStorage.removeItem('token');
//        window.localStorage.removeItem('token_expire');
//        window.localStorage.removeItem('medical_site');
//        window.localStorage.removeItem('dental_site');
//        window.localStorage.removeItem('vision_site');
//        
//        location.href = "index.html";
//    }
    
    $(".back-btn").on("click", function(){
        history.go(-1);
    });
    
    
}());    