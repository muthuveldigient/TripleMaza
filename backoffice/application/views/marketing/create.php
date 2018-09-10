<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script language="javascript">
function generate(CAMPAIGNCODE)
{
      var CAMPAIGNCODE =  document.getElementById("CAMPAIGNCODE").value;
      var select1 =  document.getElementById("select1").value;
      if(select1 == 'Select Campaign Type'){
  	alert("Select Campaign Type !!!.")
	return false;  
      }else{
    xmlHttp3=GetXmlHttpObject()
    var url='<?php echo base_url()."marketing/ajax/generateCode"?>';    
	url=url+"?camtype="+select1;
 	xmlHttp3.onreadystatechange=Showdis
	xmlHttp3.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp3.send(null);
      }
}
function Showdis() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    { 		//alert ("Hi");
            var result=xmlHttp3.responseText;
           document.getElementById("CAMPAIGNCODE").value=trim(result);
    }
} 


function generateurl(GETURL)
{
    var CAMPAIGNCODE =  document.getElementById("CAMPAIGNCODE").value;
    var select1 =  document.getElementById("select1").value;
    var select2 =  document.getElementById("select2").value;
    var GETURL = document.getElementById("GETURL").value;
    if(CAMPAIGNCODE == ""){
        alert("Generate Campaign Code First !!!.")
        return false;
    }else if(select2 == 'Select Partner Name'){
         alert("Select Partner Name !!!.");
         return false;
    }else{
    xmlHttp3=GetXmlHttpObject()
    var url='<?php echo base_url()."marketing/ajax/generateUrl"?>'; 
    url=url+"?camcode="+CAMPAIGNCODE+"&select="+select1+"&partn="+select2;
    
    xmlHttp3.onreadystatechange=Showdisp
    xmlHttp3.open("GET",url,true);
    xmlHttp3.send(null);
    }
}
function Showdisp()
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
        {
            var result=xmlHttp3.responseText;
            //alert(result);
            document.getElementById("GETURL").value=trim(result);
        }
}

