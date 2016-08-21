// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    $('.logout').on('click', function() {
        ProcessLogout();
    });
    
    function hideAll()
    {
        $('#summary_div').css('display', 'none');
        $('#deductible_div').css('display', 'none');
        $('#claim_div').css('display', 'none');
    }
    
    hideAll();

    function GetMedicalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-medical/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);

                    $("#abc1").data('easyPieChart').update(result.deductible_percent);
                    $("#abc1 span").html(result.deductible_percent+'%');
                    if (result.deductible_percent > 0) {
                        $("#abc1_dollar").html('$'+result.CD_deductible_in_net_family_accumulate);
                    } else {
                        $("#abc1_dollar").html('Pending');
                    }

                    $("#abc2").data('easyPieChart').update(result.out_of_pocket_percent);
                    $("#abc2 span").html(result.out_of_pocket_percent+'%');
                    if (result.out_of_pocket_percent) {out_of_pocket_percent
                        $("#abc2_dollar").html('$'+result.CD_out_pocket_in_net_family_accumulate);
                    } else {
                        $("#abc2_dollar").html('Pending');
                    }

                    if (result.claim_details[0]) {
                        $.each(result.claim_details, function (key, row){
                            odd_even = key % 2 ? 'odd' : 'even';
                            $('#cigna-claim').append('<tr role="row" class="'+odd_even+'"><td>'+row.date+'</td><td>'+row.for+'</td><td>'+row.total+'</td><td>'+row.member_responsibility+'</td><!--<td>'+row.status+'</td>--></tr>');
                        });
                    } else {
                        $('#cigna-claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
                    showClaimDiv();
                    //showDeductibleDiv(); // remove
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
    
    function showSummaryDiv()
    {
        hideAll();
        makeLinkNormal();
        $('#summary_div').css('display', 'block');
        $('#summary_link').css('font-weight', 'bold');
    }
    
    function showDeductibleDiv()
    {
        hideAll();
        makeLinkNormal();
        $('#deductible_div').css('display', 'block');
        $('#deductible_link').css('font-weight', 'bold');
    }
    
    function showClaimDiv()
    {
        hideAll();
        makeLinkNormal();
        $('#claim_div').css('display', 'block');
        $('#claim_link').css('font-weight', 'bold');
    }
    
    function ProcessLogout() {
        window.localStorage.removeItem('username');
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('token_expire');
        window.localStorage.removeItem('medical_site');
        window.localStorage.removeItem('dental_site');
        window.localStorage.removeItem('vision_site');
        location.href = "index.html";
    }
    
    $('#summary_link').on('click', function() {
        showSummaryDiv();
    });
    
    $('#deductible_link').on('click', function() {
        showDeductibleDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
    });
    
    $(window).load(function(){
        GetMedicalData();
        topTabLinks();
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