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
            <td><strong>In Points Report</strong></td>
          </tr>
        </table>
    		<?php 
			
	$attributes = array('id' => 'ledgerForm');
	echo form_open('reports/agent_inpoints/inpointshistory?rid='.$rid,$attributes);
	
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



if($agent_list!='all' && $agent_list!=''){
	$getselectedagent=$this->agentuserinpoints_model->getPartnerId($agent_list);
}

if(isset($results)){ 
	if(count($results)>0 && is_array($results)){
		
		for($i=0;$i<count($results);$i++){
				
			  if($results[$i]->USER_ID!="0"){  
					
					$userdetails=$this->agentuserinpoints_model->getUserById($results[$i]->USER_ID);
				    
				
					if($results[$i]->INTERNAL_REFERENCE_NO){
						$userbalance=$this->agentuserinpoints_model->getUserBalanceById($results[$i]->INTERNAL_REFERENCE_NO);
						
						if($userbalance[0]->CURRENT_TOT_BALANCE){
							$resultValue['INTERNAL_REFERENCE_NO'] = $results[$i]->INTERNAL_REFERENCE_NO;
							$resultValue1['INTERNAL_REFERENCE_NO'] = $results[$i]->INTERNAL_REFERENCE_NO;
							$resultValue['USERNAME'] = $userdetails[0]->USERNAME;
							$resultValue1['USERNAME'] = $userdetails[0]->USERNAME;
							
							   
							$CURRENT_TOT_BALANCE=$userbalance[0]->CURRENT_TOT_BALANCE;    
							$CLOSING_TOT_BALANCE=$userbalance[0]->CURRENT_TOT_BALANCE+$results[$i]->AMOUNT;    
						   
							if($results[$i]->CREATED_TIMESTAMP){
							$ndate=split(" ",$results[$i]->CREATED_TIMESTAMP);
							$resultValue['DATES'] = date("d-m-Y",strtotime($ndate[0]))." ".$ndate[1];
							$resultValue1['DATES'] = date("d-m-Y",strtotime($ndate[0]))." ".$ndate[1];
							}
						
							if($CURRENT_TOT_BALANCE<$CLOSING_TOT_BALANCE){ $resultValue['AMOUNT_IN'] = number_format($results[$i]->AMOUNT,2,".","");$resultValue1['AMOUNT_IN'] = $results[$i]->AMOUNT;} else if($CURRENT_TOT_BALANCE==$CLOSING_TOT_BALANCE){ $resultValue['AMOUNT_IN'] = '0';$resultValue1['AMOUNT_IN'] = '0';} else{ $resultValue['AMOUNT_IN'] = '';$resultValue1['AMOUNT_IN'] = '';}
							
        					if($CURRENT_TOT_BALANCE>$CLOSING_TOT_BALANCE){$resultValue['AMOUNT_OUT'] = number_format($results[$i]->AMOUNT,2,".","");$resultValue1['AMOUNT_OUT'] = $results[$i]->AMOUNT; } else {$resultValue['AMOUNT_OUT'] = '';$resultValue1['AMOUNT_OUT'] = '';}
       
        				$resultValue['CURRENT_TOT_BALANCE'] = number_format($CURRENT_TOT_BALANCE,2,".","");$resultValue1['CURRENT_TOT_BALANCE'] = $CURRENT_TOT_BALANCE; 
        				$resultValue['CLOSING_TOT_BALANCE'] = number_format($CURRENT_TOT_BALANCE+$results[$i]->AMOUNT,2,".","");$resultValue1['CLOSING_TOT_BALANCE'] = $CURRENT_TOT_BALANCE+$results[$i]->AMOUNT;
					   }
					}
    
			}
			
			$resultValue['PARTNER_USERNAME'] = $results[$i]->PROCESSED_BY;
            $resultValue1['PARTNER_USERNAME'] = $results[$i]->PROCESSED_BY;
			
			
			
			
			//echo $resultValue1['USERNAME']."-".$resultValue1['PARTNER_USERNAME'];
			
			if($resultValue['AMOUNT_IN']!="" && $resultValue['AMOUNT_IN']!="0.00" && !in_array($resultValue1['USERNAME']."-".$resultValue1['PARTNER_USERNAME'],$getValues) ){   
				         
			if($processed_by){
				if($session_data['partnertypeid']=="11"){   
				   if($resultValue1['USERNAME']!=$session_data['partnerusername']){
					$arr[] = $resultValue;  
					$arr1[] = $resultValue1;
				   }
			   }else{
				if($processed_by==$resultValue1['PARTNER_USERNAME']){
				   if($resultValue1['USERNAME']!=$session_data['partnerusername']){ 
					$arr[] = $resultValue;
					$arr1[] = $resultValue1;
				   } 
				}
			   }  
			}else{
				if($agent_list){   
				  if($agent_list!=$results[$i]->PARTNER_ID){
					 if($resultValue1['USERNAME']!=$session_data['partnerusername']){   
						$arr[] = $resultValue;    
						$arr1[] = $resultValue1;
					 }
				  }else{
					if($resultValue1['USERNAME']!=$session_data['partnerusername'] && $resultValue1['USERNAME']!=$getselectedagent[0]->PARTNER_USERNAME){  
						$arr[] = $resultValue;      
						$arr1[] = $resultValue1;
					}
				  }
				 }else{
				   if($session_data['partnertypeid']=="11"){   
					   if($resultValue1['USERNAME']!=$session_data['partnerusername']){
							$arr[] = $resultValue;   
							$arr1[] = $resultValue1;
					   } 
				   }else{
					 if($resultValue1['USERNAME']!=$session_data['partnerusername'] && $resultValue1['USERNAME']!=$getselectedagent[0]->PARTNER_USERNAME){   
						$arr[] = $resultValue;    
						$arr1[] = $resultValue1;
					 }
				   } 
				 }   
			}
		
	
		
		$resultValue1['AMOUNT_OUT']="";
	
		if(substr($row_adjust['ADJUSTMENT_COMMENT'],0,20)) { $resultValue['ADJUSTMENT_COMMENT'] = substr($adjustment_details[0]->ADJUSTMENT_COMMENT,0,20);$resultValue1['ADJUSTMENT_COMMENT'] = substr($adjustment_details[0]->ADJUSTMENT_COMMENT,0,20); }else{ $resultValue['ADJUSTMENT_COMMENT'] = '';$resultValue1['ADJUSTMENT_COMMENT'] = ''; }	
				
		
	}
  }	
 }
}
$totalinpts='';
$totaloutpts='';
if($arr){
    for($j=0;$j<count($arr);$j++){
        $totalpoints=$totalpoints+$arr[$j]['AMOUNT_IN'];
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
						colNames:['Trans.Id', 'User Id','Old Points','In','New Points','Processed By','Date'],
   						colModel:[
							{name:'INTERNAL_REFERENCE_NO',index:'INTERNAL_REFERENCE_NO', align:"center", width:120, sorttype:"int"},
							{name:'USERNAME',index:'USERNAME', align:"center", width:130},
							{name:'CURRENT_TOT_BALANCE',index:'CURRENT_TOT_BALANCE', width:80, align:"right",sorttype:"float"},		
							{name:'AMOUNT_IN',index:'AMOUNT_IN', width:80, align:"right",sorttype:"int"},
							{name:'CLOSING_TOT_BALANCE',index:'CLOSING_TOT_BALANCE', width:80, align:"right",sorttype:"int"},
							{name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', width:120, align:"center"},
							{name:'DATES',index:'DATES', width:110, align:"center", sorttype: "datetime", datefmt: "d/m/Y H:i:s"},
							//{name:'ADJUSTMENT_COMMENT',index:'ADJUSTMENT_COMMENT', width:120, align:"left"}
						],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arr);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
                
       <div style="padding-top:10px;float:right;font-family:Trebuchet MS",Arial,Helvetica,sans-serif;font-size:11px;padding-right:10px;">Total Points: <strong><?php echo number_format($totalpoints,2,".","");?></strong></div>         
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