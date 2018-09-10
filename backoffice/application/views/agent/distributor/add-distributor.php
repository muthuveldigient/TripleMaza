<script language="javascript">
function cleardistributordet()
{
	document.getElementById('PARTNER_USERNAME').value='';
	document.getElementById('PARTNER_PASSWORD').value='';
	document.getElementById('PARTNER_DEPOSIT').value='';
	document.getElementById('PARTNER_REVENUE_SHARE').value='';
	document.getElementById('PARTNER_TRANSACTION_PASSWORD').value='';
}
</script>
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
//	
//		var sk_v = document.getElementsByName('mnu_id_pk[]');
//		k = 0;
//		
//		for(i=0; i<len; i++)
//		{
//			if (ptr.elements[i].id == 'main_'+mdl)
//			{
//				str = ptr.elements[i].value;
//				k++;
//				usr_form_valid('main_'+mdl,'sub_'+str,val);
//			}
//		}
//		sk_mnu_valid();
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/minus.gif" onclick="table_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_view_valid('+ele+',\'Show\')" />';
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/minus.gif" onclick="table_sub_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_sub_view_valid('+ele+',\'Show\')" />';
		document.getElementById(ele3).className="";
	}
}

</script>
<script language="javascript">
    function clearagentdet()
    {
        document.getElementById('PARTNER_NAME').value='';
        document.getElementById('PARTNER_USERNAME').value='';
        document.getElementById('PARTNER_PASSWORD').value='';
        document.getElementById('PARTNER_DEPOSIT').value='';
        document.getElementById('PARTNER_REVENUE_SHARE').value='';
    }
