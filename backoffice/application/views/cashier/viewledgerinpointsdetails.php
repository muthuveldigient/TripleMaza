<script type="text/javascript" src="<?php echo base_url();?>static/js/popup.js"></script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script>
    function showdaterange(vid)
    {
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="1"){
              sdate='<?php echo date("d-m-Y 00:00:00");?>';
              edate='<?php echo date("d-m-Y 23:59:00");?>';
          }
          if(vid=="2"){
              
            
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>'+' 00:00:00';
              edate='<?php echo date("d-m-Y");?>'+' 23:59:00';
          }
          if(vid=="3"){
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
                              
              sdate='<?php echo $slastweekday;?>'+' 00:00:00';
              edate='<?php echo $slastweekeday;?>'+' 23:59:00';
          }
          if(vid=="4"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate="01-".$tmonth."-".$tyear." 00:00:00";
              $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear." 23:59:00";
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          if(vid=="5"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate=date("01-m-Y", strtotime("-1 month"))." 00:00:00";
              $lday=date("t-m-Y", strtotime("-1 month"))." 23:59:00";
              
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          document.getElementById("START_DATE_TIME").value=sdate;
          document.getElementById("END_DATE_TIME").value=edate;
      }
      
        
    }

</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
<div class="tableListWrap">
<?php
      @extract($gdata);
	  ?>
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>In Points Report</strong></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
   <form action="" method="post" name="tsearchform" id="tsearchform">
        <tr>
          <td>
          
        <table width="100%" cellpadding="10" cellspacing="10">
      
           <tr>
        <td width="40%"><span class="TextFieldHdr">Start Date:</span><br />
          <label>
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME){echo $START_DATE_TIME;}else{ echo $sdate;} ?>">
          </label><a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">End Date:</span><br />
          <label>
          <input type="text"  id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME){echo $END_DATE_TIME;}else{ echo date("d-m-Y 23:59:00");} ?>">    
          </label><a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a></td>
        <td width="33%"><span class="TextFieldHdr"></span><select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
        <option value="">Select</option>
        <option value="1" <?php if(isset($SEARCH_LIMIT)) if($SEARCH_LIMIT=="1"){ echo "selected";}?>>Today</option>
        <option value="2" <?php if(isset($SEARCH_LIMIT)) if($SEARCH_LIMIT=="2"){ echo "selected";}?>>This Week</option>
        <option value="3" <?php if(isset($SEARCH_LIMIT)) if($SEARCH_LIMIT=="3"){ echo "selected";}?>>Last Week</option>
        <option value="4" <?php if(isset($SEARCH_LIMIT)) if($SEARCH_LIMIT=="4"){ echo "selected";}?>>This Month</option>
        <option value="5" <?php if(isset($SEARCH_LIMIT)) if($SEARCH_LIMIT=="5"){ echo "selected";}?>>Last Month</option>
    </select>           </td>
      </tr>
           <tr>
             
                 <?php
if($this->session->userdata['isownpartner']=='1' || $this->session->userdata['isdistributor']=='1'){ ?>
                 <td>
                 <span class="TextFieldHdr">Affiliates:</span><br />
                 <label>
                 <select name="AGENT_LIST" id="AGENT_LIST" class="ListMenu">
                    <option value="all">All</option>
                    <?php
                    #Agents list
                    if(is_array($agentlists)){
                        foreach($agentlists as $row_agent){
                                    if($this->session->userdata['partnerid']!=$row_agent->PARTNER_ID){
                   ?>     
                                        <option value="<?php echo $row_agent->PARTNER_ID;?>" <?php if($AGENT_LIST) if($AGENT_LIST==$row_agent->PARTNER_ID){ echo "selected";}?>><?php echo $row_agent->PARTNER_USERNAME;?></option>     
                   <?php
                                    }
                        }
                    }
                    ?>
                </select>
                 </label>
                 </td>
<?php }  ?>                 
             
             <td><span class="TextFieldHdr">User:</span><br />
                 <label><input type="text"  id="USERNAME" class="TextField" name="USERNAME" value="<?PHP echo $USERNAME; ?>"></label>
             </td>
             <td>
                 <span class="TextFieldHdr">Processed By:</span><br />
                 <label><input type="text"  id="PROCESSED_BY" class="TextField" name="PROCESSED_BY" value="<?PHP echo $PROCESSED_BY; ?>"></label>
             </td>
           </tr>
       

      <tr>
          <td width="40%">
              <table>
              <tr>
                <td><input name="searchbutton" type="submit" class="button" id="searchbutton" value="Search" style="float:left;" />
</form> </td>
                <td>
    <form action="<?php echo base_url();?>admin_home/?p=vlsdr&parid=<?php if(isset($parid)) echo $parid;?>" method="post">    
        <input name="reset" type="submit" class="button" id="reset" value="Clear" onClick="<?php if($this->session->userdata('isownpartner')=='1' || $this->session->userdata('isdistributor')=='1'){ echo 'clearall()';}else{ echo 'clearallsubagents()';}?>" style="float:left;margin-left:5px;" />	
    </form>
                </td>
                <td>&nbsp;</td>
              </tr>
            </table>
              
    
              </td>
        <td width="40%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
      </tr>
    </table>

