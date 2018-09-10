<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
hs.graphicsDir = "<?php echo base_url()?>static/images/";
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
</script>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/css/highslide.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/ui.jqgrid.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>static/jquery/css/jquery-ui-1.css">
<script src="<?php echo base_url();?>static/jquery/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>static/jquery/js/jquery.jqGrid.min.js" type="text/javascript"></script>

<?php

$page = $this->uri->segment(3);
if(isset($page) && $page !='') {
	$j=$page;
} else {
	$j=0;
}  
$i=1; 
foreach($viewPPlayerInfo as $index=>$pPlayer) {
	$resValue[$index]['SNo']       = $i;		
	$resValue[$index]['USERNAME']  = $pPlayer->USERNAME;	
	$resValue[$index]['EMAIL_ID']  = $pPlayer->EMAIL_ID;
	$resValue[$index]['CITY']      = $pPlayer->CITY;	
	$resValue[$index]['STATE']     = $pPlayer->STATE;
	$resValue[$index]['COUNTRY']   = $pPlayer->COUNTRY;	
	if($pPlayer->ACCOUNT_STATUS==1){
		$status='Active';
	}else{
		$status='InActive';
	}
	$resValue[$index]['ACCOUNT_STATUS']   = $status;	
	$i++;
}
?>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>
    <div class="RightWrap">
    	<div class="content_wrap">
      <div class="tableListWrap">
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); ?> <br/><br/><br/><br/> <?php } ?>             
			<table width="100%" class="ContentHdr">
            	<tr>
                	<td><strong>List Players</strong></td>
                </tr>
            </table>
               
            <table width="100%" class="PageHdr">
                <tr>
                    <td><strong>Partner Name : <?php echo $partnername;?></strong></td>
                </tr>
            </table>                 
	    <div class="tableListWrap">
      		<div class="data-list">
           		<?php if(!empty($viewPPlayerInfo)) {?>
                <table id="list2"></table>
                <div id="pager2"></div>
                <script type="text/javascript">
                        jQuery("#list2").jqGrid({
                            datatype: "local",
                            colNames:['S.No', 'Username', 'Email', 'City','State','Country','Status'],
							colModel:[							
                                {name:'SNo',index:'SNo', width:40,sortable:false},
								{name:'USERNAME',index:'USERNAME', width:90}, 
                                {name:'EMAIL_ID',index:'EMAIL_ID', width:110},
								{name:'CITY',index:'CITY',width:90},
                                {name:'STATE',index:'STATE', width:90}, 
								{name:'COUNTRY',index:'COUNTRY',width:80},								 
                                {name:'ACCOUNT_STATUS',index:'ACCOUNT_STATUS', width:40, align:"center",sortable:false} 							
                            ],
                            rowNum:500,
                            width: 999, height: "100%"
                        });
                        var mydata = <?php echo json_encode($resValue);?>;
                        for(var i=0;i<=mydata.length;i++)
                            jQuery("#list2").jqGrid('addRowData',i+1,mydata[i]);
                </script> 
                <?php } else {?> 
                <table id="list4" class="data">
                  <tr>
                    <td>
                        <img src="<?php echo base_url(); ?>static/images/userinfo.png"><span style="position: relative;top: -9px;"><b>There is no record to display</b></span>
                     </td>
                  </tr>
                </table>      
               <?php } ?>                            
            </div>
        </div>                           
        </div>
        </div>
    </div>
</div>
<?php $this->load->view("common/footer"); ?>	