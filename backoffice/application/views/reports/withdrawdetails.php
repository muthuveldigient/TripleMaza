<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<style>
*{
	margin:0;
	padding:0;
	font-family:Arial, Helvetica, sans-serif;
	}
	li{
		list-style:none;
		float:left;
		}
.container_searchgame{
	padding:1px;
	border:1px solid #dff4ff;
	overflow:hidden;
	margin:10px 20px;
	min-width:600px;
	float:left;
	}
.container_searchgame ul {
	overflow:hidden;
	min-width:600px;
	}
.container_searchgame ul li {
	border-right:1px solid #71d0ff;
	overflow:hidden;
	min-width:171px;
	}
.cnt_userdetails li{
	min-height:105px;
	background-color:#d2f0ff;
	}
.container_searchgame ul li h3{
	margin:0;
	line-height:38px;
	font-size:13px;
	color:#fff;
	font-family:Arial, Helvetica, sans-serif;
	padding:0 30px;
	height:	39px;
	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);
	background-repeat:repeat-x;
	text-align:center;
	}
.searchgame_cardcnt{
	overflow:hidden;
	background-color:#d2f0ff;
	padding:9px;
	min-height:90px;
	text-align:center;
	min-width:101px;
	}
.searchgame_cardcnt p{
	font-size:13px;
	color:#333333;
	float:left;
	margin-left:5px;
	text-align:center;
	}
.searchgame_cardcnt p.usrname{
	line-height:87px;
	}
	
.userdetail_searchgame{
	padding:1px;
	border:1px solid #dff4ff;
	overflow:hidden;
	margin:10px 20px;
	min-width:600px;
	float:left;
	}
.userdetail_searchgame ul {
	overflow:hidden;
	min-width:600px;
	}
.userdetail_searchgame ul li {
	border-right:1px solid #71d0ff;
	overflow:hidden;
	min-width:115px;
	}	
.userdetail_searchgame ul li h3{
	margin:0;
	line-height:38px;
	font-size:13px;
	color:#fff;
	font-family:Arial, Helvetica, sans-serif;
	padding:0 30px;
	height:	39px;
	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);
	background-repeat:repeat-x;
	text-align:center;
	}
.table_card{
	margin: 20px 20px;
	overflow:hidden;
	}
.table_card h3{
	margin:0;
	font-size:13px;
	font-family:Arial, Helvetica, sans-serif;
	}
.cnt_userprofile{
	display:table;
	}
.cnt_userprofile li{
	min-height:135px;
	background-color:#d2f0ff;
	display:table-cell;
	}
.tablecards p{
	float:left;
	padding-left:10px;
	}
.tablecard_cnt{
	width:370px;
	overflow:hidden;
	float:left;
	}
.tablecard_cnt h3{
	text-align:left;
	margin:0 10px 10px 0;
	}
.potamount{
	width:210px;
	overflow:hidden;
	float:left;
	margin-top:20px;
	}
.potamount h3{
	text-align:right;
	margin-bottom:10px;
	float:left;
	line-height:20px;	
	width:100px;
	}
.potamount span{
	float:left;
	line-height:20px;	
	margin-left:5px;
	font-size:13px;
	}
.rake{
	width:250px;
	overflow:hidden;
	float:left;
	margin-top:20px;
	}
.rake h3{
	text-align:right;
	margin-bottom:10px;
	float:left;
	line-height:20px;
	width:100px;
	}
.rake span{
	float:left;
	line-height:20px;
	margin-left:5px;
	font-size:13px;	
	}

</style>

