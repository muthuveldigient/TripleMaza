<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>  
<script language="javascript" type="text/javascript">
$(document).ready(function () {	 
	$('#serverSettings').validate({ // initialize the plugin
	    onkeyup:false,
		onblur:true,
        rules: {
            serverMessage: {
                required: true
            }                      
        },
		submitHandler: function (form) { // for demo 
			var status = confirm("Are you sure want to stop the game? If yes, then, you must restart the game server, soon after the update!");
		   	if(status == true){
				document.form.submit();
				return true;
		   	} else {
		   		return false; 
		   	}
			return false; // for demo
	   }
    });

	
});
</script>
<script type="text/javascript">
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>
<div class="MainArea"> <?php echo $this->load->view("common/sidebar"); ?>
  <div class="RightWrap">
    <div class="content_wrap">
      <div class="tableListWrap">
       	<?php if($this->session->flashdata('message')) { ?>
				<table width="100%" class="SuccessMsg">
		          <tbody>
                  <tr>
            		<td width="45"><img width="45" height="34" alt="" src="<?php echo base_url(); ?>static/images/icon-success.png"></td>
            		<td width="95%"><?php echo $this->session->flashdata('message');?></td>
          		   </tr>
        		  </tbody>
                 </table>
            <?php } ?>    
        <table width="100%" class="ContentHdr">
          <tbody>
            <tr>
              <td><strong>Graceful shut down settings</strong> </td>
            </tr>
          </tbody>
        </table>
  		
        <form name="serverSettings" id="serverSettings" action = "<?php echo base_url();?>settings/setting/index?rid=81" method="post"> 
          <table width="100%" cellpadding="10" cellspacing="10" class="searchWrap">
         
        <tr>
          <td width="30%"><span class="TextFieldHdr">Message:</span><span id="customer" class="mandatory">*</span><br />
		  	 <textarea rows="4"  name="serverMessage" id="serverMessage" style="width:85%" tabindex="1"><?php echo $serverInfo[0]->DESCRIPTION;?></textarea>        	 
          </td>          
          <td width="30%">&nbsp;
          </td>
		  <tr>	
		  	<td width="30%" style="font-size: 15px;color: red;font-weight: bold;">Note:After updating the page, you must restart the game server</td>
		  </tr>
         </tr>         
       <td width="33%"><table>   
        <tr>
         <td>
		 <input type="hidden" name="serverStatus" id="serverStatus" value="1"  />	
		 <input name="keyword" type="submit"  id="button" value="Update" tabindex="3" style="float:left;" /> </td> 
 	   </tr>
     </tr>   
     </table>   
    </table> 
        </form>        
        </div>
      </div>
    </div>
  </div>

<?php $this->load->view("common/footer"); ?>
