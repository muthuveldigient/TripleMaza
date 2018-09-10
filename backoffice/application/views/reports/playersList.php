<style>
*{
	margin:0;
	padding:0;
	font-family:Arial, Helvetica, sans-serif;
	}
	li{
		list-style:none;
		float:left;
		}
.container_searchgame{
	padding:1px;
	border:1px solid #dff4ff;
	overflow:hidden;
	margin:10px 20px;
	min-width:560px;
	float:left;
	}
.container_searchgame ul {
	overflow:hidden;
	min-width:560px;
	}
.container_searchgame ul li {
	border-right:1px solid #71d0ff;
	overflow:hidden;
	min-width:139px;
	}
.cnt_userdetails li{
	min-height:20px;
	background-color:#d2f0ff;
	}
.container_searchgame ul li h3{
	margin:0;
	line-height:38px;
	font-size:13px;
	color:#fff;
	font-family:Arial, Helvetica, sans-serif;
	padding:0 30px;
	height:	39px;
	background-image:url(<?php echo base_url();?>/static/images/tophead_bg.png);
	background-repeat:repeat-x;
	text-align:center;
	}
.searchgame_cardcnt{
	overflow:hidden;
	background-color:#d2f0ff;
	padding:9px;
	min-height:20px;
	text-align:center;
	min-width:101px;
	}
.searchgame_cardcnt p{
	font-size:13px;
	color:#333333;
	float:left;
	margin-left:5px;
	text-align:center;
	}
</style>        

<div class="container_searchgame">
    	<ul>
        	<li><h3 class="header_searchgame">Player ID</h3></li>
            <li><h3 class="header_searchgame">Bet</h3></li>
            <li><h3 class="header_searchgame">Win</h3></li>
            <li><h3 class="header_searchgame">Rake</h3></li>
        </ul>
        <?php
		
		if(isset($results)){ 
				if(count($results)>0 && is_array($results)){
						for($i=0;$i<count($results);$i++){
							
	   ?>									
                                    <ul class="cnt_userdetails">
                                        <li>
                                            <div class="searchgame_cardcnt">
                                                <p class="usrname"><?php echo $results[$i]->USERNAME; ?></p>
                                            </div>
                                        </li>
                                        <li><div class="searchgame_cardcnt">
                                                <p class="usrname"><?php echo $results[$i]->STAKE; ?></p>
                                            </div></li>
                                        <li><div class="searchgame_cardcnt">
                                                <p class="usrname"><?php echo $results[$i]->WIN; ?></p>
                                            </div> </li>
                                        <li><div class="searchgame_cardcnt">
                                                <p class="usrname"><?php echo $results[$i]->RAKE; ?></p>
                                            </div>  </li>
                                     </ul>
        <?php					  
						}
				}
		} ?>				                
</div>        
    



