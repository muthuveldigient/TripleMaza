<script language="javascript">
    function clearagentdet()
    {
        document.getElementById('PARTNER_USERNAME').value='';
        document.getElementById('PARTNER_PASSWORD').value='';
        document.getElementById('PARTNER_TRANSACTION_PASSWORD').value='';
        document.getElementById('PARTNER_DEPOSIT').value='';
        document.getElementById('PARTNER_REVENUE_SHARE').value='';
        document.getElementById('PARTNER_DISTRIBUTOR').value='';
        
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
function showsubagents(ptid,pid)
{
        xmlHttp3=GetXmlHttpObject()
        
        var url='<?php echo base_url();?>agent/ajax/showsubagents';    
       
	url=url+"?ptid="+ptid+"&pid="+pid;
        
	xmlHttp3.onreadystatechange=Showagent
	xmlHttp3.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp3.send();
    //loader(0);
       
	return false;
}

function Showagent() 
{
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState=="complete")
    {       var result='';	
            result=xmlHttp3.responseText;
            document.getElementById("subagentssec").innerHTML=result;
    }else{
        document.getElementById("subagentssec").innerHTML='<img src="<?php echo base_url();?>static/images/loading2.gif">';
    }
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
<?php echo $this->load->view("common/sidebar");
    $error=$this->input->get('err');
    $success=$this->input->get('suc');
?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     
    
  <form name="regForm" id="regForm" method="POST" onsubmit="return partner_validate(this,0);">
    <table width="100%" class="PageHdr">
      <tr>
        <td><strong>Agent - General Information</strong>
          <table width="50%" align="right">
            <tr>
              <td><div class="UDedit"><a href="<?php echo base_url();?>admin_home/?p=vparl&chk=2" >My Agents</a></div></td>
            </tr>
          </table></td>
      </tr>
    </table>
    <?php if(isset($success) && $success!=""){ ?>
    <div class="UpdateMsgWrap">
      <table width="100%" class="SuccessMsg">
        <tr>
          <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
          <td width="95%"><?php echo "Agent Added Successfully.";?></td>
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
              <td width="40%"><span class="TextFieldHdr">Agent Name:</span><br />
                <label>
                <input name="PARTNER_USERNAME" type="text" class="TextField" id="PARTNER_USERNAME" maxlength="25" tabindex="1" value="<?php echo $PARTNER_USERNAME?>" />
                <span class="mandatory">*</span></label></td>
              <td width="40%"><span class="TextFieldHdr">Password:</span><br />
                <label>
                <input name="PARTNER_PASSWORD" type="password" class="TextField" id="PARTNER_PASSWORD" maxlength="15" tabindex="2" value="<?php echo $PARTNER_PASSWORD; ?>" />
                <span class="mandatory">*</span></label></td>
              <td width="40%"><span class="TextFieldHdr">Transaction Password:</span><br />
                <label>
                <input type="password" value="<?php echo $PARTNER_TRANSACTION_PASSWORD;?>" tabindex="4" maxlength="15" id="PARTNER_TRANSACTION_PASSWORD" class="TextField" name="PARTNER_TRANSACTION_PASSWORD" />
                </label></td>
            </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">Amount:</span><br />
                <label>
                <input name="PARTNER_DEPOSIT" type="text" class="TextField" id="PARTNER_DEPOSIT" maxlength="15"  value="<?php echo $PARTNER_DEPOSIT; ?>" tabindex="5" />
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Commission Type:</span><br />
                <label>
                <select name="PARTNER_COMMISSION_TYPE" id="PARTNER_COMMISSION_TYPE" class="ListMenu"  tabindex="6">
                  <?php
                    foreach($commisiontype as $val)
                    {
                    ?>
                  <option value="<?php echo $val->AGENT_COMMISSION_TYPE_ID;?>" <?php if($PARTNER_COMMISSION_TYPE==$val->AGENT_COMMISSION_TYPE_ID){echo "selected='selected'";}else{echo "";} ?>><?php echo $val->AGENT_COMMISSION_TYPE;?></option>
                  <?php
                    }
                    ?>
                </select>
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Commission in (%):</span><br />
                <label>
                <input name="PARTNER_REVENUE_SHARE" type="text" class="TextField" maxlength="4" id="PARTNER_REVENUE_SHARE" tabindex="7" value="<?php echo $PARTNER_REVENUE_SHARE?>" />
                <span class="mandatory">*</span> </label></td>
            </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">Partner Type:</span><br />
                <label>
                <select name="PARTNER_TYPE_ID" id="PARTNER_TYPE_ID" class="ListMenu" onchange="showsubagents((this.value-1),<?php echo $this->session->userdata('partnerid');?>)" />
                 <?php 
                 foreach($partnertypeid as $partner_typeid){
                    foreach($partner_typeid as $ptypeid=>$ptype){ ?>   
                            <option value="<?php echo $ptypeid;?>"><?php echo $ptype;?></option>
              <?php }
                 }
               ?>   
                </select>
                </label>
              </td>
              <td>
                  <div id="subagentssec" name="subagentssec"></div> 
              </td>
            </tr>
            <tr>
               <td width="40%"><span class="TextFieldHdr">Email:</span><br />
                <label>
                <input name="EMAIL" type="text" class="TextField" id="EMAIL" tabindex="9" value="<?php echo $EMAIL;?>" />
                </label></td>
               <td width="40%"><span class="TextFieldHdr">Country:</span><br />
                <label>
                <select name="PARTNER_COUNTRY" class="ListMenu" id="PARTNER_COUNTRY" onchange="showstate(this.value);" tabindex="10" >
                  <option value="">------- Select Country ------------</option>
                  <?php
   foreach($countries as $country){
   ?>
                  <option value="<?php echo $country->CountryName;?>" <?php if(strtolower($PARTNER_COUNTRY)==strtolower($country->CountryName)){echo "selected='selected'";}else{echo "";} ?>><?php echo $country->CountryName;?></option>
                  <?php
   }
   ?>
                </select>
                </label></td> 
            </tr>
            <tr>
              <td width="40%"><span class="TextFieldHdr">State:</span><br />
                <label>
                <select name="PARTNER_STATE" id="PARTNER_STATE" class="ListMenu" tabindex="11">
                  <option value=''>--------- Select State -------------------------------------</option>
                  <?php
           foreach($states as $state){
           ?>
                  <option value="<?php echo $state->StateName;?>" <?php if(strtolower($PARTNER_STATE)==strtolower($state->StateName)){echo "selected='selected'";}else{echo "";} ?>><?php echo ucfirst(strtolower($state->StateName));?></option>
                  <?php
           }
           ?>
                </select>
                </label>
              </td>
              <td width="40%">Area:</span><br />
                <label>
                <input name="PARTNER_ADDRESS1" type="text" class="TextField" id="PARTNER_ADDRESS1" maxlength="64" tabindex="12" value="<?php echo $PARTNER_ADDRESS1;?>"  />
                </label>
              </td>
              <td width="40%"> Phone:</span><br />
                <label>
                <input name="PARTNER_PHONE" type="text" class="TextField" id="PARTNER_PHONE" maxlength="64" tabindex="13" value="<?php echo $PARTNER_PHONE;?>"  />
                </label>
              </td>
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
          <table width="100%" border="0" cellpadding="0" cellspacing="0" class="agentrole">
            <?php
$i=1;
$dataid=array("adminuserid"=>$this->session->userdata['adminuserid'],"partnerid"=>$this->session->userdata['partnerid']);                 
$menu=$this->common_model->generate_menu($dataid); 
//echo "inside";

foreach($menu as $mmenu){
 
//echo $mmenu['roleid'];
//echo $mmenu['role'];
$MAIN_MENU_ID=$mmenu['roleid'];
$Mid=$mmenu['roleid'];
$MAIN_MENU_NAME=$mmenu['role'];
if($MAIN_MENU_ID!=""){
?>
            <tr>
              <td class="listViewheading">&nbsp;
                  <?php if($mmenu['submenu']!=''){ ?>
                  <span id="img_mdl_<?php echo $Mid;?>"> <img src="<?php echo base_url();?>static/images/plus.gif" onclick="table_view_valid(<?php echo $Mid;?>,'Show')"/></span>
                  &nbsp;
                  <?php }else{ ?>
                  &nbsp;&nbsp;&nbsp;&nbsp;
                  <?php } ?>
                <input type="checkbox" name="mdl_id[]" id="mdl_<?php echo $Mid;?>" value="<?php echo $Mid;?>" onclick="usr_form_valid_main(this.value,this.checked)" checked />
                &nbsp;&nbsp;<?PHP echo $MAIN_MENU_NAME; ?> </td>
            </tr>
            <?php
//$data['submenu'][$mmenu->Mid]
//$MM_cnt = mysql_num_rows($sub_menu_list_results_cnt);	
?>
            <tr>
              <td id="main_border_<?php echo $Mid;?>" valign="top" ><table id="main_tbl_<?php echo $Mid;?>" cellpadding="0" cellspacing="5" width="100%" style="display:none;">
                  <?php
if(isset($mmenu['submenu'])){                  
$MM_cnt=count($mmenu['submenu']);
foreach($mmenu['submenu'] as $smenu){
   // echo "<pre>";
    
 $Sid=$smenu['roleid'];
 $SUB_MENU_NAME=$smenu['subrole'];
?>
                  <tr>
                    <td><table cellpadding="0" cellspacing="0" width="80%" class="agentsubroles1">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="500px" class="CellLabel"><?php
$optavail="";
	if(count($mmenu[subsubmenu])>0)
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
                            &nbsp;<?PHP echo $SUB_MENU_NAME; ?> </td>
                        </tr>
                        <tr>
                          <td valign="top" class="menu_border" id="sub_border_<?php echo $Sid;?>"><table id="sub_tbl_<?php echo $Sid;?>" cellpadding="0" cellspacing="0" width="70%" style="display:none;">
                              <tr>
                                <td><table class="agentsubroles">
                                    <tr>
                                      <?php
                                      $SM_cnt=count($mmenu[subsubmenu]);
                                      foreach($mmenu[subsubmenu] as $soptmenu){
                                      ?>
                                      <td width="50px"><input type="checkbox" name="sub_mnu_id_pk[]" value="<?php echo $Sid;?>" id="sub_<?php echo $Sid;?>" onclick="sub_mnu_chk(this.id)" alt="sk_main_<?php echo $Sid;?>"  checked />
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

?>      <input type="hidden" name="rid" id="rid" value="<?php echo $rid;?>">
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
<!-- ContentWrap -->
<?php $this->load->view("common/footer"); ?>