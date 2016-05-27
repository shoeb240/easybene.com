// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();
    function hideAll()
    {
        $('#benefit_div').css('display', 'none');
        $('#claim_div').css('display', 'none');
    }

    hideAll();
    
    function GetDentalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-dental/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result.benefit);
                    $('#guardian-benefit').append('<tr role="row"><td>'+result.benefit.company_name+'</td><td>'+result.benefit.name+'</td><td>'+result.benefit.relationship+'</td><td>'+result.benefit.coverage+'</td></tr>'); // <td>'+result.benefit.original_effective_date+'</td>
                    $('#guardian-claim').append('<tr role="row"><td>'+result.claim.coverage_type+'</td><td>'+result.claim.patient_name+'</td><td>'+result.claim.paid_date+'</td><td>'+result.claim.amount_paid+'</td></tr>');
                    showBenfitDiv();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    function showBenfitDiv()
    {
        hideAll();
        $('#benefit_div').css('display', 'block');
        $('#benefit_link').css('font-weight', 'bold');
        $('#claim_link').css('font-weight', 'normal');
    }
    
    function showClaimDiv()
    {
        hideAll();
        $('#claim_div').css('display', 'block');
        $('#claim_link').css('font-weight', 'bold');
        $('#benefit_link').css('font-weight', 'normal');
    }
    
    $('#benefit_link').on('click', function() {
        showBenfitDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
    });
    
    GetDentalData();
    
    
    
}());