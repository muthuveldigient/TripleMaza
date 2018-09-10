function chibiControlBuild(flag,nameVar,idVar)
{

	var temp=document.mcatFrm['main_flag'].value;
	var categoryVal=document.mcatFrm['cat'+temp].value;	

	
	if(categoryVal==-100) {
		alert("Select Sub Category ");
		return false;	
	}
var	category=document.mcatFrm['mcatname'].value;	
	if(trim(category=document.mcatFrm['mcatname'].value)=="")
	{
		alert("Enter Sub Category ");
		return false;			
	}
	if(flag==1)
	{
			var total_num=trim(document.getElementById('avatar_num').value);
			
			var avatar_temp=document.getElementById('avatar_temp').value;
			document.getElementById('avatar_temp').value=total_num;
//			alert("temp"+avatar_temp);
		if(avatar_temp>0)
		{
			//function removeDiv(flag,nameVar,idVar)
					//	alert("remove Call-avatar");
			removeDiv(1,'nameVar','avatar_div',avatar_temp);
		}

		//	var control_tag="<p>Icon Dimension <input name='icon_w' type='text' class='TextField4' id='icon_w' size='5' /> x <input name='icon_h' type='text' class='TextField4' id='icon_h' size='5' /></p>";
			var msg="Avatar";			
	}
	else
	{
		var effects_value=trim(document.getElementById('effects').value);
		var chibi_temp=document.getElementById('chibi_temp').value;
		chibi_temp=Number(chibi_temp)*2;
		document.getElementById('chibi_temp').value=document.getElementById('chibi_num').value;
		if(chibi_temp>0)
		{
			//function removeDiv(flag,nameVar,idVar)
			//alert("remove Call");
			removeDiv(2,'nameVar','chibi_div',chibi_temp);
		}
		
		if(effects_value==1)
		{
			var total_num=trim(document.getElementById('chibi_num').value);
			var control_tag="";
			var msg="Chibi";
			total_chibi=total_num;
			total_num=Number(total_num)*2;
		}
//		alert(total_num);
	}
if(total_num=="") 
{
		alert("Enter Number of "+ msg +" Images ");
		return false;			
	
}
		
		

			for(i=1;i<=total_num;i++)
			{
				
				var cnt=document.getElementById(idVar);
				var newdiv = document.createElement('div');
				
				
//				newdiv.setAttribute('class',divIdName);
				if(flag==1)
				{
					var divIdName = 'avatar'+i+'Div';
					newdiv.setAttribute('id',divIdName);
					
					var control_tag='<div class="AvrImgwrap">Avatar details Image - '+ i +': <br /><div class="AvrWHWrap02"><input name="'+ nameVar +i+'w" type="text" class="AvrWHTxtfld" id="'+ nameVar +i+'w" size="5" /> x <input name="'+ nameVar + i +'h" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'h" size="5" /></div></div>';
				}else
				{
					var divIdName = 'chibi'+i+'Div';
					newdiv.setAttribute('id',divIdName);
					
					var category=document.mcatFrm['mcatname'].value;//document.mcatFrm['cat'+temp].value;
//					var document.getElementById(idVar).value;
					var txt_title=category + " Front";
					
							//var control_tag="<div class='UDFieldtitle'>Avatar details Image - "+ i +": </div><div class='UDFieldTxtFld'><input name='"+ nameVar +i+"w' type='text' class='TextFieldSmall' id='"+ nameVar +i+"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></div>";
					if(i>total_chibi) txt_title=category + " Back";
					//var control_tag=""+ txt_title + " Image - "+ i +":<input name='txt"+ nameVar + i +"' type='text' class='TextField4' id='txt"+ nameVar + i +"' size='20' /><br /><p><input name='"+ nameVar + i +"w' type='text' class='TextFieldSmall' id='"+ nameVar + i +"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></p>";				
				//	var control_tag=""+ txt_title + " Image - "+ i +":<input name='txt"+ nameVar + i +"' type='text' class='TextField4' id='txt"+ nameVar + i +"' size='20' /><br /><p><input name='"+ nameVar + i +"w' type='text' class='TextFieldSmall' id='"+ nameVar + i +"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></p>";	
					var control_tag='<div class="AvrImgwrap">'+ txt_title +' Image - '+ i +':<br /><input name="txt'+ nameVar + i +'" type="text" class="AvrWHTxtfld" id="txt'+ nameVar + i +'" size="20" /><div class="AvrWHWrap02">  <input name="'+ nameVar + i +'w" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'w" size="5" />   X   <input name="'+ nameVar + i +'h" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'h" size="5" /></div></div>';
				}
			//	newdiv.innerHTML = "<div class='UDRightWrap'>"+ control_tag +"</div>";		
				newdiv.innerHTML = control_tag;						
 		 // 	alert(newdiv.innerHTML);
				cnt.appendChild(newdiv);					
			
			}
}
 

