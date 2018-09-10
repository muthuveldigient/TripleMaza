<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
    hs.graphicsDir = "<?php echo base_url() ?>static/images/";
    hs.outlineType = 'rounded-white';
    hs.wrapperClassName = 'draggable-header';
</script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url(); ?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script>
    function showdaterange(vid)
    {
        if (vid != '') {
            var sdate = '';
            var edate = '';
            if (vid == "1") {
                sdate = '<?php echo date("d-m-Y "); ?>';
                edate = '<?php echo date("d-m-Y "); ?>';
            }
            if (vid == "2") {
<?php $yesterday = date('d-m-Y', strtotime("-1 days")); ?>
                sdate = '<?php echo $yesterday; ?>';
                edate = '<?php echo $yesterday; ?>';
            }
            if (vid == "3") {


<?php
$sweekday = date("d-m-Y", strtotime(date("d-m-Y")) - ((date("w") - 1) * 24 * 60 * 60));
?>
                //alert('<?php echo $sweekday; ?>');
                sdate = '<?php echo $sweekday; ?>';
                edate = '<?php echo date("d-m-Y"); ?>';
            }
            if (vid == "4") {
<?php
$sweekday = date("d-m-Y", strtotime(date("d-m-Y")) - ((date("w") - 1) * 24 * 60 * 60));
$slastweekday = date("d-m-Y", strtotime($sweekday) - (7 * 24 * 60 * 60));
$slastweekeday = date("d-m-Y", strtotime($slastweekday) + (6 * 24 * 60 * 60));
?>
                sdate = '<?php echo $slastweekday; ?>';
                edate = '<?php echo $slastweekeday; ?>';
            }
            if (vid == "5") {
<?php
$tmonth = date("m");
$tyear = date("Y");
$tdate = "01-" . $tmonth . "-" . $tyear;
$lday = date('t', strtotime(date("d-m-Y"))) . "-" . $tmonth . "-" . $tyear;
//$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
?>
                sdate = '<?php echo $tdate; ?>';
                edate = '<?php echo $lday; ?>';
            }
            if (vid == "6") {
<?php
$tmonth = date("m");
$tyear = date("Y");
$tdate = date("01-m-Y", strtotime("-1 month"));
$lday = date("t-m-Y", strtotime("-1 month"));

//$slastweekday=date("d-m-Y",strtotime(date("d-m-Y"))-(7*24*60*60));
?>
                sdate = '<?php echo $tdate; ?>';
                edate = '<?php echo $lday; ?>';
            }
            document.getElementById("startdate").value = sdate;
            document.getElementById("enddate").value = edate;
        }


    }
    function chkdatevalue()
    {
        if (trim(document.tsearchform.START_DATE_TIME.value) != '' || trim(document.tsearchform.END_DATE_TIME.value) != '') {
            if (isDate(document.tsearchform.START_DATE_TIME.value, 'dd-MM-yyyy') == false || isDate(document.tsearchform.END_DATE_TIME.value, 'dd-MM-yyyy') == false) {
                alert("Please enter the valid date");
                return false;
            } else {
                // alert(compareDates(document.tsearchform.START_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss',document.tsearchform.END_DATE_TIME.value,'dd-MM-yyyy HH:mm:ss'));
                if (compareDates(document.tsearchform.START_DATE_TIME.value, 'dd-MM-yyyy', document.tsearchform.END_DATE_TIME.value, 'dd-MM-yyyy') == "1") {
                    alert("Start date should be greater than end date");
                    return false;
                }
                return true;
            }
        }
    }
</script>

