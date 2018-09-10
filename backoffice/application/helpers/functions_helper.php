<?

//bulidComboBox("select * from user",'USER_ID','USERNAME');
//bulidComboBox("SELECT * FROM countries  ORDER BY `CountryName` ASC",'CountryID','CountryName','');
function bulidComboBox($query,$value_column,$text_column,$selectedvalue) //$selectedvalue "seleced field value
{
	$control="";
//	echo $query;
	$results=mysql_query($query) or die("connection failed");
	while($row=mysql_fetch_array($results))
	{
		$d=$row[$value_column];
		if(strcmp($d,$selectedvalue)==0) $sel="selected='selected'";
	
		$control.="<OPTION value='$row[$value_column]' $sel >$row[$text_column]</OPTION>"; 					
		$sel="";
//	echo $control."-".$row[$value_column]."-".$selectedvalue;	
	}
	//echo "<select>".$control."</select>";
	echo $control;

}

function bulidComboBox1($query,$value_column,$text_column,$selectedvalue) //$selectedvalue "seleced field value
{
	$control="";
//	echo $query;
	$results=mysql_query($query) or die("connection failed");
	while($row=mysql_fetch_array($results))
	{
	
		if(strcmp($row[$value_column],$selectedvalue)==0) $sel="selected='selected'";
	
		$control.="<OPTION value='$row[$value_column]' $sel >$row[$text_column]</OPTION>"; 					
		$sel="";
	
	}
	//echo "<select>".$control."</select>";
	return $control;
}

function existsRecord($query)
{
	//echo $query;
	$results=mysql_query($query) or die(mysql_error(). " connection failed");
	$num=mysql_num_rows($results);	
	if($num>0){
		return true;
	}else{
		return false;
	}
}

function executeQuery($query)
{
 
	$results=mysql_query($query) or die(mysql_error()."connection failed in Execute Query");
	if($results){
		return true;
	}else{
		return false;
	}	
}


function addRecord($query)
{

}

function getRecord($query,$field_name,$flag)
{
	$results=mysql_query($query) or die(mysql_error(). " connection failed");
	$num=mysql_num_rows($results);	
	$flag=$flag=='' ? 0: $flag;
	if($num>0){
		$rows = mysql_fetch_array($results);
		return $rows[$flag];
	}else{
		return "No Records";
	}
}

function countryName($COUNTRY){
  $query = "select CountryName from countries where CountryID='$COUNTRY'";
  $results=mysql_query($query) or die(mysql_error(). " connection failed");
  $num=mysql_num_rows($results);	
  if($num>0){
	$row = mysql_fetch_row($results);
	return $row[0];
  }	
}


function recordSet($query)
{
	$results=mysql_query($query) or die(mysql_error(). " connection failed");
	$num=mysql_num_rows($results);	
	if($num>0){
		$row = mysql_fetch_array($results);
		return $row;
	}	

//	return false;

}

function hackCount($query,$tableName,$fieldName,$userId,$flag)
{	
	
	$result=mysql_query($query) or die(mysql_error());	
	$num = mysql_num_rows($result);	
		
	if($num>0){		 
		if($flag==1){
			$row = mysql_fetch_array($result);
			$hack_count=$row[1];
			$hack_count=$hack_count + 1;
		}else{ $hack_count=0;}

		$updateQuery="update ".$tableName." set HACK_COUNT='".$hack_count."' where ".$fieldName."='".$userId."';"; 

		$result=mysql_query($updateQuery) or die(mysql_error());	
//		$num = mysql_num_rows($result);	
	//echo $updateQuery;
		//exit();	
		//if($num>0){ }
	}
	// return value;
}

function clearSession($key)
{
	switch($key)
	{
		case "admin":
					unset($_SESSION['user_err']);
					unset($_SESSION['pass_err']);
					unset($_SESSION['repass_err']);
					unset($_SESSION['email_err']);
					unset($_SESSION['dob_err']);
					unset($_SESSION['mobile_err']);																														
					break;
		default:
			break;
	}
}

