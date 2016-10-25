// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            //location.href = "dashboard.html";
        } else {
            location.href = "index.html";
        }
    });
            
}());