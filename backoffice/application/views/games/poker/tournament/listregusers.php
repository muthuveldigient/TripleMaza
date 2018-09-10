<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>
<script language="javascript">
function NewWindow(mypage,myname,w,h,scroll){
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage,myname,settings);
}
</script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url();?>static/js/date.js" type="text/javascript"></script>
<script language="javascript" type="application/javascript">
function frmSubmit() {
	var stDate=document.getElementById("startdate").value;	
	var edDate=document.getElementById("enddate").value;
	
	if(compareDates(stDate.substring(0,10),'dd-MM-yyyy',edDate.substring(0,10),'dd-MM-yyyy')=="1"){
        alert("Start date should be lesser than end date");
        return false;
    } else {
		document.listWintypes.submit();
	}
}
function showdaterange(vid) {
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="1"){
              sdate='<?php echo date("d-m-Y ");?> 00:00:00';
              edate='<?php echo date("d-m-Y ");?> 23:59:59';
          }
          if(vid=="2"){
              <?php
              $yesterday=date('d-m-Y',strtotime("-1 days"));?>
              sdate='<?php echo $yesterday;?> 00:00:00';
              edate='<?php echo $yesterday;?> 23:59:59';
          }
          if(vid=="3"){
              
            
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?> 00:00:00';
              edate='<?php echo date("d-m-Y");?> 23:59:59';
          }
          if(vid=="4"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?> 00:00:00';
              edate='<?php echo $slastweekeday;?> 23:59:59';
          }
          if(vid=="5"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate="01-".$tmonth."-".$tyear;
              $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear;
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?> 00:00:00';
              edate='<?php echo $lday;?> 23:59:59';
          }
          if(vid=="6"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate=date("01-m-Y", strtotime("-1 month"));
              $lday=date("t-m-Y", strtotime("-1 month"));
              
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?> 00:00:00';
              edate='<?php echo $lday;?> 23:59:59';
          }
          document.getElementById("startdate").value=sdate;
          document.getElementById("enddate").value=edate;
      }
	}
function chkdatevalue() {
   if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy')==false){
        alert("Please enter the valid date");
        return false;
    }else{
       // alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy')=="1"){
        alert("Start date should be greater than end date");
        return false;
        }
        return true;
    }
   } 
}
</script>
<?php

	
	if(!empty($resultData)) {
		$i=0;
		$sno=1;
		foreach($resultData as $resultInfo) {
;
			$resValue[$i]["SNO"]    			= $sno;
			//$resValue[$i]["TOURNAMENT_NAME"]    = $getRegUsers["TOURNAMENT_NAME"];
			if($resultInfo[2] != "") {
				$resValue[$i]["USERNAME"]= '<a href="'.base_url().'user/account/detail/'.$resultInfo[1].'?rid=10">'.$resultInfo[2].'</a>';
			} else {
				$resValue[$i]["USERNAME"]= '-';
			}			
			
			$resValue[$i]["TICKET_CREATED_DATE"]= date('d/m/Y H:i:s',strtotime($resultInfo[3]));
			$resValue[$i]["REGISTERED_DATE"]    = $resultInfo[4];
			if(!empty($resultInfo[6]))
				$resValue[$i]["CONTACT"]            = $resultInfo[6];
			else
				$resValue[$i]["CONTACT"]            = "-";
				
			$resValue[$i]["EMAIL_ID"]           = $resultInfo[7];															
			$i++;
			$sno++;
		}
	}
	

?>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
		<?php if($this->session->flashdata('errormessage')) { ?>
            <table width="100%" class="ErrorMsg">
              <tbody>
              <tr>
                <td width="45"><img width="45" height="34" alt="" src="<?php echo base_url();?>static/images/icon-error.png"></td>
                <td width="95%"><?php echo $this->session->flashdata('errormessage');?></td>
               </tr>
              </tbody>
             </table>
        <?php } ?> 
		<?php 
		if($this->session->flashdata('message')) { ?>
            <table width="100%" class="SuccessMsg">
              <tbody>
              <tr>
                <td width="45"><img width="45" height="34" alt="" src="<?php echo base_url();?>static/images/icon-success.png"></td>
                <td width="95%"><?php echo $this->session->flashdata('message');?></td>
               </tr>
              </tbody>
             </table>
        <?php } ?>
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> 
	  <?php } ?>             
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Tournament User Ticket</strong></td>
                </tr>
            </table>
            <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10"> 
                <tr>                   
                    <td width="25%">
					<?php 
                        $attributes = array('name' => 'listWintypes','id' => 'listWintypes');
                        echo form_open('games/poker/tournament/getregisteredusers?rid=73',$attributes);
                    ?>                      
                      <span class="TextFieldHdr">
                        <?php echo form_label('Tournament Name', 'tournament_name');?>:
                      </span><br />
					<?php
					if(!empty($this->session->userdata['regusersSearchData']['TOURNAMENT_ID']))
						$TOURNAMENT_ID=$this->session->userdata['regusersSearchData']['TOURNAMENT_ID'];
					else
						$TOURNAMENT_ID="";
					
					$tourNamesLisit=array();						
					if(!empty($tournamentNames)) {
						foreach($tournamentNames as $tourIndex=>$tournamentNames) {
							$tourNamesLisit[$tournamentNames->TOURNAMENT_ID] .= $tournamentNames->TOURNAMENT_NAME;
						}	
					}
					$js1 = 'id="TOURNAMENT_ID" class="ListMenu"';		
					echo form_dropdown('TOURNAMENT_ID', $tourNamesLisit,$TOURNAMENT_ID,$js1);
                    ?>
					</td>
                    <td width="75%">&nbsp;</td>                                       
                </tr> 
                <tr>
                	<td colspan="3">
						<?php
							echo form_submit('frmSearch', 'Search','')."&nbsp;";
							echo form_submit('frmClear', 'Clear');
                            echo form_close();							
						?>                    
                    </td>
                </tr>                                            
            </table>               
	    <div class="tableListWrap">
      		<div class="data-list">           
            	<?php
                if(!empty($searchResult) && !empty($resValue)) {
               ?>
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
                            colNames:['S.No','User Name', 'Ticket Created Date','Registered Date','Contact','Email'],							
                            colModel:[
                                {name:'SNO',index:'SNO', width:15,align:"center",sortable:false},
                                //{name:'TOURNAMENT_NAME',index:'TOURNAMENT_NAME', width:60,sortable:false,align:"center"},							
                                {name:'USERNAME',index:'USERNAME', width:45,align:"center"},
								{name:'TICKET_CREATED_DATE',index:'TICKET_CREATED_DATE', width:40,sortable:false,align:"center"}, 
                                {name:'REGISTERED_DATE',index:'REGISTERED_DATE', width:40,sortable:false,align:"center"},
                                {name:'CONTACT',index:'CONTACT', width:45,sortable:false,align:"center"},
								{name:'EMAIL_ID',index:'EMAIL_ID', width:70,align:"center"} 							
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
                </script>
                <div class="page-wrap">
                  <div class="pagination">
                    <?php	echo $pagination; ?>
                  </div>
                </div>
               <?php } else { 
               		$message = "Please select the search criteria";
               } 
			 if(empty($resValue) && !empty($searchResult))  
			 	$message = "There is no record to display";
			 if(!empty($message)) {?> 
            <table id="list4" class="data">
              <tr>
                <td>
                	<img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span>
                 </td>
              </tr>
            </table>               
           	<?php } ?>
            </div>
        </div>                           
        </div>
        </div>
    </div>
</div>
<?php $this->load->view("common/footer"); ?>	