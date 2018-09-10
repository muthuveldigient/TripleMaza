<?PHP
session_start();
function Is_Logged_In(){
	  
	if($_SESSION['userid']==""){
		header( "Location:index.php" );
		exit;
	}else	return true;
}

function Is_Activated()
{
	if($_SESSION['activate']==2){
		unset($_SESSION['userid']);
		unset($_SESSION['activate']);
		header( "Location:index.php" );
		exit;
	}
}

function Admin_Is_Logged_In( ){
        
	if($_SESSION['adminid']==""){
		header( "Location:index.php" );
		exit;

	}else	return true;
}

function Partner_Is_Logged_In( ){
        
	if($_SESSION['partnerid']==""){
		header( "Location:index.php" );
		exit;

	}else	return true;
}

// Shorten string function (thanks elkgames)
function shortenStr ($str, $len) {
    return strlen($str) > $len ?  substr($str, 0, $len)."..." : $str;
}
?>