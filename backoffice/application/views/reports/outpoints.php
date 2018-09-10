<script language="javascript">
function showdaterange(vid)
    {
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="1"){
              sdate='<?php echo date("d-m-Y 00:00:00");?>';
              edate='<?php echo date("d-m-Y 23:59:59");?>';
          }
          if(vid=="2"){
              <?php
              $yesterday=date('d-m-Y',strtotime("-1 days"));?>
              sdate='<?php echo $yesterday;?>'+' 00:00:00';
              edate='<?php echo $yesterday;?>'+' 23:59:59';
          }
          if(vid=="3"){
              
            
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>'+' 00:00:00';
              edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
          }
          if(vid=="4"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?>'+' 00:00:00';
              edate='<?php echo $slastweekeday;?>'+' 23:59:59';
          }
          if(vid=="5"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate="01-".$tmonth."-".$tyear." 00:00:00";
              $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear." 23:59:59";
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          if(vid=="6"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate=date("01-m-Y", strtotime("-1 month"))." 00:00:00";
              $lday=date("t-m-Y", strtotime("-1 month"))." 23:59:59";
              
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          document.getElementById("START_DATE_TIME").value=sdate;
          document.getElementById("END_DATE_TIME").value=edate;
      }
      
        
    }
function chkdatevalue()
{
   if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false){
        alert("Please enter the valid date");
        return false;
    }else{
        alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')=="1"){
        alert("Start date should be greater than end date");
        return false;
        }
        return true;
    }
   } 
}

$(document).ready(function(){
	  $("#types").change(function()
	 {
	  var id=$(this).val();
	  var dataString = 'id='+ id;
	  $.ajax
	  ({
	   type: "POST",
	   url: "<? echo base_url(); ?>games/rummy/ajaxcall",
	   data: dataString,
	   cache: false,
	   success: function(html)
	   {
	   $("#game_variation").html(html);
	   } 
	  });
	
	 });
}); // end document.ready

</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); }  ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Out Points Report</strong></td>
          </tr>
        </table>
    		<?php 
	$attributes = array('id' => 'ledgerForm');
	echo form_open('reports/agent_outpoints/outpoints?rid='.$rid,$attributes);
	
?>
    
	      <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Start Date:</span><br />
                <?php
					$S_START_DATE_TIME="";
					
					if(isset($sdate))
						$S_START_DATE_TIME = date('d-m-Y 00:00:00',strtotime($sdate));
					else
						$S_START_DATE_TIME = date("d-m-Y 00:00:00");						
				?>
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP echo $S_START_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                  
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                <?php
					$E_END_DATE_TIME="";
					
					
					if(isset($edate))
						$E_END_DATE_TIME = $edate; 	
					if(isset($edate))
						$E_END_DATE_TIME = date('d-m-Y 23:59:59',strtotime($edate));
					else
						$E_END_DATE_TIME = date("d-m-Y 23:59:59");
				?>                
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP echo $E_END_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                  
                <td width="40%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label></td> 
                <td width="20%">&nbsp;</td>
              </tr>                                   
               <tr>                     
                <td width="40%"><span class="TextFieldHdr">Affiliates:</span><br />
                  <label>
                  	<?php
						$affiliatesoptions[''] = 'Select';
						
						foreach($loggedInPartnersList as $key=>$value){
							$affiliatesoptions[$value->PARTNER_ID] = $value->PARTNER_USERNAME;
						}
						$batch=$agent_list;
						echo form_dropdown('agent_list', $affiliatesoptions,$batch,'id="agent_list" class="ListMenu" tabindex="3"'); 
				   ?>	
                    
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">User:</span><br />
                  <label>
                  <input type="text" name="username" id="username" class="TextField" value="<?PHP if(isset($username)) echo $username; ?>" >
                  </label></td>                  
                  
                <td width="40%"><span class="TextFieldHdr">Processed By:</span><br />
                  <label>
                  <input type="text" name="processed_by" id="processed_by" class="TextField" value="<?PHP if(isset($processed_by)) echo $processed_by; ?>" >
                  </label></td>
                <td width="20%">&nbsp;</td>
              </tr>
              
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </form>
        </td>
        <td><form action="<?php echo base_url();?>reports/agent_ledger/ledgerhistory?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
            <input name="reset" type="submit"  id="reset" value="Clear"  />
          </form></td>
        <td>&nbsp;</td>
        </tr>
        </table>
        </td>
        <td width="33%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
        </tr>
        </table>
        </table>
        </form>
   <?php     
        if(isset($page)){
	$j=$page;
}else{
	$j=0;
}   
								
