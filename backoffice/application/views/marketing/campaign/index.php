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
<script language="javascript" type="text/javascript">
function clearFrmValues() {
	$('#list-campaign').each(function() {
	  this.reset();
	});	
}

$(document).ready(function () {
	<?php
		if($this->session->flashdata('message')) {
	?>	
		$('.statusMessage').delay(2000).fadeOut('slow');
	<?php } ?>
});

/* THIS IS TO ACTIVATE & DEACTIVATE USERS */
function activatedeaUser(curStatus,campaignID,newStatus) {
    if(curStatus==1){
        if(confirm("Do you really want to unauthenticate this Admin? If so all the details related to this Admin will get unauthenticated")){
	xmlHttp=GetStateXmlHttpObject();
	if(xmlHttp==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url();?>marketing/campaign/campaign/changeCampaignStatus/"+curStatus+"/"+campaignID+"/"+newStatus;

	//alert(url);
	xmlHttp.onreadystatechange=changeCampaignStatus;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);            
        }
    }else{
	xmlHttp=GetStateXmlHttpObject();
	if(xmlHttp==null) {
  		alert ("Your browser does not support AJAX!");
		return;
  	} 
	var url="<?php echo base_url();?>marketing/campaign/campaign/changeCampaignStatus/"+curStatus+"/"+campaignID+"/"+newStatus;

	//alert(url);
	xmlHttp.onreadystatechange=changeCampaignStatus;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}
}

