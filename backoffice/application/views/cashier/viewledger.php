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

</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 
<?php

?>
<table width="100%" class="ContentHdr">
  <tr>
    <td><strong> Ledger </strong></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
   <form action="<?php echo base_url(); ?>cashier/pay/ledger?rid=17" method="post" name="tsearchform" id="tsearchform">
        <tr>
          <td>
          
        <table width="100%" cellpadding="10" cellspacing="10">
      
           <tr>
        <td width="40%"><span class="TextFieldHdr">Start Date:</span><br />
          <label>
           <?PHP 
		
		   $usernameSeg = $this->uri->segment(4);
		   if($usernameSeg == ""){
		    if(isset($_REQUEST['START_DATE_TIME'])) {
			  $start_date = $_REQUEST['START_DATE_TIME'];
			}else{
			  $start_date = date("d-m-Y 00:00:00");
			}
		 }else{
		    $start_date ="";
		 }
		 
		 
		  ?>
          
          
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?php echo $start_date; ?>">
          </label><a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">End Date:</span><br />
          <label>
          <?PHP 
		  if($usernameSeg == ""){
			if(isset($_REQUEST['END_DATE_TIME'])) {
			  $end_date = $_REQUEST['END_DATE_TIME'];
			}else{
			  $end_date = date("d-m-Y 23:59:59");
			}
		   }else{
		    $end_date ="";
		   }  ?>
          
          
          <input type="text"  id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?php echo $end_date; ?>">    
          </label><a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a></td>
        <td width="33%"><span class="TextFieldHdr">Date Range:</span><select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
        <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
        </select>
        </td>
      </tr>
           <tr>
             
                 <?php
//if($this->session->userdata['isownpartner']=='1' || $this->session->userdata['isdistributor']=='1'){ ?>
               <!--  <td>
                 <span class="TextFieldHdr">Affiliates:</span><br />
                 <label>
                    <? 
                    $pid =  $this->Agent_model->getAllChildIds($this->session->userdata);
                    $partnerName = $this->Agent_model->getPartnerNameByChildIds($pid); ?>                     
                     <?
                    //$par = explode(',', $partnerName);
                   // echo "<pre>";print_r($partnerName);die;//echo "<pre>";
//echo $partnerName;die;?>
                 <select name="AGENT_LIST" id="AGENT_LIST" class="ListMenu">
                    <option value="all">All</option>
                    <?php
                    #Agents list
                        foreach($partnerName as $partner_name){    ?>     
 <option <?php //if($partname == $partner_name) echo 'selected="selected"'; ?> value="<?php echo $partner_name->PARTNER_ID; ?>"><?php echo $partner_name->PARTNER_NAME; ?></option>
                   <?php }  ?>
                </select>
                 </label>
                 </td>-->
<?php// }  ?>                 
             
             <td><span class="TextFieldHdr">User:</span><br />
                 <label><input type="text"  id="USERNAME" class="TextField" name="USERNAME" value="<?PHP if($this->uri->segment(4)){echo $this->uri->segment(4);}elseif(isset($USERNAME)){ echo $USERNAME;} ?>"></label>
             </td>
             <td><span class="TextFieldHdr">Transaction Id:</span><br />
                 <label><input type="text"  id="TRANSID" class="TextField" name="TRANSID" value="<?PHP if(isset($TRANSID)) echo $TRANSID; ?>"></label>
             </td>             
            <!-- <td>
                 <span class="TextFieldHdr">Processed By:</span><br />
                 <label><input type="text"  id="PROCESSED_BY" class="TextField" name="PROCESSED_BY" value="<?PHP if(isset($PROCESSED_BY)) echo $PROCESSED_BY; ?>"></label>
             </td>  -->
           </tr>
       

      <tr>
          <td width="40%">
              <table>
              <tr>
                <td><input name="keyword" type="submit" class="button" id="button" value="Search" style="float:left;" />
</form> </td>
                <td>
    <form action="<?php echo base_url(); ?>cashier/pay/ledger?rid=17" method="post">    
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
//if(!empty($results)){ 
    //echo ($this->cashier_model->OutPointsTransTypeId());die;?>

