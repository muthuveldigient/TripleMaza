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

<script src="<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url(); ?>static/js/dw_loader.js" type="text/javascript"></script>

        <?php
      
	        $supresults=$dresults['supdist_result'];
	        
	        $supResvalue=array();
	        $allTotPlay1="";
	        $allTotWin1="";
	        $allTotComm1="";
	        $allTotpComm1="";
	        $suparrs="";
	        
	        if(count($supresults)>0 && is_array($supresults)){
	        	for($i=0;$i<count($supresults);$i++){
	        		//get partner name
	        		$partnername	  = $supresults[$i]->SUPERDISTRIBUTOR_NAME;
	        		//get partner revenueshare
	        		//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
	        			
	        		$totalbets  = $supresults[$i]->totbet;
	        		$totalwins  = $supresults[$i]->totwin;
	        
	        		if($supresults[$i]->MARGIN)
        				$commission=$supresults[$i]->MARGIN;
        			else
        				$commission="0.00";
	        
        				//$net=$totalbets-$totalwins;
        				$partner_comm=$supresults[$i]->NET;
        					
        				//$resvalue['SNO']=$j+1;
        				$supResvalue['PARTNER']= $partnername;
        				$supResvalue['PLAYPOINTS'] = $totalbets;
        				$supResvalue['WINPOINTS']	= $totalwins;
        				$supResvalue['MARGIN'] = $commission;
        				$supResvalue['NET'] = $partner_comm;
        				$supResvalue['MARGIN_PERCENTAGE'] = $supresults[$i]->MARGIN_PERCENTAGE;
        				$supResvalue['COMMISSION_TYPE'] = $supresults[$i]->PARTNER_COMMISSION_TYPE;
        				$supResvalue['GAME_ID'] = $supresults[$i]->GAME_NAME;
        				$supResvalue['TOTAL_GAMES'] = $supresults[$i]->total_games;
        
        				if($totalwins!='' && $totalbets!=''){
        					$payout=($totalwins/$totalbets)*100;
        				}else{
        					$payout="0.00";
        				}
        
        				$supResvalue['PAYOUT'] = number_format($payout,2,".","")."%";
        
        					
        					
        				if($supResvalue){
        					$suparrs[] = $supResvalue;
        				}
	        					
	        	}
	        }else{
	        	$suparrs="";
	        }
	        
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
						$resvalue['PARTNER']= $partnername;
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

			 $subdistresults = $dresults['subdist_result'];

                   if(count($subdistresults)>0 && is_array($subdistresults)){
                      for($l=0;$l<count($subdistresults);$l++){
			//get partner name
			$partnername	  = $subdistresults[$l]->SUBDISTRIBUTOR_NAME;
			//get partner revenueshare
			//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
												
			$totalbets  = $subdistresults[$l]->totbet;
			$totalwins  = $subdistresults[$l]->totwin;
		//	$partnershare = $share;
												
		//	$commission=number_format($totalbets*($partnershare/100),2,'.',''); 
		//	$net=$totalbets-$totalwins;   
		//	$partner_comm=$net-$commission;  
			$commission = $subdistresults[$l]->MARGIN;
			$partner_comm = $subdistresults[$l]->NET;						
			//$presvalue['SNO1']=$k+1;
			//$presvalue['PARTNER1']= '<a href="'.base_url().'reports/agent_game_turnover/subdistreport_details/'.$subdistresults[$l]->SUBDISTRIBUTOR_ID.'/'.$subdistresults[$l]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
			$presvalue['PARTNER1'] = $partnername;
			$presvalue['PLAYPOINTS1'] = $totalbets;
			$presvalue['WINPOINTS1']	= $totalwins;
			$presvalue['MARGIN1'] = $commission;
			$presvalue['NET1'] = $partner_comm;
			$presvalue['MARGIN_PERCENTAGE1'] = $subdistresults[$l]->MARGIN_PERCENTAGE;
			$presvalue['COMMISSION_TYPE1'] = $subdistresults[$l]->PARTNER_COMMISSION_TYPE;
			$presvalue['GAME_ID1'] = $subdistresults[$l]->GAME_NAME;
			$presvalue['TOTAL_GAMES1'] = $subdistresults[$l]->total_games;
						
						if($totalwins!='' && $totalbets!=''){
							$payout=($totalwins/$totalbets)*100;
						}else{
							$payout="0.00";
						}
						
						$presvalue['PAYOUT1'] = number_format($payout,2,".","")."%";									
			
											
                        if($presvalue){
                              $arrsp[] = $presvalue;
                        }
                              
						  }
                  }else{
                     $arrsp="";
                  }
				 
			 $distagntresults = $dresults['distagnt_result'];	  
			 
			 $allTotPlay="";
			 $allTotWin="";
			 $allTotComm="";
			 $allTotpComm="";
			 
			 if(count($distagntresults)>0 && is_array($distagntresults)){
                      for($l=0;$l<count($distagntresults);$l++){
					  
							//get partner name
							$partnername	  = $distagntresults[$l]->PARTNER_NAME;
							//get partner revenueshare
							//$share	  	= $this->Agent_model->getRevenueShareByPartnerId($presults[$l]->partner_id);
																
							$totalbets  = $distagntresults[$l]->totbet;
							$totalwins  = $distagntresults[$l]->totwin;
						//	$partner_comm=$net-$commission;  
							$commission = $distagntresults[$l]->MARGIN;
							$partner_comm = $distagntresults[$l]->NET;						
							
							$agntvalue['PARTNER2']= '<a href="'.base_url().'reports/agent_game_turnover/agentreport/'.$distagntresults[$l]->PARTNER_ID.'/'.$distagntresults[$l]->GAME_NAME.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&keyword=Search">'.$partnername.'</a>';
							$agntvalue['PLAYPOINTS2'] = $totalbets;
							$agntvalue['WINPOINTS2']	= $totalwins;
							$agntvalue['MARGIN2'] = $commission;
							$agntvalue['NET2'] = $partner_comm;
							
							$agntvalue['MARGIN_PERCENTAGE2'] = $distagntresults[$l]->MARGIN_PERCENTAGE;
							$agntvalue['COMMISSION_TYPE2'] = $distagntresults[$l]->PARTNER_COMMISSION_TYPE;
							$agntvalue['GAME_ID2'] = $distagntresults[$l]->GAME_NAME;
							$agntvalue['TOTAL_GAMES2'] = $distagntresults[$l]->total_games;
										
							if($totalwins!='' && $totalbets!=''){
								$payout=($totalwins/$totalbets)*100;
							}else{
								$payout="0.00";
							}
							
							$agntvalue['PAYOUT2'] = number_format($payout,2,".","")."%";	
																
							$allTotPlay  += $totalbets;
							$allTotWin  += $totalwins;
							$allTotComm  += $commission;
							$allTotpComm  += $partner_comm;
															
										if($agntvalue){
											  $arragnt[] = $agntvalue;
										}
                              
						  }
                  }else{
                     $arragnt="";
                  }	  
			 
			 
