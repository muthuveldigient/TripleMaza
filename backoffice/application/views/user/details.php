<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<script src="<?php echo base_url();?>static/js/lightbox-form.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/lightbox-form.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function Hidedist()
{
    document.getElementById("affiliatesection").innerHTML='';    
}

function openDESCRIPTION_Div(id)
{
	if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user will get unauthenticated"))
	{
		document.getElementById('userSID').value = id;
		Popup.show('user_status_desc');
	}
}

function UserDeActivateDescription()
{
        xmlHttp=GetXmlHttpObject()
        var userid=document.getElementById('userSID').value;
        var desc=document.getElementById('desc_status').value;
		
		if(desc == ''){
		  alert("Please enter description");
		  return false;
		}
		
		
        var url='<?php echo base_url();?>user/ajax/deauthendicate/'+userid+'/'+desc;    
	var def="def"+userid;
        var ele="dact"+userid;
        var acc="act"+userid;
	xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
            var result=xmlHttp.responseText;
            document.getElementById("saved_desc").innerHTML=result;  
            document.getElementById(ele).innerHTML='<a href="javascript:authenticate(\'act'+userid+'\', \''+userid+'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''+global_baseurl+'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
            document.getElementById(ele).style.display='';
            document.getElementById(def).style.display='none';
            document.getElementById(acc).style.display='none';
        }
       } 
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
       
	return false;
}

function Deactive()
{
    if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    { 		
              
    }
}

function authenticate(ele,typ,id,att)
{

   if(confirm("Do you really want to authenticate this user? If so all the details related to this user wil get authenticated"))
   {
    var xmlHttp=GetXmlHttpObject();
    
    var url='<?php echo base_url();?>user/ajax/authendicate/'+typ;    
    
    //alert(url);
    
    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
           // Activeuser(ele,typ,xmlhttp.responseText);
            var result=xmlHttp.responseText;
            //alert("test");
   document.getElementById(ele).innerHTML='<a href=javascript:openDESCRIPTION_Div('+typ+'); title=Acive><img src='+global_baseurl+'static/images/active.gif alt="Acive" border="0" /></a>';    
     
    var def="def"+typ;
	var dac="dact"+typ;
            //alert(result);

            if(result=='Activated'){
              document.getElementById(ele).style.display='';  
              document.getElementById(def).style.display='none';  
			  document.getElementById(dac).style.display='none'; 
            }
        }
    }
    
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
   }
}

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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>images/minus.gif" onclick="table_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>images/plus.gif" onclick="table_view_valid('+ele+',\'Show\')" />';
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
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>images/minus.gif" onclick="table_sub_view_valid('+ele+',\'Hide\')" />';
		document.getElementById(ele3).className="menu_border";
	}
	else
	{
		document.getElementById(ele1).style.display='none';
		document.getElementById(ele2).innerHTML = '<img src="<?php echo base_url(); ?>images/plus.gif" onclick="table_sub_view_valid('+ele+',\'Show\')" />';
		document.getElementById(ele3).className="";
	}
}
function validate_form(field,e){
                
                var cha1 = /^\d+(\.\d+)?$/;
                
        if(trim(DEFAULT_POINTS.value)!=""){
			if(isNaN(DEFAULT_POINTS.value))
                        {
                            alert("Default amount only allowed in numbers");
                            DEFAULT_POINTS.focus();
                            return false;
                        }
                        
                        if(!cha1.test(trim(DEFAULT_POINTS.value)) && DEFAULT_POINTS.value!="") 
                        {
                            alert("Special characters are not allowed in default amount");
                            DEFAULT_POINTS.focus();
                            return false;
                        }
		}
		
		if(MAC_ID.value!=''){	
		var mac_address = /^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/;
	
		if(mac_address.test(MAC_ID.value)==false){
			alert("Invalid Mac Address");
			MAC_ID.focus();
			return false;
		}
		}
}
</script>

