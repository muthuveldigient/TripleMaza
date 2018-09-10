<link href="<?php echo base_url(); ?>static/css/dashboard.css" rel="stylesheet" type="text/css" />
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
<div class="RightWrap">
	<table width="100%" class="PageHdr">
    	<tr>
        	<td><strong>Dashboard</strong></td>
		</tr>
	</table> 
      <?php if(isset($_REQUEST['errmsg'])){ echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>      
<!--- Add by karthick -->
<style>
	.tab{display:table;margin-top:20px;}
	.player{width:330px;overflow:hidden;margin-top:20px;float:left;}
	.heading{width:325px;overflow:hidden;float:left;display:table;}
	.heading li{padding:5px 0 0 0;border:1px solid #ccc;display:table-cell;vertical-align:middle;}	
	.heading li h3{text-align:center;}
	.heading li span{display:table-cell;text-align:left;margin-top:4px;border-top:1px solid #ccc;border-right:1px solid #ccc;float:left;padding:5px;height:25px;}
	.heading li h3 a{font--weilght:bold;color:#000;text-decoration:none;}
	.heading li.l1{width:31%;border-right:none;}
	.heading li.l2{width:235px;}
	.cntlist{width:325px;float:left;display:table}
	.cntlist li{text-align:left;padding:5px;border-bottom:1px solid #ccc;border-right:1px solid #ccc;display:table-cell;height:25px;}
	.cntlist a{text-decoration:none;color:#0066cc;}
	.cntl1{width:31%;border-left:1px solid #ccc;}
	.cntl2{width:34%;}
	.cntl3{width:35%;}
	.lst{margin-right:0;}
	.spn1{width:45%}
	.spn2{width:45%;border-right:0px !important;}
	.dtype{width:89%;border-right:0 !important;}
</style>  	

</div>
</div> <!-- MainArea ends here->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>