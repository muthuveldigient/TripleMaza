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
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Turn Over Report</strong></td>
          </tr>
        </table>
        <?php 
		  $partner_id = $this->uri->segment(4,0);
		?>
       <!-- <form action="<?php echo base_url(); ?>reports/turnover/userreport/<?php echo $partner_id; ?>?rid=20" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              
              <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) echo $_REQUEST['START_DATE_TIME']; ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) echo $_REQUEST['END_DATE_TIME']; ?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>This Week</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>Last Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>This Month</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>
                <td width="20%">&nbsp;</td>
              </tr>
               <tr>
                <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                  <label>
                  <input type="text"  id="USERN_NAME" class="TextField" name="USERN_NAME" value="<?PHP if(isset($_REQUEST['USERN_NAME'])) echo $_REQUEST['USERN_NAME']; ?>">
                  </label>
                  </td>
                  </tr>
              
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </form>
        </td>
        <td><form action="<?php echo base_url();?>reports/turnover/report?rid=19" method="post" name="clrform" id="clrform">
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
        </form> -->
<?php
if(count($detail)>0 && is_array($detail)){
	for($i=0;$i<count($detail);$i++){
	//get partner name
	$partnername	  = $this->Agent_model->getAgentNameById($detail[$i]->PARTNER_ID);
	//get partner revenueshare
	//		$share	 = $this->Agent_model->getRevenueShareByPartnerId($detail[$i]->PARTNER_ID);
	$totalbets  = $detail[$i]->tot;
	$totalwins  = $detail[$i]->totwin;
	//	$partnershare = $share;
		if($this->uri->segment(4,0) == $this->session->userdata('partnerid')){										
    	    $commission="0.00"; 
        }else{
            //  $commission=number_format($totalbets*($partnershare/100),2,'.','');    
			$commission=$detail[$i]->MARGIN;    
        }
		//	$net=$totalbets-$totalwins;   
		//	$partner_comm=$net-$commission;  
		$partner_comm=$detail[$i]->NET;    							
		//	$resvalue1['SNO']=$j+1;
		$resvalue1['PARTNER']= $partnername;
		$resvalue1['PLAYPOINTS'] = $totalbets;
		$resvalue1['WINPOINTS']	= $totalwins;
		$resvalue1['REFUNDPOINTS'] = $commission;
		$resvalue1['ENDPOINTS'] = $partner_comm;
												
		$allTotPlay1  += $totalbets;
		$allTotWin1  += $totalwins;
		$allTotComm1  += $commission;
		$allTotpComm1  += $partner_comm;
											
		if($resvalue1){
        	$arr1[] = $resvalue1;
        }
        $j++;
	}
}else{
	$arr1="";
}
if(isset($arr1) && $arr1 !=''){ ?>
        <div class="tableListWrap">
            <div class="PageHdr"><p style="font-family:arial; font-size:15px;">From: <b><?php echo $_REQUEST['sdate']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TO: <b><?php echo $_REQUEST['edate']; ?></b> </p></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list5" class="data">
              <tr>
                <td></td>
              </tr>
            </table>
            <div id="pager3"></div>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery("#list5").jqGrid({
                    datatype: "local",
					//colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
					colNames:['Partner','Total Bets','Total Wins','Margin','House Wins'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
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
                var mydata = <?php echo json_encode($arr1);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list5").jqGrid('addRowData',i+1,mydata[i]);
					
					
					
                </script>
            
             <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:230px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:189px"><div align="right"><?php echo number_format($allTotPlay1, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:151px"><div align="right"><?php echo number_format($allTotWin1, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:228px"><div align="right"><?php echo number_format($allTotComm1, 2, '.', ''); ?></div></div>
                <div class="Agent_TotalRShdr" style="width:147px"><div align="right"><?php echo number_format($allTotpComm1, 2, '.', '');?></div></div>

</div>
          </div>
        </div>                
<?php 
}
	$page = $this->uri->segment(4);
	if(isset($page) && $page !=''){
		$j=$page;
	}else{
		$j=0;
	}  
							
	$resvalues=array();
	if($tot_users > 0){ 
		if(count($results)>0 && is_array($results)){
			for($i=0;$i<count($results);$i++){
				//get partner name
				$username	  = $this->Account_model->getUserNameById($results[$i]->user_id);
				//	$resvalue['SNO']=$i+1;
				$resvalue['USERNAME']='<a href="'.base_url().'games/poker/game/view?rid=51&playerID='.$username.'&START_DATE_TIME='.$_REQUEST['sdate'].'&END_DATE_TIME='.$_REQUEST['edate'].'&keyword=Search">'.$username.'</a>';
				//$resvalue['USERNAME']= '<a href="'.base_url().'reports/turnover/userreport/'.$username.'?rid=20">'.$username.'</a>';
				$resvalue['PLAYPOINTS'] = $results[$i]->tot;
				$resvalue['WINPOINTS']	= $results[$i]->totwin;
				//$endpoint = $results[$i]->tot - $results[$i]->totwin;
				$endpoint = $results[$i]->net;
				$resvalue['ENDPOINTS'] = $endpoint;
				$allTotStake  += $results[$i]->tot;
				$allTotWIN  += $results[$i]->totwin;
				$allTotEnd  += $endpoint;
                if($resvalue){
	                $arrs[] = $resvalue;
                }
            $j++;
			}
		}else{
        	$arrs="";
		}
	}
	$page = $this->uri->segment(4);
	if(isset($page) && $page !=''){
		$k=$page;
    }else{
        $k=0;
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
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Players</b></div>
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
					//colNames:['S.No','Player Name','Total Bet','Total Wins','House Win'],
					colNames:['Player Name','Total Bet','Total Wins','House Wins'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'USERNAME',index:'USERNAME', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40},
						{name:'ENDPOINTS',index:'ENDPOINTS', align:"right", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
					
					
					
                </script>
            
             <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:305px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:253px;"><div align="right"><?php echo number_format($allTotStake, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:200px;"><div align="right"><?php echo number_format($allTotWIN, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:198px;"><div align="right"><?php echo number_format($allTotEnd, 2, '.', ''); ?></div></div>

</div>
          </div>
        </div>
        
     
        <?php }else{ 
		  if(empty($_POST) || $_POST['reset'] == 'Clear'){
		    $message  = "Please select the search criteria"; 
		  }else{
		    $message  = "There are currently no users found in this search criteria.";
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