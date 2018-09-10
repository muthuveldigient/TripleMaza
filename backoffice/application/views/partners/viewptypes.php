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
<script language="javascript" type="application/javascript">
/* THIS IS TO ACTIVATE & DEACTIVATE USERS */
function activatedeaUser(curStatus,partnerID,newStatus,pType) {	
	if(curStatus == 1){
	if(confirm("Do you really want to unauthenticate this partner? If so all the details related to this partner will get unauthenticated"))
	{	
		xmlHttp=GetStateXmlHttpObject();
		if(xmlHttp==null) {
			alert ("Your browser does not support AJAX!");
			return;
		} 
		var url="<?php echo base_url();?>partners/partners/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus+"/"+pType;			
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
		var url="<?php echo base_url();?>partners/partners/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus+"/"+pType;		
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
<?php
$page = $this->uri->segment(3);
if(isset($page) && $page !='') {
	$j=$page;
} else {
	$j=0;
}  
$i=1; 

foreach($viewPartnerInfo as $index=>$partnerInfo) {	

	//$encPartnerId = $this->encrypt->encode($partnerInfo->PARTNER_ID);
	$encPartnerId = base64_encode($partnerInfo->PARTNER_ID);
	$resValue[$index]['PARTNER_USERNAME']        = '<a href="'.base_url().'partners/partners/editPartner/'.$encPartnerId.'?rid=51">'.$partnerInfo->PARTNER_NAME.'</a>';	
	$resValue[$index]['PARTNER_REVENUE_SHARE'] = $partnerInfo->PARTNER_REVENUE_SHARE;
	$resValue[$index]['PARTNER_COMMISSION_TYPE'] = $this->partner_model->getCommissionIdByName($partnerInfo->PARTNER_COMMISSION_TYPE);			
	$resValue[$index]['PARTNER_BALANCE']      = $this->partner_model->getPartnerBalance($partnerInfo->PARTNER_ID);	
	$resValue[$index]['PARTNER_CREATED_ON'] = $partnerInfo->PARTNER_CREATED_ON;						
	if(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=="0") {	
	/*$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewPartnerPlayers/'.$partnerInfo->PARTNER_ID.'?rid=7">View Dist</a>';
	$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewPartnerPlayers/'.$partnerInfo->PARTNER_ID.'?rid=7">View Sub.dist</a>';
	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewPartnerPlayers/'.$partnerInfo->PARTNER_ID.'?rid=7">View Agents</a>';*/
} else if(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=='11') {        
	$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/15?rid=51&ty=15">View Dist.</a>';
	/* $resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/12?rid=51&ty=12">View Dist.</a>';
	$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=13">View Sub.dist</a>';
	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=14">View Agents</a>'; */
}else if(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=='15') {                           						
	$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/12?rid=51&ty=12">View Dist.</a>';
	$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=13">View Sub.dist</a>';
	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=14">View Agents</a>';
} else if(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=='12') { 						
	$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=13">View Sub.dist</a>';
	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=14">View Agents</a>';
} else if(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=='13') {		
	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=14">View Agents</a>';
} elseif(!empty($partnerInfo->FK_PARTNER_TYPE_ID) && $partnerInfo->FK_PARTNER_TYPE_ID=='14') {	
	$resValue[$index]['VIEWU']      = '<a href="'.base_url().'partners/partners/viewPartnerPlayers/'.$encPartnerId.'?rid=51">View Users</a>';
} 
if($partnerInfo->PARTNER_STATUS=="1")
		$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$partnerInfo->PARTNER_ID.',0,-1)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';	
	else 
		$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(0,'.$partnerInfo->PARTNER_ID.',1,-1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';	
	$j++;
}
?>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
        <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?>
        <br/>
        <br/>
        <br/>
        <br/>
        <?php } ?>
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>
              <?PHP 			  											
                        if($_GET['ty']=="0") {
                        $type="Players";
                        } else if($_GET['ty']=="1") {                           
                        $type="Main Agent";						
                        } else if($_GET['ty']=="2") { 					
                        $type="Distributor";
                        } else if($_GET['ty']=="3") {
                        $type="Sub.Distributor";
                        } elseif($_GET['ty']=="4")  {
                        $type="Agent";
                        }elseif($_GET['ty']=="5")  {
                       	 $type="Super Distributor";
                        }
						if($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID!="")
							echo $type ." List";		
						else
							echo $type=$type." No List";
                        ?>
              </strong></td>
          </tr>
        </table>
        <div class="tableListWrap">
          <div class="data-list">
            <?php if(!empty($viewPartnerInfo)) {
			 
			?>
            <table id="list2">
            </table>
            <div id="pager2"></div>
            <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",														
							<?php if($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="0") { ?>
                           // colNames:['Partner Type', 'Margin (%)', 'Points', 'Status','View', 'View','View', 'Action'],
							<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="11") { ?>                           
							colNames:['Partner Name', 'Margin (%)', 'Margin Type', 'Balance', 'Reg.date','View', 'Status'],							
							<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="15") { ?>                           
							colNames:['Partner Name', 'Margin (%)', 'Margin Type', 'Balance', 'Reg.date','View', 'View','View', 'Status'],							
							<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="12") { ?>					
							colNames:['Partner Name', 'Margin (%)', 'Margin Type','Balance', 'Reg.date','View', 'View', 'Status'],
							<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="13") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Margin Type', 'Balance', 'Reg.date','View', 'Status'], 
							<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="14") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Margin Type', 'Balance', 'Reg.date','View', 'Status'],							
							<?php } ?>													
                            colModel:[
                                {name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', width:120,align:"left",sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE', width:80,align:"center",sortable:true},
								{name:'PARTNER_COMMISSION_TYPE',index:'PARTNER_COMMISSION_TYPE', width:80,align:"center",sortable:true},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE', width:80,align:"center",sortable:true}, 									
								{name:'PARTNER_CREATED_ON',index:'PARTNER_CREATED_ON', width:80,align:"center",sortable:true},				                         							
								<?php if($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="0") { ?>
								/*{name:'VIEWD',index:'VIEWD', width:100, align:"center",sortable:false},
								{name:'VIEWS',index:'VIEWS', width:100, align:"center",sortable:false},
								{name:'VIEWA',index:'VIEWA', width:100, align:"center",sortable:false},*/
								<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="11") { ?>                           
								{name:'VIEWD',index:'VIEWD', width:80, align:"center",sortable:false},
						//		{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
						//		{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},							
								<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="15") { ?>                           
								{name:'VIEWD',index:'VIEWD', width:80, align:"center",sortable:false},
								{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},							
								<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="12") { ?>													
								{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
								<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="13") { ?>								
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
								<?php } elseif($viewPartnerInfo[0]->FK_PARTNER_TYPE_ID=="14") { ?>								
								{name:'VIEWU',index:'VIEWU', width:80, align:"center",sortable:false},							
								<?php } ?>
								{name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
                </script>
            <?php } else {?>
            <table id="list4" class="data">
              <tr>
                <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"><span style="position: relative;top: -9px;"><b>There is no record to display</b></span> </td>
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
