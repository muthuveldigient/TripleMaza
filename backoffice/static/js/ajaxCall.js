var gate=0;
var flag=0;
function ajaxCall(txt,errcontainer,fieldname,baseurl)
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
	{		//alert("");
		var txts=trim(httpxml.responseText);
// alert(txts.length + " *** " +httpxml.responseText );
		if(txts.length >0 && gate==0) 
		{
	//		alert("first call");
	 //		alert(txts.length + " "+ txts +" GATE "+gate);			
			gate=1;
		//	alert("sssss"+gate);
		}
		
		 
		
		//if(errcontainer=="termserr") alert(httpxml.responseText);
		
			document.getElementById(errcontainer).innerHTML=httpxml.responseText;
		/*if(errcontainer=='usernameavailability'){
			ajaxgetxmlcontent('index.php', 'checkduplicateusername', this.value, 'registererror');	
		}*/

	}
}
 
	var url="validations.php";
	url=url+"?var="+fieldname+"&txt="+txt;
	url=url+"&sid="+Math.random();

	httpxml.onreadystatechange=stateck;
	httpxml.open("GET",url,true);
	httpxml.send(null);
 
}

function pwdCheck(val,err,fieldname)
{
	if(document.regForm.password.value==document.regForm.cpassword.value){
		
	}else{
		ajaxCall('1',err,"mismatch");
	}
}

function checkBox(nme,err,vars)
 {
	if(nme="gterms") {
		if(document.regForm.gterms.checked==false) val=""; else val="true";
	}if(nme="grules") {
		if(document.regForm.grules.checked==false) val=""; else val="true";	
	}

	ajaxCall(val,err,vars);
	
 }
				   
function errorcall()
{
//	alert("before assign "+gate);
	gate=0;
	//alert("before assign "+gate);	
var err1=document.regForm.username.value;
var err2=document.regForm.password.value;
var err3=document.getElementById('cpassword').value;
var err4=document.getElementById('email').value;
var err5=document.getElementById('dobday').value;
var err6=document.getElementById('dobmonth').value;
var err7=document.getElementById('dobyear').value;
var err8=document.getElementById('number').value;

//var err9=document.getElementById('grules').value;

//var err10=document.getElementById('gterms').value;

if(document.regForm.gterms.checked==false) err9=""; else err9="true"
if(document.regForm.grules.checked==false) err10=""; else err10="true"


ajaxCall(err1,'usernameavailability','user');	

ajaxCall(err2,'passworderr','password');
/*
 if(gate==1)
{
	alert("error in password");
}else
{
	alert("No in password");
} */

//alert(gate);
ajaxCall(err3,'passworderr','rpassword');


//alert(gate);

ajaxCall(err4,'emailavailability','email');


ajaxCall(err5,'doberr','day');
ajaxCall(err6,'doberr','month');

ajaxCall(err7,'doberr','year');
ajaxCall(err8,'imgerr','vcode');

ajaxCall(err9,'ruleserr','rules');
ajaxCall(err10,'termserr','terms');
//alert (gate + " end "); 


if(gate==1){	
	alert(gate + "ss");	
	gate=0;
	return false;
}else{
	alert(gate + "dd");
return true;
}

}

function checkerror()
{

//alert ("At last"+gate);
if(gate==1){	
	gate=0;
	return false;
}

return true;
/*var msg1=document.getElementById("usernameavailability").innerHTML;
var msg2=document.getElementById("passworderr").innerHTML;
var msg3=document.getElementById("emailavailability").innerHTML;
var msg4=document.getElementById("doberr").innerHTML;
var msg5=document.getElementById("imgerr").innerHTML;
var msg6=document.getElementById("ruleserr").innerHTML;
var msg7=document.getElementById("termserr").innerHTML;
/*
if(msg1.length!=0 || msg2.length!=0 || msg3.length!=0 || msg4.length!=0 || msg5.length!=0 || msg6.length!=0 || msg7.length!=0)
{
 return false;	
}

if(msg1.length ==0 && msg2.length ==0 && msg3.length==0 ) 
return true;

return false;	
*/
}

function LTrim( value ) {
	
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
	
}

// Removes ending whitespaces
function RTrim( value ) {
	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
	
}
// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
}

// for  Admin add user page 
function errorClear(id){
	//alert("text");	
document.getElementById(id).innerHTML =''; 	
//document.getElementById('err').innerHTML =''; 		
}


//**************************************************
// Is Date CHECK
//**************************************************

function isDate(txtDate) {  
    var objDate,  // date object initialized from the txtDate string  
        mSeconds, // txtDate in milliseconds  
        day,      // day  
        month,    // month  
        year;     // year  
    // date length should be 10 characters (no more no less)  
    if (txtDate.length !== 10) {  
        return false;  
    }  
    // third and sixth character should be '/'  
    if (txtDate.substring(2, 3) !== '/' || txtDate.substring(5, 6) !== '/') {  
        return false;  
    }  
    // extract month, day and year from the txtDate (expected format is mm/dd/yyyy)  
    // subtraction will cast variables to integer implicitly  
    month = txtDate.substring(0, 2) - 1; // because months in JS start from 0  
    day = txtDate.substring(3, 5) - 0;  
    year = txtDate.substring(6, 10) - 0;  
    // test year range  
    if (year < 1000 || year > 3000) {  
        return false;  
    }  
    // convert txtDate to milliseconds  
    mSeconds = (new Date(year, month, day)).getTime();  
    // initialize Date() object from calculated milliseconds  
    objDate = new Date();  
    objDate.setTime(mSeconds);  
    // compare input date and parts from Date() object  
    // if difference exists then date isn't valid  
    if (objDate.getFullYear() !== year ||  
        objDate.getMonth() !== month ||  
        objDate.getDate() !== day) {  
        return false;  
    }  
    // otherwise return true  
    return true;  
}  
