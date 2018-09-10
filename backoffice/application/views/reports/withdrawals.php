<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script>
var isAllCheck = false;
function chkAllCheckboxes() {
	var chkWithdrawals=document.getElementById('withdrawFunctions');
	for(var i = 0; i < chkWithdrawals.length; i++){
		chkWithdrawals[i].checked = !isAllCheck	
	}
	isAllCheck = !isAllCheck;	
}

function checkChk(){
  var i, dLen = document.withdrawFunctions["wBatch[]"].length;
    if (typeof dLen === "undefined") {
        if (document.withdrawFunctions["wBatch[]"].checked) return true;
    }
    else {
        for (i = 0; i < dLen; i++) {
            if (document.withdrawFunctions["wBatch[]"][i].checked) return true;
        }
    }
	
	alert("Check something"); return false;
}

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
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy')==false){
        alert("Please enter the valid date");
        return false;
    }else{
       // alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy')=="1"){
        alert("Start date should be greater than end date");
        return false;
        }
        return true;
    }
   } 
}
function NewWindow(mypage,myname,w,h,scroll){
var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
win = window.open(mypage,myname,settings);
}
</script>
<style>
#buttong,#buttong1{
  background: #ccc !important;
  border:none;
}
</style>
<?php
$message = "";
$j=$this->uri->segment(4); 
if(empty($j) || $pageNo==1) {
	$Sno=1;
} else {
	$Sno = $j + 1;
}

$statusId  =  $this->session->userdata['withdrawalSearchData']['TRANSACTION_STATUS_ID'];

if(!empty($withdrawRequests)) {
	foreach($withdrawRequests as $wIndex=>$withdrawRequest) {
	
	    $panProof 		= $this->Account_model->getVerificationInfo($withdrawRequest->USER_ID,4);
		$panVerifi      = $panProof->VERIFICATION_PROOF;
		
		$addressProof 	= $this->Account_model->getVerificationInfo($withdrawRequest->USER_ID,3);
		$addVerifi      = $addressProof->VERIFICATION_PROOF;
		
		//GET WITHDRAW TYPE AND WITHDRAW BY
		$withInfo 		= $this->withdrawal_model->getWithdrawInfo($withdrawRequest->INTERNAL_REFERENCE_NO);
		$withInfoType   = $withInfo[0]->WITHDRAW_TYPE;
		$withInfoBy     = $withInfo[0]->WITHDRAW_BY; 
		
	
		//$resValue[$wIndex]['SNO']          = $Sno;
		$resValue[$wIndex]['USERNAME'] = '<a href="'.base_url().'user/account/detail/'.$withdrawRequest->USER_ID.'?rid=18">'.$withdrawRequest->USERNAME.'</a>';
		$resValue[$wIndex]['TRANSACTION_AMOUNT']   = $withdrawRequest->TRANSACTION_AMOUNT;													
		//$resValue[$wIndex]['INTERNAL_REFERENCE_NO']= '<a href="'.base_url().'user/ajax/viewWithdrawInfo/'.$withdrawRequest->INTERNAL_REFERENCE_NO.'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )">'.$withdrawRequest->INTERNAL_REFERENCE_NO.'</a>';
		$resValue[$wIndex]['INTERNAL_REFERENCE_NO'] = '<a href="#" onclick="NewWindow(\''.base_url().'user/ajax/viewWithdrawInfo/'.$withdrawRequest->INTERNAL_REFERENCE_NO.'/'.$withdrawRequest->MASTER_TRANSACTTION_ID.'?rid=53\',\'Game Details\',\'1032\',\'900\',\'yes\')"><strong>'.$withdrawRequest->INTERNAL_REFERENCE_NO.'</strong></a>';
		
		$resValue[$wIndex]['TRANSACTOIN_STATUS']   = $withdrawRequest->TRANSACTION_STATUS_DESCRIPTION;
		if($withInfoType != ""){
			$resValue[$wIndex]['TYPE']   = $withInfoType;
		}else{
			$resValue[$wIndex]['TYPE']   = "-";
		}
		if($withInfoBy != ""){ 
			$resValue[$wIndex]['BY']   = $withInfoBy;
		}else{
			$resValue[$wIndex]['BY']   = "-";
		}
		$resValue[$wIndex]['TRANSACTION_DATE']     = date('d-m-Y h:i:s',strtotime($withdrawRequest->TRANSACTION_DATE));	
		if($panVerifi != ''){
		  $resValue[$wIndex]['PANNO'] = '<a onclick="return hs.expand(this)" class="highslide " href="'.base_url().'static/uploads/proof/'.$panVerifi.'"><img src="'.base_url().'static/images/drag.png" alt="" width="14" height="12" style="border:none;"/></a>';
		}else{
		   $resValue[$wIndex]['PANNO']       = "-";  
		}
		
		if($addVerifi != ''){
		  $resValue[$wIndex]['ADDRSS_PROOF'] = '<a onclick="return hs.expand(this)" class="highslide " href="'.base_url().'static/uploads/proof/'.$addVerifi.'"><img src="'.base_url().'static/images/drag.png" alt="" width="14" height="12" style="border:none;"/></a>';
		}else{
		   $resValue[$wIndex]['ADDRSS_PROOF']       = "-";  
		}
		
		$resValue[$wIndex]['BATCH']     = "No";		
		if($withdrawRequest->TRANSACTION_STATUS_ID=="109")
			$resValue[$wIndex]['ACTION'] = '<input type="checkbox" name="wBatch[]" value="'.$withdrawRequest->INTERNAL_REFERENCE_NO.'" />';
		else
			$resValue[$wIndex]['ACTION']    = "-";
		$Sno++;
	}	
}
?>

