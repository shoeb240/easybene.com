function money_check(money)
{ 
    $check = 0;
    if ( project_cost < money) {
        alert('You have bidded a higher amount than the maximum budget. Please change your price.');
        return false;
    } else {
        $check = 1;
    }
}
     
function project_bid_func()
{ 
    var  bid_amount = document.getElementById('bid_amount').value;
    var  time_period = document.getElementById('time_period').value;
    var  message = document.getElementById('message').value;
    if(bid_amount=='') {
        alert('Please insert your bid amount!');
        return false;
    } else if(time_period=='') {
        alert('Please insert your time period!');
        return false;
    } else if(message=='') {
        alert('Please insert your message!');
        return false;
    } else if($check!=1) {
        alert('You have bidded a higher amount than the maximum budget. Please change your price.'); 
        return false;
    } else {
        var con = confirm('Are you sure to bid this project?');
        if(!con) { 
            return false;
        } else { 
            document.forms.project_bid_Frm.submit();
        }    
    }

} 