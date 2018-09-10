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
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?><br/><br/><br/><br/> <?php } ?>             
	
            <form method="post" name="tsearchform" id="tsearchform"  onsubmit="return chkdatevalue();">  
            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
          <table width="100%" class="ContentHdr">
      <tr>
        <td><strong>Campaign Search</strong></td>
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
                  </select>
                </label>
              </td>
              <td width="40%"><span class="TextFieldHdr">Campaign Status:</span><br />
                <label>
                  <select name="select2" class="ListMenu" id="select2">
                  <option selected="selected">Select Status</option>
                  <option>ACTIVE</option>
                  <option>INACTIVE</option>
                  </select>
                </label>
              </td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr>
        <td width="40%"><span class="TextFieldHdr">Campaign Code:</span><br />
          <label>
          <input type="text" name="CampaignCode" id="CampaignCode" class="TextField" value="" >
          </label></td>
        <td width="40%"><span class="TextFieldHdr">Campaign Name:</span><br />
          <label>
          <input type="text" name="CampaignName" id="CampaignName" class="TextField" value="" >
          </label></td>        
      </tr>
      
      <tr>
        <td width="40%"><span class="TextFieldHdr">From:</span><br />
          <label>
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="">
          </label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">To:</span><br />
          <label>
          <input type="text"  id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="">
          </label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
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
                <?php 
	if(isset($arrs) && $arrs!=''){ ?>
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
					colNames:['Campaign Code','Campaign Name','Start Date','End Date','No.of clicks','Reg.user','Campaign Status','','',''],
                    colModel:[
                        {name:'CAMPAIGNCODE',index:'CAMPAIGNCODE', align:"center", width:20, sorttype:"int"},
						{name:'CAMPAIGNNAME',index:'CAMPAIGNNAME', align:"center", width:60},
						{name:'STARTDATE',index:'STARTDATE', align:"center", width:100},
						{name:'ENDDATE',index:'ENDDATE', align:"center", width:60},
						{name:'NO.OFCLICKS',index:'NO.OFCLICKS', align:"center", width:60},
						{name:'REG.USER',index:'REG.USER', align:"center", width:40},
						{name:'CAMPAIGNSTATUS',index:'CAMPAIGNSTATUS', align:"center", width:80},
						{name:'STATUS',index:'STATUS', align:"center", width:50},
						{name:'EDIT',index:'EDIT', align:"center", width:20},
                        {name:'DELETE',index:'DELETE', width:20, align:"center"},
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
    <?php }else{ ?>
	<div class="tableListWrap">
      <div class="data-list">
        <table id="list4" class="data">
          <tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no users found in this search criteria.</b></span></td>
          </tr>
        </table>
      </div>
    </div>
	<?php } ?>
</div>
 </div>
</div>
</div>
<?php echo $this->load->view("common/footer"); ?>