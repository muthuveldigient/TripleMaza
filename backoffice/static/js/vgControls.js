// JavaScript Document

function vgControls()
{

var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateck()
{
	if(httpxml.readyState==4)
	{	
	// alert(httpxml.responseText );
		 
	 	var total_count=document.mcatFrm['total_control'].value;
	var n=document.mcatFrm['num_vg'].value;
	
			if(total_count > 0)
			{

				var cnt=document.getElementById('cnt');
				var rcnt=document.getElementById('cnt1Div');
				for(i=1;i<=total_count;i++)
				{
					rcnt=document.getElementById('cnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'].value=n;

			}
			var cnt=document.getElementById('cnt');
			for(i=1;i<=n;i++)
			{
				 var c="<select name='product"+ i +"' id='product"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Product Name "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'cnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);

//newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='vgnum"+i+"' type='text' class='UDTxtField' id='vgnum"+i+"' size='5' /></div></div>";
				
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><select name='vgnum"+i+"' id='vgnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div>";
				 
				
				
				cnt.appendChild(newdiv);
			}
document.mcatFrm['total_control'].value=n;
//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
	var url="vg_controls.php";
	num=document.getElementById("num_vg").value;
	url=url+"?num="+num;
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);
 
	
}

function vgStaticControls()
{

var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateckstatic()
{
	if(httpxml.readyState==4)
	{	
	// alert(httpxml.responseText );
		 
	var total_count=document.mcatFrm['total_control'].value;	
	var n=document.mcatFrm['num_vg'].value;
	
			if(total_count > 0)
			{

				var cnt=document.getElementById('cnt');
				var rcnt=document.getElementById('cnt1Div');
				for(i=1;i<=total_count;i++)
				{
					rcnt=document.getElementById('cnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'].value=n;

			}
			var cnt=document.getElementById('cnt');
			var gt=document.mcatFrm['qtype'].value;	
			
			for(i=1;i<=n;i++)
			{
				 var c="<select name='product"+ i +"' id='product"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Game Area "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'cnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);

//newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='vgnum"+i+"' type='text' class='UDTxtField' id='vgnum"+i+"' size='5' /></div></div>";
				
				if(gt=="7")
				{
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Task Dispaly Name"+ i +":</div><div class='AvrsubRtext'><input type='text' name='sdisplayname"+i+"' class='UDTxtField' id='sdisplayname"+i+"'></div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Game Area "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of Times "+ i +":</div><div class='AvrsubRtext'><select name='vgnum"+i+"' id='vgnum"+i+"' class='Textselct'><option value='-100'>Select</option><option value='1' selected='selected'>1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Winning"+ i +":</div><div class='AvrsubRtext'><select name='winnum"+i+"' id='winnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='0' >Win</option><option value='1' >Play</option></select></div></div>";				
				}
				else
				{
					newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Task Dispaly Name"+ i +":</div><div class='AvrsubRtext'><input type='text' name='sdisplayname"+i+"' class='UDTxtField' id='sdisplayname"+i+"'></div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Game Area "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of Times "+ i +":</div><div class='AvrsubRtext'><select name='vgnum"+i+"' id='vgnum"+i+"' class='Textselct'><option value='-100'>Select</option><option value='1' selected='selected'>1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div>";
				}
				
				cnt.appendChild(newdiv);
			}
document.mcatFrm['total_control'].value=n;
//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
	var url="vg_controls.php";
	num=document.getElementById("num_vg").value;
	var gt=document.mcatFrm['qtype'].value;	
	url=url+"?gt="+gt+"&num="+num;
	//alert(url);
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateckstatic;
	httpxml.open("GET",url,true);
	httpxml.send(null);
 
	
}


function subVgControls(obj,n,z)
{

	var total_count=document.mcatFrm['total_control'+z].value;
	document.mcatFrm['main_flag'+z].value=n;

	var main_flag=Number(n) + 1;		
	//*********************************
	if(obj.value==-1)
	{
		var cnt=document.getElementById('t'+z+'cnt1');
		var rcnt=document.getElementById('t'+z+'cnt1Div');
		for(i=n+1;i<=total_count;i++)
		{
			rcnt=document.getElementById('t'+z+'cnt'+i+'Div');
//					alert(document.getElementById('cnt'+i+'Div').value);
			cnt.removeChild(rcnt);					
		}
		document.mcatFrm['total_control'+z].value=n;
		return false;
	}
//********************************	
//	if(n==0) document.getElementById('cnt').innerHTML="";
	
	if(document.getElementById('t'+z+'cat'+ Number(n)).value=="Select Main Category") 
	{
		document.mcatFrm['main_flag'+ z].value=n-1;
	//	return false;
	}
//	var v=document.mcatFrm['cat'+n].value;
	var v= document.getElementById('t'+z+'cat'+ n).value;
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
		alert ("Browser does not support HTTP Request")
		return
		} 
		var url="loadtask.php?id="+v+"&main_flag="+n;	
	//alert(url);
		xmlHttp.onreadystatechange=function()
      {
     
	 	if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
		{
		}
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
		{ 
		
//				alert(xmlHttp.responseText);
			if(xmlHttp.responseText!=500)
			{	
				var c="<select name='t"+ z +"cat"+main_flag+"' id='t"+ z +"cat"+main_flag+"' class='Textselct' onchange='subVgControls(this,"+main_flag+","+ z +");'><option selected='selected' value='-100'>Select Sub Category</option>"+xmlHttp.responseText+"</select>";
			  
				//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" + c +"</div></div></div>");		
				
//				document.getElementById('cnt').innerHTML=document.getElementById('cnt').innerHTML + "<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>";
			
//			alert(total_count + "  " + n);
			if(total_count > n)
			{
//				alert(total_count + "  " + main_flag);

				var cnt=document.getElementById('t'+z+'cnt1');
				var rcnt=document.getElementById('t'+z+'cnt1Div');
				for(i=n+1;i<=total_count;i++)
				{
					rcnt=document.getElementById('t'+z+'cnt'+i+'Div');
//					alert(document.getElementById('cnt'+i+'Div').value);
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'+ z].value=n;
			}
			var cnt=document.getElementById('t'+z+'cnt1');
			var newdiv = document.createElement('div');
			var divIdName = 't'+z+'cnt'+main_flag+'Div';
			newdiv.setAttribute('id',divIdName);
newdiv.innerHTML = "<div class='UDRightWrap'><div class='UDFieldtitle'>Task Sub Category "+ main_flag +":</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>";
cnt.appendChild(newdiv);

			document.mcatFrm['total_control'+z].value=main_flag;
 
			}
		
		}else if(xmlHttp.responseText==500)
		{
			if(total_count > n)
			{
//				alert(total_count + "  " + n);

				var cnt=document.getElementById('t'+z+'cnt1');
				var rcnt=document.getElementById('t'+z+'cnt1Div');
				for(i=n+1;i<=total_count;i++)
				{
					rcnt=document.getElementById('t'+z+'cnt'+i+'Div');
//					alert(document.getElementById('cnt'+i+'Div').value);
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'+z].value=n;
				
			}				
		}
      }
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
}

function vgRewardsControls()
{
	var ch = /[0-9]/;	
	var num_vg=document.getElementById("Rnum_vg");				
	/*if(num_vg.value=="")
	{
		alert("Enter Number of VG");
		num_vg.focus();
		return false;
	}*/
	if(isInteger(num_vg.value)==false)
	{
		alert("Numbers only allowed");
		num_vg.focus();
		return false;
	}	
		
		
var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateck()
{
	if(httpxml.readyState==4)
	{	
//	 alert(httpxml.responseText );
		 
	 	var total_count=document.mcatFrm['Rtotal_control'].value;
	var n=document.mcatFrm['Rnum_vg'].value;

			if(total_count > 0)
			{

				var cnt=document.getElementById('cntReward');
				var rcnt=document.getElementById('Rcnt1Div');
				for(i=1;i<=total_count;i++)
				{
					rcnt=document.getElementById('Rcnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['Rtotal_control'].value=n;
			}
			var cnt=document.getElementById('cntReward');
			for(i=1;i<=n;i++)
			{
				 var c="<select name='Rewardproduct"+ i +"' id='Rewardproduct"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Product Name "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'Rcnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);
//				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='Rewardvgnum"+i+"' type='text' class='UDTxtField' id='Rewardvgnum"+i+"' size='5' /></div></div>";
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><select name='Rewardvgnum"+i+"' id='Rewardvgnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div>";



				cnt.appendChild(newdiv);
			}
			document.mcatFrm['Rtotal_control'].value=n;
 			//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
 
	var url="vg_controls.php";
	num=document.getElementById("Rnum_vg").value;
	url=url+"?num="+num;
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}

//** Edit QUEST VG 

function editVgControls()
{


var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateck()
{
	if(httpxml.readyState==4)
	{	
//	 alert(httpxml.responseText );
		 
	 	var total_count=eval(document.mcatFrm['total_control'].value);
	var n=document.mcatFrm['num_vg'].value;
	var start=1;
//		
			if(total_count > 0)
			{
				if(n > total_count) 
					start= eval(total_count) +1;
				if(n < total_count) 
					start= eval(n) + 1;
				
				var cnt=document.getElementById('cnt');
				var rcnt=document.getElementById('cnt1Div');
				for(i=start;i<=total_count;i++)
				{
					rcnt=document.getElementById('cnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'].value=n;

			}
			if(n <total_count)
			{
				document.mcatFrm['total_control'].value=n;	
				return;	
			}
			var cnt=document.getElementById('cnt');
			
			for(i=start;i<=n;i++)
			{
				 var c="<select name='product"+ i +"' id='product"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Product Name "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'cnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);

//newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='vgnum"+i+"' type='text' class='UDTxtField' id='vgnum"+i+"' size='5' /></div></div>";
				
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><select name='vgnum"+i+"' id='vgnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div>";
				 
				
				
				cnt.appendChild(newdiv);
			}
document.mcatFrm['total_control'].value=n;
//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
	var url="vg_controls.php";
	num=document.getElementById("num_vg").value;
	url=url+"?num="+num;
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}

//** Edit QUEST VG 


function editVgStaticControls()
{
var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateck()
{
	if(httpxml.readyState==4)
	{	
//	 alert(httpxml.responseText );
		 
	 	var total_count=eval(document.mcatFrm['total_control'].value);
	var n=document.mcatFrm['num_vg'].value;
	var start=1;
//		
			if(total_count > 0)
			{
				if(n > total_count) 
					start= eval(total_count) +1;
				if(n < total_count) 
					start= eval(n) + 1;
				
				var cnt=document.getElementById('cnt');
				var rcnt=document.getElementById('cnt1Div');
				for(i=start;i<=total_count;i++)
				{
					rcnt=document.getElementById('cnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['total_control'].value=n;

			}
			if(n <total_count)
			{
				document.mcatFrm['total_control'].value=n;	
				return;	
			}
			var cnt=document.getElementById('cnt');
			
			for(i=start;i<=n;i++)
			{
				 var c="<select name='product"+ i +"' id='product"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Product Name "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'cnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);

//newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='vgnum"+i+"' type='text' class='UDTxtField' id='vgnum"+i+"' size='5' /></div></div>";
				
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Task Dispaly Name"+ i +":</div><div class='AvrsubRtext'><input type='text' name='sdisplayname"+i+"' class='UDTxtField' id='sdisplayname"+i+"'></div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Game Area "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of Times "+ i +":</div><div class='AvrsubRtext'><select name='vgnum"+i+"' id='vgnum"+i+"' class='Textselct'><option value='-100'>Select</option><option value='1' selected='selected'>1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Winning"+ i +":</div><div class='AvrsubRtext'><select name='winnum"+i+"' id='winnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='0' >Win</option><option value='1' >Play</option></select></div></div>";	
				
				cnt.appendChild(newdiv);
			}
document.mcatFrm['total_control'].value=n;
//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
	var url="vg_controls.php";
	num=document.getElementById("num_vg").value;
	var gt=document.mcatFrm['qtype'].value;	
	url=url+"?gt="+gt+"&num="+num;
	alert(url);
	//url=url+"?num="+num;
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}

function editVgRewardsControls()
{	
	var ch = /[0-9]/;	
	var num_vg=document.getElementById("Rnum_vg");				
/*	if(num_vg.value=="")
	{
		alert("Enter Number of VG");
		num_vg.focus();
		return false;
	}
*/
	if(isInteger(num_vg.value)==false)
	{
		alert("Numbers only allowed");
		num_vg.focus();
		return false;
	}	
		
		
var httpxml;

try
{
// Firefox, Opera 8.0+, Safari
httpxml=new XMLHttpRequest();
}
catch (e)
{
// Internet Explorer
try
{
httpxml=new ActiveXObject("Msxml2.XMLHTTP");
}
catch (e)
{
try
{
httpxml=new ActiveXObject("Microsoft.XMLHTTP");
}
catch (e)
{
alert("Your browser does not support AJAX!");
return false;
}
}
}
function stateck()
{
	if(httpxml.readyState==4)
	{	
//	 alert(httpxml.responseText );
		 
	 	var total_count=document.mcatFrm['Rtotal_control'].value;
	var n=document.mcatFrm['Rnum_vg'].value;
var start=1;
			if(total_count > 0)
			{
				if(n > total_count) 
					start= eval(total_count) +1;
				if(n < total_count) 
					start= eval(n) + 1;

				var cnt=document.getElementById('cntReward');
				var rcnt=document.getElementById('Rcnt1Div');
				for(i=start;i<=total_count;i++)
				{
					rcnt=document.getElementById('Rcnt'+i+'Div');
					cnt.removeChild(rcnt);					
				}
				document.mcatFrm['Rtotal_control'].value=n;
			}
			var cnt=document.getElementById('cntReward');
			for(i=start;i<=n;i++)
			{
				 var c="<select name='Rewardproduct"+ i +"' id='Rewardproduct"+ i +"' class='Textselct' ><option selected='selected' value='-100'>Select Product Name "+ i + "</option>"+httpxml.responseText+"</select>";
				var newdiv = document.createElement('div');			
				var divIdName = 'Rcnt'+ i +'Div';
				newdiv.setAttribute('id',divIdName);
//				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><input name='Rewardvgnum"+i+"' type='text' class='UDTxtField' id='Rewardvgnum"+i+"' size='5' /></div></div>";
				newdiv.innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>Virtual Goods Name "+ i +":</div><div class='AvrsubRtext'>" +c+"</div></div><div class='AvrsubWrap'><div class='AvrsubLtext'>Number of VG "+ i +":</div><div class='AvrsubRtext'><select name='Rewardvgnum"+i+"' id='Rewardvgnum"+i+"' class='Textselct' ><option value='-100'>Select</option><option value='1' >1</option><option value='2' >2</option><option value='3' >3</option><option value='4' >4</option><option value='5' >5</option></select></div></div>";



				cnt.appendChild(newdiv);
			}
			document.mcatFrm['Rtotal_control'].value=n;
 			//alert("<div class='UDRightWrap'><div class='UDFieldtitle'>Product Sub Category 02:</div><div class='UDFieldTxtFld'>" +c+"</div></div></div>");			document.mcatFrm['total_control'].value=n;
		 
	}
}
 
	var url="vg_controls.php";
	num=document.getElementById("Rnum_vg").value;
	url=url+"?num="+num;
//	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);
}