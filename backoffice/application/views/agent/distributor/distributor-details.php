<script>
function SetChecked(val)
{
  ptr=document.regForm;
  len=ptr.elements.length;
  var i=0;
  for(i=0; i<len; i++)
	if (ptr.elements[i].name=='sub_menu_id_pk[]')
	   ptr.elements[i].checked=val;
}

function usr_form_valid_main(mdl,val)
{
	ptr=document.regForm;
	len=ptr.elements.length;
	var i=0;
	for(i=0; i<len; i++)
	{
		if (ptr.elements[i].id == 'main_'+mdl)
		{
			ptr.elements[i].checked=val;
			
			for(j=0; j<len; j++)
				if (ptr.elements[j].id=='sub_'+ptr.elements[i].value)
					ptr.elements[j].checked=val;
		}
	}
        
	if(!val)
	{
		for(i=0; i<len; i++)
			if (ptr.elements[i].name == 'sk_sub[]' && ptr.elements[i].alt == mdl)
				ptr.elements[i].value = 0;
	}
	else
	{
	}
	return true;
}

function usr_form_valid(id,mdl,val)
{
	ptr=document.regForm;
	len=ptr.elements.length;
	var i=0, j=0, k=0;
	for(i=0; i<len; i++)
	{
		if(ptr.elements[i].id==mdl)
		{
			ptr.elements[i].checked=val;
				if(ptr.elements[i].checked)
					j++;
		}
	}
	for(i=0; i<len; i++)
	{
		if(ptr.elements[i].id==id)
		{
			if(ptr.elements[i].checked)
				k++;
		}
	}
	
	str = mdl.indexOf("_");
	str++;
	str1 = mdl.substr(str);
	
	document.getElementById('sk_sub_'+str1).value = j;
	//document.getElementById('sk_'+id).value = k;
	
	sk_mnu_valid();
	return true;
}

function sk_mnu_valid()
{
	ptr=document.regForm;
	len=ptr.elements.length;
	var i=0;
	for(i=0; i<len; i++)
	{
		str = ptr.elements[i].id.lastIndexOf("_");
		str++;
		str = ptr.elements[i].id.substr(str);
		if(ptr.elements[i].name=='sk_sub[]')
		{
			if(ptr.elements[i].value == ptr.elements[i].title)
			{
				for(j=0; j<len; j++)
				{
					if (ptr.elements[j].alt=='main_'+str)
					{
						ptr.elements[j].checked = true;
					}
				}
			}
			else
			{
				for(j=0; j<len; j++)
				{
					if (ptr.elements[j].alt=='main_'+str)
					{
						ptr.elements[j].checked = false;
					}
				}
			}
		}
		
		if(ptr.elements[i].name=='sk_main[]')
		{
			skcnt = 0;
			for(j=0; j<len; j++)
			{
				if (ptr.elements[j].id=='main_'+str)
				{
					if (ptr.elements[j].checked)
						skcnt++;
				}
			}
			
			if(skcnt == ptr.elements[i].value)
				document.getElementById('mdl_'+str).checked = true;
			else
				document.getElementById('mdl_'+str).checked = false;
		}
	}
}

function sub_mnu_chk(id)
{
	ptr=document.regForm;
	len=ptr.elements.length;
	var i=0, j=0;
	for(i=0; i<len; i++)
	{
		if (ptr.elements[i].id==id)
		{
			if (ptr.elements[i].checked)
				j++;
		}
	}
	
	document.getElementById('sk_'+id).value = j;
	sk_mnu_valid();
	return true;
}

