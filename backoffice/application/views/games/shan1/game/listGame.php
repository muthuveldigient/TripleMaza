<script src = "<?php echo base_url(); ?>static/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<script src = "<?php echo base_url(); ?>static/js/date.js"  type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script language="javascript">
function showdaterange(vid){
	if(vid!=''){
	  var sdate='';
	  var edate='';
	  if(vid=="1"){
		  sdate='<?php echo date("d-m-Y 00:00:00");?>';
		  edate='<?php echo date("d-m-Y 23:59:59");?>';
	  }
	  if(vid=="2"){
		  <?php
		  $yesterday=date('d-m-Y',strtotime("-1 days"));?>
		  sdate='<?php echo $yesterday;?>'+' 00:00:00';
		  edate='<?php echo $yesterday;?>'+' 23:59:59';
	  }
	  if(vid=="3"){
		  <?php
		  $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
		  ?>
		  //alert('<?php echo $sweekday;?>');
		  sdate='<?php echo $sweekday;?>'+' 00:00:00';
		  edate='<?php echo date("d-m-Y");?>'+' 23:59:59';
	  }
	  if(vid=="4"){
		 <?php
		  $sweekday=date("d-m-Y",strtotime(date("d-m-Y"))-((date("w")-1)*24*60*60));
		  $slastweekday=date("d-m-Y",strtotime($sweekday)-(7*24*60*60));
		  $slastweekeday=date("d-m-Y",strtotime($slastweekday)+(6*24*60*60));
		  ?>
		  sdate='<?php echo $slastweekday;?>'+' 00:00:00';
		  edate='<?php echo $slastweekeday;?>'+' 23:59:59';
	  }
	  if(vid=="5"){
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
	  if(vid=="6"){
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

function NewWindow(mypage,myname,w,h,scroll){
	var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	var settings ='height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable';
	win = window.open(mypage,myname,settings);
}

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

$(document).ready(function() {
	$("#delete").click(function(){
        var chkBoxArray = [];
		$('.chkbox:checked').each(function() {
            chkBoxArray.push($(this).val());
        });
		if(chkBoxArray!=''){
			if (confirm('Are you sure. You want to delete selected items ?')){
				$.ajax({
					url: "<? echo base_url(); ?>games/game/deactivateTournament?chkarr="+chkBoxArray,
					type: "post",
					async: false,
					//data: $('.wBatch:checked').serialize(),
					success: function(data) {
						window.location='<? echo base_url(); ?>games/game/editgame?rid=71&msg=111'; 
					}
				});
			}
		}else{
			alert('Select Atleast One Check Box!!!');
			return false;
		}
	});
});
$(document).ready(function() {
	$("#deleted").click(function(){
        var chkBoxArray = [];
		$('.chkbox:checked').each(function() {
            chkBoxArray.push($(this).val());
        });
		if(chkBoxArray!=''){
			if (confirm('Are you sure. You want to delete selected items ?')){
				$.ajax({
					url: "<? echo base_url(); ?>games/game/deactivateTournament?chkarr="+chkBoxArray,
					type: "post",
					async: false,
					//data: $('.wBatch:checked').serialize(),
					success: function(data) {
						window.location='<? echo base_url(); ?>games/game/editgame?rid=71&msg=111'; 
					}
				});
			}
		}else{
			alert('Select Atleast One Check Box!!!');
			return false;
		}
	});	
});	
function changestatus(id){
	xmlHttp3=GetXmlHttpObject()
	document.getElementById('verify_id').value = id;
    var url='<?php echo base_url()."games/game/activateTournament/"?>'+id;
    xmlHttp3.onreadystatechange=ShowAdditions
    xmlHttp3.open("GET",url,true);
    xmlHttp3.send(null);
    return false;
}

function ShowAdditions(){
	var ival = document.getElementById("verify_id").value;
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0){ 		
		var result=xmlHttp3.responseText;
		document.getElementById("status_change_"+ival).innerHTML=result;
	    document.getElementById('verify_id').value = '';
        //Popup.hide('user_approve_desc');
	}
} 
</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){  echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?> 
    
   		  <form action="<?php echo base_url();?>games/game/listgame?rid=<?php echo $rid;?>" method="post" name="tsearchform" id="tsearchform" onsubmit="return chkdatevalue();">
    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
    <tr>
      <td><table width="100%" class="ContentHdr">
          <tr>
            <td><strong>Edit Game</strong></td>
          </tr>
        </table>
        <table width="100%" cellpadding="10" cellspacing="10">
        <tr>
          <td width="40%"><span class="TextFieldHdr">Game Name:</span><br />
            <label>
            <input type="text" name="gameName" id="gameName" class="TextField" value="<?PHP if(isset($_REQUEST['gameName'])) echo $_REQUEST['gameName']; ?>" tabindex="1" >
            </label></td>
          <td width="30%"><span class="TextFieldHdr">Status:</span><br />
            <label>
             <select name="status" class="ListMenu" id="status" tabindex="5">
               <option value="">Select</option>
              <option value="1" <?php if($_REQUEST['status']=='1'){ echo 'selected="selected"'; } ?> >Active</option>
              <option value="0" <?php if($_REQUEST['status']=='0'){ echo 'selected="selected"'; } ?> >In Active</option>
              <option value="2" <?php if($_REQUEST['status']=='2'){ echo 'selected="selected"'; } ?> >Deleted</option>              
            </select>
            </label></td>
        </tr>
         
        <tr>
                <td width="40%"><span class="TextFieldHdr">From:</span><br />
                  <label>
                  <?php
					if($_REQUEST['START_DATE_TIME'])
						$START_DATE_TIME = $_REQUEST['START_DATE_TIME'];
					else
						$START_DATE_TIME = "";
				  ?>   
                  <input type="text"  id="START_DATE_TIME" class="TextField" name="START_DATE_TIME" value="<?PHP if($START_DATE_TIME !=""){ echo $START_DATE_TIME; } ?>">
                  </label>
                  <a onclick="NewCssCal('START_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="40%"><span class="TextFieldHdr">To:</span><br />
                  <label>
                    <?php
					if($_REQUEST['END_DATE_TIME'])
						$END_DATE_TIME = $_REQUEST['END_DATE_TIME'];
					else
						$END_DATE_TIME = "";
				  ?>  
                  <input type="text" id="END_DATE_TIME" class="TextField" name="END_DATE_TIME" value="<?PHP if($END_DATE_TIME != ""){ echo $END_DATE_TIME; }?>">
                  </label>
                  <a onclick="NewCssCal('END_DATE_TIME','ddmmyyyy','arrow',true,24,false);document.getElementById('calBorder').style.top='300px'" href="#"><img src="<?php echo base_url(); ?>static/images/calendar.png" /></a></td>
                <td width="20%"><span class="TextFieldHdr">Date Range:</span><br />
                  <label>
                  <select name="SEARCH_LIMIT" id="SEARCH_LIMIT" class="ListMenu" onchange="javascript:showdaterange(this.value);">
                    <option value="">Select</option>
                    <option value="1" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="1"){ echo "selected";}?>>Today</option>
                    <option value="2" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="2"){ echo "selected";}?>>Yesterday</option>
                    <option value="3" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="3"){ echo "selected";}?>>This Week</option>
                    <option value="4" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="4"){ echo "selected";}?>>Last Week</option>
                    <option value="5" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="5"){ echo "selected";}?>>This Month</option>
                    <option value="6" <?php if(isset($_REQUEST['SEARCH_LIMIT']) && $_REQUEST['SEARCH_LIMIT']=="6"){ echo "selected";}?>>Last Month</option>
                  </select>
                  </label>
                </td>
                <td width="20%">&nbsp;</td>
        </tr>
        <tr>
          <td width="33%"><table>
            <tr><input type="hidden" name="verify_id" id="verify_id" class="TextField" value="" >
              <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
		  		</form>
			  </td>
			  <td><form action="<?php echo base_url();?>games/game/editgame?rid=<?php echo $rid;?>" method="post" name="clrform" id="clrform">
			      <input name="reset" type="submit"  id="reset" value="Clear"  />
    			  </form>
              </td>
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
if(isset($page)){
	$j=$page;
}else{
	$j=0;
}   
//echo "<pre>";print_r($results);die;
$resvalues=array();
if(isset($results)){ 
	if(count($results)>0 && is_array($results)){
		for($i=0;$i<count($results);$i++){
		//call model to get Tournament Name,currency type.
			$resvalue['GAME_NAME']	= '<a href="'.base_url().'games/game/edit/'.$results[$i]->TOURNAMENT_ID.'?rid='.$rid.'">'.$results[$i]->GAME_NAME.'</a>';
			$resvalue['BANKER']		= $results[$i]->BANKER;
			$resvalue['MINBUYIN']	= $results[$i]->MINBUYIN;
			$resvalue['MAXBUYIN']	= $results[$i]->MAXBUYIN;
			$resvalue['MIN_BET']	= $results[$i]->MIN_BET;
			$resvalue['MAX_BET']	= $results[$i]->MAX_BET;
			
			if($results[$i]->RAKE)
				$resvalue['RAKE']	= $results[$i]->RAKE;
			else
				$resvalue['RAKE']	= '-';
				
			if($results[$i]->IS_ACTIVE==1){
				$resvalue['STATUS'] = 'Active';
			}elseif($results[$i]->IS_ACTIVE==2){
				$resvalue['STATUS'] = 'Deleted';
			}else{
				$resvalue['STATUS'] = 'In Active';
			} 

			if($results[$i]->IS_ACTIVE!=2)
				$resvalue['ACTION'] = '<input type="checkbox" class="chkbox" value="'.$results[$i]->TOURNAMENT_ID.'" />';
			else
				$resvalue['ACTION'] = '<div id="status_change_'.$results[$i]->TOURNAMENT_ID.'"><a onClick="changestatus('.$results[$i]->TOURNAMENT_ID.');" style="cursor: pointer; cursor: hand;"><font color="#cc3300">reactive</font></a></div>';
				
			if($resvalue){
				$arrs[] = $resvalue;
			}
			$j++;
			}
		}else{
			$arrs="";
		}
	}
	if(isset($arrs) && $arrs!=''){ 
		if($_REQUEST['status']!='2'){ ?>
    		<input type="button" id="delete" value="Delete" style="float:right; margin-top:20px; margin-right:35px;" />
    	<?php } ?>
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
					colNames:['Game Name','Banker','Min Buy-In','Max Buy-In','Min Bet','Max Bet','Rake(%)','Status','Action'],
                    colModel:[
						{name:'GAME_NAME',index:'GAME_NAME', align:"center", width:100},
						{name:'BANKER',index:'BANKER', align:"center", width:50,sorttype:"number"},
						{name:'MINBUYIN',index:'MINBUYIN', align:"center", width:70,sorttype:"number"},
						{name:'MAXBUYIN',index:'MAXBUYIN', align:"center", width:70,sorttype:"number"},						
						{name:'MIN_BET',index:'MIN_BET', align:"center", width:60,sorttype:"number"},
						{name:'MAX_BET',index:'MAX_BET', align:"center", width:60,sorttype:"number"},
						{name:'RAKE',index:'RAKE', align:"center", width:50,sorttype:"number"},
						{name:'STATUS',index:'STATUS', align:"center", width:50},
						{name:'ACTION',index:'ACTION', width:30, align:"center",sortable:false},
                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
		<?php if($_REQUEST['status']!='2'){ ?>
    				<input type="button" id="deleted" value="Delete" style="float:right; margin-top:20px; margin-right:35px;" />
    	<?php } ?>                
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
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no games found in this search criteria.</b></span></td>
          </tr>
        </table>
      </div>
    </div>
	<?php } ?>
  </div>
</div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>