<?php
     /*$page = $this->uri->segment(4);
     if(isset($page) && $page !=''){
	$j=$page;
     }else{
        $j=0;
     } */
	$j=0;
    $totalpoints="";
    $resvalues=array();
    	if(isset($results)){ 
    		if(count($results)>0 && is_array($results)){
         		$outPointsTypeID = $this->cashier_model->OutPointsTransTypeId();
     			for($i=0;$i<count($results);$i++){
     				//get agent name
         			$user_id = $results[$i]->USER_ID;
     				$USERNAME    = $this->Account_model->getUserNameById($user_id);
     				$TRANS_ID    = $results[$i]->INTERNAL_REFERENCE_NO; 
     				$DATE        = date("d/m/Y h:i:s",strtotime($results[$i]->TRANSACTION_DATE));
     				$OLD_POINTS  = $results[$i]->CURRENT_TOT_BALANCE;
     				$NEW_POINTS  = $results[$i]->CLOSING_TOT_BALANCE;
     				$expResult= explode(",",$this->cashier_model->InPointsTransTypeId());
	 				$IN = "-"; $OUT = "-";
	 				if($results[$i]->CLOSING_TOT_BALANCE <= $results[$i]->CURRENT_TOT_BALANCE) { //OUT Points calculation here
		 				$OUT = $results[$i]->TRANSACTION_AMOUNT;
         				if($TotOutPoints)
         					$TotOutPoints=$TotOutPoints+$results[$i]->TRANSACTION_AMOUNT;
         				else
         					$TotOutPoints=$results[$i]->TRANSACTION_AMOUNT;        		 
	 				} else { //IN Points calculation here
		 				$IN = $results[$i]->TRANSACTION_AMOUNT;
     	 				if($TotInPoints)
	     					$TotInPoints=$TotInPoints+$results[$i]->TRANSACTION_AMOUNT;
     					else
        					$TotInPoints=$results[$i]->TRANSACTION_AMOUNT;  
	 				}
      
    /* if($results[$i]->TRANSACTION_TYPE_ID == $expResult[0] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[1] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[2] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[3] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[4] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[5] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[6] || $results[$i]->TRANSACTION_TYPE_ID == $expResult[7]){
         $IN = $results[$i]->TRANSACTION_AMOUNT;
     if($TotInPoints){
        $TotInPoints=$TotInPoints+$results[$i]->TRANSACTION_AMOUNT;
     }else{
        $TotInPoints=$results[$i]->TRANSACTION_AMOUNT;    
     }
     }else{
         $IN = "-";
     }
     if($results[$i]->TRANSACTION_TYPE_ID == $outPointsTypeID){
         $OUT = $results[$i]->TRANSACTION_AMOUNT;
         if($TotOutPoints){
                $TotOutPoints=$TotInPoints+$results[$i]->TRANSACTION_AMOUNT;
         }else{
                $TotOutPoints=$results[$i]->TRANSACTION_AMOUNT;    
         }         
     }else{
         $OUT = "-";
     }*/
     
     				$resvalue['SNO']        =$j+1;
				    $resvalue['USERNAME']   = '<a href="'.base_url().'user/account/detail/'.$results[$i]->USER_ID.'?rid=10">'.$USERNAME.'</a>';
     				$resvalue['TRANS_ID']   = $TRANS_ID;
     				$resvalue['DATE']       = $DATE;
     				$resvalue['OLD_POINTS'] = $OLD_POINTS;
     				$resvalue['IN']         = $IN;
     				$resvalue['OUT']        = $OUT;
     				$resvalue['NEW_POINTS'] = $NEW_POINTS;
     				//$resvalue['PROCESSED_BY']= $PROCESSED_BY;
									
				    if($resvalue){
     					$arrs[] = $resvalue;
     				}
     				$j++;
				}
     		}else{
     			$arrs="";
     		}
     }

