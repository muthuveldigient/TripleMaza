<style>
.PageHdr{
  width: 94.9%;
}
</style>

<div class="MainArea"> 
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <?php
		if(!empty($partnersList)) {
                    //echo "<pre>";print_r($partnersList);die;
			$i=1;
			$allTotStake=""; $allTotWIN=""; $allTotEnd="";
			foreach($partnersList as $index=>$partnersData) {
				$resValue[$index]['SNo']         = $i;		
				$resValue[$index]['PARTNER_NAME']= '<a href="'.base_url().'reports/turnover/userreport/'.$partnersData->PARTNER_ID.'?rid=19&sdate='.$sdate.'&edate='.$edate.'">'.$partnersData->PARTNER_NAME.'</a>';
				$resValue[$index]['totalBets']   = $partnersData->totalBets;
				$resValue[$index]['totalWins']= $partnersData->totalWins;
				if($this->session->userdata['partnerid'] == $partnersData->PARTNER_ID) {
					$resValue[$index]['Margin']   = "0.00";
				} else {
					$parnerShare	= $this->Agent_model->getRevenueShareByPartnerId($partnersData->PARTNER_ID);
					$resValue[$index]['Margin']   = number_format($partnersData->totalBets * ($parnerShare / 100),2,'.','');
				}
				//$resValue[$index]['Payout']   = number_format(($resValue[$index]['totalWins']/$resValue[$index]['totalBets'])*100,2,'.','');
				$resValue[$index]['houseWin'] = ($resValue[$index]['totalBets'] - $resValue[$index]['totalWins']) - $resValue[$index]['Margin'];	
				if(!empty($resValue[$index]['totalBets']))
					$allTotStake = $allTotStake + $resValue[$index]['totalBets'];
				if(!empty($resValue[$index]['totalWins']))
					$allTotWIN = $allTotWIN + $resValue[$index]['totalWins'];	
				if(!empty($resValue[$index]['houseWin']))
					$allTotEnd = $allTotEnd + $resValue[$index]['houseWin'];										
				$i++;
			}
		}
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
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>            
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
					colNames:['S.No','Partner Name','Total Bet','Total Wins','Margin','House Win'],
                    colModel:[
						{name:'SNo',index:'SNo', align:"center", width:20, sorttype:"int"},
						{name:'PARTNER_NAME',index:'PARTNER_NAME', align:"center", width:60},
						{name:'totalBets',index:'totalBets', align:"right", width:50},
						{name:'totalWins',index:'totalWins', align:"right", width:40},
						{name:'Margin',index:'Margin', align:"right", width:40},	
						//{name:'Payout',index:'Payout', align:"center", width:40},					
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
                <div class="Agent_TotalShdr" style="width:312px;text-align:right;">TOTAL:</div>
                <div class="Agent_TotalRShdr" style="width:188px;"><div align="right"><?php echo number_format($allTotStake, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:150px;"><div align="right"><?php echo number_format($allTotWIN, 2, '.', '');?></div></div>
                <div class="Agent_TotalRShdr" style="width:150px;"></div>
                <div class="Agent_TotalRShdr" style="width:145px;"><div align="right"><?php echo number_format($allTotEnd, 2, '.', ''); ?></div></div>

			</div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