</script>
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
//	
//		var sk_v = document.getElementsByName('mnu_id_pk[]');
//		k = 0;
//		
//		for(i=0; i<len; i++)
//		{
//			if (ptr.elements[i].id == 'main_'+mdl)
//			{
//				str = ptr.elements[i].value;
//				k++;
//				usr_form_valid('main_'+mdl,'sub_'+str,val);
//			}
//		}
//		sk_mnu_valid();
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/minus.gif" onclick="table_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_view_valid('+ele+',\'Show\')" />';
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/minus.gif" onclick="table_sub_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_sub_view_valid('+ele+',\'Show\')" />';
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
  <form onsubmit="return distributor_validate(this,0);" action="" method="POST" id="regForm" name="regForm">
    <table width="100%" class="PageHdr">
      <tr>
        <td><strong>Distributor - General Information</strong>
          <table width="50%" align="right">
            <tr>
              <td><div class="UDedit"><a href="<?php echo base_url();?>agent/distributor/view" >My Distributors</a></div></td>
            </tr>
          </table></td>
      </tr>
    </table>
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
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
      <tr>
        <td><table width="100%" class="ContentHdr">
            <tr>
              <td><strong>General Information</strong></td>
            </tr>
          </table>
          <table width="100%" cellpadding="10" cellspacing="10">
            <tr>
              <td width="40%"><span class="TextFieldHdr">Distributor Name:</span><br />
                <label>
                <input type="text" value="<?php echo $PARTNER_USERNAME;?>" tabindex="2" maxlength="25" id="PARTNER_USERNAME" class="TextField" name="PARTNER_USERNAME" />
                <span class="mandatory">*</span></label></td>
              <td width="40%"><span class="TextFieldHdr">Password:</span><br />
                <label>
                <input type="password" value="<?php echo $PARTNER_PASSWORD;?>" tabindex="3" maxlength="15" id="PARTNER_PASSWORD" class="TextField" name="PARTNER_PASSWORD" />
                <span class="mandatory">*</span></label></td>
              <td width="40%"><span class="TextFieldHdr">Transaction Password:</span><br />
                <label>
                <input type="password" value="<?php echo $PARTNER_TRANSACTION_PASSWORD;?>" tabindex="4" maxlength="15" id="PARTNER_TRANSACTION_PASSWORD" class="TextField" name="PARTNER_TRANSACTION_PASSWORD" />
                <span class="mandatory">*</span> </label></td>
            </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">Amount:</span><br />
                <label>
                <input type="text" tabindex="5" value="<?php echo $PARTNER_DEPOSIT;?>" maxlength="15" id="PARTNER_DEPOSIT" class="TextField" name="PARTNER_DEPOSIT" />
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Commission Type:</span><br />
                <label>
                <select name="PARTNER_COMMISSION_TYPE" id="PARTNER_COMMISSION_TYPE" class="ListMenu"  tabindex="6">
                  <?php
foreach($commisiontype as $val)
{
?>
                  <option value="<?php echo $val->AGENT_COMMISSION_TYPE_ID;?>" <?php if($PARTNER_COMMISSION_TYPE==$val->AGENT_COMMISSION_TYPE_ID){echo "selected='selected'";}else{echo "";}?>><?php echo $val->AGENT_COMMISSION_TYPE;?></option>
                  <?php
}
?>
                </select>
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Commission in (%):</span><br />
                <label>
                <input type="text" value="<?php echo $PARTNER_REVENUE_SHARE;?>" tabindex="7" id="PARTNER_REVENUE_SHARE" maxlength="4" class="TextField" name="PARTNER_REVENUE_SHARE" />
                <span class="mandatory">*</span> </label></td>
            </tr>
            <tr>
              <td width="40%"></td>
              <td width="40%">&nbsp;</td>
              <td width="40%">&nbsp;</td>
            </tr>
          </table>
          <table width="100%" class="ContentHdr">
            <tr>
              <td><strong>Assign - Roles</strong></td>
            </tr>
          </table>
          <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px; padding-top:10px;" >
            <?php
$i=1;

foreach($mainmenu as $mmenu){
$MAIN_MENU_ID=$mmenu->MAIN_MENU_ID;
$Mid=$mmenu->Mid;
 $MAIN_MENU_NAME=$mmenu->MAIN_MENU_NAME;
if($MAIN_MENU_ID!=""){
?>
            <tr>
              <td class="listViewheading">&nbsp;<span id="img_mdl_<?php echo $Mid;?>"> <img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_view_valid(<?php echo $Mid;?>,'Show')"/></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="mdl_id[]" id="mdl_<?php echo $Mid;?>" value="<?php echo $Mid;?>" onclick="usr_form_valid_main(this.value,this.checked)" checked />
                &nbsp;&nbsp;&nbsp;&nbsp;<?PHP echo $MAIN_MENU_NAME; ?> </td>
            </tr>
            <?php
//$data['submenu'][$mmenu->Mid]
//$MM_cnt = mysql_num_rows($sub_menu_list_results_cnt);	
?>
            <tr>
              <td id="main_border_<?php echo $Mid;?>" valign="top" ><table id="main_tbl_<?php echo $Mid;?>" cellpadding="0" cellspacing="5" width="100%" style="display:none;">
                  <?php
$MM_cnt=count($submenu[$Mid]);
foreach($submenu[$Mid] as $smenu){
if($smenu->SUB_MENU_NAME!="server kiosk" && $smenu->SUB_MENU_NAME!="kiosk ledger"){
$Sid=$smenu->Sid;
$SUB_MENU_NAME=$smenu->SUB_MENU_NAME;
?>
                  <tr>
                    <td><table cellpadding="0" cellspacing="0" width="80%" class="agentsubroles1">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="500px" class="CellLabel"><?php
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
                            <span id="img_mnu_<?php echo $Sid;?>"> <img src="<?php echo base_url();?>static/images/plus.gif" onClick="table_sub_view_valid(<?php echo $Sid;?>,'Show')" /></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
	 }else{
	 ?>
                            <span id="img_mnu_<?php echo $Sid;?>"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php } ?>
                            <input type="checkbox" name="mnu_id_pk[]" value="<?php echo $Sid;?>" id="main_<?php echo $Mid;?>" alt="SM_<?php echo $Sid;?>" onClick="usr_form_valid(this.id,'sub_<?php echo $Sid;?>',this.checked);" checked  />
                            &nbsp;&nbsp;&nbsp;&nbsp;<?PHP echo $SUB_MENU_NAME; ?> </td>
                        </tr>
                        <tr>
                          <td valign="top" class="menu_border" id="sub_border_<?php echo $Sid;?>"><table id="sub_tbl_<?php echo $Sid;?>" cellpadding="0" cellspacing="0" width="70%" style="display:none;">
                              <tr>
                                <td><table class="agentsubroles">
                                    <tr>
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
                                      <td width="50px"><input type="checkbox" name="sub_mnu_id_pk[]" value="<?php echo $Soid;?>" id="sub_<?php echo $Sid;?>" onclick="sub_mnu_chk(this.id)" alt="sk_main_<?php echo $Mid;?>" <?php if($USR_STATUS!=1){ if($GRP_OP_ID!=""){ ?> checked="checked" <?php } } else { if($GRP_MP_OP_ID!=""){ ?> checked="checked" <?php } }?> checked />
                                        &nbsp;&nbsp;<?PHP echo $SUB_MENU_OP_NAME; ?> </td>
                                      <?php
}
?>
                                    </tr>
                                  </table></td>
                              </tr>
                              <tr style="display:none;">
                                <td><input type="text" name="sk_sub[]" id="sk_sub_<?php echo $Sid;?>" alt="<?php echo $Mid;?>" title="<?php echo $SM_cnt;?>" value="<?php echo $SM_cnt;?>" />
                                </td>
                              </tr>
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                  <?php
}
}
?>
                  <tr style="display:none;">
                    <td><input type="text" name="sk_main[]" id="sk_main<?php echo $Mid;?>" value="<?php echo $MM_cnt;?>" />
                    </td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <?php
$i++;
}
}

?>
          </table>
          <div class="SeachResultWrap2">
            <input type="submit" tabindex="28" value="Create" class="button" id="Submit" name="Submit">
            <input type="button" onclick="clearagentdet();" tabindex="29" value="Reset" class="button">
          </div>
      </tr>
    </table>
  </form>
</div>
 </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>