// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    $('.logout').on('click', function() {
        ProcessLogout();
    });
    
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
                    //console.log(result.claim);
                    $.each(result.claim, function(key, row) {
                        $('#guardian-claim').append('<tr role="row"><td>'+row.paid_date+'</td><td>'+row.patient_name+'</td><td>'+row.submitted_charges+'</td><td>'+row.i_owe+'</td><td>'+row.status+'</td></tr>');
                    });
                    showClaimDiv();
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
    
    $('#benefit_link').on('click', function() {
        showBenfitDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
    });
    
    GetDentalData();
    
    
    
}());