<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
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
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/> <?php } ?>        
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
      <table width="100%" class="ContentHdr">
        <tr>
          <td><strong>User Detail</strong>
            <table width="50%" align="right">
              <tr>
                <td><table width="50%" align="right">
                    <tr>
                      <td><div style="position:relative;left:5px;" align="right"><img style="width:16px;height:16px;" src="<?php echo base_url();?>static/images/edit.png" alt="" /><a style="padding:5px; color:#FFFFFF" class="dettxt" href="<?php echo base_url(); ?>user/account/edit/<?php echo  $results->USER_ID; ?>?rid=10">Edit</a></div></td>
                 <!--     <td><div align="right"><img style="width:16px;height:16px;" src="<?php echo base_url();?>static/images/list.png" alt="" /><a style="padding:5px;" class="dettxt" href="<?php echo base_url(); ?>user/account/search">Players List</a></div></td>-->
                    </tr>
                  </table></td>
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
foreach($details as $val){
@extract($val);
}
?>
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>PERSONAL INFORMATION</strong>
                    </td>
                </tr>
              </table>
<?php		    $username  = $results->USERNAME;
				$userid	   = $this->Account_model->getUserIdByName($results->USERNAME);
			    $email     = $results->EMAIL_ID;
			    $country   = $results->COUNTRY;
			    $state     = $results->STATE;
			    $city      = $results->CITY;
			    $gender    = $results->GENDER;
			    $first_name = $results->FIRSTNAME;
			    $last_name = $results->LASTNAME;
			    $street = $results->STREET;
			    $first_name = $results->FIRSTNAME;
			    $address = $results->ADDRESS;
			    $zipcode = $results->ZIPCODE;
			    $contact = $results->CONTACT;
			    $about = $results->ABOUT_ME;
			    $dob = $results->DATE_OF_BIRTH;
				$partnername  = $this->Agent_model->getPartnerNameById($results->PARTNER_ID);   ?>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>User Name:</strong></span>
                    <label> <?php echo $username;?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Email Address:</strong></span>
                    <label> <?php if($email != 'none') echo $email; else echo '-'; ?> </label>
                  </td>
                  <td width="20%"><span class="TextFieldHdr"><strong>Partner:</strong></span>
                    <label> <?php echo $partnername; ?> </label>
                  </td>
                </tr>
                <tr>
                  <!--<td width="20%"><span class="TextFieldHdr"><strong>Distributor:</strong></span>
                    <label> <?php echo $disName; ?> </label>
                  </td>-->
                  <td width="40%"><span class="TextFieldHdr"><strong>Gender:</strong></span>
                    <label> <?php if($gender != 'none') echo $gender; else echo '-';?> </label></td>
	                
                  <td width="40%"><span class="TextFieldHdr"><strong>DOB:</strong></span>
                    <label> <?php if($gender != 'none') echo $dob; else echo '-';?> </label></td>
                 
                  <td width="40%">&nbsp;</td>                  
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table>
          </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>Contact Info</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                 <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>First Name:</strong></span>
                    <label> <?php if($first_name != 'none') echo $first_name; else echo '-'; ?>  </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Last Name:</strong></span>
                    <label> <?php if($last_name != 'none') echo $last_name; else echo '-'; ?>  </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Contact Number:</strong></span>
                    <label> <?php if(!empty($contact)) echo $contact; else echo '-'; ?>  </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                
                
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Country:</strong></span>
                    <label> <?php if($country != 'none') echo $country; else echo '-'; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>State:</strong></span>
                    <label> <?php if($state != 'none') echo $state; else echo '-'; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>City:</strong></span>
                    <label> <?php if($city != 'none') echo $city; else echo '-'; ?></label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                 <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Street:</strong></span>
                    <label> <?php if($street != 'none') echo $street; else echo '-'; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Address:</strong></span>
                    <label> <?php if(!empty($address)) echo $address; else echo '-'; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Zipcode:</strong></span>
                    <label><?php if(!empty($zipcode)) echo $zipcode; else echo '-'; ?>  </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        
		<table width="100%" class="PageHdr">
                <tr>
                  <td><strong>Wallet</strong> </td>
                </tr>
              </table>        
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="ContentHdr ContentHdr_realmoney">
                <tr>
                  <td><strong>Real Money</strong> </td>
                  <td width="40%"><span class="TextFieldHdr">
                    <div class="UDeditR" style="float:right;">
                      <?php if((isset($this->session->userdata['ADMIN_USER_ID']))){ ?>
                      <a href="<?php echo base_url()?>cashier/pay/ledger/<? echo $results->USERNAME; ?>?rid=17" style="color:#fff;">Ledger</a>
                      <?php }else{ ?>
                      <a href="<?php echo base_url()?>cashier/pay/ledger/<? echo $results->USERNAME; ?>?rid=17" style="color:#fff;"	>Ledger</a>
                      <?php } ?>
                    </div>
                    </span> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Deposit Balance:</strong></span>
                    <label> <?php echo $depositBalance; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Promo Balance:</strong></span>
                    <label> <?php echo $promoBalance; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Win Balance:</strong></span>
                    <label> <?php echo $winBalance; ?> </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Total Balance:</strong></span>
                    <label> <?php echo $totBalance; ?> </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td class="bluff_bonus"><table width="100%" class="ContentHdr ContentHdr_realmoney">
                <tr>
                  <td><strong>Play Money</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Deposit Balance:</strong></span>
                    <label> <?php echo $playDepositBalance; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Promo Balance:</strong></span>
                    <label> <?php echo $playPromoBalance; ?> </label></td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Win Balance:</strong></span>
                    <label> <?php echo $playWinBalance; ?> </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Total Balance:</strong></span>
                    <label> <?php echo $playTotBalance; ?> </label></td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>        
             
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
          
          <td class="bluff_bonus"><table width="100%" class="ContentHdr ContentHdr_new">
                <tr>
                  <td><strong>FPP Balance</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php echo $fppBonusPoints; ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
                <td class="bluff_bonus"> <table width="100%" class="ContentHdr ContentHdr_new">
                <tr>
                  <td><strong>Bluff Balance</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php echo $bluffBonusPoints; ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>

               <td class="bluff_bonus"><table width="100%" class="ContentHdr ContentHdr_new">
                <tr>
                  <td><strong>Token Balance</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php echo $tokenBonusPoints; ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
                <td class="vip_chips"><table width="100%" class="ContentHdr ContentHdr_vipchips">
                <tr>
                  <td><strong>VIP Chips Balance</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php echo $vipChipsBonusPoints; ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
              
              
            <td class="vip_chips"><table width="100%" class="ContentHdr ContentHdr_vipchips">
                <tr>
                  <td><strong>Loyalty Balance</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php echo $loyaltyBonusPoints; ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>
              
