<link href="<?php echo base_url(); ?>static/css/dashboard.css" rel="stylesheet" type="text/css" />
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
<div class="RightWrap">
    <div class="content_wrap">
    <?php if($this->session->userdata('adminuserid')!=1 && $this->session->userdata('dashboardAccess')=="") {?>
        <table class="PageHdr" width="100%" style="height: 770px;">
          <tr>
            <td valign="top" style="padding:20px 10px;">
               <strong>Please navigate to the left menu to access the page!</strong>
             </td>
          </tr>
        </table>     
    <?php } else { ?>
        <table width="100%" class="PageHdr">
            <tr>
                <td><strong><?php echo date('d-m-Y', strtotime($revenueHistoricalData[0]->END_DATE));?> - <?php echo date('d-m-Y', strtotime($revenueHistoricalData[0]->START_DATE));?></strong></td>
            </tr>
        </table>    
        
        <table width="100%">
            <tr>
                <td width="70%">
                    <div class="iconwrap">
                        <div class="icon"><img src="<?php echo base_url();?>static/images/dashboard/icon-revenue.png" width="55" height="40" /></div>
                        <div class="iconTxt">Revenue</div>
                    </div>                
                    <table width="100%" cellspacing="0" style="height:147px;" class="tableWrap" cellpadding="10">
                        <tr class="tableHeading">
                            <td width="16%" rowspan="2">Name</td>
                            <td colspan="3" align="center" class="diffMonth1"><?php echo $revenueHistoricalData[0]->MONTH1;?></td>
                            <td colspan="3" align="center" class="diffMonth1"><?php echo $revenueHistoricalData[0]->MONTH2;?></td>
                            <td colspan="3" align="center"><?php echo $revenueHistoricalData[0]->MONTH3;?></td>
                        </tr>
                        <tr class="tableHeading1">
                            <td width="9%">Revenue</td>
                            <td width="10%">O/P Share</td>
                            <td width="9%" class="diffMonth">Share</td>
                            <td width="10%">Revenue</td>
                            <td width="10%">O/P Share</td>
                            <td width="8%" class="diffMonth">Share</td>
                            <td width="9%">Revenue</td>
                            <td width="10%">O/P Share</td>
                            <td width="9%">Share</td>
                        </tr>
                        <tr>
                            <td class="sideHeadingNormal">Self</td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF1_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF1_OP_SHARE;?></td>
                            <td class="diffMonth"><?php echo $revenueHistoricalData[0]->SELF1_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF2_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF2_OP_SHARE;?></td>
                            <td class="diffMonth"><?php echo $revenueHistoricalData[0]->SELF2_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF3_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF3_OP_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->SELF3_SHARE;?></td>
                        </tr>
                          <tr>
                            <td class="sideHeadingNormal">Affiliate</td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE1_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE1_OP_SHARE;?></td>
                            <td class="diffMonth"><?php echo $revenueHistoricalData[0]->AFFILIATE1_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE2_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE2_OP_SHARE;?></td>
                            <td class="diffMonth"><?php echo $revenueHistoricalData[0]->AFFILIATE2_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE3_REVENUE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE3_OP_SHARE;?></td>
                            <td class="dataAmount"><?php echo $revenueHistoricalData[0]->AFFILIATE3_SHARE;?></td>
                        </tr>
                          <tr>
                            <td class="sideHeading">Total</td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF1_REVENUE+$revenueHistoricalData[0]->AFFILIATE1_REVENUE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF1_OP_SHARE+$revenueHistoricalData[0]->AFFILIATE1_OP_SHARE,2,'.','');?></td>
                            <td class="diffMonth"><?php echo number_format($revenueHistoricalData[0]->SELF1_SHARE+$revenueHistoricalData[0]->AFFILIATE1_SHARE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF2_REVENUE+$revenueHistoricalData[0]->AFFILIATE2_REVENUE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF2_OP_SHARE+$revenueHistoricalData[0]->AFFILIATE2_OP_SHARE,2,'.','');?></td>
                            <td class="diffMonth"><?php echo number_format($revenueHistoricalData[0]->SELF2_SHARE+$revenueHistoricalData[0]->AFFILIATE2_SHARE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF3_REVENUE+$revenueHistoricalData[0]->AFFILIATE3_REVENUE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF3_OP_SHARE+$revenueHistoricalData[0]->AFFILIATE3_OP_SHARE,2,'.','');?></td>
                            <td class="dataAmount"><?php echo number_format($revenueHistoricalData[0]->SELF3_SHARE+$revenueHistoricalData[0]->AFFILIATE3_SHARE,2,'.','');?></td>
                        </tr>
                    </table>                
                </td>
       		  <td width="30%" valign="top">
                <div class="iconwrap">
                        <div class="icon"><img src="<?php echo base_url();?>static/images/dashboard/icon-user.png" width="55" height="40" /></div>
                        <div class="iconTxt">User</div>
                  </div>          
                  <table width="100%" cellspacing="0" class="tableWrap" cellpadding="10">
                        <tr class="tableHeading">
                          <td width="45%">Reg.Month</td>
                          <td width="28%">Self</td>
                          <td width="27%">Affiliate</td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal"><?php echo $usersHistoricalData[0]->MONTH1;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->SELF1_USERS;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->AFFILIATE1_USERS;?></td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal"><?php echo $usersHistoricalData[0]->MONTH2;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->SELF2_USERS;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->AFFILIATE2_USERS;?></td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal"><?php echo $usersHistoricalData[0]->MONTH3;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->SELF3_USERS;?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->AFFILIATE3_USERS;?></td>
                      </tr>
                        <tr>
                          <td class="sideHeading">Total</td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->SELF1_USERS+$usersHistoricalData[0]->SELF2_USERS+$usersHistoricalData[0]->SELF3_USERS?></td>
                          <td class="dataAmount"><?php echo $usersHistoricalData[0]->AFFILIATE1_USERS+$usersHistoricalData[0]->AFFILIATE2_USERS+$usersHistoricalData[0]->AFFILIATE3_USERS?></td>
                      </tr>
                  </table>
                </td>
            </tr>
            <tr>
           	  <td width="70%">
                <div class="iconwrap">
                        <div class="icon"><img src="<?php echo base_url();?>static/images/dashboard/icon-cashflow.png" width="55" height="40" /></div>
                        <div class="iconTxt">Cash Flow</div>
                  </div>                
                  <table width="100%" cellspacing="0" style="height:188px;" class="tableWrap" cellpadding="10">
                      <tr class="tableHeading">
                          <td width="16%" rowspan="2">Name</td>
                          <td colspan="3" align="center" class="diffMonth1"><?php echo $cashflowHistoricalData[0]->MONTH1;?></td>
                          <td colspan="3" align="center" class="diffMonth1"><?php echo $cashflowHistoricalData[0]->MONTH2;?></td>
                          <td colspan="3" align="center"><?php echo $cashflowHistoricalData[0]->MONTH3;?></td>
                      </tr>
                      <tr class="tableHeading1">
                          <td width="9%">Self</td>
                          <td width="10%">Affiliate</td>
                          <td width="9%" class="diffMonth">Total</td>
                          <td width="10%">Self</td>
                          <td width="10%">Affiliate</td>
                          <td width="8%" class="diffMonth">Total</td>
                          <td width="9%">Self</td>
                          <td width="10%">Affiliate</td>
                          <td width="9%">Total</td>
                      </tr>
                      <tr>
                          <td class="sideHeadingNormal">Cash In</td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN1_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN1_AFFILIATE;?></td>
                          <td class="diffMonth"><?php echo $cashflowHistoricalData[0]->CASH_IN1_TOTAL;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN2_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN2_AFFILIATE;?></td>
                          <td class="diffMonth"><?php echo $cashflowHistoricalData[0]->CASH_IN2_TOTAL;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN3_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN3_AFFILIATE;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_IN3_TOTAL;?></td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal">Cash Out</td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT1_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT1_AFFILIATE;?></td>
                          <td class="diffMonth"><?php echo $cashflowHistoricalData[0]->CASH_OUT1_TOTAL;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT2_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT2_AFFILIATE;?></td>
                          <td class="diffMonth"><?php echo $cashflowHistoricalData[0]->CASH_OUT2_TOTAL;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT3_SELF;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT3_AFFILIATE;?></td>
                          <td class="dataAmount"><?php echo $cashflowHistoricalData[0]->CASH_OUT3_TOTAL;?></td>
                      </tr>
                        <tr>
                          <td class="sideHeading">Pending</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="diffMonth">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="diffMonth">&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                      </tr>
                        <tr>
                          <td class="sideHeading">Percentage</td>
                          <td></td>
                          <td></td>
                          <td class="diffMonth"></td>
                          <td></td>
                          <td></td>
                          <td class="diffMonth"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                      </tr>
                  </table>                 
                </td>
                <!--<td width="30%" valign="top">
                <div class="iconwrap">
                        <div class="icon"><img src="<?php echo base_url();?>static/images/dashboard/icon-promo.png" width="55" height="40" /></div>
                        <div class="iconTxt">Promotion</div>
                  </div>          
                  <table width="100%" cellspacing="0" class="tableWrap" style="height:187px;" cellpadding="10">
                        <tr>
                          <td width="45%" class="sideHeadingNormal">Promotion</td>
                          <td width="28%" align="center">13</td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal">Registration</td>
                          <td align="center">42</td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal">Refer-a-Friend</td>
                          <td align="center">26</td>
                      </tr>
                        <tr>
                          <td class="sideHeadingNormal">Payment</td>
                          <td align="center">11</td>
                      </tr>
                  </table>                
                </td>-->
            </tr>
            <tr>
           	  <td>
                <div class="iconwrap">
                        <div class="icon"><img src="<?php echo base_url();?>static/images/dashboard/icon-games.png" width="55" height="40" /></div>
                        <div class="iconTxt">Games</div>
                  </div>                
                    <table width="100%" cellspacing="0" class="tableWrap" cellpadding="10">
                          <tr class="tableHeading">
                            <td width="30%">Name</td>
                            <td width="24%">Percentage(%)</td>
                            <td width="22%">User</td>
                            <td width="24%">Game Played</td>
                      </tr>
                          <tr>
                            <td class="sideHeadingNormal"><?php echo $gamesHistoricalData[0]->GAME1_NAME;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME1_PERCENTAGE;?></td>
                            <td><?php echo $gamesHistoricalData[0]->GAME1_USER;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME1_TIMESPLAYED;?></td>
                      </tr>
                          <tr>
                            <td class="sideHeadingNormal"><?php echo $gamesHistoricalData[0]->GAME2_NAME;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME2_PERCENTAGE;?></td>
                            <td><?php echo $gamesHistoricalData[0]->GAME2_USER;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME2_TIMESPLAYED;?></td>
                      </tr>
                          <tr>
                            <td class="sideHeadingNormal"><?php echo $gamesHistoricalData[0]->GAME3_NAME;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME3_PERCENTAGE;?></td>
                            <td><?php echo $gamesHistoricalData[0]->GAME3_USER;?></td>
                            <td align="center"><?php echo $gamesHistoricalData[0]->GAME3_TIMESPLAYED;?></td>
                      </tr>
                    </table>
                </td>
            </tr>
        </table>
        <?php } ?>
	</div>
</div>
</div> <!-- MainArea ends here->