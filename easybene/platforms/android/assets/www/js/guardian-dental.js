// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            $("#top_tab_link_medical").removeClass("active");
            $("#top_tab_link_dental").addClass("active");
            $("#top_tab_link_vision").removeClass("active");

            GetDentalData();
        } else {
            ShowLogin();
        }
    });

    function ShowLogin() {
        location.href = 'index.html';
    }
    
    function GetDentalData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        var status = '';
        var cssclass = '';
        $.ajax({
            url: 'http://www.easybene.com/index.php/api-dental/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                    //console.log(result.claim);
                    if (result.claim[0]) {
                        $.each(result.claim, function(key, row) {
                            status = 'Pending';
                            cssclass = 'pending';
                            if (row.status.search("Processed") >= 0) {
                                status = 'Processed';
                                cssclass = 'processed';
                            }
                            $('#claim').append('<tr><td>'+row.paid_date+'</td><td><p>'+row.patient_name+'</p></td><td>'+row.submitted_charges+'</td><td>'+row.i_owe+'</td><td><span class="'+status.toLowerCase()+'">'+cssclass+'</span></td></tr>');
                        });
                    } else {
                        $('#claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                },
            error: function(xhr, ajaxOptions, thrownError) {
                    //console.log(xhr);
                    //console.log(ajaxOptions);
                    //console.log(thrownError);
                },
        });
    }
    
    $('#benefit_link').on('click', function() {
        showBenfitDiv();
    });
    
    $('#claim_link').on('click', function() {
        showClaimDiv();
    });
    
}());