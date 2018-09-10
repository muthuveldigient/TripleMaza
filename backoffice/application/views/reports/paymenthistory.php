<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script src ="<?php echo base_url(); ?>static/js/thickbox.js"  type="text/javascript" ></script>
<link href="<?php echo base_url(); ?>static/css/thickbox.css" rel="stylesheet" type="text/css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function confirmDelete(){
var agree=confirm("Are you sure you want to delete this file?");
if(agree)
    return true;
else
     return false;
}

function activateUser(status,userid,positionid){
   xmlHttp3=GetXmlHttpObject()
   
   if(status == 1){
     var urlstatus = 'deactive';
   }else{
     var urlstatus = 'active';
   }
   var url='<?php echo base_url()."user/ajax/"?>'+urlstatus+'/'+userid;    
 
   //url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showsubagent(userid,status,positionid)
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}


function ShowAdditions() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0)
    { 		
            var result=xmlHttp3.responseText;
            document.getElementById("status_approve_"+intrefno).innerHTML=result;
 	}

} 

function clsDiv()
{
	document.getElementById('save_desc').innerHTML = '';	
	document.getElementById('desc_reason').value = '';
        //document.getElementById('userid').value = '';
	Popup.hide('user_approve_desc');
        window.opener.location.reload();
}
</script>
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
function chkdatevalue()
{
   if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false){
        alert("Please enter the valid date");
        return false;
    }else{
       // alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')=="1"){
        alert("Start date should be greater than end date");
        return false;
        }
        return true;
    }
   } 
}



function Hidedist(){
    document.getElementById("affiliatesection").innerHTML='';    
}

function openDESCRIPTION_Div(id){
		Popup.show('user_status_desc');
}

function openDESC_Div(id,transid,intrefid){
        document.getElementById('userid').value = id;
		document.getElementById('paytransid').value = transid;
		document.getElementById('internalid').value = intrefid;
		Popup.show('user_approve_desc');
}

function verify(){
    xmlHttp3=GetXmlHttpObject()
     
    var userid      = document.getElementById("userid").value; 
    var desc_reason = document.getElementById("desc_reason").value;
	var transid     = document.getElementById("paytransid").value;
    var form = document.getElementById('descSTATUS'); // if you passed the form, you wouldn't need this line.
    for(var i = 0; i < form.approve.length; i++){
          if(form.approve[i].checked){
          var approve = form.approve[i].value;
          }
 
     }
     //alert(desc_reason);
//     if(desc_reason == ''){
//        alert("Comments Required !!!.")
//	return false;  
//     }

    var url='<?php echo base_url()."reports/payment/approve/"?>'+userid+'/'+approve+'/'+desc_reason+'/'+transid;
    //alert(url);//return false;
    xmlHttp3.onreadystatechange=ShowAdditions
    xmlHttp3.open("GET",url,true);
    xmlHttp3.send(null);
    return false;

}

function ShowAdditions(){

    var userid123  =  document.getElementById("userid").value;
	var internalid     = document.getElementById("internalid").value;
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0){ 		
            var result=xmlHttp3.responseText;
			document.getElementById("status_verify_"+internalid).innerHTML=result;
			document.getElementById("status_change_"+internalid).innerHTML=result;
	    	document.getElementById('desc_reason').value = '';
            Popup.hide('user_approve_desc');
           // window.opener.location.reload(true);
           // window.refresh();
 	}

} 
</script>
<div id="user_approve_desc" class="popup" style="width:350px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
      
    <form enctype="multipart/form-data" action="" name="descSTATUS" id="descSTATUS" method="post" onsubmit="return verify();" >
      <!--<input type="hidden" name="userSID" id="userSID" value=""/>-->
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90%" height="50px;" style="font-size:120%;padding-left:10px;"> Approve Payment</td>
          <td width="10%" align="right"><img style="cursor:pointer;" src="<?php echo base_url();?>static/images/close.gif" alt="close" title="close" border="0" onClick="clsDiv();"/></td>
        </tr>
        <input type="hidden" name="userid" id="userid" value="">
        <input type="hidden" name="paytransid" id="paytransid" value="">
        <input type="hidden" name="internalid" id="internalid" value="">
       <tr>
          <td style="padding:11px;"><br />
<input type="radio" name="approve" id="approve" value="2"  checked>Approve
<input type="radio" name="approve" id="approve" value="0">Rejected
           </td>
        </tr>
        <tr>
        <td style="padding:11px;"><b></b> <br /><textarea style="display:none;" name="desc_reason" id="desc_reason" cols="25" rows="5" class="TextArea"></textarea></td>
        </tr>
        <tr>
          <td style="padding:11px;" height="50px;"><input type="submit" name="submit" id="submit" value="Save" onclick="" />
            &nbsp;
            
            <input type="button" name="close" id="close" value="close" onClick="clsDiv();" />
            <span id="save_desc" style="font-size:90%;"></span></td>
        </tr>
      </table>
    </form>
  </div>

