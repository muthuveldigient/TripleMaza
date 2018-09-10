
<style>
.error {
    color: red;
}
.err{
	 float: left;
    margin-left: 95%;
}
.err1{
	 margin-right: -181%;
    float: right;
}
.success {
    color: green;
    margin-left: 32px;
	font-size: 20px;
}
.failed {
    color: red;
    margin-left: 32px;
	font-size: 20px;
}
.gamename{ float: left;margin-left: 13%;margin-top:10px;margin-bottom:10px; }
.gamedesc{ margin-left: 31%;margin-top:10px;margin-bottom:10px;}
.SHdr5line {
    float: left;
    margin: 6px;
}
</style>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<div class="MainArea">
<?php echo $this->load->view("common/sidebar"); ?>
 <div class="RightWrap">
	<div class="content_wrap">
      <div class="tableListWrap">
		<div class="ContentHdr">Edit Games Name</div>
		<?PHP if($msg==1) { ?>
			<div class="success">Game name has been updated successfully..!</div>
		<?PHP } ?> 

		<?PHP if($msg==2) { ?>
			<div class="failed">Game name not modified..!</div>
		<?PHP } ?>

<form name="update_game"  id="update_game" action="" method="post">
	<div class="TopLine">
	<div class="addadminWrap1">
			<div class="STblHdraddadmin">
				<div class="gamename"><b>GAME NAME</b></div>
				<div class="gamedesc"><b>GAME DESCRIPTION</b></div>
			</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 1:</div>
			<div class="SHdr5line"><input name="game1" type="text" value="<?= (!empty($gameList[1]['GAMES_NAME'])?$gameList[1]['GAMES_NAME']:"")?>" class="TextField4" id="game1" tabindex="1" required  maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description1" type="text" value="<?= (!empty($gameList[1]['DESCRIPTION'])?$gameList[1]['DESCRIPTION']:"")?>" class="TextField4" id="description1"  tabindex="2" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game1-error" class="error err" for="game1"></label></div>
			<div class="SHdr5line">
			<label id="description1-error" class="error err1" for="description1"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 2:</div>
			<div class="SHdr5line"><input name="game2" type="text" value="<?= (!empty($gameList[2]['GAMES_NAME'])?$gameList[2]['GAMES_NAME']:"")?>" class="TextField4" id="game2" tabindex="3" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description2" type="text" value="<?= (!empty($gameList[2]['DESCRIPTION'])?$gameList[2]['DESCRIPTION']:"")?>" class="TextField4" id="description2"  tabindex="4" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game2-error" class="error err" for="game2"></label></div>
			<div class="SHdr5line">
			<label id="description2-error" class="error err1" for="description2"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 3:</div>
			<div class="SHdr5line"><input name="game3" type="text" value="<?= (!empty($gameList[3]['GAMES_NAME'])?$gameList[3]['GAMES_NAME']:"")?>" class="TextField4" id="game3" tabindex="5" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description3" type="text" value="<?= (!empty($gameList[3]['DESCRIPTION'])?$gameList[3]['DESCRIPTION']:"")?>" class="TextField4" id="description3"  tabindex="6" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game3-error" class="error err" for="game3"></label></div>
			<div class="SHdr5line">
			<label id="description3-error" class="error err1" for="description3"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 4:</div>
			<div class="SHdr5line"><input name="game4" type="text" value="<?= (!empty($gameList[4]['GAMES_NAME'])?$gameList[4]['GAMES_NAME']:"")?>" class="TextField4" id="game4" tabindex="7" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description4" type="text" value="<?= (!empty($gameList[4]['DESCRIPTION'])?$gameList[4]['DESCRIPTION']:"")?>" class="TextField4" id="description4"  tabindex="8" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game4-error" class="error err" for="game4"></label></div>
			<div class="SHdr5line">
			<label id="description4-error" class="error err1" for="description4"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 5:</div>
			<div class="SHdr5line"><input name="game5" type="text" value="<?= (!empty($gameList[5]['GAMES_NAME'])?$gameList[5]['GAMES_NAME']:"")?>" class="TextField4" id="game5" tabindex="9" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description5" type="text" value="<?= (!empty($gameList[5]['DESCRIPTION'])?$gameList[5]['DESCRIPTION']:"")?>" class="TextField4" id="description5"  tabindex="10" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game5-error" class="error err" for="game5"></label></div>
			<div class="SHdr5line">
			<label id="description5-error" class="error err1" for="description5"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 6:</div>
			<div class="SHdr5line"><input name="game6" type="text" value="<?= (!empty($gameList[6]['GAMES_NAME'])?$gameList[6]['GAMES_NAME']:"")?>" class="TextField4" id="game6" tabindex="11" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description6" type="text" value="<?= (!empty($gameList[6]['DESCRIPTION'])?$gameList[6]['DESCRIPTION']:"")?>" class="TextField4" id="description6"  tabindex="12" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game6-error" class="error err" for="game6"></label></div>
			<div class="SHdr5line">
			<label id="description6-error" class="error err1" for="description6"></label></div>
			
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 7:</div>
			<div class="SHdr5line"><input name="game7" type="text" value="<?= (!empty($gameList[7]['GAMES_NAME'])?$gameList[7]['GAMES_NAME']:"")?>" class="TextField4" id="game7"  tabindex="13" required maxlength="20" size="20" /></div>
			
			<div class="SHdr5line"><input name="description7" type="text" value="<?= (!empty($gameList[7]['DESCRIPTION'])?$gameList[7]['DESCRIPTION']:"")?>" class="TextField4" id="description7"  tabindex="14" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game7-error" class="error err" for="game7"></label></div>
			<div class="SHdr5line">
			<label id="description7-error" class="error err1" for="description7"></label></div>
			
		</div>
		
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 8:</div>
			<div class="SHdr5line"><input name="game8" type="text" value="<?= (!empty($gameList[8]['GAMES_NAME'])?$gameList[8]['GAMES_NAME']:"")?>" class="TextField4" id="game8" tabindex="15" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description8" type="text" value="<?= (!empty($gameList[8]['DESCRIPTION'])?$gameList[8]['DESCRIPTION']:"")?>" class="TextField4" id="description8"  tabindex="16" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game8-error" class="error err" for="game8"></label></div>
			<div class="SHdr5line">
			<label id="description8-error" class="error err1" for="description8"></label></div>
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 9:</div>
			<div class="SHdr5line"><input name="game9" type="text" value="<?= (!empty($gameList[9]['GAMES_NAME'])?$gameList[9]['GAMES_NAME']:"")?>" class="TextField4" id="game9" tabindex="17" required maxlength="20" size="20" /></div>
			<div class="SHdr5line"><input name="description9" type="text" value="<?= (!empty($gameList[9]['DESCRIPTION'])?$gameList[9]['DESCRIPTION']:"")?>" class="TextField4" id="description9"  tabindex="18" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game9-error" class="error err" for="game9"></label></div>
			<div class="SHdr5line">
			<label id="description9-error" class="error err1" for="description9"></label></div>
			
		</div>
		<div class="STblHdraddadmin">
			<div class="SHdr4line">GAME NAME 10:</div>
			<div class="SHdr5line"><input name="game10" type="text" value="<?= (!empty($gameList[10]['GAMES_NAME'])?$gameList[10]['GAMES_NAME']:"")?>" class="TextField4" id="game10"  tabindex="19" required maxlength="20" size="20" /></div>
			
			<div class="SHdr5line"><input name="description10" type="text" value="<?= (!empty($gameList[10]['DESCRIPTION'])?$gameList[10]['DESCRIPTION']:"")?>" class="TextField4" id="description10"  tabindex="20" required maxlength="20" size="20" /></div>
			<div class="SHdr5line">
			<label id="game10-error" class="error err" for="game10"></label></div>
			<div class="SHdr5line">
			<label id="description10-error" class="error err1" for="description10"></label></div>
			
		</div>
		
		<div class="STblHdraddadmin">
			<div class="SHdr4line"></div>
			<div class="SHdr5line"> <br />
				<input type="submit" class="buttonBig" value="Update" name="submit" id="submit" />
			</div>
		</div>
	</div>  
	</div>
  </form>
 <script> 
 jQuery.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element)
				|| /^(?!.*?[._]{2})[a-zA-Z0-9_. ]+$/i.test(value);
	}, "Letters, numbers, dot or underscore only allowed");
	
  $("#update_game").validate({
		rules : {
			game1 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game2 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game3 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game4 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game5 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game6 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game7 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game8 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game9 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			},
			game10 : {
				required: true,
				alphanumeric : true,
				maxlength : 20
			}
			
		},
		// Specify validation error messages
		messages : {
			game1 :{ 
				required : "Please enter game name",
			},
			game2 :{ 
				required : "Please enter game name",
			},
			game3 :{ 
				required : "Please enter game name",
			},
			game4 :{ 
				required : "Please enter game name",
			},
			game5 :{ 
				required : "Please enter game name",
			},
			game6 :{ 
				required : "Please enter game name",
			},
			game7 :{ 
				required : "Please enter game name",
			},
			game8 :{ 
				required : "Please enter game name",
			},
			game9 :{ 
				required : "Please enter game name",
			},
			game10 :{ 
				required : "Please enter game name",
			}
		}
});
	</script>
</div>
</div>
</div>
</div>
<?php $this->load->view("common/footer"); ?>