function table_view_valid(ele,val)
{
	browser = navigator.appName;
	ele1 = 'main_tbl_'+ele;
	ele2 = 'img_mdl_'+ele;
	ele3 = 'main_border_'+ele;
	if(val == 'Show')
	{
		if(browser!='Netscape')
		{
			document.getElementById(ele1).style.display='table-row';
		}
		else
		{
			document.getElementById(ele1).style.display='block';
		}
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>static/images/minus.gif" onclick="table_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>static/images/plus.gif" onclick="table_view_valid('+ele+',\'Show\')" />';
		document.getElementById(ele3).className="";
	}
}

function table_sub_view_valid(ele,val)
{
	browser = navigator.appName;
	ele1 = 'sub_tbl_'+ele;
	ele2 = 'img_mnu_'+ele;
	ele3 = 'sub_border_'+ele;
	if(val == 'Show')
	{
		if(browser!='Netscape')
		{
			document.getElementById(ele1).style.display='table-row';
		}
		else
		{
			document.getElementById(ele1).style.display='block';
		}
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>static/images/minus.gif" onclick="table_sub_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>static/images/plus.gif" onclick="table_sub_view_valid('+ele+',\'Show\')" />';
		document.getElementById(ele3).className="";
	}
}
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     
<?php
$editchk="";
if(is_array($plo)){
    if(in_array("Edit",$plo)){
        $editchk="1";
    }
}else{
    $editchk="1";
}

foreach($details as $val){
@extract($val);
}
$display=0;
if($IS_OWN_PARTNER==1){
$title="Main Agent Details";
$display=1;
}
if($IS_DISTRIBUTOR==1){
$title="Distributor Details";
}
else{
$title="Agent Details";
}
?>
<?php if(isset($success) && $success!=""){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="SuccessMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-success.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo $success;?></td>
    </tr>
  </table>
</div>
<?php } ?>
<?php if(isset($error) && $error!=""){ ?>
<div class="UpdateMsgWrap">
  <table width="100%" class="ErrorMsg">
    <tr>
      <td width="45"><img src="<?php echo base_url();?>images/icon-error.png" alt="" width="45" height="34" /></td>
      <td width="95%"><?php echo $error;?></td>
    </tr>
  </table>
</div>
<?php } ?>
<table width="100%" class="PageHdr">
  <tr>
    <td><strong>Distributor Detail</strong>
      <table width="50%" align="right">
        <tr>
          <td><?php if(isset($this->session->userdata['ADMIN_USER_ID'])){ ?>
            <div class="UDedit"><a href="<?php echo base_url()?>cpanel_home/?p=vparl&chk=<?php echo $chk;?>">My Agents</a></div>
            <?php }else{ ?>
           <!-- <div class="UDedit"><a href="<?php echo base_url()?>admin_home/?p=vparl&chk=<?php echo $chk;?>">My Agents</a></div>-->
            <?php } ?></td>
        </tr>
      </table></td>
  </tr>
</table>
<div class="tableListWrap">
<?php

if($f=='pd' && $editchk=="1"){

?>
<form name="regForm" method="post" onsubmit="return updatedistributor_validate (this,0);">
  <input type="hidden" name="f" id="f" value="pd"/>
  <div class="UDedit"><a href="<?php echo base_url()?>agent/distributor/detail/<? echo base64_encode($id); ?>">Back to Distributors List</a></div>
  <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
  <tr>
    <td><table width="100%" class="ContentHdr">
        <tr>
          <td><strong>PERSONAL DETAILS</strong></td>
        </tr>
      </table>
      <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Distributor Name:</span><br />
            <label> <?php echo $PARTNER_USERNAME;?>
            <input name="PARTNER_USERNAME" type="hidden" class="TextField" id="PARTNER_USERNAME" maxlength="15" tabindex="2" value="<?php echo $PARTNER_USERNAME;?>" />
            </label>
          </td>
          <td width="40%"><span class="TextFieldHdr">Password:</span><br />
            <label>
            <input name="PARTNER_PASSWORD" type="password" class="UDTxtField" id="PARTNER_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
            &nbsp;<span class="mandatory">*</span> </label>
          </td>
          <td width="20%"><span class="TextFieldHdr">Transaction Password:</span><br />
            <label>
            <input name="PARTNER_TRANSACTION_PASSWORD" type="password" class="UDTxtField" id="PARTNER_TRANSACTION_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
            &nbsp;<span class="mandatory">*</span> </label>
          </td>
        </tr>
        <?php
     if($PARTNER_USERNAME){  
	  ?>
        <tr>
          <td width="40%"><span class="TextFieldHdr">Commission Type:</span><br />
            <label>
            <select name="PARTNER_COMMISSION_TYPE" id="PARTNER_COMMISSION_TYPE" class="ListMenu"  tabindex="3">
              <?php
	foreach($commissiontype as $rowcntm){
		?>
              <option value="<?php echo $rowcntm->AGENT_COMMISSION_TYPE_ID;?>" <?php if($PARTNER_COMMISSION_TYPE==$rowcntm->AGENT_COMMISSION_TYPE_ID){ echo "selected";} ?> ><?php echo $rowcntm->AGENT_COMMISSION_TYPE;?></option>
              <?php
	}
   ?>
            </select>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Commission in (%):</span><br />
            <label>
            <input name="PARTNER_REVENUE_SHARE" type="text" class="TextField" maxlength="5" id="PARTNER_REVENUE_SHARE" tabindex="4" value="<?php echo $PARTNER_REVENUE_SHARE;?>" />
            &nbsp;<span class="mandatory">*</span> </label></td>
        </tr>
        <?php } ?>
        <!-- <tr>
        <td width="40%"><span class="TextFieldHdr">
                  Assign - Roles
              </span><br />
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="agentrole">
<?php
$i=1;
//print_r($mainmenu);
foreach($mainmenu as $mmenu){
$MAIN_MENU_ID=$mmenu->MAIN_MENU_ID;
$Mid=$mmenu->Mid;
$MAIN_MENU_NAME=$mmenu->MAIN_MENU_NAME;
if($MAIN_MENU_ID!=""){
    
    echo $MAIN_MENU_ID;
?>
<tr>
<td class="listViewheading">
&nbsp;<span id="img_mdl_<?php echo $Mid;?>">
<img src="<?php echo base_url();?>images/plus.gif" onclick="table_view_valid(<?php echo $Mid;?>,'Show')"/></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="mdl_id[]" id="mdl_<?php echo $Mid;?>" value="<?php echo $Mid;?>" <?php if($MAIN_MENU_ID!=""){?> checked="checked" <?php }?> onclick="usr_form_valid_main(this.value,this.checked)"  />&nbsp;&nbsp;&nbsp;&nbsp;<?PHP echo $MAIN_MENU_NAME; ?>
</td>
</tr>
<?php
//$data['submenu'][$mmenu->Mid]
//$MM_cnt = mysql_num_rows($sub_menu_list_results_cnt);	
?>
<tr>
<td id="main_border_<?php echo $Mid;?>" valign="top" >
<table id="main_tbl_<?php echo $Mid;?>" cellpadding="0" cellspacing="5" width="100%" style="display:none;">
<?php
$MM_cnt=count($submenu[$Mid]);
foreach($submenu[$Mid] as $smenu){
$Sid=$smenu->Sid;
$SUB_MENU_NAME=$smenu->SUB_MENU_NAME;
?>
<tr>
<td>
<table cellpadding="0" cellspacing="0" width="80%" class="agentsubroles1">
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td width="500px" class="CellLabel">
<?php
$optavail="";
	if(count($suboptmenutotl[$Sid])>0)
	{
	$optavail="1";
	}else{
	$optavail="0";
	}
?>    
<?php
	if($optavail=="1"){
?>
<span id="img_mnu_<?php echo $Sid;?>">
<img src="<?php echo base_url();?>images/plus.gif" onClick="table_sub_view_valid(<?php echo $Sid;?>,'Show')" /></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	 }else{
	 ?>
<span id="img_mnu_<?php echo $Sid;?>"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php } ?>
<input type="checkbox" name="mnu_id_pk[]" value="<?php echo $Sid;?>" id="main_<?php echo $Mid;?>" alt="SM_<?php echo $Sid;?>" onClick="usr_form_valid(this.id,'sub_<?php echo $Sid;?>',this.checked);" checked  />&nbsp;&nbsp;&nbsp;&nbsp;<?PHP echo $SUB_MENU_NAME; ?>
</td>
</tr>
<tr>
<td valign="top" class="menu_border" id="sub_border_<?php echo $Sid;?>">
<table id="sub_tbl_<?php echo $Sid;?>" cellpadding="0" cellspacing="0" width="70%" style="display:none;">
<tr>
<td>
<table class="agentsubroles"><tr>
<?php
//$data['suboptmenu'][$sopt->Sid]
$SM_cnt=count($suboptmenu[$Sid]);
foreach($suboptmenu[$Sid] as $soptmenu){
//print_r($soptmenu);
$Soid=$soptmenu->Soid;
$SUB_MENU_OP_NAME=$soptmenu->SUB_MENU_OP_NAME;
if(isset($soptmenu->GRP_MP_OP_ID) && $soptmenu->GRP_MP_OP_ID!=""){
$GRP_MP_OP_ID=$soptmenu->GRP_MP_OP_ID;
}
else{
$GRP_MP_OP_ID="";
}
if(isset($soptmenu->GRP_OP_ID) && $soptmenu->GRP_OP_ID!=""){
$GRP_OP_ID=$soptmenu->GRP_OP_ID;
}
else{
$GRP_OP_ID="";
}
?>
<td width="50px">
<input type="checkbox" name="sub_mnu_id_pk[]" value="<?php echo $Soid;?>" id="sub_<?php echo $Sid;?>" onclick="sub_mnu_chk(this.id)" alt="sk_main_<?php echo $Mid;?>" <?php if($USR_STATUS!=1){ if($GRP_OP_ID!=""){ ?> checked="checked" <?php } } else { if($GRP_MP_OP_ID!=""){ ?> checked="checked" <?php } }?> checked />
&nbsp;&nbsp;<?PHP echo $SUB_MENU_OP_NAME; ?>
</td>
<?php
}
?>
</tr>
</table>
</td>
</tr>
<tr style="display:none;">																																																																																																																																																																																																																																																																																																																																														
<td>
<input type="text" name="sk_sub[]" id="sk_sub_<?php echo $Sid;?>" alt="<?php echo $Mid;?>" title="<?php echo $SM_cnt;?>" value="<?php echo $SM_cnt;?>" />
</td>
</tr>
</table>
</td>
</tr>
</table> 
</td>
</tr>
<?php
}
?>
<tr style="display:none;">																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																
<td>
<input type="text" name="sk_main[]" id="sk_main<?php echo $Mid;?>" value="<?php echo $MM_cnt;?>" />
</td>
</tr>
</table>
</td>
</tr>
<tr><td>&nbsp;</td></tr>
<?php
$i++;
}
}

?>
</table>
        </td>
        <td width="40%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
      </tr>-->
        <tr>
          <td><input type="submit" name="submit" id="submit" class="button" value="Save" tabindex="25" />
            <input name="PARTNER_ID" type="hidden" value="<?php echo $id; ?>" /></td>
        </tr>
      </table>
</form>
</tr>
</table>
<?php }else{ ?>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
  <tr>
    <td><table width="100%" class="ContentHdr">
        <tr>
          <td><strong>PERSONAL DETAILS</strong>
            <div class="UDedit">
              <?php
    if(is_array($plo)){
    if(in_array("Edit",$plo)){ ?>
              <div class="UDedit"><a href="<?php echo base_url(); ?>agent/distributor/edit/pd/<?php echo base64_encode($id); ?>">Edit</a></div>
              <?php
    }
    }else{ ?>
              <div class="UDedit"><a href="<?php echo base_url(); ?>agent/distributor/edit/pd/<?php echo base64_encode($id); ?>">Edit</a></div>
              <?php
    }
    ?>
            </div></td>
        </tr>
      </table>
      <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <?php  if($PARTNER_USERNAME){ ?>
          <td width="40%"><span class="TextFieldHdr"><strong>Distributor Name:</strong></span>
            <label> <?php echo $PARTNER_USERNAME;?> </label>
          </td>
          <?php } ?>
          <td width="40%"><span class="TextFieldHdr"><strong>Commission Type:</strong></span>
            <label>
            <?php if($PARTNER_COMMISSION_TYPE=="1"){echo "Turnover";}else{ echo "Revenue";} ?>
            </label>
          </td>
          <td width="20%"><span class="TextFieldHdr"><strong>Commission in (%):</strong></span>
            <label> <?php echo $PARTNER_REVENUE_SHARE; ?> </label>
          </td>
        </tr>
        <tr>
          <td width="40%"></td>
          <td width="40%">&nbsp;</td>
          <td width="40%">&nbsp;</td>
        </tr>
      </table>
  </tr>
</table>
<?php } ?>
<?php if($f=='w'){ ?>
<form name="regForm" action="" method="post" onsubmit="return validate_registration();">
<input type="hidden" name="f" id="f" value="w" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
  <tr>
    <td><table width="100%" class="ContentHdr">
        <tr>
          <td><strong>WALLET</strong></td>
          
          <div class="UDedit"><a href="<?php echo base_url()?>agent/distributor/detail/<? echo base64_encode($id); ?>">Back to Distributors List</a></div>
        </tr>
      </table>
      <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Agent Name:</span><br />
            <label> <?php echo $PARTNER_USERNAME;?>
            <input name="PARTNER_USERNAME" type="hidden" class="UDTxtField" id="PARTNER_USERNAME" maxlength="15" tabindex="2" value="<?php echo $PARTNER_USERNAME;?>" />
            </label>
          </td>
          <td width="40%"><span class="TextFieldHdr">Password:</span><br />
            <label>
            <input name="PARTNER_PASSWORD" type="password" class="UDTxtField" id="PARTNER_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
            <span class="mandatory">*</span> </label>
          </td>
          <td width="20%"><span class="TextFieldHdr">Transaction Password:</span><br />
            <label>
            <input name="PARTNER_TRANSACTION_PASSWORD" type="password" class="UDTxtField" id="PARTNER_TRANSACTION_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
            <span class="mandatory">*</span> </label>
          </td>
        </tr>
        <?php
     if($PARTNER_USERNAME){  
	  ?>
        <tr>
          <td width="40%"><span class="TextFieldHdr">Commission Type:</span><br />
            <label>
            <select name="PARTNER_COMMISSION_TYPE" id="PARTNER_COMMISSION_TYPE" class="Textselct"  tabindex="3">
              <?php
	foreach($commissiontype as $rowcntm){
		?>
              <option value="<?php echo $rowcntm->AGENT_COMMISSION_TYPE_ID;?>" <?php if($PARTNER_COMMISSION_TYPE==$rowcntm->AGENT_COMMISSION_TYPE_ID){ echo "selected";} ?> ><?php echo $rowcntm->AGENT_COMMISSION_TYPE;?></option>
              <?php
	}
   ?>
            </select>
            </label></td>
          <td width="40%"><span class="TextFieldHdr">Commission in (%):</span><br />
            <label>
            <input name="PARTNER_REVENUE_SHARE" type="text" class="UDTxtField" maxlength="5" id="PARTNER_REVENUE_SHARE" tabindex="4" value="<?php echo $PARTNER_REVENUE_SHARE;?>" />
            &nbsp;<span class="mandatory">*</span> </label></td>
        </tr>
        <?php } ?>
        <tr>
          <td width="40%"></td>
          <td width="40%">&nbsp;</td>
          <td width="40%">&nbsp;</td>
        </tr>
        <tr>
          <td><input type="submit" name="Submit" id="Submit"  value="Create" tabindex="6"  />
            &nbsp;
            <input type="reset" class="button" value="Reset" /></td>
        </tr>
      </table>
  </tr>
</table>
<?php }else{ ?>
<!--<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
          <table width="100%" class="ContentHdr">
      <tr>
        <td><strong>Payment Transactions</strong></td>
      </tr>
        </table>
       <table width="100%" cellpadding="10" cellspacing="10">
       <tr>
        <td width="40%"><span class="TextFieldHdr"><strong>Balance:</strong></span>
          <label>
          <?php echo $cash; ?>
          </label>
        </td>
        <td width="40%"><span class="TextFieldHdr"><strong>Adjust Distributor Balance:</strong></span>
          <label>
           <?php   
              if(isset($this->session->userdata['ADMIN_USER_ID'])){
                if($display==1){
        ?>
              <span class="UDeditR" ><a href="<?php echo base_url()?>cpanel_home/?p=cmadd&uid=<? echo base64_encode($PARTNER_USERNAME); ?>&chk=<?php echo $chk;?>">Manage</a></span>
          <?php
                }
              }else{
         ?>     
              <span class="UDeditR" ><a href="<?php echo base_url()?>admin_home/?p=cmadd&uid=<? echo base64_encode($PARTNER_USERNAME); ?>&chk=<?php echo $chk;?>">Manage</a></span>
         <?php
              }
         ?>     
          </label>
        </td>
        
        <td width="20%"><span class="TextFieldHdr"><strong>Transaction:</strong></span><br/>
          <label>
            <?php if(isset($this->session->userdata['ADMIN_USER_ID'])){ ?>  
            <span class="UDeditR" ><a href="<?php echo base_url()?>cpanel_home/?p=vlsdr&parid=<? echo base64_encode($PARTNER_ID); ?>&chk=<?php echo $chk;?>" >View Ledger (Click)</a></span>
          <?php }else{ ?>
            <span class="UDeditR" ><a href="<?php echo base_url()?>admin_home/?p=vlsdr&parid=<? echo base64_encode($PARTNER_ID); ?>&chk=<?php echo $chk;?>" >View Ledger (Click)</a></span>
           <?php } ?> 
          </label>
        </td>
        
      </tr>
	  
      
      
      <tr>
          <td width="40%"></td>
        <td width="40%">&nbsp;</td>
        <td width="40%">&nbsp;</td>
      </tr>
      
    </table>
       </td>        
      </tr>
    </table>-->
<?php } ?>
</div>
</div>
 </div>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url()?>js/popup.js"></script>
<script>
function closeDiv()
{
	document.getElementById('saved_desc').innerHTML = '';	
	document.getElementById('desc_status').value = '';
	Popup.hide('user_status_desc');
}
</script>
<?php $this->load->view("common/footer"); ?>
