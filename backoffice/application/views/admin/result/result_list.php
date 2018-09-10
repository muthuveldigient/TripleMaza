<?php //error_reporting(0); ?>
<script language="javascript">
	$(document).ready(function() {
		$('#reset_form').click(function() {
			window.location.href = '<?php echo base_url(); ?>admin/draw/result_list';
		});
	});
	
	// Changing the dates as per selection.
	function showdaterange( vid ) {
		if( vid != '' ) {
			var sdate = '';
			var edate = '';
			if( vid == "1" ) {
			  sdate = '<?php echo date("d-m-Y 00:00:00");  ?>';
			  edate = '<?php echo date("d-m-Y 23:59:59");  ?>';
			}
			if( vid == "2" ) {
			  <?php
			  $yesterday = date('d-m-Y',strtotime("-1 days")); ?>
			  sdate = '<?php echo $yesterday;?>'+' 00:00:00';
			  edate = '<?php echo $yesterday;?>'+' 23:59:59';
			}
			if( vid == "3" ) {
			  <?php
			  $sweekday = date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60)); ?>
			  sdate 	= '<?php echo $sweekday;?>'+' 00:00:00';
			  edate 	= '<?php echo date("d-m-Y");?>'+' 23:59:59';
			}
			if( vid == "4" ) {
			 <?php
			  $sweekday 	 = date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
			  $slastweekday  = date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
			  $slastweekeday = date("d-m-Y",strtotime($slastweekday)+(6*24*60*60)); ?>
			  sdate 		 = '<?php echo $slastweekday;?>'+' 00:00:00';
			  edate 		 = '<?php echo $slastweekeday;?>'+' 23:59:59';
			}
			if( vid == "5" ) {
			  <?php
			  $tmonth = date("m");
			  $tyear  = date("Y");
			  $tdate  = "01-".$tmonth."-".$tyear." 00:00:00";
			  $lday   = date('t',strtotime(date("d-m-Y")))."-".$tmonth."-".$tyear." 23:59:59"; ?>
			  sdate   = '<?php echo $tdate;?>';
			  edate   = '<?php echo $lday;?>';
			}
			if( vid == "6" ) {
			  <?php
			  $tmonth = date("m");
			  $tyear  = date("Y");
			  $tdate  = date("01-m-Y", strtotime("-1 month"))." 00:00:00";
			  $lday   = date("t-m-Y", strtotime("-1 month"))." 23:59:59"; ?>
			  sdate   = '<?php echo $tdate;?>';
			  edate   = '<?php echo $lday;?>';
			}
			document.getElementById("START_DATE_TIME").value = sdate;
			document.getElementById("END_DATE_TIME").value   = edate;
		}
	}
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>

<?php 
	$message  = '';
	$resValue = array();

	if( !empty( $result_list ) && !empty( $result_data ) ) {

		foreach( $result_list as $index => $list ) {
			$resValue[$index]['DRAW_DATETIME']	= date('d-m-Y H:i:s',strtotime($list->DRAW_STARTTIME));
			$resValue[$index]['TICKET_NUMBER']	= $list->DRAW_WINNUMBER;
			$resValue[$index]['DRAW_NAME']		= $list->DRAW_NAME;
			$resValue[$index]['UPDATED_DATE']	= date('d-m-Y H:i:s',strtotime($list->UPDATED_DATE));
			$url= base_url().'admin/draw/deletedraw/'.$list->DRAW_ID;
			$resValue[$index]['Action']			= '<a href ="'.$url.'">Delete </a>';
		}
	}
	// echo '<pre>'; print_r($resValue); exit;
?>

