<?php
//	echo "<pre>";
//	print_r($this->session->userdata['blacklistsData']);
?>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript">
/*hs.graphicsDir = 'images/';
hs.wrapperClassName = 'wide-border';*/

function closeDiv()
{
	document.getElementById('saved_desc').innerHTML = '';	
	document.getElementById('desc_status').value = '';
	Popup.hide('user_status_desc');
}

function Datecompare()
{
   var objFromDate = document.getElementById("START_DATE_TIME").value; 
   var objToDate = document.getElementById("END_DATE_TIME").value;
   var FromDate = new Date(objFromDate);
   var ToDate = new Date(objToDate);
   var valCurDate = new Date();
   valCurDate =  valCurDate.getYear()+ "-" +valCurDate.getMonth()+1 + "-" + valCurDate.getDate();
   var CurDate = new Date(valCurDate);
   
   if(FromDate > ToDate)
   {
    alert(fromname + " should be less than " + toname);
     return false; 
   }
   else if(FromDate > CurDate)
   {
     alert("From date should be less than current date");
     return false; 
   }
    else if(ToDate > CurDate)
    {
      alert("To date should be less than current date");
      return false;
    }

}

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
function chkdatevalue()
{
   if(trim(document.tsearchform.START_DATE_TIME.value)!='' || trim(document.tsearchform.END_DATE_TIME.value)!=''){ 
    if(isDate(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false ||  isDate(document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')==false){
        alert("Please enter the valid date");
        return false;
    }else{
       // alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
        if(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss')=="1"){
        alert("Start date should be greater than end date");
        return false;
        }
        return true;
    }
   } 
}


function activateUser(status,trackingid,position,pageno,statusType){   
   xmlHttp3=GetXmlHttpObject();
   if(status == 1){
     var urlstatus = 'deactive';
   }else{
     var urlstatus = 'active';
   }
   var url='<?php echo base_url()."helpdesk/ajax/"?>'+urlstatus+'/'+trackingid+'/'+pageno+'/'+statusType;    

	xmlHttp3.onreadystatechange=Showsubagent;
	xmlHttp3.open("GET",url,true);
	xmlHttp3.send(null);
}

function Showsubagent() { 
	if (xmlHttp3.readyState==4) { 
		var pageNo = xmlHttp3.responseText;
   		var newurl = "<?php echo base_url().'helpdesk/blacklist/searchip/'?>"+pageNo+"?rid=35";
		window.location= newurl;		
	}
}

function GetXmlHttpObject() {
	var xmlHttp3=null;
	try {
  		// Firefox, Opera 8.0+, Safari
	    xmlHttp3=new XMLHttpRequest();
  	} catch (e) {
		// Internet Explorer
	  	try {
			xmlHttp3=new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			xmlHttp3=new ActiveXObject("Microsoft.XMLHTTP");
		}
  	}
	return xmlHttp3;
}
</script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 	
            <form action="<?php echo base_url(); ?>helpdesk/blacklist/searchip?rid=35" method="post" name="blacklist" id="blacklist"  > 
              <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
                <tr>
                  <td>
                      <table width="100%" class="ContentHdr">
                        <tr>
                          <td><strong>Black Lists</strong></td>
                        </tr>
                      </table>
                      <table width="100%" cellpadding="10" cellspacing="10">
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">IP Address:</span><br />
                            <label>
                            <?php
								$ipAddrss="";
								if(!empty($this->session->userdata['blacklistsData']['IPADDRESS']));
									$ipAddrss = $this->session->userdata['blacklistsData']['IPADDRESS'];
							?>
                               <input type="text" name="IPADDRESS" id="IPADDRESS" class="TextField" value="<?php echo $ipAddrss;?>" >
                            </label></td>
                            <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                            <label>
                            <?php
								$username="";
								if(!empty($this->session->userdata['blacklistsData']['USERNAME']));
									$username = $this->session->userdata['blacklistsData']['USERNAME'];
							?>                            
                               <input type="text" name="USERNAME" id="USERNAME" class="TextField" value="<?php echo $username;?>" >
                            </label></td>
                            <td width="20%"><span class="TextFieldHdr">Status:</span><br />
                            <label>
                            <?php
								$bStatus="";
								if(!empty($this->session->userdata['blacklistsData']['select2']));
									$bStatus = $this->session->userdata['blacklistsData']['select2'];
							?>                             
                              <select name="select2" class="ListMenu" id="select2">
                                <option selected="selected" value="">Select</option>
                                <option value="1" <?php if($bStatus==1) echo "selected=selected"?>>ACTIVE</option>
                                <option value="2" <?php if($bStatus==2) echo "selected=selected"?>>INACTIVE</option>
                              </select>
                            </label>                            
                            </td>
                          </tr>
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
				<?php
                    if(!empty($this->session->userdata['blacklistsData']['START_DATE_TIME']))
                        $startDate = date('d-m-Y 00:00:00',strtotime($this->session->userdata['blacklistsData']['START_DATE_TIME']));
					else
						$startDate = date('d-m-Y 00:00:00');
                ?>                   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP echo $startDate;?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                            <td width="40%"><span class="TextFieldHdr">To:</span><br />
                            <label>
				<?php
                    if(!empty($this->session->userdata['blacklistsData']['END_DATE_TIME']))
                        $endDate = date('d-m-Y 23:59:59',strtotime($this->session->userdata['blacklistsData']['END_DATE_TIME']));
					else
						$endDate = date('d-m-Y 23:59:59');						
                ?>                               
                               <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP echo $endDate;?>">
                            </label>
<a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>                            
                            <td width="20%">&nbsp;</td>
                          </tr>                          
                          <tr>
                            <td width="33%">
                              <table>
                                <tr>
                                  <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
                                  </form> </td>
                                  <td>
                                    <form action="<?php echo base_url();?>helpdesk/blacklist/searchip?rid=35&start=1" method="post" name="clrform" id="clrform">   
                                    <input name="reset" type="submit"  id="reset" value="Clear"  />
                                    </form>
                                  </td>
                          <td>&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          <td width="33%">&nbsp;</td>
                          <td width="33%">&nbsp;</td>
                          </tr>                          
                      </table>
                      
                      <table width="100%" class="ContentHdr">
                        <tr>
                          <td><strong>IP Search Result</strong></td>
                        </tr>
                      </table>
                      
                
<?php
	$page=0;
	if($this->uri->segment(4))
    	$page = $this->uri->segment(4);
		
	 if(isset($page) && $page !=''){
	 	$j=$page;
     }else{
     	$j=0;
     }  

     $resvalues=array();
     if(isset($results)){ 
     	if(count($results)>0 && is_array($results)){
            for($i=0;$i<count($results);$i++){					
				$resvalue['SNO']=$j+1;
				$resvalue['USERNAME']= $results[$i]->USERNAME;
				$resvalue['SYSTEM_IP']= $results[$i]->SYSTEM_IP;
				//$resvalue['ACTION']  = $results[$i]->ACTION_NAME;
				if($results[$i]->STATUS == 1){
                    $resvalue['STATUS']  = "ACTIVE";
                }elseif($results[$i]->STATUS == 2 || $results[$i]->STATUS == 3){
                    $resvalue['STATUS']  = "INACTIVE";
                }
				$resvalue['DATE_TIME'] = date("d/m/Y h:i:s",strtotime($results[$i]->DATE_TIME));
				//This is for registration block									
				if($results[$i]->STATUS == 1){
					$statusType = 1;
        	        $resvalue['IMGSTATUS'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(1,'.$results[$i]->TRACKING_ID.','.$i.','.$page.','.$statusType.')" ><img src="'.base_url().'static/images/status.png" title="Click here to deactivate"></a> &nbsp;&nbsp;&nbsp;</span>';
				}else{
					$statusType = 1;					
                	$resvalue['IMGSTATUS'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(0,'.$results[$i]->TRACKING_ID.','.$i.','.$page.','.$statusType.')" ><img src="'.base_url().'static/images/status-locked.png" title="Click here to activate"></a> &nbsp;&nbsp;&nbsp;</span>';
				}
				//This is for login block
				if($results[$i]->LOGIN_STATUS==1) {
					$statusType = 2;					
					$resvalue['LoginStatus'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(1,'.$results[$i]->TRACKING_ID.','.$i.','.$page.','.$statusType.')" ><img src="'.base_url().'static/images/status.png" title="Click here to deactivate"></a> &nbsp;&nbsp;&nbsp;</span>'; 
				} else {
					$statusType = 2;					
					$resvalue['LoginStatus'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(0,'.$results[$i]->TRACKING_ID.','.$i.','.$page.','.$statusType.')" ><img src="'.base_url().'static/images/status-locked.png" title="Click here to activate"></a> &nbsp;&nbsp;&nbsp;</span>'; 
				}
                if($resvalue){
                	$arrs[] = $resvalue;
                }		
                $j++;
			}
        }else{
        	$arrs="";
	}
 }
?>
    <?php 
	if(isset($arrs) && $arrs!=''){ ?>
    <div class="tableListWrap">
      <div class="data-list">
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
        <table id="list4" class="data">
          <tr>
            <td></td>
          </tr>
        </table>
        <div id="pager3"></div>
        <script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script type="text/javascript">
                jQuery("#list4").jqGrid({
                    datatype: "local",
					colNames:['Username','Ip Address','Status','Date','Registration Status','Login Status'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:60},
						{name:'SYSTEM_IP',index:'SYSTEM_IP', align:"center", width:60},
						//{name:'ACTION',index:'ACTION', align:"center", width:50},
						{name:'STATUS',index:'STATUS', align:"center", width:50},
						{name:'DATE_TIME',index:'DATE_TIME', align:"center", width:50},
						{name:'IMGSTATUS',index:'IMGSTATUS', width:60, align:"center"},
						{name:'LoginStatus',index:'LoginStatus', width:60, align:"center"},			
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
        <div class="page-wrap">
          <div class="pagination">
            <?php	echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
    <?php }else{ 
			  if(empty($_POST) || $_POST['reset'] == 'Clear'){
			      $message  = "Please select the search criteria"; 
			  }else{
		      	  $message  = "There are currently no users found in this search criteria.";
			  } ?>
	<div class="tableListWrap">
      <div class="data-list">
        <table id="list4" class="data">
          <tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no users found in this search criteria.</b></span></td>
          </tr>
        </table>
      </div>
    </div>
	<?php } ?>

    <div id="proofs" align="center" class="popup" style="position:absolute;margin-left:auto;margin-right:auto;display:none;"> <img src='<?php echo base_url();?>static/images/ajax-loader.gif' width='16' height='16' border='0'> </div>
    <div id="user_status_desc" class="popup" style="width:250px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
      <form name="descriptionSTATUS" id="descriptionSTATUS" method="post">
        <input type="hidden" name="userSID" id="userSID"/>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="90%" height="50px;" style="font-size:120%; background-color:#017AB3;padding-left:10px;">Reason for Deactivate Kiosk</td>
            <td width="10%" align="right" style="background-color:#017AB3;"><img src="<?php echo base_url();?>static/images/close.gif" alt="close" title="close" border="0" onClick="closeDiv();"/></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><textarea name="desc_status" id="desc_status" class="TextArea" cols="25" rows="5"></textarea></td>
          </tr>
          <tr>
            <td colspan="2" height="50px;"><input class="button" type="button" name="submit" id="submit" value="Save" 
			onclick="UserDeActivateDescription()" />
              &nbsp;
              <input type="button" class="button" name="close" id="close" value="close" 
			onClick="closeDiv();" />
              <span id="saved_desc" style="font-size:90%;"></span></td>
          </tr>
        </table>
      </form>                
    </div>
    
                   <!--   <table width="100%" class="ContentHdr">
                        <tr>
                          <td><strong>Block/Active IP Address</strong></td>
                        </tr>
                      </table> 
                      <table width="100%" cellpadding="10" cellspacing="10">
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">Action:</span><br />
                            <label>
                              <select name="select3" class="ListMenu" id="select3">
                                <option selected="selected">Select Action</option>
                                <option>LOGIN</option>
                                <option>REGISTRATION</option>
                              </select>
                            </label>
                            </td>                              
                          </tr>
                          <td width="20%">&nbsp;</td>
                          <td width="20%">&nbsp;</td>
                          
                          <tr>
                            <td width="33%">
                              <table>
                                <tr>
                                  <td><input name="block" type="submit"  id="button" value="Block" style="float:left;" />
                                  </form> </td>
                                  <td><input name="activate" type="submit"  id="button" value="Activate" style="float:left;" />
                                  </form> </td>
                          <td>&nbsp;</td>
                                </tr>
                              </table>
                            </td>
                          <td width="33%">&nbsp;</td>
                          <td width="33%">&nbsp;</td>
                          </tr>                           
                      </table>-->
                  </td>
                </tr>
              </table>
</div>
</div>
</div>
</div>