function getIp()
{
	return $_SERVER['REMOTE_ADDR'];
}

//Get user IP




//for registration
  //"SELECT * FROM TRACKING WHERE IP_ADDRESS={$ip} and STATUS=block";

  //If Record exists Your IP is Blocked to Register user

  //"INSERT INTO TRACKING (USERNAME,ACTION_NAME,DATE_TIME,SYSTEM_IP,STATUS)VALUE('$username','login',NOW(),'$ip','Active');"




  //"SELECT * FROM TRACKING WHERE IP_ADDRESS={$ip} AND STATUS='block/login'"

  //If Record exists Your IP is Blocked to Login
    
  //"INSERT INTO TRACKING (USERNAME,ACTION_NAME,DATE_TIME,SYSTEM_IP,STATUS)VALUE('$username','login',NOW(),'$ip','Active');"
  


//"SELECT *  FROM TRACKING WHERE USERNAME='$username' AND STATUS='' AND (DATE_TIME '$start_date' BETWEEN '$end_date') AND ACTION='$action' AND IP_ADDRESS='$ipaddress'"  
//"SELECT * FROM TRAKCING WHERE STATUS='BLOKCED'" ....This is for Blocked IP

	function uploadImage($fileName, $maxSize, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB,$new_Filename,$maxH = null){
		$folder = $relPath;
		$maxlimit = $maxSize;
		$allowed_ext = "jpg,jpeg,gif,png,bmp,swf";
		$match = "";
		$filesize = $_FILES[$fileName]['size'];
		if($filesize > 0){	
			$filename = strtolower($_FILES[$fileName]['name']);
			$filename = preg_replace('/\s/', '_', $filename);
		   	if($filesize < 1){ 
				$errorList[] = "File size is empty.";
			}
			if($filesize > $maxlimit){ 
				$errorList[] = "File size is too big.";
			}
			if(count($errorList)<1){
				$file_ext = preg_split("/\./",$filename);
				$allowed_ext = preg_split("/\,/",$allowed_ext);
				foreach($allowed_ext as $ext){
					if($ext==end($file_ext)){
						$match = "1"; // File is allowed
						$NUM = time();
						$front_name = substr($file_ext[0], 0, 15);
//						$newfilename = $front_name."_".$NUM.".".end($file_ext);
						$newfilename =$new_Filename;// $_FILES[$fileName]["name"];
//						$namefilename=
						$filetype = end($file_ext);
						$save = $folder.$newfilename;
/*						if(chmod($folder,0777)==false) 
						{
			//				echo ("not working");
	//						exit();
						}
						*/
						chmod($save,0777);
						move_uploaded_file($_FILES[$fileName]["tmp_name"],$save);
//						chmod($folder,0755);
						

/*						if(!file_exists($save)){
				  			list($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
							if($maxH == null){
								if($width_orig < $maxW){
									$fwidth = $width_orig;
								}else{
									$fwidth = $maxW;
								}
								$ratio_orig = $width_orig/$height_orig;
								$fheight = $fwidth/$ratio_orig;
								
								$blank_height = $fheight;
								$top_offset = 0;
									
							}else{
								if($width_orig <= $maxW && $height_orig <= $maxH){
									$fheight = $height_orig;
									$fwidth = $width_orig;
								}else{
									if($width_orig > $maxW){
										$ratio = ($width_orig / $maxW);
										$fwidth = $maxW;
										$fheight = ($height_orig / $ratio);
										if($fheight > $maxH){
											$ratio = ($fheight / $maxH);
											$fheight = $maxH;
											$fwidth = ($fwidth / $ratio);
										}
									}
									if($height_orig > $maxH){
										$ratio = ($height_orig / $maxH);
										$fheight = $maxH;
										$fwidth = ($width_orig / $ratio);
										if($fwidth > $maxW){
											$ratio = ($fwidth / $maxW);
											$fwidth = $maxW;
											$fheight = ($fheight / $ratio);
										}
									}
								}
								if($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0){
									die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
								}
								if($fheight < 45){
									$blank_height = 45;
									$top_offset = round(($blank_height - $fheight)/2);
								}else{
									$blank_height = $fheight;
								}
							}
							$image_p = imagecreatetruecolor($fwidth, $blank_height);
							$white = imagecolorallocate($image_p, $colorR, $colorG, $colorB);
							imagefill($image_p, 0, 0, $white);
							switch($filetype){
								case "gif":
									$image = @imagecreatefromgif($_FILES[$fileName]['tmp_name']);
								break;
								case "jpg":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "jpeg":
									$image = @imagecreatefromjpeg($_FILES[$fileName]['tmp_name']);
								break;
								case "png":
									$image = @imagecreatefrompng($_FILES[$fileName]['tmp_name']);
								break;
							}
							@imagecopyresampled($image_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
							switch($filetype){
								case "gif":
									if(!@imagegif($image_p, $save)){
										$errorList[]= "PERMISSION DENIED [GIF]";
									}
								break;
								case "jpg":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPG]";
									}
								break;
								case "jpeg":
									if(!@imagejpeg($image_p, $save, 100)){
										$errorList[]= "PERMISSION DENIED [JPEG]";
									}
								break;
								case "png":
									if(!@imagepng($image_p, $save, 0)){
										$errorList[]= "PERMISSION DENIED [PNG]";
									}
								break;
							}
							@imagedestroy($filename);
						}else{
							$errorList[]= "CANNOT MAKE IMAGE IT ALREADY EXISTS";
						}	*/
					}
				}		
			}
		}else{
			$errorList[]= "NO FILE SELECTED";
		}
		if(!$match){
		   	$errorList[]= "File type isn't allowed: $filename";
		}
		if(sizeof($errorList) == 0){
			return $fullPath.$newfilename;
		}else{
			$eMessage = array();
			for ($x=0; $x<sizeof($errorList); $x++){
				$eMessage[] = $errorList[$x];
			}
		   	return $eMessage;
		}
	}

