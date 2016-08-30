(function () {

    hideAll(); 
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
           PrepareWelcomeData();
        } else {
            ShowLogin();
        }
    });

    function ShowLogin() {
        location.hrf = 'provider-login.html';
    }
    
    function PrepareWelcomeData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site= window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        
        if (!username || !token) return false;
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-summary/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                //console.log(result);
                $("#medical_chart").data('easyPieChart').update(result.medical_percent);
                
                if (!medical_site || medical_site == 'null' || medical_site == 'undefined') {
                //if (!result.medical_site) {
                    $("#medical_chart span").html('No Provider');
                } else {
                    var medical_image_name = medical_site.toLowerCase() + "_logo.jpg";
                    $("#medical_image").attr("src", "assets/images/" + medical_image_name);
                    if (result.medical_percent > 0) {
                        $("#medical_chart span").html(result.medical_percent+'%');
                    } else {
                        $("#medical_chart span").html('Pending');
                    }
                }
                
                $("#dental_chart").data('easyPieChart').update(result.dental_percent);
                if (!dental_site || dental_site == 'null' || dental_site == 'undefined') {
                //if (!result.dental_site) {
                    $("#dental_chart span").html('No Provider');
                } else {
                    var dental_image_name = dental_site.toLowerCase() + "_logo.jpg";
                    $("#dental_image").attr("src", "assets/images/" + dental_image_name);
                    if (result.dental_percent > 0) {
                        $("#dental_chart span").html(result.dental_percent+'%');
                    } else {
                        $("#dental_chart span").html('Pending');
                    }
                }
                
                $("#vision_chart").data('easyPieChart').update(0);
                if (!vision_site || vision_site == 'null' || vision_site == 'undefined') {
                //if (!result.vision_site) {
                    $("#vision_chart span").html('No Provider');
                } else {
                    var vision_image_name = vision_site.toLowerCase() + "_logo.jpg";
                    $("#vision_image").attr("src", "assets/images/" + vision_image_name);
                    if (!1) { // TODO
                        $("#vision_chart span").html(result.dental_percent+'%');
                    } else {
                        $("#vision_chart span").html('Pending');
                    }
                }
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
            },
        });
    }
    
    
}());