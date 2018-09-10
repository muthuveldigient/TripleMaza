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
      <?php if(isset($_REQUEST['errmsg'])){
            echo $this->common_model->errorHandling($_REQUEST['errmsg']); } ?>       
  <table width="100%" class="PageHdr">
  <tr>
    <td><strong>Search IP Address</strong>
      <table width="50%" align="right">
  <tr>
    <td><div align="right">
      <a href="<?php echo base_url();?>cms/pages/create" class="dettxt">Create Page</a></div></td>
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
    <form action="<?php echo base_url()?>games/poker/game/view" method="post" name="tsearchform" id="tsearchform">
        <table width="" cellpadding="0" cellspacing="0" bgcolor="#993366" class="searchWrap">
        <tr>
          <td>
            <table width="100%" class="ContentHdr">
              <tr>
                <td><strong>Search</strong></td>
              </tr>
            </table>
            <table width="100%" cellpadding="10" cellspacing="10">
          	  <tr>
              <td width="40%"><span class="TextFieldHdr">Game Name:</span><br />
                <label>
                <input type="text" name="gameName" id="gameName" class="TextField" value="<?PHP if(isset($_REQUEST['gameName'])) echo $_REQUEST['gameName']; ?>" >
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Game Type:</span><br />
                <label>
                <select name="game_type" class="ListMenu" id="select2">
                  <option value="">select</option>
                  <?php foreach($gameTypes as $gametype){ ?>
                  <option value="<?php echo $gametype->ID; ?>"><?php echo $gametype->TYPE; ?></option>
                  <?php } ?>
                </select>
                </label></td>
              <td width="20%">&nbsp;</td>
            </tr>
              <tr>
              <td width="40%"><span class="TextFieldHdr">Currency Type:</span><br />
                <label>
                 <select name="currency_type" class="ListMenu" id="ctype">
                   <option value="">select</option>
                  <?php foreach($currencyTypes as $currencyType){ ?>
                  <option value="<?php echo $currencyType->ID; ?>"><?php echo $currencyType->VALUE; ?></option>
                  <?php } ?>
                </select>
                </label></td>
              <td width="40%"><span class="TextFieldHdr">Pot Limit:</span><br />
                <label>
                <input type="text" name="potlimit" id="potlimit" class="TextField" value="<?PHP if(isset($_REQUEST['potlimit'])) echo $_REQUEST['potlimit']; ?>" >
                </label></td>
              <td width="20%">&nbsp;</td>
            </tr>
          	  <tr>
              <td width="33%"><table>
                <tr>
                  <td><input name="keyword" type="submit"  id="button" value="Search" style="float:left;" />
                </td>
                </tr>
                </table> </td></tr>
             </table>
           </td>
          </tr>
          </table>     
      </form>
      
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

												$resvalue['CHECKALL']		= "<input type='checkbox' value='61.12.5.34' id='c' name='c'>";
												$resvalue['SNO']=$j+1;
												$resvalue['USERNAME']		= $results[$i]->USERNAME;
												$resvalue['ACTION_NAME']	= $results[$i]->ACTION_NAME;
												$resvalue['DATE_TIME']		= $results[$i]->DATE_TIME;
												$resvalue['SYSTEM_IP']		= $results[$i]->SYSTEM_IP;
												$resvalue['STATUS']			= $results[$i]->STATUS;
												
												
												
												$resvalue['RSTATUS']			= '<a href="edit/'.$results[$i]->TRACKING_ID.'"><img src="'.base_url().'static/images/edit-img.png" alt="history"></a>';
												
												$resvalue['LSTATUS']		= '<a href="delete/'.$results[$i]->TRACKING_ID.'" onClick="return confirmDelete();"><img src="'.base_url().'static/images/delete.png" alt="Delete"></a>';
												
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
					colNames:["<input type='checkbox'>",'S.No','Username','IP Address','Action Name','Date Time','Stauts','Login Status','Register Status'],
                    colModel:[
						{name:'CHECKALL',index:'CHECKALL', align:"center", width:30},
                        {name:'SNO',index:'SNO', align:"center", width:35, sorttype:"int"},
						{name:'USERNAME',index:'USERNAME', align:"center", width:80},
					    {name:'ACTION_NAME',index:'ACTION_NAME', align:"center", width:60},
						{name:'DATE_TIME',index:'DATE_TIME', align:"center", width:100},
						{name:'SYSTEM_IP',index:'SYSTEM_IP', align:"center", width:60},
						{name:'STATUS',index:'STATUS', align:"center", width:60},
						{name:'LSTATUS',index:'LSTATUS', align:"center", width:60},
                        {name:'RSTATUS',index:'RSTATUS', width:60, align:"center"},
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