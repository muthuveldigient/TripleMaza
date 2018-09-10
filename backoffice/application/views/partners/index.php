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
<script src="<?php echo base_url();?>static/js/date.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
<script src = "<?php echo base_url();?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>


<script language="javascript" type="text/javascript">
/* THIS IS TO ACTIVATE & DEACTIVATE USERS */
function activatedeaUser(curStatus,partnerID,newStatus,pType) {
	if(curStatus == 1){
	if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user will get unauthenticated"))
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

  if(confirm("Do you really want to authenticate this user? If so all the details related to this user will get authenticated"))
	{
       xmlHttp=GetStateXmlHttpObject();
		if(xmlHttp==null) {
			alert ("Your browser does not support AJAX!");
			return;
		}
		var url="<?php echo base_url();?>partners/partners/changeActivePartnerStatus/"+curStatus+"/"+partnerID+"/"+newStatus+"/"+pType;
		//alert(url);
		xmlHttp.onreadystatechange=changeActivePartnerStatus;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
 }
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

function showagentusers()
{
	document.getElementById("affiliatesection").style.display="block";
	document.getElementById("loginstatus").style.display="block";
	document.getElementById("pnameselection").style.display="none";
	document.getElementById("partnername").value="";
	document.getElementById("playername").value="";		
}
function Hidedist()
{
	document.getElementById('affiliatesection').style.display="none";
	document.getElementById('loginstatus').style.display="none";
	document.getElementById("pnameselection").style.display="block";
	document.getElementById("partnername").value="";
	document.getElementById("playername").value="";		
}
</script>
<script>
function showdaterange(vid)
    {
      if(vid!=''){
          var sdate='';
          var edate='';
          if(vid=="0"){
              sdate='';
              edate='';
          }
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
          document.getElementById("startdate").value=sdate;
          document.getElementById("enddate").value=edate;
      }


    }



function chkdatevalue(){
   if(trim(document.getElementById("startdate").value)!='' || trim(document.getElementById("enddate").value)!=''){
	  if(isDate(document.getElementById("startdate").value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.getElementById("enddate").value,'dd-MM-yyyy HH:mm:ss')==false){
	   		alert("Please enter the valid date");
	   		return false;
	  }else{
		   if(compareDates(document.getElementById("startdate").value,'dd-MM-yyyy HH:mm:ss',document.getElementById("enddate").value,'dd-MM-yyyy HH:mm:ss')=="1"){
			alert("Start date should be greater than end date");
			return false;
		   }else{
			return true;
		   }
	  }
   }
}





</script>
<style>
/* New styles below */
label.valid {
  width: 24px;
  height: 24px;
  /*background: url(assets/img/valid.png) center center no-repeat;*/
  display: inline-block;
  text-indent: -9999px;
}
label.error {
	font-weight: normal;
	color: red;
	padding: 0 3px;
	margin-top: -5px;
}
</style>
<?php
$message = "";
$page = $this->uri->segment(3);
if(isset($page) && $page !='') {
	$j=$page;
} else {
	$j=0;
}
$sesFk=$this->session->userdata('partnerSearchData');
if($sesFk["FK_PARTNER_TYPE_ID"] =='0')
{
	foreach($partner_info as $index=>$userInfo) {

		//encrypt userid
		 //$encUserId = $this->encrypt->encode($userInfo->USER_ID);
		$encUserId=base64_encode($userInfo->USER_ID);

		$resValue[$index]['USERNAME']        = '<a href="'.base_url().'partners/partners/details/'.$encUserId.'?rid=51">'.$userInfo->USERNAME.'</a>';
		$resValue[$index]['AGENT_NAME'] = $this->partner_model->getPartnerNameById_display($userInfo->PARTNER_ID);
		$arr=explode('/',$this->partner_model->getNameOfPartnerIds_display($userInfo->PARTNER_ID));
		$resValue[$index]['AGENT_SUBD'] =$arr['1']; 		
		$resValue[$index]['AGENT_DISB'] = $arr['0'];
		$resValue[$index]['POINTS'] = $userInfo->USER_TOT_BALANCE;

		if($userInfo->MOBILE_LOGIN_STATUS=="1" || $userInfo->LOGIN_STATUS==1) {
			$resValue[$index]['ONLINE']    = '<b>True</b>';
			/*$resValue[$index]['ACTION_KICKOFF'] = '<a href="'.base_url().'partners/partners/kickoff/'.$userInfo->USER_ID.'?rid=51">Kickoff</a>';	*/
		}else{
			$resValue[$index]['ONLINE']    = '<b>false</b>';
			/*$resValue[$index]['ACTION_KICKOFF'] = 'Kickoff';*/
		}
		if($userInfo->ACCOUNT_STATUS=="1")
			$resValue[$index]['USER_STATUS']    = '<span id="activatede_'.$userInfo->USER_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$userInfo->USER_ID.',0,0)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';
		else
			$resValue[$index]['USER_STATUS']    = '<span id="activatede_'.$userInfo->USER_ID.'"><a href="#" onclick="javascript:activatedeaUser(0,'.$userInfo->USER_ID.',1,0)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';

	  $USERID = base64_encode($userInfo->USER_ID);
	  $USERNAME = base64_encode($userInfo->USERNAME);
		if($this->session->userdata('partnerid')!=ADMIN_ID){

		   if($this->session->userdata('partnertransaction_password')!= ''){
			 $resValue[$index]['ACTION'] = "<a style='cursor:pointer;' title='Transfer Points' onClick='openbox1(\"Transfer Points\",\"1\",\"$USERNAME-$USERID\")'>Transfer Points</a>";
			}

			//$resValue[$index]['ACTION']    			= '<a onClick="openboxSearch(\"Adjust Points\",\"1\",\"$userid\")" href="'.base_url().'partners/partners/transferPointsAll/'.$userInfo->USER_ID.'?rid=51&name='.base64_encode($userInfo->USERNAME).'">Transfer Points</a>';
		}else{
		$resValue[$index]['ACTION']    			= '';
		}
		$j++;
		}?>

        <div id="shadowing2"></div>
            <div id="box2">
                <?php //$string = AdjustPoints;?>

                <form id="frmLightboxSearch" method="REQUEST" action="" target="_parent">
                <div class="SeachResultWrap">
                <div class="Agent_create_wrap">
                <div class="Agent_hdrt" id="boxtitle1"></div>
                <div class="Agent_txtField">Transaction Password:<br />
                    <input name="partnertransaction_password" type="password" class="TextField" id="transpassword" size="65" maxlength="60"  />
                </div>
                <div class="Agent_txtField">
                    <input type ="hidden" name="currentUrl" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" />
                    <input type="submit" class="button" value="Submit" />
                    <input type="button" class="button" value="Cancel" onClick="closebox2()" />
                </div>
                </div>
                </div>
                </form>
            </div>

		<?php

}
else if($sesFk["FK_PARTNER_TYPE_ID"]!='0' && isset($sesFk["FK_PARTNER_TYPE_ID"])) {
	foreach($partner_info as $index=>$partnerInfo) {
		//encrypt parthner id
		 //$encPartnerId = $this->encrypt->encode($partnerInfo->PARTNER_ID);
		$encPartnerId=base64_encode($partnerInfo->PARTNER_ID);

		//$getParentPName = $this->partner_model->getParentPartnerName($partnerInfo->MPARTNER_ID);
		$resValue[$index]['PARTNER_TYPE']        = '<a href="'.base_url().'partners/partners/editPartner/'.$encPartnerId.'?rid=51">'.$partnerInfo->PARTNER_NAME.'</a>';
		$resValue[$index]['PARTNER_REVENUE_SHARE'] = $partnerInfo->PARTNER_REVENUE_SHARE;
		$resValue[$index]['PARTNER_BALANCE']      = $this->partner_model->getPartnerBalance($partnerInfo->PARTNER_ID);
	if(!empty($_REQUEST['partnertype']) && $_REQUEST['partnertype']=='11' || $sesFk["FK_PARTNER_TYPE_ID"] ==11) {
		$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/15?rid=51&ty=5">View Sup.Dist</a>';
		//$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$partnerInfo->PARTNER_ID.'/13?rid=51&ty=3">View Sub.dist</a>';
		//$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$partnerInfo->PARTNER_ID.'/14?rid=51&ty=4">View Agents</a>';
	} else if(!empty($_REQUEST['partnertype']) && $_REQUEST['partnertype']=='12' || $sesFk["FK_PARTNER_TYPE_ID"] ==12) {
		$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=3">View Sub.dist</a>';
		$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=4">View Agents</a>';
	} else if(!empty($_REQUEST['partnertype']) && $_REQUEST['partnertype']=='13' || $sesFk["FK_PARTNER_TYPE_ID"] ==13) {
		$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=4">View Agents</a>';
	} elseif(!empty($_REQUEST['partnertype']) && $_REQUEST['partnertype']=='14' || $sesFk["FK_PARTNER_TYPE_ID"] ==14) {
		$resValue[$index]['VIEWU']      = '<a href="'.base_url().'partners/partners/viewPartnerPlayers/'.$encPartnerId.'?rid=51">View Users</a>';
		$resValue[$index]['AFFILIATE_CODE'] = $partnerInfo->PARTNER_ID;
	} elseif(!empty($_REQUEST['partnertype']) && $_REQUEST['partnertype']=='15' || $sesFk["FK_PARTNER_TYPE_ID"] ==15) {
		$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/12?rid=51&ty=2">View Dist.</a>';
	//	$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=3">View Sub.dist</a>';
	//	$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=4">View Agents</a>';
	} else {
		$resValue[$index]['VIEWD']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/12?rid=51&ty=2">View Dist.</a>';
		$resValue[$index]['VIEWS']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/13?rid=51&ty=3">View Sub.dist</a>';
		$resValue[$index]['VIEWA']      = '<a href="'.base_url().'partners/partners/viewTypeOfPartners/'.$encPartnerId.'/14?rid=51&ty=4">View Agents</a>';
	}
		if($partnerInfo->PARTNER_STATUS=="1")
			$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(1,'.$partnerInfo->PARTNER_ID.',0,-1)"><img src="'.base_url().'static/images/status.png" title="Click to Deactivate"></img></a></span>';
		else
			$resValue[$index]['PARTNER_STATUS']    = '<span id="activatede_'.$partnerInfo->PARTNER_ID.'"><a href="#" onclick="javascript:activatedeaUser(0,'.$partnerInfo->PARTNER_ID.',1,-1)"><img src="'.base_url().'static/images/status-locked.png" title="Click to Activate"></img></a></span>';



	  //$pid = $this->encrypt->encode($partnerInfo->PARTNER_ID);
	  $pid = base64_encode($partnerInfo->PARTNER_ID);

	  if($this->session->userdata('partnertransaction_password')!= ''){
	  	//$resValue[$index]['ACTIONPOINTS'] = "<a style='cursor:pointer;' title='Transfer Points' onClick='openbox7(\"Transfer Points\",\"1\",\"$pid\")'>Transfer Points</a>";
		}else{

		//$resValue[$index]['ACTIONPOINTS'] = "<a style='cursor:pointer;' title='Transfer Points' href='".base_url()."partners/partners/transferPointsAll?rid=52'>Transfer Points</a>";
		}
		if(isset($_REQUEST['partnertype'])) {
			$ptypeid=base64_encode($_REQUEST['partnertype']);
			$resValue[$index]['ACTIONPOINTS'] = "<a style='cursor:pointer;' title='Transfer Points' href='".base_url()."partners/partners/adjust?pid=$encPartnerId&pty=$ptypeid&rid=51'>Transfer Points</a>";
		} else {
			$resValue[$index]['ACTIONPOINTS'] = "<a style='cursor:pointer;' title='Transfer Points' href='".base_url()."partners/partners/adjust?pid=$encPartnerId&rid=51'>Transfer Points</a>";
		}
		$j++;
	} 
// 	echo '<pre>';print_r($sesFk);exit;
	?>
      <div id="shadowing7"></div>
            <div id="box7">
                <?php //$string = AdjustPoints;?>

                <form id="frmLightboxSearch7" method="post" action="" target="_parent">
                <div class="SeachResultWrap">
                <div class="Agent_create_wrap">
                <div class="Agent_hdrt" id="boxtitle7"></div>
                <div class="Agent_txtField">Transaction Password:<br />
                    <input name="partnertransaction_password" type="password" class="TextField" id="transpassword" size="65" maxlength="60"  />
                </div>
                <div class="Agent_txtField">
                    <input type ="hidden" name="currentUrl" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" />
                    <input type="submit" class="button" value="Submit" />
                    <input type="button" class="button" value="Cancel" onClick="closebox7()" />
                </div>
                </div>
                </div>
                </form>
            </div>

    <?php

}



//echo $pTypeId = $this->session->userdata['partnerid'];
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
		<?php if ($this->session->flashdata('message')) { ?>
			<script>
				$('#ErrorMsg').show()
				setTimeout(function(){ $('#ErrorMsg').hide(); }, 3000);
			</script>
                    <table width="100%" class="ErrorMsg" id="ErrorMsg">
                        <tbody>
                            <tr>
                                <td width="45"><img width="37" height="25" alt="" src="<?php echo base_url();?>static/images/icon-error.png"></td>
                                <td width="95%"><?php echo $this->session->flashdata('message'); ?></td>
                            </tr>
                        </tbody>
                    </table>
		<?php } ?> 
        <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Search Agents & Players</strong></td>
          </tr>
        </table>
        <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
          <tr>
            <td><?php
							$attributes = array('id' => 'listpartners','onsubmit'=>' return chkdatevalue()');
							echo form_open('partners/index?rid=51',$attributes); ?>
              <?PHP if($type=$this->session->userdata('partnertypeid')!=4) {?>
              <span class="TextFieldHdr"> <?php echo form_label('Search By', 'Search By');?>: </span><br />
              <input type="radio"  name="partnertype" id="partnertype" value="0" <?php if($_REQUEST['partnertype']=="0"){ echo "checked='checked'";}?> checked="checked"onclick="showagentusers()">Players
              <?PHP }else { ?>
              <input type="hidden"  name="partnertype" id="partnertype" value="0">
              <?PHP } ?>

              <?PHP foreach($partnerTypes as $partnerType) { ?>
              <input type="radio" class="radio_partnertype" name="partnertype" id="partnertype" value="<?PHP echo $partnerType->PARTNER_TYPE_ID; ?>" <?php if($_REQUEST['partnertype']==$partnerType->PARTNER_TYPE_ID || $this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']==$partnerType->PARTNER_TYPE_ID){ echo "checked='checked'";}?> onclick="Hidedist('affiliatesection','loginstatus');"><?PHP echo $partnerType->PARTNER_TYPE; }?>
          </tr>
          <tr>
            <td width="40%"><?php $partnerC_status =  $this->session->userdata['partnerSearchData']['PARTNER_STATUS']; ?>
              <span class="TextFieldHdr"> <?php echo form_label('Status', 'PartnerStatus');?>: </span><br />
              <select name="partnerstatus" id="partnerstatus" class="lstTextField">
                <option value="" selected="selected">--- Select ---</option>
                <option <?php if($partnerC_status == 1) echo 'selected="selected"'; ?>  value="1">Active</option>
                <option <?php if($partnerC_status == 2) echo 'selected="selected"'; ?> value="2">Deactive</option>
              </select>
            </td>
            <td id="pnameselection"  <?PHP if(isset($_POST['partnertype']) && $_POST['partnertype']!=0 || isset($this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']) && $this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']!=0) {?> style="display:block;" <?PHP }else {?> style="display:none;"<?PHP } ?>><span class="TextFieldHdr"> <?php echo form_label('Partner Name', 'PartnerName');?>: </span><br />
              <?php
							if(!empty($this->session->userdata['partnerSearchData']['PARTNER_NAME']))
								$PARTNER_DIS_NAME = $this->session->userdata['partnerSearchData']['PARTNER_NAME'];

                            $PartnerName = array(
                                  'name'        => 'partnername',
                                  'id'          => 'partnername',
								  'value'		=> $PARTNER_DIS_NAME,
								  'class'		=> 'TextField',
                                  'maxlength'   => '45'
                                );
                            echo form_input($PartnerName);


					    ?>
              <td id="affiliatesection" <?PHP if(isset($_POST['partnertype']) && $_POST['partnertype']!=0 || isset($this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']) && $this->session->userdata['partnerSearchData']['FK_PARTNER_TYPE_ID']!=0) {?> style="display:none;" <?PHP }else {?> style="display:block;"<?PHP } ?>>
              <span class="TextFieldHdr"> <?php echo form_label('Player Name', 'PlayerName');?>: </span><br />
              <?php
							if(!empty($this->session->userdata['partnerSearchData']['PLAYERNAME']))
								$PLAYERNAME = $this->session->userdata['partnerSearchData']['PLAYERNAME'];

                            $AffiliateName = array(
                                  'name'        => 'playername',
                                  'id'          => 'playername',
								  'value'		=> $PLAYERNAME,
								  'class'		=> 'TextField',
                                  'maxlength'   => '45'
                                );
                            echo form_input($AffiliateName);
                        ?>
            </td>
            <td width="20%">&nbsp;</td>
          </tr>
          <tr>
            <td width="40%"><span class="TextFieldHdr"> <?php echo form_label('Start Date', 'StartDate');?>: </span><br />
              <?php
							if(!empty($this->session->userdata['partnerSearchData']['CREATED_ON']))
								$START_DATE_TIME = date('d-m-Y H:i:s',strtotime($this->session->userdata['partnerSearchData']['CREATED_ON']));
							else
								$START_DATE_TIME = "";

                            $startDate = array(
                                  'name'        => 'startdate',
                                  'id'          => 'startdate',
								  'value'		=> $START_DATE_TIME,
								  'class'		=> 'TextFieldDate',
                                  'maxlength'   => '19'
                                );
                            echo form_input($startDate);
                        ?>
              <a onclick="NewCssCal('startdate','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a> </td>
            <td width="40%"><span class="TextFieldHdr"> <?php echo form_label('End Date', 'EndDate');?>: </span><br />
              <?php
							if(!empty($this->session->userdata['partnerSearchData']['CREATED_ON_END_DATE']))
								$END_DATE_TIME = date('d-m-Y H:i:s',strtotime($this->session->userdata['partnerSearchData']['CREATED_ON_END_DATE']));
							else
								$END_DATE_TIME = "";//date('d-m-Y');

                            $endDate = array(
                                  'name'        => 'enddate',
                                  'id'          => 'enddate',
								  'value'		=> $END_DATE_TIME,
								  'class'		=> 'TextFieldDate',
                                  'maxlength'   => '19'
                                );
                            echo form_input($endDate);
                        ?>
              <a onclick="NewCssCal('enddate','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url()?>static/images/calendar.png" /></a> </td>
            <td width="20%"><span class="TextFieldHdr"> <?php echo form_label('Date Range', 'range');?>: </span><br />
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
				$js = 'id="searchlimit" name="searchlimit" class="ListMenu" onchange="javascript:showdaterange(this.value);"';
				 echo form_dropdown('searchlimit', $options, $this->session->userdata['partnerSearchData']['SEARCH_LIMIT'], $js);
		?>
            </td>
          </tr>
          <tr>
            <td width="60%" id="loginstatus" <?PHP if(isset($_POST['partnertype']) && $_POST['partnertype']!=0) {?> style="display:none;" <?PHP }else {?> style="display:block;"<?PHP } ?>>
            <?php $partnerL_status =  $this->session->userdata['partnerSearchData']['LOGIN_STATUS']; ?>
            <span class="TextFieldHdr"> Online: </span><br />
            <select name="partnerLstatus" id="partnerLstatus" class="lstTextField">
              <option value="" selected="selected">All</option>
              <option  value="1" <?php if($partnerL_status == 1) echo 'selected="selected"'; ?>>True</option>
              <option  value="2" <?php if($partnerL_status == 2) echo 'selected="selected"';?>>False</option>
            </select>
            </td>
            <td width="20%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="1">
			<?php
				echo form_submit('frmSearch', 'Search','style="float:left;margin-right:5px"')."&nbsp;";
				//echo form_reset('frmClear', 'Clear');
                echo form_close();
			?>
            <form action="<?php echo base_url();?>partners/index?rid=51&start=1" method="post" name="clrform" id="clrform" style="float:left;">
                        <input name="reset" type="submit"  id="reset" value="Clear"  />
                        </form>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
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
<?php if(!empty($searchResult) && !empty($partner_info)) { ?>
<p class="searchWrap1" style="height:30px;">
    <span style="position:relative;top:8px;left:10px">
        <b> Total Users: <font color="#FF3300">(<?php echo $tot_users; ?>) </font></b> &nbsp;&nbsp;&nbsp;
        <b> Active Users: <font color="green">(<?php echo $active_users; ?>)</font></b> &nbsp;&nbsp;&nbsp;
        <b> Inactive Users: <font color="#FF3300">(<?php echo $inactive_users; ?>)</font></b>
    </span>
</p>
<?php } ?>        
        <div class="tableListWrap">
          <div class="data-list">
            <?php //echo "<pre>";print_r($partner_info);die;
                if(!empty($searchResult) && !empty($partner_info)) {
                    //echo "<pre>";print_r($partner_info);die;?>
            <table id="list2">
            </table>
            <div id="pager2"></div>
            <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
							<?php if($sesFk["FK_PARTNER_TYPE_ID"]=="0") { ?>
                            colNames:['User Name', 'Agent', 'Sub.Dist', 'Distributor','Points', 'Online','Status','Action'],
							<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="11") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance', 'View','Status', 'Manage Points'],
							<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="12") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance','View', 'View','Status','Manage Points'],
							<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="13") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance','View', 'Status','Manage Points'],
							<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="14") { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance','Affiliate Code','View','Status','Manage Points'],
							<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="15")  { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance','View','Status','Manage Points'],
							<?PHP } else { ?>
							colNames:['Partner Name', 'Margin (%)', 'Balance','View','View','View','Status','Manage Points'],
							<?PHP } ?>

							colModel:[
								<?php if($sesFk["FK_PARTNER_TYPE_ID"]=="0") { ?>
								{name:'USERNAME',index:'USERNAME',align:"left", width:140,sortable:true},
								{name:'AGENT_NAME',index:'AGENT_NAME',align:"left", width:90,sortable:true},
								{name:'AGENT_SUBD',index:'AGENT_SUBD',align:"left", width:90,sortable:true},
								{name:'AGENT_DISB',index:'AGENT_DISB',align:"left", width:90,sortable:true},
								{name:'POINTS',index:'POINTS',align:"center", width:80,sortable:true},
								{name:'ONLINE',index:'ONLINE',align:"center", width:40,sortable:true},
								{name:'USER_STATUS',index:'USER_STATUS',align:"center", width:40,sortable:true},
								{name:'ACTION',index:'ACTION',align:"center", width:100},
								<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="11") { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'VIEWD',index:'VIEWD', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="12") { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="13") { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="14") { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'AFFILIATE_CODE',index:'AFFILIATE_CODE', width:80, align:"center"},
								{name:'VIEWU',index:'VIEWU', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?php } elseif($sesFk["FK_PARTNER_TYPE_ID"]=="15") { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'VIEWD',index:'VIEWD', width:80, align:"center",sortable:false},
							//	{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
							//	{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?PHP } else { ?>
                                {name:'PARTNER_TYPE',index:'PARTNER_TYPE',align:"left", width:120,sortable:true},
								{name:'PARTNER_REVENUE_SHARE',index:'PARTNER_REVENUE_SHARE',align:"center", width:50},
								{name:'PARTNER_BALANCE',index:'PARTNER_BALANCE',align:"center", width:80},
								{name:'VIEWD',index:'VIEWD', width:80, align:"center",sortable:false},
								{name:'VIEWS',index:'VIEWS', width:80, align:"center",sortable:false},
								{name:'VIEWA',index:'VIEWA', width:80, align:"center",sortable:false},
                                {name:'PARTNER_STATUS',index:'PARTNER_STATUS', width:40, align:"center",sortable:true},
								{name:'ACTIONPOINTS',index:'ACTIONPOINTS', width:100, align:"center",sortable:false},
								<?PHP }?>
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
