<?php
class User
{	
    function User_Login()   {	
	  	 global  $DB;		 
	     $user_login     = $_POST['username'];
		 $pass_word      = $_POST['password'];
	     $q_user       = "select USER_ID,USERNAME,PASSWORD from user where USERNAME='{$user_login}' and PASSWORD='{$pass_word}'";	 
		 $result = mysql_query($q_user) or die (mysql_error());
		 $num=mysql_num_rows($result);		
	      
			if($num>0)
				{		
					$row = mysql_fetch_array($result);																
					$_SESSION[ user_id ] =	$row['USER_ID'];
					$_SESSION[ username ] =	$row['USERNAME'];					
					return true;
			    }
				
			else	
			  	return false;   
			  }			  
			  
	 function User_available( ){
	 
         	if( "" == $_SESSION[ user_id ]  && ! trim( $_SESSION[ user_id ]  ) ){ 
 		    echo "<script>alert('You are not yet Logged In');</script>";
		    header("location:index.php");
		    exit;
	        }			 
			 else	
			    return true;
			 }
}
?>