function changeCampaignStatus() { 
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
$page = $this->uri->segment(4);
if(isset($page) && $page !='') {
	$j=$page;
} else {
	$j=0;
} 

foreach($campaign_info as $index=>$campaignDetail) {
	$resValue[$index]['PROMO_CAMPAIGN_ID']  = $j+1;	
	$resValue[$index]['PROMO_CAMPAIGN_TYPE']= $campaignDetail->PROMO_CAMPAIGN_TYPE;	
	$resValue[$index]['PROMO_CAMPAIGN_CODE']= $campaignDetail->PROMO_CAMPAIGN_CODE;
	$resValue[$index]['PROMO_CAMPAIGN_NAME']= $campaignDetail->PROMO_CAMPAIGN_NAME;
	$resValue[$index]['NoOfClicks']         = "";
	$resValue[$index]['RegUser']            = "";
	$resValue[$index]['PROMO_STATUS_ID']    = $campaignDetail->PROMO_STATUS_ID;
	if($campaignDetail->PROMO_STATUS_ID=="1")
		$resValue[$index]['PROMO_STATUS_ID']    = '<span id="activatede_'.$campaignDetail->PROMO_CAMPAIGN_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$campaignDetail->PROMO_CAMPAIGN_ID.',2)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';	
	else 
		$resValue[$index]['PROMO_STATUS_ID']    = '<span id="activatede_'.$campaignDetail->PROMO_CAMPAIGN_ID.'"><a href="#" onclick="javascript:activatedeaUser(2,'.$campaignDetail->PROMO_CAMPAIGN_ID.',1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';
			
	$resValue[$index]['ACTIONS']    			= '<a href="'.base_url().'marketing/campaign/campaign/viewCampaign/'.$campaignDetail->PROMO_CAMPAIGN_ID.'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )"><img height="16" width="16" src="'.base_url().'static/images/info.png" title="view"></a>';	
	$j++;
}
?>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']);?> <br/> <?php } ?>            
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>Search Campaign</strong></td>
                </tr>
            </table>
            <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
                <tr>
                	<td width="40%">
                    	<?php 
							$attributes = array('id' => 'list-campaign');
							echo form_open('marketing/campaign/index?rid=37',$attributes);
						?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('Campaign Type', 'CampaignType');?>:
                        </span><br />  
						<?php
							if(!empty($this->session->userdata['searchData']['PROMO_CAMPAIGN_TYPE_ID']))
								$PROMO_CAMPAIGN_TYPE_ID = $this->session->userdata['searchData']['PROMO_CAMPAIGN_TYPE_ID'];						

                            echo '<select name="campaigntype" id="CampaignType" class="lstTextField">';
                            echo '<option value="" selected="selected">-- Select --</option>';
                            foreach($campaign_types as $campType) {								
								if($PROMO_CAMPAIGN_TYPE_ID==$campType->PROMO_CAMPAIGN_TYPE_ID)
	                            	echo '<option value="'.$campType->PROMO_CAMPAIGN_TYPE_ID.'" selected="selected">'.$campType->PROMO_CAMPAIGN_TYPE.'</option>';
								else
									echo '<option value="'.$campType->PROMO_CAMPAIGN_TYPE_ID.'">'.$campType->PROMO_CAMPAIGN_TYPE.'</option>';
                            }
                            echo '</select>';
                        ?>                                        
                    </td>
					<td width="40%"><?php $campaignP_status = $this->session->userdata['searchData']['PROMO_STATUS_ID']; ?>
                        <span class="TextFieldHdr">
                            <?php echo form_label('Status', 'CampaignStatus');?>:
                        </span><br />
						<?php
			    /*			if(!empty($this->session->userdata['searchData']['PROMO_STATUS_ID']))
								$PROMO_STATUS_ID = $this->session->userdata['searchData']['PROMO_STATUS_ID'];						
								
                            echo '<select name="campaignstatus" id="campaignstatus" class="lstTextField">';		
                            foreach($campaign_status as $campStatus) {																
								if($PROMO_STATUS_ID==$campStatus->PROMO_STATUS_ID)
                                	echo '<option value="'.$campStatus->PROMO_STATUS_ID.'" selected="selected">'.$campStatus->PROMO_STATUS_DESC.'</option>';
								else
                                	echo '<option value="'.$campStatus->PROMO_STATUS_ID.'">'.$campStatus->PROMO_STATUS_DESC.'</option>';
                            } */	?>
                            <select name="campaignstatus" id="campaignstatus" class="lstTextField">                                                
							<option value="" selected="selected">--- Select ---</option>
							<option <?php if($campaignP_status == 1) echo 'selected="selected"'; ?>  value="1">ACTIVE</option>
							<option <?php if($campaignP_status == 2) echo 'selected="selected"'; ?> value="2">INACTIVE</option>							
						
						</select>                                            
                    </td>
                    <td width="20%">&nbsp;</td>
                </tr>
                <tr>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Campaign Name', 'CampaignName');?>:
                        </span><br />                     
							<?php
								if(!empty($this->session->userdata['searchData']['PROMO_CAMPAIGN_NAME']))
									$PROMO_CAMPAIGN_NAME = $this->session->userdata['searchData']['PROMO_CAMPAIGN_NAME'];
																
                                $CampaignName = array(
                                      'name'        => 'campaignname',
                                      'id'          => 'campaignname',
									  'value'		=> $PROMO_CAMPAIGN_NAME,									  
									  'class'		=> 'TextField',
                                      'maxlength'   => '75',
                                      'width'		=> '85'
                                    );		
                                echo form_input($CampaignName);									
                            ?>                        
                    </td>                 
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('Campaign Code', 'CampaignCode');?>:
                        </span><br />                    
						<?php
							if(!empty($this->session->userdata['searchData']['PROMO_CAMPAIGN_CODE']))
								$PROMO_CAMPAIGN_CODE = $this->session->userdata['searchData']['PROMO_CAMPAIGN_CODE'];
															
                            $CampaignCode = array(
                                  'name'        => 'campaigncode',
                                  'id'          => 'campaigncode',
								  'value'		=> $PROMO_CAMPAIGN_CODE,								  
								  'class'		=> 'TextField',								  
                                  'maxlength'   => '10'
                                );		
                            echo form_input($CampaignCode);									
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
							if(!empty($this->session->userdata['searchData']['START_DATE_TIME']))
								$START_DATE_TIME = date('d-m-Y',strtotime($this->session->userdata['searchData']['START_DATE_TIME']));	
							else
								$START_DATE_TIME = ""; //date('d-m-Y');
													
                            $startDate = array(
                                  'name'        => 'startdate',
                                  'id'          => 'startdate',
								  'value'		=> $START_DATE_TIME,
								  'class'		=> 'TextFieldDate',	
								  'readonly'	=> true,								  							  
                                  'maxlength'   => '100'			  
                                );
                            echo form_input($startDate);								
                        ?><a onclick="NewCssCal('startdate','ddmmyyyy','arrow',false,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a>                                            
                    </td>
                	<td width="40%">
                        <span class="TextFieldHdr">
                            <?php echo form_label('End Date', 'EndDate');?>:
                        </span><br />                     
						<?php
							if(!empty($this->session->userdata['searchData']['END_DATE_TIME']))
								$END_DATE_TIME = date('d-m-Y',strtotime($this->session->userdata['searchData']['END_DATE_TIME']));
							else
								$END_DATE_TIME = "";  //date('d-m-Y');														
                            $endDate = array(
                                  'name'        => 'enddate',
                                  'id'          => 'enddate',
								  'value'		=> $END_DATE_TIME,								  
								  'class'		=> 'TextFieldDate',
								  'readonly'	=> true,								  								  
                                  'maxlength'   => '100'			  
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
            
	            <?php if(!empty($searchResult) && !empty($campaign_info)) { ?>
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
                            colNames:['S.No','Campaign Type', 'Campaign Code', 'Campaign Name', 'No.Of Clicks','Reg.User','Status','Action'],
                            colModel:[
                                {name:'PROMO_CAMPAIGN_ID',index:'PROMO_CAMPAIGN_ID', width:40,sortable:false},
								{name:'PROMO_CAMPAIGN_TYPE',index:'PROMO_CAMPAIGN_TYPE', width:100}, 
                                {name:'PROMO_CAMPAIGN_CODE',index:'PROMO_CAMPAIGN_CODE', width:80}, 
                                {name:'PROMO_CAMPAIGN_NAME',index:'PROMO_CAMPAIGN_NAME', width:150}, 
                                {name:'NoOfClicks',index:'NoOfClicks', width:50}, 
                                {name:'RegUser',index:'RegUser', width:50}, 
                                {name:'PROMO_STATUS_ID',index:'PROMO_STATUS_ID', width:70, align:"center",sortable:false},
                                {name:'ACTIONS',index:'ACTIONS', width:40, align:"center",sortable:false} 							
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
			 if(empty($campaign_info) && !empty($searchResult))  
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