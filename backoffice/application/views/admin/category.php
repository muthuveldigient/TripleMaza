<style>
.PageHdr {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: #c8181e;
    text-decoration: none;
    float: left;
    width: auto;
    white-space: nowrap;
    clear: both;
padding-bottom: 5px;}
.ledgerWrap {
    float: left;
    width: 100%;
    height: 1100px;
    padding-top: 10px;
    clear: both;
    border-top: 1px solid #F0F0F0;
}
.TopLine {
    float: left;
    width: 100%;
    padding-top: 10px;
    clear: both;
    border-top: 1px solid #F0F0F0;
}
.SeachResultWrap {
    float: right;
    width: 100%;
    clear: both;
    padding-top: 10px;
}

.tableWrap, .DisplayWrap {
    float: left;
    width: auto;
    border: 1px solid #f0f0f0;
    padding: 1px;
    clear: both;
}
.UDSubBg {
    float: left;
    width: 690px;
    padding-top: 5px;
    padding-right: 10px;
    padding-bottom: 5px;
    padding-left: 10px;
    background-color: #F0F0F0;
    clear: both;
}
.UDCommonWrap {
    float: left;
    width: 690px;
}
.UDRightWrap {
    float: left;
    width: 345px;
    padding-top: 5px;
    padding-bottom: 5px;
}
.RightInBg {
    float: left;
    width: 83%;
	margin-top: 20px;
}
.vbacksucs_box {
    width: 100%;
    float: left;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    background: #c8181e !important;
    color: #fff !important;
}.ui-state-default:hover{
    background: #c8181e !important;
    color: #fff !important;
}
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
    border: 1px solid #F0F0F0 !important;
    background: #F0F0F0 !important;
    color: #363636 !important;
}
</style>

