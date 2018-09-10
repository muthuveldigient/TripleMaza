<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script>
function showdaterange(vid)
    {
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="1"){
              sdate='<?php echo date("d-m-Y ");?>';
              edate='<?php echo date("d-m-Y ");?>';
          }
          if(vid=="2"){
              <?php
              $yesterday=date('d-m-Y',strtotime("-1 days"));?>
              sdate='<?php echo $yesterday;?>';
              edate='<?php echo $yesterday;?>';
          }
          if(vid=="3"){
              
            
              <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>';
              edate='<?php echo date("d-m-Y");?>';
          }
          if(vid=="4"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?>';
              edate='<?php echo $slastweekeday;?>';
          }
          if(vid=="5"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate="01-".$tmonth."-".$tyear;
              $lday=date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear;
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          if(vid=="6"){
              <?php
              $tmonth=date("m");
              $tyear=date("Y");
              $tdate=date("01-m-Y", strtotime("-1 month"));
              $lday=date("t-m-Y", strtotime("-1 month"));
              
              //$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
              ?>
              sdate='<?php echo $tdate;?>';
              edate='<?php echo $lday;?>';
          }
          document.getElementById("startdate").value=sdate;
          document.getElementById("enddate").value=edate;
      }
      
        
    }
function chkdatevalue()
{
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
$message = "";
$j=0; 
if(!empty($getUserTickets)) {
	foreach($getUserTickets as $tIndex=>$userTickets) {
		$resValue[$tIndex]['SNO']     = $j+1;
		$resValue[$tIndex]['USERNAME']= $userTickets->USER_ID;	
		$resValue[$tIndex]['MESSAGE'] = $userTickets->MESSAGE;
		if($userTickets->STATUS==1)
			$resValue[$tIndex]['STATUS']  = "New";
			
		if($userTickets->STATUS==2)
			$resValue[$tIndex]['STATUS']  = "In Progress";		
			
		if($userTickets->STATUS==3)
			$resValue[$tIndex]['STATUS']  = "Reopen";
					
		$resValue[$tIndex]['RDATE']   = date('d-m-Y h:i:s',strtotime($userTickets->REPORTING_DATE));
		$resValue[$tIndex]['ACTION']  = "";	
		$j++;
	}
}
?>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Search Tickets</strong></td>
                </tr>
            </table>
            <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
                <tr>
                	<td width="40%">
                    	<?php 
							$attributes = array('id' => 'list-tickets');
							echo form_open('general/tickets/index?rid=46',$attributes);
						?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('Ticket Type', 'TicketType');?>:
                        </span><br />  
						<?php
                            echo '<select name="ticketType" id="ticketType" class="lstTextField">';
                            echo '<option value="" selected="selected">-- Select --</option>';
                            foreach($getTicketStatus as $tIndex=>$tType) {	
								echo '<option value="'.$tIndex.'">'.$tType.'</option>';
                            }
                            echo '</select>';
                        ?>                                        
                    </td>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('User Name', 'UserName');?>
                        </span>
                        <?php
                            $UserName = array(
                                  'name'        => 'username',
                                  'id'          => 'username',
                                  'class'		=> 'TextField',												  
                                  'maxlength'   => '55'
                                );		
                            echo form_input($UserName);			
                        ?>                       
                    </td>                    
                    <td width="20%">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="3">
						<?php 
							echo form_submit('frmSearch', 'Search')."&nbsp;";
							echo form_submit('frmClear', 'Clear');
                            echo form_close();							
						?>                    
                    </td>
                </tr>                                            
            </table>
        
	    <div class="tableListWrap">
	  <div class="data-list">
           
            	<?php //echo "<pre>";print_r($partner_info);die;
                if(!empty($searchResult) && !empty($getUserTickets)) {
                    //echo "<pre>";print_r($partner_info);die;?>
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            colNames:['S.No', 'User Name', 'Message', 'Status','Date','Action'],							
                            colModel:[
                                {name:'SNO',index:'SNO', width:20,sortable:false},
								{name:'USERNAME',index:'USERNAME',width:90},
                                {name:'MESSAGE',index:'MESSAGE', width:110}, 
								{name:'STATUS',index:'STATUS',width:40},								
                                {name:'RDATE',index:'RDATE', width:60, align:"center",sortable:false}, 
                                {name:'ACTION',index:'ACTION', width:60, align:"center",sortable:false}, 							
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
			 if(empty($getUserTickets) && !empty($searchResult))  
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