<style>
/* New styles below */
label.valid {
  /*background: url(assets/img/valid.png) center center no-repeat;*/
  display: inline-block;
  text-indent: -9999px;
}
label.error {
	color: #FF0000;
    font-weight: normal;
    left: -8px;
    margin-top: -5px;
    padding: 0 9px;
    position: relative;
    top: 3px;
	float:left;
}
</style>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script> 
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		email: true
	};
	$('#NeftInfo').validate({
		rules: {
		date: ruleSet1,
		//EMAIL: ruleSet2,
		trans_id: ruleSet1,
		amount: ruleSet1,
		acnt_number: ruleSet1,
		user_acnt_number: ruleSet1,
		ifsc_code: ruleSet1,
		branch: ruleSet1
  	},
	messages: {
    	date: "Enter Date ",
		//EMAIL: "Enter valid email id",
		trans_id: "Enter Trans_id",
		amount: "Enter Amount",
		acnt_number: "Select Account Number",
		user_acnt_number: "Select User Account Number",
		ifsc_code: "Enter IFSC Code",
		branch: "Enter Branch"
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.closest('.control-group').removeClass('error').addClass('success');
  	},
	submitHandler: function (form) {
   	formSubmit();
	}
 });
}); // end document.ready
</script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
	var ruleSet1 = {
        required: true
    };
	var ruleSet2 = {
		required: true,
		email: true
	};
	$('#gameForm').validate({
		rules: {
		bankname: ruleSet1,
		//EMAIL: ruleSet2,
		cheque_number: ruleSet1,
		cheque_amount: ruleSet1,
		date: ruleSet1,
		account_number: ruleSet1,
		courier_name: ruleSet1,
		awb_no: ruleSet1,
		charges: ruleSet1
  	},
	messages: {
		bankname: "Enter BankName",
    	//EMAIL: "Enter valid email id",
		cheque_number: "Enter Cheque No",
		cheque_amount: "Enter Cheque Amount",
		date: "Enter Date ",
		account_number: "Select Account Number",
		courier_name: "Enter Courier Name",
		awb_no: "Enter AWB No",
		charges: "Enter Charges"
    },
	highlight: function(element) {
    	$(element).closest('.control-group').removeClass('success').addClass('error');
  	},
  	success: function(element) {
    	element
    	.closest('.control-group').removeClass('error').addClass('success');
  	},
	submitHandler: function (form) {
   	ajaxSubmit();
  }
 });
}); // end document.ready
</script>
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';


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
          document.getElementById("date").value=sdate;
          document.getElementById("END_DATE_TIME").value=edate;
      }      
        
    }

</script>
<?php
$username  		= $getWithdrawDetil[0]->USERNAME;
$userid         = $getWithdrawDetil[0]->USER_ID;
$firstname  	= $getWithdrawDetil[0]->FIRSTNAME;
$lastname  		= $getWithdrawDetil[0]->LASTNAME;
$trans_amount  	= $getWithdrawDetil[0]->TRANSACTION_AMOUNT;
$hand_id   		= $getWithdrawDetil[0]->INTERNAL_REFERENCE_NO;
$trans_status  	= $getWithdrawDetil[0]->TRANSACTION_STATUS_ID;
$trans_date  	= $getWithdrawDetil[0]->TRANSACTION_DATE;
$description  	= $getWithdrawDetil[0]->TRANSACTION_STATUS_DESCRIPTION;
$trans_id	  	= $withdrawId;
//GET USER ADDRESS PROOF
$panProof 		= $this->Account_model->getVerificationInfo($userid,4);
$panVerifi      = $panProof->VERIFICATION_PROOF;
$addressProof 	= $this->Account_model->getVerificationInfo($userid,3);
$addVerifi      = $addressProof->VERIFICATION_PROOF;

if($panVerifi != ''){
  $panp = '<a onclick="return hs.expand(this)" class="highslide " href="'.base_url().'static/uploads/proof/'.$panVerifi.'"><img src="'.base_url().'static/images/drag.png" alt="" width="14" height="12" style="border:none;"/></a>';
}else{
  $panp = '-';
}

if($addVerifi != ''){
  $addp = '<a onclick="return hs.expand(this)" class="highslide " href="'.base_url().'static/uploads/proof/'.$addVerifi.'"><img src="'.base_url().'static/images/drag.png" alt="" width="14" height="12" style="border:none;"/></a>';
}else{
  $addp = '-';
}

//GET WITHDRAW TYPE AND WITHDRAW BY
$withInfo 		= $this->Withdrawal_model->getWithdrawInfo($hand_id);
$withInfoType   = $withInfo[0]->WITHDRAW_TYPE;
$withInfoBy     = $withInfo[0]->WITHDRAW_BY; 

