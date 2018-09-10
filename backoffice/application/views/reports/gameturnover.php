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

function getPartnersData(gameID,sdate,edate) {
    ///alert(edate);
	$('#partnerslist').load('<?php echo base_url()?>reports/ajax/getPartnersData/'+gameID+'/'+sdate+'/'+edate);	
}
function getPartnersData123(gameID) {
	xmlHttp=GetStateXmlHttpObject();
	if(xmlHttp==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url()?>reports/ajax/getPartnersData/"+gameID;

	//alert(url);
	xmlHttp.onreadystatechange=getPartnersDataResult;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);		
}

function getPartnersDataResult() { 
	if (xmlHttp.readyState==4) { 
		document.getElementById("partnerslist").innerHTML=xmlHttp.responseText;		
	}
}

function GetStateXmlHttpObject() {
	var xmlHttp=null;
	try {
  		// Firefox, Opera 8.0+, Safari
	    xmlHttp=new XMLHttpRequest();
  	} catch (e) {
		// Internet Explorer
	  	try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
  	}
	return xmlHttp;
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
            <td><strong>Game T/O Report</strong></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>reports/turnover/game?rid=20" method="post" name="tsearchform" id="tsearchform"  >
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
                
              <td width="33%"><span class="TextFieldHdr">Date Range:</span><br />
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
              </tr>
              
              <tr>
              	<td width="40%"><span class="TextFieldHdr">Games:</span><br />
                <?php
					$gameID = "";
					if(!empty($this->session->userdata['searchData']['GAME_ID']))
						$gameID = $this->session->userdata['searchData']['GAME_ID'];	

					echo '<select name="gameName" class="ListMenu">';
					echo '<option value="">Select</option>';
					foreach($getGamesData as $gamesID) {
						if($gameID == $gamesID->MINIGAMES_NAME)	
							echo '<option value="'.$gamesID->MINIGAMES_NAME.'" selected="selected">'.$gamesID->MINIGAMES_NAME.'</option>';						
						else
							echo '<option value="'.$gamesID->MINIGAMES_NAME.'">'.$gamesID->MINIGAMES_NAME.'</option>';
					}
					echo '</select>';					
				?>
                </td>

                             
              </tr>
              
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </td>
        <td><input name="frmClear" type="submit"  id="frmClear" value="Clear"  /></td>
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
            if($totCount > 0){ 
              if(count($results)>0 && is_array($results)){
									
              for($i=0;$i<count($results);$i++){
		//get partner name
		$partnername	  = $this->Agent_model->getAgentNameById($results[$i]->partner_id);
		//get partner revenueshare
		$share 	= $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
											
		$totalbets  = $results[$i]->tot;
		$totalwins  = $results[$i]->totwin;
		$partnershare = $share;
												
		$commission="0.00"; 
		$net=$totalbets-$totalwins;   
		$partner_comm=$net-$commission;  

		$resvalue['SNO']=$j+1;
		$gameID = $results[$i]->game_id;
                //echo $START_DATE_TIME;die;
		if(empty($this->session->userdata['searchData']['GAME_ID']))
                        
                    $resvalue['GAME']= "<a onclick='javascript:getPartnersData(".'"'.$gameID.'"'.",".'"'.str_replace(' ', '--', $START_DATE_TIME).'"'.",".'"'.str_replace(' ', '--', $END_DATE_TIME).'"'.");' style='cursor: pointer'>".$results[$i]->game_id."</a>";
		else
                    $resvalue['GAME']= $results[$i]->game_id;
                    $resvalue['PLAYPOINTS'] = $totalbets;
                    $resvalue['WINPOINTS']	= $totalwins;
                    $resvalue['REFUNDPOINTS'] = $commission;
                    $resvalue['ENDPOINTS'] = $partner_comm;
                    $resvalue['TOTGAME'] = $results[$i]->cnt;
                    $resvalue['PAYOUT'] = number_format(($resvalue['WINPOINTS']/$resvalue['PLAYPOINTS'])*100,2,'.','');
                    $resvalue['MARGINP'] = '-';
												
                    $allTotPlay1  += $totalbets;
                    $allTotWin1  += $totalwins;
                    $allTotComm1  += $commission;
                    $allTotpComm1  += $partner_comm;
											
                if($resvalue){
                   $arrs[] = $resvalue;
                }
                $j++;}
              }else{
                $arrs="";
	      }
            }
								   
								   
								   
								 
							
                                    ?>
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
					colNames:['S.No','Game Name','Total Bets','Total Wins','Margin','House Wins','Margin %','Total Games','Payout %'],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'GAME',index:'GAME', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40},
						{name:'REFUNDPOINTS',index:'REFUNDPOINTS', align:"right", width:60},
						{name:'ENDPOINTS',index:'ENDPOINTS', align:"right", width:40},
						{name:'MARGINP',index:'MARGINP', align:"right", width:40},
						{name:'TOTGAME',index:'TOTGAME', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
					
					
					
                </script>
            
             <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:197px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:117px"><div align="right"><?php echo number_format($allTotPlay1, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:90px"><div align="right"><?php echo number_format($allTotWin1, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:142px"><div align="right"><?php echo number_format($allTotComm1, 2, '.', ''); ?></div></div>
                <div class="Agent_TotalRShdr" style="width:95px"><div align="right"><?php echo number_format($allTotpComm1, 2, '.', '');?></div></div>

</div>
          </div>
        </div>
        
        
        <div id="partnerslist">
				<?php
                if(!empty($partnersList)) {
                    $i=1;
                    $allTotStake=""; $allTotWIN=""; $allTotEnd="";
                    foreach($partnersList as $index=>$partnersData) {
                        $resValue[$index]['SNo']         = $i;		
                        $resValue[$index]['PARTNER_NAME']= '<a href="'.base_url().'reports/turnover/userreport/'.$partnersData->PARTNER_ID.'?rid=19&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'">'.$partnersData->PARTNER_NAME.'</a>';
                        $resValue[$index]['totalBets']   = $partnersData->totalBets;
						$resValue[$index]['totalWins']= $partnersData->totalWins;
						if($this->session->userdata['partnerid'] == $partnersData->PARTNER_ID) {
							$resValue[$index]['Margin']   = "0.00";
						} else {
							$parnerShare	= $this->Agent_model->getRevenueShareByPartnerId($partnersData->PARTNER_ID);
							$resValue[$index]['Margin']   = number_format($partnersData->totalBets * ($parnerShare / 100),2,'.','');
						}
						$resValue[$index]['Payout']   = number_format(($resValue[$index]['totalWins']/$resValue[$index]['totalBets'])*100,2,'.','');
						$resValue[$index]['houseWin'] = ($resValue[$index]['totalBets'] - $resValue[$index]['totalWins']) - $resValue[$index]['Margin'];	
                        if(!empty($resValue[$index]['totalBets']))
                            $allTotStake = $allTotStake + $resValue[$index]['totalBets'];
                        if(!empty($resValue[$index]['totalWins']))
                            $allTotWIN = $allTotWIN + $resValue[$index]['totalWins'];	
                        if(!empty($resValue[$index]['houseWin']))
                            $allTotEnd = $allTotEnd + $resValue[$index]['houseWin'];										
                        $i++;
                    }
				?>        
                <div class="tableListWrap">
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
                            colNames:['S.No','Partner Name','Total Bets','Total Wins','Margin','Payout (%)','House Wins'],
                            colModel:[
                                {name:'SNo',index:'SNo', align:"center", width:20, sorttype:"int"},
                                {name:'PARTNER_NAME',index:'PARTNER_NAME', align:"center", width:60},
                                {name:'totalBets',index:'totalBets', align:"right", width:50},
                                {name:'totalWins',index:'totalWins', align:"right", width:40},
                                {name:'Margin',index:'Margin', align:"right", width:40},		
				{name:'Payout',index:'Payout', align:"right", width:40},						
                                {name:'houseWin',index:'houseWin', align:"right", width:40},
                                
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list5").jqGrid('addRowData',i+1,mydata[i]);
                        </script>
                    
                     <div class="Agent_total_Wrap1" style="width:1000px;">
                        <div class="Agent_TotalShdr" style="width:330px;text-align:right;">TOTAL:</div>
                        <div class="Agent_TotalRShdr" style="width:226px;"><div align="right"><?php echo number_format($allTotStake, 2, '.', '');?></div></div>
                        <div class="Agent_TotalRShdr" style="width:180px;"><div align="right"><?php echo number_format($allTotWIN, 2, '.', '');?></div></div>
                        <div class="Agent_TotalRShdr" style="width:178px;"><div align="right"><?php echo number_format($allTotEnd, 2, '.', ''); ?></div></div>
        
                    </div>
                  </div>
                </div>
                <?php } ?>  
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