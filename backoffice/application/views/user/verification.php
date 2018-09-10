<?php error_reporting(E_ALL) ?>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/popup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>static/js/date.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>

hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';

function Hidedist(){
    document.getElementById("affiliatesection").innerHTML='';    
}

function openDESCRIPTION_Div(id){
		Popup.show('user_status_desc');
}

function openDESC_Div(id,verify_id,ival){
        document.getElementById('userid').value = id;
		document.getElementById('user_verify_id').value = verify_id;
		document.getElementById('record_id').value = ival;
		Popup.show('user_approve_desc');
}

function verify(){
    xmlHttp3=GetXmlHttpObject()
     
    var userid      = document.getElementById("userid").value; 
	var verify_id	= document.getElementById("user_verify_id").value; 
    var desc_reason = document.getElementById("desc_reason").value;
    var form = document.getElementById('descSTATUS'); // if you passed the form, you wouldn't need this line.
    for(var i = 0; i < form.approve.length; i++){
          if(form.approve[i].checked){
          var approve = form.approve[i].value;
          }
 
     }
     //alert(desc_reason);
     if(desc_reason == ''){
        alert("Comments Required !!!.")
	return false;  
     }

    var url='<?php echo base_url()."user/account/approveverification/"?>'+userid+'/'+approve+'/'+desc_reason+'/'+verify_id;
    //alert(desc_reason);//return false;
    xmlHttp3.onreadystatechange=ShowAdditions
    xmlHttp3.open("GET",url,true);
    xmlHttp3.send(null);
    return false;

}

function ShowAdditions(){

    var userid123   = document.getElementById("userid").value;
	var ival		= document.getElementById("record_id").value;
    if(xmlHttp3.readyState==4 || xmlHttp3.readyState==0){ 		
            var result=xmlHttp3.responseText;
			document.getElementById("status_verify_"+ival).innerHTML=result;
	    	document.getElementById('desc_reason').value = '';
            Popup.hide('user_approve_desc');
           // window.opener.location.reload(true);
           // window.refresh();
 	}

} 

function addValiate(){
    var user_id 	=  document.getElementById("user_id").value;
    var proof_type 	=  document.getElementById("proof_type").value;
    var proof           =  document.getElementById("proof").value;
    var desc_status 	=  document.getElementById("desc_status").value;
    
    	if(user_id == 'select'){
  		alert("Please Select User !!!.")
		return false;  
  	}else if(proof_type == 'select'){
   		 alert("Please Select Type Of Proof !!!.")
		return false;  
  	}else if(proof == ''){
   		 alert("Please Upload Proof !!!.")
		return false;  
  	}else if(desc_status == ''){
   		 alert("Comments Required !!!.")
		return false;  
  	}
    
}
</script>
<?PHP  $from_player = $this->uri->segment(4, 0);   ?>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
          <?php if($_REQUEST['msg']=="Success"){ ?>
        <div id="UpdateMsgWrap" class="UpdateMsgWrap">
          <table width="100%" class="SuccessMsg">
            <tr>
              <td width="45"><img src="<?php echo base_url();?>static/images/icon-success.png" alt="" width="45" height="34" /></td>
              <td width="95%"><div id="showErrorMsg">Proof Added Successfully.</div></td>
            </tr>
          </table>
        </div>
        <br/><br/><br/><br/><br/>
        <?php } ?>
 
    <div class="content_wrap">
              <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/> <?php } ?> 
  <table width="100%" class="ContentHdr">
          <tr>
            <td><strong>ID Verification</strong><a style="float: right; position: relative; top: 5px;color:white; left: -42px;" href=javascript:openDESCRIPTION_Div();>Add New</a></td>
          </tr>
        </table>
        <form action="<?php echo base_url(); ?>user/account/verification?rid=32" method="post" name="tsearchform" id="tsearchform"  >
          <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
          
          <tr>
            <td><table width="100%" cellpadding="10" cellspacing="10">
            
              <tr>
                <td width="40%"><span class="TextFieldHdr">User Name:</span><br />
                  <label>
                  <input type="text" name="username" id="username" class="TextField" value="<?PHP if($_REQUEST['uname']!=""){ echo $_REQUEST['uname'];  }elseif(isset($USERNAME)){ echo $USERNAME; } ?>" >
                  <input type="hidden" name="verify_id" id="user_verify_id" class="TextField" value="" >
                  <input type="hidden" name="record_id" id="record_id" class="TextField" value="" >
                  </label></td>
                <td width="40%"><span class="TextFieldHdr">Verification Type:</span><br />
                  <label>
                  <select name="type" class="TextField"  >
                   <option value="select">Select</option>
                   <?php foreach($verificationTypes as $types){ ?>
				     <option <?php if(($_REQUEST['type'] == $types->VERIFICATION_TYPE_ID) || ($TYPE == $types->VERIFICATION_TYPE_ID)) { ?> selected="selected" <?php } ?> value="<?php echo $types->VERIFICATION_TYPE_ID; ?>"><?php echo $types->VERIFICATION; ?></option>
				   <?php } ?>
                  </select>
                  
                  </label></td>
                <td width="20%">&nbsp;</td>
              </tr>
              <tr>
                <td width="33%"><table>
                  <tr>
                    <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
        </td>
        </form>
        
        <td><form action="<?php echo base_url();?>user/account/verification?rid=32" method="post" name="clrform" id="clrform">
            <input name="reset" type="submit"  id="reset" value="Clear"  />
          </form></td>
        <td>&nbsp;</td>
        </tr>
        </table>
        </td>
        <td width="33%">&nbsp;</td>
        <td width="33%">&nbsp;</td>
        </tr>
        </table>
        </table>
      <table width="100%" class="PageHdr">
        
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
        <style>
