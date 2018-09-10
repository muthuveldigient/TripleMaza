
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />


<style>
.PageHdr{
  width: 94.9%;
}
</style>

<?php 
$START_DATE_TIME 	= (!empty($START_DATE_TIME)?date('d-m-Y H:i:s' ,strtotime($START_DATE_TIME)):date("d-m-Y 00:00:00"));
$END_DATE_TIME 		= (!empty($END_DATE_TIME)?date('d-m-Y H:i:s' ,strtotime($END_DATE_TIME)):date("d-m-Y 23:59:59"));
?>
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
			$resvalue=array();
			$arrs=array();
        	if(count($results)>0 && is_array($results)){
				foreach($results as $res){
					$partnername	  = $res->AGENT_NAME;
					$totalbets  = $res->totbet;
					$totalwins  = $res->totwin;
						
					if($res->MARGIN)
						$commission=$res->MARGIN; 
					else
						$commission="0.00"; 

					//$net=$totalbets-$totalwins;   
					$partner_comm=$res->NET;   
					//$resvalue['SNO']=$j+1;
				
					$resvalue['id'] = $res->AGENT_ID;
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAY_POINTS'] = $totalbets;
					$resvalue['WIN_POINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['NET'] = $partner_comm;
																
					$allTotPlay1  += $totalbets;
					$allTotWin1  += $totalwins;
					$allTotComm1  += $commission;
					$allTotpComm1  += $partner_comm;
															
					if($resvalue){
						$arrs['arrs'][] = $resvalue;
					}$j++;
				}
			}
			
			$arrs1=array();$resvalue=array();
			if(count($sub_results)>0 && is_array($sub_results)){
				$partnername = $totalbets = $resvalue =  $totalwins='';
				foreach($sub_results as $res1){
					$partnername	  =$res1->AGENT_NAME;
					$totalbets  = $res1->totbet;
					$totalwins  = $res1->totwin;
						
					if($res1->MARGIN)
						$commission=$res->MARGIN; 
					else
						$commission="0.00"; 

					//$net=$totalbets-$totalwins;   
					$partner_comm=$res1->NET;   
					//$resvalue['SNO']=$j+1;
				
					$resvalue['id'] = $res1->AGENT_ID;
					$resvalue['PARTNER']= '<a href="'.base_url().'reports/turnover_report/partnerdetails/'.$res1->AGENT_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&AGENT_LIST='.$AGENT_LIST.'&GAMES_TYPE='.$GAMES_TYPE.'&PARTNER_TYPE=&keyword=Search">'.$partnername.'</a>';
					$resvalue['PLAY_POINTS'] = $totalbets;
					$resvalue['WIN_POINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['NET'] = $partner_comm;
																
					$allTotPlay1  += $totalbets;
					$allTotWin1  += $totalwins;
					$allTotComm1  += $commission;
					$allTotpComm1  += $partner_comm;
															
					if($resvalue){
						$arrs1['arrs1'][] = $resvalue;
					}$j++;
				}
			}
			
			$arrs2=array();$resvalue=array();
			if(count($sub_sub_results)>0 && is_array($sub_sub_results)){
				$partnername = $totalbets = $resvalue = $totalwins='';
				foreach($sub_sub_results as $res2){
					$partnername	  = $res2->AGENT_NAME;
					$totalbets  = $res2->totbet;
					$totalwins  = $res2->totwin;
						
					if($res2->MARGIN)
						$commission=$res2->MARGIN; 
					else
						$commission="0.00"; 

					//$net=$totalbets-$totalwins;   
					$partner_comm=$res2->NET;   
					//$resvalue['SNO']=$j+1;
				
					$resvalue['id'] = $res2->AGENT_ID;
					$resvalue['PARTNER']= '<a href="'.base_url().'reports/turnover_report/partnerdetails/'.$res2->AGENT_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&AGENT_LIST='.$AGENT_LIST.'&GAMES_TYPE='.$GAMES_TYPE.'&PARTNER_TYPE='.$PARTNER_TYPE.'&keyword=Search">'.$partnername.'</a>';
					$resvalue['PLAY_POINTS'] = $totalbets;
					$resvalue['WIN_POINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['NET'] = $partner_comm;
																
					$allTotPlay1  += $totalbets;
					$allTotWin1  += $totalwins;
					$allTotComm1  += $commission;
					$allTotpComm1  += $partner_comm;
															
					if($resvalue){
						$arrs2['arrs2'][] = $resvalue;
					}$j++;
				}
			}
			$userInfo=array();$presvalue=array();
			 if(count($user_results)>0 && is_array($user_results)){
				foreach($user_results as $userList){
					//get partner name
					$partnername	  = $userList->USER_NAME;
					$totalbets  = $userList->totbet;
					$totalwins  = $userList->totwin;
					$partner_comm = $userList->NET;						
					if($userList->GAME_ID=='shan_mp'){
						$presvalue['USER_NAME']= $partnername;
					}else{
						$presvalue['USER_NAME']= $partnername;
					}
					$presvalue['PLAYPOINTS1'] = $totalbets;
					$presvalue['WINPOINTS1']	= $totalwins;
					$presvalue['NET1'] = $partner_comm;
																	
					$allTotPlay  += $totalbets;
					$allTotWin  += $totalwins;
					$allTotpComm  += $partner_comm;
																
					if($presvalue){
						  $userInfo['arrsp'][] = $presvalue;
					}
					$k++;
				}
			}
		
			if(!empty($arrs)){
				echo $this->load->view("reports/grid1",$arrs); 

			}else{
				  if(!empty($TITLE1)){
					$message  = "There are currently no records found in this search criteria"; 
				  
				  
				?>
				<div class="tableListWrap">
				<div class="PageHdr"><b><?php echo $TITLE1; ?></b></div>
				  <div class="data-list">
					<table id="list4" class="data">
					  <tr>
						<td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
					  </tr>
					</table>
				  </div>
				</div>
			<?php }
			} 
			if(!empty($arrs1)){
				echo $this->load->view("reports/grid2",$arrs1); 
			}else{
				 if(!empty($TITLE2)){
					$message  = "There are currently no records found in this search criteria.";
				 
			?>
				<div class="tableListWrap">
				<div class="PageHdr"><b><?php echo $TITLE2; ?></b></div>
				  <div class="data-list">
					<table id="list4" class="data">
					  <tr>
						<td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
					  </tr>
					</table>
				  </div>
				</div>
				 <?php }
			} 
			if(!empty($arrs2)){
				echo $this->load->view("reports/grid3",$arrs2); 

			}else{
				  if(!empty($TITLE3)){
					$message  = "There are currently no records found in this search criteria"; 
				  
				?>
				
				<div class="tableListWrap">
				<div class="PageHdr"><b><?php echo $TITLE3; ?></b></div>
				  <div class="data-list">
					<table id="list4" class="data">
					  <tr>
						<td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
					  </tr>
					</table>
				  </div>
				</div>
			<?php } } if(!empty($userInfo)){
				echo $this->load->view("reports/grid4",$userInfo); 

			}else{
				  if(!empty($TITLE4)){
					$message  = "There are currently no records found in this search criteria"; 
				 ?>
				<div class="tableListWrap">
				<div class="PageHdr"><b><?php echo $TITLE4; ?></b></div>
				  <div class="data-list">
					<table id="list4" class="data">
					  <tr>
						<td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
					  </tr>
					</table>
				  </div>
				</div>
			<?php } }?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>