// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    $('.logout').on('click', function() {
        ProcessLogout();
    });
    
    $('#hsa_details_link').on('click', function() {
        showTransactionActivityDiv();
    });
    
    function hideAll()
    {
        $('#hsa_summary_div').css('display', 'none');
        $('#hsa_transaction_activity_div').css('display', 'none');
    }

    hideAll();
    
    function GetFundsData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-funds/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    $('#hsa_checking_value').html(result.HS_balance);
                    $('#hsa_investment_value').html(result.portfolio_balance);
                    
                    if (result.transaction_activity[0]) {
                        $.each(result.transaction_activity, function(key, row) {
                            if (row.transaction_type) {
                                $('#hsa_transaction_activity_loop').append('<div class="row">' +
                                '<div class="col-md-4  text-left" style="float:left;">' +
                                    row.transaction_date +
                                '</div>' +
                                '<div class="col-md-4  text-left" style="float:left;">' +
                                    row.transaction_type +
                                '</div>' +
                                '<div class="col-md-4"  style="float:left;">' +
                                    row.transaction_amt +
                                '</div>' +
                            '</div>');
                            }
                        });
                    } else {
                        $('#hsa_transaction_activity_loop').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    
                    showHSASummaryDiv();
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    function showHSASummaryDiv()
    {
        hideAll();
        $('#hsa_summary_div').css('display', 'block');
    }
    
    function showTransactionActivityDiv()
    {
        hideAll();
        $('#hsa_transaction_activity_div').css('display', 'block');
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
    
    $('#hsa_transaction_activity_link').on('click', function() {
        showTransactionActivityDiv();
    });
    
    $('#hsa_summary_link').on('click', function() {
        showHSASummaryDiv();
    });
    
    GetFundsData();
    
    
    
}());