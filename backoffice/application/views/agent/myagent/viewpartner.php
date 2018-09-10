<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript">
function openDESCRIPTION_Div(id)
{
	if(confirm("Do you really want to unauthenticate this user? If so all the details related to this user wil get unauthenticated"))
	{
            
		var partnerid = id;
		//Popup.show('user_status_desc');
		UserDeActivateDescription(partnerid);
	}
}

function UserDeActivateDescription(id)
{
        xmlHttp=GetXmlHttpObject()
        var partnerid=id;
        var url='<?php echo base_url();?>agent/myagent/deactive/'+partnerid;    
		var def="def"+partnerid;
        var ele="dact"+partnerid;
        var acc="act"+partnerid;
		xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
            var result=xmlHttp.responseText;
            document.getElementById(ele).innerHTML='<a href="javascript:authenticate(\'act'+partnerid+'\', \''+partnerid+'\', \'status\', \'act\');" title=\'Deactive\'><img src=\''+global_baseurl+'static/images/deactive.gif\' alt=\'DeActive\' border=\'0\' /></a>';
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
    
    var url='<?php echo base_url();?>agent/myagent/active/'+typ;    
    
    //alert(url);
    
    xmlHttp.onreadystatechange=function(){
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){
           // Activeuser(ele,typ,xmlhttp.responseText);
            var result=xmlHttp.responseText;
            //alert("test");
   document.getElementById(ele).innerHTML='<a href=javascript:openDESCRIPTION_Div('+typ+'); title=Acive><img src='+global_baseurl+'static/images/active.gif alt="Acive" border="0" /></a>';    
     
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
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>     

<table width="100%" class="PageHdr">
  <tr>
    <td><strong>Agents</strong></td>
  </tr>
</table>
<?php
if(isset($results)){
    $j = $page;
    //print_r($results);
    
    /*if($j==false){
        $j="1";
    }*/
         if(count($results)>0 && is_array($results)){
             for($i=0;$i<count($results);$i++){
                 $j++;
                  
                 $resvalue['PARTNER_USERNAME']=$results[$i][0];
                 $resvalue['REG_DATE']=$results[$i][1];
                 $resvalue['MAC_ID']=$results[$i][2];
                 $resvalue['MARGIN']=$results[$i][3];
                 $resvalue['MARGIN_PER']=$results[$i][4];
                 $resvalue['DISTRIBUTOR']=$results[$i][5];
                 $resvalue['BALANCE'] =$results[$i][6];
                 $resvalue['STATUS'] =$results[$i][7];
                 $resvalue['VIEW'] =$results[$i][8];
                 $resvalue['SNO'] = $j;
                 if($resvalue){
                     $arrs[] = $resvalue;
                 }
                
             }
         }else{
           $arrs="";
         }
}
//print_r($arrs);
if(isset($arrs) && $arrs!=''){
?>

<div  style="height:auto;">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>static/jquery/css/jquery-ui-1.css">
<div class="tableListWrap"><div class="data-list">
<table id="list4" class="data"><tr><td></td></tr></table>
    </div></div>
<script src="<?php echo base_url(); ?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<script type="text/javascript">
	jQuery("#list4").jqGrid({
		datatype: "local",
		colNames:['S.no','Username','Registration Date', 'Margin Type', 'Margin (%)','Distributor','Status','View'],
		colModel:[
			{name:'SNO',index:'SNO', align:"center", width:60, sorttype:"int"},
			{name:'PARTNER_USERNAME',index:'PARTNER_USERNAME', align:"center", width:115},
                        //{name:'MAC_ID',index:'MAC_ID', align:"center", width:115},
			{name:'REG_DATE',index:'REG_DATE', width:110, align:"center", sorttype: "datetime", datefmt: "d/m/Y H:i:s"},
			{name:'MARGIN',index:'MARGIN', align:"center", width:110},
			{name:'MARGIN_PER',index:'MARGIN_PER', width:120, align:"center",sorttype:"float"},
			{name:'DISTRIBUTOR',index:'DISTRIBUTOR', width:120, align:"center"},		
                        //{name:'BALANCE',index:'BALANCE', width:120, align:"right",sorttype:"float"},
			{name:'STATUS',index:'STATUS', width:80, align:"center",sorttype:"int"},
                        //{name:'ACTION',index:'ACTION', width:100, align:"center"},
			{name:'VIEW',index:'VIEW', width:80, align:"center"},
                        
		],
		rowNum:500,
		width: 999, height: "100%"
	});
	var mydata = <?php echo json_encode($arrs);?>;
	for(var i=0;i<=mydata.length;i++)
		jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
</script>
</div>
<!--</div>-->
<input type="hidden" name="partnerid" id="partnerid" value="<?php echo $this->session->userdata('partnerid');?>">
<!--<div class="Vback2"><img src="images/excel.jpeg" width="20" height="20"><a href="admin-home.php?p=vparl&exc=1">Export</a></div>-->
<div class="page-wrap">
 <div class="pagination">
<?PHP 
echo $links;
?>
 </div> 
</div>
<?php } ?>
    </div>
 </div>
   </div>
   </div>
<?php echo $this->load->view("common/footer"); ?>  