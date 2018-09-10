<script type="text/javascript" src="<?php echo base_url(); ?>static/js/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>static/css/highslide.css" />
<script>
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

</script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
<div class="content_wrap">
  <div class="tableListWrap">
  <table width="100%" class="PageHdr">
  <tr>
    <td><strong>Site Configuration</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right">
    </div></td>
  </tr>
</table>
    </td>
  </tr>
</table>
<?php 
  if($msg != ''){  ?>
	 <div class="UpdateMsgWrap">
	  <table width="100%" class="SuccessMsg">
		<tr>
		  <td width="45"><img src="<?php echo base_url();?>images/icon-success.png" alt="" width="45" height="34" /></td>
		  <td width="95%"><?php echo $msg; ?>!!!</td>
		  </tr>
	  </table>
	</div>
<?php } ?>
  <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
          <table width="100%" class="ContentHdr">
      <tr>
        <td>List</td>
        </tr>
        </table>
        
    
      </tr>
    </table>
       <?php
					if(isset($page)){
						$j=$page;
					}else{
						$j=0;
					}   
				
				   $resvalues=array();
				   if(isset($results)){ 
					if(count($results)>0 && is_array($results)){
							for($i=0;$i<count($results);$i++){
								$resvalue['SNO']=$j+1;
								$resvalue['KEY_NAME']	= $results[$i]->KEY_NAME;
								$resvalue['VALUE']	= $results[$i]->VALUE;
								
								$configId = $results[$i]->CONFIG_ID;
								$resvalue['EDIT'] = "<a onclick=\"return hs.htmlExpand( this, {
    	objectType: 'iframe', outlineType: 'rounded-white', wrapperClassName: 'highslide-wrapper drag-header',
        outlineWhileAnimating: true, preserveContent: false, width: 250 } )\" class=\"highslide\" id=\"formexample\" href=\"".base_url()."cms/ajax/config/".$configId."\"><img src=".base_url()."static/images/edit-img.png></a>";
								
								//$resvalue['EDIT']	= '<a href="banner/edit/'.$results[$i]->BANNER_MANAGER_ID.'"><img src="'.base_url().'static/images/edit-img.png" alt="history"></a>';												
							if($resvalue){
							$arrs[] = $resvalue;
							}
						$j++;}
					}else{
						$arrs="";
						
					}
				   }
			
                                   
            ?>
    <?php 
	if(isset($arrs) && $arrs!=''){ ?>
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
					colNames:['S.No','Name','Value','Edit'],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'KEY_NAME',index:'KEY_NAME', align:"center", width:50},
						{name:'VALUE',index:'VALUE', align:"center", width:100},
						{name:'EDIT',index:'EDIT', align:"center", width:20},
                    ],
                    rowNum:500,
                    width: 1033, height: "100%"
                });
                var mydata = <?php echo json_encode($arrs);?>;
                for(var i=0;i<=mydata.length;i++)
                    jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
                </script>
        <div class="page-wrap">
          <div class="pagination">
            <?php	echo $links; ?>
          </div>
        </div>
      </div>
    </div>
    <?php }else{ ?>
	<div class="tableListWrap">
      <div class="data-list">
        <table id="list4" class="data">
          <tr>
            <td><img src="<?php echo base_url(); ?>static/images/userinfo.png"> <span style="position: relative;top: -9px;"><b>There are currently no users found in this search criteria.</b></span></td>
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