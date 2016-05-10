function reply_func()
{
    var reply_message =  document.getElementById('reply_message').value;
    if(reply_message=='') {
        alert('Please write your message!');
        return false;
    } else {
        document.forms.reply_message_Frm.submit();
    }
 }
      
function search_func()
{
    var message_search = document.getElementById('message_search').value; 
    if(message_search=='') {
        alert('Please insert a username!');
        return false;
    } else {
        document.location.href = url + '/' + message_search;
    }
}