// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            GetDentalData();
        } else {
            ShowLogin();
        }
    });

    function ShowLogin() {
        location.href = 'provider-login.html';
    }
    
    function GetDentalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var status = '';
        var cssclass = '';
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-medical/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    console.log(result.cigna_deductible_percent);
                    console.log(result.cigna_deductible_met);
                    console.log(result.cigna_out_of_pocket_percent);
                    console.log(result.cigna_out_of_pocket_met);
                    graph(result.cigna_deductible_percent, result.cigna_deductible_met, 'plan-deductible');
                    graph(result.cigna_out_of_pocket_percent, result.cigna_out_of_pocket_met, 'out-of-pocket');
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    function graph(percent, amount, graph_name)
    {
        var graph_id = "#"+graph_name+"-circle";
        var fontColor = "#14efef";
        var foregroundColor = "#14efef";
        
        if (percent > 0) {
            $(graph_id).parent().children("p.status-text").html("Total Spent <span>" + amount + "</span>");
            $(graph_id).parent().removeClass("orange-graph");
        } else {
            $(graph_id).parent().children("p.status-text").html("Provider Pending");
            $(graph_id).parent().addClass("orange-graph");
            fontColor = "#f8c572";
            foregroundColor = "#f8c572";
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
    
    
    $('#benefit_link').on('click', function() {
        showBenfitDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
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