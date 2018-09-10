<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<style>
.UDCommonWrap { float: left; width: 905px; }    
.UDFieldTxtFld { float: left; width: 300px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; color: #017AB3; text-decoration: none; padding-bottom: 3px; }
.UDRightWrap { float: left; width: 300px; padding-top: 5px; padding-bottom: 5px; }
.UDLeftWrap { float: left; width: 300px; padding-top: 5px; padding-bottom: 5px; }
.UDFieldtitle { float: left; width: 300px; font-family: Arial, Helvetica, sans-serif; font-size: 12px; font-weight: normal; color: #000000; text-decoration: none; }
</style>    
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

function showdistagents()
{
    
        xmlHttp=GetXmlHttpObject()
        var url='<?php echo base_url();?>index.php/ajax_showdistagents';    
	
	xmlHttp.onreadystatechange=Listdistagent
	xmlHttp.open("GET",url,true);
    //xmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	xmlHttp.send(null);
    //loader(0);
       
	return false;
    
}

function openDESCRIPTION_Div(id)
{
	if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user wil get unauthenticated"))
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
        var url='<?php echo base_url();?>index.php/deactiveusers/index/'+userid+'/'+desc;    
	var def="def"+userid;
        var ele="dact"+userid;
        var acc="act"+userid;
	xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
            var result=xmlHttp.responseText;
            document.getElementById("saved_desc").innerHTML=result;  
            document.getElementById(ele).innerHTML='<a href="javascript:authenticate(\'act'+userid+'\', \''+userid+'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''+global_baseurl+'images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
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
    
    var url='<?php echo base_url();?>index.php/activeusers/index/'+typ;    
    
    //alert(url);
    
    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
           // Activeuser(ele,typ,xmlhttp.responseText);
            var result=xmlHttp.responseText;
            //alert("test");
   document.getElementById(ele).innerHTML='<a href=javascript:openDESCRIPTION_Div('+typ+'); title=Acive><img src='+global_baseurl+'images/active.gif alt="Acive" border="0" /></a>';    
     
    var def="def"+typ;
	var dact="dact"+typ;
            //alert(result);

            if(result=='Activated'){
              document.getElementById(ele).style.display='';  
              document.getElementById(dact).style.display='none';  
			  document.getElementById(def).style.display='none';  
            }
        }
    }
    
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
   }
}


</script>
<script src ="<?php echo base_url()?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>static/css/highslide.css"/>
<div class="content_wrap">
<div class="tableListWrap">
            <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>
    <div align="right" style="text-align:right;"><input type="button" value="Back" class="button" onClick="window.history.back();"></div>
    <div class="UsrName">Agent: <? echo $na; ?></div>
        <table width="100%" class="ContentHdr">
        <tr>
        <td><strong>View Users</strong></td>
        </tr>
        </table>
    
        <?php
        $arrs=$result;
        ?>
    
                 
                <div  style="height:auto;padding-top:10px;" class="data-list">
                <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url()?>static/jquery/css/ui.jqgrid.css" />
                <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url()?>static/jquery/css/jquery-ui-1.css" />
                <table id="list4" class="data"><tr><td></td></tr></table>
                <script src="<?php echo base_url()?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
                <script src="<?php echo base_url()?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
                <script src="<?php echo base_url()?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>
                
                <script type="text/javascript">
                    jQuery("#list4").jqGrid({
                        datatype: "local",
                        colNames:['S.no','Username','Agent', 'Distributor', 'Register Date','Status'],
                        colModel:[
                            {name:'SNO',index:'SNO', align:"center", width:60, sorttype:"int"},
							{name:'USERNAME',index:'USERNAME', align:"center", width:115},
                            {name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', width:110, align:"center"},
                            {name:'PARTNER_USERNAME1',index:'PARTNER_USERNAME1', align:"center", width:130},
                            //{name:'BALANCE',index:'BALANCE', width:120, align:"right",sorttype:"float"},
                            {name:'REG_DATE',index:'REG_DATE', width:120, align:"center",sorttype: "datetime", datefmt: "d/m/Y H:i:s"},		
                            {name:'STATUS',index:'STATUS', width:80, align:"center",sorttype:"int"},
                        ],
                        rowNum:500,
                        width: 999, height: "100%"
                    });
                    var mydata = <?php echo json_encode($arrs);?>;
                    for(var i=0;i<=mydata.length;i++)
                        jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
                </div>
        
<div class="pagination">
<?php echo $links;?>
</div>                
    
</div>

    <div id="proofs" align="center" class="popup" style="position:absolute;margin-left:auto;margin-right:auto;display:none;">
<img src='<?php echo base_url()?>static/images/ajax-loader.gif' width='16' height='16' border='0'>
</div>

<div id="user_status_desc" class="popup" style="width:250px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
<form name="descriptionSTATUS" id="descriptionSTATUS" method="post">
<input type="hidden" name="userSID" id="userSID"/>
<input type="hidden" name="adminId" id="adminId" value=""/>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="90%" height="50px;" style="font-size:120%; background-color:#017AB3;padding-left:10px;">Reason for Deactivate kiosk</td>
<td width="10%" align="right" style="background-color:#017AB3;"><img src="<?php echo base_url()?>static/images/close.gif" alt="close" title="close" border="0" onClick="closeDiv();"/></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
<td colspan="2"><textarea name="desc_status" id="desc_status" class="TextArea" cols="25" rows="5"></textarea></td>
</tr>
<tr>
<td colspan="2" height="50px;"><input class="button" type="button" name="submit" id="submit" value="Save" 
onclick="UserDeActivateDescription()" />&nbsp;<input type="button" class="button" name="close" id="close" value="close" onClick="closeDiv();" /><span id="saved_desc" style="font-size:90%;"></span></td>
</tr>			
</table>
</form>
</div>
    </div>