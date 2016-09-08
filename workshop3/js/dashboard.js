(function () {

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
        location.href = 'index.html';
    }
    
    function PrepareWelcomeData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site= window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var funds_site = window.localStorage.getItem('funds_site');
        
        if (!username || !token) return false;
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-summary/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                console.log(result);
                graph(result.medical_percent, result.medical_deductible_met, medical_site, 'medical', result.medical_deductible);
                graph(result.dental_percent, result.dental_deductible_met, dental_site, 'dental', result.dental_deductible);
                graph(result.vision_percent, result.vision_deductible_met, vision_site, 'vision', result.vision_deductible);
                
                
                
        if (!funds_site || funds_site == 'null' || funds_site == 'undefined') {
            $("#summary_link_funds").css("color", "#f8c572");
        } else {
            var image_name = funds_site.toLowerCase() + "_logo.jpg";
            $("#funds_image").attr("src", "images/" + image_name);
            $("#funds_image").css("border", "1px solid grey");
            $("#funds_image").css("padding", "2px");
            
            //$("#summary_link_funds").html('<a style="color: #14efef" href="' + funds_site + '-funds.html">HSA Funds</a>');
            $("#summary_link_funds").html('<a  style="color: #14efef;" href="funds.html">HSA Funds</a>');
        }
        
        
                
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
            },
        });
    }
    
    function graph(percent, deductible_met, site, site_type, deductible)
    {
        var site_lower = site.toLowerCase();
        var graph_id = "#"+site_type+"-circle";
        var image_id = "#"+site_type+"_image";
        var fontColor = "#14efef";
        var foregroundColor = "#14efef";
        
        if (!site || site == 'null' || site == 'undefined') {
            $(graph_id).parent().children("p.status-text").html("No Provider");
            $(graph_id).parent().addClass("orange-graph");
            fontColor = "#f8c572";
            foregroundColor = "#f8c572";
            percent = 0;
        } else {
            var image_name = site_lower + "_logo.jpg";
            $(image_id).attr("src", "images/" + image_name);
            $(image_id).css("border", "1px solid grey");
            $(image_id).css("padding", "2px");
            if (percent > 0) {
                $(graph_id).parent().children("p.status-text").html("Deductible <span>$" + deductible + "</span><br />Total Spent <span>$" + deductible_met + "</span>");
                $(graph_id).parent().removeClass("orange-graph");
                $("#summary_link_" + site_type).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html">' + site_type + '</a>');
            } else {
                $(graph_id).parent().children("p.status-text").html("Provider Pending");
                $(graph_id).parent().addClass("orange-graph");
                fontColor = "#f8c572";
                foregroundColor = "#f8c572";
                percent = 0;
            }
        }

        $(graph_id).circliful({
            animation: 0,
            animationStep: 6,
            foregroundBorderWidth: 2,
            backgroundBorderWidth: 2,
            backgroundColor: "#3c4447",
            foregroundColor: foregroundColor,
            fillColor: '#262e31',
            percent: percent,
            fontColor: fontColor,
            percentageTextSize: 30

        });
    }
    

}());