function search_func()
  {
      var message_search = document.getElementById('message_search').value; 
      if(message_search=='') {
        alert('Please insert a username!');
        return false;
      } else {
        document.location.href = url + '/1/' + message_search;
      }
  }

function delete_message_func(project_id, SENDER_user_id)
{
    var con = confirm('Are you sure delete this message?');
    if(!con) {
      return false;
    } else {
      document.location.href = baseUrl + 'account/delete-inbox-message/' + project_id + '/' + SENDER_user_id;
    }    
} 

function outbox_message_delete_func(project_id,RECEIVER_user_id)
{ 
    var con = confirm('Are you sure delete this message?');
    if(!con) {
      return false;
    } else document.location.href = baseUrl + 'account/delete-outbox-message/' + project_id + '/' + RECEIVER_user_id;
}