function fileSizeCheck($fileName,$num,$type,$id,$givenFileName)
{
		/*	$width_orig=0;
			$height_orig =0;	*/
//echo "SELECT * FROM image_dimension WHERE IMAGE_TYPE=$type AND CATEGORY_ID=$id AND IMAGE_NUMBER=$num";
	$row_value=recordSet("SELECT * FROM image_dimension WHERE IMAGE_TYPE=$type AND CATEGORY_ID=$id AND IMAGE_NUMBER=$num");
	
	list($width_orig, $height_orig) = getimagesize($_FILES[$fileName]['tmp_name']);
	$maxW=$row_value["IMAGE_DIMENSION_W"];
	$maxH=$row_value["IMAGE_DIMENSION_H"];
	
	/*	echo "<br />".$_FILES[$fileName]['tmp_name'];
		echo "<br />".$maxW .":". $maxH;
	
		echo "<br />".$width_orig.":". $height_orig ;
//		exit();*/
	if($width_orig == $maxW && $height_orig == $maxH){
		//$fwidth = $width_orig;

			return true;

			
	}else{
//		
  		return false;	
	}
}

function editQuestTask($task_name)
{

	
//$id=102;
	$i=1;
	$query_lang="select * from task_master where TASK_NAME='".$task_name."'";	

 	

	$e_row=recordSet($query_lang);

	$parent_category_id=$e_row["PARENT_ID"];
	$id=$e_row["PARENT_ID"];	
	
	$c_cat= "<select name='cat0' id='cat0' onchange='subLoadCombo(this,0);' class='Textselct'>";
	$c_cat=$c_cat.bulidComboBox1("SELECT * FROM task_master  WHERE PARENT_ID =".$parent_category_id." ORDER BY `TASK_NAME` ASC",'TASK_ID','TASK_NAME',$e_row["TASK_ID"]);
	$c_cat=$c_cat."</select>";

//	echo $c_cat."<br />";	
	
	if(existsRecord("SELECT * FROM task_master  WHERE TASK_ID=".$id)==true)
	{

	$query_lang="SELECT PARENT_ID  from task_master where TASK_ID=".$id;
	$parent_category_id=getRecord($query_lang,'PARENT_ID','0');

	 $mat_name=getRecord("SELECT TASK_NAME FROM task_master WHERE TASK_ID=".$parent_category_id,"TASK_NAME",''); 
	 $mat_id=$parent_category_id;
//	 echo $mat_name."<br />"; 
	 $sub_name=getRecord("SELECT TASK_NAME FROM task_master WHERE TASK_ID=".$id,"TASK_NAME",''); 
	//echo $sub_name."<br />";
	$sub_cat="<div id='cnt1Div'><input 'mcat1' id='mcat1' type='text' value='".$sub_name."' class='UDTxtField' /><input name='cat1' id='cat1' class='UDTxtField'  type='hidden' value='".$id."' /></div>";
	
	while($parent_category_id<>0)
	{
	//if(existsRecord("SELECT * FROM maincategory  WHERE PARENT_CATEGORY_ID=".$id)==true)

	
		$query_lang="SELECT * from task_master where TASK_ID=".$parent_category_id;
		$row=recordSet($query_lang);
		$main_category_id=$parent_category_id;
		$parent_category_id=$row["PARENT_ID"];
		$s=$row["TASK_ID"];
		$main_cat_id=$row["TASK_ID"];
		/*	echo "<select>";
			echo bulidComboBox("SELECT * FROM maincategory  WHERE PARENT_CATEGORY_ID =".$row["MAINCATEGORY_ID"]." ORDER BY `NAME` ASC",'MAINCATEGORY_ID','NAME',$id);
			echo "</select>";	*/
	//	$a[$i]=bulidComboBox1("SELECT * FROM maincategory  WHERE PARENT_CATEGORY_ID =".$row["MAINCATEGORY_ID"]." ORDER BY `NAME` ASC",'MAINCATEGORY_ID','NAME',$id);	
		$a[$i]=getRecord("SELECT TASK_NAME FROM task_master WHERE TASK_ID=".$row["TASK_ID"],"TASK_NAME",'');
	//	echo '<br />SELECT TASK_NAME FROM task_master WHERE TASK_ID='.$row["TASK_ID"].'<br/>';
		echo $a[$i]."<br />";

		$b[$i]=$row["TASK_ID"];
		$i++;
	//	$val=bulidComboBox("SELECT * FROM maincategory  WHERE PARENT_CATEGORY_ID =".$id." ORDER BY `NAME` ASC",'MAINCATEGORY_ID','NAME',$main_flag);	
	//	echo $val;		
	}
	if($parent_category_id==0)
	{	
		$m_cat= "<select name='cat0' id='cat0' onchange='subLoadCombo(this,0);' class='Textselct' disabled='disabled'  >";
		$m_cat=$m_cat.bulidComboBox1("SELECT * FROM task_master  WHERE PARENT_ID =".$parent_category_id." ORDER BY `TASK_NAME` ASC",'TASK_ID','TASK_NAME',$s);
		$m_cat=$m_cat."</select>";
	 
	}
	
	$k=1;
	$val="<span id='cnt'>";

	for ($j=$i-1;$j>=1;$j--)
	{
//	echo $j;
		$val=$val."<div id='cnt".$k."Div'>";		
 		//$val=$val."<select name='cat".$k."' id='cat".$k."' onchange='subLoadCombo(this,".$k.");' class='Textselct' disabled='disabled' >"; 
//		echo $a[$j]."<br />";	
		$val=$val."<input 'mcat".$k."' id='mcat".$k."' type='text' value='".$a[$j]."' class='UDTxtField' /><input name='cat".$k."' id='cat".$k."' class='UDTxtField'  type='hidden' value='".$b[$j]."' /></div>";
		$k++;
	}

$val=$val."</span>";
 echo $m_cat;
//echo $val;
/*
<div id="t1cnt1Div">
	<div class="UDRightWrap">
		<div class="UDFieldtitle">Task Sub Category 1:</div>
		<div class="UDFieldTxtFld">
			<select name="t1cat1" id="t1cat1" class="Textselct" onchange="subVgControls(this,1,1);">
				<option selected="selected" value="-100">Select Sub Category</option>
				<option value="4">female</option><option value="5">male</option>
			</select>
		</div>
	</div>
</div>
*/
echo $sub_cat;
echo $c_cat;



	//$control='<select name="cat'.$main_flag.'" id="cat'.$main_flag.'" class="Textselct" onchange="subLoadCombo(this,'.$main_flag.');"><option selected="selected">Select Main Category</option>'.$val.'</select>';
//	echo "^^".$parent_category_id;
		 
	}else
	{
//	echo "500";
		 
	}
}
function editTask($task_name1,$k)
{
	
//$id=102;
	$i=1;
	$query_lang="select * from task_master where TASK_NAME='".$task_name1."'";	
/*echo $query_lang;
exit();*/
	$e_row=recordSet($query_lang);			
//	$parent_id=$e_row["PARENT_ID"];
	$parent_id=$e_row["TASK_ID"];	
	$z=1;
	while($parent_id!=0)
	{
		$q="select * from task_master where TASK_ID=".$parent_id;
		$e_rows=recordSet($q);			
		$task_name[$z]=$e_rows["TASK_NAME"];
		$task_id[$z]=$e_rows["TASK_ID"];
		$parent_id=	$e_rows["PARENT_ID"];
		
		$z++;
	}
/*	if($parent_id==0)
	{
		$task_name[$z]=$e_rows["TASK_NAME"];
		$task_id[$z]=$e_rows["TASK_ID"];		
	}
*/	$i=1;
	for($j=$z-1;$j>=1;$j--)
	{
 	//	echo $task_name[$j]."<br/>";
		
		if($j==($z-1))
		{
			echo '<div class="UDRightWrap"><div class="UDFieldtitle">Task Sub Category '.$i.':</div><div class="UDFieldTxtFld">';

			echo '<select name="t'.$k.'cat0" id="t'.$k.'cat0" class="Textselct" onchange="subVgControls(this,0,'.$k.');"><option selected="selected" value="-100">Select Sub Category</option>';
//function bulidComboBox($query,$value_column,$text_column,$selectedvalue)			
			echo bulidComboBox("SELECT * FROM task_master  WHERE PARENT_ID =0 ORDER BY `TASK_NAME` ASC",'TASK_ID','TASK_NAME',$task_id[$j]);
			echo '	</select>';
			echo '</div></div>';
		}
//			echo "SELECT * FROM task_master  WHERE PARENT_ID =".$task_id[$i]."<br/>";
		if($j!=1)
		{
			echo '<div id="t'.$k.'cnt'.$i.'Div"><div class="UDRightWrap"><div class="UDFieldtitle">Task Sub Category '.($i+1).':</div><div class="UDFieldTxtFld">';
	
			echo '<select name="t'.$k.'cat'.$i.'" id="t'.$k.'cat'.$i.'" class="Textselct" onchange="subVgControls(this,'.$i.','.$k.');"><option selected="selected" value="-100">Select Sub Category</option>';
	//function bulidComboBox($query,$value_column,$text_column,$selectedvalue)			
			echo bulidComboBox("SELECT * FROM task_master  WHERE PARENT_ID =".$task_id[$j]." ORDER BY `TASK_NAME` ASC",'TASK_ID','TASK_NAME',$task_id[$j-1]);
			echo '	</select>';
			echo '</div></div></div>';
		}		
		$i++;
	}
	echo '<input name="total_control'.$k.'" id="total_control'.$k.'" type="hidden" value="'.($i-2).'" />';
	

} 	
?>