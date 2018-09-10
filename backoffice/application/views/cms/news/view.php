<script>
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
    <td><strong>News</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right"><a href="<?php echo base_url();?>cms/news/add" class="dettxt">Add New News</a></div></td>
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
												$resvalue['NEWS_TITLE']	= trim(ucfirst($results[$i]->NEWS_TITLE));
												$resvalue['NEWS_DESCRIPTION']	= $this->common_model->shortenStr($results[$i]->NEWS_DESCRIPTION,'50');
												$resvalue['ACTIVE_DAYS']	= $results[$i]->ACTIVE_HOURS/24;
												if($results[$i]->HIGHLIGHTED == 1){
												$resvalue['HIGH_NEWS']	= '<a href="news/dehigh/'.$results[$i]->NEWS_ID.'"><img src="'.base_url().'static/images/highlight.png" alt="history"></a>';
												}else{
													$resvalue['HIGH_NEWS']	= '<a href="news/high/'.$results[$i]->NEWS_ID.'"><img src="'.base_url().'static/images/nonhighligh.png" alt="history"></a>';
												}
												
												$resvalue['DATE']	= $results[$i]->CREATE_TIMESTAMP;
												
												if($results[$i]->STATUS == 1){
												    $resvalue['STATUS']	= '<a href="news/deactive/'.$results[$i]->NEWS_ID.'"><img src="'.base_url().'static/images/active.gif" alt="history"></a>';
												}else{
													$resvalue['STATUS']	= '<a href="news/active/'.$results[$i]->NEWS_ID.'"><img src="'.base_url().'static/images/deactive.gif" alt="history"></a>';
												}
												
												$resvalue['EDIT']			= '<a href="news/edit/'.$results[$i]->NEWS_ID.'"><img src="'.base_url().'static/images/edit-img.png" alt="history"></a>';												
												$resvalue['DELETE']					= '<a href="news/delete/'.$results[$i]->NEWS_ID.'" onClick="return confirmDelete();"><img src="'.base_url().'static/images/delete.png" alt="Delete"></a>';
												
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
					colNames:['S.No','News Title','News Description','Active Days',"Highlighted",'Date','Status','Edit','Delete'],
                    colModel:[
                        {name:'SNO',index:'SNO', align:"center", width:20, sorttype:"int"},
						{name:'NEWS_TITLE',index:'NEWS_TITLE', align:"center", width:50},
						{name:'NEWS_DESCRIPTION',index:'NEWS_DESCRIPTION', align:"center", width:100},
						{name:'ACTIVE_DAYS',index:'ACTIVE_DAYS', width:30, align:"center"},
						{name:'HIGH_NEWS',index:'HIGH_NEWS', width:30, align:"center"},
						{name:'DATE',index:'DATE', width:50, align:"center"},
						{name:'STATUS',index:'STATUS', width:20, align:"center"},
						{name:'EDIT',index:'EDIT', align:"center", width:20},
                        {name:'DELETE',index:'DELETE', width:20, align:"center"},
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