// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* --------------------------------- Event Registration -------------------------------- */
    //findByName();

    function GetMedicalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-medical/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    console.log(result.claim);
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
    
}());