if($withInfoBy == 'Cheque'){
  //get user information
  $userInfo 		= $this->Account_model->getUserInfoById($userid);
}else{
  //get user bank information
  $bankInfo 		= $this->Account_model->get_user_BankDetails($userid);
}  ?>
<script>
function ajaxSubmit(){
var xmlhttp;

   var bankname 	 = document.getElementById('bankname').value;
   var cheque_number = document.getElementById('cheque_number').value;
   var cheque_amount = document.getElementById('cheque_amount').value;
   var date 		 = document.getElementById('date').value;
   var account_number= document.getElementById('account_number').value;
   var courier_name  = document.getElementById('courier_name').value;
   var awb_no 		 = document.getElementById('awb_no').value;
   var charges 		 = document.getElementById('charges').value;

   var user_id 		 = document.getElementById('user_id').value;
   var type 		 = document.getElementById('type').value;
   var withdraw_id 	 = document.getElementById('withdraw_id').value;
   var reference_id  = document.getElementById('reference_id').value;
   
   
    var url='<?php echo base_url()."user/ajax/wthInfo"?>?bankname='+bankname+'&cname='+cheque_number+'&camount='+cheque_amount+'&date='+date+'&acn='+account_number+'&cname='+courier_name+'&awb='+awb_no+'&user_id='+user_id+'&type='+type+'&withdraw_id='+withdraw_id+'&reference_id='+reference_id+'&charges='+charges;    
   
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
}else{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
   	 location.reload();
  }
}
xmlhttp.open("GET",url,true);
xmlhttp.send();
return false;
}
</script>
<script>
function formSubmit(){
var xmlhttp;

   var trans_id 		= document.getElementById('trans_id').value;
   var amount 			= document.getElementById('amount').value;
   var acnt_number 		= document.getElementById('acnt_number').value;
   var user_acnt_number = document.getElementById('user_acnt_number').value;
   var ifsc_code		= document.getElementById('ifsc_code').value;
   var branch  			= document.getElementById('branch').value;
   var date 		 	= document.getElementById('date').value;

   var user_id 		 = document.getElementById('user_id').value;
   var type 		 = document.getElementById('type').value;
   var withdraw_id 	 = document.getElementById('withdraw_id').value;
   var reference_id  = document.getElementById('reference_id').value;
   
   
    var url='<?php echo base_url()."user/ajax/wthInfo"?>?trans_id='+trans_id+'&amount='+amount+'&acnt_number='+acnt_number+'&date='+date+'&user_acnt_number='+user_acnt_number+'&ifsc_code='+ifsc_code+'&branch='+branch+'&user_id='+user_id+'&type='+type+'&withdraw_id='+withdraw_id+'&reference_id='+reference_id;    
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
}else{// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
   	 location.reload();
  }
}
xmlhttp.open("GET",url,true);
xmlhttp.send();
return false;
}
</script>
<link href="<?php echo base_url(); ?>static/css/style.css" rel="stylesheet" type="text/css" />
<table width="100%" class="ContentHdr">
        <tbody><tr>
          <td>Withdraw Information:</td>
        </tr>
      </tbody></table>
