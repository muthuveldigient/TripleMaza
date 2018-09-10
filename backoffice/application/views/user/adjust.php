<script language="javascript">
function transferValiate(){
	 var user_id 	=  document.getElementById("USER_ID").value;
  	 var bal_type 	=  document.getElementById("BALANCE_TYPE").value;
	 var adj_type 	=  document.getElementById("ADJUST_TYPE").value;
	 var cash 		=  document.getElementById("CASH").value;
	 var comments 	=  document.getElementById("COMMENTS").value;
	if(user_id=='' && bal_type=='' && adj_type=='' && cash==''){
	 alert("Mandatory Fields are required...");
	 return false;
	}
	if(user_id == ''){
  		alert("Username is required.")
		return false;  
  	}else if(bal_type == ''){
   		 alert("Balance type is required.")
		return false;  
  	}else if(adj_type == ''){
   		 alert("Adjust type is required.")
		return false;  
  	}else if(cash == ''){
   		 alert("Cash is required.")
		return false;  
  	}/*else if(comments == ''){
   		 alert("Comment Must Be Required !!!.")
		return false;  
  	}*/
	 //var userLoggedStatus = document.getElementById("userLoggedInStatus").innerHTML;
	/*	THIS IS TO VALIDATE THE IN-SUFFICIENT BALANCE IN THE USER ACCOUNT */
	if(adj_type=="Remove") {
		var balTypeValue;
		if(bal_type==1)
			balTypeValue = document.getElementById('deposit_balance').innerHTML;
		if(bal_type==2)
			balTypeValue = document.getElementById('promo_balance').innerHTML; //promo balace
		if(bal_type==3)
			balTypeValue = document.getElementById('win_balance').innerHTML; //deposit balace
		if(userLoggedStatus==1) {
			var newurl = "<?php echo base_url().'user/account/adjust?err=7&rid=13'?>";
			window.location= newurl;	
			return false;		
		}
		if(parseInt(cash) > parseInt(balTypeValue)) {
			var newurl = "<?php echo base_url().'user/account/adjust?err=3&rid=13'?>";
			window.location= newurl;	
			return false;
		} else {
			document.regForm[0].submit();	
		}
	}
	/*	THIS IS TO VALIDATE THE IN-SUFFICIENT BALANCE IN THE USER ACCOUNT */	
}

function checkNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
   	return false;
	
   return true;
}


