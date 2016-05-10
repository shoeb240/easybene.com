function bookmark_user(selected_id)
{
    $.ajax({
    type: "POST",
    url: baseUrl + 'account/bookmark-user/format/html',
    data: "selected_id="+selected_id,
    async: false,
    success: function(html_data)
    {
        if (html_data == 'yes'){
            $('#bookmark_user').hide('fast');
            $('#cancel_bookmark').show('fast');
            window.setTimeout(
                function()
                {
                    //location.reload(true)
                },
                0
            );

        } else if(html_data == 'no') {
           alert('Something went wrong!');
        } else if(html_data == 'bookmarked') {
            alert('You have already bookmarked this user!');
        }
    }
}, 'json');
}

function cancel_bookmark(selected_id)
{
    $.ajax({
    type: "POST",
    url: baseUrl + 'account/cancel-bookmark/format/html',
    data: "selected_id=" + selected_id,
    async: false,
    success: function(html_data)
    {
        if (html_data == 'yes') {
            $('#cancel_bookmark').hide('fast');
            $('#bookmark_user').show('fast');
            window.setTimeout(
                function()
                {
                    //location.reload(true)
                },
                0
            );            
        } else if(html_data == 'no') {
            alert('Something went wrong!');
        }
    }
});
}