<div class="table_card">
        	<div class="potamount" style="width:330px;">
                <div style="float: left;width: 255px;"><h3>User Name:</h3><span><?php echo $username; ?></span></div>
                <div style="float: left;width: 255px;"><h3>First Name:</h3><span><?php echo $firstname; ?></span></div>
                <div style="float: left;width: 255px;"><h3>Last Name:</h3><span><?php echo $lastname; ?></span></div>
                <div style="float: left;width: 255px;"><h3>Amount:</h3><span><?php echo $trans_amount; ?></span></div>
                <div style="float: left;width: 315px;"><h3>Hand ID:</h3><span><?php  echo $hand_id; ?></span></div>
                <div style="float: left;width: 255px;"><h3>Status:</h3><span><?php echo $description; ?></span></div>
                <div style="float: left;width: 255px;"><h3>Date:</h3><span><?php  echo $trans_date; ?></span></div>
            </div>    
            
            <div class="rake">
            	<div style="width:250px;float:left;"> <h3>PAN:</h3><span><?php echo $panp; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Address Proof:</h3><span><?php echo $addp; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Withdraw Type:</h3><span><?php echo $withInfoType; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Withdraw By:</h3><span><?php echo $withInfoBy; ?></span></div>
            
           </div>
           <?php if($withInfoBy == 'Cheque'){ ?>
           <div class="rake">
            	<div style="width:250px;float:left;"> <h3>Address Line1:</h3><span><?php echo $userInfo->ADDRESS; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Address Line 2:</h3><span><?php echo '-'; ?></span></div>
            	<div style="width:250px;float:left;"><h3>City:</h3><span><?php echo $userInfo->CITY; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Pincode:</h3><span><?php echo $userInfo->PINCODE; ?></span></div>
                <div style="width:250px;float:left;"><h3>State:</h3><span><?php echo $userInfo->STATE; ?></span></div>
                <div style="width:250px;float:left;"><h3>Country:</h3><span><?php echo $userInfo->COUNTRY; ?></span></div>
                <div style="width:250px;float:left;"><h3>Mobile :</h3><span><?php echo $userInfo->CONTACT; ?></span></div>
           </div>
           <?php }else{ ?>
            <div class="rake">
            	<div style="width:250px;float:left;"> <h3>Account Holder Name:</h3><span><?php echo $bankInfo->ACCOUNT_HOLDER_NAME; ?></span></div>
            	<div style="width:250px;float:left;"><h3>Accout number:</h3><span><?php echo $bankInfo->ACCOUNT_NUMBER; ?></span></div>
            	<div style="width:250px;float:left;"><h3>MICR Code:</h3><span><?php echo $bankInfo->MICR_CODE; ?></span></div>
            	<div style="width:250px;float:left;"><h3>IFSC Code:</h3><span><?php echo $bankInfo->IFSC_CODE; ?></span></div>
                <div style="width:250px;float:left;"><h3>Bank Name:</h3><span><?php echo $bankInfo->BANK_NAME; ?></span></div>
                <div style="width:250px;float:left;"><h3>Branch Name:</h3><span><?php echo $bankInfo->BRANCH_NAME; ?></span></div>
           </div>
           <?php } ?>
    	   
    	</div>