<td class="vip_chips"><table width="100%" class="ContentHdr ContentHdr_vipchips">
                <tr>
                  <td><strong>Pending Deposit</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Points:</strong></span>
                    <label> <?php if($DepositPending != '0'){ ?> <a href="#"><?php echo $DepositPending; ?></a> <?php }else{ echo "0"; } ?> </label></td>
                  <td width="40%">&nbsp;</td>  
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table></td>              
             
           </tr>
        </table>
        
	<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>Withdrawal Details</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Pending Withdrawal Request:</strong></span>
                    <label> <?php if($WithdrawalPending != '0'){ ?> <a href="<?php echo base_url(); ?>reports/withdrawal/index?rid=53&userID=<?php echo $userid; ?>&tSID=109"><?php echo $WithdrawalPending; ?></a> <?php }else{ echo "0"; } ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Total Amount Withdrawn:</strong></span>
                    <label> <?php if($TotalWithdrawal != ''){ ?> <a href="<?php echo base_url(); ?>reports/withdrawal/index?rid=53&userID=<?php echo $userid; ?>&tSID=111"><?php  echo $TotalWithdrawal; ?></a> <?php }else{ echo "0"; } ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Tax:</strong></span>
                    <label> <?php echo  "-"; ?> </label>
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


	<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>Bank Details</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
              <?php if($BankDetailsCount == 1){ ?>
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Account Holder Name:</strong></span>
                    <label> <?php echo $ActHdlrName; ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Account Number:</strong></span>
                    <label> <?php echo $AccntNumber; ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Ifsc Code:</strong></span>
                    <label> <?php echo  $IfscCode; ?> </label>
                  </td>                                    
                </tr>
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Bank Name:</strong></span>
                    <label> <?php echo  $BankName; ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Branch Name:</strong></span>
                    <label> <?php echo  $BranchName; ?> </label>
                  </td>
				<!-- <td width="40%"><span class="TextFieldHdr"><strong>Micr Code:</strong></span>
                    <label> <?php echo  $MicrCode; ?> </label>
                  </td>-->                  
                  </tr> 
                  <?php }else{ ?>
                  <tr>
                  <span style="font-weight:bold;margin-top:10px;display:inline-block"><img src="<?php echo base_url();?>static/images/dialog-warning.png" alt="" width="24" height="22" /> <?php echo "Bank Details Not YET Submitted"; ?> </span>
                  </tr>
                  <?php } ?>                                                   
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table>
          </tr>
        </table>

	<table width="25%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>ID Proof:</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <ul>
                
                <?php $userid = $this->uri->segment(4, 0);
				$a = count($UserIdType);
				$j=0;
				for($i=0;$i<$a;$i++){ 
				$query  = $this->db->query("select * from user_verification where USER_ID = '".$userid."' AND VERIFICATION_TYPE_ID = '".$UserIdType[$i]->VERIFICATION_TYPE_ID."' AND STATUS = 1");
				$result = $query->row();
				if($result->VERIFICATION_PROOF != ''){ ?>
                 <li style="width:240px;margin-left:10px;float:left;"><span class="TextFieldHdr"><strong><?php $j+=1; echo $UserIdType[$i]->VERIFICATION; ?>:</strong></span>
                    <label> <?php if($result->STATUS){ ?><a onclick="return hs.expand(this)" class="highslide " href="<?php echo base_url(); ?>static/uploads/proof/<?php echo $result->VERIFICATION_PROOF ?>"><img src="<?php echo base_url();?>static/images/drag.png" alt="" width="14" height="12" style="border:none;" /></a> <?php }else{ ?><img src="<?php echo base_url();?>static/images/dragcancel.png" alt="" width="14" height="12"  style="border:none;"/> <?php } ?> </label>
                  </li>		
				<?php }
				} 
				if($j==0){ ?> <span style="font-weight:bold;margin-top:10px;display:inline-block"><img src="<?php echo base_url();?>static/images/dialog-warning.png" alt="" width="24" height="22" /> <?php echo "ID Proof Not YET Submitted"; ?> </span> <?php } ?> 
                       </li>            
                </ul>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table>
          </tr>
        </table>


        
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>TRANSACTION</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Play Points:</strong></span>
                    <label> <?php echo $playpoint;?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Win Points:</strong></span>
                    <label> <?php echo $winpoint; ?> </label>
                  </td>
                  <td width="20%"><span class="TextFieldHdr"><strong>Margin:</strong></span>
                    <label> <?php echo $margin; ?> </label>
                  </td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>

                  <td width="40%"><span class="TextFieldHdr">
                    <div class="UDeditR">
                      <?php if((isset($this->session->userdata['ADMIN_USER_ID']))){ ?>
                      <a href="<?php echo base_url()?>games/poker/game/view/<? echo $results->USERNAME; ?>?rid=51">Game Transactions</a>
                      <?php }else{ 
                          ?>
                      <a href="<?php echo base_url()?>games/poker/game/view/<? echo $results->USERNAME; ?>?rid=51">Game Transactions</a>
                      <?php } ?>
                    </div>
                    </span></td>
                  <td width="20%"><span class="TextFieldHdr">
				      <div class="UDeditR"><a href="#" onClick='openboxSearch("Adjust Points","1","<?php echo $userid; ?>")' >Manage Points</a></div>
                    </span> </td>
                  <td width="40%">&nbsp;</td>
                </tr>
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table>
          </tr>
        </table>
           <div id="shadowing2"></div>
        <div id="box2">
            <?php $string = AdjustPoints;?>
            
            <form id="frmLightboxSearch" method="REQUEST" action="" target="_parent">
            <div class="SeachResultWrap">
            <div class="Agent_create_wrap">
            <div class="Agent_hdrt" id="boxtitle1"></div>
            <div class="Agent_txtField">Transaction Password:<br />
                <input name="partnertransaction_password" type="password" class="TextField" id="transpassword" size="65" maxlength="60"  />
            </div>
            <div class="Agent_txtField">
                <input type ="hidden" name="currentUrl" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" />
                <input type="hidden" id="userid" name="userid" value="145">
                <input type="submit" class="button" value="Submit" />
                <input type="button" class="button" value="Cancel" onClick="closebox2()" />
            </div>
            </div>
            </div>
            </form>
        </div>        
        <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          <tr>
            <td><table width="100%" class="PageHdr">
                <tr>
                  <td><strong>REGISTRATION</strong> </td>
                </tr>
              </table>
              <table width="100%" cellpadding="10" cellspacing="10">
                <tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Date:</strong></span>
                    <label> <?php echo  date('d/m/Y H:i:s',strtotime($results->REGISTRATION_TIMESTAMP)); ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Status:</strong></span>
                    <label>
                    <?php if($results->ACCOUNT_STATUS == "1") {?>
                    ACTIVE
                    <?php } else if($results->ACCOUNT_STATUS == "2") { ?>
                    NOT ACTIVATED
                    <?php } else if($results->ACCOUNT_STATUS == "0") { ?>
                    DEACTIVE
                    <?php } ?>
                    </label>
                  </td>
                  <?php if((isset($this->session->userdata['ADMIN_USER_ID']) && $this->session->userdata['ADMIN_USER_ID']==1)){?>
                  <?php } else { ?>
                  <td width="20%"><span class="TextFieldHdr"><strong>Change Status:</strong></span>
                    <label> <span id="def<?php echo $results->USER_ID; ?>" style="display:block; text-align:left">
                    <?php if($results->ACCOUNT_STATUS == "1") {?>
                    <a href="javascript:openDESCRIPTION_Div(<?php echo $results->USER_ID; ?>);" title="Acive"><img src="<?php echo base_url()?>static/images/active.gif" alt="Acive" title="" border="0" /></a>
                    <?php }else if($results->ACCOUNT_STATUS == "2" || $results->ACCOUNT_STATUS == "0") {  ?>
                    <a href="javascript:authenticate('act<?php echo $results->USER_ID; ?>',<?php echo $results->USER_ID; ?>,'status','act');" title="Deactive"><img src="<?php echo base_url()?>static/images/deactive.gif" alt="DeActive" title="" border="0" /></a>
                    <?php } ?>
                    </span> <span id="dact<?php echo $results->USER_ID; ?>" style="display:none; text-align:center"> </span> <span id="act<?php echo $results->USER_ID; ?>" style="display:none; text-align:center"> </span> </label>
                  </td>
                  <?php }?>
                </tr>
                  <td width="40%"><span class="TextFieldHdr"><strong>Campaign:</strong></span>
                    <label> <?php $reffer = $this->Account_model->getUserInfoById($userid); 
								 if($reffer->REFERRED_BY=="" || $reffer->REFERRED_BY==0){ echo "Registration"; }else{ echo "Referral"; } ?> </label>
                  </td>
                  <td width="40%"><span class="TextFieldHdr"><strong>Partner:</strong></span>
                    <label> <?php $pid = $this->Account_model->getUserPartnerId($userid); 
					echo $this->Agent_model->getAgentNameById($pid); ?> </label>                    
                  </td>                                  
                <tr>
                  <td width="40%"></td>
                  <td width="40%">&nbsp;</td>
                  <td width="40%">&nbsp;</td>
                </tr>
              </table>
          </tr>
        </table>
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
  <div id="user_status_desc" class="popup" style="width:250px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
    <form name="descriptionSTATUS" id="descriptionSTATUS" method="post">
      <input type="hidden" name="userSID" id="userSID" value=""/>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90%" height="50px;" style="font-size:120%;background-color:#017AB3;padding-left:10px;">Reason for Deactivate User</td>
          <td width="10%" align="right" style="background-color:#017AB3;"><img style="cursor:pointer;" src="<?php echo base_url();?>static/images/close.gif" alt="close" title="close" border="0" onClick="closeDiv();"/></td>
        </tr>
        <tr>
          <td colspan="2"><textarea name="desc_status" id="desc_status" cols="25" rows="5" class="TextArea"></textarea></td>
        </tr>
        <tr>
          <td colspan="2" height="50px;"><input type="button" name="submit" id="submit" value="Save" onclick="UserDeActivateDescription()" />
            &nbsp;
            <input type="button" name="close" id="close" value="close" onClick="closeDiv();" />
            <span id="saved_desc" style="font-size:90%;"></span></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>