.dettxt1 {
    color: #ffffff;
}
</style>
<?php  $resvalues=array();
//echo "<pre>";print_r($results);die;
       if(isset($results)){ 
       if(count($results)>0 && is_array($results)){
       for($i=0;$i<count($results);$i++){
			//get user name
			$VERIFICATION_TYPE_ID	= $results[$i]->VERIFICATION_TYPE_ID;
			$VERIFICATION_PROOF	    = $results[$i]->VERIFICATION_PROOF;
			$ADDRESS     	        = $results[$i]->ADDRESS;
			$REASON  	            = $results[$i]->REASON;
			$SUBMITTED_DATE  	    = date("d/m/Y",strtotime($results[$i]->SUBMITTED_DATE));
			$verificationName       = $this->Account_model->getVerificationNameById($VERIFICATION_TYPE_ID);
			$veriid                .= $results[$i]->VERIFICATION_TYPE_ID.',';
			$username	            = $this->Account_model->getUserNameById($results[$i]->USER_ID);
			$resvalue['SNO']        = $j+1;
			$resvalue['USERNAME']   = $username;
			$resvalue['VERIFICATION_TYPE_ID'] = $verificationName;	
	        $resvalue['VERIFICATION_PROOF']= '<a onclick="return hs.expand(this)" class="highslide " href="'.base_url().'static/uploads/proof/'.$VERIFICATION_PROOF.'"><img style="width:25px;" src="'.base_url().'static/uploads/proof/'.$VERIFICATION_PROOF.'"></a>';
			$resvalue['COMMENT'] = $REASON;
			$resvalue['SUBMITTED_DATE'] = $SUBMITTED_DATE;

			if($results[$i]->STATUS == 1){
		    	$status  = '<div id="status_verify_'.$i.'"><a href="javascript:openDESC_Div('.$results[$i]->USER_ID.','.$results[$i]->USER_VERIFICATION_ID.','.$i.');"><font color="#DBA901">Yet To Approve</font></a></div>';
			}elseif($results[$i]->STATUS == 2){
            	$status = '<div id="status_verify_'.$i.'"><font color="Green">Approved</font></div>';
            }else{
				$status  = '<div id="status_verify_'.$i.'"><font color="Red">Rejected</font></div>';
			}
			$resvalue['ACTION'] = $status;
										
            if($resvalue){
	            $arrs[] = $resvalue;
            } ?>

<script>
function closeDiv()
{
    document.getElementById('desc_reason').value = '';
        window.opener.location.reload(true);
        window.close();
}   
function clsDiv()
{
	document.getElementById('save_desc').innerHTML = '';	
	document.getElementById('desc_reason').value = '';
        //document.getElementById('userid').value = '';
	Popup.hide('user_approve_desc');
        window.opener.location.reload();
}
</script>
  <div id="user_approve_desc" class="popup" style="width:270px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
      
    <form enctype="multipart/form-data" action="" name="descSTATUS" id="descSTATUS" method="post" onsubmit="return verify();" >
      <!--<input type="hidden" name="userSID" id="userSID" value=""/>-->
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90%" height="50px;" style="font-size:120%;padding-left:10px;"> Verify Document</td>
          <td width="10%" align="right"><img style="cursor:pointer;" src="<?php echo base_url();?>static/images/close.png" alt="close" title="close" border="0" onClick="clsDiv();"/></td>
        </tr>
        <input type="hidden" name="userid" id="userid" value="">
       <tr>
          <td style="padding:11px;"><br />
<input type="radio" name="approve" id="approve" value="2"  checked>Approve
<input type="radio" name="approve" id="approve" value="0">Rejected
           </td>
        </tr>
      
        <tr>
          <td style="padding:11px;"><b>Comment</b> <br /><textarea maxlength="50" style="position: relative; top: 8px; resize:none;" name="desc_reason" id="desc_reason" cols="25" rows="5" class="TextArea"></textarea></td>
        </tr>
        <tr>
          <td style="padding:11px;" height="50px;"><input type="submit" name="submit" id="submit" value="Save" onclick="" />
            &nbsp;
            
            <input type="button" name="close" id="close" value="close" onClick="clsDiv();" />
            <span id="save_desc" style="font-size:90%;"></span></td>
        </tr>
      </table>
    </form>
  </div>
<?php  $j++;}
      }else{
       $arrs="";
      }
    }
	if(isset($arrs) && $arrs!=''){ ?>
<style>
.searchWrap1 {
    background-color: #F8F8F8;
    border: 1px solid #EEEEEE;
    border-radius: 5px;
    float: left;
    width: 100%;
	margin-top:10px;
	font-size:13px;
}
</style>
     <!--   <p class="searchWrap1" style="height:30px;"> <span style="position:relative;top:8px;left:10px"> 
        <?php if($from_player != ''){ ?>
        <b> Username: <font color="#FF3300"><?php echo $USER_NAME; ?></font></b>
        <?php } ?>
         &nbsp;&nbsp;&nbsp; </span> <span ><a style="float: right; position: relative; top: 10px; left: -42px;" href=javascript:openDESCRIPTION_Div();>Add New</a></span> </p>
        -->
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
					colNames:['Username','Id Type','ID Proof','Comment','Submitted Date','Action'],
                    colModel:[
                        //{name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:40},
						{name:'VERIFICATION_TYPE_ID',index:'VERIFICATION_TYPE_ID', align:"center", width:40},
						{name:'VERIFICATION_PROOF',index:'VERIFICATION_PROOF', align:"center", width:80},
						{name:'COMMENT',index:'COMMENT', align:"center", width:60},
						{name:'SUBMITTED_DATE',index:'SUBMITTED_DATE', align:"center", width:60},
						{name:'ACTION',index:'ACTION', align:"center", width:60},

                    ],
                    rowNum:500,
                    width: 999, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
            <div class="page-wrap">
              <div class="pagination">
                <?php	echo $pagination; ?>
              </div>
            </div>
          </div>
        </div>
        <?php }else{ 
		  if(empty($_POST) || $_POST['reset'] == 'Clear'){
		    $message  = "Please select the search criteria"; 
		  }else{
		    $message  = "There are currently no records found in this search criteria.";
		  }
		?>
        <div class="tableListWrap">
          <div class="data-list">
            <table id="list4" class="data">
              <tr>
                <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b><?php echo $message; ?></b></span></td>
              </tr>
            </table>
          </div>
        </div>
        <?php } ?>
        
       
 
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
  <div id="user_status_desc" class="popup" style="width:320px; border:3px solid black; background-color:#DDF4FF; padding:10px; display:none;">
    <form enctype="multipart/form-data" action="<?php echo base_url(); ?>user/account/addverification?rid=34" name="descriptionSTATUS" id="descriptionSTATUS" method="post" onsubmit="return addValiate();" >
      <input type="hidden" name="userSID" id="userSID" value=""/>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90%" height="50px;" style="font-size:120%;padding-left:10px;">Add New Verification Document</td>
          <td width="10%" align="right"><img style="cursor:pointer;" src="<?php echo base_url();?>static/images/close.png" alt="close" title="close" border="0" onClick="closeDiv();"/></td>
        </tr>
       <tr>
    
          <td style="padding:11px;"><b>Select User</b><br />
           <select style="position: relative; top: 8px;" name="user_id" id="user_id">
             <option value="select">Select</option>
			 <?php foreach($childUsers as $users){ 
			 	//if (!in_array($verificationType->VERIFICATION_TYPE_ID,$arrayVer)){ ?>
                <option value="<?php echo $users->USER_ID; ?>"><?php echo $users->USERNAME; ?></option>
             <?php 
			   //}
			 } ?>
           </select>
          </td>
        </tr>
        <tr>