</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<?php //echo $rdoSearch; ?>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
	
            <form method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">  
            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
      <table width="100%" class="PageHdr">
        <tr>
          <td><strong>Campaign - Add Campaign</strong>
            <table width="50%" align="right">
              <tr>
                <td><table width="50%" align="right">
                    <tr>
                      <td><div align="right"><a class="dettxt" href="<?php echo base_url(); ?>-----/-----/-----">View Campaign</a></div></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Create</strong></td>
            </tr>
          </table>
        <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Campaign Type:</span><br />
                <label>
                  <select name="select1" class="ListMenu" id="select1">
                  <option selected="selected">Select Campaign Type</option>
                  <option>PAYMENT</option>
                  <option>REGISTRATION</option>
                  <option>TELL-A-FRIEND</option>
                  <option>PROMO-REGISTRATION</option>
                  </select><span class="mandatory">*</span>
                </label>
              </td>
              <td width="40%"><span class="TextFieldHdr">Partner Name:</span><br />
                <label>
                  <select name="select2" class="ListMenu" id="select2">
                  <option selected="selected">Select Partner Name</option>
                  <option>DIGIENT</option>
                  <option>FACEBOOK</option>
                  <option>OZONE</option>
                  <option>TESTPARTNER</option>
                  </select><span class="mandatory">*</span>
                </label>
              </td>
            </tr>
      <tr>
        <td width="40%"><span class="TextFieldHdr">Campaign Name:</span><br />
          <label>
          <input type="text" name="CAMPAIGNNAME" id="CAMPAIGNNAME" class="TextField" value="" >
          </label><span class="mandatory">*</span></td>
        <td width="40%"><span class="TextFieldHdr">Campaign Code:</span><br />
           <label>
          <input type="text" name="CAMPAIGNCODE" id="CAMPAIGNCODE" class="TextField" value="" >
          </label></td>
          <td>
              <input type="button" class="button" value="Generate" onclick="generate(this.value);"/>
          </td>
        <td width="20%">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="40%"><label>
          <input type="text" readonly="readonly" name="GETURL" id="GETURL" class="TextField" value="" >
          </label></td> 
          <td>
              <input type="button" class="button" value="Get Url" onclick="generateurl(this.value);"/>
          </td>
      </tr>
      
      <tr>
                 <td width="40%"><span class="TextFieldHdr">Campaign Description:</span><br />
                <label>
                <textarea id="CAMPAIGNDESCRIPTION" class="TextField" name="CAMPAIGNDESCRIPTION"></textarea>
                <span class="mandatory">*</span></label></td>              
          <td width="40%"><span class="TextFieldHdr">Status:</span><br />
                <label>
                  <select name="select3" class="ListMenu" id="select3">
                  <option selected="selected">Select Status</option>
                  <option>ACTIVE</option>
                  <option>INACTIVE</option>
                  </select><span class="mandatory">*</span>
                </label>
              </td>
      </tr>
      
      <tr>
        <td width="40%"><span class="TextFieldHdr">From:</span><br />
          <label>
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="">
          <span class="mandatory">*</span></label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">To:</span><br />
          <label>
          <input type="text"  id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="">
          <span class="mandatory">*</span></label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
      </tr>
    </table>
              
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Payment & Rule Settings</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                   <td width="40%"><span class="TextFieldHdr">Payment Type:</span><br />
                    <td width="40%"><span class="TextFieldHdr">Promo Type:</span><br />    
              </tr>
              <tr>
                <td width="40%"><span class="TextFieldHdr">Promo Min Value:</span><br />
                  <label>
                  <input name="PromoMinValue" type="text" class="TextField" id="PromoMinValue" />
                  <span class="mandatory">*</span></label></td>
               <td width="40%"><span class="TextFieldHdr">Promo Max Value:</span><br />
                  <label>
                  <input name="PromoMaxValue" type="text" class="TextField" id="PromoMaxValue" />
                  <span class="mandatory">*</span></label></td>            
              </tr>
              <tr>
                <td width="40%"><span class="TextFieldHdr">Promo Value 1:</span><br />
                  <label>
                  <input name="PromoValue1" type="text" class="TextField" id="PromoValue1" />
                  <span class="mandatory">*</span></label></td>
               <td width="40%"><span class="TextFieldHdr">Promo Value 2:<span style="color:#FF0000">(This value mandatory for First deposit Payment and tell-a-friend campaign type only)</span></span><br />
                  <label>
                  <input name="PromoValue2" type="text" class="TextField" id="PromoValue2" />
                  </label></td>            
              </tr>              
          </table>
              
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Cost & User Range</strong></td>
            </tr>
          </table> 
 
          <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Cost:</span><br />
                  <label>
                  <input name="Cost" type="text" class="TextField" id="Cost" />
                  <span class="mandatory">*</span></label></td>                  
                <td width="40%"><span class="TextFieldHdr">Expected User:</span><br />
                  <label>
                  <input name="ExpectedUser" type="text" class="TextField" id="ExpectedUser" />
                  <span class="mandatory">*</span></label></td>                  
              </tr>
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Cost Per User:</span><br />
                  <label>
                  <input name="CostPerUser" type="text" class="TextField" id="CostPerUser" />
                  </label></td>                  
              </tr>
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">Expected User Min:</span><br />
                  <label>
                  <input name="ExpectedUserMin" type="text" class="TextField" id="ExpectedUserMin" />
                  <span class="mandatory">*</span></label></td>
                <td width="40%"><span class="TextFieldHdr">Expected User Max:</span><br />
                  <label>
                  <input name="ExpectedUserMax" type="text" class="TextField" id="ExpectedUserMax" />
                  <span class="mandatory">*</span></label></td>                  
              </tr>
      <tr>
        <td width="33%">
              <table>
              <tr>
                <td><input name="keyword" type="submit"  id="button" value="Create" style="float:left;" />
                </form> </td>
                <td>
                    <form action="<?php echo base_url();?>-----" method="post" name="clrform" id="clrform">   
                        <input name="reset" type="submit"  id="reset" value="Reset"  />
                    </form>
                </td>
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
        </div>            
</div>		
</div>
</div>
<?php echo $this->load->view("common/footer"); ?>