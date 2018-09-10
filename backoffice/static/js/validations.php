<? session_start();
if(isset($_GET['var'])){
$var=$_GET['var'];
}
if(isset($_GET['txt'])){
$txt=$_GET['txt'];
}
if(isset($var) ){
switch($var)
{
	case "login":
		if(isEmpty($txt)==true)	
			echo "Enter Username";
		exit();			
		break;
	case "loginpassword":
		if(isEmpty($txt)==true)	
		echo "Enter Password";
		exit();	
		break;
	case "forgotpassword":
		if(isEmpty($txt)==true)	
			echo "Please enter your Email";
		else if(emailcheck($txt)==false) 		
			echo "Invalid Email";		
		exit();	
		break;
	case "user":
		if(isEmpty($txt)==true)	
			echo "Enter username";
		else if(minChar($txt)==false) 
			echo "Username should have mini. 4 characters max. of 15 characters";					 		
		else if(firstChar($txt)==true)	
			echo "First character should be alphabet or numeric";
		else if(endChar($txt)==true)	
			echo "Last character should be alphabet or numeric";
		else if(isSpaceExists($txt)==true)	
			echo "Space not allowed";
//		else if(user($txt)==true)echo "Invalid Username";				
		else if(userexists($txt)==true) echo "Username Exists.";		
		else echo "";
		exit();
		break;	
		//9841377375
		
	case "password":
			 
		if(isEmpty($txt)==true)	
			echo "Enter Password";
		else if(isSpaceExists($txt)==true)	
			echo "Space not allowed";
		
		exit(0);
		break;	
		
	case "rpassword":
		if(isEmpty($txt)==true)	
			echo "Enter Retype Password";
		else if(isSpaceExists($txt)==true)	
			echo "Space not allowed";
		exit(0);
		break;	
	case "email":
		if(isEmpty($txt)==true)	
			echo "Enter Email";
		else if(firstChar($txt)==true)	
			echo "First character should be alphabet or numeric";
		else if(endChar($txt)==true)	
			echo "Last character should be alphabet or numeric";
		else if(isSpaceExists($txt)==true)	
			echo "Space not allowed";
		else if(emailcheck($txt)==false) 		
			echo "Invalid Email";		
		else if(emailexists($txt)==true) echo "Email Exists.";					
		exit(0);	
		break;
	case "day":
		if(trim($txt)=="") echo "Select Day";
		exit(0);		
	break;
	case "month":
		if($txt=="") echo "Select Month";
		exit(0);		
	break;
	case "year":
		if($txt=="") echo "Select Year";
		exit(0);
	break;
	case "vcode":
		
		if(isEmpty($txt)==true)	echo "Enter Verification code";
		else if(verificationcode($txt)==false) echo "The Verification Code is not valid! Please try again!";
		
  		exit(0);	
	break;		
	case "rules":
//		echo $txt;
		if(isEmpty($txt)==true)	echo "Please agree game rules";
  		exit(0);	
	break;
	case "terms":
		if(isEmpty($txt)==true)	echo "Please agree the Terms & Conditions";
		exit(0);		
	break;
	case "mobile":
//	echo is_numeric(+11e-9)? "T" :"F";// Output T
		$mobi_val=$_REQUEST['mobile'];		
		if(strlen(trim($mobi_val))==0) $mobi_val=$txt;
		if(is_numeric($mobi_val)==false) echo "Numbers only allowed"; 
		exit();
	break;
	case "mismatch":
		if($txt==1)	echo "Password mismatched.Please re-type your password correctly";
		exit(0);			
	case "datecheck":
		if($txt==1)	echo "Invalid Date";
		exit(0);
	break;	
		case "empty":
			 
		if(isEmpty($txt)==true)	
			echo "Please enter the value";
		else if(isSpaceExists($txt)==true)	
			echo "Space not allowed";
		
		exit(0);
		break;
		
		
	default:
		echo "";
	break;
}
}

function isEmpty($txt){
//	if(trim($txt)=="" || $txt="undefined") return true; else return false;
	if(strlen(trim($txt))==0) return true; else return false;
}
function minChar($txt){
	if(strlen($txt)<4) return false; else return true;
}

function firstChar($txt)
{
//	$exp="/^[a-zA-Z.]+[0-9_]{3,15}$/";	
	$first= "/^[!@#$%^&*(),|<>_.]+[a-zA-Z0-9_]{3,15}$/";	
	if (preg_match($first,$txt)) return true; else return false;
}
function user($txt)
{
	$username="/^[a-zA-Z]+[0-9_]{3,15}$/";	
	if (preg_match($username,$txt))  return true; else return false;
}

function endChar($txt)
{
	$last= "/^[A-Za-z0-9]+[!@#$%^&*_()]{1,15}$/";	
	if (preg_match($last,$txt))  return true; else return false;
}
function isSpaceExists($txt)
{
	$txt_len=strlen($txt);

	for($i=0;$i<$txt_len;$i++)
	{
	
		if(substr($txt,$i,1)==" ") { 
			return true;
			break;
		}	
	}
	return false;
}

function emailcheck($email)
{

///^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,5})$/
	$exp="/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,5})$/";
	if (preg_match($exp,$email))
	{
			//echo "<font color=red> Invalid email</font>";
		return true;	
	}else
	{
		//echo "<font color=green> Valid Email</font>";
		return false;
	}
}

function userexists($username)
{
	include("../dbs.php");
//$username = $_REQUEST['filter'];
	if($username){
		$sql_veri_name="select USERNAME FROM admin_user where USERNAME='{$username}'";
		$insname=mysql_query($sql_veri_name) or die(mysql_error());	
		$num = mysql_num_rows($insname);
		if($num>0) return true ;
				
		return false;
	}
}
function emailexists($email)
{
//	$email = $_REQUEST['filter'];
	include("../dbs.php");
	if($email)
	{
		$sql_veri_email="select EMAIL FROM admin_user where EMAIL='{$email}'";
		$insemail=mysql_query($sql_veri_email) or die(mysql_error());	
		$num = mysql_num_rows($insemail);	
		if($num>0) return true ;
					
		return false;			
	}
}


function verificationcode($code)
{
	$key=substr($_SESSION['key'],0,5);
	if(strtolower($code)==strtolower($key)) return true;
	
	return false;
}
 


?>