<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script language="javascript">
$(document).ready(function(){
    $('#center_ids').val('');
    $('#btnRight').click(function(e){
		var selectedOpts = $('#lstBox1 option:selected');
		var $data=$('#lstBox1').val();
		if($('#center_ids').val()){
			$data=$data+","+$('#center_ids').val();
		}else{
			$data=$data;
		}
		$('#center_ids').val($data);
		if(selectedOpts.length == 0){
			alert("Nothing to move.");
			e.preventDefault();
		}
		$('#lstBox2').append($(selectedOpts).clone());
		
		$(selectedOpts).remove();
		e.preventDefault();
    });
    
    $('#btnLeft').click(function(e){
        var selectedOpts = $('#lstBox2 option:selected');
        var data2=$('#center_ids').val();
        var data1=$('#lstBox2').val();
        var $datan="";
        if(selectedOpts.length == 0){
            alert("Nothing to move.");
            e.preventDefault();
        }
        var narray1=data1.toString().split(",");
        if(data2){
        var narray=data2.toString().split(",");
        for(k=0;k<narray.length;k++){
            if(narray1.indexOf(narray[k])==-1){
                if($datan){
                    $datan=$datan+","+narray[k];
                }else{
                    $datan=narray[k];
                }
            }
        } 
        $('#center_ids').val($datan);
        }
        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
});
function GetXmlHttpObject() {
	var objXMLHttp=null
	if (window.XMLHttpRequest) {
		objXMLHttp=new XMLHttpRequest()
	} else if (window.ActiveXObject) {
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp
}

function getCategoryGames(e) {
	var selectedOptsCategory = $('#categoryBox option:selected').val();
	if(selectedOptsCategory.length == 0){
		alert("Nothing to move.");
		e.preventDefault();
	}	
    objXMLHttp=GetXmlHttpObject()
    var url='<?php echo base_url();?>admin/draw/categorygames';    
	url=url+"?catid="+selectedOptsCategory;
	objXMLHttp.onreadystatechange=showCategoryGames
	objXMLHttp.open("GET",url,true);
	objXMLHttp.send(null);
	return false;		
}
function showCategoryGames() {
	if(objXMLHttp.readyState==4 || objXMLHttp.readyState=="complete") { 		
		var result=objXMLHttp.responseText.split("###");
		document.getElementById("lstBox1").innerHTML=result[0];	
		document.getElementById("lstBox2").innerHTML=result[1];
		document.getElementById("center_ids").value=result[2];					
    }	
}
function frmValidate() {
	if(document.getElementById("categoryBox").value=="") {
		alert("Select the category");
		return false;
	}	
	return true;
}
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
<div class="RightInBg">
   <div class="RightInSubBg">
      <div class="UsrSrchmainwrap">
         <div class="PageHdr">Category Management</div>
      </div>
	  <?php
	  	if(isset($err) && !empty($err)) {
			if($err==1)
				echo '<div class="vbacksucs_box">Games assignment updated successfully</div>';
			if($err==2)
				echo '<div class="vbackerr_box">Games assignment update failed</div>';
		}
	  ?>	
	  <form name="frmCategoryManagement" method="post" onsubmit="return frmValidate();" >
      <div class="TopLine">
         <div class="SeachResultWrap">
            <div class="tableWrap">
               <div class="UDSubBg">
                  <div class="UDCommonWrap">
                     <div class="UDRightWrap" style="width:150px;">
                        <div class="UDFieldtitle" style="width:150px;">Category:</div>
                        <div class="UDFieldTxtFld" style="width:150px;">
                           <select id='categoryBox' class="Textselct" size="5" style="height:100px;width:150px;"  name="category" tabindex="1" onchange="javascript:getCategoryGames();">
                              <?php
                                 
                                foreach($category as $cat){
                                 	?>
                              <option value="<?php echo $cat->CATEGORY_ID;?>"><?php echo $cat->CATEGORY_NAME;?></option>
                              <?php
                                 }		
                                 ?>
                           </select>
                           &nbsp;
                        </div>
                     </div>
                     <div class="UDRightWrap" style="width:50px;padding-top:60px;">
                        <div class="UDFieldtitle"></div>
                        <div class="UDFieldTxtFld" style="width:50px;text-align:center;"><input type='button' id='btnRightCategory' value ='  >  ' onclick="getCategoryGames()"/></div>
                     </div>
                     <div class="UDRightWrap" style="width:190px;">
                        <div class="UDFieldtitle" style="width:190px;">Games:</div>
                        <div class="UDFieldTxtFld" style="width:190px;">
                           <select multiple="multiple" id='lstBox1' class="Textselct" style="height:100px;width:190px;" name="lstBoxgames[]" tabindex="2"></select>&nbsp;
                        </div>
                     </div>
                     <div class="UDRightWrap" style="width:50px;padding-top:40px;">
                        <div class="UDFieldtitle" style="width:50px;"></div>
                        <div class="UDFieldTxtFld" style="width:50px;text-align:center;"><input type='button' id='btnRight' value ='  >  '/>
                           <br/><br/><input type='button' id='btnLeft' value ='  <  '/>
                        </div>
                     </div>
                     <div class="UDRightWrap" style="width:200px;">
                        <input type="hidden" name="center_ids" id="center_ids" value=""/>
                        <div class="UDFieldtitle" style="width:200px;">Selected Games:</div>
                        <div class="UDFieldTxtFld" style="width:200px;"><select multiple="multiple" id='lstBox2' class="Textselct" style="height:100px;" name="lstBox2" tabindex="3"></select> </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="SeachResultWrap">
            <input type="submit" name="Submit" id="Submit" class="button" value="Update" tabindex="4" /> 
         </div>
      </div>
	  </form>
<?php
	if(!empty($getCategoryGames)) {
		$sno=1;
		foreach($getCategoryGames as $games) {
			$resvalue["SNO"]=$sno;
			$resvalue["CATEGORY_NAME"]=$games->CATEGORY_NAME;
			$resvalue["GAME_NAME"]    =$games->DESCRIPTION;
			$sno++;
			$arrs[] = $resvalue;
		}
	} else {
		$arrs=array();
	}
	
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>/static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>/static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>/static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>/static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<div class="ledgerWrap" style="height:auto;border-top:1px solid #fff;">
<table id="list1"><tr><td></td></tr></table>
<div id="pager1"></div>
<script type="text/javascript">
	jQuery("#list1").jqGrid({
		datatype: "local",
		colNames:['S.No','Category Name', 'Game Name'],
		colModel:[
			{name:'SNO',index:'SNO', width:20, align:"center"},
			{name:'CATEGORY_NAME',index:'CATEGORY_NAME', width:80, align:"center", sorttype:"char"},
			{name:'GAME_NAME',index:'GAME_NAME', align:"center", width:80, sorttype:"char"}			
		],
		rowNum:500,
		width: 950, height: "100%"
	});
	var mydata = <?php echo json_encode($arrs);?>;
	for(var i=0;i<=mydata.length;i++)
		jQuery("#list1").jqGrid('addRowData',i+1,mydata[i]);
</script>
</div>
<?php if(empty($arrs)) { ?>
<div>There is no record to display</div>
<?php } ?>
   </div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>