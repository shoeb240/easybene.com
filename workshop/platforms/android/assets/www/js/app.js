// We use an "Immediate Function" to initialize the application to avoid leaving anything behind in the global scope
(function () {

    /* ---------------------------------- Local Variables ---------------------------------- */
    var service = new EmployeeService();
    service.initialize("http://www.themercerpool.com/easybenefits2/api.php").done(function () {
        console.log("Service initialized");
    });

    /* --------------------------------- Event Registration -------------------------------- */
    /*$('.search-key').on('keyup', findByName);
    $('.help-btn').on('click', function() {
        alert("Employee Directory v3.4");
    });*/
    findByName();

    /* ---------------------------------- Local Functions ---------------------------------- */
    function findByName() {
        service.findByName($('.search-key').val()).done(function (response) {
            rob = JSON.parse(response);
            var l = rob.rows.length;
            $('.employee-list').empty();
            var row;
            var m;
            for (var i = 0; i < l; i++) {
                row = rob.rows[i];
                m = row.length;
                $('.employee-list').append('<li>');
                for (var j = 2; j < m; j++) {
                    $('.employee-list').append("=="+row[j]+"==");
                }
                $('.employee-list').append('</li>');
            }
        });
    }

}());