<script language="javascript" type="application/javascript">
    /* THIS IS TO ACTIVATE & DEACTIVATE USERS */
    function activatedeaUser(curStatus,adminID,newStatus) {
    if(curStatus==1){
    if(confirm("Do you really want to unauthenticate this Admin? If so all the details related to this Admin will get unauthenticated"))
    {    
    xmlHttp=GetStateXmlHttpObject();
    if(xmlHttp==null) {
    alert ("Your browser does not support AJAX!");
    return;
    } 
    var url="<?php echo base_url(); ?>partners/admin/changeActiveAdminStatus/"+curStatus+"/"+adminID+"/"+newStatus;

    //alert(url);
    xmlHttp.onreadystatechange=changeActiveAdminStatus;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
    }
    }else{
    xmlHttp=GetStateXmlHttpObject();
    if(xmlHttp==null) {
    alert ("Your browser does not support AJAX!");
    return;
    } 
    var url="<?php echo base_url(); ?>partners/admin/changeActiveAdminStatus/"+curStatus+"/"+adminID+"/"+newStatus;

    //alert(url);
    xmlHttp.onreadystatechange=changeActiveAdminStatus;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);        
    }
    }

    function changeActiveAdminStatus() { 
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
$message = "";
$page = $this->uri->segment(4);
if (isset($page) && $page != '') {
    $j = $page;
} else {
    $j = 0;
}

foreach ($getAdminInfo as $index => $adminInfo) {
    $resValue[$index]['ADMIN_USER_ID'] = $j + 1;
    $resValue[$index]['USERNAME'] = $adminInfo->USERNAME;
    $resValue[$index]['EMAIL'] = $adminInfo->EMAIL;
    $resValue[$index]['CITY'] = $adminInfo->CITY;
    $resValue[$index]['STATE'] = $adminInfo->STATE;
    $resValue[$index]['COUNTRY'] = $adminInfo->CountryName;
    $resValue[$index]['PINCODE'] = $adminInfo->PINCODE;
    if ($adminInfo->ACCOUNT_STATUS == "1")
        $resValue[$index]['ACCOUNT_STATUS'] = '<span id="activatede_' . $adminInfo->ADMIN_USER_ID . '"><a href="#" onclick="javascript:activatedeaUser(1,' . $adminInfo->ADMIN_USER_ID . ',2)"><img src="' . base_url() . 'static/images/status.png" title="Click to Deactivate"></img></a></span>';
    else
        $resValue[$index]['ACCOUNT_STATUS'] = '<span id="activatede_' . $adminInfo->ADMIN_USER_ID . '"><a href="#" onclick="javascript:activatedeaUser(2,' . $adminInfo->ADMIN_USER_ID . ',1)"><img src="' . base_url() . 'static/images/status-locked.png" title="Click to Deactivate"></img></a></span>';

    $resValue[$index]['ACTIONS'] = '<a href="' . base_url() . 'admin/viewUser/' . $adminInfo->ADMIN_USER_ID . '" onclick="return hs.htmlExpand(this, { objectType: \'iframe\' } )"><img height="16" width="16" src="' . base_url() . 'static/images/info.png" title="view"></a>&nbsp;&nbsp;&nbsp;<a href="' . base_url() . 'admin/editAdmin/' . $adminInfo->ADMIN_USER_ID . '?rid=23"><img height="16" width="16" src="' . base_url() . 'static/images/edit-img.png" title="Edit"></a>';
    $j++;
}
?>
<div class="MainArea">
    <?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
        <div class="content_wrap">
            <div class="tableListWrap">
                <?php if (isset($_REQUEST['errmsg'])) {
                    echo $this->common_model->errorHandling($_REQUEST['errmsg']);
                    ?> <br/><br/><br/><br/> <?php } ?>             
                <table width="100%" class="ContentHdr">
                    <tr>
                        <td><strong>Search Admin</strong></td>
                    </tr>
                </table>
                <table width="100%" border="1" class="searchWrap" cellpadding="10" cellspacing="10">
                     <?php
                            $attributes = array('id' => 'list-admin');
                            echo form_open('admin/index?rid=23', $attributes);
                            ?>
                    <!--<tr>
                        <td width="40%">
                           
                            <span class="TextFieldHdr">
                                <?php //echo form_label('Partner Type', 'PartnerType'); ?>:
                            </span><br />  
                            <?php
                            /*if (!empty($this->session->userdata['adminSearchData']['FK_PARTNER_TYPE_ID']))
                                $PARTNER_TYPE_ID = $this->session->userdata['adminSearchData']['FK_PARTNER_TYPE_ID'];

                            echo '<select name="partnertype" id="partnertype" class="lstTextField">';
                            echo '<option value="" selected="selected">-- Select --</option>';
                            foreach ($partnerTypes as $pType) {
                                if ($PARTNER_TYPE_ID == $pType->PARTNER_TYPE_ID)
                                    echo '<option value="' . $pType->PARTNER_TYPE_ID . '" selected="selected">' . $pType->PARTNER_TYPE . '</option>';
                                else
                                    echo '<option value="' . $pType->PARTNER_TYPE_ID . '">' . $pType->PARTNER_TYPE . '</option>';
                            }
                            echo '</select>';*/
                            ?>                                        
                        </td>
                        <td width="40%">
                            <span class="TextFieldHdr">
                                <?php //echo form_label('Partner Name', 'PartnerName'); ?>:
                            </span><br />                     
                            <?php
                            /*if (!empty($this->session->userdata['adminSearchData']['PARTNER_NAME']))
                                $PARTNER_NAME = $this->session->userdata['adminSearchData']['PARTNER_NAME'];


                            echo '<select name="partnername" id="partnername" class="lstTextField">';
                            echo '<option value="0">-- Select --</option>';
                            foreach ($getOwnPartners as $partnersID) {
                                if ($partnersID->PARTNER_ID == $PARTNER_NAME)
                                    echo '<option value="' . $partnersID->PARTNER_ID . '" selected="selected">' . $partnersID->PARTNER_NAME . '</option>';
                                else
                                    echo '<option value="' . $partnersID->PARTNER_ID . '">' . $partnersID->PARTNER_NAME . '</option>';
                            }
                            echo '</select>';*/
                            ?>                                             
                        </td>
                        <td width="20%">&nbsp;</td>
                    </tr>-->
                    <tr>
                        <td width="40%">
                            <span class="TextFieldHdr">
                                <?php echo form_label('User Name', 'Username'); ?>:
                            </span><br />                    
                            <?php
                            if (!empty($this->session->userdata['adminSearchData']['USERNAME']))
                                $UsernameValue = $this->session->userdata['adminSearchData']['USERNAME'];

                            $Username = array(
                                'name' => 'username',
                                'id' => 'username',
                                'value' => $UsernameValue,
                                'class' => 'TextField',
                                'maxlength' => '45'
                            );
                            echo form_input($Username);
                            ?>                       
                        </td> 
                        <td width="40%"> <?php $adminA_status = $this->session->userdata['adminSearchData']['ACCOUNT_STATUS']; ?>
                            <span class="TextFieldHdr">
                                <?php echo form_label('Status', 'PartnerStatus'); ?>:
                            </span><br />
                            <?php /* 	if(!empty($this->session->userdata['adminSearchData']['ACCOUNT_STATUS']))
                              $ACCOUNT_STATUS = $this->session->userdata['adminSearchData']['ACCOUNT_STATUS'];

                              echo '<select name="account_status" id="account_status" class="lstTextField">';
                              if($ACCOUNT_STATUS) {
                              if($ACCOUNT_STATUS==1) {
                              echo '<option value="1" selected="selected">ACTIVE</option>';
                              echo '<option value="0">INACTIVE</option>';
                              } else {
                              echo '<option value="1">ACTIVE</option>';
                              echo '<option value="0" selected="selected">INACTIVE</option>';
                              }
                              } else { */ ?>


                            <select name="account_status" id="account_status" class="lstTextField">                                                
                                <option value="" selected="selected">--- Select ---</option>
                                <option <?php if ($adminA_status == 1) echo 'selected="selected"'; ?>  value="1">ACTIVE</option>
                                <option <?php if ($adminA_status == 2) echo 'selected="selected"'; ?> value="2">INACTIVE</option>							

                            </select>							

                        </td>                 
                        
                        <td width="20%">&nbsp;</td>                                      
                    </tr> 
                    <tr>
                        <td width="40%">
                            <span class="TextFieldHdr">
                                <?php echo form_label('Start Date', 'StartDate'); ?>:
                            </span><br />
                            <?php
                            if (!empty($this->session->userdata['adminSearchData']['CREATED_ON']))
                                $START_DATE_TIME = $this->session->userdata['adminSearchData']['CREATED_ON'];
                            else
                                $START_DATE_TIME = ""; //date('d-m-Y');									

                            $startDate = array(
                                'name' => 'startdate',
                                'id' => 'startdate',
                                'value' => $START_DATE_TIME,
                                'class' => 'TextFieldDate',
                                'readonly' => true,
                                'maxlength' => '12'
                            );
                            echo form_input($startDate);
                            ?><a onclick="NewCssCal('startdate', 'ddmmyyyy', 'arrow', false, 24, false)" href="#"><img src="<?php echo base_url() ?>static/images/calendar.png" /></a>                                            
                        </td>
                        <td width="40%">
                            <span class="TextFieldHdr">
                                <?php echo form_label('End Date', 'EndDate'); ?>:
                            </span><br />                     
                            <?php
                            if (!empty($this->session->userdata['adminSearchData']['CREATED_ON_END_DATE']))
                                $END_DATE_TIME = date('d-m-Y', strtotime($this->session->userdata['adminSearchData']['CREATED_ON_END_DATE']));
                            else
                                $END_DATE_TIME = ""; //date('d-m-Y');									

                            $endDate = array(
                                'name' => 'enddate',
                                'id' => 'enddate',
                                'value' => $END_DATE_TIME,
                                'class' => 'TextFieldDate',
                                'readonly' => true,
                                'maxlength' => '12'
                            );
                            echo form_input($endDate);
                            ?><a onclick="NewCssCal('enddate', 'ddmmyyyy', 'arrow', false, 24, false)" href="#"><img src="<?php echo base_url() ?>static/images/calendar.png" /></a> 
                        </td> 
                        <td width="20%">
                            <span class="TextFieldHdr">
                                <?php echo form_label('Date Range', 'range'); ?>:
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
                            echo form_submit('frmSearch', 'Search') . "&nbsp;";
                            echo form_submit('frmClear', 'Clear');
                            echo form_close();
                            ?>                    
                        </td>
                    </tr>                                            
                </table>

                <div class="tableListWrap">
                    <div class="data-list">

                        <?php if (!empty($searchResult) && !empty($getAdminInfo)) { ?>            
                            <table id="list2"></table>
                            <div id="pager2"></div>
                            <script type="text/javascript">
                                jQuery("#list2").jqGrid({
                                    datatype: "local",
                                    colNames: ['S.No', 'Username', 'Email', 'City', 'State', 'Country', 'Pincode', 'Status', 'Action'],
                                    colModel: [
                                        {name: 'ADMIN_USER_ID', index: 'ADMIN_USER_ID', width: 30, sortable: false},
                                        {name: 'USERNAME', index: 'USERNAME', width: 75},
                                        {name: 'EMAIL', index: 'EMAIL', width: 105},
                                        {name: 'CITY', index: 'CITY', width: 110},
                                        {name: 'STATE', index: 'STATE', width: 110},
                                        {name: 'COUNTRY', index: 'COUNTRY', width: 80},
                                        {name: 'PINCODE', index: 'PINCODE', width: 60},
                                        {name: 'ACCOUNT_STATUS', index: 'ACCOUNT_STATUS', width: 30, align: "center", sortable: false},
                                        {name: 'ACTIONS', index: 'ACTIONS', width: 30, align: "center", sortable: false}
                                    ],
                                    rowNum: 500,
                                    width: 999, height: "100%"
                                });
                                var mydata = <?php echo json_encode($resValue); ?>;
                                for (var i = 0; i <= mydata.length; i++)
                                    jQuery("#list2").jqGrid('addRowData', i + 1, mydata[i]);
                            </script>              
                            <div class="page-wrap">
                                <div class="pagination">
                                    <?php echo $pagination; ?>
                                </div>
                            </div>
                        <?php
                        } else {
                            $message = "Please select the search criteria";
                        }
                        if (empty($getAdminInfo) && !empty($searchResult))
                            $message = "There is no record to display";

                        if (!empty($message)) {
                            ?>
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