<?php
if($trans_status != 209){ //checking already the withdraw is paid or not
 if($withInfoBy == 'Cheque' && $trans_status == 208){ ?>
<table width="100%" bgcolor="#993366" cellspacing="0" cellpadding="0" class="searchWrap">
  <tbody><tr>
    <td><table width="100%" class="ContentHdr">
        <tbody><tr>
          <td>Bank Information</td>
        </tr>
      </tbody></table>
     <form id="gameForm" name="gameForm" method="post" novalidate="novalidate">
       <table width="100%" cellspacing="10" cellpadding="10">
        <tbody>
        
        <tr>
            <td width="40%"><span class="TextFieldHdr">Bank Name:</span><span class="mandatory">*</span><br>
            <label>
           <select tabindex="1" id="bankname" class="ListMenu" name="bankname">
              <option value="icici">ICICI</option>
              <option value="hdfc">HDFC</option>
              <option value="hsbc">HSBC</option>
            </select>
            </label></td>            
                  
          <td width="40%"><span class="TextFieldHdr">Cheque #:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="2" id="cheque_number" class="TextField" name="cheque_number">
            </label></td>
            
            <td width="40%"><span class="TextFieldHdr">Cheque Amount:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="3" id="cheque_amount" class="TextField" name="cheque_amount">
            </label></td>
        </tr>
        <tr>
           <td width="40%"><span class="TextFieldHdr">Cheque Date:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text"  id="date" class="TextField" name="date" value="">
            </label>
            <a onclick="NewCssCal('date','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a> 
            </td>
          
          <td width="40%"><span class="TextFieldHdr">Ac number:</span><span class="mandatory">*</span><br>
            <label>
             <select tabindex="5" id="account_number" class="ListMenu" name="account_number">
              <option value="">select</option>
            <?php  	$user_acnt_num = $this->Withdrawal_model->getUserAccountDetails($userid); 
					foreach($user_acnt_num as $value){ ?>             
					<option value="<?php echo $value->ACCOUNT_NUMBER ?>"><?php echo $value->ACCOUNT_NUMBER; ?></option>
					<?php } ?> 
            </select>
            </label></td>
            <td width="40%"><span class="TextFieldHdr">Courier Name:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="6" id="courier_name" class="TextField" name="courier_name">
            </label></td>
           
          
        </tr>
        <tr>
          <td width="40%"><span class="TextFieldHdr">AWB No:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="7" id="awb_no" class="TextField" name="awb_no">
            </label></td>
            <td width="40%"><span class="TextFieldHdr">Charges:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="8" id="charges" class="TextField" name="charges">
            </label></td>
        </tr>
        	<input id="type" type="hidden" value="Cheque" name="type">
        	<input id="user_id" type="hidden" value="<?php echo $userid; ?>" name="user_id">
        	<input id="withdraw_id" type="hidden" value="<?php echo $trans_id; ?>" name="withdraw_id">
        	<input id="reference_id" type="hidden" value="<?php echo $hand_id; ?>" name="reference_id">
        	<input type="hidden" value="creategame" name="task">
        <tr>
          <td><input type="submit" tabindex="16" value="Pay" name="Paid">
            &nbsp;
        </tr>
        <tr>
          <td width="40%"></td>
          <td width="40%">&nbsp;</td>
          <td width="40%">&nbsp;</td>
        </tr>
      </tbody></table>
     </form>
     </td></tr>
</tbody></table>
<?php }else{ 
if($trans_status == 208){ ?>
<table width="100%" bgcolor="#993366" cellspacing="0" cellpadding="0" class="searchWrap">
  <tbody><tr>
    <td><table width="100%" class="ContentHdr">
        <tbody><tr>
          <td>NEFT Information</td>
        </tr>
      </tbody></table>
     <form id="NeftInfo" name="NeftInfo" method="post" novalidate="novalidate">
       <table width="100%" cellspacing="10" cellpadding="10">
        <tbody><tr>
          <td width="40%"><span class="TextFieldHdr">Date:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="1" id="date" class="TextField" name="date">
            </label></td>
            <td width="40%"><span class="TextFieldHdr">Trans.ID:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="1" id="trans_id" class="TextField" name="trans_id">
            </label></td>
             <td width="40%"><span class="TextFieldHdr">Amount:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="1" id="amount" class="TextField" name="amount">
            </label></td>
          
        </tr>

        <tr>
            <td width="40%"><span class="TextFieldHdr">Account Number:</span><span class="mandatory">*</span><br>
            <label>
           <select tabindex="4" id="acnt_number" class="ListMenu" name="acnt_number">
              <option value="11024386356582">11024386356582</option>
            </select>
            </label></td>            
            
          <td width="40%"><span class="TextFieldHdr">User Account Number:</span><span class="mandatory">*</span><br>
            <label>
            <select tabindex="5" id="user_acnt_number" class="ListMenu" name="user_acnt_number">
            <option value="">select</option>
            <?php  	$user_acnt_num = $this->Withdrawal_model->getUserAccountDetails($userid); 
					foreach($user_acnt_num as $value){ ?>
					<option value="<?php echo $value->ACCOUNT_NUMBER ?>"><?php echo $value->ACCOUNT_NUMBER; ?></option>
					<?php } ?> 
            </select>
             </label></td>
          <td width="40%"><span class="TextFieldHdr">IFSC Code:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="1" id="ifsc_code" class="TextField" name="ifsc_code">
            </label></td>
            
            <td width="40%"><span class="TextFieldHdr">Branch:</span><span class="mandatory">*</span><br>
            <label>
            <input type="text" maxlength="50" tabindex="1" id="branch" class="TextField" name="branch">
            </label></td>
        </tr>
        	<input id="type" type="hidden" value="NEFT" name="type">
        	<input id="user_id" type="hidden" value="<?php echo $userid; ?>" name="user_id">
        	<input id="withdraw_id" type="hidden" value="<?php echo $trans_id; ?>" name="withdraw_id">
        	<input id="reference_id" type="hidden" value="<?php echo $hand_id; ?>" name="reference_id">
        	<input type="hidden" value="creategame" name="task">        
        <tr>
          <td><input type="submit" tabindex="16" value="Pay"  name="submit">
            &nbsp;
            <!--<input type="reset" tabindex="17" value="Reset" name="submit">--></td>
        </tr>
        <tr>
          <td width="40%"></td>
          <td width="40%">&nbsp;</td>
          <td width="40%">&nbsp;</td>
        </tr>
      </tbody></table>
     </form>
     </td></tr>
</tbody></table>
<?php }
}
}else{ 
$pay_trans_id = $this->uri->segment(5);
$paidInfo =  $this->Withdrawal_model->getWithdrawalPaidInfo($hand_id,$pay_trans_id);  
if($withInfoBy == 'Cheque'){  ?>
  <div class="container_searchgame">
    	<ul>
        	<li style="min-width:118px;"><h3 class="header_searchgame">Date</h3></li>
            <li style="min-width:172px;"><h3 class="header_searchgame">Trans.ID</h3></li>
            <li style="min-width:118px;"><h3 class="header_searchgame">Amount</h3></li>
            <li style="min-width:80px;"><h3 class="header_searchgame">Account Number</h3></li>
            <li style="min-width:119px;"><h3 class="header_searchgame">Cheque No</h3></li>
            <li style="min-width:122px;"><h3 class="header_searchgame">AWB No</h3></li>
            <li style="min-width:100px;"><h3 class="header_searchgame">Bank Name</h3></li>
        </ul>
   		<ul class="cnt_userdetails">
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                    <p class="usrname"><?php echo date('d/m/Y', strtotime($paidInfo[0]->DATE)); ?></p>
                </div>
             </li>
             <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->INTERNAL_REFERENCE_NO; ?></p>
                </div>
             </li>
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->CHEQUE_AMOUNT; ?></p>
                </div>
            </li>
            <li style="min-width:165px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->COMP_ACCOUNT_NO; ?></p>
                </div>
            </li>
            <li style="min-width:130px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->CHEQUE_NO; ?></p>
                </div>
            </li>
            <li style="min-width:118px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->AWB_NO; ?></p>
                </div>
            </li>
            <li style="min-width:133px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->BANK_NAME; ?></p>
                </div>
            </li>
           </ul>
        </div>
<?php }else{ ?>
  <div class="container_searchgame">
    	<ul>
        	<li style="min-width:120px;"><h3 class="header_searchgame">Date</h3></li>
            <li style="min-width:172px;"><h3 class="header_searchgame">Trans.ID</h3></li>
            <li style="min-width:118px;"><h3 class="header_searchgame">Amount</h3></li>
            <li style="min-width:80px;"><h3 class="header_searchgame">Account Number</h3></li>
            <li style="min-width:119px;"><h3 class="header_searchgame">User AC</h3></li>
            <li style="min-width:80px;"><h3 class="header_searchgame">IFSC Code</h3></li>
            <li style="min-width:118px;"><h3 class="header_searchgame">Branch</h3></li>
        </ul>
   		<ul class="cnt_userdetails">
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                    <p class="usrname"><?php echo date('d/m/Y', strtotime($paidInfo[0]->DATE)); ?></p>
                </div>
             </li>
             <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->INTERNAL_REFERENCE_NO; ?></p>
                </div>
             </li>
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->CHEQUE_AMOUNT; ?></p>
                </div>
            </li>
            <li style="min-width:165px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->COMP_ACCOUNT_NO; ?></p>
                </div>
            </li>
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->USER_ACCOUNT_NO; ?></p>
                </div>
            </li>
            <li style="min-width:126px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->IFSC_CODE; ?></p>
                </div>
            </li>
            <li style="min-width:80px;">
                <div class="searchgame_cardcnt">
                	<p class="usrname"><?php echo $paidInfo[0]->BRANCH; ?></p>
                </div>
            </li>
           </ul>
        </div>
<?php }  
} ?>