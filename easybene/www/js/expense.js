// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {
    
    var username = window.localStorage.getItem('username');
    var token = window.localStorage.getItem("token");
    
    $(window).load(function(){
        if (username && token) {
            var page = getQueryString('page');
            selectExpenseNote(page);
            
            prepareExpenseData();
        } else {
            ShowLogin();
        }
    });

    function ShowLogin() {
        location.href = 'index.html';
    }
    
    var getQueryString = function ( field ) {
        var href = window.location.href;
        var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
        var string = reg.exec(href);
        return string ? string[1] : null;
    };
    
    function selectExpenseNote(page) {
        if (page == 'expense') {
            $('#expense_a').trigger('click'); // or $('#expense_a').tab('show');
        } else {
            $('#document_a').trigger('click');
        }
    }
    
    function prepareExpenseData() {
        var username = window.localStorage.getItem("username");
        var token = window.localStorage.getItem("token");
        
        $.ajax({
            url: 'https://easybene.com/index.php/api-expense/'+username+'/'+token,
            type: "GET",
            dataType: 'json',
            async: false,
            success: function(result) {
                var exp_cont = '';
                $.each(result.expense, function(key, row){
                    exp_cont += '<li>\
                        <a href="#">\
                            <p>'+row.description+'</p>\
                            <span>'+row.date+' - '+row.name+'</span>\
                        </a>\
                    </li>';
                    
                    /*exp_cont += '<li>\
                            <div class="add-edit-content-wrapper">\
                                <div class="ex-content-wrapper">\
                                        <a href="#">\
                                                <p>'+row.description+'</p>\
                                                <span>'+row.date+' - '+row.name+'</span>\
                                            </a>\
                                        </div>\
                                        <div id="edit-wrapper" class="edit-content">\
                                            <div class="edit-con">\
                                                <div>\
                                                    <button class="delete-btn" ><span class="icon-trash-o"></span></button>\
                                                    <button class="edit-btn" data-toggle="modal" data-target="#edit-modal"><span class="icon-edit"></span></button>\
                                                </div>\
                                                <div>\
                                                    <p>'+row.description+'</p>\
                                                    <span>'+row.date+' - '+row.name+'</span>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </li>';*/
                });
                $('#expense ul').append(exp_cont);
                
                var doc_cont = '';
                $.each(result.document, function(key, row){
                    doc_cont += '<li>\
                    <a href="#">\
                        <p>'+row.description+'</p>\
                        <span>'+row.date+' - '+row.name+'</span>\
                    </a>\
                </li>';
                });
                $('#document ul').append(doc_cont);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                /*console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);*/
            },
        });
    }
    
    
}());