function space1(txtboxvalue)
{
	var flag=0;
	var strText = txtboxvalue; 
	if (strText!="") 
	{ 
		var strArr = new Array();
		// strArr = strText.split(" ");
		strVal= txtboxvalue; 
		strArr=strVal;
		for(var i = 0; i < strArr.length ; i++) 
		{ 
			if(strArr[i] == " ") 
			{ 
				flag=1;       
				break; 
			} 
		} 
		if (flag==1) 
		{
			// alert("Space not allowed."); 
			return false; 
		}
	}
}

// chk=duplicateChar(id,'.','Special Characters not allowed more than once',contentarea,sourcearea);
function firstChar(txt,err,errarea)
{
	// var exp_username = /^[A-Za-z0-9]{3,20}$/;	
	var txt1=new Array();
	txt1=txt;
	
	if (txt1[0]=="_" || txt1[0]=="." ) 
	{
		//	alert(txt1[0] + " Special Char Not allowed");
		document.getElementById(errarea).innerHTML = "First " + err;
		return false;
	}
	 
 	if (txt1[txt1.length-1]=="_" || txt1[txt1.length-1]=="." ) 
	{
		//alert("Special Char Not allowed");
		document.getElementById(errarea).innerHTML ="Last "+ err;
		return false;
	}
	return true;
}

function specialChar(txt,err,errarea)
{
	var exp_username = /^[A-Za-z0-9_..]{3,20}$/;	
	//	var ck_name = /^[A-Za-z0-9 ]{3,20}$/;
	var exp_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i 
	var exp_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;	

	if (!exp_username.test(txt)) 
	{
		//alert("Special Char Not allowed");
		document.getElementById(errarea).innerHTML = err;
		return false;
	}
	return true;
}

function emailFormat(txt)
{
	var strA=new Array();
	strA=txt;
	for(var i=0;i< strA.length;i++)
	{
		if(strA[i]=="."){
			if(strA[i+1]==".") return false;
		}
	}
}

function duplicateChar(txtboxvalue,c,err,errarea)
{
	var strVal=new String(txtboxvalue);
 	var strArr=new Array();
	//	var srcs=document.getElementById(sourcearea);
	strArr=strVal.split(c);
	//	strArr=strVal;
	//alert (strArr);
	for(var i=0; i < strArr.length ; i++)
	{ 
		///alert (strArr[i]);
	if(i>1) { //alert(err);
	//		if(strArr[i] == c){
		document.getElementById(errarea).innerHTML = err;
	//		srcs.focus();
		return false;
		}		
	}
	return true;
}

function space(txtboxvalue)
{ 
	var flag=0;
	var strText = txtboxvalue; 
	if (strText!="") 
	{ 
		var strArr = new Array();
		strArr = strText.split(" ");
		for(var i = 0; i < strArr.length ; i++) 
		{ 
			if(strArr[i] == "") 
			{ 
				flag=1;       
				break; 
			} 
		} 
		if (flag==1) 
		{
			alert("Space not allowed");return false; 
		}
	}
}

function LTrim( value ) 
{
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
}

// Removes ending whitespaces
function RTrim( value ) 
{	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");	
}

// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
}

function keyword_check()
{
var words = document.getElementsByName('keyword');
if(words.value =="")
{
alert("Please enter the word to search");	
words.focus();
}
}

var xmlHttp
//Ads Start
function GetXmlHttpObject()
{

var objXMLHttp=null
if (window.XMLHttpRequest)
{
objXMLHttp=new XMLHttpRequest()
}
else if (window.ActiveXObject)
{
objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
}
return objXMLHttp
}



//User ajax end

//***************************************** IP status change
function ipstatuschange(userid,status,page)
{
	var msg="";	
	if(status==1)
		msg="Active registration action to particular IP address?";
	else if(status==2)
		msg="Deactive registration action to particular IP address?";	
	else if(status==3)
		msg="Activate Login action to particular IP address?";	
	else if(status==4)
		msg="Deactive Login action to particular IP address?";	
		
	var a = confirm("Do you really want to "+msg);
					//unauthenticate this user? If so all the details related to this user wil get unauthenticated");
	if(a)
	{
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
		alert ("Browser does not support HTTP Request")
		return
		} 
		var url="changeuserstatus.php?userid="+userid+"&status=ip&col="+status;	
		//alert(url);
		xmlHttp.onreadystatechange=function()
                {
     
	 	if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
			{
						
			}

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
			{ 
				var newurl = "admin-home.php?p=sip&page="+page;
				window.location= newurl;			
			} 
                }
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)	
	}
}

function blockipstatuschange(userid,status)
{
	var msg="";	
	if(status==1)
		msg="Active registration action to particular IP address?";
	else if(status==2)
		msg="Deactive registration action to particular IP address?";	
/*	else if(status==3)
		msg="frozen registration action to particular IP address?";	*/
		
	var a = confirm("Do you really want to "+msg);
					//unauthenticate this user? If so all the details related to this user wil get unauthenticated");
	if(a)
	{
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
		alert ("Browser does not support HTTP Request")
		return
		} 
		var url="changeuserstatus.php?userid="+userid+"&status=ip&col="+status;	
		//alert(url);
		xmlHttp.onreadystatechange=function()
      {
     
	 	if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
			{
			}

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
			{ 
		var newurl = "admin-home.php?p=bip&msg=1";
		window.location= newurl;			
			} 
      }
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)	
	}
}

function bulkipstatuschange(status)
{
	var msg="";	
	if(status==2 && document.getElementById('bulkaction').value ==3 )
			msg="frozen registration action to particular IP address?";	
	else if(status==1)
		msg="Active registration action to particular IP address?";	
	else if(status==2)
		msg="Deactive registration action to particular IP address?";		
	var a = confirm("Do you really want to "+msg);
					//unauthenticate this user? If so all the details related to this user wil get unauthenticated");
	if(a)
	{
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{ 
			alert ("Browser does not support HTTP Request")
		return
		} 
		var url="changeuserstatus.php?userid="+userid+"&status=ip&col="+status;	
		//alert(url);
		xmlHttp.onreadystatechange=function()
      {
     
	 	if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
			{
			}

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
			{ 
		var newurl = "admin-home.php?p=sip";
		window.location= newurl;			
			} 
      }
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)	
	}
}


//languagevalidate Start
function languagevalidate(field)
{	
	with (field)
	{				
		 if(trim(langname.value)=="" || trim(langname.value)==null)
			{
			alert("Enter the language name");
			langname.focus();
			return false;
			}			
	return true; 
	}
}
//languagevalidate end

//Languageeditvalidate Start
function languageeditvalidate(field)
{	
	with (field)
	{				
		 if(trim(langname.value)=="" || trim(langname.value)==null)
			{
			alert("Enter the Language name");
			langname.focus();
			return false;
			}				
	return true; 
	}
}
//Languageeditvalidate end

