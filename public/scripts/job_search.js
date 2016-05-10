
    function job_search_func()
    {
      var job_search = document.getElementById('job_search').value;
      if(job_search=='')
      {
        alert('Please insert any job name!');
        return false;
      }
      else
      {
        document.forms.job_search_Frm.submit();
      }
    }
