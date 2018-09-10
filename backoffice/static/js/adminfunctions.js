function setCheckboxes(the_form, do_check)
{
    var elts      = document.forms[the_form].elements;
	
    var elts_cnt  = elts.length;
	
    for (var i = 0; i < elts_cnt; i++) {
        elts[i].checked = do_check;
		/*if (the_form + "_submit" == elts[i].name) {
			elts[i].disabled = !do_check;
		}*/
    } // end for

    return true;
} // end of the 'setCheckboxes()' function

function setCheckbox(the_form)
{
    var elts      = document.forms[the_form].elements;
    var elts_cnt  = elts.length;
    
    var allUnchecked = true;
	
    for (var i = 0; i < elts_cnt; i++)
    {
        if(elts[i].checked) allUnchecked = false;
    }
    
   /*for (var i = 0; i < elts_cnt; i++)
    {
        if(elts[i].name == (the_form + "_submit")) elts[i].disabled = allUnchecked;
    }*/

    return true;
}

function mail()
{
if(document.adu_form.cnt.value >= 1)
	{	
	 if(document.adu_form.checkbox.length > 0)
		{
			var flag=0;
			
				for(i=0;i<document.adu_form.checkbox.length;i++)
				{
						if(document.adu_form.checkbox[i].checked == true)
						{
							flag = 1;
							break;
						}
				}			
			
			   if(flag == 0)
			  {
				alert('Please select the any one checkbox to sent mail');
				return false;
			 }
	  }
	
	}

var r=confirm("Are you sure?sent a mail to selected user");
if (r==true)
  {
  document.adu_form.action='admin-home.php?p=madmmail';
  return true;  
  }
}