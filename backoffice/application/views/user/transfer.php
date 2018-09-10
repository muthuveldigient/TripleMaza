<script language="javascript">
function showuserbalance()
{
        if(trim(document.getElementById('TO').value)==''){
            alert("Please enter the username");
            document.getElementById('TO').focus();
            return false;
        }
        var ptid=document.getElementById('TO').value;
        xmlHttp=GetXmlHttpObject()
        
        var url='<?php echo base_url();?>user/ajax/balance';    
        
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
                disptext='<br>User not exists.';
            }else{
                disptext=result;
            }
            document.getElementById("usercbal").innerHTML=disptext;    
    }else{
        document.getElementById("usercbal").innerHTML='<img src="images/loading2.gif">';
    }

} 

function transferValiate(){
	 var tod_id =  document.getElementById("TO").value;
  	 var points =  document.getElementById("POINTS").value;
	 
	 if(tod_id == ''){
  		alert("To Field Must Be Required!!!.")
		return false;  
  	}else if(points == ''){
   		 alert("Points Field Must Be Required !!!.")
		return false;  
  }
}


</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
	<div class="content_wrap">
        <form name="regForm" id="regForm" method="POST" action="" onsubmit="return transferValiate();">
        <table width="100%" class="PageHdr">
          <tr>
            <td><strong>Transfer Points</strong>
              </td>
          </tr>
        </table>
        <?php if($_GET['err']==1){ ?>
        <div class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%">Transfered Successfully !!!</td>
            </tr>
          </table>
        </div>
        <?php } ?>
        <?php if(isset($_REQUEST['err']) && $_REQUEST['err']!="1"){ 
             echo $this->common_model->errorHandling($_REQUEST['err']); } ?>
        
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr">To:</span><br />
                    <label>
                    <input name="TO" type="text" class="TextField" id="TO" onchange='showuserbalance();' tabindex="1" maxlength="15" value="" />
                    <span class="mandatory">*</span></label></td>
                  <td width="40%"><span class="TextFieldHdr">Points:</span><br />
                    <label>
                    <input name="POINTS" type="text" class="TextField" id="POINTS" tabindex="2" maxlength="15" value="" />
                    <span class="mandatory">*</span></label></td>
             
                </tr>
                <tr>
                <td><div class="UDFieldTxtFld" id="usercbal"></div></td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td><input type="submit" name="Submit" id="Submit"  value="Create" tabindex="6"  />
                    &nbsp;
                    <input type="reset" class="button" value="Reset" /></td>
                </tr>
              </table>
          </tr>
        </table>
        </form>
	</div>
  </div>
</div>
<?php $this->load->view("common/footer"); ?>