/*


			if(total_count > n)
			{
//				alert(total_count + "  " + main_flag);
				var cnt=document.getElementById('cnt');
				var rcnt=document.getElementById('cnt1Div');
				for(i=n+1;i<=total_count;i++)
				{

//									var control_tag="<p>Icon Dimension <input name='icon_w' type='text' class='TextField4' id='icon_w' size='5' /> x <input name='icon_h' type='text' class='TextField4' id='icon_h' size='5' /></p>";

					
					rcnt=document.getElementById('cnt'+i+'Div');
					
//					alert(document.getElementById('cnt'+i+'Div').value);
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'].value=n;
			}


*/
function removeDiv(flag,nameVar,idVar,num)
{
	

			total_count=num; 


		
			if(total_count > 0)
			{
//				alert(total_count + "  " + main_flag);
 				var cnt=document.getElementById(idVar);
	//			var rcnt=document.getElementById('cnt1Div');
	
				for(i=1;i<=total_count;i++)
				{
//				var control_tag="<p>Icon Dimension <input name='icon_w' type='text' class='TextField4' id='icon_w' size='5' /> x <input name='icon_h' type='text' class='TextField4' id='icon_h' size='5' /></p>";
					if(flag==1) var nme='avatar'+i+'Div'; else var nme='chibi'+i+'Div';

					rcnt=document.getElementById(nme);

					  if(rcnt)
					  {
				//		alert(rcnt.innerHTML);
						//						rcnt.innerHTML="";
						cnt.removeChild(rcnt);					
					  }
				}
		//		document.getElementById('avatar_temp').value=0;
			}

//alert('');
}


function chibiVisible(obj)
{
	var d=document.getElementById('effects').value;
//	alert(this.checked);
	if(obj.checked==true)
	{
		document.getElementById('chibi_control').style.visibility='visible';	
	}
	else
	{
		document.getElementById('chibi_control').style.visibility='hidden';	
		var temp=document.getElementById('chibi_num').value;
		chibi_temp=document.getElementById('chibi_temp').value;
		chibi_temp=Number(chibi_temp)*2;
		if(temp>0)
		{
			removeDiv(2,'nameVar','chibi_div',chibi_temp);
		}
	}
}



