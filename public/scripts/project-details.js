function check_bid_user_func()
{
    alert('You are already bided this project!');
}
  
function check_bid_for_owner_func()
{
    alert('You are the project owner for this project so you can not bid for this project!');
}
  
function project_assign_func(url)
{
    var con = confirm('Are you sure your project will be assigned to this user?');
    if(!con) {
        return false;
    } else {
        document.location.href = url;
    }
} 
  
function accept_func(url)
{ 
    var con = confirm('Are you sure accept this project!');
    if(!con) {
        return false;
    } else { 
        document.location.href = url;
    }    
} 
  
function decline_func(url)
{
    var con = confirm('Are you sure decline this project!');
    if(!con) {
        return false;
    } else {
        document.location.href = url;
    }
}
  
function frozen_project_func()
{
    alert('This project has frozen!');
}
  
function project_cancel_func(project_id)
{
    var con = confirm('Are you sure cancel your project?');
    if(!con) {
      return false;
    } else {
      document.location.href = baseUrl + 'project/cancel-project' + project_id;
    }
}
  
function delete_bid_func(project_id)
{
    var con = confirm('Are sure delete your bid for this project?');
    if(!con) {
        return false;
    } else {
        document.location.href = baseUrl + 'project/delete-bid/' + project_id;
    }
}
  
function bid_number_count_func(poject_id)
{
    var con = confirm('As a normal user, you have already finished up your limit of ' + bid_number_per_month + ' bids every month. If you wish to bid on this project, then please upgrade your account to a Premium User Account. Click OK to continue, and cancel otherwise.');
    if(!con) {
        return false;
    } else { 
        document.location.href = baseUrl + 'index/upgrade_membership';              
    }
}   
  
function payment_check_func(poject_id)
{
    var con = confirm('As a normal user, you have already finished up your limit of '+bid_number_per_month+' bids every month. If you wish to bid on this project, then please upgrade your account to a Premium User Account. You also upgrade your account in previous so this time not nedded upgrade your account. Click OK to continue, and cancel otherwise.');   
    if(!con) {
        return false;
    } else { 
      document.location.href = baseUrl + 'project/project-bid-payment/' + poject_id + '/add';              
    }
}