<div class="MainArea"> 
  <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Result List</strong></td>
          </tr>
        </table>
		<?php if ($this->session->flashdata('result')!='') {
			$message = $this->session->flashdata('result');
		?>
			<script type="application/javascript">
				$(".UpdateMsgWrap").show();
				window.setTimeout(function() {
					$(".UpdateMsgWrap").hide();
				}, 4000);
			</script>
			<div class="UpdateMsgWrap ticket_message">
				<table width="100%" class="<?php echo $message['class'] ?>">
					<tbody>
						<tr>
							<td width="95%"><?php echo $message['message']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php } ?>
        <form action="<?php echo base_url(); ?>admin/draw/result_list_search" method="post" name="list_result" id="list_result">
            <table width="100%" cellpadding="10" cellspacing="10" class="searchWrap">
				<!--<tr>
					<td width="40%">
						<span class="TextFieldHdr">Ticket Number:</span><br />
						<label>
							<?php //$userName = ( $this->session->userdata['keywords']['TICKET_NUMBER'] != '' ) ? $this->session->userdata['keywords']['TICKET_NUMBER'] : ''; ?>
							<input type="text" name="TICKET_NUMBER" id="TICKET_NUMBER" class="TextField" value="<?PHP echo $userName; ?>" >
						</label>
					</td>
				</tr>-->
				<tr>
					<td width="40%">
						<span class="TextFieldHdr">From:</span><br />
						<label>
						<?php $START_DATE_TIME = ( $this->session->userdata['keywords']['START_DATE_TIME'] != '' ) ? $this->session->userdata['keywords']['START_DATE_TIME'] : ''; ?>
						<input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; }else{ echo date("d-m-Y 00:00:00");} ?>">
						</label>
						<a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
					</td>
					<td width="40%">
						<span class="TextFieldHdr">To:</span><br />
						<label>
						<?php $END_DATE_TIME = ( $this->session->userdata['keywords']['END_DATE_TIME'] != '' ) ? $this->session->userdata['keywords']['END_DATE_TIME'] : ''; ?>
						<input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }else{ echo date("d-m-Y 23:59:59");}?>">
						</label>
						<a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a>
					</td>
					<td width="20%">
						<span class="TextFieldHdr">Date Range:</span><br />
						<label>
							<?php $SEARCH_LIMIT = ( $this->session->userdata['keywords']['SEARCH_LIMIT'] != '' ) ? $this->session->userdata['keywords']['SEARCH_LIMIT'] : ''; ?>
							<select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
							<option value="">Select</option>
							<option value="1" <?php if($SEARCH_LIMIT=="1"){ echo "selected";}?>>Today</option>
							<option value="2" <?php if($SEARCH_LIMIT=="2"){ echo "selected";}?>>Yesterday</option>
							<option value="3" <?php if($SEARCH_LIMIT=="3"){ echo "selected";}?>>This Week</option>
							<option value="4" <?php if($SEARCH_LIMIT=="4"){ echo "selected";}?>>Last Week</option>
							<option value="5" <?php if($SEARCH_LIMIT=="5"){ echo "selected";}?>>This Month</option>
							<option value="6" <?php if($SEARCH_LIMIT=="6"){ echo "selected";}?>>Last Month</option>
							</select>
						</label>
					</td>
					<td width="20%">&nbsp;</td>
				</tr>
				<tr>
					<td>
						<input name="formSearch" type="submit"  id="submit_form" value="Search" />&nbsp;&nbsp;&nbsp;
						<input name="reset" type="button" id="reset_form" value="Clear"  />
					</td>
				</tr>
        	</table>
        </form>

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
            <?php 
            if( !empty( $result_list ) && !empty( $result_data ) ) { 
            ?>
	            <table id="list2" class="data">
	            </table>
	            <div id="pager3"></div>
	            <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        		<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        		<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	            <script type="text/javascript">

	                jQuery("#list2").jqGrid({
	                    datatype: "local",
	                    colNames:['Draw Date Time','Draw Name', 'Win Number', 'Date','Action'],
						colModel:[
							{name:'DRAW_DATETIME',index:'DRAW_DATETIME',align:"left", width:80,sortable:true},
							{name:'DRAW_NAME',index:'DRAW_NAME',align:"left", width:160,sortable:true},
							{name:'TICKET_NUMBER',index:'TICKET_NUMBER',align:"left", width:160,sortable:true},
							{name:'UPDATED_DATE',index:'UPDATED_DATE',align:"left", width:160,sortable:true},
							{name:'Action',index:'Action',align:"center", width:50,sortable:true}
						],
	                    rowNum:500,
	                    width: 999, height: "100%"
	                });
	                var mydata = <?php echo json_encode($resValue); ?>;
	                for( var i = 0; i <= mydata.length; i++ )
	                    jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);

	            </script>
	            <div class="page-wrap">
	              <div class="pagination">
	                <?php echo $pagination; ?>
	              </div>
	            </div>
            <?php 
        	}

			if( empty($result_list) || empty( $result_data ) ) {
			 	$message = "There is no record to display. Please select the search criteria";
			}

			if( !empty($message) ) { ?>
	            <table id="list4" class="data">
	              <tr>
	                <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span> </td>
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