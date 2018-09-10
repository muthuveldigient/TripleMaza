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

function Showsubagent(userid,status,position) 
{
   
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0)
    { 		
            var result=xmlHttp3.responseText;
			 if(status == 1){
      document.getElementById("active_"+position).innerHTML='<a onclick="activateUser(0,'+userid+','+position+')" ><img src="http://localhost/backoffice/static/images/status-locked.png" alt="Delete"></a> &nbsp;&nbsp;&nbsp;';    
   }else{
      document.getElementById("active_"+position).innerHTML='<a onclick="activateUser(1,'+userid+','+position+')" ><img src="http://localhost/backoffice/static/images/status.png" alt="Delete"></a> &nbsp;&nbsp;&nbsp;';    
   } 
	
	}

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
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
          <?php 
                //rint_r($partnerIds);
          //$fk = $this->Agent_model->getAllPartnerIdByParentId($this->session->userdata['partnerid']);
          //print_r($fk);
       ?>
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Game History</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/game/history?rid=21" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                    <label>
                  <input type="text" name="username" id="username" class="TextField" value="<?PHP if($this->uri->segment(4)){echo $this->uri->segment(4);}elseif(isset($username)){echo $username;} ?>" >
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Game:</span><br />
              
                  <label>
                    <select class="TextField" name="gameName">
                    <option value="">Select</option>
                     <?php foreach($games as $game){ ?>
                      <option value="<?php echo $game->MINIGAMES_ID; ?>"><?php echo $game->MINIGAMES_NAME; ?></option>
                      <?php } ?>
                      
                    </select>
                  </label></td>
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
                <td width="40%"><span class="TextFieldHdr">Partner Name:</span><br />
                  <label>
                  <?php	   $partnerL =  $this->Agent_model->getAllPartnerIdByParentId($this->session->userdata['partnerid']); 
                  $partnerList = explode(",",$partnerL); //print_r($partnerList); ?>
                  <select name="partner" id="partner" class="ListMenu">
                    <option value="select">Select</option>
                    <?php foreach($partnerList as $partner){ ?>
                    <option <?php if($this->session->userdata('gameHistorySearchData') == $partner) echo 'selected="selected"'; ?> value="<?php echo $partner; ?>"><?php echo $this->Agent_model->getPartnerNameById($partner); ?></option>
                    <?php } ?>
                  </select>
                  </label></td>  
                
                <td width="40%"><span class="TextFieldHdr">Hand Id:</span><br />
                  <label>
                    
                    <input type="text" name="hand_id" id="hand_id" class="TextField" value="<?PHP if(isset($hand_id)) echo $hand_id; ?>" >
                  </label></td>  
                <td width="20%">&nbsp;</td>                  
              </tr>
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) {echo $_REQUEST['START_DATE_TIME'];}elseif($_REQUEST['START_DATE_TIME'] == ""){ echo "";}else{ echo date("d-m-Y 00:00:00");} ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) {echo $_REQUEST['END_DATE_TIME'];}elseif($_REQUEST['END_DATE_TIME'] == ""){ echo "";}else{ echo date("d-m-Y 23:59:59");} ?>">
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
        <td><form action="<?php echo base_url();?>reports/game/history?rid=21" method="post" name="clrform" id="clrform">
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
        $page = $this->uri->segment(4);
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
		$username  = $this->Account_model->getUserNameById($results[$i]->USER_ID);
		$totalbets  = $results[$i]->totalbets;
		$totalwins  = $results[$i]->totalwins;
		$totalrefunds  = $results[$i]->totalrefunds;
		$resvalue['SNO']=$j+1;
		$resvalue['USERNAME']= '<a href="'.base_url().'reports/game/user/'.base64_encode($results[$i]->USER_ID).'?rid=21&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'">'.$username.'</a>';												
		$resvalue['PARTNER']= "Admin";
		$resvalue['PLAYPOINTS'] = $totalbets;
		$resvalue['WINPOINTS']	= $totalwins;
		$resvalue['REFUNDPOINTS']= $totalrefunds;
		$resvalue['ENDPOINTS'] = $totalbets-$totalwins-$totalrefunds;
		//$resvalue['ACTION'] = '<a href="'.base_url().'reports/game/user/'.base64_encode($results[$i]->USER_ID).'?rid=21"><img src="'.base_url().'/static/images/view.png"></a>';
											
                if($resvalue){
                     $arrs[] = $resvalue;
                }
                     $j++;}
                }else{
                     $arrs="";
                }
            }    ?>
        <?php 
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
    <b> Total Users: <font color="#FF3300">(<?php echo $tot_users; ?>) </font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Play Points: <font color="green">(<?php echo $totPlayPoint; ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Win Points: <font color="#FF3300">(<?php echo $totWinPoint; ?>)</font></b> &nbsp;&nbsp;&nbsp;
    <b> Total Refund Points: <font color="#FF3300">(<?php echo $totRefundPoint; ?>)</font></b>
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
					colNames:['S.No','Username','Partner','Total Bets','Total Wins','Refund Points','House Wins'],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:40},
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40},
						{name:'REFUNDPOINTS',index:'REFUNDPOINTS', align:"right", width:60},
						{name:'ENDPOINTS',index:'ENDPOINTS', align:"right", width:40},
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
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