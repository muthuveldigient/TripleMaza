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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url()?>static/images/minus.gif" onclick="table_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url()?>static/images/plus.gif" onclick="table_view_valid('+ele+',\'Show\')" />';
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url()?>static/images/minus.gif" onclick="table_sub_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url()?>static/images/plus.gif" onclick="table_sub_view_valid('+ele+',\'Show\')" />';
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
        <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
        <td width="95%"><?php echo $success;?></td>
      </tr>
    </table>
  </div>
  <?php } ?>
  <?php if(isset($error) && $error!=""){ ?>
  <div class="UpdateMsgWrap">
    <table width="100%" class="ErrorMsg">
      <tr>
        <td width="45"><img src="<?php echo base_url();?>static/images/icon-error.png" alt="" width="45" height="34" /></td>
        <td width="95%"><?php echo $error;?></td>
      </tr>
    </table>
  </div>
  <?php } ?>
  <table width="100%" class="PageHdr">
    <tr>
      <td><strong><?php echo $title;?></strong>
        <table width="50%" align="right">
          <tr>
            <td><?php if(isset($this->session->userdata['ADMIN_USER_ID'])){ ?>
              <div class="UDedit"><a href="<?php echo base_url()?>cpanel_home/?p=vparl&chk=<?php echo $chk;?>">My Agents</a></div>
              <?php }else{ ?>
              <div class="UDedit"><a href="<?php echo base_url()?>agent/myagent/view">My Agents</a></div>
              <?php } ?></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <div class="tableListWrap">
    <?php
$editchk="";
if(is_array($plo)){
    if(in_array("Edit",$plo)){
        $editchk="1";
    }
}else{
    $editchk="1";
}
if($f=='pd' && $editchk=="1"){

?>
    <?php 
if(isset($this->session->userdata['ADMIN_USER_ID'])){ ?>
    <div class="UDedit"><a href="<?php echo base_url()?>cpanel_home/?p=vparl&id=<? echo base64_encode($id); ?>&chk=<?php echo $chk;?>">Back to Agents List</a></div>
    <?php } else{ ?>
    <div class="UDedit"><a href="<?php echo base_url()?>agent/myagent/detail/<? echo base64_encode($id); ?>">Back to Agents List</a></div>
    <?php } ?>
    <form name="regForm" action="" method="post" onsubmit="return updatepartner_validate (this,0);">
      <input type="hidden" name="f" id="f" value="pd" />
      <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td><table width="100%" class="ContentHdr">
              <tr>
                <td><strong>PERSONAL DETAILS</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
              <tr>
                <td width="40%"><span class="TextFieldHdr">Agent Name:</span><br />
                  <label> <?php echo $PARTNER_USERNAME;?>
                  <input name="PARTNER_USERNAME" type="hidden" class="TextField" id="PARTNER_USERNAME" maxlength="15" tabindex="2" value="<?php echo $PARTNER_USERNAME;?>" />
                  </label>
                </td>
                <td width="40%"><span class="TextFieldHdr">Password:</span><br />
                  <label>
                  <input name="PARTNER_PASSWORD" type="password" class="TextField" id="PARTNER_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
                  <span class="mandatory">*</span> </label>
                </td>
                <td width="20%"><span class="TextFieldHdr">Transaction Password:</span><br />
                  <label>
                  <input name="PARTNER_TRANSACTION_PASSWORD" type="password" class="TextField" id="PARTNER_TRANSACTION_PASSWORD" maxlength="15" tabindex="2" value="1234567890" />
                  <span class="mandatory">*</span> </label>
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
              <tr>
                <td width="40%"></td>
                <td width="40%">&nbsp;</td>
                <td width="40%">&nbsp;</td>
              </tr>
              <tr>
                <td><input type="submit" name="submit" id="submit"  value="Create" tabindex="6"  />
                  &nbsp;
                  <input type="reset" class="button" value="Reset" /></td>
              </tr>
            </table>
        </tr>
      </table>
    </form>
    <?php }else{ ?>
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td><table width="100%" class="ContentHdr">
            <tr>
              <td><strong>PERSONAL DETAILS</strong>
                <div class="UDedit">
                <?php
if(isset($this->session->userdata['ADMIN_USER_ID'])){

    if(is_array($plo)){
    if(in_array("Edit",$plo)){ ?>
                <div class="UDedit" >
                <a href="<?php echo base_url()?>cpanel_home/?p=vpard&f=pd&id=<? echo base64_encode($id); ?>&chk=<?php echo $chk;?>">Edit</a></span>
                <?php
    }
    }else{ ?>
                <div class="UDedit" ><a href="<?php echo base_url()?>cpanel_home/?p=vpard&f=pd&id=<? echo base64_encode($id); ?>&chk=<?php echo $chk;?>">Edit</a></span>
                  <?php
    }

}
else{
    if(is_array($plo)){
    if(in_array("Edit",$plo)){ ?>
                  <a href="<?php echo base_url()?>agent/myagent/edit/?f=pd&id=<? echo base64_encode($id); ?>">Edit</a>
                  <?php
    }
    }else{ ?>
                  <a href="<?php echo base_url()?>agent/myagent/edit/?f=pd&id=<? echo base64_encode($id); ?>">Edit</a>
                  <?php
    }

}

    ?>
                </div></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <?php  if($PARTNER_USERNAME){ ?>
              <td width="40%"><span class="TextFieldHdr"><strong>Agent Name:</strong></span>
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
                <div class="UDedit"> <a href="<?php echo base_url()?>admin_home/?p=vpard&id=<? echo base64_encode($id); ?>&chk=<?php echo $chk;?>">Back to Agent List</a></div>
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
    </form>
    <?php }else{ ?>
    <?php } ?>
  </div>
</div>
                  </div>
</div>
</div>
</div>
</div>
<?php echo $this->load->view("common/footer"); ?>
<script type="text/javascript" src="<?php echo base_url()?>js/popup.js"></script>
<script>
function closeDiv()
{
	document.getElementById('saved_desc').innerHTML = '';	
	document.getElementById('desc_status').value = '';
	Popup.hide('user_status_desc');
}
</script>
