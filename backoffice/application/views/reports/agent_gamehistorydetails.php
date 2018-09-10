<?PHP
	$query=mysql_query("select rummy_play.*,user.USERNAME from rummy_play , user where rummy_play.USER_ID = user.USER_ID and INTERNAL_REFERENCE_NO='".$handId."'");
	$row=mysql_fetch_array($query);	
	//echo "select rummy_play.*,user.USERNAME from rummy_play , user where rummy_play.USER_ID = user.USER_ID and INTERNAL_REFERENCE_NO='".$handId."'";
	@extract($row);
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/style.css" />
<div  id="myOnPageContent<?php if(isset($INTERNAL_REFERENCE_NO)) echo $INTERNAL_REFERENCE_NO; ?>">
<div class="UDpopBg">
<div class="UDpopupWrap">
<div class="UDpopLeftWrap">
<div class="UDFieldtitle">
<div class="UDFieldtitle">
<?php
		 if(isset($PLAY_DATA)){
	     $total=json_decode($PLAY_DATA, true);
		 }else{
		 $total='';
		 }
	//	 echo "<pre>";
	//	print_r($total);	
//		echo "Card".$total[10005][1]['playerPickCard'][0]['clientCard'];
//		die;	
		 @$totusercardsDetails=$total[$USER_ID][0];
		 if(is_array($totusercardsDetails)==1){
		
	  if($total[$USER_ID][0]){
	  	 $totalrounds=count($total[$USER_ID]);
		 if($totalrounds==''){
		 	$totalrounds=0;
		 }
		for($i=0;$i<$totalrounds;$i++){
		  $totuserpickcards=$total[$USER_ID][$i]['playerPickCard'];	
		  $totuserreleasecards=$total[$USER_ID][$i]['playerReleaseCard']; 	 
         if($total[$USER_ID][$i]['playerHandCard']){
             $totusercards=$total[$USER_ID][$i]['playerHandCard'];
			 		 		
             if($total[$USER_ID][$i]['playerHandCardround'][0]){
                  $playerHandCardround=$total[$USER_ID][$i]['playerHandCardround'][0];	
             }
			 $rounds=$total[$USER_ID][$i]['rounds'];
	 ?>
<table cellpadding="3" cellspacing="3" align="center">
  <tr>
    <tr><td><div class="UDFieldtitle"> <span  style=" font-weight:bold">Round:<?php echo $rounds;?></span> </div></td></tr>
    <td>
      <table cellpadding="3" cellspacing="3">
      	<tr><td colspan="2"><div class="UDFieldtitle"> Player Pick Cards:</div></td></tr>
      	<tr>
	<?php
    $userpickCount=count($totuserpickcards);
	if($userpickCount){
    	for($up=0;$up<$userpickCount;$up++) { ?>
    	<td><img src="<?PHP echo base_url(); ?>static/images/rummy/<?PHP echo $totuserpickcards[$up]['clientCard'].".png";?>" style="border-color:#FF0000" border="1"></td>
    <?php 
		} 
	}else{
		echo "<td colspan='2'>---</td>";
	}
	?>
        </tr>
        <tr><td colspan='2'><div class="UDFieldtitle"> Player Release Cards:</div></td></tr>
      	<tr>
	<?php
    $userreleaseCount=count($totuserreleasecards);
	if($userreleaseCount){
    	for($ur=0;$ur<$userreleaseCount;$ur++) { ?>
    	<td><img src="<?PHP echo base_url(); ?>static/images/rummy/<?PHP echo $totuserpickcards[$ur]['clientCard'].".png";?>" style="border-color:#FF0000" border="1"></td>
    <?php 
		} 
	}else{
		echo "<td colspan='2'>---</td>";
	}
	?>
        </tr>
        
        <tr>
        <tr><td><div class="UDFieldtitle">Round Cards:</div></td></tr>
	<?php
    $ucCount=count($totusercards);
    for($uc=0;$uc<$ucCount;$uc++) { ?>
    <td><img src="<?PHP echo base_url(); ?>static/images/rummy/<?PHP echo $totusercards[$uc]['clientCard'].".png";?>" style="border-color:#FF0000" border="1"></td>
    <?php } ?>
        <tr>
      </table></td>
  </tr>
  <tr><td><div class="UDFieldtitle"> Final Cards: </div></td></tr>
  <tr>
    <td>
      <?PHP if($totusercardsDetails['clientSideCard']!="null") { ?>
      <table cellpadding="3" cellspacing="3">
        <tr>
	<?php
    $clientSideCard=$totusercardsDetails['clientSideCard'];
	$result1=explode(",",$clientSideCard);
    $chCount=count($result1);
    for($ch=0;$ch<$chCount;$ch++) { ?>
   <td><img src="<?PHP echo base_url(); ?>static/images/rummy/<?PHP echo $result1[$ch].".png";?>" style="border-color:#FF0000" border="1"></td>
 <?PHP } ?>
        <tr>
      </table>
      <?PHP }else{  echo '---'; }?>
    </td>
  </tr>
  </td>  
    </tr>  
    <tr><td height="20"></td></tr>
<?PHP }
   } 
 }
}else{ ?>
<div class="UDFieldtitle" align="center" style="padding-top:50px;"> <span style=" font-weight:bold;padding-top:50px;">No records found!.....</span> </div>
<?PHP } ?>
