<?PHP 

//QA
$username = 'kheloqa';
$password = 'kheloqa';		
$dbhost = '54.254.155.69';		
$database = 'triplemaza_mstr_qa';



$conn1 = new PDO("mysql:host=".$dbhost.";dbname=".$database."",$username,$password);
mysql_pconnect ("$dbhost", "$username", "$password") or die ('I cannot connect to the database because: ' . mysql_error());		
mysql_select_db ("$database") or die ('I cannot connect to the database because: ' . mysql_error());


/* $conn2 = new PDO("mysql:host=".$dbhost1.";dbname=".$database1."",$username1,$password1);
mysql_pconnect ("$dbhost1", "$username1", "$password1") or die ('I cannot connect to the database because: ' . mysql_error());		
mysql_select_db ("$database1") or die ('I cannot connect to the database because: ' . mysql_error()); */
		
				
?>