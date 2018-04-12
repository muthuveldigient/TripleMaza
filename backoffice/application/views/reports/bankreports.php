<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />

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


</script>
<style>
.PageHdr{
  width: 94.9%;
}
</style>
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
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>NU Bank</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/bank?rid=43" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) {echo $_REQUEST['START_DATE_TIME'];}else{ echo date("d-m-Y 00:00:00");} ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) {echo $_REQUEST['END_DATE_TIME'];}else{ echo date("d-m-Y 23:59:59");} ?>">
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
        <td><form action="<?php echo base_url();?>reports/bank?rid=43" method="post" name="clrform" id="clrform">
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
        //echo "<pre>";print_r($bank);die;
       if(isset($bank) && $bank!=''){ 
                $resvalue[0]['TITLE']   = "Registration";
		if($bank['regpoints'][0]->tot == ""){	
                    $resvalue[0]['POINTS']   = "0.00";
                }else{
                    $resvalue[0]['POINTS'] = $bank['regpoints'][0]->tot;
                } 
                if($bank['regchips'][0]->tot == ""){
                    $resvalue[0]['CHIPS'] = "0.00";
                }else{
                    $resvalue[0]['CHIPS'] = $bank['regchips'][0]->tot;
                }
                
                $resvalue[1]['TITLE']   = "Login";
                if($bank['loginpoints'][0]->tot == ""){
                    $resvalue[1]['POINTS'] = "0.00";
                }else{
                    $resvalue[1]['POINTS'] = $bank['loginpoints'][0]->tot;
                }
                if($bank['loginchips'][0]->tot == ""){ 
                    $resvalue[1]['CHIPS'] = "0.00";
                }else{
                    $resvalue[1]['CHIPS']  = $bank['loginchips'][0]->tot;
                }
                
                $resvalue[2]['TITLE']   = "VIP";
                if($bank['vippoints'][0]->tot == ""){
                    $resvalue[2]['POINTS'] = "0.00";
                }else{
                    $resvalue[2]['POINTS'] = $bank['vippoints'][0]->tot;
                }
                if($bank['vipchips'][0]->tot == ""){ 
                    $resvalue[2]['CHIPS'] = "0.00";
                }else{
                    $resvalue[2]['CHIPS']  = $bank['vipchips'][0]->tot;
                }
                
                $resvalue[3]['TITLE']   = "Odd N Even";
		if($bank['oddnevenpoints'][0]->tot == ""){	
                    $resvalue[3]['POINTS']   = "0.00";
                }else{
                    $resvalue[3]['POINTS'] = $bank['oddnevenpoints'][0]->tot;
                } 
                if($bank['oddnevenchips'][3]->tot == ""){
                    $resvalue[3]['CHIPS'] = "0.00";
                }else{
                    $resvalue[3]['CHIPS'] = $bank['oddnevenchips'][0]->tot;
                }
                
                $resvalue[4]['TITLE']   = "Lucky Number";
		if($bank['luckynumberpoints'][0]->tot == ""){	
                    $resvalue[4]['POINTS']   = "0.00";
                }else{
                    $resvalue[4]['POINTS'] = $bank['luckynumberpoints'][0]->tot;
                } 
                if($bank['luckynumberchips'][4]->tot == ""){
                    $resvalue[4]['CHIPS'] = "0.00";
                }else{
                    $resvalue[4]['CHIPS'] = $bank['luckynumberchips'][0]->tot;
                }
                
                $resvalue[5]['TITLE']   = "Luck";
		if($bank['luckpoints'][0]->tot == ""){	
                    $resvalue[5]['POINTS']   = "0.00";
                }else{
                    $resvalue[5]['POINTS'] = $bank['luckpoints'][0]->tot;
                } 
                if($bank['luckchips'][5]->tot == ""){
                    $resvalue[5]['CHIPS'] = "0.00";
                }else{
                    $resvalue[5]['CHIPS'] = $bank['luckchips'][0]->tot;
                }
	//echo "<pre>";print_r($resvalue);die;			
                       ?>
        <?php 
	//if(isset($resvalue) && $resvalue!=''){ 
       $TotPoints =  $resvalue[0]['POINTS'] + $resvalue[1]['POINTS'] + $resvalue[2]['POINTS'] + $resvalue[3]['POINTS'] + $resvalue[4]['POINTS'] + $resvalue[5]['POINTS'] ;
       $TotChips =  $resvalue[0]['CHIPS'] + $resvalue[1]['CHIPS'] + $resvalue[2]['CHIPS'] + $resvalue[3]['CHIPS'] + $resvalue[4]['CHIPS'] + $resvalue[5]['CHIPS'] ;      
            
            ?>
  
        <div class="tableListWrap">
         <!-- <div class="PageHdr"><b>Points & Chips</b></div>-->
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4" class="data">
              <tr>
                <td></td>
              </tr>
            </table>
            <div id="pager3"></div>
<STYLE>
  .cvteste {
            background-color: #8CD9FD !important;
           }
</STYLE>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
            <!--<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>-->
            <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['#','Points','Chips'],
                    colModel:[
                                        {name:'TITLE',index:'TITLE', align:'center', classes: 'cvteste', width:40,sortable:false},
                                        {name:'POINTS',index:'POINTS', align:"right", width:40},
					{name:'CHIPS',index:'CHIPS', align:"right", width:40}
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 499, height: "100%",
                    jsonReader: {
                        repeatitems : false
                    }
                   // caption: "Group Header"
                });
                  /*  jQuery("#list4").jqGrid('setGroupHeaders', {
                  useColSpanStyle: true, 
                  groupHeaders:[
                        {startColumnName: 'REGPOINTS', numberOfColumns: 3, titleText: '<center><font color="red">Points</font></center>'},
                        {startColumnName: 'REGCHIPS', numberOfColumns: 3, titleText: '<center><font color="red">Chips</font></center>'}
                  ]	
                });*/
                var mydata = <?php echo json_encode($resvalue);?>;

                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
					
					
					
                </script>
             <div class="Agent_total_Wrap1" style="width:499px;">
                <div class="Agent_TotalShdr" style="width:158px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:154px"><div align="right"><?php echo number_format($TotPoints, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:154px"><div align="right"><?php echo number_format($TotChips, 2, '.', '');?></div></div>
             </div>                
            
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
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>