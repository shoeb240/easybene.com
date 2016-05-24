// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();
    function hideAll()
    {
        $('#benefit_div').css('display', 'none');
        $('#claim_div').css('display', 'none');
    }

    function GetDentalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-dental/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    console.log(result.benefit);
                    $.each(result.benefit, function (key, row){
                        odd_even = key % 2 ? 'odd' : 'even';
                        $('#guardian-benefit').append('<tr role="row" class="'+odd_even+'"><td>'+row.company_name+'</td><td>'+row.name+'</td><td>'+row.relationship+'</td><td>'+row.coverage+'</td><td>'+row.original_effective_date+'</td></tr>');
                    });
                    
                    $.each(result.claim, function (key, row){
                        odd_even = key % 2 ? 'odd' : 'even';
                        $('#guardian-claim').append('<tr role="row" class="'+odd_even+'"><td>'+row.coverage_type+'</td><td>'+row.patient_name+'</td><td>'+row.paid_date+'</td><td>'+row.amount_paid+'</td></tr>');
                    });
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                },
        });
    }
    
    GetDentalData();
    hideAll();
    
    $('#benefit_link').on('click', function() {
        hideAll();
        $('#benefit_div').css('display', 'block');
    });
    
    $('#claim_link').on('click', function() {
        hideAll();
        $('#claim_div').css('display', 'block');
    });
    
    
    
    
}());