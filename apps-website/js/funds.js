// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    $(window).load(function(){
        if (username && token) {
            GetFundsData();
        } else {
            ShowLogin();
        }
    });

    hideAll();

    function ShowLogin() {
        location.href = 'index.html';
    }
    
    $('#hsa_details_link').on('click', function() {
        showTransactionActivityDiv();
    });
    
    function hideAll()
    {
        $('#hsa_summary_div').css('display', 'none');
        $('#hsa_transaction_activity_div').css('display', 'none');
    }

    function GetFundsData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        $.ajax({
            url: 'https://easybene.com/index.php/api-funds/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result);
                    if (result.HS_balance === '' || result.HS_balance === null) {
                        result.HS_balance = 'Pending';
                        $('#hsa_checking_value').css('color', '#f8c572');
                        
                    }
                    if (result.portfolio_balance === '' || result.portfolio_balance === null) {
                        result.portfolio_balance = 'Pending';
                        $('#hsa_investment_value').css('color', '#f8c572');
                    }
                    $('#hsa_checking_value').html(result.HS_balance);
                    $('#hsa_investment_value').html(result.portfolio_balance);
                    
                    if (result.transaction_activity[0]) {
                        $.each(result.transaction_activity, function(key, row) {
                            
                            if (row.transaction_type) {
                                $('#hsa_transaction_activity_loop').append('<tr><td>' +
                                    row.transaction_date +
                                '</td><td>' +
                                    row.transaction_type +
                                '</td><td>' +
                                    row.transaction_amt +
                                '</td></tr>');
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
    
    $('#hsa_transaction_activity_link').on('click', function() {
        showTransactionActivityDiv();
    });
    
    $('#hsa_summary_link').on('click', function() {
        showHSASummaryDiv();
    });
    
}());