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
                    //console.log(result.cigna_deductible_percent);
                    
                    $("#abc1").data('easyPieChart').update(result.cigna_deductible_percent);
                    $("#abc1 span").html(result.cigna_deductible_percent);

                    $("#abc2").data('easyPieChart').update(result.cigna_out_of_pocket_percent);
                    $("#abc2 span").html(result.cigna_out_of_pocket_percent);

                    $.each(result.claim, function (key, row){
                        odd_even = key % 2 ? 'odd' : 'even';
                        $('#cigna-claim').append('<tr role="row" class="'+odd_even+'"><td>'+row.service_date+'</td><td>'+row.for+'</td><td>'+row.amount_billed+'</td><td>'+row.what_i_owe+'</td><td>'+row.status+'</td></tr>');
                    });
                    
                    showDeductibleDiv();
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
        window.localStorage.removeItem('cigna_exists');
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
    });
    
}());