</table>    
    
    
<?php

if(!empty($results)){ ?>
<div class="data-list" style="padding-top:10px;">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<table id="list4" class="data"><tr><td><td/></tr></table>
<?php

$str="";
for($i=0;$i<count($results['excelexport']);$i++){
$str.="{";
foreach($results['excelexport'][$i] as $key=>$value){
$str.="#".$key.":".$value;
}
$str.="},";
}
$tpoints=$results['excelexporttot'];
$ledgerlist=$results['ledgerlist'];
$totalpoints=$results['totalpoints'];
//print_r($ledgerlist);
if($ledgerlist){
if(!empty($ledgerlist)){
    $j = $page;
         if(count($ledgerlist)>0 && is_array($ledgerlist)){
             for($i=0;$i<count($ledgerlist);$i++){
                 $j++;
                 $resvalue['INTERNAL_REFERENCE_NO']=$ledgerlist[$i]['INTERNAL_REFERENCE_NO'];
                 $resvalue['DATES']=$ledgerlist[$i]['DATES'];
                 $resvalue['USERNAME']=$ledgerlist[$i]['USERNAME'];
                 $resvalue['CURRENT_TOT_BALANCE']=$ledgerlist[$i]['CURRENT_TOT_BALANCE'];
                 $resvalue['AMOUNT_IN']=$ledgerlist[$i]['AMOUNT_IN'];
                 $resvalue['AMOUNT_OUT']=$ledgerlist[$i]['AMOUNT_OUT'];
                 $resvalue['CLOSING_TOT_BALANCE']=$ledgerlist[$i]['CLOSING_TOT_BALANCE'];
                 $resvalue['PARTNER_USERNAME']=$ledgerlist[$i]['PARTNER_USERNAME'];
                 $resvalue['ADJUSTMENT_COMMENT']=$ledgerlist[$i]['ADJUSTMENT_COMMENT'];
                 $resvalue['SNO'] = $j;
                 if($resvalue){
                     $arrs[] = $resvalue;
                 }
             }
         }else{
                $arrs="";
         }
         
         
}


?>
<form name="myfrm" id="myfrm" action="<?php echo base_url()?>inpointsexcelexpot/cumexcel" method="post">
<input type="hidden" name="inpointsdata" value="<?php echo $str;?>" />
<input type="hidden" name="totalinpoints" value="<?php echo $tpoints;?>" />
</form>
<div style="padding-top:10px;float:left;font-family:arial;font-size:11px;padding-right:10px;">Export: <a href="#" onclick="javascript:document.myfrm.submit()"><img src="<?php echo base_url()?>static/images/excel.jpg" height="20" width="20"></a></div>
<?php

if($totalpoints){
?>
<div style="padding-top:10px;float:right;font-family:arial;font-size:11px;padding-right:10px;">Total Points: <strong><?php echo $totalpoints;?></strong></div>
<?php } ?>

<div id="pager3"></div>
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery("#list4").jqGrid({
	datatype: "local",
   	colNames:['S.no', 'User Id','Old Points','In','New Points','Processed By', 'Comment'],
   	colModel:[
   		{name:'SNO',index:'SNO', align:"center", width:50, sorttype:"int"},
	//	{name:'INTERNAL_REFERENCE_NO',index:'INTERNAL_REFERENCE_NO', align:"center", width:80, sorttype:"int"},
   	//	{name:'DATES',index:'DATES', width:110, align:"center", sorttype: "datetime", datefmt: "d/m/Y H:i:s"},
   		{name:'USERNAME',index:'USERNAME', align:"center", width:130},
        {name:'CURRENT_TOT_BALANCE',index:'CURRENT_TOT_BALANCE', width:80, align:"right",sorttype:"float"},		
   		{name:'AMOUNT_IN',index:'AMOUNT_IN', width:80, align:"right",sorttype:"int"},
   		//{name:'AMOUNT_OUT',index:'AMOUNT_OUT', width:80, align:"right",sorttype:"int"},		
   		{name:'CLOSING_TOT_BALANCE',index:'CLOSING_TOT_BALANCE', width:80, align:"right",sorttype:"int"},
		{name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', width:120, align:"center"},
		{name:'ADJUSTMENT_COMMENT',index:'ADJUSTMENT_COMMENT', width:120, align:"left"}
   	],
	rowNum:500,
	width: 999, height: "100%"
});
var mydata = <?php echo json_encode($arrs);?>;
for(var i=0;i<=mydata.length;i++)
	jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
</script>
<div class="page-wrap">
   <div class="pagination">
            <?php					
            echo $links;    
            ?>
   </div>
</div>
<?php }

?>
</div>
<?php } ?>    
</div>
</div>
</div>
</div>
<?php echo $this->load->view("common/footer"); ?>