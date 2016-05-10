function submit_project_func()
{   
    var project_title       = document.getElementById('project_title').value;  
    var project_description = document.getElementById('project_description').value;
    var primary_category_id = document.getElementById('primary_category_id').value;
    var cost                = document.getElementById('cost').value;
    var bid_ending_date     = document.getElementById('bid_ending_date').value;

    if(project_title==''){
      alert('Please insert your project title!');
      return false;
    } else if(project_description=='') {
      alert('Please insert your project description!');
      return false;
    } else if(primary_category_id=='') {
      alert('Please insert your project category!');
      return false;
    } else if(cost=='') {
      alert('Please mention your budget for this project!');
      return false;
    } else if(bid_ending_date=='') {
      alert('Please mention your bid ending date for this project!');
      return false;
    } else {
      document.forms.submit_project_Frm.submit();
    }
}



$('#bid_ending_date').datepicker(
{
    changeMonth: true,
    changeYear: true,
    dateFormat: "dd MM yy",
    yearRange: '1900:2020'
});