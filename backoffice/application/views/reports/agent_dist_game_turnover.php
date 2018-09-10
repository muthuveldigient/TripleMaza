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
</script>
<script src="<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url(); ?>static/js/dw_loader.js" type="text/javascript"></script>

        <?php 
       if($partnertype==11 || $partnertype==0){
	  
		$results=$dresults['dist_result'];
		  $resvalues=array();
				$allTotPlay1="";	  
				$allTotWin1="";
				$allTotComm1="";
				$allTotpComm1="";
				$arrs="";
              if(count($results)>0 && is_array($results)){
					for($i=0;$i<count($results);$i++){
						//get partner name
						$partnername	  = $results[$i]->SUPERDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $results[$i]->totbet;
						$totalwins  = $results[$i]->totwin;
						
						if($results[$i]->MARGIN)
							$commission=$results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER']= '<a href="'.base_url().'reports/agent_game_turnover/supdistreport_details/'.$results[$i]->SUPERDISTRIBUTOR_ID.'/'.$results[$i]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['MARGIN_PERCENTAGE'] = $results[$i]->MARGIN_PERCENTAGE;
						$resvalue['COMMISSION_TYPE'] = $results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['GAME_ID'] = $results[$i]->GAME_NAME;
						$resvalue['TOTAL_GAMES'] = $results[$i]->total_games;
						
						if($totalwins!='' && $totalbets!=''){
							$payout=($totalwins/$totalbets)*100;
						}else{
							$payout="0.00";
						}
						
						$resvalue['PAYOUT'] = number_format($payout,2,".","")."%";
																
						$allTotPlay1  += $totalbets;
						$allTotWin1  += $totalwins;
						$allTotComm1  += $commission;
						$allTotpComm1  += $partner_comm;
															
						if($resvalue){
							$arrs[] = $resvalue;
						}
// 						echo '<pre>';print_r($arrs);exit;
					}
                }else{
                    $arrs="";
                }
                $name ="Super Distributor";
        }  
		
        if($partnertype==15 ){
        	 
        	$results=$dresults['dist_result'];
        	$resvalues=array();
        	$allTotPlay1="";
        	$allTotWin1="";
        	$allTotComm1="";
        	$allTotpComm1="";
        	$arrs="";
        	if(count($results)>0 && is_array($results)){
        		for($i=0;$i<count($results);$i++){
        			//get partner name
        			$partnername	  = $results[$i]->DISTRIBUTOR_NAME;
        			//get partner revenueshare
        			//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
        				
        			$totalbets  = $results[$i]->totbet;
        			$totalwins  = $results[$i]->totwin;
        
        			if($results[$i]->MARGIN)
        				$commission=$results[$i]->MARGIN;
        				else
        					$commission="0.00";
        
        					//$net=$totalbets-$totalwins;
        					$partner_comm=$results[$i]->NET;
        						
        					//$resvalue['SNO']=$j+1;
        					$resvalue['PARTNER']= '<a href="'.base_url().'reports/agent_game_turnover/distreport_details/'.$results[$i]->DISTRIBUTOR_ID.'/'.$results[$i]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
        					$resvalue['PLAYPOINTS'] = $totalbets;
        					$resvalue['WINPOINTS']	= $totalwins;
        					$resvalue['MARGIN'] = $commission;
        					$resvalue['NET'] = $partner_comm;
        					$resvalue['MARGIN_PERCENTAGE'] = $results[$i]->MARGIN_PERCENTAGE;
        					$resvalue['COMMISSION_TYPE'] = $results[$i]->PARTNER_COMMISSION_TYPE;
        					$resvalue['GAME_ID'] = $results[$i]->GAME_NAME;
        					$resvalue['TOTAL_GAMES'] = $results[$i]->total_games;
        
        					if($totalwins!='' && $totalbets!=''){
        						$payout=($totalwins/$totalbets)*100;
        					}else{
        						$payout="0.00";
        					}
        
        					$resvalue['PAYOUT'] = number_format($payout,2,".","")."%";
        
        					$allTotPlay1  += $totalbets;
        					$allTotWin1  += $totalwins;
        					$allTotComm1  += $commission;
        					$allTotpComm1  += $partner_comm;
        						
        					if($resvalue){
        						$arrs[] = $resvalue;
        					}
        		}
        	}else{
        		$arrs="";
        	}
        	$name ="Distributor";
        }
        
		if($partnertype==12){
			  $results=$dresults['subdist_result'];
			  $agent_results=$dresults['distagnt_result'];
			  
			  $resvalues=array();
				$allTotPlay1="";	  
				$allTotWin1="";
				$allTotComm1="";
				$allTotpComm1="";
				$arrs="";

              if(count($results)>0 && is_array($results)){
					for($i=0;$i<count($results);$i++){
						//get partner name
						$partnername	  = $results[$i]->SUBDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $results[$i]->totbet;
						$totalwins  = $results[$i]->totwin;
						
						if($results[$i]->MARGIN)
							$commission=$results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER']= '<a href="'.base_url().'reports/agent_game_turnover/distreport_details/'.$results[$i]->SUBDISTRIBUTOR_ID.'/'.$results[$i]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['MARGIN_PERCENTAGE'] = $results[$i]->MARGIN_PERCENTAGE;
						$resvalue['COMMISSION_TYPE'] = $results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['GAME_ID'] = $results[$i]->GAME_NAME;
						$resvalue['TOTAL_GAMES'] = $results[$i]->total_games;
						
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

				if(count($agent_results)>0 && is_array($agent_results)){
					for($i=0;$i<count($agent_results);$i++){
						//get partner name
						$partnername	  = $agent_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $agent_results[$i]->totbet;
						$totalwins  = $agent_results[$i]->totwin;
						
						if($agent_results[$i]->MARGIN)
						$commission=$agent_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$agent_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$agntresvalue['PARTNER']= '<a href="'.base_url().'reports/agent_game_turnover/agentreport/'.$agent_results[$i]->PARTNER_ID.'/'.$agent_results[$i]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
						$agntresvalue['PLAYPOINTS'] = $totalbets;
						$agntresvalue['WINPOINTS']	= $totalwins;
						$agntresvalue['MARGIN'] = $commission;
						$agntresvalue['NET'] = $partner_comm;
						$agntresvalue['MARGIN_PERCENTAGE'] = $agent_results[$i]->MARGIN_PERCENTAGE;
						$agntresvalue['COMMISSION_TYPE'] = $agent_results[$i]->PARTNER_COMMISSION_TYPE;
						$agntresvalue['GAME_ID'] = $agent_results[$i]->GAME_NAME;
						$agntresvalue['TOTAL_GAMES'] = $agent_results[$i]->total_games;
						
						if($totalwins!='' && $totalbets!=''){
							$payout=($totalwins/$totalbets)*100;
						}else{
							$payout="0.00";
						}
						
						$agntresvalue['PAYOUT'] = number_format($payout,2,".","")."%";
																
						$allTotPlay1  += $totalbets;
						$allTotWin1  += $totalwins;
						$allTotComm1  += $commission;
						$allTotpComm1  += $partner_comm;
															
								if($agntresvalue){
									$arrsp[] = $agntresvalue;
								}
					}
                }else{
                    $arrsp="";
                }
        }  
	
		if($partnertype==13){
			  $agent_results=$dresults['agnt_result'];
			  $resvalues=array();
				$allTotPlay1="";	  
				$allTotWin1="";
				$allTotComm1="";
				$allTotpComm1="";
				$arrs="";
              if(count($agent_results)>0 && is_array($agent_results)){
					for($i=0;$i<count($agent_results);$i++){
						//get partner name
						$partnername	  = $agent_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $agent_results[$i]->totbet;
						$totalwins  = $agent_results[$i]->totwin;
						
						if($agent_results[$i]->MARGIN)
							$commission=$agent_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$agent_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER']= '<a href="'.base_url().'reports/agent_game_turnover/agentreport/'.$agent_results[$i]->PARTNER_ID.'/'.$agent_results[$i]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
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
        }
		   
		if($partnertype==14){
			  $user_results=$dresults['user_result'];
			  $resvalues=array();
				$allTotPlay="";	  
				$allTotWin="";
				$allTotpComm="";
				$arrsp="";
				
              if(count($user_results)>0 && is_array($user_results)){
                      for($l=0;$l<count($user_results);$l++){
							//get partner name
							$partnername	  = $user_results[$l]->USER_NAME;
							//get partner revenueshare
							//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
																
							$totalbets  = $user_results[$l]->totbet;
							$totalwins  = $user_results[$l]->totwin;
						//	$partnershare = $share;
																
						//	$commission=number_format($totalbets*($partnershare/100),2,'.',''); 
						//	$net=$totalbets-$totalwins;   
						//	$partner_comm=$net-$commission;  
							$partner_comm = $user_results[$l]->NET;						
							//$presvalue['SNO1']=$k+1;
							if($user_results[$l]->GAME_ID=="shan_mp"){
								$presvalue['USER_NAME']= '<a href="'.base_url().'helpdesk/helpdesk/shanwallet?rid='.$rid.'&START_DATE_TIME='.$START_DATE_TIME.'&END_DATE_TIME='.$END_DATE_TIME.'&keyword=Search&username='.$partnername.'">'.$partnername.'</a>';
							}else{							
								$presvalue['USER_NAME']= '<a href="'.base_url().'games/history/game/userhistory/'.$partnername.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search&playerID='.$partnername.'">'.$partnername.'</a>';
							}
							$presvalue['PLAYPOINTS1'] = $totalbets;
							$presvalue['WINPOINTS1']	= $totalwins;
							$presvalue['NET1'] = $partner_comm;
																
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
        }
		   

		if($partnertype==15 || $partnertype==11 || $partnertype==0){ ?>
        <div class="tableListWrap">
	<?php			
		if( (isset($arrs) && $arrs!='')){		
	 ?>
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
          <div class="PageHdr"><b><?php echo $name  ?></b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4"></table>
            <div id="pager3"></div>
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
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50, sorttype: 'float'},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60, sorttype: 'float'},
						{name:'NET',index:'NET', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"right", width:40},
						
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
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
      
      <?php 
	   }
	   }
	 
	   if($partnertype==12){
	   		if( (isset($arrs) && $arrs!='')){
	 ?>
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Sub Distributors</b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4"></table>
            <div id="pager3"></div>
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
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50, sorttype: 'float'},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60, sorttype: 'float'},
						{name:'NET',index:'NET', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"right", width:40},
						
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
            
          </div>
      <?php 
	  		}
	   	   if((isset($arrsp) && $arrsp!='')){
	 ?>
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Agents</b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list5"></table>
            <div id="pager4"></div>
             <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script type="text/javascript">
                jQuery("#list5").jqGrid({
                    datatype: "local",
					//colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
					colNames:['Partner','Play Points','Win Points','Margin','Net', 'Margin %','Total Game','Payout%','Game'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50, sorttype: 'float'},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60, sorttype: 'float'},
						{name:'NET',index:'NET', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"right", width:40},
						
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrsp);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list5").jqGrid('addRowData',i+1,mydata[i]);
                </script>
            
          </div>
        </div>
      
      <?php 
	   }
	   ?></div>
     <?php
     }
	 
	 if($partnertype==13){
	   		if( (isset($arrs) && $arrs!='')){
	 ?>
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
  
        <div class="tableListWrap">
          <div class="PageHdr"><b>Agents</b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4"></table>
            <div id="pager3"></div>
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
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'PLAYPOINTS',index:'PLAYPOINTS', align:"right", width:50},
						{name:'WINPOINTS',index:'WINPOINTS', align:"right", width:40},
						{name:'MARGIN',index:'MARGIN', align:"right", width:60},
						{name:'NET',index:'NET', align:"right", width:40},
						{name:'MARGIN_PERCENTAGE',index:'MARGIN_PERCENTAGE', align:"right", width:40},
						{name:'TOTAL_GAMES',index:'TOTAL_GAMES', align:"right", width:40},
						{name:'PAYOUT',index:'PAYOUT', align:"right", width:40},
						{name:'GAME_ID',index:'GAME_ID', align:"right", width:40},
						
						//{name:'ACTION',index:'ACTION', align:"center", width:40},
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
            
          </div>
        
      
      <?php 
	  		}
	  ?>
	   
	   	  </div>
     <?php
     }
	 
	 if($partnertype==14){
	 		
	   		if( (isset($arrsp) && $arrsp!='')){
	 ?>
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
	iframe#buffer { position:absolute; visibility:hidden; left:0; top:0; } 
	</style>
  
        <div class="tableListWrap">
        <div class="PageHdr"><b>User</b></div>
          <div class="data-list">
           <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list4"></table>
            <div id="pager3"></div>
             <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
            <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
            <script type="text/javascript">
               jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['Username','Total Bets','Total Wins','Net'],
                    colModel:[
						{name:'USER_NAME',index:'USER_NAME', align:"center", width:60},
						{name:'PLAYPOINTS1',index:'PLAYPOINTS1', align:"right", width:50,summaryType: 'sum', sorttype: 'number', formatter: 'number'},
						{name:'WINPOINTS1',index:'WINPOINTS1', align:"right", width:40,summaryType: 'sum', sorttype: 'number', formatter: 'number'},
						{name:'NET1',index:'NET1', align:"right", width:60,summaryType: 'sum', sorttype: 'number', formatter: 'number'}
						
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata1 = <?php echo json_encode($arrsp);?>;
                for(var i=0;i<=mydata1.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata1[i]);
					
					
					
                </script>
                
                <div class="Agent_total_Wrap1" style="width:1000px;">
                <div class="Agent_TotalShdr" style="width:277px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:226px"><div align="right"><?php echo number_format($allTotPlay, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:181px"><div align="right"><?php echo number_format($allTotWin, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:272px"><div align="right"><?php echo number_format($allTotpComm, 2, '.', '');?></div></div>

</div>
          </div>
        </div>
        
      
      <?php 
	  		}
	  ?>
	   
	   	  </div>
     <?php
     }
	  ?>
	  
        
     