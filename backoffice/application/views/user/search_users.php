<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<script type="text/javascript">
/*hs.graphicsDir = 'images/';
hs.wrapperClassName = 'wide-border';*/

function closeDiv()
{
	document.getElementById('saved_desc').innerHTML = '';	
	document.getElementById('desc_status').value = '';
	Popup.hide('user_status_desc');
}

function Datecompare()
{
   var objFromDate = document.getElementById("START_DATE_TIME").value; 
   var objToDate = document.getElementById("END_DATE_TIME").value;
   var FromDate = new Date(objFromDate);
   var ToDate = new Date(objToDate);
   var valCurDate = new Date();
   valCurDate =  valCurDate.getYear()+ "-" +valCurDate.getMonth()+1 + "-" + valCurDate.getDate();
   var CurDate = new Date(valCurDate);
   
   if(FromDate > ToDate)
   {
    alert(fromname + " should be less than " + toname);
     return false; 
   }
   else if(FromDate > CurDate)
   {
     alert("From date should be less than current date");
     return false; 
   }
    else if(ToDate > CurDate)
    {
      alert("To date should be less than current date");
      return false;
    }

}


function showdistagents()
{
    
        xmlHttp=GetXmlHttpObject()
        var url='<?php echo base_url();?>index.php/ajax_showdistagents';    
	
	xmlHttp.onreadystatechange=Listdistagent
	xmlHttp.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp.send(null);
    //loader(0);
       
	return false;
    
}

function Listdistagent(){
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    { 		
            var result=xmlHttp.responseText;
            var dispdist='<div class="UDFieldtitle">Affiliate:</div><div class="UDFieldTxtFld">'+result+'</div>';
            document.getElementById("affiliatesection").innerHTML=dispdist;    
    }
}

function showagentusers()
{
        xmlHttp=GetXmlHttpObject()
        var url='<?php echo base_url();?>index.php/ajax_showagentlist';    
	
	xmlHttp.onreadystatechange=Listagent
	xmlHttp.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp.send(null);
    //loader(0);
       
	return false;
    
}

function Listagent()
{
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    { 		
            var result=xmlHttp.responseText;
            var dispagnt='<div class="UDFieldtitle">Affiliate:</div><div class="UDFieldTxtFld">'+result+'</div>';
            document.getElementById("affiliatesection").innerHTML=dispagnt;    
    }
}

function Hidedist()
{
 
            document.getElementById("affiliatesection").innerHTML='';    
    
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
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>'+' 00:00:00';
              edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
          }
          if(vid=="3"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?>'+' 00:00:00';
              edate='<?php echo $slastweekeday;?>'+' 23:59:59';
          }
          if(vid=="4"){
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
          if(vid=="5"){
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
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<?php //echo $rdoSearch; ?>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
	<div class="content_wrap">
            <?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="1"){ ?>
            <div class="UpdateMsgWrap">
              <table width="100%" class="ErrorMsg">
                <tr>
                  <td width="45"><img src="<?php echo base_url();?>images/icon-error.png" alt="" width="45" height="34" /></td>
                  <td width="95%"><?php echo "Transaction Password is incorrect.";?></td>
                </tr>
              </table>
            </div>
          <?php } ?>  
            <?php if(isset($_GET['errmsg']) && $_GET['errmsg']=="404"){ ?>
            <div class="UpdateMsgWrap">
              <table width="100%" class="ErrorMsg">
                <tr>
                  <td width="45"><img src="<?php echo base_url();?>images/icon-error.png" alt="" width="45" height="34" /></td>
                  <td width="95%"><?php echo "Invalid Transaction Password !!!";?></td>
                </tr>
              </table>
            </div>
          <?php } ?>             
            
		
            <form method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">  
            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
          <table width="100%" class="ContentHdr">
      <tr>
        <td><strong>Search User</strong></td>
        </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
      <tr>
        <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
          <label>
          <input type="text" name="userName" id="userName" class="TextField" value="<?PHP if(isset($_REQUEST['userName'])) echo $_REQUEST['userName']; ?>" >
          </label></td>
        <td width="40%"><span class="TextFieldHdr">Mac Address:</span><br />
           <label>
          <input type="text" name="macAddress" id="macAddress" class="TextField" value="<?PHP if(isset($_REQUEST['macAddress'])) echo $_REQUEST['macAddress']; ?>" >
          </label></td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr>
          <?php
            if($this->session->userdata('isownpartner')=="1" || $this->session->userdata('isdistributor')=="1"){ 
          ?>
          <td width="40%"><span class="TextFieldHdr">Search BY:</span><br />
                    <label>
			
					<input type="radio"  name="rdoSearch" id="rdoSearch_a" value="player" <?php if($rdoSearch=="player"){ echo "checked";}?> onclick="showagentusers()"  checked>&nbsp;User
                                       <?php if($this->session->userdata('isdistributor')!="1"){ ?>
                                        <input type="radio"  name="rdoSearch" id="rdoSearch_d" value="distributor" <?php if($rdoSearch=="distributor"){ echo "checked";}?> onclick="javascript:Hidedist();" >&nbsp;Distributors
                                        <?php } ?>
                                        <input type="radio"  name="rdoSearch" id="rdoSearch_a" value="agent" <?php if($rdoSearch=="agent"){ echo "checked";}?> onclick="showdistagents()"  >&nbsp;Agents
                   
                        <input type="hidden" name="partner_selection" id="partner_selection" value="<?php if($rdoSearch=='agent'){ if(isset($_REQUEST['partner_selection']) && $_REQUEST['partner_selection']){ echo $_REQUEST['partner_selection']; }else{ if($this->session->userdata('isdistributor')=="1" || $this->session->userdata('isownpartner')=="1"){echo $this->session->userdata('partnerid');}} }?>">
          </label></td>              
                   <?php }else{ ?>
                            <input type="hidden"  name="rdoSearch"  value="player">
                   <?php } ?>
        <?php
                                if(($rdoSearch=='player' || $rdoSearch=='')  && ($this->session->userdata('isownpartner')=="1" || $this->session->userdata('isdistributor')=="1")){ 
                                    ?>
               <td width="40%"><span class="TextFieldHdr">Affiliate:</span><br />
          <label>
          <?php
                                        $CI =& get_instance();
                                        $CI->load->library('showagentlist');
                                        echo $CI->showagentlist->index();
                                        ?>
          </label></td>
                                    
                                <?php
                                }
                                ?> 
        <td width="20%">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="40%"><span class="TextFieldHdr">From:</span><br />
          <label>
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) echo $_REQUEST['START_DATE_TIME']; ?>">
          </label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">To:</span><br />
          <label>
          <input type="text"  id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) echo $_REQUEST['END_DATE_TIME']; ?>">
          </label><img src="<?php echo base_url(); ?>images/calendar.png" /></td>
        <td width="20%"><span class="TextFieldHdr"></span><br />
            <label><select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                            <option value="">Select</option>
                            <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                            <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>This Week</option>
                            <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>Last Week</option>
                            <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>This Month</option>
                            <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>Last Month</option>
                        </select></label>
         </td>
      </tr>
       

      <tr>
        <td width="33%">
              <table>
              <tr>
                <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
                </form> </td>
                <td>
                    <form action="<?php echo base_url();?>admin_home" method="post" name="clrform" id="clrform">   
                        <input name="reset" type="submit"  id="reset" value="Clear"  />
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
<?php echo $this->load->view("common/footer"); ?>