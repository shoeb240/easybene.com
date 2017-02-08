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

    
    
    
    
    
}());