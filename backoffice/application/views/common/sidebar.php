<?php error_reporting(0);
$status =$this->common_model->sessionStatus();
?>
<script src="<?php echo base_url();?>static/js/lightbox-form.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>static/css/lightbox-form.css">
<script type="text/javascript">
    $(document).ready(function(){
            setTimeout(function(){
                // Slide
                $('#menu1 > li > a.expanded + ul').slideToggle('');
                $('#menu1 > li > a').click(function(){
                        $(this).toggleClass('expanded').toggleClass('collapsed').parent().find('> ul').slideToggle('');
                        var excclass = $(this).attr("class");
                        var exclass = $(this).attr("class");
                        var posid = $(this).attr("id");
						
                        if(posid == 1){
                            var collap = '<?php echo base_url().'/static/images/user-home.png'; ?>';
                            var expan =  '<?php echo base_url().'/static/images/user-home.png'; ?>';
                        }else{
                            var collap = '<?php echo base_url().'/static/images/collapse.gif';?>';
                            var expan =  '<?php echo base_url().'/static/images/expand.gif'; ?>';
                        }
                        if(exclass=='menuitem submenuheader expanded'){
                        $("#imgpos"+posid).html('<img src="'+collap+'" width="11" height="11" align="left" style="padding:2px 5px 0 0" >');
                        }else{
                        $("#imgpos"+posid).html('<img src="'+expan+'" width="11" height="11" align="left" style="padding:2px 5px 0 0" >');    
                        }
                });
            }, 250);
    });
</script>
<style>
.example_menu1 ul {	display: none;  }
#menu1 {	margin: 0;    }
#menu1 li,
.example_menu li {	background-image: none;	margin: 0;	padding: 0;  }
.example_menu ul ul {	display: block;  }
.style5{  h1 {text-decoration:underline; }  color: #0066CC;  font: bold;  text-decoration:none;  }
</style>
<script type="text/javascript">
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block'){
          e.style.display = 'none';
          document.getElementById('changeToggleIcon').innerHTML = "<img src='<?php echo base_url();?>static/images/expand.gif' style='padding:2px 5px 0 0' />";
       }else{
          e.style.display = 'block';
          document.getElementById('changeToggleIcon').innerHTML = "<img src='<?php echo base_url();?>static/images/collapse.gif' style='padding:2px 5px 0 0' />";
       }
    }
</script>