function editChibiControlBuild(flag,nameVar,idVar)
{
//		alert('');

	if(flag==1)
	{
			
			var total_num=trim(document.getElementById('avatar_num').value);
			
			var avatar_temp=document.getElementById('avatar_temp').value;
			document.getElementById('avatar_temp').value=total_num;
 		//	alert("temp"+avatar_temp);
		if(avatar_temp>0)
		{
			//function removeDiv(flag,nameVar,idVar)
					//	alert("remove Call-avatar");
					
			removeDiv(1,nameVar,'avatar_div',avatar_temp);
		}

		//	var control_tag="<p>Icon Dimension <input name='icon_w' type='text' class='TextField4' id='icon_w' size='5' /> x <input name='icon_h' type='text' class='TextField4' id='icon_h' size='5' /></p>";
			var msg="Avatar";			
	}
	else
	{
		var effects_value=trim(document.getElementById('effects').value);
		var chibi_temp=document.getElementById('chibi_temp').value;
		chibi_temp=Number(chibi_temp)*2;
		document.getElementById('chibi_temp').value=document.getElementById('chibi_num').value;
		if(chibi_temp>0)
		{
			//function removeDiv(flag,nameVar,idVar)
			//alert("remove Call");
			removeDiv(2,nameVar,'chibi_div',chibi_temp);
		}
		
		if(effects_value==1)
		{
			var total_num=trim(document.getElementById('chibi_num').value);
			var control_tag="";
			var msg="Chibi";
			total_chibi=total_num;
			total_num=Number(total_num)*2;
		}
//		alert(total_num);
	}
if(total_num=="") 
{
		alert("Enter Number of "+ msg +" Images ");
		return false;			
	
}
		
		

			for(i=1;i<=total_num;i++)
			{
				
				var cnt=document.getElementById(idVar);
				var newdiv = document.createElement('div');
				
				
//				newdiv.setAttribute('class',divIdName);
				if(flag==1)
				{
					var divIdName = 'avatar'+i+'Div';
					newdiv.setAttribute('id',divIdName);
					
					var control_tag='<div class="AvrImgwrap">Avatar details Image - '+ i +': <br /><div class="AvrWHWrap02"><input name="'+ nameVar +i+'w" type="text" class="AvrWHTxtfld" id="'+ nameVar +i+'w" size="5" maxlength="3" /> x <input name="'+ nameVar + i +'h" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'h" size="5" maxlength="3"/></div></div>';
				}else
				{
					var divIdName = 'chibi'+i+'Div';
					newdiv.setAttribute('id',divIdName);
					
					var category=document.mcatFrm['mcatname'].value;//document.mcatFrm['cat'+temp].value;
//					var document.getElementById(idVar).value;
					var txt_title=category + " Front";
					
							//var control_tag="<div class='UDFieldtitle'>Avatar details Image - "+ i +": </div><div class='UDFieldTxtFld'><input name='"+ nameVar +i+"w' type='text' class='TextFieldSmall' id='"+ nameVar +i+"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></div>";
					if(i>total_chibi) txt_title=category + " Back";
					//var control_tag=""+ txt_title + " Image - "+ i +":<input name='txt"+ nameVar + i +"' type='text' class='TextField4' id='txt"+ nameVar + i +"' size='20' /><br /><p><input name='"+ nameVar + i +"w' type='text' class='TextFieldSmall' id='"+ nameVar + i +"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></p>";				
				//	var control_tag=""+ txt_title + " Image - "+ i +":<input name='txt"+ nameVar + i +"' type='text' class='TextField4' id='txt"+ nameVar + i +"' size='20' /><br /><p><input name='"+ nameVar + i +"w' type='text' class='TextFieldSmall' id='"+ nameVar + i +"w' size='5' /> x <input name='"+ nameVar + i +"h' type='text' class='TextFieldSmall' id='"+ nameVar + i +"h' size='5' /></p>";	
					var control_tag='<div class="AvrImgwrap">'+ txt_title +' Image - '+ i +':<br /><input name="txt'+ nameVar + i +'" type="text" class="AvrWHTxtfld" id="txt'+ nameVar + i +'" size="20" /><div class="AvrWHWrap02">  <input name="'+ nameVar + i +'w" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'w" size="5" maxlength="3" />   X   <input name="'+ nameVar + i +'h" type="text" class="AvrWHTxtfld" id="'+ nameVar + i +'h" size="5" maxlength="3" /></div></div>';
				}
			//	newdiv.innerHTML = "<div class='UDRightWrap'>"+ control_tag +"</div>";		
				newdiv.innerHTML = control_tag;						
 		 // 	alert(newdiv.innerHTML);
				cnt.appendChild(newdiv);					
			
			}

}
