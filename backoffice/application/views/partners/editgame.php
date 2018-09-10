<link href="<?php echo base_url();?>jsValidation/style.css" rel="stylesheet">
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url();?>jsValidation/assets/js/jquery.validate.min.js"></script>
<script language="javascript">
$(document).ready(function() {
	$('input[name^="allgames_"]').change(function() {
		var catID=this.id.split("_");
		if($(this).is(':checked')) {
			$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
				$("#"+el.id).prop("checked",true);				
			});
		} else {
			$("input[id^='"+catID[1]+"_games']").each(function(i, el) {		
				$("#"+el.id).prop("checked",false);		
			});
		}
    });
	
	$('input[id*="_games_"]').change(function() {
		if ($("#"+this.id).prop("checked")==false){
			var catID1=this.id.split("_");
			$("#allgames_"+catID1[0]).prop("checked",false);	
		} 
	});
});
</script>
<div class="MainArea">
	<?php echo $this->load->view("common/sidebar"); ?>

<div class="RightWrap">
  <div class="RightInBg">
    <div class="RightInSubBg">
            <form name="regForm" id="regForm" method="POST" action="" onsubmit=" return distributor_validate(this,0); ">
        <div class="UsrSrchmainwrap">
                    <div class="PageHdr">Game Settings <a href="<?php echo base_url().'partners/partners/editPartner/'.base64_encode($pid).'?rid=51' ?>"  class="button" style="float: right;">Back</a></div>
        </div>
        <div class="TopLine">
          <div class="SeachResultWrap">
            <div class="tableWrap">
              <div class="UDSubBg">
                <div class="UDCommonWrap">
                  <div class="UDLeftWrap">
                    <div class="UDFieldtitle"><?php echo $roleName ?>:</div>
                    <div class="UDFieldTxtFld"> <?php echo $partnerName;?>&nbsp;<span class="mandatory">*</span> <br>
                      <span id="alreadyexists"></span> </div>
                  </div>
                </div>
				<?php if(!empty( $categoryInfo )){ ?>
						<div class="UDCommonWrap">
						<?php foreach($categoryInfo as $key=> $val){ 
							$categoryName = str_replace(' ', '', $key);
								if($sno==4) {?>
									</div><div class="UDCommonWrap">
							<?php		$sno=1;
								}?>

							<div class="UDRightWrap" style="width:150px;">
								<div class="UDFieldtitle" style="width:150px;"><?php echo $key ?></div>
								<div class="UDFieldTxtFld" style="width:150px;">
									<div style="height:100px;width:150px;border: 1px solid;background-color: #fff;overflow: auto;line-height: 18px;">
									<div style="padding:1% 2%">
									<label><input type="checkbox" name="<?php echo 'allgames_'.$categoryName?>" id="<?php echo 'allgames_'.$categoryName?>" style="float:left;margin: 1.5% 3% 1%;" />Select All</label>
									</div>
									<?php foreach($val as $category){
											extract($category);
											
										?>
										<div style="padding:1% 2%">
										<label>
										<?php if(in_array($MINIGAMES_NAME,$assignedGames)) {?>
											<input type="checkbox" name="category[]" id="<?php echo $categoryName;?>_games_<?php echo $MINIGAMES_ID;?>" checked="checked" value="<?php echo $MINIGAMES_NAME;?>" style="float:left;margin: 1.5% 3% 1%;" /><?php echo $DESCRIPTION;?>
										<?php } else { ?>
											<input type="checkbox" name="category[]" id="<?php echo $categoryName;?>_games_<?php echo $MINIGAMES_ID;?>" value="<?php echo $MINIGAMES_NAME;?>" style="float:left;margin: 1.5% 3% 1%;" /><?php echo $DESCRIPTION;?>					
										<?php } ?>
										</label>
										</div>
										<?php } ?>
									</div>	  
								</div>
							</div>
							<div class="UDRightWrap" style="width:50px;padding-top:60px;">
								<div class="UDFieldtitle"></div>
								<div class="UDFieldTxtFld" style="width:50px;text-align:center;"></div>
							</div>	
							<?php
								$sno++;
							}?>
						</div>
		<?php	}  ?>
			</div>
			</div>
		  </div>
		  <?php if(!empty( $categoryInfo )){ ?>
			<div class="SeachResultWrap2">
				<input type="hidden" name="partner_id_dist" id="partner_id_dist" value="7"> 
				<input type="submit" name="Submit" id="Submit" class="button" onclick="return confirm('Are you sure you want to Update?. This change will affect immediately for this partner');" value="Update" tabindex="28">
			</div>
		<?php	}  ?>
		  </div>
           
      </form>
          </div>
  </div>
  <!-- ContentWrap -->
</div>
</div>
<?php $this->load->view("common/footer"); ?>
