function trigger_input()
{
    $('.qq-upload-button input[name=file]').trigger('click');
}

function submit_portfolio_func()
{   
    var portfolio_title       = document.getElementById('portfolio_title').value;
    var client_name       = document.getElementById('client_name').value;
    var project_url = document.getElementById('project_url').value;
    var project_description = document.getElementById('project_description').value;

    if(portfolio_title=='') {
      alert('Please insert a title!');
      return false;
    } else if(client_name=='') {
      alert('Please insert client name!');
      return false;
    } else if(project_url=='') {
      alert('Please insert your client url!');
      return false;
    } else if(!is_valid_url(project_url)) {
        alert('Please insert a valid url!');
        return false;
    } else if(project_description=='') {
        alert('Please insert your project description!');
        return false;
    } else {
        document.forms.portfolio_add_form.submit();
    }
}

function is_valid_url(url)
{
    return url.match(/^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/);
}