<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Withdrawal Report</strong></td>
                </tr>
            </table>
            <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
                <tr>
                	<td width="35%">
                    	<?php 
							$attributes = array('id' => 'listWithdrawals','name' => 'listWithdrawals');
							echo form_open('reports/withdrawal/index?rid=53',$attributes);
						?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('User Name', 'Username');?>:
                        </span><br />  
						<?php
							if(!empty($this->session->userdata['withdrawalSearchData']['USERNAME']))
								$SUsername = $this->session->userdata['withdrawalSearchData']['USERNAME'];	
														
							$Username = array(
								  'name'        => 'username',
								  'id'          => 'username',
								  'class'		=> 'TextField',
								  'value'		=> $SUsername, 												  
								  'maxlength'   => '35'
								);		
							echo form_input($Username);	
                        ?>                                        
                    </td>
                	<td width="35%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Internal Reference No', 'WithdrawID');?>:
                        </span><br />                     
							<?php	
							if(!empty($this->session->userdata['withdrawalSearchData']['INTERNAL_REFERENCE_NO']))
								$SWithdrawID = $this->session->userdata['withdrawalSearchData']['INTERNAL_REFERENCE_NO'];
																							
							$WithdrawID = array(
								  'name'        => 'withdrawid',
								  'id'          => 'withdrawid',
								  'class'		=> 'TextField',	
								  'value'		=> $SWithdrawID,								  											  
								  'maxlength'   => '35'
								);		
							echo form_input($WithdrawID);									
                            ?>                        
                    </td>                    
                    <td width="30%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Status', 'Status');?>:
                        </span><br /> 
                        <?php
							if(!empty($this->session->userdata['withdrawalSearchData']['TRANSACTION_STATUS_ID']))
								$wStatus = $this->session->userdata['withdrawalSearchData']['TRANSACTION_STATUS_ID'];																				
						?>                    
                        <select name="withdrawStatus" id="withdrawStatus" class="lstTextField">
							<option value="" selected="selected">--- Select ---</option>
							<option <?php if($wStatus == 109) echo 'selected="selected"'; ?>  value="109">Pending</option>
							<option <?php if($wStatus == 208) echo 'selected="selected"'; ?> value="208">Approved</option>
							<option <?php if($wStatus == 111) echo 'selected="selected"'; ?> value="111">Paid</option>
							<option <?php if($wStatus ==112) echo 'selected="selected"'; ?> value="112">Rejected</option>                                                        							
						</select>                    
                    </td>
                </tr>
                <tr>
                	<td width="35%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('From', 'StartDate');?>:
                        </span><br /> 
						<label>
                        <?php
							$startDateValue="";
							if(!empty($this->session->userdata['withdrawalSearchData']['TRANSACTION_SDATE'])){
								$startDateValue = date('d-m-Y 00:00:00',strtotime($this->session->userdata['withdrawalSearchData']['TRANSACTION_SDATE']));
							}else{
								$startDateValue = "";
							}
						?>
		                	<input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?php echo $startDateValue;?>">
		                </label> 
                        <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>                                                            
                    </td>
                	<td width="35%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('To', 'EndDate');?>:
                        </span><br />                                     
						<label>
                        <?php
							$endDateValue="";
							if(!empty($this->session->userdata['withdrawalSearchData']['TRANSACTION_EDATE'])){
								$endDateValue = date('d-m-Y 23:59:59',strtotime($this->session->userdata['withdrawalSearchData']['TRANSACTION_EDATE']));
							}else{
								$endDateValue = "";
							}
						?>                        
							<input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?php echo $endDateValue;?>">
                  		</label> 
                        <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>                           
                    </td>                    
                    <td width="30%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Date Range', 'DateRange');?>:
                        </span><br />  
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
						</label>                                                             
                    </td>
                </tr>                
                <tr>
                	<td colspan="3">
						<?php 
							echo form_submit('frmSearch', 'Search')."&nbsp;";
							echo form_submit('frmClear', 'Clear');
                            echo form_close();							
						?>                    
                    </td>
                </tr>                                            
            </table>
        
	    <div class="tableListWrap">
	  <div class="data-list">
           
            	<?php
                if(!empty($searchResult) && !empty($withdrawRequests)) {
				?>
<?php
	$attributes1 = array('id' => 'withdrawFunctions','name' => 'withdrawFunctions');
	echo form_open('reports/withdrawal/withdrawFunctions',$attributes1);
?>                
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
                            colNames:['User Name', 'Amount', 'Internal Reference No','STATUS','Type','Via','Date','PAN','Add. Proof','Batch','Action'],							
                            colModel:[
                                {name:'USERNAME',index:'USERNAME',align:"center",width:60},
                                {name:'TRANSACTION_AMOUNT',index:'TRANSACTION_AMOUNT', align:"right",width:40, sorttype:"float"}, 
								{name:'INTERNAL_REFERENCE_NO',index:'INTERNAL_REFERENCE_NO',align:"center",width:105},								
                                {name:'TRANSACTOIN_STATUS',index:'TRANSACTOIN_STATUS',align:"center", width:40,sortable:false},
								{name:'TYPE',index:'TYPE',align:"center", width:40,sortable:false},
								{name:'BY',index:'BY',align:"center", width:40,sortable:false},
								{name:'TRANSACTION_DATE',index:'TRANSACTION_DATE',align:"center",width:65},
                                {name:'PANNO',index:'PANNO',align:"center", width:20,sortable:false}, 
								{name:'ADDRSS_PROOF',index:'ADDRSS_PROOF',align:"center",width:40,sortable:false},								
                                {name:'BATCH',index:'BATCH', width:20, align:"center",sortable:false}, 								
                                {name:'ACTION',index:'ACTION', width:30, align:"center",sortable:false}, 							
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
                </script> 

                <div class="page-wrap">
                  <div class="pagination">
                    <?php	echo $pagination; ?>
                  </div>
                </div>
<div>
<?php 
	$btnCheckALL = array(
		'name' => 'CheckALL',
		'id' => 'button',
		'value' => 'Check ALL',
		'type' => 'button',
		'content' => 'Check / Uncheck ALL',
		'onclick' => 'chkAllCheckboxes();'
	);	
	
	$btnApprove = array(
		'name' => 'Approve',
		'id' => 'button',
		'value' => 'Approve',
		'type' => 'submit',
		'content' => 'Approve',
		'onclick' => 'checkChk();'
	);	
	
	$btnApproveNBatch = array(
		'name' => 'ApprvoeAndCreateBathch',
		'id' => 'buttong',
		'value' => 'Approve and Create Batch',
		'type' => 'button',
		'content' => 'Approve and Create Batch',
		'href' => '#'
	);	
	
if($statusId == 208){	
	$btnBatch = array(
		'name' => 'CreateBathch',
		'id' => 'buttong1',
		'value' => 'Create Batch',
		'type' => 'button',
		'content' => 'Create Batch',
		'href' => '#'
	);	
}
	
							
	echo form_button($btnCheckALL)."&nbsp;";						
	echo form_submit($btnApprove)."&nbsp;";
	echo form_submit($btnApproveNBatch)."&nbsp;";
	if($statusId == 208){ echo form_submit($btnBatch)."&nbsp;"; }
	echo form_close();							
?> 
</div>
               <?php } else { 
               		$message = "Please select the search criteria";
               } 
			 if(empty($withdrawRequests) && !empty($searchResult))  
			 	$message = "There is no record to display";
			 if(!empty($message)) {?> 
            <table id="list4" class="data">
              <tr>
                <td>
                	<img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span>
                 </td>
              </tr>
            </table>               
           	<?php } ?>
            </div>
        </div>                           
        </div>
        </div>
    </div>
</div>
<?php $this->load->view("common/footer"); ?>	