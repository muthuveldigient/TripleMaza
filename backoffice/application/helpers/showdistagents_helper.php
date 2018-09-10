<?php 
function showdistagents()
{
$listdist="<select name='affiliateid' id='affiliateid' class='UDTxtField'><option value='all'>all</option>";
$sql_alldist=mysql_query("select PARTNER_USERNAME,PARTNER_ID from partner where FK_PARTNER_ID='".$this->session->userdata('partnerid')."' and IS_DISTRIBUTOR=1");    
while($row_alldist=mysql_fetch_array($sql_alldist)){
    $listdist=$listdist."<option value=".$row_alldist['PARTNER_ID'].">".$row_alldist['PARTNER_USERNAME']."</option>";
}
$listdist=$listdist."</select>";

echo $listdist;        
}
?>