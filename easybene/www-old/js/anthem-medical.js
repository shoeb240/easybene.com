// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            $("#top_tab_link_medical").addClass("active");
            $("#top_tab_link_dental").removeClass("active");
            $("#top_tab_link_vision").removeClass("active");
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
        location.href = 'index.html';
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
                    //console.log(result.deductible_percent);
                    //console.log(result.deductible_amt);
                    //console.log(result.deductible_met);
                    //console.log(result.out_of_pocket_percent);
                    //console.log(result.out_of_pocket_amt);
                    //console.log(result.out_of_pocket_met);
                    if (result.claim_details[0]) {
                        $.each(result.claim_details, function(key, row) {
                            status = 'Pending';
                            cssclass = 'pending';
//                            if (row.status.search("Processed") >= 0) {
//                                status = 'Processed';
//                                cssclass = 'processed';
//                            }
                            $('#claim').append('<tr><td><p>'+row.date+'</p></td><td>'+row.for+'</td><td>'+row.total+'</td><td>'+row.member_responsibility+'</td><!--<td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></td>--></tr>');
                        });
                    } else {
                        $('#claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
                    graph(result.deductible_percent, result.deductible_met, 'plan-deductible', result.deductible_amt);
                    graph(result.out_of_pocket_percent, result.out_of_pocket_met, 'out-of-pocket', result.out_of_pocket_amt);
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

    function graph(percent, deductible_met, graph_name, deductible_amt)
    {
        var graph_id = "#"+graph_name+"-circle";
        var fontColor = "#14efef";
        var foregroundColor = "#14efef";
        
        if (percent > 0) {
            $(graph_id).parent().children("p.status-text").html("Deductible <span>" + deductible_amt + "</span><br />Total Spent <span>" + deductible_met + "</span>");
            $(graph_id).parent().removeClass("orange-graph");
        } else {
            $(graph_id).parent().children("p.status-text").html("Provider Pending");
            $(graph_id).parent().addClass("orange-graph");
            $(graph_id).parent().children("p").css("color", "#f8c572");
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