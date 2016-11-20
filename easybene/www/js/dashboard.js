(function () {

    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    var provider_execution = '';
    
    $(window).load(function(){
        if (username && token) {
            $(".medical-grap").css('display', 'none');
            $(".after-login-screen").css('display', 'block');
            $("#bz_text").html('Loading your dashboard information, this may take few seconds.');

            provider_execution = window.localStorage.getItem('provider_execution');
            //console.log(provider_execution);
            
            var medical_site = window.localStorage.getItem('medical_site');
            var dental_site= window.localStorage.getItem('dental_site');
            var vision_site = window.localStorage.getItem('vision_site');
            var funds_site = window.localStorage.getItem('funds_site');

            var user_data = '';
            if (medical_site && provider_execution && provider_execution.indexOf(medical_site.toLowerCase()) >= 0) {
                if (!user_data) {
                    user_data = GetUserData();
                }
                provider_execute(medical_site.toLowerCase(), 'medical', user_data);
            }
            if (dental_site && provider_execution && provider_execution.indexOf(dental_site.toLowerCase()) >= 0) {
                if (!user_data) {
                    user_data = GetUserData();
                }
                provider_execute(dental_site.toLowerCase(), 'dental', user_data);
            }
            if (vision_site && provider_execution && provider_execution.indexOf(vision_site.toLowerCase()) >= 0) {
                if (!user_data) {
                    user_data = GetUserData();
                }
                provider_execute(vision_site.toLowerCase(), 'vision', user_data);
            }
            if (funds_site && provider_execution && provider_execution.indexOf(funds_site.toLowerCase()) >= 0) {
                if (!user_data) {
                    user_data = GetUserData();
                }
                provider_execute(funds_site.toLowerCase(), 'funds', user_data);
            }
            
            PrepareWelcomeData();
            
            if (provider_execution) {
                $("#check_back_msg").css('display', 'block');
            }
            
            $(".medical-grap").css('display', 'block');
            $(".after-login-screen").css('display', 'none');
        } else {
            ShowLogin();
        }
    });

    function GetUserData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var result_data = '';

        $.ajax({
            url: 'https://easybene.com/index.php/api-user/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    result_data = result;
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                    ShowSitelRegFail();
                },
        });
        
        return result_data;
    }
        
    function ShowLogin() {
        location.href = 'index.html';
    }
    
    function provider_execute(provider_name, provider_type, user_data)
    {
        var response = '';
        var response_failed_ids = [];
        //var provider_execution = window.localStorage.getItem('provider_execution');
        var timed_run = false;
        
        $("#bz_text").html('Linking your providers, this may take a minute or two.');
        
        $.ajax({
            url: 'https://easybene.com/index.php/'+user_data.providersSelected[provider_type]['scrapper_script_path']+'/execute/'+username+'/'+token+'/'+user_data.providersSelected[provider_type]['id'],
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result){
                response = result.response;
                //console.log(response);
                if (response === 'OK') {
                    provider_execution = provider_execution.replace(provider_name+'~~', '');
                    window.localStorage.setItem('provider_execution', provider_execution);
                    //console.log(provider_execution);
                    if (timed_run === true) {
                        PrepareWelcomeData();
                        timed_run = false;
                    }
                } else if (response === 'QUEUED' || response === 'PENDING' || response === 'RUNNING') {
                    setTimeout(provider_execute, 570000, provider_name, provider_type, user_data); // will run after 9 min 30 sec
                    timed_run = true;
                } else if (response === 'FAILED' || response === 'STOPPED') {
                    provider_execution = provider_execution.replace(provider_name+'~~', '');
                    window.localStorage.setItem('provider_execution', provider_execution);
                    //console.log(provider_execution);
                    if (timed_run === true) {
                        PrepareWelcomeData();
                        timed_run = false;
                    }
                    //response_failed_ids = result.response_failed_ids;
                }
            },
            error: function(a, b, c){
                response = false; 
            }
        });

        //if (response_failed_ids) {
            //console.log(response_failed_ids);
            //save_failed_ids(response_failed_ids);
        //}
        
        //console.log(provider_execution);
        if (provider_execution !== '') {
            $("#check_back_msg").css('display', 'block');
        } else {
            $("#check_back_msg").css('display', 'none');
        }

        return response;
    }
    
    /*function save_failed_ids(response_failed_ids)
    {
        $.ajax({
            url: 'https://easybene.com/index.php/api-summary/'+username+'/'+token,
            type: 'post',
            data: 'response_failed_ids='+response_failed_ids,
            dataType: 'json',
            success: function(result){
                //console.log(result);
            },
            error: function(){
                
            }
        });
    }*/
        
    function PrepareWelcomeData() {
        //console.log('PrepareWelcomeData run');
        
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var medical_site = window.localStorage.getItem('medical_site');
        var dental_site= window.localStorage.getItem('dental_site');
        var vision_site = window.localStorage.getItem('vision_site');
        var funds_site = window.localStorage.getItem('funds_site');
        
        if (!username || !token) return false;
        $.ajax({
            url: 'https://easybene.com/index.php/api-summary/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                //console.log(result);
                graph(result.medical_percent, result.medical_deductible_met, medical_site, 'medical', result.medical_deductible, result.medical_data_exists);
                graph(result.dental_percent, result.dental_deductible_met, dental_site, 'dental', result.dental_deductible, result.dental_data_exists);
                graph(result.vision_percent, result.vision_deductible_met, vision_site, 'vision', result.vision_deductible, result.vision_data_exists);
                
                if (!funds_site || funds_site == 'null' || funds_site == 'undefined') {
                    $("#summary_link_funds").css("color", "#f8c572");
                } else {
                    var image_name = funds_site.toLowerCase() + "_logo.jpg";
                    //$("#summary_link_funds").html('<a style="color: #14efef" href="' + funds_site + '-funds.html">HSA Funds</a>');
                    $("#summary_link_funds").html('<a  style="color: #14efef;" href="funds.html">HSA Funds</a>');
                    $("#funds_image").html('<a style="color: #14efef" href="funds.html"><img style="height: 40px; border: 1px solid grey; padding: 2px; margin: 7px;" src="images/' + image_name + '" alt="" /></a>');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
            },
        });
        
    }
    
    function graph(percent, deductible_met, site, site_type, deductible, data_exists)
    {
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
            var site_lower = site.toLowerCase();
            var image_name = site_lower + "_logo.jpg";
            if (percent > 0) {
                $(graph_id).parent().children("p.status-text").html("Deductible <span>$" + deductible + "</span><br />Total Spent <span>$" + deductible_met + "</span>");
                $(graph_id).parent().removeClass("orange-graph");
                $("#summary_link_" + site_type).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html">' + site_type + '</a>');
                $(image_id).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html"><img style="height: 40px; border: 1px solid grey; padding: 2px; margin: 7px;" src="images/' + image_name + '" alt="" /></a>');
            } else if (data_exists !== 'yes') {
                $(graph_id).parent().children("p.status-text").html("Data Unavailable");
                $(graph_id).parent().addClass("orange-graph");
                $("#summary_link_" + site_type).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html">' + site_type + '</a>');
                $(image_id).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html"><img style="height: 40px; border: 1px solid grey; padding: 2px; margin: 7px;" src="images/' + image_name + '" alt="" /></a>');
                fontColor = "#f8c572";
                foregroundColor = "#f8c572";
                percent = 0;
            } else {
                $(graph_id).parent().children("p.status-text").html("Provider Pending");
                $(graph_id).parent().addClass("orange-graph");
                $("#summary_link_" + site_type).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html">' + site_type + '</a>');
                $(image_id).html('<a style="color: #14efef" href="' + site + '-' + site_type + '.html"><img style="height: 40px; border: 1px solid grey; padding: 2px; margin: 7px;" src="images/' + image_name + '" alt="" /></a>');
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