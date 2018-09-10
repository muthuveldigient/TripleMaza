<?php // echo error_reporting(E_ALL); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script src ="<?php echo base_url(); ?>static/js/thickbox.js"  type="text/javascript" ></script>
<link href="<?php echo base_url(); ?>static/css/thickbox.css" rel="stylesheet" type="text/css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function NewWindow(mypage,myname,w,h,scroll){
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/4 : 0;
	var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage,myname,settings);
}
function showdaterange(vid){
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
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          document.getElementById("START_DATE_TIME").value=sdate;
          document.getElementById("END_DATE_TIME").value=edate;
      }
      
        
    }
function chkdatevalue(){
   if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false){
        alert("Please enter the valid date");
        return false;
    }else{
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
            <td><strong>Shan Game History</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>helpdesk/helpdesk/shanwallet?rid=61" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                  <label>
                  <?php
					if($_REQUEST["username"])
						$userName = $_REQUEST["username"];
					else
						$userName = "";
				  ?>
                  <input type="text" name="username" id="username" class="TextField" value="<?PHP echo $userName; ?>" >
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Game Reference No:</span><br />
                  <label>
                  <?php
					if($_REQUEST["ref_id"])
						$ref_id = $_REQUEST["ref_id"];
					else
						$ref_id = "";
				  ?>                  
                  <input type="text" name="ref_id" id="ref_id" class="TextField" value="<?PHP echo $ref_id; ?>" >
                  </label></td>
               <td width="20%">
			   <span class="TextFieldHdr">Play Group Id:</span><br />
                  <label>
                  <?php
					if($_REQUEST["playgroupid"])
						$playgroupid = $_REQUEST["playgroupid"];
					else
						$playgroupid = "";
				  ?>                  
                  <input type="text" name="playgroupid" id="playgroupid" maxlength="20" class="TextField" value="<?PHP echo $playgroupid; ?>" >
                  </label>			   
			   </td>
              </tr>
               
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST["START_DATE_TIME"])
						$START_DATE_TIME = $_REQUEST["START_DATE_TIME"];
					else
						$START_DATE_TIME = "";
				  ?>                   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; }else{ echo date("d-m-Y 00:00:00");} ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <?php
					if($_REQUEST["END_DATE_TIME"])
						$END_DATE_TIME = $_REQUEST["END_DATE_TIME"];
					else
						$END_DATE_TIME = "";
				  ?>                   
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }else{ echo date("d-m-Y 23:59:59");}?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <?php
					if($_REQUEST["SEARCH_LIMIT"])
						$SEARCH_LIMIT = $_REQUEST["SEARCH_LIMIT"];
					else
						$SEARCH_LIMIT = "";
				  ?>                  
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if($SEARCH_LIMIT=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if($SEARCH_LIMIT=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if($SEARCH_LIMIT=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if($SEARCH_LIMIT=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if($SEARCH_LIMIT=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if($SEARCH_LIMIT=="6"){ echo "selected";}?>>Last Month</option>
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
        <td><form action="<?php echo base_url();?>helpdesk/helpdesk/shanwallet?rid=61" method="post" name="clrform" id="clrform">
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
        
<?php   $page = $this->uri->segment(4);
	    if(isset($page) && $page !=''){
			$j=$page;
        }else{
            $j=0;
        }
		//echo "<pre>";print_r($results);die;
	    $resvalues=array();
        if(isset($results)){ 
        	if(count($results)>0 && is_array($results)){
            	for($i=0;$i<count($results);$i++){
				//get user name
					$user_id	  = $results[$i]->USER_ID;
					$username	  = $this->Account_model->getUserNameById($user_id);
					$ref_no		  = $results[$i]->GAME_REFERENCE_NO;
					if($results[$i]->RAKE)
						$rake 	  = $results[$i]->RAKE; 						
					else
						$rake 	  = '-';   

					$gameId 	  = $results[$i]->GAME_ID;
					$playGroupId  = $results[$i]->PLAY_GROUP_ID;
					$opening_bal  = $results[$i]->OPENING_TOT_BALANCE;												
					$closing      = $results[$i]->CLOSING_TOT_BALANCE;
					$date         = date("d/m/Y h:i:s",strtotime($results[$i]->TRANSACTION_DATE));
					$bet 		  = $results[$i]->BET_POINTS;
					$win 		  = $results[$i]->WIN_POINTS;
					$loss 		  = $results[$i]->LOSS;
					$forcedbet 	  = $results[$i]->FORCED_BET;

					$resvalue['SNO']		=$j+1;
					$resvalue['USERNAME']	= $username;	
					$resvalue['REF_NO'] 	= $ref_no;
					$resvalue['PLAY_GROUP_ID'] = '<a href="#" onclick="NewWindow(\''.base_url().'games/shan/gamedetails/details/'.$ref_no.'/'.$gameId.'?rid=45\',\'Game Details\',\'1140\',\'600\',\'yes\')">'.$playGroupId.'</a>'; 
					if($bet!='')
						$resvalue['BET'] 	= $bet;
					else
						$resvalue['BET'] 	= '-';
					if($win!='')
						$resvalue['WIN'] 	= $win;
					else
						$resvalue['WIN'] 	= '-';
					if($loss!='')
						$resvalue['LOSS'] 	= $loss;
					else
						$resvalue['LOSS'] 	= '-'; 
					if($forcedbet!='')
						$resvalue['FORCED'] = $forcedbet;
					else
						$resvalue['FORCED'] = '-';
						
					$resvalue['AMOUNT']		= $amount;
					$resvalue['OPENING']	= $opening_bal;
					$resvalue['CLOSING']	= $closing;
					$resvalue['RAKE'] 		= $rake;
					$resvalue['DATE_TIME']	= $date;
                    if($resvalue){
	                    $arrs[] = $resvalue;
                    }
	  		$j++;
			}
       }else{
       		$arrs="";
       }
     }
$sumBet = $totalbet + $totaloss + $totalforcebet;
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
<span style="position:relative;top:8px;left:10px"> <b> Total Record: <font color="#FF3300">(<?php echo $totCount; ?>) </font></b> &nbsp;&nbsp;&nbsp; </span>
<span style="position:relative;top:8px;left:10px"> <b> Total Pot: <font color="#FF3300">(<?php echo $sumBet; ?>) </font></b> &nbsp;&nbsp;&nbsp; </span>
<span style="position:relative;top:8px;left:10px"> <b> Total Win: <font color="#FF3300">(<?php echo $totalwin; ?>) </font></b> &nbsp;&nbsp;&nbsp; </span>
<?php if($this->session->userdata['searchData']["username"]==''){ ?>
<span style="position:relative;top:8px;left:10px"> <b> Total Rake: <font color="#FF3300">(<?php echo $totalrake; ?>) </font></b> &nbsp;&nbsp;&nbsp; </span>
<?php } ?>
<b style="float: right; position: relative; left: -42px; top: 6px;"><img src="<?php echo base_url(); ?>static/images/print.png"><a style="position: relative; top: -2px; left: 2px;" onclick="window.print()" href="#">Print</a></b>
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
					colNames:['Username','Reference No','PlayGroupId','Open Balance','Bet','Win','Banker Loss','Forced Bet','Close Balance','Rake','Transaction Date'],
                    colModel:[
						{name:'USERNAME',index:'USERNAME',align:"center", width:60},
						{name:'REF_NO',index:'REF_NO',align:"center", width:80},
						{name:'PLAY_GROUP_ID',index:'PLAY_GROUP_ID',align:"center", width:50},
						{name:'OPENING',index:'OPENING', align:"right", width:43, sorttype:"float"},						
						{name:'BET',index:'BET', align:"right", width:25, sorttype:"float"},
						{name:'WIN',index:'WIN', align:"right", width:25, sorttype:"float"},
						{name:'LOSS',index:'LOSS', align:"right", width:38, sorttype:"float"},
						{name:'FORCED',index:'FORCED', align:"right", width:35, sorttype:"float"},
						{name:'CLOSING',index:'CLOSING', align:"right", width:43, sorttype:"float"},
						{name:'RAKE',index:'RAKE', align:"right", width:25, sorttype:"float"},
						{name:'DATE_TIME',index:'DATE_TIME', align:"center", width:60},
                    ],
                    rowNum:500,
                    width: 1045, height: "100%"
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