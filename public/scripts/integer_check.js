     $(document).ready(function () {
    $('.integer_check').keydown(function (event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if ((event.keyCode >= 48 && event.keyCode <= 57) || 
                  (event.keyCode >= 96 && event.keyCode <= 105) || 
                   event.keyCode == 190) {
 
            }
            else {
                event.preventDefault();
            }
        }
    });
});