function space1(txtboxvalue){ 
var flag=0;
var strText = txtboxvalue; 

if (strText!="") { 

var strArr = new Array();
//strArr = strText.split(" ");
strVal= txtboxvalue; 
strArr=strVal;
for(var i = 0; i < strArr.length ; i++) { 

if(strArr[i] == " ") { 
flag=1;       
break; } 
} 
if (flag==1) {
	//alert("Space not allowed."); 
	return false; 
	}
	}
	}

//chk=duplicateChar(id,'.','Special Characters not allowed more than once',contentarea,sourcearea);
function firstChar(txt,err,errarea)
{
	//var exp_username = /^[A-Za-z0-9]{3,20}$/;	
	var txt1=new Array();
	txt1=txt;
	
	 if (txt1[0]=="_" || txt1[0]=="." ) {
//			alert(txt1[0] + " Special Char Not allowed");
			document.getElementById(errarea).innerHTML = "First " + err;
			return false;
	 }
	 
 	 if (txt1[txt1.length-1]=="_" || txt1[txt1.length-1]=="." ) {
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
	

	 if (!exp_username.test(txt)) {
			//alert("Special Char Not allowed");
			document.getElementById(errarea).innerHTML = err;
			return false;
	 }
	/* if (!exp_email.test(txt)) {
			document.getElementById(errarea).innerHTML = err;
			return false;
	 }*/
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


function ageLimit(txtboxvalue)
{
	var year=eval(txtboxvalue);
	var curYear= new  Date();

	if((curYear.getFullYear() - year) < 13 ){ // 13 minimum
		alert("Under 13 Year is not allowed");
		return false;	
	}
	return true;
}

function ageCheck(startDate){	
	var curDate=new Date();

//	startDate="2006-01-17";
	//endDate="2006-03-11";
	endDate=curDate.getFullYear()+"-"+curDate.getMonth+"-"+curDate.getDay;
		
	curDate.DateDiff({interval:"Y",date1:startDate,date2:endDate});
	
	alert(curDate.difference);	
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

function isEmpyt(txt,errmsg,err){
	if(trim(txt)=="")
	{
		document.getElementById(err).innerHTML =errmsg;
		return false;		
	}


}

function blurTxt(o,errmsg)
{	//Empty uesrname check
	var txt=o.value;
	if(firstChar(txt,"Enter Password","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;		
	}
	else if(firstChar(txt," character should be alphabet or numeric","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;
	}else if(duplicateChar(txt," ","Space not allowed in password","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;
	}
	return true;
}

function blurUser(o)
{	//Empty uesrname check
	var o=document.getElementById("username");
	var txt=o.value;
	if(firstChar(txt,"Enter user name","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		o.focus();
		return false;		
	}
	if(space1(txt)==false){
			document.getElementById("errmsg").innerHTML="Space not allowed in username";
			return false;
	}
	else if(firstChar(txt," character should be alphabet or numeric","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
			o.focus();
	return false;
	}else if(duplicateChar(txt," ","Space not allowed in username","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
			o.focus();
	return false;
	}else if(duplicateChar(txt,"_","Underscore not allowed more than once","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
			o.focus();
	return false;
	}else if(duplicateChar(txt,".","Dot not allowed more than once","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
			o.focus();
	return false;
	}else if(specialChar(txt,"Special Characters Not allowed","errmsg")==false){ 
			o.focus();
	return false;	
	}
	return true;
}

function blurEmail(obj)
{	//Empty uesrname check
	var o=document.getElementById("email");
	var txt=o.value;
	if(firstChar(txt,"Enter email","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		o.focus();
		return false;		
	}
	else if(space1(txt)==false){
			document.getElementById("errmsg").innerHTML="Space not allowed in Email";
			return false;
	}
	else if(firstChar(txt," character should be alphabet or numeric","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)

	return false;
	}else if(duplicateChar(txt," ","Space not allowed in Email","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)

	return false;
	}else if(duplicateChar(txt,"_","Underscore not allowed more than once","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)

	return false;
	}else if(duplicateChar(txt,".","Dot not allowed more than once","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)

	return false;
	}else if(specialChar(txt,"Special Characters Not allowed","errmsg")==false){ 

	return false;	
	}
	return true;
}

function clearErr(){
	document.getElementById("errmsg").innerHTML = "";
}

function validate(){

if(document.regForm.username.value=="")
{
		document.getElementById("errmsg").innerHTML = "Enter your username"; 			

		document.regForm.username.focus();
		return false;
	}else if(space1(document.regForm.username.value)==false){			
	document.getElementById("errmsg").innerHTML="Space not allowed in username";		
	document.regForm.username.focus();
	return false;
}
if (document.regForm.password.value==""){
		document.getElementById("errmsg").innerHTML="Please enter password";
			document.regForm.password.focus();
				return false;
			}
if(space1(document.regForm.password.value)==false){			
	document.getElementById("errmsg").innerHTML="Space not allowed in password";		
	document.regForm.password.focus();
	return false;
}else if(document.regForm.password.value!=document.regForm.repassword.value)
{
		document.getElementById("errmsg").innerHTML="Password mismatched";
	document.regForm.repassword.focus();
		return false;
}
if (document.regForm.email.value==""){
		document.getElementById("errmsg").innerHTML="Please enter your e-mail id";
			document.regForm.email.focus();
				return false;
			}
			else if(space(document.regForm.email.value)==false){			
			document.regForm.email.focus();
			return false;
			}	
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,5})$/;
	var address = document.regForm.email.value;
	if(firstChar(address," character should be alphabet or numberic","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;
	}
	
	if(reg.test(address) == false) {
	document.getElementById("errmsg").innerHTML="Invalid Email Address";
	document.regForm.email.focus();
	return false;
	}else if(duplicateChar(address," ","Space not allowed in email","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;
	}else if(duplicateChar(address,"_","Underscore not allowed more than once in email","errmsg")==false){			//duplicateChar(txtboxvalue,c,err)
		return false;
	}else if(emailFormat(address)==false){
		document.getElementById("errmsg").innerHTML="Invalid Email Address";
		return false;	
	}


}