function showuserbalance()
{

        /*if(trim(document.getElementById('USER_ID').value)==''){
            alert("Please enter the username");
            document.getElementById('TO').focus();
            return false;
        }*/
        var ptid=document.getElementById('USER_ID').value;
        xmlHttp=GetXmlHttpObject()
        
        var url='<?php echo base_url();?>user/ajax/balanceadjust';    
        
	url=url+"?ptid="+ptid;	
        
	xmlHttp.onreadystatechange=Showbal
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	return false;
} 
function Showbal() 
{
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    { 		
            var result=xmlHttp.responseText;
            var disptext='';
            if(trim(result)=='Usernotexist'){
                disptext='<br>User does not exists.';
            }else{
                disptext=result;
            }
            document.getElementById("usercbal").innerHTML=disptext;    
    }else{
        document.getElementById("usercbal").innerHTML='<img src="images/loading2.gif">';
    }

} 
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
	<div class="content_wrap">
    <div class="tableListWrap">  
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>          
        <form name="regForm" id="regForm" method="POST" action="" onsubmit="return transferValiate();">
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Adjust Points</strong>
              </td>
          </tr>
        </table>
        <?php if($_GET['err']==1){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Adjusted Successfully.</div></td>
            </tr>
          </table>
        </div>
        <?php } ?>   
          
        <?php if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="ErrorMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
              <td width="95%">
			 
			  <?PHP if($_GET['err']==2) { ?>Cash Must Be Greater Than Zero!!<?PHP }  ?>
			  <?PHP if($_GET['err']==3) { ?>Insufficient balance in the user account.<?PHP }  ?>
			  <?PHP if($_GET['err']==4) { ?>Something went wrong... Please try again.<?PHP }  ?>
               <?PHP if($_GET['err']==5) { ?>Special characters are not allowed in cash.<?PHP }  ?>
               <?PHP if($_GET['err']==7) { ?>you can not remove points for the logged in user.<?PHP }  ?>
              </td>
            </tr>
          </table>
        </div>
        <?php } ?>
        
        <?PHP
		 if($this->uri->segment(4) != ''){
			 $username  = $this->Account_model->getUserNameById(base64_decode($this->uri->segment(4)));
		 }else{
		   $username  = '';
		 }
		
		?>
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr">Select User<span class="mandatory">*</span>:</span><br />
                    <label>
              		 <input id="USER_ID" name="USER_ID" maxlength="25" value="<?php if($username !='') echo $username;  ?>" type="text" class="TextField" onblur="showuserbalance();" >	
                   <!-- <select id="USER_ID" name="USER_ID" onchange='showuserbalance();' class="TextField">
                      <option value="">Select User</option>
                      <?php foreach($users as $user){ ?>
					      <option <?php if(base64_decode($this->uri->segment(4)) == $user->USER_ID) echo 'selected="selected"'; ?>  value="<?php echo $user->USER_ID; ?>"><?php echo $user->USERNAME; ?></option>
					   <?php } ?>
                    </select>-->
                    </label>
                    <br />
                    <div class="UDFieldTxtFld" id="usercbal">
                    <?php
					  if($username !=''){
					    //get user balance
						$userid = $this->Account_model->getUserIdByName($username);
						$userpoints = $this->Account_model->getUserPoints($userid);
						
						$depositPoint = $userpoints->USER_DEPOSIT_BALANCE;
						$promoPoint   = $userpoints->USER_PROMO_BALANCE;
						$winPoint     = $userpoints->USER_WIN_BALANCE;
						$totPoint     = $userpoints->USER_TOT_BALANCE;					?>
                    <div class="tableListWrap"><div class="data-list"><table class="data" style="width:88%" id="list4"><tbody><tr><td><div style=""><span style="style1"><b>Promo Balance:</b></span><span id="promo_Balance"><?php echo $promoPoint ?></span><br><b>Deposit Balance:</b><span id="deposit_balance"><?php echo $depositPoint ?></span><br><b>Win Balance:</b><span id="win_balance"><?php echo $winPoint ?></span><br><b>Total Balance:</b><?php echo $totPoint ?><br><span style1""="" style=""><b>Partner:</b></span>Admin<br></div></td></tr></tbody></table></div></div>
                    <?php } ?>
                    </div>
                    
                    </td>
                  <td width="40%" valign="top"><span class="TextFieldHdr">Balance Type<span class="mandatory">*</span>:</span><br />
                    <label>
                     <select id="BALANCE_TYPE" name="BALANCE_TYPE" class="TextField">
                      <option value="">Select Type</option>
                      <?php foreach($balanceTypes as $type){ ?>
                       <option value="<?php echo $type->BALANCE_TYPE_ID; ?>"> <?php echo ucfirst($type->BALANCE_TYPE); ?> </OPTION> 
                      <?php } ?>
                    </select>
                    </label></td>
                  <td width="40%" valign="top"><span class="TextFieldHdr">Adjust Type<span class="mandatory">*</span>:</span><br />
                    <label>
                     <select id="ADJUST_TYPE" name="ADJUST_TYPE" class="TextField">
                     <option value="">Select</option>
                    <option value="Add">Add</option>
                    <option value="Remove">Remove</option>
                    </select>
                    </label></td>
             
                </tr>
             <tr>
                <td width="40%" valign="top"><span class="TextFieldHdr">Amount<span class="mandatory">*</span>:</span><br />
                    <label>
                    <input id="CASH" name="CASH" type="text" maxlength="10" class="TextField" onkeypress="return checkNumberKey(event)">
                	   </label></td>
                 <td width="40%"><span class="TextFieldHdr">Comments:</span><br />
                <label>
                <textarea id="COMMENTS" class="TextField" maxlength="15" style="resize:none;" name="COMMENTS"></textarea>
                </label></td>
             </tr>
             <tr>
               <td width="33%"><table>
                 <tr>
                    <td><input name="submit" type="submit" id="Submit"  value="Adjust" style="float:left;"  /></form></td>
                    <td><form action="<?php echo base_url();?>user/account/adjust?rid=13" method="post" name="clrform" id="clrform">
                        <input class="reset" type="submit" id="reset" value="Reset" />
                        </form></td>
                    <td>&nbsp;</td>
                 </tr>
               </table></td>
               <td width="33%">&nbsp;</td>
               <td width="33%">&nbsp;</td>
             </tr>
              </table>
          </tr>
        </table>
        </form>
	</div>
  </div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>