<?php 	  $valdd = trim($veriid,",");
		  $arrayVer = explode(',',$valdd);  ?>
          <td style="padding:11px;"><b>Type of Proof </b><br />
           <select style="position: relative; top: 8px;" name="proof_type" id="proof_type">
             <option value="select">Select</option>
			 <?php foreach($verificationTypes as $verificationType){ 
			 	//if (!in_array($verificationType->VERIFICATION_TYPE_ID,$arrayVer)){ ?>
                <option value="<?php echo $verificationType->VERIFICATION_TYPE_ID; ?>"><?php echo $verificationType->VERIFICATION; ?></option>
             <?php 
			   //}
			 } ?>
           </select>
          </td>
        </tr>
         <tr>
          <td style="padding:11px;"><b>Upload Proof</b><br />
            <input style="position: relative; top: 8px;" type="file" name="proof" id="proof">
          </td>
        </tr>
        
        <tr>
          <td style="padding:11px;"><b>Comment</b> <br /><textarea maxlength="50" style="position: relative; top: 8px;resize:none;" name="desc_status"  id="desc_status" cols="30" rows="5" class="TextArea"></textarea></td>
        </tr>
        <tr>
          <td style="padding:11px;" height="50px;"><input type="submit" name="submit" id="submit" value="Save"/>
            &nbsp;
            <input type="hidden" name="uname" value="<?php if($_REQUEST){ $_REQUEST['uname']; }else{ echo $_POST['username']; } ?>" />
            <input type="hidden" name="type" value="<?php if($_REQUEST){ $_REQUEST['type']; }else{ echo $_POST['type']; } ?>" />
            <input type="hidden" name="key" value="<?php if($_REQUEST){ $_REQUEST['key']; }else{ echo $_POST['keyword']; } ?>" />
            <input type="hidden" name="userid" value="<?php echo $USER_ID; ?>">
            <input type="button" name="close" id="close" value="close" onClick="closeDiv();" />
            <span id="saved_desc" style="font-size:90%;"></span></td>
        </tr>
      </table>
    </form>
  </div>


</div>
</div>
<?php $this->load->view("common/footer"); ?>

