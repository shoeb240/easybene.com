function member_search_func()
{
    var member_search = document.getElementById('member_search').value; 
    if(member_search == '') {
        alert('Please insert a member name!');
        return false;
    } else {
        document.forms.member_search_Frm.submit();
    }
}

function creative_search_func()
{
    var creative_search = document.getElementById('creative_search').value; 
    if(creative_search=='') {
        alert('Please insert a creative member name!');
        return false;
    } else {
        document.forms.creative_search_Frm.submit();
    }
}
