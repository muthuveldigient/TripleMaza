<?php

			$partnerTypeID = $this->session->userdata['partnertypeid'];
			if($partnerTypeID ==0){
				$category= $this->partner_model->getCategoryMiniGames();
			}else{
				$category= $this->partner_model->getCategoryBasedMiniGames($this->session->userdata('partnerid'));
			}
			
			$sno=1;
			$data = array();
			if(!empty($category)){
				foreach($category as $rs ) {
					$data[$rs["CATEGORY_NAME"]][] = array("MINIGAMES_NAME"=>$rs["MINIGAMES_NAME"],"DESCRIPTION"=>$rs["DESCRIPTION"]
													);
				}
				if(!empty( $data )){
					$selectBox1.='<div class="UDCommonWrap">';
					foreach($data as $key=> $val){
						$categoryName = str_replace(' ', '', $key);
							if($sno==4) {
						$selectBox1.= '</div><div class="UDCommonWrap">';
								$sno=1;
							}

						$selectBox1.='<div class="UDRightWrap" style="width:150px;">
							<div class="UDFieldtitle" style="width:150px;">'.$key.'</div>
							<div class="UDFieldTxtFld" style="width:150px;">
								<div style="height:100px;width:150px;border: 1px solid;background-color: #fff;overflow: auto;line-height: 18px;">
								<div style="padding:1% 2%">
								<label><input type="checkbox" name="allgames_'.$categoryName.'" id="allgames_'.$categoryName.'" style="float:left;margin: 1.5% 3% 1%;" />Select All</label>
								</div>';
								foreach($val as $category){
							$selectBox1.='<div style="padding:1% 2%">
								<label><input type="checkbox" name="category[]" id="'.$categoryName.'_games_'.$category["MINIGAMES_NAME"].'" value="'.$category["MINIGAMES_NAME"].'" style="float:left;margin: 1.5% 3% 1%;" />'.$category["DESCRIPTION"].'</label>
								</div>';
								}
					  $selectBox1.='</div>	  
							</div>
						</div>
						<div class="UDRightWrap" style="width:50px;padding-top:60px;">
							<div class="UDFieldtitle"></div>
							<div class="UDFieldTxtFld" style="width:50px;text-align:center;"></div>
						</div>	';	
							$sno++;
						}
					$selectBox1.='</div>';
				} 
			}
			echo $selectBox1;


?>