<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<style>
#TB_window{
  height: 350px !important;
}
</style>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Payment Report</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/payment/history?rid=18" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                  <label>
                  <input type="text" name="username" id="username" class="TextField" value="<?PHP if(isset($username)) echo $username; ?>" >
                  </label></td>
                  
                <td width="40%"><span class="TextFieldHdr">Internal Reference No:</span><br />
                  <label>
                  <input type="text" name="ref_no" id="ref_no" class="TextField" value="<?PHP if(isset($ref_no)) echo $ref_no; ?>" >
                  </label></td>
                  
                <td width="40%"><span class="TextFieldHdr">Products:</span><br />
                  <label>
                    
                    <select class="TextField" name="payment_mode">
                       <option value="">Select</option>
					   <option value=""></option>
                    </select>
                  </label></td> 
                <td width="20%">&nbsp;</td>
              </tr>                                   
               <tr>                     
                <td width="40%"><span class="TextFieldHdr">Status:</span><br />
                  <label>
                    <select  name="status_id" id="status_id" class="ListMenu">
                    <option value="">Select</option>
                    <option value="1" <?php if($status_id=="1") echo "selected=selected";?>>Success</option>
                    <option value="2" <?php if($status_id=="2") echo "selected=selected";?>>Pending</option>
                    <option value="122" <?php if($status_id=="122") echo "selected=selected";?>>Initiated</option>
                    <option value="3" <?php if($status_id=="3") echo "selected=selected";?>>Rejected</option>
                    <option value="4" <?php if($trans_status=="4") echo "selected=selected";?>>Cancelled</option>
                    <option value="204" <?php if($status_id=="204") echo "selected=selected";?>>Failed</option>
                    </select>
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Amount:</span><br />
                  <label>
                  <input type="text" name="amount" id="amount" class="TextField" value="<?PHP if(isset($amount)) echo $amount; ?>" >
                  </label></td>                  
                  
                <td width="40%"><span class="TextFieldHdr">Payment Service Provider:</span><br />
                  <label>
                    <select class="TextField" name="payment_mode">
                       <option value="">Select</option>
					  <?php foreach($providers as $provide){ ?>
                      <option value="<?php echo $provide->PAYMENT_PROVIDER_ID; ?>"><?php echo $provide->PROVIDER_NAME; ?></option>
                      <?php } ?>
                    </select>
                  </label></td>
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                <?php
					$S_START_DATE_TIME="";
					if(isset($_REQUEST['START_DATE_TIME']))
						$S_START_DATE_TIME = $_REQUEST['START_DATE_TIME']; 	
					if(isset($START_DATE_TIME))
						$S_START_DATE_TIME = date('d-m-Y 00:00:00',strtotime($START_DATE_TIME));
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
					if(isset($_REQUEST['END_DATE_TIME']))
						$E_END_DATE_TIME = $_REQUEST['END_DATE_TIME']; 	
					if(isset($END_DATE_TIME))
						$E_END_DATE_TIME = date('d-m-Y 23:59:59',strtotime($END_DATE_TIME));
					else
						$E_END_DATE_TIME = date("d-m-Y 23:59:59");
				?>                
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP echo $E_END_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
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
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </form>
        </td>
        <td><form action="<?php echo base_url();?>reports/payment/history?rid=18" method="post" name="clrform" id="clrform">
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
      
