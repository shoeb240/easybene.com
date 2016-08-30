// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            GetDentalData();
        } else {
            ShowLogin();
        }
    });

    function ShowLogin() {
        location.href = 'provider-login.html';
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
                    //console.log(result.claim);
                    if (result.claim[0]) {
                        $.each(result.claim, function(key, row) {
                            $('#guardian-claim').append('<tr role="row"><td>'+row.paid_date+'</td><td><p>'+row.patient_name+'</p></td><td>'+row.submitted_charges+'</td><td>'+row.i_owe+'</td><td><span>'+row.status+'</span></td></tr>');
                        });
                    } else {
                        $('#guardian-claim').append('<tr role="row"><td colspan="5">No data available</td></tr>');
                    }
                    showClaimDiv();
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