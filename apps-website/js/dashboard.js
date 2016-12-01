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
                console.log(result);
                graph(result.medical_percent, result.medical_deductible_met, medical_site, 'medical', result.medical_deductible, result.medical_data_exists);
                graph(result.dental_percent, result.dental_deductible_met, dental_site, 'dental', result.dental_deductible, result.dental_data_exists);
                graph(result.vision_percent, result.vision_deductible_met, vision_site, 'vision', result.vision_deductible, result.vision_data_exists);
                graph(result.funds_percent, result.funds_denominator, funds_site, 'funds', result.funds_nominator, result.funds_data_exists);
                graph(result.day_care_FSA_percent, result.day_care_FSA_denominator, funds_site, 'day_care_FSA', result.day_care_FSA_nominator, result.day_care_FSA_data_exists);
                graph(result.health_care_FSA_percent, result.health_care_FSA_denominator, funds_site, 'health_care_FSA', result.health_care_FSA_nominator, result.health_care_FSA_data_exists);
                
                $("#medical_site_name").html(medical_site.toUpperCase());
                $("#dental_site_name").html(dental_site.toUpperCase());
                
                GetMedicalData(medical_site);
                GetDentalData(dental_site);
                GetFundsData();
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
            $(graph_id).parent().find("span.deductible-text").html("No Provider");
            $(graph_id).parent().find("span.deductible-met-text").html("No Provider");
            $(graph_id).parent().addClass("orange-graph");
            fontColor = "#f8c572";
            foregroundColor = "#f8c572";
            percent = 0;
        } else {
            var site_lower = site.toLowerCase();
            var image_name = site_lower + "_logo.png";
            if (data_exists === 'yes') {
                $(graph_id).parent().find("span.deductible-text").html('$'+deductible);
                $(graph_id).parent().find("span.deductible-met-text").html('$'+deductible_met);
                $(graph_id).parent().removeClass("orange-graph");
                $(image_id).css("background", "url('images/"+image_name+"')");
            } else if (data_exists !== 'yes') {
                $(graph_id).parent().find("span.deductible-text").html("Unavailable");
                $(graph_id).parent().find("span.deductible-met-text").html("Unavailable");
                $(graph_id).parent().addClass("orange-graph");
                $(image_id).css("background", "url('images/"+image_name+"')");
                fontColor = "#f8c572";
                foregroundColor = "#f8c572";
                percent = 0;
            } /*else {
                $(graph_id).parent().find("span.deductible-text").html("Pending");
                $(graph_id).parent().find("span.deductible-met-text").html("Pending");
                $(graph_id).parent().addClass("orange-graph");
                $(image_id).css("background", "url('images/"+image_name+"')");
                //fontColor = "#f8c572";
                //foregroundColor = "#f8c572";
                fontColor = "#25cbf5";
                foregroundColor = "#25cbf5";
                percent = 0;
            }*/
        }

        $(graph_id).circliful({
            animation: 0,
            animationStep: 6,
            foregroundBorderWidth: 2,
            backgroundBorderWidth: 2,
            //backgroundColor: "#3c4447",
            backgroundColor: "#f9f9f9",
            foregroundColor: foregroundColor,
            //fillColor: '#262e31',
            fillColor: '#f9f9f9',
            percent: percent,
            fontColor: fontColor,
            percentageTextSize: 30

        });
    }
    
    function GetMedicalData(medical_site) {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var status = '';
        var cssclass = '';
        $.ajax({
            url: 'https://easybene.com/index.php/api-medical/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result.deductible_percent);
                    //console.log(result.deductible_amt);
                    //console.log(result.deductible_met);
                    
                    dyn_functions[medical_site+'_medical_table'](result);
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    function GetDentalData(dental_site) {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var status = '';
        var cssclass = '';
        $.ajax({
            url: 'https://easybene.com/index.php/api-dental/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result.claim);
                    dyn_functions[dental_site+'_dental_table'](result);
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    function GetFundsData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'https://easybene.com/index.php/api-funds/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    if (result.HS_balance === '' || result.HS_balance === null) {
                        result.HS_balance = 'Pending';
                        $('#hsa_checking_value').css('color', '#f8c572');
                        
                    }
                    if (result.portfolio_balance === '' || result.portfolio_balance === null) {
                        result.portfolio_balance = 'Pending';
                        $('#hsa_investment_value').css('color', '#f8c572');
                    }
                    $('#hsa_checking_value').html(result.HS_balance);
                    $('#hsa_investment_value').html(result.portfolio_balance);
                    
                    if (result.day_care_FSA[0]) {
                        $.each(result.day_care_FSA, function(key, row) {
                            
                            if (row.transaction_type) {
                                $('#day_care_FSA_loop').append('<tr><td>' +
                                    row.date_posted +
                                '</td><td>' +
                                    row.transaction_type +
                                '</td><td>' +
                                    row.claim_amount +
                                '</td><td>' +
                                    row.amount +
                                '</td></tr>');
                            }
                        });
                    } else {
                        $('#day_care_FSA_loop').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
                    if (result.health_care_FSA[0]) {
                        $.each(result.health_care_FSA, function(key, row) {
                            
                            if (row.transaction_type) {
                                $('#health_care_FSA_loop').append('<tr><td>' +
                                    row.date_posted +
                                '</td><td>' +
                                    row.transaction_type +
                                '</td><td>' +
                                    row.claim_amount +
                                '</td><td>' +
                                    row.amount +
                                '</td></tr>');
                            }
                        });
                    } else {
                        $('#health_care_FSA_loop').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
                    //showHSASummaryDiv();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    var dyn_functions = [];
    dyn_functions['cigna_medical_table'] = function (result) {
        if (result.claim_details[0]) {
            $.each(result.claim_details, function(key, row) {
                status = 'Pending';
                cssclass = 'pending';
                $('#medical_claim').append('<tr><td><p>'+row.claim_processed_on+'</p></td><td>'+row.for+'</td><td>'+row.service_amount_billed+'</td><td>'+row.service_what_i_owe+'</td><!--<td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></td>--></tr>');
            });
        } else {
            $('#medical_claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
        }
    }
    
    dyn_functions['anthem_medical_table'] = function (result) {
        if (result.claim_details[0]) {
            $.each(result.claim_details, function(key, row) {
                status = 'Pending';
                cssclass = 'pending';
                $('#medical_claim').append('<tr><td><p>'+row.date+'</p></td><td>'+row.for+'</td><td>'+row.total+'</td><td>'+row.member_responsibility+'</td><!--<td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></td>--></tr>');
            });
        } else {
            $('#medical_claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
        }
    }
    
    dyn_functions['guardian_dental_table'] = function (result) {
        if (result.claim[0]) {
            $.each(result.claim, function(key, row) {
                status = 'Pending';
                cssclass = 'pending';
                if (row.status.search("Processed") >= 0) {
                    status = 'Processed';
                    cssclass = 'processed';
                }
                $('#dental_claim').append('<tr><td>'+row.paid_date+'</td><td><p>'+row.patient_name+'</p></td><td>'+row.submitted_charges+'</td><td>'+row.i_owe+'</td><td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></tr>');
            });
        } else {
            $('#dental_claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
        }
    }
    

}());