<?php $page = $this->uri->segment(4);
	  if(isset($page) && $page !=''){
	  	$j=$page;
      }else{
        $j=0;
      }  
									
		$resvalues=array();
        if(isset($results)){ 
        if(count($results)>0 && is_array($results)){
        	for($i=0;$i<count($results);$i++){
			//get user name
			$username	  = $this->Account_model->getUserNameById($results[$i]->USER_ID);
			$providerName = $this->payment_model->getProviderNameById($results[$i]->PAYMENT_PROVIDER_ID);
			$amount  = $results[$i]->PAYMENT_TRANSACTION_AMOUNT;
			$transactionStatus  = $this->payment_model->getPaymentTransNameById($results[$i]->PAYMENT_TRANSACTION_STATUS);
			$date  = date("d/m/Y h:i:s",strtotime($results[$i]->PAYMENT_TRANSACTION_CREATED_ON));
			$internalReferece  = $results[$i]->INTERNAL_REFERENCE_NO;
			//$chip   = $this->payment_model->getChipValue($results[$i]->PAYMENT_TRANSACTION_AMOUNT);
												
			$resvalue['SNO']=$j+1;
			$resvalue['USERNAME']= '<a href="'.base_url().'user/account/detail/'.$results[$i]->USER_ID.'?rid=18">'.$username.'</a>';												
		    $resvalue['PROVIDER_NAME']= $providerName;
			$resvalue['AMOUNT'] = $amount;
										
			$resvalue['TRANS_STATUS']= '<div id="status_change_'.$i.'"> '.$transactionStatus.' </div>';

			if($transactionStatus == 'Pending'){
				$resvalue['Action'] = '<div id="status_verify_'.$i.'"><a href="javascript:openDESC_Div('.$results[$i]->USER_ID.','.$results[$i]->PAYMENT_TRANSACTION_ID.','."'$i'".');"><font color="#DBA901">Pending</font></a></div>';
			}else{
				$resvalue['Action'] = '-';
			}
			$resvalue['DATE']= $date;
			//$resvalue['REFERECNE_NO'] = $internalReferece;
			$resvalue['REFERECNE_NO'] = '<div id="status_approve_'.$results[$i]->USER_ID.'"><a class="thickbox" href="#TB_inline?height=650&width=450&inlineId=myOnPageContent'.$internalReferece.'" title="Transaction Id : '.$internalReferece.'"  >'.$internalReferece.'</a></div>';
											
            if($resvalue){
	            $arrs[] = $resvalue;
            }	?>
		<div style="display: none;" id="myOnPageContent<?php echo $internalReferece; ?>">
		<div class="UDpopBg" style="padding: 7px;">
		<div class="UDpopupWrap">
			<h2><u>Payment Information</u></h2>
            <br />
        <div class="UDpopLeftWrap">
		<div class="UDFieldtitle"><b>Username:</b> &nbsp;<?php echo $username; ?></div>
		</div>
		<div class="UDpopLeftWrap">
		<div class="UDFieldtitle"><b>Date:</b> &nbsp;<?php echo $date; ?></div>
		</div>
		<div class="UDpopLeftWrap">
		<div class="UDFieldtitle"><b>Status:</b>  &nbsp;
		<?php 		echo $transactionStatus;		?>
		</div>
		</div>
		<div class="UDpopLeftWrap">
		<div class="UDFieldtitle"><b>Payment Mode:</b> &nbsp;
		<?php   	echo $providerName;				?>
		</div>
		</div>
		<div class="UDpopLeftWrap">
		<div class="UDFieldtitle"><b>Amount:</b> &nbsp;<?php echo $amount; ?></div>
		</div>
        <?php  	$returnvalues = array();
				$returnvalue = json_decode($results[$i]->PAYPAL_RETURN_VALUES);
				$uid = $this->Account_model->getUserIdByName($username);
				//$returnValues = josn_decode($results[$i]->PAYPAL_RETURN_VALUES);
				$paymentTimestamp = $returnvalue->TIMESTAMP;
				$payerEmailid = $returnvalue->EMAIL;
				$payerId = $returnvalue->PAYERID;
				$payerStatus = $returnvalue->PAYERSTATUS;
				$countryCode = $returnvalue->COUNTRYCODE;
				$currencyCode = $returnvalue->CURRENCYCODE;
				$payChips = $returnvalue->L_NAME0;	 ?>
         <br />
         <h2><u>Paypal Return Values</u></h2><br />
         <input type="hidden" value="<?php echo $internalReferece; ?>" name="reference_nos" id="reference_nos" />
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Payment Timestamp:</b> &nbsp;<?php echo $paymentTimestamp; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Payer Email ID:</b> &nbsp;<?php echo $payerEmailid; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Payer Transaction ID:</b> &nbsp;<?php echo $payerId; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Payer Status:</b> &nbsp;<?php echo $payerStatus; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Country Code:</b> &nbsp;<?php echo $countryCode; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Currency Code:</b> &nbsp;<?php echo $currencyCode; ?></div></div>
         <div class="UDpopLeftWrap"><div class="UDFieldtitle"><b>Chip Value:</b> &nbsp;<?php echo $payChips; ?></div></div>
		 <div style="padding:30px;" class="UDpopupform">
		 <?php if($transactionStatus == 'Pending'){ ?>
		 <form action="" method="post" name="tsearchform" id="approveform" onsubmit="return gtapprove('<?php echo $internalReferece; ?>','<?php echo $amount; ?>','<?php echo $uid; ?>');">
								
		 	<input type="hidden" value="<?php echo $row['INTERNAL_REFERENCE_NO']; ?>" name="reference_no" id="reference_no" />
			<input name="status" type="hidden" value="<?php echo $_REQUEST['status']; ?>" />
			<input name="st_time" type="hidden" value="<?php echo $_REQUEST['st_time']; ?>" />
			<input name="end_time" type="hidden" value="<?php echo $_REQUEST['end_time']; ?>" />
			<input name="prname" type="hidden" value="<?php echo $_REQUEST['prname']; ?>" />
			<input name="amount" type="hidden" value="<?php echo $_REQUEST['amount']; ?>" />
			<input name="uname" type="hidden" value="<?php echo $_REQUEST['uname']; ?>" />
			<input name="pmode" type="hidden" value="<?php echo $_REQUEST['pmode']; ?>" />
			<input name="prod_id" type="hidden" value="<?php echo $_REQUEST['prod_id']; ?>" />
			<input name="ptransid" type="hidden" value="<?php echo $_REQUEST['ptransid']; ?>" />
			<input name="amnt" type="hidden" value="<?php echo $row['PAYMENT_TRANSACTION_AMOUNT']; ?>" />
			<input name="total_bal" type="hidden" value="<?php echo $USER_TOT_BALANCE; ?>" />
			<input name="usid" type="hidden" value="<?php echo $row['USER_ID']; ?>" />
			<input name="prid" type="hidden" value="<?php echo $PRODUCT_NAME; ?>" />
			<input name="coin_typeid" type="hidden" value="<?php echo $COIN_TYPE_ID; ?>" />
			<input type="hidden" value="<?php echo $row['INTERNAL_REFERENCE_NO']; ?>" name="key" id="key<?php echo $row['INTERNAL_REFERENCE_NO']; ?>" />
			<input type="submit" class="button" value="Approve" name="approve" style="float:left" onclick="document.getElementById('key<?php echo $row['INTERNAL_REFERENCE_NO']; ?>').value='approve';"/> &nbsp;&nbsp;
<!--<input type="submit" class="button" value="Refund" name="refund" style="float:left" onclick="document.getElementById('key<?php echo $row['INTERNAL_REFERENCE_NO']; ?>').value='refund';"/> &nbsp;&nbsp;
<input type="submit" class="button" value="Cancel" name="cancel"  style="float:left" onclick="document.getElementById('key<?php echo $row['INTERNAL_REFERENCE_NO']; ?>').value='cancel';"/> &nbsp;&nbsp;-->
		 </form>
<?php } ?>
</div>
</div>
</div>
</div>
<?PHP   $j++;
		}
        }else{
        	$arrs="";
		}
        }   
	 	if(isset($arrs) && $arrs!=''){ ?>
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
    <b> Total Amount: <font color="green">(<?php echo $tot_Amt; ?>) </font></b> &nbsp;&nbsp;&nbsp;
    <!--<b> Total Payments: <font color="#FF3300">(<?php //echo $tot_users; ?>) </font></b> &nbsp;&nbsp;&nbsp;
    <b> Success Payments: <font color="green">(<?php //echo $success_payments; ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Pending Payments: <font color="#FF3300">(<?php //echo $pending_payments; ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Failed Payments: <font color="#FF3300">(<?php //echo $failed_payments; ?>)</font></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
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
					colNames:['Username','Internal Referecne NO','Provider Name','Amount','Date & TimeStamp','Status','Action'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:70},
						{name:'REFERECNE_NO',index:'REFERECNE_NO', align:"center", width:70},						
						{name:'PROVIDER_NAME',index:'PROVIDER_NAME', align:"center", width:40},
						{name:'AMOUNT',index:'AMOUNT', align:"right", width:40,sorttype:"int"},
						{name:'DATE',index:'DATE', align:"center", width:60},						
						{name:'TRANS_STATUS',index:'TRANS_STATUS', align:"center", width:40},
						{name:'Action',index:'Action', align:"center",width:30},
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
                <?php	echo $pagination; ?>
              </div>
            </div>
          </div>
        </div>
        <?php }else{ 
		  if(empty($_POST) || $_POST['reset'] == 'Clear'){
		    $message  = "Please select the search criteria"; 
		  }else{
		    $message  = "There are currently no history found in this search criteria.";
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
      </div>
    </div>
  </div>
</div>

<?php
 function getStatusString($code){
    switch ($code) {
		case 'TRANS_PAYPAL_INITIATED':
			$product_status_val = 'Pending';
			break;
		case 'TRANS_START':
			$product_status_val = 'Started';
			break;
		case 'TRANS_FAILED':
			$product_status_val = 'Failed';
			break;
		case 'TRANS_SUCCESS':
			$product_status_val = 'Success';
			break;
		case 'TRANS_SUCCESS_WITH_WARNING':
			$product_status_val = 'Success';
			break;
	}
	
	return $product_status_val;
 }

 echo $this->load->view("common/footer"); ?>