<?php
//echo "<pre>"; print_r($this->session->userdata);die;
$dataid=array("adminuserid"=>$this->session->userdata['adminuserid'],"partnerid"=>$this->session->userdata['partnerid'],"transaction_password"=>$this->session->userdata['partnertransaction_password'],"partnertype"=>$this->session->userdata['partnertypeid']);                 
$menu=$this->common_model->generate_menu($dataid); 
 if(isset($menu)){  ?>
<div class="LeftMenuWrap">
<div class="MainMenuHdr">Main Menu</div>
    <?php
    $k=1;

    for($i=0;$i<count($menu);$i++){ ?>  
    <div class="glossymenu">
    <ul id="menu1" class="example_menu1">
    <?php //echo $menu[$i]['roleid'] .'=='. $_REQUEST['rid'];
       $uid = $this->input->get('rid');
        $parid=$this->common_model->getParentIdByRoleId($uid);
        if(isset($parid)){
            if($menu[$i]["roleid"] == $parid){
                $v = 'expanded';
                $di = 'display: block;';
            }else{
                $v = 'collapsed';
                $di = 'display: none;';
            }
        }else{
            $v = 'collapsed';
            $di = 'display: none;';
        }
           
        if($menu[$i]["role"]){ 
            //$mainlink=$menu[$i]['link'];  ?> 
        <li>
            <?php
         if( $k == 1 ){
              $linkValue = base_url();
              $imgcollapse = base_url()."/static/images/user-home.png";
              $imgexpand = base_url()."/static/images/user-home.png";
         }elseif( $k == 8 ){
            // $linkValue =  "http://dev.test.digient.co/pokerbaazi/administrator/index.php?option=com_login&task=login&username=admin&passwd=digient1$1";
             $imgcollapse = base_url()."/static/images/collapse.gif";
             $imgexpand = base_url()."/static/images/expand.gif";
         }else{
             $linkValue = "#";
             $imgcollapse = base_url()."/static/images/collapse.gif";
             $imgexpand = base_url()."/static/images/expand.gif";
         } 
   		 if( $k == 8 ){ ?>  
   <a class="menuitem submenuheader <?php echo $v; ?>" href=" <?php echo $linkValue; ?>" target="_blank" id="<?php echo $k;?>" title="<?php echo $menu[$i]["role"]; ?>">
   <?php }else{ ?>
   	 <a class="menuitem submenuheader <?php echo $v; ?>" href=" <?php echo $linkValue; ?>" id="<?php echo $k;?>" title="<?php echo $menu[$i]["role"]; ?> ">
   <?php } 
        	 if($menu[$i]["roleid"] == $parid){ ?>
                <div id="imgpos<?php echo $k; ?>">
                    <img src="<?php echo $imgcollapse; ?>" width="11" height="11" align="left" style="padding:2px 5px 0 0" />
                </div>
        <?php }else{ ?>
                <div id="imgpos<?php echo $k; ?>">
                    <img src="<?php echo $imgexpand; ?>" width="11" height="11" align="left" style="padding:2px 5px 0 0" />
                </div>
        <?php }
		//print_r($this->session->userdata);
                echo $menu[$i]["role"];?>
        </a>
        <?php if($menu[$i]['submenu']){
        //echo count($menu[$i]['submenu']);
              for($j=-1;$j<count($menu[$i]['submenu']);$j++){
			  	if($menu[$i]['submenu'][$j]['subrole']=="Shan Game History") {// THIS IS TO CHECK SHAN GAME HISTORY
					if($this->session->userdata["partnerid"]=="10002" || $this->session->userdata["partnerid"]=="10679" || $this->session->userdata["partnerid"]=="10006" || $this->session->userdata["partnerid"]=="10706") {
                  $subrole=$menu[$i]['submenu'][$j]['subrole'];
                  $sublink=$menu[$i]['submenu'][$j]['link']; ?>
                  <ul id="<?php echo $j; ?>" style="<?php echo $di; ?>">
                  </li>                 
         <?php   $ridArray = explode("rid=",$sublink);
       //  echo $ridArray[1];
                 $ridAray = explode("&",$ridArray[1]);
                 $rid = $ridAray[0];
                 if($subrole){   
                     //echo "<pre>"; print_r($this->session->userdata);die;
                  $transpassword = $this->session->userdata['partnertransaction_password'];
                  if($transpassword !='' && ($subrole == "Transfer points")){
                       
						if($rid==$uid && $rid != "") {
						
						 ?>
                           <div class="SubMenuCnt style5"><h1><li><a href="#" onClick="openbox1('<?php echo $subrole;?>',1,'')"><?php echo $subrole;?> </a></li></h1></div>
                  <?php }else{
				    
				  ?>
             
             
              <div class="SubMenuCnt"><li><a href="#" onClick="openbox1('<?php echo $subrole;?>',1,'<?php echo base_url() ?>')"><?php echo $subrole;?> </a></li></div>
                  <?php }
                    if($this->session->userdata['partnertransaction_password']!=''){    
                    }   
                  }else{  
                        if($rid==$uid && $rid != "") { ?>
                  <div class="SubMenuCnt style5"><h1><li><a href="<?php echo base_url().$sublink; ?>"><?php echo $subrole;?></a></li></h1></div> 
                  <?php }else{  ?>
                   <div class="SubMenuCnt"><li><a href="<?php echo base_url().$sublink; ?>"><?php echo $subrole;?> </a></li></div>      
                  <?php }
                  }
                 } ?>
                  </ul>					
					<?php } 
				} else {
              // echo '=>'.$di;
                  $subrole=$menu[$i]['submenu'][$j]['subrole'];
                  $sublink=$menu[$i]['submenu'][$j]['link']; ?>
                  <ul id="<?php echo $j; ?>" style="<?php echo $di; ?>">
                  </li>                 
         <?php   $ridArray = explode("rid=",$sublink);
       //  echo $ridArray[1];
                 $ridAray = explode("&",$ridArray[1]);
                 $rid = $ridAray[0];
                 if($subrole){   
                     //echo "<pre>"; print_r($this->session->userdata);die;
                  $transpassword = $this->session->userdata['partnertransaction_password'];
                  if($transpassword !='' && ($subrole == "Transfer points")){
                       
						if($rid==$uid && $rid != "") {
						
						 ?>
                           <div class="SubMenuCnt style5"><h1><li><a href="#" onClick="openbox1('<?php echo $subrole;?>',1,'')"><?php echo $subrole;?> </a></li></h1></div>
                  <?php }else{
				    
				  ?>
             
             
              <div class="SubMenuCnt"><li><a href="#" onClick="openbox1('<?php echo $subrole;?>',1,'<?php echo base_url() ?>')"><?php echo $subrole;?> </a></li></div>
                  <?php }
                    if($this->session->userdata['partnertransaction_password']!=''){    
                    }   
                  }else{  
                        if($rid==$uid && $rid != "") { ?>
                  <div class="SubMenuCnt style5"><h1><li><a href="<?php echo base_url().$sublink; ?>"><?php echo $subrole;?></a></li></h1></div> 
                  <?php }else{  ?>
                   <div class="SubMenuCnt"><li><a href="<?php echo base_url().$sublink; ?>"><?php echo $subrole;?> </a></li></div>      
                  <?php }
                  }
                 } ?>
                  </ul>
              <?php }
			  	} // THIS IS TO CHECK SHAN GAME HISTORY
              } ?>
    </ul>
    </div>
<?php   $k++;
        }
      } ?> 
       <div id="shadowing1"></div>
        <div id="box1">
            <?php $string = str_replace(' ', '', $subrole);?>
            
            <form id="frmLightbox" method="post" action="" target="_parent">
            <div class="SeachResultWrap">
            <div class="Agent_create_wrap">
            <div class="Agent_hdrt" id="boxtitle1"></div>
            <div class="Agent_txtField">Transaction Password:<br />
                <input name="partnertransaction_password" type="password" class="TextField" id="transpassword" size="65" maxlength="60"  />
            </div>
            <div class="Agent_txtField">
                <input type="submit" class="button" value="Submit" />
                <input type="button" class="button" value="Cancel" onClick="closebox1()" />
            </div>
            </div>
            </div>
            </form>
        </div>

</div>
<?php } ?>