$resvalues=array();
$session_data=$this->session->all_userdata();
$totaloutpts=0;
if(isset($results)){ 
	foreach($results as $lIndex=>$lData) {
		if(!empty($lData->USER_ID)) {
			$resultValue['USERNAME'] = "<a href='".base_url()."reports/agent_user_outpoints/agent_user_outpointshistory?rid=".$rid."&parid=".base64_encode($lData->PARTNER_ID)."&uid=".base64_encode($lData->USER_ID)."&START_DATE_TIME=".date("d-m-Y H:i:s",strtotime($sdate))."&END_DATE_TIME=".date("d-m-Y H:i:s",strtotime($edate))."&keyword=Search'><span style='color:red;'><b>".$lData->PARTNER_USER_NAME."</b></span></a>";	
		} else {
			$resultValue['USERNAME'] = "<a href='".base_url()."reports/agent_outpoints/agent_outpointshistory?rid=".$rid."&parid=".base64_encode($lData->PARTNER_ID)."&START_DATE_TIME=".date("d-m-Y H:i:s",strtotime($sdate))."&END_DATE_TIME=".date("d-m-Y H:i:s",strtotime($edate))."&keyword=Search'>".$lData->PARTNER_USER_NAME."</a>";
		}
		$resultValue['CURRENT_TOT_BALANCE']=$lData->CURRENT_TOT_BALANCE;
		$resultValue['AMOUNT_OUT']  =$lData->OUT_AMOUNT;
		$resultValue['CLOSING_TOT_BALANCE']=$lData->CLOSING_TOT_BALANCE;
		$resultValue['PARTNER_USERNAME']  =$lData->PROCESSED_BY; //processed by
		$arr[] = $resultValue;	
		
        $totaloutpts=$totaloutpts+$resultValue['AMOUNT_OUT'];														
	}
}
if(isset($arr) && $arr!=''){ ?>
    <div class="tableListWrap">
      <div class="data-list">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
        <table id="list4" class="data">
          <tr>
            <td></td>
          </tr>
        </table>
        <div id="pager3"></div>
        <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['User Id','Old Points','Out','New Points','Processed By'],
					colModel:[
						{name:'USERNAME',index:'USERNAME', align:"center", width:130},
						{name:'CURRENT_TOT_BALANCE',index:'CURRENT_TOT_BALANCE', width:80, align:"right",sorttype:"float"},		
						{name:'AMOUNT_OUT',index:'AMOUNT_OUT', width:80, align:"right",sorttype:"int"},
						{name:'CLOSING_TOT_BALANCE',index:'CLOSING_TOT_BALANCE', width:80, align:"right",sorttype:"int"},
						{name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', width:120, align:"center"}
					],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arr);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
                
       <div style="padding-top:10px;float:right;font-family:Trebuchet MS",Arial,Helvetica,sans-serif;font-size:11px;padding-right:10px;">Total Points: <strong><?php echo number_format($totaloutpts,2,".","");?></strong></div>         
      </div>
    </div>
    <?php }else{ ?>
	<div class="tableListWrap">
      <div class="data-list">
        <table id="list4" class="data">
          <tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no records found in this search criteria.</b></span></td>
          </tr>
        </table>
      </div>
    </div>
	<?php } ?>
</div>
 </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>