//LangContent validate Start
function contentvalidate(field)
{	
	with (field)
	{				
		 if(langid.value=="" || langid.value==null)
			{
			alert("Select the language name");
			langid.focus();
			return false;
			}		
						
		if(trim(contenttxt.value)=="" || trim(contenttxt.value)==null)
			{
			alert("Enter the content txt name");
			contenttxt.focus();
			return false;
			}		
						
		if(trim(contentvalue.value)=="" || trim(contentvalue.value)==null )
			{
			alert("Enter the content value");
			contentvalue.focus();
			return false;
			}
		
	return true; 
	}
}
//LangContent validate end






function partner_validate(field,e)
{
	with (field)
	{
//		if(trim(PARTNER_NAME.value)=="" || trim(PARTNER_NAME.value)==null)
//		{
//			alert("Enter the Agent name");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
//		var parname=document.getElementById('PARTNER_NAME');		
//		if(!cha.test(parname.value) && parname.value!="") 
//		{
//			alert("Agent name only allowed in alphabets and numbers");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
                if(trim(PARTNER_USERNAME.value)=="" || trim(PARTNER_USERNAME.value)==null)
		{
			alert("Enter the Agent Name");
			PARTNER_USERNAME.focus();
			return false;
		}
		
		var parusername=document.getElementById('PARTNER_USERNAME');
                //var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9].+$/;
                var cha1 = /^[1-9]\d*(\.\d+)?$/;
//		if(!cha.test(parusername.value) && parusername.value!="") 
//		{
//			alert("Username only allowed in alphabets and numbers");
//			PARTNER_USERNAME.focus();
//			return false;
//		}
                
                if(trim(PARTNER_PASSWORD.value)=="" || trim(PARTNER_PASSWORD.value)==null)
		{
			alert("Enter the Password");
			PARTNER_PASSWORD.focus();
			return false;
		}
                
                if(trim(PARTNER_DEPOSIT.value)!="")
		{
			if(isNaN(PARTNER_DEPOSIT.value))
                        {
			alert("Amount only allowed in numbers");
			PARTNER_DEPOSIT.focus();
			return false;
                        }
                        if(!cha1.test(trim(PARTNER_DEPOSIT.value)) && PARTNER_DEPOSIT.value!="") 
                        {
                            alert("Special characters are not allowed in amount");
                            PARTNER_DEPOSIT.focus();
                            return false;
                        }
		}
                if(trim(PARTNER_REVENUE_SHARE.value)=="" || trim(PARTNER_REVENUE_SHARE.value)==null)
		{
			alert("Enter the commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		else if(isNaN(PARTNER_REVENUE_SHARE.value))
		{
			alert("Commission only allowed in numbers");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                if(!cha1.test(trim(PARTNER_REVENUE_SHARE.value)) && PARTNER_REVENUE_SHARE.value!="") 
		{
			alert("Special characters are not allowed in commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		var x = parseFloat(PARTNER_REVENUE_SHARE.value);
                if (isNaN(x) || x < 0 || x > 100) {
                       alert("Commission is out of range"); 
                       PARTNER_REVENUE_SHARE.focus();
		       return false;
                }
                var ds=PARTNER_DISTRIBUTOR;
                var dist=ds.options[ds.selectedIndex].value;
                if(trim(dist)==""){
                    alert("Please select the distributor");
                    PARTNER_DISTRIBUTOR.focus();
                    return false;
                }
                
                
		
		return true;
	}
}


function distributor_validate(field,e)
{
	with (field)
	{
//		if(trim(PARTNER_NAME.value)=="" || trim(PARTNER_NAME.value)==null)
//		{
//			alert("Enter the Distributor name");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		//var parname=document.getElementById('PARTNER_NAME');		
//		if(!cha.test(parname.value) && parname.value!="") 
//		{
//			alert("Distributor name only allowed in alphabets and numbers");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
                if(trim(PARTNER_USERNAME.value)=="" || trim(PARTNER_USERNAME.value)==null)
		{
			alert("Enter the Distributor Name");
			PARTNER_USERNAME.focus();
			return false;
		}
		
		var parusername=document.getElementById('PARTNER_USERNAME');
                //var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9].+$/;
                var cha1 = /^[1-9]\d*(\.\d+)?$/;
//		if(!cha.test(parusername.value) && parusername.value!="") 
//		{
//			alert("Username only allowed in alphabets and numbers");
//			PARTNER_USERNAME.focus();
//			return false;
//		}
                
                if(trim(PARTNER_PASSWORD.value)=="" || trim(PARTNER_PASSWORD.value)==null)
		{
			alert("Enter the Password");
			PARTNER_PASSWORD.focus();
			return false;
		}
                if(trim(PARTNER_TRANSACTION_PASSWORD.value)=="" || trim(PARTNER_TRANSACTION_PASSWORD.value)==null)
		{
			alert("Enter the Transaction Password");
			PARTNER_TRANSACTION_PASSWORD.focus();
			return false;
		}
                if(trim(PARTNER_DEPOSIT.value)!="")
		{
			if(isNaN(PARTNER_DEPOSIT.value))
                        {
			alert("Amount only allowed in numbers");
			PARTNER_DEPOSIT.focus();
			return false;
                        }
                        if(!cha1.test(trim(PARTNER_DEPOSIT.value)) && PARTNER_DEPOSIT.value!="") 
                        {
                            alert("Special characters are not allowed in amount");
                            PARTNER_DEPOSIT.focus();
                            return false;
                        }
		}
		
                if(trim(PARTNER_REVENUE_SHARE.value)=="" || trim(PARTNER_REVENUE_SHARE.value)==null)
		{
			alert("Enter the commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		else if(isNaN(PARTNER_REVENUE_SHARE.value))
		{
			alert("Commission only allowed in numbers");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                if(!cha1.test(trim(PARTNER_REVENUE_SHARE.value)) && PARTNER_REVENUE_SHARE.value!="") 
		{
			alert("Special characters are not allowed in commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		var x = parseFloat(PARTNER_REVENUE_SHARE.value);
                if (isNaN(x) || x < 0 || x > 100) {
                       alert("Commission is out of range"); 
                       PARTNER_REVENUE_SHARE.focus();
		       return false;
                }

                
		
		return true;
	}
}


function updatepartner_validate(field,e)
{
	with (field)
	{
//		if(trim(PARTNER_NAME.value)=="" || trim(PARTNER_NAME.value)==null)
//		{
//			alert("Enter the Agent name");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		var parname=document.getElementById('PARTNER_NAME');		
//		if(!cha.test(parname.value) && parname.value!="") 
//		{
//			alert("Agent name only allowed in alphabets and numbers");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
                if(trim(PARTNER_USERNAME.value)=="" || trim(PARTNER_USERNAME.value)==null)
		{
			alert("Enter the Agent Name");
			PARTNER_USERNAME.focus();
			return false;
		}
		
		var parusername=document.getElementById('PARTNER_USERNAME');		
//		if(!cha.test(parusername.value) && parusername.value!="") 
//		{
//			alert("Username only allowed in alphabets and numbers");
//			PARTNER_USERNAME.focus();
//			return false;
//		}
                
                if(trim(PARTNER_REVENUE_SHARE.value)=="" || trim(PARTNER_REVENUE_SHARE.value)==null)
		{
			alert("Enter the Revenue share");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                var cha1 = /^[1-9]\d*(\.\d+)?$/;
                if(trim(PARTNER_REVENUE_SHARE.value)!=""){
                if(isNaN(PARTNER_REVENUE_SHARE.value))
		{
			alert("Revenue share only allowed in numbers");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                }
                //alert(trim(PARTNER_REVENUE_SHARE.value));
                if(!parseInt(trim(PARTNER_REVENUE_SHARE.value))) 
		{
			alert("Special characters are not allowed in commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		var x = parseFloat(PARTNER_REVENUE_SHARE.value);
                if (isNaN(x) || x < 0 || x > 100) {
                       alert("Commission is out of range"); 
                       PARTNER_REVENUE_SHARE.focus();
		       return false;
                }
		
		return true;
	}
}

function updatedistributor_validate(field,e)
{
	with (field)
	{
//		if(trim(PARTNER_NAME.value)=="" || trim(PARTNER_NAME.value)==null)
//		{
//			alert("Enter the Agent name");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		var parname=document.getElementById('PARTNER_NAME');		
//		if(!cha.test(parname.value) && parname.value!="") 
//		{
//			alert("Agent name only allowed in alphabets and numbers");
//			PARTNER_NAME.focus();
//			return false;
//		}
		
                if(trim(PARTNER_USERNAME.value)=="" || trim(PARTNER_USERNAME.value)==null)
		{
			alert("Enter the Distributor Name");
			PARTNER_USERNAME.focus();
			return false;
		}
		
		var parusername=document.getElementById('PARTNER_USERNAME');		
//		if(!cha.test(parusername.value) && parusername.value!="") 
//		{
//			alert("Username only allowed in alphabets and numbers");
//			PARTNER_USERNAME.focus();
//			return false;
//		}
                
                if(trim(PARTNER_REVENUE_SHARE.value)=="" || trim(PARTNER_REVENUE_SHARE.value)==null)
		{
			alert("Enter the Revenue share");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                var cha1 = /^[1-9]\d*(\.\d+)?$/;
                if(trim(PARTNER_REVENUE_SHARE.value)!=""){
                if(isNaN(PARTNER_REVENUE_SHARE.value))
		{
			alert("Revenue share only allowed in numbers");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
                }
                //alert(trim(PARTNER_REVENUE_SHARE.value));
                if(!parseInt(trim(PARTNER_REVENUE_SHARE.value))) 
		{
			alert("Special characters are not allowed in commission");
			PARTNER_REVENUE_SHARE.focus();
			return false;
		}
		var x = parseFloat(PARTNER_REVENUE_SHARE.value);
                if(isNaN(x) || x < 0 || x > 100){
                       alert("Commission is out of range"); 
                       PARTNER_REVENUE_SHARE.focus();
		       return false;
                }
		
		return true;
	}
}

function register_validate(field,e)
{
	with (field)
	{
		if(trim(USERNAME.value)=="" || trim(USERNAME.value)==null)
		{
			alert("Enter the user name");
			USERNAME.focus();
			return false;
		}
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
                var cha2=/^[a-zA-Z]+$/;
		var parname=trim(document.getElementById('USERNAME').value);		
//		if(!cha.test(USERNAME.value) && USERNAME.value!="") 
//		{
//			alert("user name only allowed in alphabets and numbers");
//			USERNAME.focus();
//			return false;
//		}
                
		if(parname.length<4){
                        alert("user name should have minimum 4 characters");
                        USERNAME.focus();
			return false;
                }
                if(parname.length>15){
                        alert("user name should have maximum 15 characters");
                        USERNAME.focus();
			return false;
                }
		if(trim(PASSWORD.value)=="" || trim(PASSWORD.value)==null)
		{
			alert("Enter the Password");
			PASSWORD.focus();
			return false;
		}
                
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(trim(EMAIL.value)!=''){
                if(reg.test(EMAIL.value)==false)
		{
			alert("Invalid Email Address");
			EMAIL.focus();
			return false;
		}
                }
		/*if(trim(dobday.value)=="DD" || trim(dobday.value)==null)
		{
			alert("Select the day");
			dobday.focus();
			return false;
		}
                if(trim(dobmonth.value)=="MM" || trim(dobmonth.value)==null)
		{
			alert("Select the month");
			dobmonth.focus();
			return false;
		}
		if(trim(dobyear.value)=="YYYY" || trim(dobyear.value)==null)
		{
			alert("Select the year");
			dobyear.focus();
			return false;
		}
		if(trim(country.value)=="" || trim(country.value)==null)
		{
			alert("Select the Country");
			country.focus();
			return false;
		}
		
		if(trim(state.value)=="" || trim(state.value)==null)
		{
			alert("Select the State");
			state.focus();
			return false;
		}*/
		var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9]+$/;
//                if(trim(PROMO_DEPOSIT.value)=="" || trim(PROMO_DEPOSIT.value)==null)
//		{
//			alert("Enter the amount");
//			PROMO_DEPOSIT.focus();
//			return false;
//		}
                if(trim(PROMO_DEPOSIT.value)!=""){
                    if(isNaN(PROMO_DEPOSIT.value))
                    {
                            alert("Amount only allowed in numbers");
                            PROMO_DEPOSIT.focus();
                            return false;
                    }
                    if(!cha1.test(trim(PROMO_DEPOSIT.value)) && trim(PROMO_DEPOSIT.value)!="") 
                    {
                            alert("Special characters are not allowed in amount");
                            PROMO_DEPOSIT.focus();
                            return false;
                    }
                }
                var ds=PARTNER_DISTRIBUTOR;
                var dist=ds.options[ds.selectedIndex].value;
                if(trim(dist)==""){
                    alert("Please select the distributor");
                    ds.focus();
                    return false;
                }
                
                var ag=USERPARTNER_ID;
                var agt=ag.options[ag.selectedIndex].value;
                if(trim(agt)==""){
                    alert("Please select the agent");
                    ag.focus();
                    return false;
                }
                
                
                if(trim(PARTNER_CITY.value)!=""){
                    if(!cha2.test(trim(PARTNER_CITY.value)) && trim(PARTNER_CITY.value)!="") 
                    {
			alert("City only allowed in alphabets");
			PARTNER_CITY.focus();
			return false;
                    }
                }
                
		
		return true;
	}
}

function balanceadjustment(field,e)
{
        with (field)
	{
		if(trim(USERNAME.value)=="" || trim(USERNAME.value)==null)
		{
			alert("Select the user name");
			USERNAME.focus();
			return false;
		}
                var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		var parname=trim(document.getElementById('USERNAME').value);		
//		if(!cha.test(USERNAME.value) && USERNAME.value!="") 
//		{
//			alert("user name only allowed in alphabets and numbers");
//			USERNAME.focus();
//			return false;
//		}
                if(calc.value=="" || calc.value==null)
                {
                        alert("Select the adjustment");
			calc.focus();
			return false;
                }
                var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9]+$/;
                if(trim(cash.value)=="" || trim(cash.value)==null)
		{
			alert("Enter the amount");
			cash.focus();
			return false;
		}
		else if(isNaN(trim(cash.value)))
		{
			alert("amount allowed in numbers");
			cash.focus();
			return false;
		}
                if(!cha1.test(trim(cash.value)) && trim(cash.value)!="") 
		{
			alert("Special characters are not allowed in amount");
			cash.focus();
			return false;
		}
                
                
              return true;  
        }        
}

function transferadjustment(field,e)
{
        with (field)
	{
                var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9]+$/;
                if(trim(points.value)=="" || trim(points.value)==null)
		{
			alert("Enter the point");
			points.focus();
			return false;
		}
		else if(isNaN(trim(points.value)))
		{
			alert("point allowed in numbers");
			points.focus();
			return false;
		}
                if(!cha1.test(trim(points.value)) && trim(points.value)!="") 
		{
			alert("Special characters are not allowed in amount");
			points.focus();
			return false;
		}
                
                
              return true;  
        }        
}

function transferalladjustment(field,e)
{
        with (field)
	{
                var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9]+$/;
                if(trim(USERID.value)=="" || trim(USERID.value)==null)
		{
			alert("Enter the Userid");
			USERID.focus();
			return false;
		}
                if(trim(points.value)=="" || trim(points.value)==null)
		{
			alert("Enter the point");
			points.focus();
			return false;
		}
		else if(isNaN(trim(points.value)))
		{
			alert("point allowed in numbers");
			points.focus();
			return false;
		}
                if(!cha1.test(trim(points.value)) && trim(points.value)!="") 
		{
			alert("Special characters are not allowed in amount");
			points.focus();
			return false;
		}
                
                
              return true;  
        }        
}

function userbalanceadjustment(field,e)
{
        with (field)
	{
		if(calc.value=="" || calc.value==null)
                {
                        alert("Select the adjustment");
			calc.focus();
			return false;
                }
                var cha1 = /^[0-9]{0,1}[0-9]*[\s]{0,1}[0-9]+$/;
                if(trim(cash.value)=="" || trim(cash.value)==null)
		{
			alert("Enter the amount");
			cash.focus();
			return false;
		}
		else if(isNaN(trim(cash.value)))
		{
			alert("amount allowed in numbers");
			cash.focus();
			return false;
		}
                if(!cha1.test(trim(cash.value)) && trim(cash.value)!="") 
		{
			alert("Special characters are not allowed in amount");
			cash.focus();
			return false;
		}
                
                
              return true;  
        }        
}



/* IP BLOCK section */
function checkAction(ob,chk)
{
    if(chk>10) chk=10;
	var cbox;
	var val;

	if(ob.checked==true){
		val=true; 
		document.getElementById('chck').innerHTML="Uncheck All";
		document.check_box['checkall'].value=1;
	}
	else 
	{
		val=false;
		document.getElementById('chck').innerHTML="Check All";
	}
	
	for (var i = 1; i <= chk; i++) {
		cbox=document.check_box['c'+i];
		cbox.checked=val;
    }
    return true;

	
}

function bulkipvalidation()
{	
	var flag=0;
	var	cbox;
	var chk=document.check_box['totalcheck'].value;
	for (var i = 1; i <= chk; i++) {
		cbox=document.check_box['c'+i];
		if(cbox.checked==true)
			flag=1;			
    }
	
	if(flag==0) 
	{
		alert("Select IP");	
		return false;
	}
	
	if(document.check_box['bulkaction'].value==1) 
	{
		alert("Select action");	
		return false;
	}	
    return true;
}
function isValidIPAddress(ipaddr) {
   var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/;
   if (re.test(ipaddr)) {
      var parts = ipaddr.split(".");
      if (parseInt(parseFloat(parts[0])) == 0) {return false;}
      for (var i=0; i<parts.length; i++) {
         if (parseInt(parseFloat(parts[i])) > 255) {return false;}
      }
      return true;
   } else {
      return false;
   }
}

function searchIPValidation()
{var ipaddr=document.searchform['ip'].value;

	if(ipaddr.length>0)
	{
		/* var st=trim(ipaddr);
		if(st.length==0){
			
		}*/
		if(isValidIPAddress(ipaddr)==false)
		{
			alert("Invalid IP format");	
			return false;
		}
	}
	if(dateCheck()==false) return false;
	return true;
}

function dateCheck()
{
  var objFromDate = document.getElementById("campaign_st_time").value;
  var objToDate = document.getElementById("campaign_end_time").value;
  var frmDate=new Array();
  
	objFromDate=objFromDate.substring(0,10) ;
	objToDate=objToDate.substring(0,10) ;

	frmDate=objFromDate.split("-",3);	
	ToDate=objToDate.split("-",3);
	
//	alert(objToDate.split("-",3));

objFromDate= frmDate[1] + "/" + frmDate[2] +"/" + frmDate[0];
objToDate= ToDate[1] + "/" + ToDate[2] +"/" + ToDate[0];
 var date1 = new Date(objFromDate);
 var date2 = new Date(objToDate);
 var date3 = new Date();
 var date4 = (date3.getMonth()+1) + "/" + date3.getDate() + "/" + date3.getFullYear();

 var currentDate = new Date(date4);

//alert(currentDate);

   if(date1 > currentDate)
   {
         alert("From date should not be greater than current date");
         return false; 
   }
   else if(date2 > currentDate) 
  {
  alert("To date should be lesser than current date");
  	return false; 
  }
  else if(date1 > date2)
  {
         alert("From date should be lesser than to date");
         return false; 
  }

}
//****************************************Edit User details Valitions

function validate_registration()
{
	if(document.regForm.f.value=="pd")
	 {
	//duplicateChar(document.regForm.username.value,"_","Underscore occurs more than once");
	
	//ageLimit(document.regForm.dobyear.value);
	if(document.regForm.username.value=="")
	{
//		alert("Enter your username.");
//		document.getElementById("usernameavailability").innerHTML = "Enter your username"; 			
		document.getElementById("user").innerHTML = "Enter your username"; 			
		document.regForm.username.focus();
		return false;
	}else if(space1(document.regForm.username.value)==false){			
	document.getElementById("user").innerHTML="Space not allowed in username";		
	document.regForm.username.focus();
	return false;
	}
	var txt=new Array();
	txt=document.regForm.username.value;

	if(document.regForm.username.value.length<4)
	{
//		alert("Your username should have minimum 4 Characters maximum of 15 Characters.");
//document.getElementById("usernameavailability").innerHTML = "Your username should have minimum 4 Characters maximum of 15 Characters";
		document.getElementById("user").innerHTML = "Username should have min. 4 characters <br/> max. of 15 characters";
		document.regForm.username.focus();
		return false;
	}

	if(document.regForm.username.value.length>15)
	{
//		alert("Your username should have minimum 4 Characters maximum of 15 Characters.");
//document.getElementById("usernameavailability").innerHTML = "Your username should have minimum 4 Characters maximum of 15 Characters";
		document.getElementById("user").innerHTML = "Username should have max. of 15 characters";
		document.regForm.username.focus();
		return false;
	}
	
	 if(firstChar(txt," character should be alphabet or numeric","user")==false){			//duplicateChar(txtboxvalue,c,err)
//	txtuser.focus();
	return false;
	}else if(duplicateChar(txt," ","Space not allowed in username","user")==false){			//duplicateChar(txtboxvalue,c,err)
//	txtuser.focus();
	return false;
	}else if(duplicateChar(txt,"_","Underscore not allowed more than once","user")==false){			//duplicateChar(txtboxvalue,c,err)
	//	txtuser.focus();
		return false;
	}else if(duplicateChar(txt,".","Dot not allowed more than once","user")==false){			//duplicateChar(txtboxvalue,c,err)
	//	txtuser.focus();
		return false;
	}else if(specialChar(txt,"Special Characters Not allowed","user")==false){ 
		//txtuser.focus();
		return false;
	}
	
	if (document.regForm.email.value==""){
//				alert("Please enter your e-mail id.");
//		document.getElementById("emailavailability").innerHTML="Please enter your e-mail id";
		document.getElementById("emailerr").innerHTML="Please enter your e-mail id";
			document.regForm.email.focus();
				return false;
			}
			else if(space1(document.regForm.email.value)==false){			
		 	document.getElementById("emailerr").innerHTML="Space not allowed in email";		
			document.regForm.email.focus();
			return false;
			}	
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,5})$/;
			var address = document.regForm.email.value;
			if(firstChar(address," character should be alphabet or numeric","emailerr")==false){			//duplicateChar(txtboxvalue,c,err)
						//	txtuser.focus();
				return false;
			}
			
			if(reg.test(address) == false) {
//			alert('Invalid Email Address');
//			document.getElementById("passworderr").innerHTML="Invalid Email Address";
			document.getElementById("emailerr").innerHTML="Invalid Email Address";
			document.regForm.email.focus();
			return false;
			}else if(duplicateChar(address," ","Space not allowed in email","emailerr")==false){			//duplicateChar(txtboxvalue,c,err)
//				txtuser.focus();
				return false;
			}else if(duplicateChar(address,"_","Underscore not allowed more than once in email","emailerr")==false){			//duplicateChar(txtboxvalue,c,err)
			//	txtuser.focus();
				return false;
			}else if(emailFormat(address)==false){
				document.getElementById("emailerr").innerHTML="Invalid Email Address";
				return false;	
			}
}//if condn end for pd
			if(document.regForm.f.value=="w")
			   {
					if(document.regForm.balanceType.value==0)
					{
					alert("Please choose  balance type");
					document.regForm.balanceType.focus();
					return false;
					}
					if(document.regForm.calc.value=="")
					{
					alert("Please choose  action");
					document.regForm.calc.focus();
					return false;
					}
					if(document.regForm.comment.value=="")
					{
					alert("Please enter  comment");
					document.regForm.comment.focus();
					return false;
					}
					
				if(document.regForm.calc.value=="Remove")
					{
					
						if(document.regForm.gold.value > document.regForm.bgold.value)
						{
							alert("cannot remove goldbalance");
							document.regForm.gold.focus();
							return false;
						}
						if(document.regForm.platinum.value > document.regForm.bplatinum.value)
						{
							alert("cannot remove Platinum");
							document.regForm.platinum.focus();
							return false;
						}
						if(document.regForm.cash.value > document.regForm.bcash.value)
						{
							alert("cannot remove cash");
							document.regForm.cash.focus();
							return false;
						}
					
					
					}	
			   }
		
 
return true;
}

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function trims(s)
{var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not a whitespace, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (c != " ") returnString += c;
    }
    return returnString;
}
function stripCharsInBag(s, bag)
{var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
var bracket=3
strPhone=trims(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

function ValidateForm(){
	var Phone=document.frmSample.txtPhone
	
	if ((Phone.value==null)||(Phone.value=="")){
		alert("Please Enter your Phone Number")
		Phone.focus()
		return false
	}
	if (checkInternationalPhone(Phone.value)==false){
		alert("Please Enter a Valid Phone Number")
		Phone.value=""
		Phone.focus()
		return false
	}
	return true
 }

//*****************************************Edit User Deatails END
function validateCoin()
{
	var coin_name=document.frm['coin-name'].value;
	var coin_value=document.frm['coin-value'].value;
	var ch = /[a-zA-z]/;	
	var ch1 = /[0-9]/;
	if(trim(coin_name)=="") {
		alert("Coin name is empty");
		document.frm['coin-name'].focus();
		return false;
	}else if(!ch.test(coin_name))
	{
		alert("Alphabets only allowed");
		document.frm['coin-name'].focus();
		return false;
	}else if(trim(coin_value)=="") {
		alert("Coin value is empty");
		document.frm['coin-value'].focus();
		return false;
	}
	else if(!ch1.test(coin_value)) {
		alert("Coin value should be numbers only");
		document.frm['coin-value'].focus();
		return false;
	}
	return true;
}




//Mcat validate Start
function mcatvalidate(field)
{	
	with (field)
	{	 	
		if(trim(mcatname.value)=="" || trim(mcatname.value)==null)
			{
			alert("Enter the main category name");
			mcatname.focus();
			return false;
			}
			
		var cha = /[a-zA-z]/;
		var linkage=document.getElementById('mcatname');		
		 if(!cha.test(linkage.value) && linkage.value!="") {
				alert("Alphabets only allowed in main category");
				linkage.focus();
				return false;
			}			
						
		if(trim(mcatdesc.value)=="" || trim(mcatdesc.value)==null )
			{
			alert("Enter the main category description");
			mcatdesc.focus();
			return false;
			}
		
	return true; 
	}
}


//Level validate Start
function levelvalidate(field)
{	
	with (field)
	{	 	
						
		if(trim(levelname.value)=="" || trim(levelname.value)==null)
			{
			alert("Enter the level name");
			levelname.focus();
			return false;
			}
		
		
		if(isNaN(levelname.value)==true)
			{
			alert("Level name should be numeric only");
			levelname.value="";
			levelname.focus();
			return false;
		}
		
		if(levelname.value!="")
		{
		if (/^ *[0-9]+ *$/.test(levelname.value))
		{
		}
		else
		{
		alert("Decimal number not allowed! please re-enter the level name\n");
		levelname.value="";
		levelname.focus();
		return false;
		}
		}		
		if(trim(points.value)=="" || trim(points.value)==null)
			{
			alert("Enter the points");
			points.focus();
			return false;
			}	
			
		 if(isNaN(points.value)==true)
			{
			alert("Points value should be numeric only");
			points.value="";
			points.focus();
			return false;
		}	
			
		if(trim(levdesc.value)=="" || trim(levdesc.value)==null )
			{
			alert("Enter the level description");
			levdesc.focus();
			return false;
			}
		
	return true; 
	}
}









// InventoryItem Validations - END

function fileUpload(total,nameVar)
{
	alert(total + "- " +  nameVar);
	if(total!="" || total!=0)	
	{	
		for(i=1;i<=total;i++)
		{
			nameVar=nameVar  + i;
			var f=document.getElementById("'"+ nameVar + "'" );
			if(f){
				if(trim(f.value)==''){
					alert("Select file to upload");
					f.focus();
					return false;
				}

			}else alert(nameVar + " Not Found");
		}
	}
	return true;
}







//***************Npc Management*************************//

function check_isNaN(ths)
{
	var value = ths.value;
	var id = ths.id;
	
	if(isNaN(value))
	{
		document.getElementById(id).value = '';
		return false;
	}
}

function check_not_isNaN(ths)
{
	var value = ths.value;
	var id = ths.id;
	
	if(!isNaN(value))
	{
		document.getElementById(id).value = '';
		return false;
	}
}


 


function get_location(val,mode,id)
{
	var httpxml;
	try
	{
		httpxml = new XMLHttpRequest();    // Firefox, Opera 8.0+, Safari
	}
	catch (e)
	{
		try     // Internet Explorer
		{
			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	 
	var url = "ajaxgetdata.php";
	url = url+"?val="+val+"&mode="+mode+"&id="+id+"&type=npc_location";
	httpxml.onreadystatechange = function()
	{
		if( httpxml.readyState == 1 )
		{
			document.getElementById('npc_zr_id').innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>&nbsp;</div><div class='AvrsubRtext'><img src='images/ajax-loader.gif' width='16' height='16' border='0'></div></div></div>";
			//alert('1');
		}
		if( httpxml.readyState == 2 )
		{
			document.getElementById('npc_zr_id').innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>&nbsp;</div><div class='AvrsubRtext'><img src='images/ajax-loader.gif' width='16' height='16' border='0'></div></div></div>";	
			//alert('2');			
			
		}
		if( httpxml.readyState == 3 )
		{
			document.getElementById('npc_zr_id').innerHTML = "<div class='AvrsubWrap'><div class='AvrsubLtext'>&nbsp;</div><div class='AvrsubRtext'><img src='images/ajax-loader.gif' width='16' height='16' border='0'></div></div></div>";	
			//alert('3');
		}
		
		if( httpxml.readyState == 4 || httpxml.readyState == "Complete")
		{		 
			document.getElementById('npc_zr_id').innerHTML = httpxml.responseText;
		}
	}
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}

// *************** Chumba Configuration ************************* //


// *************** Chumba Default Settings Configuration ************************* //


function divCancel(id,ids)
{
	document.getElementById(id).style.display = 'block';
	document.getElementById(ids).style.display = 'none';
}

function ajaxCcedit(id)
{
	var httpxml;
	try
	{
		httpxml = new XMLHttpRequest();    // Firefox, Opera 8.0+, Safari
	}
	catch (e)
	{
		try     // Internet Explorer
		{
			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	 
	var url = global_baseurl+"application/helpers/ajaxgetdata_helper.php";
	url = url+"?id="+id+"&type=ccvEDIT";
	httpxml.onreadystatechange = function()
	{
		if( httpxml.readyState == 1 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		if( httpxml.readyState == 2 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
			
		}
		if( httpxml.readyState == 3 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		
		if( httpxml.readyState == 4 || httpxml.readyState == "Complete")
		{		 
			document.getElementById('ccVALUE_'+id).innerHTML = httpxml.responseText;
		}
	}
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}

function ajaxccUPDATE(id,vle,state)
{
	if(state == 'update')
		val = document.getElementById('edit_vlaue_'+id).value;	
	else
		val = vle;	
		
	var httpxml;
	try
	{
		httpxml = new XMLHttpRequest();    // Firefox, Opera 8.0+, Safari
	}
	catch (e)
	{
		try     // Internet Explorer
		{
			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	 
	var url = "ajaxgetdata.php";
	url = url+"?val="+val+"&id="+id+"&type=ccvUPDATE";
	httpxml.onreadystatechange = function()
	{
		if( httpxml.readyState == 1 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		if( httpxml.readyState == 2 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
			
		}
		if( httpxml.readyState == 3 )
		{
			document.getElementById('ccVALUE_'+id).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		
		if( httpxml.readyState == 4 || httpxml.readyState == "Complete")
		{		 
			document.getElementById('ccVALUE_'+id).innerHTML = httpxml.responseText;
		}
	}
	httpxml.open("GET",url,true);
	httpxml.send(null);	
}




//*************** USER STATUS DESCRIPTION AJAX *************************
function openDESCRIPTION_Div(id)
{
	if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user wil get unauthenticated"))
	{
            
		document.getElementById('userSID').value = id;
		Popup.show('user_status_desc');
	}
}
function UserDeActivateDescription() 
{
	var httpxml;
	try
	{
		httpxml = new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
	}
	catch (e)
	{
		try  // Internet Explorer
		{
			httpxml = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				httpxml = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	var file = 'ajaxgetdata.php';
	var id   = document.getElementById('userSID').value;	
	var desc = document.getElementById('desc_status').value;
	var type = 'UpdateUserStatusDeactive';
	var adminId  = document.getElementById('adminId').value;
	
	var url=file +"?uid=" + id +"&type=" + type + "&desc=" + desc + "&adminId=" + adminId;
	
	
	httpxml.onreadystatechange = function()
	{	
		if(httpxml.readyState == 1)
		{
			document.getElementById('saved_desc').innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		
		if(httpxml.readyState == 2)
		{
			document.getElementById('saved_desc').innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		
		if(httpxml.readyState == 3)
		{
			document.getElementById('saved_desc').innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}
		
		if(httpxml.readyState==4)
		{
			document.getElementById('saved_desc').innerHTML = httpxml.responseText;
			var ele = 'dact'+id;
			authenticate('ajaxgetdata.php',ele,id,'status','dact');
		}
	}
	httpxml.open("GET",url,true);
	httpxml.send(null);
}

//*************** Quest Management *************************




function gamrep()
{	
document.tsearchform.st_time.value="";
document.tsearchform.end_time.value="";	
document.tsearchform.monthly.value="";	
//document.tsearchform.submit();		
return true; 	
}

function lrchk(form)
{	

if(document.tsearchform.monthly.value!=0)
{
document.tsearchform.st_time.value="";
document.tsearchform.end_time.value="";	
document.tsearchform.today.checked=false;
}
//document.tsearchform.submit();		
return true; 	
}
function txt()
{
	//alert("sdsd");
	document.tsearchform.today.checked=false;
	document.tsearchform.monthly.value="";	

}
function montxt()
{
	//alert("sdsd");
	document.tsearchform.monthly.value="";	

}

function month()
{
	if(document.tsearchform.gameid.value=="")
			{
			alert("Please choose  gametype");
			document.tsearchform.gameid.focus();
			return false;
			}	
			return true;
			
			
}
function commonw(file,ele,id,type,att)
{	
//alert(id);
if(att == "ppetype")
{
$pp_type = document.getElementById('pp_type').value;	
}

	element=ele;
	
	document.getElementById(element).style.display = 'block';
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
	alert ("Browser does not support HTTP Request")
	return
	} 
	if(att == "ppetype")
	{
	var url=file +"?id=" + id +"&type=" + type +"&att=" +att +"&pp_type=" +$pp_type;
	}
	else
	{
	var url=file +"?id=" + id +"&type=" + type +"&att=" +att;	
	}
	//alert(url);
	xmlHttp.onreadystatechange=function()
  {
		if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
		{
			document.getElementById(element).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
		{
			
			document.getElementById(element).innerHTML = xmlHttp.responseText;	
			if(document.getElementById(element).innerHTML != "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>"){
				
			commonPromo(file,'prtype',id,'protype','pprtype');}
		}
  }
	
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)	
}

function commonPromo(file,ele,id,type,att)
{	
	if(att == "pprtype")
	{
	$pro_type = document.getElementById('pro_type').value;	
	}

	element=ele;

	document.getElementById(element).style.display = 'block';
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
	{
	alert ("Browser does not support HTTP Request")
	return
	} 
	 if(att == "pprtype")
	{
	var url=file +"?id=" + id +"&type=" + type +"&att=" +att +"&pro_type=" +$pro_type;
	}
	else
	{
	var url=file +"?id=" + id +"&type=" + type +"&att=" +att;	
	}
	//alert(url);
	xmlHttp.onreadystatechange=function()
	{
		if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
		{
			document.getElementById(element).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
		}

		if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
		{
			document.getElementById(element).innerHTML = xmlHttp.responseText;			
		}
	}

	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)	
}	
	
function common(file,ele,type,id,att)
{	
	if(att == 'url')
	{
		if(document.getElementById('PROMO_CAMPAIGN_CODE').value=="")
			{
				alert("Please Generate  campaign code first");
				document.regForm.PROMO_CAMPAIGN_CODE.focus();
				return false;	
			}
	}
	else
	{
			if(document.getElementById('PROMO_CAMPAIGN_TYPE_ID').value=="")
			{
				alert("Please choose  campaign type first");
				document.regForm.PROMO_CAMPAIGN_TYPE_ID.focus();
				return false;	
			}

	}
	xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
		alert ("Browser does not support HTTP Request")
		return
		} 
	var url=file +"?type=" + type + "&id=" + id + "&att=" + att;
	//alert(url);
	
	xmlHttp.onreadystatechange=function()
		 {
			/*if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
				{
					document.getElementById(ele).innerHTML = "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>";
				}*/

			if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
				{
					//alert(xmlHttp.responseText);
					document.getElementById(ele).value = xmlHttp.responseText;			
				}
		}
	
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)	
}
	
//Common ajax start by Stalin
function authenticate(file,ele,id,type,att)
{
	element=ele;	
	if(att =='logip_dact' || att =='logip_act')
	{
		var m = "ldef"+id;
	}
	else
	{
		var m = "def"+id;
	}
	if(att=='msub_dact')
	{
		var a = confirm("Do you really want to unauthenticate this subcategory? If so all the details related to this user wil get unauthenticated");	
		var d = "act"+id;
	}
	else if(att=='msub_act')
	{
		var a = confirm("Do you really want to authenticate this subcategory? If so all the details related to this user will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='dact')
	{
		// var a = confirm("Do you really want to unauthenticate this user? If so all the details related to this user wil get unauthenticated");
		var a = true;
		var d = "act"+id;
	}
	else if(att=='act')
	{
		var a = confirm("Do you really want to authenticate this user? If so all the details related to this user will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='adm_dact')
	{
		var a = confirm("Do you really want to unauthenticate this admin? If so all the details related to this admin wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='adm_act')
	{
		var a = confirm("Do you really want to authenticate this admin? If so all the details related to this admin will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='level_dact')
	{
		var a = confirm("Do you really want to unauthenticate this level? If so all the details related to this level wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='level_act')
	{
		var a = confirm("Do you really want to authenticate this level? If so all the details related to this level will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='zone_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Zone? If so all the details related to this Zone wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='zone_act')
	{
		var a = confirm("Do you really want to authenticate this zone? If so all the details related to this zone will get authenticated");
		var d = "dact"+id;
	}		
	else if(att=='room_dact')
	{
		var a = confirm("Do you really want to unauthenticate this room? If so all the details related to this room wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='room_act')
	{
		var a = confirm("Do you really want to authenticate this room? If so all the details related to this room will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='mainc_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Main category? If so all the details related to this Main category wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='mainc_act')
	{
		var a = confirm("Do you really want to authenticate this Main category? If so all the details related to this Main category will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='inven_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Inventory Items? If so all the details related to this Inventory Items wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='inven_act')
	{
		var a = confirm("Do you really want to authenticate this Inventory Items? If so all the details related to this Inventory Items will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='quest_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Quest Items? If so all the details related to this Quest Items wil get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='quest_act')
	{
		var a = confirm("Do you really want to authenticate this Quest Items? If so all the details related to this Quest Items will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='npc_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Npc? If so all the details related to this Npc will get unauthenticated");
		var d = "act"+id;
	}
	else if(att=='npc_act')
	{
		var a = confirm("Do you really want to authenticate this Npc? If so all the details related to this Npc will get authenticated");
		var d = "dact"+id;
	}
	else if(att=='news_dact')
	{
		var a = confirm("Do you really want to unauthenticate this news? If so all the details related to this news wil get unauthenticated");
		var d = "act"+id;		
	}
	else if(att=='news_act')
	{
		var a = confirm("Do you really want to authenticate this news? If so all the details related to this news will get authenticated");
		var d = "dact"+id;			
	}
	else if(att=='member_dact')
	{
		var a = confirm("Do you really want to unauthenticate this membership? If so all the details related to this membership will get unauthenticated"); 
		var d = "act"+id;		
	}
	else if(att=='member_act')
	{
		var a = confirm("Do you really want to authenticate this membership? If so all the details related to this membership will get authenticated");	 
		var d = "dact"+id;		
	}
	else if(att=='vprod_dact')
	{
		var a = confirm("Do you really want to unauthenticate this product? If so all the details related to this product wil get unauthenticated");	 
		var d = "act"+id;
	}
	else if(att=='vprod_act')
	{
		var a = confirm("Do you really want to authenticate this Product? If so all the details related to this product will get authenticated");	 
		var d = "dact"+id;
	}
	else if(att=='serip_dact')
	{
		var a = confirm("Deactive registration action to particular IP address?"); 
		var d = "act"+id;
	}
	else if(att=='serip_act')
	{
		var a = confirm("Active registration action to particular IP address?"); 
		var d = "dact"+id;
	}
	else if(att=='logip_dact')
	{
		var a = confirm("Deactive registration action to particular IP address?");
		var d = "lact"+id;		
	}
	else if(att=='logip_act')
	{
		var a = confirm("Active registration action to particular IP address?");	 
		var d = "ldact"+id;		
	}
	else if(att=='part_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Partner? If so all the details related to this Partner wil get unauthenticated"); 
		var d = "act"+id;		
	}
	else if(att=='part_act')
	{
		var a = confirm("Do you really want to authenticate this Partner? If so all the details related to this Partner will get authenticated");	 
		var d = "dact"+id;		
	}
        else if(att=='dist_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Distributor? If so all the details related to this Distributor wil get unauthenticated"); 
		var d = "act"+id;		
	}
	else if(att=='dist_act')
	{
		var a = confirm("Do you really want to authenticate this Distributor? If so all the details related to this Distributor will get authenticated");	 
		var d = "dact"+id;		
	}	
	else if(att=='camp_dact')
	{
		var a = confirm("Do you really want to unauthenticate this Campaign? If so all the details related to this Campaign wil get unauthenticated"); 
		var d = "act"+id;		
	}
	else if(att=='camp_act')
	{
		var a = confirm("Do you really want to authenticate this Campaign? If so all the details related to this Campaign will get authenticated");
		var d = "dact"+id;
	}
        
	if(a)
	{
		document.getElementById(d).style.display = 'none';
		document.getElementById(element).style.display = 'block';
		document.getElementById(m).style.display = 'none';
		
		xmlHttp=GetXmlHttpObject()
		if (xmlHttp==null)
		{
			alert ("Browser does not support HTTP Request")
			return
		} 
		var url=global_baseurl+"application/helpers/"+file+"?id=" + id +"&type=" + type +"&att=" +att;
		
		xmlHttp.onreadystatechange=function()
		{	
			if( xmlHttp.readyState < 4 || xmlHttp.readyState!="Complete")
			{
				document.getElementById(element).innerHTML = "<img src='images/loading2.gif' width='16' height='16' border='0'>";
			}
			if (xmlHttp.readyState==4 || xmlHttp.readyState=="Complete")
			{
				document.getElementById(element).innerHTML = trim(xmlHttp.responseText);
			}
		}		
		xmlHttp.open("GET",url,true)
		xmlHttp.send(null)	
	}
	
}
// Validate url start
function is_valid_url(url)
{
     return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
}




function clearall()
{
    document.getElementById('START_DATE_TIME').value='';
    document.getElementById('END_DATE_TIME').value='';
    document.getElementById('AGENT_LIST').value='all';
    document.getElementById('USERNAME').value='';
}
function clearallsubagents()
{
    document.getElementById('START_DATE_TIME').value='';
    document.getElementById('END_DATE_TIME').value='';
    document.getElementById('USERNAME').value='';
}
function gthandid(field)
{	
	with (field)
	{				
		 if(HANDID.value=="" || HANDID.value==null)
			{
			alert("Enter the Hand Id");
			HANDID.focus();
			return false;
			}					
			
	return true; 
	}
}
function showuserslist()
{
    mywindow = window.open("view-agent-user-details.php", "Users", "location=0,status=0,scrollbars=0,  width=470,height=500");
    mywindow.moveTo(300, 200);
}
function showsearchsection(secid)
{
  if(secid=="agent")
  {  
    document.getElementById("agentsection").style.display = '';
    document.getElementById("distributorsection").style.display = 'none';   
    document.getElementById("distributorsection").value='';
    var e=document.getElementById("partnerlist");
    document.getElementById("partner_selection").value=e.options[e.selectedIndex].value;
  }else{
    document.getElementById("agentsection").style.display = 'none';
    document.getElementById("distributorsection").style.display = '';     
    document.getElementById("agentsection").value='';
    var e=document.getElementById("distributlist");
    document.getElementById("partner_selection").value=e.options[e.selectedIndex].value;
  } 
}

function setpartid(pid)
{
    document.getElementById("partner_selection").value=pid;
}

function password_validate(field,e)
{
    with (field)
	{
            if(trim(OLDPASSWORD.value)=="")
            {
            alert("Enter the old password");
            OLDPASSWORD.focus();
            return false;
            }
            if(trim(NEWPASSWORD.value)=="")
            {
            alert("Enter the new password");
            NEWPASSWORD.focus();
            return false;
            }
        }
}

function transactionpassword_validate(field,e)
{
    with(field)
	{
            if(trim(TRANS_OLDPASSWORD.value)=="")
            {
            alert("Enter the transaction old password");
            TRANS_OLDPASSWORD.focus();
            return false;
            }
            if(trim(TRANS_NEWPASSWORD.value)=="")
            {
            alert("Enter the transaction new password");
            TRANS_NEWPASSWORD.focus();
            return false;
            }
        }
}

function kiosk_validate(field,e)
{
	with(field)
	{
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		
        if(trim(USERNAME.value)=="" || trim(USERNAME.value)==null)
		{
			alert("Player Name Must Be Required!!");
			USERNAME.focus();
			return false;
		}
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
        var cha2=/^[a-zA-Z]+$/;
		var parname=trim(document.getElementById('USERNAME').value);		

                
		if(parname.length<4){
            alert("Player name should have minimum 4 characters");
            USERNAME.focus();
			return false;
		}
		if(parname.length>15){
			alert("Player name should have maximum 15 characters");
			USERNAME.focus();
			return false;
		}
		
		if(trim(EMAIL.value)=="" || trim(EMAIL.value)==null)
		{
			alert("Email Must Be Required");
			EMAIL.focus();
			return false;
		}
		
		if(trim(PARTNER_DISTRIBUTOR.value)=="" || trim(PARTNER_DISTRIBUTOR.value)==null)
		{
			alert("Distributor Must Be Required");
			PARTNER_DISTRIBUTOR.focus();
			return false;
		}
		
        if(trim(DEFAULT_POINTS.value)!="")
		{
			if(isNaN(DEFAULT_POINTS.value))
                        {
                            alert("Default amount only allowed in numbers");
                            DEFAULT_POINTS.focus();
                            return false;
                        }
                        
                        if(!cha1.test(trim(DEFAULT_POINTS.value)) && DEFAULT_POINTS.value!="") 
                        {
                            alert("Special characters are not allowed in default amount");
                            DEFAULT_POINTS.focus();
                            return false;
                        }
		}
	}
}

function assign_mac_validate(field,e)
{
	with(field)
	{
		
		
                
                var ds=PARTNER_AGENT;
		var dist=ds.options[ds.selectedIndex].value;
		if(trim(dist)==""){
			alert("Please select the agent");
			ds.focus();
			return false;
		}
		
                if(trim(MAC_ID.value)=="" || trim(MAC_ID.value)==null)
		{
			alert("Mac address Empty");
			MAC_ID.focus();
			return false;
		}

		
		var mac_address = /^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/;

		if(mac_address.test(MAC_ID.value)==false){
			alert("Invalid Mac Address");
			MAC_ID.focus();
			return false;
		}
				
		
	}
}


function admin_validate(field,e)
{
	with(field)
	{
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		
                if(trim(username.value)=="" || trim(username.value)==null)
		{
			alert("Enter the User Name");
			username.focus();
			return false;
		}
                
                if(trim(password.value)=="" || trim(password.value)==null)
		{
			alert("Enter the Password");
			password.focus();
			return false;
		}
                
                
		
	}
}

function edit_admin_validate(field,e)
{
	with(field)
	{
		
		var cha = /^[a-z0-9A-Z]{1}[a-z0-9A-Z]*[\s]{0,1}[a-z0-9A-Z]+$/;		
		
                if(trim(username.value)=="" || trim(username.value)==null)
		{
			alert("Enter the User Name");
			username.focus();
			return false;
		}
                
                if(trim(password.value)=="" || trim(password.value)==null)
		{
			alert("Enter the Password");
			password.focus();
			return false;
		}
                
                
		
	}
}