?>

<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>          
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Game Turn Over Report</strong></td>
          </tr>
        </table>
       
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
  <?php } 
	
	  if(isset($suparrs) && $suparrs!=''){
	  	if( $partnertype==11 || $partnertype==0){
	  
	  
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
	  	
	  	</style>
	    
	         <div class="tableListWrap">
	            <div class="PageHdr"><b>Super Distributor</b></div>
	            <div class="data-list">
	              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
	  			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
	              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
	              <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
	              <table id="list7"></table>
	              <div id="pager7"></div>
	               <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
	              <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
	  <!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
	              <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
	              <script type="text/javascript">
	                  jQuery("#list7").jqGrid({
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
	                  var mydata = <?php echo json_encode($suparrs);?>;
	                  for(var i=0;i<=mydata.length;i++)
	                      jQuery("#list7").jqGrid('addRowData',i+1,mydata[i]);
	                  </script>
	            </div>
	          </div>
	        <?php 
	  	   }
	        }
             
	if(isset($arrs) && $arrs!=''){
		if($partnertype==15 || $partnertype==11 || $partnertype==0){
		
		
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
	
	</style>
  
       <div class="tableListWrap">
          <div class="PageHdr"><b>Distributor</b></div>
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
	  
	   if(isset($arrsp) && $arrsp!=''){
	   ?>
	   <div class="tableListWrap">
          <div class="PageHdr"><b>Sub Distributors</b></div>
          <div class="data-list">
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
			<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
            <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
            <table id="list5"></table>
            <div id="pager5"></div>
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
						
						{name:'PARTNER1',index:'PARTNER1', align:"center", width:60},
						{name:'PLAYPOINTS1',index:'PLAYPOINTS1', align:"right", width:50, sorttype: 'float'},
						{name:'WINPOINTS1',index:'WINPOINTS1', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN1',index:'MARGIN1', align:"right", width:60, sorttype: 'float'},
						{name:'NET1',index:'NET1', align:"right", width:40, sorttype: 'float'},
						{name:'MARGIN_PERCENTAGE1',index:'MARGIN_PERCENTAGE1', align:"right", width:40},
						{name:'TOTAL_GAMES1',index:'TOTAL_GAMES1', align:"right", width:40},
						{name:'PAYOUT1',index:'PAYOUT1', align:"right", width:40},
						{name:'GAME_ID1',index:'GAME_ID1', align:"right", width:40},
						
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
    <?php } 

	if(isset($arragnt) && $arragnt!=''){
	   ?>
               <div class="tableListWrap">
                  <div class="PageHdr"><b>Agent</b></div>
                  <div class="data-list">
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.multiselect.css" />
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-custom.css" />
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
                    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
                    <table id="list6"></table>
                    <div id="pager4"></div>
                     <script src="<?php echo base_url();?>static/jquery/js/subgrid_grid.js" type="text/javascript"> </script>
                    <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <!--            <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>-->
                    <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.js" type="text/javascript"></script>
                    <script type="text/javascript">
                        jQuery("#list6").jqGrid({
                            datatype: "local",
                            //colNames:['S.No','Partner','Total Bets','Total Wins','Margin','House Wins'],
                            colNames:['Partner','Play Points','Win Points','Margin','Net', 'Margin %','Total Game','Payout%','Game'],
                            colModel:[
                                //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
                                
                                {name:'PARTNER2',index:'PARTNER2', align:"center", width:60},
                                {name:'PLAYPOINTS2',index:'PLAYPOINTS2', align:"right", width:50, sorttype: 'float'},
                                {name:'WINPOINTS2',index:'WINPOINTS2', align:"right", width:40, sorttype: 'float'},
                                {name:'MARGIN2',index:'MARGIN2', align:"right", width:60, sorttype: 'float'},
                                {name:'NET2',index:'NET2', align:"right", width:40, sorttype: 'float'},
                                {name:'MARGIN_PERCENTAGE2',index:'MARGIN_PERCENTAGE2', align:"right", width:40},
                                {name:'TOTAL_GAMES2',index:'TOTAL_GAMES2', align:"right", width:40},
                                {name:'PAYOUT2',index:'PAYOUT2', align:"right", width:40},
                                {name:'GAME_ID2',index:'GAME_ID2', align:"right", width:40},
                                
                                //{name:'ACTION',index:'ACTION', align:"center", width:40},
                                
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($arragnt);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list6").jqGrid('addRowData',i+1,mydata[i]);
                        </script>
                  </div>
                </div>
        <?php 
		}  
	?>
      
      
        
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>	
     