
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
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
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
        <form action="<?php echo base_url(); ?>reports/turnover_report/index?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
              
              <tr>
                <td width="30%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP echo $START_DATE_TIME; ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="30%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP echo $END_DATE_TIME;?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($SEARCH_LIMIT) && $SEARCH_LIMIT=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
			
			  <td width="20%"><span class="TextFieldHdr">Affiliates:</span><br />
                  <label>
                  <select name="AGENT_LIST" id="AGENT_LIST" class="ListMenu">
					<option value="">All</option>
                    <?php
					
					foreach($all_agent_result as $key=>$val){       ?>     
					<option value="<?php echo $val['PARTNER_ID'];?>" <?php if($AGENT_LIST==$val['PARTNER_ID']){ echo "selected";}?>><?php echo $val['PARTNER_USERNAME'];?></option>     
					<?php      }        ?>
                  </select>
                  </label>
                </td>
				<!--<td width="10%"><span class="TextFieldHdr">Games Type:</span><br />
					<input type="radio" name="GAMES_TYPE" value="" <?php //if($GAMES_TYPE=="all" || $GAMES_TYPE=="") echo 'checked="checked"'; ?>> All
					<input type="radio" name="GAMES_TYPE" value="pc" <?php //if($GAMES_TYPE=="pc"){ echo 'checked="checked"';}?>> PC
					<input type="radio" name="GAMES_TYPE" value="mobile" <?php //if($GAMES_TYPE=="mobile"){ echo 'checked="checked"';}?>> Mobile
                </td>-->
				<td width="20%"><span class="TextFieldHdr">Games Type</span><br />
					<select name="PARTNER_TYPE" id="PARTNER_TYPE" class="ListMenu">
						<option <?php if($GAMES_TYPE=="all" || $GAMES_TYPE=="") echo 'selected="selected"'; ?> value="">ALL</option>
						<option value="pc" <?php if($GAMES_TYPE=="pc"){ echo 'selected="selected"';}?>>PC</option>     
						<option value="mobile" <?php if($GAMES_TYPE=="mobile"){ echo 'selected="selected"';}?>>MOBILE</option>     

					</select>
				</td>
				
				<td width="20%"><span class="TextFieldHdr">Partner Type</span><br />
					<select name="PARTNER_TYPE" id="PARTNER_TYPE" class="ListMenu">
						<option value="">Select</option>
						<?php foreach($partner_type_array  as $key=>$val){ ?>
						<option value="<?php echo $val;?>" <?php if($PARTNER_TYPE==$val){ echo "selected";}?>><?php echo $key;?></option>     
						<?php }?>
					</select>
				</td>
              </tr>
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </form>
        </td>
        <td><form action="<?php echo base_url();?>reports/turnover_report/index?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
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
    $resvalues=array();

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
					$resvalue['PARTNER']= '<a href="'.base_url().'reports/turnover_report/partnerdetails/'.$res->AGENT_ID.'?rid='.$rid.'&sdate='.$START_DATE_TIME.'&edate='.$END_DATE_TIME.'&AGENT_LIST='.$AGENT_LIST.'&GAMES_TYPE='.$GAMES_TYPE.'&PARTNER_TYPE='.$PARTNER_TYPE.'&keyword=Search">'.$partnername.'</a>';
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
					}
				}
			}else{
            	$arrs="";
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
					}
				}
			}

		if(isset($arrs) && $arrs!=''){
			echo $this->load->view("reports/grid1",$arrs); 
		}else{ 
		   if(!empty($TITLE1)){
		    $message  = "There are currently no records found in this search criteria.";
		  
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
        <?php } }
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
        ?>
      </div>
    </div>
  </div>
</div>
<?php echo $this->load->view("common/footer"); ?>