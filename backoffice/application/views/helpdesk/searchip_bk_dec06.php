
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
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              ?>
              //alert('<?php echo $sweekday;?>');
              sdate='<?php echo $sweekday;?>'+' 00:00:00';
              edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
          }
          if(vid=="3"){
             <?php
              $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
              $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
              $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
              ?>
              sdate='<?php echo $slastweekday;?>'+' 00:00:00';
              edate='<?php echo $slastweekeday;?>'+' 23:59:59';
          }
          if(vid=="4"){
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
          if(vid=="5"){
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


function activateUser(status,trackingid,position){
    
    //alert("test");
   xmlHttp3=GetXmlHttpObject()
   
   if(status == 1){
     var urlstatus = 'deactive';
   }else{
     var urlstatus = 'active';
   }
   var url='<?php echo base_url()."helpdesk/ajax/"?>'+urlstatus+'/'+trackingid;    
 
   //url=url+"?disid="+disid;
   xmlHttp3.onreadystatechange=Showsubagent(trackingid,status,position)
   var newurl = "searchip?rid=35";
	window.location= newurl;
   xmlHttp3.open("GET",url,true);
   xmlHttp3.send(null);
   return false;
}

function Showsubagent(trackingid,status,position) 
{
   
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0)
    { 		
        var result=xmlHttp3.responseText;
	if(status == 1){
            document.getElementById("active_"+position).innerHTML='<a onclick="activateUser(0,'+trackingid+','+position+')" ><img src="http://localhost/backoffice/static/images/status-locked.png" alt="Delete"></a> &nbsp;&nbsp;&nbsp;';    
        }else{
            document.getElementById("active_"+position).innerHTML='<a onclick="activateUser(1,'+trackingid+','+position+')" ><img src="http://localhost/backoffice/static/images/status.png" alt="Delete"></a> &nbsp;&nbsp;&nbsp;';    
        }
        
    }
} 

</script>

<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
	<div class="content_wrap">
	
            <form action="<?php echo base_url(); ?>helpdesk/blacklist/searchip?rid=35" method="post" name="blacklist" id="blacklist"  > 
              <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
                <tr>
                  <td>
                      <table width="100%" class="ContentHdr">
                        <tr>
                          <td><strong>Search IP Address</strong></td>
                        </tr>
                      </table>
                      <table width="100%" cellpadding="10" cellspacing="10">
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">IP Address:</span><br />
                            <label>
                               <input type="text" name="IPADDRESS" id="IPADDRESS" class="TextField" value="" >
                            </label></td>
                            <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                            <label>
                               <input type="text" name="USERNAME" id="USERNAME" class="TextField" value="" >
                            </label></td>
                            <td width="20%">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) echo $_REQUEST['START_DATE_TIME']; ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                            <td width="40%"><span class="TextFieldHdr">To Date:</span><br />
                            <label>
                               <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) echo $_REQUEST['END_DATE_TIME']; ?>">
                            </label>
<a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr"></span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>This Week</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>Last Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>This Month</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>                            
                            <td width="20%">&nbsp;</td>
                          </tr>
                          
                          <tr>
                            <td width="40%"><span class="TextFieldHdr">Action:</span><br />
                            <label>
                              <select name="select1" class="ListMenu" id="select1">
                                <option selected="selected"></option>
                                <option value="login" >LOGIN</option>
                                <option value="registration" >REGISTRATION</option>
                              </select>
                            </label>
                            </td>
                            <td width="40%"><span class="TextFieldHdr">Status:</span><br />
                            <label>
                              <select name="select2" class="ListMenu" id="select2">
                                <option selected="selected"></option>
                                <option value="1">ACTIVE</option>
                                <option value="2">DEACTIVE</option>
                              </select>
                            </label>
                            </td>                            
                          </tr>
                          
                          <tr>
                            <td width="33%">
                              <table>
                                <tr>
                                  <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
                                  </form> </td>
                                  <td>
                                    <form action="<?php echo base_url();?>helpdesk/blacklist/searchip?rid=35" method="post" name="clrform" id="clrform">   
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
		//get agent name
							
		$resvalue['SNO']=$j+1;
		$resvalue['USERNAME']= $results[$i]->USERNAME;
		$resvalue['SYSTEM_IP']= $results[$i]->SYSTEM_IP;
		$resvalue['ACTION']  = $results[$i]->ACTION_NAME;
		if($results[$i]->STATUS == 1){
                    $resvalue['STATUS']  = "ACTIVE";
                }elseif($results[$i]->STATUS == 2 || $results[$i]->STATUS == 3){
                    $resvalue['STATUS']  = "INACTIVE";
                }
		$resvalue['DATE_TIME'] = $results[$i]->DATE_TIME;
									
		/*if($results[$i]->STATUS == 1){
                     $resvalue['IMGSTATUS']= '<a href="'.base_url().'user/account/deactive/'.$results[$i]->USER_ID.'"><img src="'.base_url().'static/images/status.png" alt="Delete"></a>';
                }else{
                     $resvalue['IMGSTATUS']= '<a href="'.base_url().'user/account/active/'.$results[$i]->USER_ID.'"><img src="'.base_url().'static/images/status-locked.png" alt="Delete"></a>';
		}*/
		if($results[$i]->STATUS == 1){
                    $resvalue['IMGSTATUS'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(1,'.$results[$i]->TRACKING_ID.','.$i.')" ><img src="'.base_url().'static/images/status.png" alt="Deactivate"></a> &nbsp;&nbsp;&nbsp;</span>';
		}else{
                    $resvalue['IMGSTATUS'] = '<span style="cursor:pointer;" id="active_'.$i.'"><a onclick="activateUser(0,'.$results[$i]->TRACKING_ID.','.$i.')" ><img src="'.base_url().'static/images/status-locked.png" alt="Activate"></a> &nbsp;&nbsp;&nbsp;</span>';
		}										
												
                if($resvalue){
                $arrs[] = $resvalue;
                }
                  $j++;}
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
					colNames:['S.No','Username','Ip Address','Action','Status','Timestamp','Status'],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
			{name:'USERNAME',index:'USERNAME', align:"center", width:60},
			{name:'SYSTEM_IP',index:'SYSTEM_IP', align:"center", width:60},
			{name:'ACTION',index:'ACTION', align:"center", width:50},
			{name:'STATUS',index:'STATUS', align:"center", width:50},
			{name:'DATE_TIME',index:'DATE_TIME', align:"center", width:50},
			{name:'IMGSTATUS',index:'IMGSTATUS', width:60, align:"center"},
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
		  }?>
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