// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();
    function hideAll()
    {
        $('#summary_div').css('display', 'none');
        $('#deductible_div').css('display', 'none');
        $('#claim_div').css('display', 'none');
    }

    function GetMedicalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-medical/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    console.log(result.claim_details);
                    $.each(result.medical_summary, function (key, row){
                        odd_even = key % 2 ? 'odd' : 'even';
                        $('#cigna-summary').append('<tr role="row" class="'+odd_even+'"><td>'+row.whos_covered+'</td><td>'+row.date_of_birth+'</td></tr>');
                    });
                    
                    $('#cigna-deductible').append('<tr role="row" class="'+odd_even+'"><td>'+result.deductible.deductible_amt+'</td><td>'+result.deductible.deductible_met+'</td><td>'+result.deductible.deductible_remaining+'</td></tr>');
                    
                    $('#cigna-out-of-pocket').append('<tr role="row" class="'+odd_even+'"><td>'+result.deductible.out_of_pocket_amt+'</td><td>'+result.deductible.out_of_pocket_amt+'</td><td>'+result.deductible.out_of_pocket_remaining+'</td></tr>');
                    
                    $.each(result.claim, function (key, row){
                        odd_even = key % 2 ? 'odd' : 'even';
                        $('#cigna-claim').append('<tr role="row" class="'+odd_even+'"><td>'+row.service_date+'</td><td>'+row.provided_by+'</td><td>'+row.amount_billed+'</td><td>'+row.my_account_paid+'</td><td>'+row.status+'</td></tr>');
                    });
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log(ajaxOptions);
                    console.log(thrownError);
                },
        });
    }
    
    GetMedicalData();
    hideAll();
    
    $('#summary_link').on('click', function() {
        hideAll();
        $('#summary_div').css('display', 'block');
    });
    
    $('#deductible_link').on('click', function() {
        hideAll();
        $('#deductible_div').css('display', 'block');
    });
    
    $('#claim_link').on('click', function() {
        hideAll();
        $('#claim_div').css('display', 'block');
    });
    
    
    
    
}());