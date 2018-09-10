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
</script>
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
</script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script> 
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
  <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>
    <table width="100%" class="ContentHdr">
      <tr>
        <td><strong>Player Search</strong></td>
      </tr>
    </table>
    <form action="<?php echo base_url(); ?>user/account/search" method="post" name="tsearchform" id="tsearchform"  >
     <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td><table width="100%" cellpadding="10" cellspacing="10">
          <tr>
            <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
              <label>
              <input type="text" name="username" id="username" class="TextField" value="<?PHP if(isset($username)) echo $username; ?>" >
              </label></td>
            <td width="40%"><span class="TextFieldHdr">Email:</span><br />
              <label>
              <input type="text" name="email" id="email" class="TextField" value="<?PHP if(isset($email)) echo $email; ?>" >
              </label></td>
            <td width="40%"><span class="TextFieldHdr">Country:</span><br />
              <label>
              <?php
			    $countryList  = $this->common_model->getAllCountries();
			   ?>
              <select name="country" class="TextField">
               <option value="select">Select</option>
                <?php foreach($countryList as $country){ ?>
                <option <?php if($countryv == $country->CountryName) echo 'selected="selected"'; ?> value="<?php echo $country->CountryName; ?>"><?php echo $country->CountryName; ?></option>
                <?php } ?>
              </select>
              </label></td>
            <td width="20%">&nbsp;</td>
          </tr>
           <tr>
            
             <td width="40%"><span class="TextFieldHdr">From:</span><br />
          <label>
          <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if(isset($_REQUEST['START_DATE_TIME'])) echo $_REQUEST['START_DATE_TIME']; ?>">
          </label>
            <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
        <td width="40%"><span class="TextFieldHdr">To:</span><br />
          <label>
          <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if(isset($_REQUEST['END_DATE_TIME'])) echo $_REQUEST['END_DATE_TIME']; ?>">
          </label><a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false)" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
        <td width="20%"><span class="TextFieldHdr"></span><br />
            <label><select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                            <option value="">Select</option>
                            <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                            <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>This Week</option>
                            <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>Last Week</option>
                            <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>This Month</option>
                            <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>Last Month</option>
                        </select></label>
         </td>
            <td width="20%">&nbsp;</td>
          </tr>
          
          
          
          
          
          <tr>
            <td width="33%"><table>
              <tr>
                <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
    </form>
    </td>
    <td><form action="<?php echo base_url();?>user/account/search" method="post" name="clrform" id="clrform">
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
												$partnerName 	= $this->Agent_model->getAgentNameById($results[$i]->PARTNER_ID);
												$distributorId  = $this->Agent_model->getDistributorIdByAgentId($results[$i]->PARTNER_ID);
												$distributorName= $this->Agent_model->getDistributorNameById($distributorId);
												//get user balance
												$createdName    = $results[$i]->CREATED_BY;
												
												$resvalue['SNO']=$j+1;
												$resvalue['USERNAME']= '<a href="'.base_url().'/user/account/detail/'.$results[$i]->USER_ID.'">'.$results[$i]->USERNAME.'</a>';
												$resvalue['EMAIL_ID']= $results[$i]->EMAIL_ID;
												$resvalue['PARTNER'] = $partnerName;
												$resvalue['DISTRIBUTOR']= $createdName;
												$resvalue['COUNTRY']= $results[$i]->COUNTRY;
												$resvalue['REGISTRATION']= $results[$i]->REGISTRATION_TIMESTAMP;
											
												if($results[$i]->USER_IMAGE != '' && $results[$i]->USER_IMAGE != 'none'){
													$resvalue['PROFILEIMAGE']= '<a href="'.$results[$i]->USER_IMAGE.'" class="highslide" onclick="return hs.expand(this)"><img src="'.$results[$i]->USER_IMAGE.'" alt="Highslide JS" title="Click to enlarge" height="60" width="60" /></a>';												
												}else
												{
												 
												    $resvalue['PROFILEIMAGE']= '<img src="'.base_url().'static/images/default-image.jpg" alt="Highslide JS" title="Click to enlarge" height="60" width="60" />';												
												
												}
												$resvalue['DETAILEDVIEW']= '<a href="'.base_url().'user/ajax/info/'.$results[$i]->USER_ID.'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )"><img height="16" width="16" src="'.base_url().'static/images/search.png" alt="view"></a>';
												
												if($results[$i]->ACCOUNT_STATUS == 1){
												  $resvalue['STATUS']= '<a href="'.base_url().'user/account/deactive/'.$results[$i]->USER_ID.'"><img src="'.base_url().'static/images/status.png" alt="Delete"></a>';
												}else 
												{
												$resvalue['STATUS']= '<a href="'.base_url().'user/account/active/'.$results[$i]->USER_ID.'"><img src="'.base_url().'static/images/status-locked.png" alt="Delete"></a>';
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
					colNames:['S.No','Username','Email','Partner','Created By','Country','Register Date','Profile Image','',''],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:60},
						{name:'EMAIL_ID',index:'EMAIL_ID', align:"center", width:100},
						{name:'PARTNER',index:'PARTNER', align:"center", width:60},
						{name:'DISTRIBUTOR',index:'DISTRIBUTOR', align:"center", width:60},
						{name:'COUNTRY',index:'COUNTRY', align:"center", width:40},
						{name:'REGISTRATION',index:'REGISTRATION', align:"center", width:80},
						{name:'PROFILEIMAGE',index:'PROFILEIMAGE', align:"center", width:50},
						{name:'DETAILEDVIEW',index:'DETAILEDVIEW', align:"center", width:20},
                        {name:'STATUS',index:'STATUS', width:20, align:"center"},
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
    <?php }else{ ?>
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
  </div>
</div>
</div>
</div>
<?php echo $this->load->view("common/footer"); ?>