if(isset($arrs) && $arrs!=''){  ?>
    
<style>
	.searchWrap1 {
    background-color: #F8F8F8;
    border: 1px solid #EEEEEE;
    border-radius: 5px;
    float: left;
    width: 100%;
	margin-top:10px;
	font-size:13px;
}
</style>
   <p class="searchWrap1" style="height:30px;">
    <span style="position:relative;top:8px;left:10px">
    <b> Total Records: <font color="#FF3300">(<?php echo $j; ?>) </font></b> &nbsp;&nbsp;&nbsp;
    <b> Total In Points: <font color="green"><?php if($TotInPoints){echo number_format($TotInPoints,2,".","");}else{echo "0.00";} ?></font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Out Points: <font color="#FF3300"><?php if($TotOutPoints){echo number_format($TotOutPoints,2,".","");}else{echo "0.00";} ?></font></b>
    <b style="float: right; position: relative; left: -42px; top: 6px;"><img src="<?php echo base_url(); ?>static/images/print.png"><a style="position: relative; top: -2px; left: 2px;" onclick="window.print()" href="#">Print</a></b>
    </span>
     </p>
     
     
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
					colNames:['User Name','Transaction Id','Date','Current Balance','Amount In','Amount Out','Closing Balance'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:60},
                        {name:'TRANS_ID',index:'TRANS_ID', align:"center", width:100},
                        {name:'DATE',index:'DATE', align:"center", width:80},
						{name:'OLD_POINTS',index:'OLD_POINTS', align:"right", width:60,sorttype:"float"},
						{name:'IN',index:'IN', align:"right", width:50,sorttype:"float"},
                        {name:'OUT',index:'OUT', align:"right", width:50,sorttype:"float"},
						{name:'NEW_POINTS',index:'NEW_POINTS', align:"right", width:60,sorttype:"float"},
						//{name:'PROCESSED_BY',index:'PROCESSED_BY', align:"center", width:40},
						//{name:'COMMENTS',index:'COMMENTS', align:"center", width:80},
                             ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
<div class="Agent_total_Wrap1" style="width:1000px;">
<div class="Agent_TotalShdr" style="width:642px;">TOTAL:</div>

<div class="Agent_TotalRShdr" style="width:98px"><p align="right"><?PHP if($TotInPoints){echo number_format($TotInPoints,2,".","");}else{echo "0.00";}?></p></div>
<div class="Agent_TotalRShdr" style="width:99px"><p align="right"><?PHP if($TotOutPoints){echo number_format($TotOutPoints,2,".","");}else{echo "0.00";}?></p></div>

</div>
        <!--<div class="page-wrap">
          <div class="pagination">
            <?php	//echo $pagination; ?>
          </div>
        </div>-->
      </div>
    </div>
        <?php }else{ 
		  if(empty($_POST) || $_POST['reset'] == 'Clear'){
		    $message  = "Please select the search criteria"; 
		  }else{
		    $message  = "There are currently no records found in this search criteria.";
		  }
		?>
        <div class="tableListWrap">
          <div class="data-list">
            <table id="list4" class="data">
              <tr>
                <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
              </tr>
            </table>
          </div>
        </div>
        <?php } ?>

    <div id="proofs" align="center" class="popup" style="position:absolute;margin-left:auto;margin-right:auto;display:none;"> <img src='<?php echo base_url();?>static/images/ajax-loader.gif' width='16' height='16' border='0'> </div>
    <div id="user_status_desc" class="popup" style="width:250px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
      <form name="descriptionSTATUS" id="descriptionSTATUS" method="post">
        <input type="hidden" name="userSID" id="userSID"/>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="90%" height="50px;" style="font-size:120%; background-color:#017AB3;padding-left:10px;">Reason for Deactivate Kiosk</td>
            <td width="10%" align="right" style="background-color:#017AB3;"><img src="<?php echo base_url();?>static/images/close.gif" alt="close" title="close" border="0" onClick="closeDiv();"/></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><textarea name="desc_status" id="desc_status" class="TextArea" cols="25" rows="5"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" height="50px;"><input class="button" type="button" name="submit" id="submit" value="Save" 
			onclick="UserDeActivateDescription()" />
              &nbsp;
              <input type="button" class="button" name="close" id="close" value="close" 
			onClick="closeDiv();" />
              <span id="saved_desc" style="font-size:90%;"></span></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
    <?php //} ?>
</div>
</div>
</div>
</div>

<?php echo $this->load->view("common/footer"); ?>