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

    function hideAll()
    {
        $('#deductible_div').css('display', 'none');
        $('#claim_div').css('display', 'none');
    }
    
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
                    console.log(result.claim_details);
                    if (result.claim_details[0]) {
                        $.each(result.claim_details, function(key, row) {
                            status = 'Pending';
                            cssclass = 'pending';
//                            if (row.status.search("Processed") >= 0) {
//                                status = 'Processed';
//                                cssclass = 'processed';
//                            }
                            $('#claim').append('<tr><td><p>'+row.claim_processed_on+'</p></td><td>'+row.for+'</td><td>'+row.service_amount_billed+'</td><td>'+row.service_what_i_owe+'</td><!--<td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></td>--></tr>');
                        });
                    } else {
                        $('#guardian-claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
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
    
    function makeLinkNormal()
    {
        $('#summary_link').css('font-weight', 'normal');
        $('#deductible_link').css('font-weight', 'normal');
        $('#claim_link').css('font-weight', 'normal');
    }
    
    function showDeductibleDiv()
    {
        hideAll();
        //makeLinkNormal();
        $('#deductible_div').css('display', 'block');
        //$('#deductible_link').css('font-weight', 'bold');
    }
    
    function showClaimDiv()
    {
        hideAll();
        //makeLinkNormal();
        $('#claim_div').css('display', 'block');
        //$('#claim_link').css('font-weight', 'bold');
    }
    
    
    $('#deductible_link').on('click', function() {
        showDeductibleDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
    });

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
    
    
}());