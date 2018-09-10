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

<script language="javascript" type="application/javascript">

/* THIS IS TO ACTIVATE & DEACTIVATE USERS */
function activatedeaUser(curStatus,partnerID,newStatus) {
	
	if(curStatus == 1){
	if(confirm("Do you really want to unauthenticate this partner? If so all the details related to this partner will get unauthenticated"))
	{	
		xmlHttp=GetStateXmlHttpObject();
		if(xmlHttp==null) {
			alert ("Your browser does not support AJAX!");
			return;
		} 
		var url="<?php echo base_url();?>partner/partner/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus;
	
		//alert(url);
		xmlHttp.onreadystatechange=changeActivePartnerStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
  }else{
       xmlHttp=GetStateXmlHttpObject();
		if(xmlHttp==null) {
			alert ("Your browser does not support AJAX!");
			return;
		} 
		var url="<?php echo base_url();?>partner/partner/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus;
	
		//alert(url);
		xmlHttp.onreadystatechange=changeActivePartnerStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
  }
}

function changeActivePartnerStatus() { 
	if (xmlHttp.readyState==4) {
		var respValue = xmlHttp.responseText.split("_");
		document.getElementById('activatede_'+respValue[1]).innerHTML=respValue[0];
	}
}

function GetStateXmlHttpObject() {
	var xmlHttp=null;
	try {
  		// Firefox, Opera 8.0+, Safari
	    xmlHttp=new XMLHttpRequest();
  	} catch (e) {
		// Internet Explorer
	  	try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
  	}
	return xmlHttp;
}
</script>
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
$page = $this->uri->segment(3);
if(isset($page) && $page !='') {
	$j=$page;
} else {
	$j=0;
}  
 
foreach($partner_info as $index=>$partnerInfo) {
	$getParentPName = $this->partner_model->getParentPartnerName($partnerInfo->MPARTNER_ID); 
	$resValue[$index]['PARTNER_ID']        = $j+1;		
	$resValue[$index]['PARTNER_NAME']      = $partnerInfo->PARTNER_NAME;	
	$resValue[$index]['PARTNER_TYPE']      = $partnerInfo->PARTNER_TYPE;
	//$resValue[$index]['MPARTNER_ID']       = $getParentPName[0]->PARTNER_NAME;	
	$resValue[$index]['PARTNER_EMAIL']     = $partnerInfo->PARTNER_EMAIL;
	$resValue[$index]['AGENT_COMMISSION_TYPE'] = $partnerInfo->AGENT_COMMISSION_TYPE;
	$resValue[$index]['PARTNER_REVENUE_SHARE'] = $partnerInfo->PARTNER_REVENUE_SHARE;			
	if($partnerInfo->PARTNER_STATUS=="1")
		$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$partnerInfo->PARTNER_ID.',2)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';	
	else 
		$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(2,'.$partnerInfo->PARTNER_ID.',1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';	
		
	$resValue[$index]['ACTIONS']    			= '<a href="'.base_url().'partner/viewPartnerPlayers/'.$partnerInfo->PARTNER_ID.'?rid=23"><img height="16" width="16" src="'.base_url().'static/images/group.png" title="View Players"></a>&nbsp;&nbsp;&nbsp;<a href="'.base_url().'partner/viewPartnerAdmins/'.$partnerInfo->PARTNER_ID.'?rid=23"><img height="16" width="16" src="'.base_url().'static/images/administrator.png" title="View Admins"></a>&nbsp;&nbsp;&nbsp;<a href="'.base_url().'partner/editPartner/'.$partnerInfo->PARTNER_ID.'?rid=23"><img height="16" width="16" src="'.base_url().'static/images/edit-img.png" title="Edit"></a>';	
	$j++;
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
                	<td><strong>Search Partner</strong></td>
                </tr>
            </table>
            <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
                <tr>
                	<td width="40%">
                    	<?php 
							$attributes = array('id' => 'list-partners');
							echo form_open('partner/index?rid=23',$attributes);
						?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('Partner Type', 'PartnerType');?>:
                        </span><br />  
						<?php
							if(!empty($this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']))
								$PARTNER_TYPE_ID = $this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID'];	

                            echo '<select name="partnertype" id="partnertype" class="lstTextField">';
                            echo '<option value="" selected="selected">-- Select --</option>';
                            foreach($partnerTypes as $pType) {
								if($PARTNER_TYPE_ID == $pType->PARTNER_TYPE_ID)
									echo '<option value="'.$pType->PARTNER_TYPE_ID.'" selected="selected">'.$pType->PARTNER_TYPE.'</option>';
								else						
									echo '<option value="'.$pType->PARTNER_TYPE_ID.'">'.$pType->PARTNER_TYPE.'</option>';
                            }
                            echo '</select>';
                        ?>                                        
                    </td>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Partner Name', 'PartnerName');?>:
                        </span><br />                     
							<?php	
							if(!empty($this->session->userdata['partnerSearchData']['PARTNER_NAME']))
								$PARTNER_NAME = $this->session->userdata['partnerSearchData']['PARTNER_NAME'];	
								

								echo '<select name="partnername" id="partnername" class="lstTextField">';
								echo '<option value="0">-- Select --</option>';
								foreach($getOwnPartners as $partnersID) {
									if($partnersID->PARTNER_ID==$PARTNER_NAME)
										echo '<option value="'.$partnersID->PARTNER_ID.'" selected="selected">'.$partnersID->PARTNER_NAME.'</option>';									
									else
										echo '<option value="'.$partnersID->PARTNER_ID.'">'.$partnersID->PARTNER_NAME.'</option>';
								}
								echo '</select>';									
                            ?>                        
                    </td>                    
                    <td width="20%">&nbsp;</td>
                </tr>
                <tr>
					<td width="40%"> <?php $partnerC_status =  $this->session->userdata['partnerSearchData']['PARTNER_STATUS']; ?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('Status', 'PartnerStatus');?>:
                        </span><br />
						<?php
						/*	if(!empty($this->session->userdata['partnerSearchData']['PARTNER_STATUS']))
								$PARTNER_STATUS = $this->session->userdata['partnerSearchData']['PARTNER_STATUS'];	
														
                            echo '<select name="partnerstatus" id="partnerstatus" class="lstTextField">';	
							if($PARTNER_STATUS) {
								if($PARTNER_STATUS==1) {
									echo '<option value="1" selected="selected">ACTIVE</option>';
									echo '<option value="0">INACTIVE</option>';										
								} else {
									echo '<option value="1">ACTIVE</option>';
									echo '<option value="0" selected="selected">INACTIVE</option>';										
								}
							} else {*/ ?>
							
                            <select name="partnerstatus" id="partnerstatus" class="lstTextField">
							<option value="" selected="selected">--- Select ---</option>
							<option <?php if($partnerC_status == 1) echo 'selected="selected"'; ?>  value="1">ACTIVE</option>
							<option <?php if($partnerC_status == 2) echo 'selected="selected"'; ?> value="2">INACTIVE</option>							
						
						</select>
                        
                    </td>                 
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Partner Email', 'PartnerEmail');?>:
                        </span><br />                    
						<?php
							if(!empty($this->session->userdata['partnerSearchData']['PARTNER_EMAIL']))
								$PARTNER_EMAIL = $this->session->userdata['partnerSearchData']['PARTNER_EMAIL'];
																												
                            $PartnerEmail = array(
                                  'name'        => 'partneremail',
                                  'id'          => 'partneremail',	
								  'value'		=> $PARTNER_EMAIL,						  
								  'class'		=> 'TextField',								  
                                  'maxlength'   => '45'
                                );		
                            echo form_input($PartnerEmail);									
                        ?>                         
                    </td> 
                    <td width="20%">&nbsp;</td>                                      
                </tr> 
                <tr>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Start Date', 'StartDate');?>:
                        </span><br />
						<?php
							if(!empty($this->session->userdata['partnerSearchData']['CREATED_ON']))
								$START_DATE_TIME = date('d-m-Y',strtotime($this->session->userdata['partnerSearchData']['CREATED_ON']));
							else
								$START_DATE_TIME = "";	
																											
                            $startDate = array(
                                  'name'        => 'startdate',
                                  'id'          => 'startdate',
								  'value'		=> $START_DATE_TIME,
								  'class'		=> 'TextFieldDate',	
								  'readonly'	=> true,						  
                                  'maxlength'   => '12'			  
                                );
                            echo form_input($startDate);								
                        ?><a onclick="NewCssCal('startdate','ddmmyyyy','arrow',false,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a>                                            
                    </td>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('End Date', 'EndDate');?>:
                        </span><br />                     
						<?php
							if(!empty($this->session->userdata['partnerSearchData']['CREATED_ON_END_DATE']))
								$END_DATE_TIME = date('d-m-Y',strtotime($this->session->userdata['partnerSearchData']['CREATED_ON_END_DATE']));
							else
								$END_DATE_TIME = "";//date('d-m-Y');								
														
                            $endDate = array(
                                  'name'        => 'enddate',
                                  'id'          => 'enddate',	
								  'value'		=> $END_DATE_TIME,						  
								  'class'		=> 'TextFieldDate',	
								  'readonly'	=> true,								  							  
                                  'maxlength'   => '12'			  
                                );
                            echo form_input($endDate);								
                        ?><a onclick="NewCssCal('enddate','ddmmyyyy','arrow',false,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a> 
                    </td> 
                    <td width="20%">
                      <span class="TextFieldHdr">
                        <?php echo form_label('Date Range', 'range');?>:
                      </span><br />
                      
        
        <?php
		  $options = array(
                  '' => 'Select',
				  '1' => 'Today',
                  '2' => 'Yesterday',
                  '3' => 'This Week',
                  '4' => 'Last Week',
				  '5' => 'This Month',
				  '6' => 'Last Month',
                );
				$js = 'id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);"';
				 echo form_dropdown('SEARCH_LIMIT', $options, $this->session->userdata['partnerSearchData']['SEARCH_LIMIT'], $js);
		?>
                      
                      
                       </td>                                       
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
                if(!empty($searchResult) && !empty($partner_info)) {
                    //echo "<pre>";print_r($partner_info);die;?>
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
							<?php //if($this->session->userdata['partnerid']==1) { ?>
                            //colNames:['S.No', 'Partner Name', 'Partner Type','Parent Partner', 'Email','Commission Type','Commission (%)','Status','Action'],
							<?php //} else { ?>
                            colNames:['S.No', 'Partner Name', 'Partner Type', 'Email','Commission Type','Commission (%)','Status','Action'],							
							<?php //} ?>						
                            colModel:[
                                {name:'PARTNER_ID',index:'PARTNER_ID', width:40,sortable:false},
								{name:'PARTNER_NAME',index:'PARTNER_NAME', width:80}, 
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE', width:60},
								<?php //if($this->session->userdata['partnerid']==1) { ?> 
                                	//{name:'MPARTNER_ID',index:'MPARTNER_ID', width:80,sortable:false}, 								
								<?php //} ?>
								{name:'PARTNER_EMAIL',index:'PARTNER_EMAIL',width:90},
                                {name:'AGENT_COMMISSION_TYPE',index:'AGENT_COMMISSION_TYPE', width:80}, 
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',width:60},								
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:false}, 
                                {name:'ACTIONS',index:'ACTIONS', width:100, align:"center",sortable:false}, 							
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
			 if(empty($partner_info) && !empty($searchResult))  
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