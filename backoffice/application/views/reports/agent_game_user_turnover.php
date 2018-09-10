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
.PageHdr{  width: 94.9%;}
</style>

<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Game TurnOver Report</strong></td>
          </tr>
        </table>
        <?php
		
		$agent_results=$agntresults['agnt_result'];
        $user_results=$agntresults['user_result'];
		
		
		
	    $resvalues=array();
 
              if(count($agent_results)>0 && is_array($agent_results)){
					for($i=0;$i<count($agent_results);$i++){
						//get partner name
						$partnername	  = $agent_results[$i]->PARTNER_NAME;
						$totalbets  = $agent_results[$i]->totbet;
						$totalwins  = $agent_results[$i]->totwin;
						
						if($agent_results[$i]->MARGIN)
						$commission=$agent_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$agent_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['MARGIN_PERCENTAGE'] = $agent_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['COMMISSION_TYPE'] = $agent_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['GAME_ID'] = $agent_results[$i]->GAME_NAME;
						$resvalue['TOTAL_GAMES'] = $agent_results[$i]->total_games;
						
						if($totalwins!='' && $totalbets!=''){
							$payout=($totalwins/$totalbets)*100;
						}else{
							$payout="0.00";
						}
						
						$resvalue['PAYOUT'] = number_format($payout,2,".","")."%";										
					
															
						if($resvalue){
							$arrs[] = $resvalue;
						}
					}
            }else{
                    $arrs="";
            }
              
							  $allTotPlay="";
							  $allTotWin=""; 
        					  $allTotpComm="";

                   if(count($user_results)>0 && is_array($user_results)){
                      for($l=0;$l<count($user_results);$l++){
							//get partner name
							$partnername	  = $user_results[$l]->USER_NAME;
							//get partner revenueshare
							//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
																
							$totalbets  = $user_results[$l]->totbet;
							$totalwins  = $user_results[$l]->totwin;
							$gameID = $user_results[$l]->GAME_ID;
						//	$partnershare = $share;
																
						//	$commission=number_format($totalbets*($partnershare/100),2,'.',''); 
						//	$net=$totalbets-$totalwins;   
						//	$partner_comm=$net-$commission;  
							$partner_comm = $user_results[$l]->NET;						
							//$presvalue['SNO1']=$k+1;
							if($user_results[$l]->GAME_ID=="Texas Hold'em"){
								$presvalue['AGENT_ANT2']= $partnername;							
							}else if($user_results[$l]->GAME_ID=="shan_mp"){
								$presvalue['AGENT_ANT2']= '<a href="'.base_url().'helpdesk/helpdesk/shanwallet?rid='.$rid.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'&keyword=Search&username='.$partnername.'">'.$partnername.'</a>';
							}else{
								$presvalue['AGENT_ANT2']= '<a href="'.base_url().'games/history/game/history?rid='.$rid.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'&keyword=Search&gameID='.$gameID.'&playerID='.$partnername.'">'.$partnername.'</a>';
							}
							$presvalue['PLAYPOINTS2'] 	= $totalbets;
							$presvalue['WINPOINTS2']	= $totalwins;
							$presvalue['NET2'] 			= $partner_comm;
							$presvalue['TOTAL_GAMES2'] 	= $user_results[$l]->total_games;	
							
							if($totalwins!='' && $totalbets!=''){
								$payout=($totalwins/$totalbets)*100;
							}else{
								$payout="0.00";
							}
						
						$presvalue['PAYOUT2'] = number_format($payout,2,".","")."%";			
															
						$allTotPlay  += $totalbets;
						$allTotWin  += $totalwins;
						$allTotpComm  += $partner_comm;
															
						if($presvalue){
							  $arrsp[] = $presvalue;
						}
											
					}
                  }else{
                     $arrsp="";
                  }

	if(isset($arrs) && $arrs!=''){
		if($partnertype==15 || $partnertype==11 || $partnertype==12 || $partnertype==13 || $partnertype==0){	 ?>
    <style>
	.searchWrap1 {   background-color: #F8F8F8;  border: 1px solid #EEEEEE; border-radius: 5px; float: left; width: 100%;  margin-top:10px;	font-size:13px; }
	</style>
  <?php if($_REQUEST['sdate']){ ?>
    <div class="Agent_Game_Det_wrap">
        <div class="Agent_game_Left01" style="width:500px">
            <div class="Agent_game_tit_wrap">
            <div class="Agent_game_name">From Date</div>
            <div class="Agent_game_val2">: <?php if($_REQUEST['sdate']){ echo $_REQUEST['sdate']; }else{ echo $sdate;}?></div>
            </div>
            <div class="Agent_game_tit_wrap01">
            <div class="Agent_game_name">To Date</div>
            <div class="Agent_game_val3">: <?php if($_REQUEST['edate']){ echo $_REQUEST['edate']; }else{ echo $edate;}?></div>
            </div>
        </div>
    </div>
  <?php } ?>
        <div class="tableListWrap">
          <div class="PageHdr"><b>Agent</b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
           <table id="list4"></table>
            <div id="page4"></div>
           <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					//colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
					colNames:['Partner','Play Points','Win Points','Margin','Net', 'Margin %','Total Game','Payout%','Game'],
                    colModel:[
                       {name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50, sorttype:"float"},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40, sorttype:"float"},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60, sorttype:"float"},
						{name:'NET',index:'NET', align:"right", width:40, sorttype:"float"},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"right", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
          </div>
        </div>
        
       <?php if(isset($arrsp) && $arrsp!=''){ ?>
      
        <div class="tableListWrap">
        <div class="PageHdr"><b>User</b></div>
          <div class="data-list">
            <table id="list6" class="data">
              <tr>
                <td></td>
              </tr>
            </table>
            <div id="pager6"></div>
            <script type="text/javascript">
                jQuery("#list6").jqGrid({
                    datatype: "local",
					colNames:['Player Id','Play Points', 'Win Points','End Points','Total Game', 'Payout %'],
                    colModel:[
						{name:'AGENT_ANT2',index:'AGENT_ANT2', align:"center", width:117},
						{name:'PLAYPOINTS2',index:'PLAYPOINTS2', width:110, align:"right", sorttype:"float"},
						{name:'WINPOINTS2',index:'WINPOINTS2', align:"right", width:110, sorttype:"float"},			
						{name:'NET2',index:'NET2', width:115, align:"right",sorttype:"float"},			
						{name:'TOTAL_GAMES2',index:'TOTAL_GAMES2', width:75, align:"center",sorttype:"int"},
						{name:'PAYOUT2',index:'PAYOUT2', width:90, align:"center",sorttype:"float"},	
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata1 = <?php echo json_encode($arrsp);?>;
                for(var i=0;i<=mydata1.length;i++)
                    jQuery("#list6").jqGrid('addRowData',i+1,mydata1[i]);
                </script>
                
                <div class="Agent_total_Wrap1" style="width:1000px;">
                    <div class="Agent_TotalShdr" style="width:180px;text-align:right;">TOTAL:</div>
                    <div class="Agent_TotalRShdr" style="width:168px"><div align="right"><?php echo number_format($allTotPlay, 2, '.', '');?></div></div>
                    <div class="Agent_TotalRShdr" style="width:167px"><div align="right"><?php echo number_format($allTotWin, 2, '.', '');?></div></div>
                    <div class="Agent_TotalRShdr" style="width:176px"><div align="right"><?php echo number_format($allTotpComm, 2, '.', '');?></div></div>
                </div>
			</div>
		</div>
        
       <?php }  ?>
       
       
	<?php   
	   }
      } ?>
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>