<?php
//error_reporting(E_ALL);
/*
  Class Name	: Agentreport_model
  Package Name  : Report
  Purpose       : Handle all the database services related to Turnover report
  Author 	    : Sivakumar
  Date of create: July 08 2014
*/
class agentreport_Model extends CI_Model
{

	public function getAllSearchGameInfo($loggedInUsersPartnersId,$searchdata,$limit,$start){
		//get userid based on username
		//echo "<pre>";print_r($searchdata);die;

		$partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}


		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}
		   if($searchdata['partner']!="select")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where $sql and USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");
	      }else{
		    $query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");
		  }
		}else{
		  $query = $this->db3->query("SELECT GAME_TRANSACTION_ID,MASTER_TRANSACTTION_ID,USER_ID,INTERNAL_REFERENCE_NO,TRANSACTION_DATE, sum(BET_POINTS) as totalbets,sum(WIN_POINTS) as totalwins,sum(REFUND_POINTS) as totalrefunds from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC LIMIT $start,$limit");

		}

		//echo $this->db2->last_query();die;

		$fetchResults  = $query->result();


		return $fetchResults;



	}

	public function getAllSearchGamePointsCount($loggedInUsersPartnersId,$searchdata,$point_field){
		//get userid based on username
			 $partnerids  = $this->Agent_model->getAllChildIds();
		$allUserids  = $this->Agent_model->getAllUsersByPartners($partnerids);
		if($allUserids != ''){
		   //$allUserNames  = $this->Agent_model->getAllUsersNamesByPartners($partnerids);
		   $userids = $allUserids;
		}else{
		   $userids  = "007";
		}


		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}

		   if($searchdata['partner']!="select")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
					$conQuery .= " PARTNER_ID = '".$searchdata['partner']."' ";
				}else{
					$conQuery .= " AND PARTNER_ID = '".$searchdata['partner']."' ";
				}
			}

			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == '' && $searchdata['partner'] == "select"){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;



		if($sql != ''){
			$query = $this->db3->query("SELECT sum(".$point_field.") as totalbets from view_transaction_history where $sql and USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history where USER_ID IN ($userids) group by USER_ID ORDER BY TRANSACTION_DATE DESC ");
		}
		$fetchResults  = $query->result();
		foreach($fetchResults as $points){
			$sum_amount += $points->totalbets;
		}
		return $sum_amount;
	}

	public function getAllUserGameCount($user_id,$sdate,$edate){
         if($sdate != "" || $edate != ""){
             $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
             $edate1 = date("Y-m-d H:i:s",strtotime($edate));
             	$querycnt=$this->db3->query("select count(*) as cnt from view_transaction_history where USER_ID = $user_id  AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1' ");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
        }else{
		$querycnt=$this->db3->query("select count(*) as cnt from view_transaction_history where USER_ID = $user_id ");
		$rowcnt=$querycnt->row();
		return $rowcnt->cnt;
	}
        }

	public function getAllUserGamePlaySum($user_id,$sdate,$edate,$field_id){
            if($sdate != "" || $edate !=""){
               $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
               $edate1 = date("Y-m-d H:i:s",strtotime($edate));
                $querycnt=$this->db3->query("select sum($field_id) as tot_play from view_transaction_history where USER_ID = $user_id AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1'");
		$rowcnt=$querycnt->row();
		return $rowcnt->tot_play;
            }else{
		$querycnt=$this->db3->query("select sum($field_id) as tot_play from view_transaction_history where USER_ID = $user_id ");
		$rowcnt=$querycnt->row();
		return $rowcnt->tot_play;
	}
        }


	public function getAllUserGameInfo($user_id,$sdate,$edate){
            if($sdate != "" || $edate !=""){
               $sdate1 = date("Y-m-d H:i:s",strtotime($sdate));
               $edate1 = date("Y-m-d H:i:s",strtotime($edate));
	   	$query  = $this->db3->query("select * from view_transaction_history where USER_ID = $user_id AND TRANSACTION_DATE >= '$sdate1' AND TRANSACTION_DATE <= '$edate1' order by TRANSACTION_DATE DESC");
		$result = $query->result();
		return $result;
            }else{
	   	$query  = $this->db3->query("select * from view_transaction_history where USER_ID = $user_id order by TRANSACTION_DATE DESC");
		$result = $query->result();
		return $result;
	}
        }

	public function getAllSearchUserGameCount($loggedInUsersPartnersId,$searchdata){
		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}
			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));
			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }



		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history where $sql ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT count(*) as cnt from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");

		}
		$rowcnt=$query->row();
		return $rowcnt->cnt;
	}

	public function getAllSearchUserGameInfo($loggedInUsersPartnersId,$searchdata){

		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }
		 $sql = 	$conQuery;

		if($sql != ''){
			$query = $this->db3->query("SELECT * from view_transaction_history where $sql ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT * from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT * from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		}
		$fetchResults  = $query->result();
		return $fetchResults;
	}

	public function getAllSearchUserGamePointsCount($loggedInUsersPartnersId,$searchdata,$point_field){
		//get userid based on username
		if(!empty($searchdata['user_id']) || !empty($searchdata['ref_id']) || !empty($searchdata['hand_id']) || !empty($searchdata['START_DATE_TIME']) || !empty($searchdata['END_DATE_TIME'])  )
	   {
			$conQuery = "";
			if($searchdata['user_id']!="")
			{
				$conQuery .= "USER_ID =  '".$searchdata['user_id']."'";
			}

			if($searchdata['ref_id']!="")
			{
				if($searchdata['user_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['ref_id']."%' ";
				}
			}

		   if($searchdata['hand_id']!="")
			{
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == ''){
					$conQuery .= " INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}else{
					$conQuery .= " AND INTERNAL_REFERENCE_NO like '%".$searchdata['hand_id']."%' ";
				}
			}


			$startdateformate = date("Y-m-d H:i:s",strtotime($searchdata['START_DATE_TIME']));
			$enddateformate   = date("Y-m-d H:i:s",strtotime($searchdata['END_DATE_TIME']));


			if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] =="")
			 {

				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME'] =="" and $searchdata['END_DATE_TIME'] !=""){
			   if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  < '".$enddateformate."' ";
				}else{
					$conQuery .= " AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }else if($searchdata['START_DATE_TIME']!="" and $searchdata['END_DATE_TIME'] !=""){
				if($searchdata['user_id'] == '' && $searchdata['ref_id'] == '' && $searchdata['hand_id'] == ''){
				   $conQuery .= " TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}else{
				   $conQuery .= " AND TRANSACTION_DATE  > '".$startdateformate."' AND TRANSACTION_DATE  < '".$enddateformate."'";
				}
			 }
		 $sql = 	$conQuery;
		if($sql != ''){
			$query = $this->db3->query("SELECT sum(".$point_field.") as totalbets from view_transaction_history where $sql  ORDER BY TRANSACTION_DATE DESC");
	      }else{
		    $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history  ORDER BY TRANSACTION_DATE DESC");
		  }
		}else{
		  $query = $this->db3->query("SELECT  sum(".$point_field.") as totalbets from view_transaction_history  ORDER BY TRANSACTION_DATE DESC ");
		}
		$rowcnt=$query->row();
		return $rowcnt->totalbets;
	}

        public function getParticularHandidGameInfo($hand_id){

            //Get Game Info using Handid
                $rest = substr("$hand_id",0,3);

                if($rest == AAA){
                    $query = $this->db2->query("select * from oddneven_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;

                    }elseif($rest == AAB){
                    $query = $this->db2->query("select * from luckynumber_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;

                }elseif($rest == AAC){
                    $query = $this->db2->query("select * from luck_play where INTERNAL_REFERENCE_NO = '$hand_id' ");
                    $gameInfo  =  $query->result();
                    return $gameInfo;
                }
        }



	public function getSelfTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db3->select('*')->from('partner_turnover_report_daily');
		$this->db3->where("PARTNER_ID",$partner_id);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return count($results);
	}

	public function getSelfTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
        $this->db3->select('sum(TOTAL_BETS) as tot, sum(TOTAL_WINS) as totwin,PARTNER_ID,MARGIN,NET')->from('partner_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
        $this->db3->order_by('tot','desc');
        $browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		return $results;
	}


	public function getPartnersTurnoverCount($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');

		if($partner_type==11){
			#Get distributors list
			$partnerids=$this->getPartnersList(11,$partner_id);
			
			if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
			else
			$partnerids=$partnerids;


			$this->db3->select('*')->from('ysuperdistributor_game_turn_over_history');
			if($partner_id)
			$this->db3->where("MAIN_AGEN_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

		}

		$this->db3->group_by("SUPERDISTRIBUTOR_ID");
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
// 		echo $this->db2->last_query();exit;
		$countval = count($results);
		return $countval;
	}

	public function getPartnersTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		if($partner_type==0 || $partner_type==''){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ymainagent_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] != 'all' ) {
				//$this->db3->where("GAMES_NAME",$data["GAMES_TYPE"]); 
			}
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("SUPERDISTRIBUTOR_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("MAIN_AGEN_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysuperdistributor_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("MAIN_AGEN_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("SUPERDISTRIBUTOR_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("SUPERDISTRIBUTOR_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			$results['self_results']  = $browseSQL->result();
		}
		
		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
		
			//if($partnerids)
			//	$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
		
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				
				if($data["GAMES_TYPE"] == 'pc' ) {
					$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
				}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
					$this->db3->where_in("GAME_ID",MOBILE_GAMES);
				}
				
				if($data["AGENT_LIST"] != 'all' ) {
					$this->db3->where("DISTRIBUTOR_ID",$data["AGENT_LIST"]);
				} 
				
				$this->db3->group_by("DISTRIBUTOR_ID");
				
				$browseSQL = $this->db3->get();
				//echo $this->db3->last_query();exit;
				$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				//$this->db3->where("DISTRIBUTOR_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			//echo "<br>";
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("SUBDISTRIBUTOR_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			//echo "<br>";
			$subresults  = $subbrowseSQL->result();


			$results['subdist_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				//$this->db3->where("PARTNER_ID",$data["AGENT_LIST"]);
			} 
			
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
 			//echo $this->db3->last_query();
			//echo "<br>";
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				//$this->db3->where("SUBDISTRIBUTOR_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
 			//echo $this->db3->last_query();
			$subresults  = $subbrowseSQL->result();


			$results['self_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("PARTNER_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
 			//echo $this->db3->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("PARTNER_ID",$partner_id);


			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("PARTNER_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("PARTNER_ID");
			
			$agntbrowseSQL = $this->db3->get();
			//echo $this->db3->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['self_results'] = $agntresults;

			#Users list
			$this->db3->select('USER_ID,USER_NAME,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history')->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			$this->db3->where("PARTNER_ID",$partner_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if($data["GAMES_TYPE"] == 'pc' ) {
				$this->db3->where_not_in("GAME_ID",MOBILE_GAMES);
			}else if($_REQUEST['GAMES_TYPE'] == 'mobile'){
				$this->db3->where_in("GAME_ID",MOBILE_GAMES);
			}
			if($data["AGENT_LIST"] != 'all' ) {
				$this->db3->where("PARTNER_ID",$data["AGENT_LIST"]);
			} 
			$this->db3->group_by("USER_ID");

			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			//echo $this->db3->last_query();
			$results['user_results'] = $userresults;
		}

		//echo $this->db2->last_query();
		$countval = $results;
		return $countval;
	}

	public function getPartnersShanTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');


		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;

		if($partner_type==0 || $partner_type==''){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ymainagent_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("MAIN_AGEN_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("MAIN_AGEN_ID",$partner_id);
		
			if($partnerids)
				$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
		
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("SUPERDISTRIBUTOR_ID");
				$browseSQL = $this->db3->get();
				//echo $this->db3->last_query();exit;
				$results['self_results']  = $browseSQL->result();
		}
		
		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
		
			//if($partnerids)
			//	$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
		
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("DISTRIBUTOR_ID");
				$browseSQL = $this->db3->get();
// 				echo '<pre>';print_r($this->db3->last_query());exit;
				$results['self_results']  = $browseSQL->result();
		}
		
		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();


			$results['subdist_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();


			$results['self_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);



			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("PARTNER_ID",$partner_id);


			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['self_results'] = $agntresults;

			#Users list
			$this->db3->select('USER_ID,USER_NAME,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history')->where('GAME_ID', SHAN_GAME_IDS);
			$this->db3->where("PARTNER_ID",$partner_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");

			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			//echo $this->db2->last_query();
			$results['user_results'] = $userresults;
		}

		//echo $this->db2->last_query();
		$countval = $results;
		return $countval;
	}


	public function getPartnersGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		/*
		$partnerids=$this->getPartnersList($partner_type,$partner_id);

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;
		*/
		if($partner_type==0){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ymainagent_game_turn_over_history');
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID,MAIN_AGEN_ID");
			$browseSQL = $this->db3->get();
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("MAIN_AGEN_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==15){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("GAME_ID");
				$browseSQL = $this->db3->get();
				$results['self_results']  = $browseSQL->result();
		}
		
		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			$results['subdist_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$agntbrowseSQL = $this->db3->get();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			$results['self_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$agntbrowseSQL = $this->db3->get();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;

			#Users list
			$this->db3->select('USER_ID,USER_NAME,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			//echo $this->db2->last_query();
			$results['user_results'] = $userresults;

		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company,MARGIN_PERCENTAGE,sum(TOTAL_GAME_PLAYED) as total_games,(sum(WIN_POINTS)/sum(PLAY_POINTS))*100 AS PAYOUT,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$agntbrowseSQL = $this->db3->get();
			$agntresults  = $agntbrowseSQL->result();
			$results['self_results'] = $agntresults;

			#Users list
			$this->db3->select('USER_ID,USER_NAME,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$partner_id);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			$results['user_results'] = $userresults;
		}

		//echo $this->db2->last_query();
		$countval = $results;
		return $countval;
	}


	public function getPartnersTurnoverGameWise($data){
		//$partner_id = $this->session->userdata('partnerid');
		$partner_id = $data['partner_id'];
		$partner_type = $this->session->userdata('partnertypeid');

		$partnerids=$this->getPartnersList($partner_type,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		$partid=$data['partner_id'];

		if($partner_type==0){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ymainagent_game_turn_over_history');
			$this->db3->where("MAIN_AGEN_ID",$partid);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
			
			if($partnerids)
				$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
			
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("GAME_ID");
				$browseSQL = $this->db3->get();
				// 			echo $this->db3->last_query(); die;
				$results['self_results']  = $browseSQL->result();
		}
		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();

			$results['self_results']  = $browseSQL->result();

		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['subdist_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['self_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$partid);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");

			$agntbrowseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['self_results'] = $agntresults;
		}

		//echo $this->db2->last_query();
		$countval = $results;
		return $countval;
	}

	public function getPartnersTurnoverShanGameWise($data){
		//$partner_id = $this->session->userdata('partnerid');
		$partner_id = $data['partner_id'];
		$partner_type = $this->session->userdata('partnertypeid');

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		$partid=$data['partner_id'];

		if($partner_type==0){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ymainagent_game_turn_over_history');
			$this->db3->where("MAIN_AGEN_ID",$partid);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();

			//echo $this->db2->last_query();
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);
			
			if($partnerids)
				$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
			
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("GAME_ID");
				$browseSQL = $this->db3->get();
				// 			echo $this->db3->last_query(); die;
				$results['self_results']  = $browseSQL->result();
				
		}
		
		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);
		
			//if($partnerids)
				//$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
		
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("GAME_ID");
				$browseSQL = $this->db3->get();
				//echo $this->db2->last_query(); die;
				$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);


			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['subdist_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['self_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$partid);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");

			$agntbrowseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['self_results'] = $agntresults;
		}

		//echo $this->db2->last_query();
		$countval = $results;
		return $countval;
	}

	public function getMgntTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("MAIN_AGEN_ID");
	
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval['magnt_result'] = $results;
	
		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("SUPERDISTRIBUTOR_ID");
	
		$browseSQL = $this->db3->get();
// 		echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;
// 	echo '<pre>';print_r($countval);exit;
		return $countval;
	}
	
	public function getSupDistTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['supdistid'];

		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$magnt_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("SUPERDISTRIBUTOR_ID");
		$browseSQL = $this->db3->get();
// 		echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;

		$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$magnt_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("DISTRIBUTOR_ID");

		$browseSQL = $this->db3->get();
// 		echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;

		return $countval;
	}
	
	public function getShanSupDistTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['supdistid'];
	
		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,GAME_ID,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT, PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$magnt_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("SUPERDISTRIBUTOR_ID");
		$browseSQL = $this->db3->get();
// 		echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;
	
		$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,GAME_ID,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT, PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$magnt_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("DISTRIBUTOR_ID");
	
		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;
	
		return $countval;
	}
	

	public function getMgntShanTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("MAIN_AGEN_ID");

		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
// 		echo $this->db3->last_query();exit;
		$countval['magnt_result'] = $results;

		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);
		
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("SUPERDISTRIBUTOR_ID");
		
		$browseSQL = $this->db3->get();
// 		 		echo $this->db3->last_query();exit;
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;
		return $countval;
	}


	public function getDistributorTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		if($partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;

			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['subdist_result'] = $subresults;

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['distagnt_result'] = $distagntresults;
		}

		if($partner_type==15 || $partner_type==11 || $partner_type==12){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			//if($partnerids)
			//	$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();exit;
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}

		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			//if($partnerids)
			//	$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['subdist_result'] = $subresults;
		}

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

		//	if($partnerids)
		//		$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
// 			echo $this->db3->last_query();exit;
			$countval['distagnt_result'] = $distagntresults;
		}
		return $countval;
	}

	public function getDistributorShanTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id = $data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		if($partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
		//	echo $this->db2->last_query();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;

			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['subdist_result'] = $subresults;

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['distagnt_result'] = $distagntresults;
		}

		if($partner_type==15 || $partner_type==11 || $partner_type==12){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		//	if($partnerids)
			//	$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db2->last_query();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}

		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		//	if($partnerids)
		//		$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			$countval['subdist_result'] = $subresults;
		}

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		//	if($partnerids)
		//		$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
// 			echo $this->db3->last_query();exit;
			$countval['distagnt_result'] = $distagntresults;
		}
// 		echo '<pre>';print_r($countval);exit;
		return $countval;
	}

	public function getMagntTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		$countval['magnt_result'] = $results;

		return $countval;
	}

	public function getMagntTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		$countval['magnt_result'] = $results;

		return $countval;
	}

	public function getMagntDistTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
		$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;
		return $countval;
	}
	
	
	public function getMagntSupDistTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$supdistributor_id=$data['distid'];
	
		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$supdistributor_id);
		$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");
	
		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;
		return $countval;
	}
	
	public function getMagntSupDistTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$supdistributor_id=$data['distid'];
	
		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,GAME_ID,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT, PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$supdistributor_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);
	
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");
	
		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		$countval['supdist_result'] = $results;
		return $countval;
	}

	public function getMagntDistTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
		$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
		$this->db3->where('GAME_ID', SHAN_GAME_IDS);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;
		return $countval;
	}

	public function getDistributorTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;
		$results='';
		
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
		}
		$countval['dist_result'] = $results;


		#Get sub distributor list
		$subresults='';
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
		}
		$countval['subdist_result'] = $subresults;

		#Get agents list
		$distagntresults='';
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db3->last_query();exit;
		}
		$countval['distagnt_result'] = $distagntresults;
		return $countval;
	}

	public function getDistributorTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;
		$results='';
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
		}
		$countval['dist_result'] = $results;

		#Get sub distributor list
		$subresults='';
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}
 */
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
		//	echo $this->db2->last_query();
		}
		$countval['subdist_result'] = $subresults;

		#Get agents list
		$distagntresults='';
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		
		}
		$countval['distagnt_result'] = $distagntresults;
		return $countval;
	}

	public function getDistributorAllGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id = $data['distid'];

		$gamename = $data['gameid'];
		$gameId = str_replace("%20"," ",$gamename);
		if($gamename!='ALL'){
			$gameid = $this->getGameNameByDescription($gameId);
		}else{
			$gameid = $gameId;
		}

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ydistributor_game_turn_over_history');
			$this->db3->where_in("GAME_ID",$gameid);
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);

			/* if($partnerids!='' && $partner_type!=0){
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();exit;
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}



		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ysubdistributor_game_turn_over_history');
			if($partner_type==15 || $partner_type==11){
				$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			}
			if($partner_type==12){
				$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			}
			$this->db3->where("GAME_ID",$gameid);

			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db3->last_query();exit;
			$countval['subdist_result'] = $subresults;
		}



		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('yagent_game_turn_over_history');
			if($partner_type==15 || $partner_type==11){
				$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			}
			if($partner_type==12){
				$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			}
			$this->db3->where_in("GAME_ID",$gameid);

			/* if($partnerids!='' && $partner_type!=0){
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db3->last_query();exit;
			$countval['distagnt_result'] = $distagntresults;
		}



		return $countval;
	}
	
	public function getSupDistributorAllGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id = $data['distid'];
	
		$gamename = $data['gameid'];
		$gameId = str_replace("%20"," ",$gamename);
		if($gamename!='ALL'){
			$gameid = $this->getGameNameByDescription($gameId);
		}else{
			$gameid = $gameId;
		}
	
		$partnerids=$this->getPartnersList(11,$partner_id);
	
			if(strstr($partnerids,","))
				$partnerids=explode(",",$partnerids);
			else
				$partnerids=$partnerids;
	
				
			if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
				$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ysuperdistributor_game_turn_over_history');
				$this->db3->where_in("GAME_ID",$gameid);
				$this->db3->where("SUPERDISTRIBUTOR_ID",$distributor_id);
			
				if($partnerids!='' && $partner_type!=0){
					$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
				} 
			
				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("SUPERDISTRIBUTOR_ID");
			
				$browseSQL = $this->db3->get();
 				//echo $this->db3->last_query();exit;
				$results  = $browseSQL->result();
				$countval['supdist_result'] = $results;
			}
			
			if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
				$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ydistributor_game_turn_over_history');
				$this->db3->where_in("GAME_ID",$gameid);
		//		$this->db3->where("DISTRIBUTOR_ID",$distributor_id);

				if($partnerids!='' && $partner_type!=0){
					$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
				} 

				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("DISTRIBUTOR_ID");

				$browseSQL = $this->db3->get();
				//echo $this->db3->last_query();exit;
				$results  = $browseSQL->result();
				$countval['dist_result'] = $results;
			}



			#Get sub distributor list
			if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
				$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ysubdistributor_game_turn_over_history');
				/* if($partner_type==15 || $partner_type==11){
					$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
				} */
				if($partner_type==12){
					$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
				}
				$this->db3->where("GAME_ID",$gameid);

				if($partnerids!='' && $partner_type!=0){
					$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
				}

				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("SUBDISTRIBUTOR_ID");

				$subbrowseSQL = $this->db3->get();
				$subresults  = $subbrowseSQL->result();
// 				echo $this->db3->last_query();exit;
				$countval['subdist_result'] = $subresults;
			}



			#Get agents list

			if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
				$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('yagent_game_turn_over_history');
				/* if($partner_type==15 || $partner_type==11){
					$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
				} */
				if($partner_type==12){
					$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
				}
				$this->db3->where_in("GAME_ID",$gameid);

				if($partnerids!='' && $partner_type!=0){
					$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
				}

				if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
					$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
				}
				$this->db3->group_by("PARTNER_ID");
				$distagntbrowseSQL = $this->db3->get();
				$distagntresults  = $distagntbrowseSQL->result();
				$countval['distagnt_result'] = $distagntresults;
			}

			return $countval;
	}

	public function getSuperDistributorGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$gamename = $data['gameid'];
		$game_id = str_replace("%20"," ",$gamename);
		
		if($gamename!='ALL'){
			$gameid = $this->getGameNameByDescription($game_id);
		}else{
			$gameid = $game_id;
		}
		$magntid = $data['magntid'];
		$partnerids=$this->getPartnersList(11,$partner_id);
	
		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
			else
				$partnerids=$partnerids;
	
				if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
					$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ysuperdistributor_game_turn_over_history');
					$this->db3->where("GAME_ID",$gameid);
					if($magntid){
						$this->db3->where("MAIN_AGEN_ID",$magntid);
					}
					if($partnerids!='' && $partner_type!=0){
						$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
					}
	
					if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
						$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
					}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
						$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
					}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
						$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
						$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
					}
					$this->db3->group_by("SUPERDISTRIBUTOR_ID");
	
					$browseSQL = $this->db3->get();
// 					echo $this->db3->last_query(); die;
					$results  = $browseSQL->result();
					$countval['dist_result'] = $results;
				}
				return $countval;
	}

	public function getDistributorGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$gamename = $data['gameid'];
		$game_id = str_replace("%20"," ",$gamename);
		if($gamename!='ALL'){
			$gameid = $this->getGameNameByDescription($game_id);
		}else{
			$gameid = $game_id;
		}
		$magntid = $data['magntid'];
		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ydistributor_game_turn_over_history');
			$this->db3->where("GAME_ID",$gameid);
			if($magntid){
				$this->db3->where("SUPERDISTRIBUTOR_ID",$magntid);
			}
			/* if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			} */

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query(); die;
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}
		return $countval;
	}

	public function getSubDistributorTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get sub distributor list
		if($partner_type==15 ||  $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['subdist_result'] = $subresults;

		#Get agents list
		if($partner_type==15 ||  $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}
		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['distagnt_result'] = $distagntresults;
		return $countval;
	}

	public function getSubDistributorShanTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['subdist_result'] = $subresults;

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}
		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['distagnt_result'] = $distagntresults;
		return $countval;
	}

	public function getSubDistributorGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id = $partner_id;
		$game_name = $data['gameid'];

		$gameId = str_replace("%20"," ",$game_name);
		if($game_name!='ALL'){
			$game_id = $this->getGameNameByDescription($gameId);
		}else{
			$game_id = $gameId;
		}

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;

		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('ysubdistributor_game_turn_over_history');

			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where("GAME_ID",$game_id);

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		//echo $this->db2->last_query(); die;
		$countval['subdist_result'] = $subresults;

		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where("GAME_ID",$game_id);

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID","GAME_NAME");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['distagnt_result'] = $distagntresults;

		return $countval;
	}

	public function getSubDistributorAllGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$subdistributor_id = $data['subdistid'];
		$game_name = $data['gameid'];
		$gameId = str_replace("%20"," ",$game_name);
		$partnerids = $this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids	= explode(",",$partnerids);
		else
			$partnerids = $partnerids;

		#Get sub distributor list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_NAME')->from('ysubdistributor_game_turn_over_history');

			$this->db3->where("SUBDISTRIBUTOR_ID",$subdistributor_id);
			$this->db3->where("GAME_NAME",$gameId);
			if($partnerids!='' && $partner_type!=0){
				if($partner_type==15 || $partner_type==11){
					$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);
				}
				if($partner_type==12){
					$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
				}
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		//echo $this->db2->last_query(); die;
		$countval['subdist_result'] = $subresults;

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_NAME')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$subdistributor_id);
			$this->db3->where("GAME_NAME",$gameId);

			if($partnerids!='' && $partner_type!=0){
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['subdistagnt_result'] = $distagntresults;

		return $countval;
	}

	public function getSubDistributorTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get sub distributor list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		$countval['subdist_result'] = $subresults;

		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['distagnt_result'] = $distagntresults;

		return $countval;
	}

	public function getSubDistributorTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get sub distributor list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		$countval['subdist_result'] = $subresults;

		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids)
			$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['distagnt_result'] = $distagntresults;

		return $countval;
	}

	public function getAgentTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id = $data['agntid'];

		$partnerids=$this->getPartnersList($partner_type,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

			if($partnerids != ''){
				if(is_array($partnerids))
					$astr = implode(",",$partnerids);
				else
					$astr = $partnerids;

					if($agent_id != '')
						$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		return $results;
	}

	public function getAgentTurnoverShanGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id = $data['agntid'];

		$partnerids=$this->getPartnersList($partner_type,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

			if($partnerids != ''){
				if(is_array($partnerids))
					$astr = implode(",",$partnerids);
				else
					$astr = $partnerids;

					if($agent_id != '')
						$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$browseSQL = $this->db3->get();
		//echo $this->db2->last_query();
		$results  = $browseSQL->result();
		return $results;
	}

	public function getAgentTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id=$data['agntid'];

		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}elseif($partner_type==0){
			$partnerids='';
		}

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

           	if($partnerids != ''){
				$astr = implode(",",$partnerids);
				if($agent_id != '')
					$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);

			//$partnerids = array_push($partnerids,$agent_id);
			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$agntbrowseSQL = $this->db3->get();
		$agntresults  = $agntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['agnt_result'] = $agntresults;

		#Get users list
		if($partner_type==15 ||$partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('USER_ID,USER_NAME,GAME_ID,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_not_in('GAME_ID',unserialize(CASINO_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
		}

		$userbrowseSQL = $this->db3->get();
		$userresults  = $userbrowseSQL->result();
		$countval['user_result'] = $userresults;
		return $countval;
	}

	public function getShanAgentTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id=$data['agntid'];
		
		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}elseif($partner_type==0){
			$partnerids='';
		}

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get agents list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

           	if($partnerids != ''){
				$astr = implode(",",$partnerids);
				if($agent_id != '')
					$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);

			//$partnerids = array_push($partnerids,$agent_id);
			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$agntbrowseSQL = $this->db3->get();
		$agntresults  = $agntbrowseSQL->result();
		//echo $this->db2->last_query();
		$countval['agnt_result'] = $agntresults;

		#Get users list
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('USER_ID,USER_NAME,GAME_ID,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,SUM(TOTAL_RAKE) AS TOTAL_RAKE, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where('GAME_ID', SHAN_GAME_IDS);

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
		}

		$userbrowseSQL = $this->db3->get();
		$userresults  = $userbrowseSQL->result();
		$countval['user_result'] = $userresults;
		return $countval;
	}

	public function getAgentGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id = $data['agntid'];

		$game_name = $data['gameid'];
		$gameId = str_replace("%20"," ",$game_name);
		if($game_name!='ALL'){
			$game_id = $this->getGameNameByDescription($gameId);
		}else{
			$game_id = $gameId;
		}
		
		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}elseif($partner_type==0){
			$partnerids='';
		}

		if(strstr($partnerids,","))
		$partnerids = explode(",",$partnerids);
		else
		$partnerids = $partnerids;

		//print_r($partnerids);
		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where("GAME_ID",$game_id);

			if($partnerids!='' && $partner_type!=0){
				//$this->db2->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
			$agntresults  = $agntbrowseSQL->result();

			$countval['agnt_result'] = $agntresults;

		}

		#Get users list
		if($game_name!='ALL'){
			$uGameId = $this->getGameNameByDescription($game_name);
		}else{
			$uGameId = $game_name;
		}
		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('USER_ID,USER_NAME,GAME_ID,SUM(TOTAL_GAME_PLAYED) as total_games,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where("GAME_ID",$uGameId);

			if($partnerids!='' && $partner_type!=0){
				//$this->db2->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");

			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			//echo $this->db2->last_query();
			$countval['user_result'] = $userresults;
		}
		return $countval;
	}


	public function getSubDistAgentGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id=$data['agntid'];

		$game_name = $data['gameid'];
		$gameId = str_replace("%20"," ",$game_name);
		if($game_name!='ALL'){
			$game_id = $this->getGameNameByDescription($gameId);
		}else{
			$game_id = $gameId;
		}


		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}

		if(strstr($partnerids,","))
		$partnerids=explode(",",$partnerids);
		else
		$partnerids=$partnerids;

		if($this->input->get_post('START_DATE_TIME',TRUE))
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			else
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);

			if($this->input->get_post('END_DATE_TIME',TRUE))
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			else
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);
		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,GAME_ID,sum(MARGIN) as MARGIN ,sum(NET) as NET,MARGIN_PERCENTAGE,PARTNER_COMMISSION_TYPE,GAME_DESCRIPTION as GAME_NAME')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$agent_id);
			$this->db3->where("GAME_ID",$game_id);

			if($partnerids)
				$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$agntbrowseSQL = $this->db3->get();
		$agntresults  = $agntbrowseSQL->result();
// 		echo $this->db3->last_query(); exit;
		$countval['agnt_result'] = $agntresults;

		return $countval;
	}


	public function getAgentGameDetailsTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id=$data['agntid'];
		$game_name = $data['gameid'];

		//$game_id = $this->getGameNameByDescription($game_name);
		if($game_name!='ALL'){
			$game_id = $this->getGameNameByDescription($game_name);
		}else{
			$game_id = $game_name;
		}

		if($this->input->get_post('START_DATE_TIME',TRUE))
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			else
			$data['START_DATE_TIME']= $this->input->get_post('sdate',TRUE);

			if($this->input->get_post('END_DATE_TIME',TRUE))
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			else
			$data['END_DATE_TIME'] 	= $this->input->get_post('edate',TRUE);

		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}

		//print_r($partnerids);
		#Get agents list

		if($partner_type==15 || $partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==14){
			$this->db3->select('USER_ID,USER_NAME,SUM(TOTAL_GAME_PLAYED) as total_games,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET, GAME_ID')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where("GAME_ID",$game_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
		}

		$userbrowseSQL = $this->db3->get();
		$userresults  = $userbrowseSQL->result();
		//echo $this->db2->last_query(); die;
		$countval['user_result'] = $userresults;

		return $countval;
	}

	public function getAllGameTurnoverCount($data){
		//$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllChildIds();

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('game_id,sum(stake) as tot, sum(win) as totwin,partner_id,count(*) as cnt')->from('game_transaction_history');
			$this->db3->where_in("partner_id",explode(",",$partner_ids));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

			if(!empty($data["GAME_ID"]))
				$this->db3->where('GAME_ID',$data["GAME_ID"]);
				$this->db3->group_by("GAME_ID");
        		$browseSQL = $this->db3->get();
				$results  = $browseSQL->result();
				$countval = count($results);
		}else{
		    $countval = 0;
		}
		return $countval;
	}


	public function getAllGameTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		//get all the whitelable and affliate partners
		$partner_ids = $this->getAllChildIds();

		if(count(explode(",",$partner_ids))>0){
        	$this->db3->select('game_id,sum(stake) as tot, sum(win) as totwin,partner_id,count(*) as cnt')->from('game_transaction_history');
			$this->db3->where_in("partner_id",explode(",",$partner_ids));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('STARTED >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('ENDED <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			if(!empty($data["GAME_ID"]))
				$this->db3->where('GAME_ID',$data["GAME_ID"]);

			$this->db3->group_by("GAME_ID");
   	        $browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			$countval = $results;
		}else{
		    $countval = "";
		}
		return $countval;
	}


	public function getAllPartnerIds($partnerid){
	    $this->db2->select('PARTNER_ID')->from('partner');
		$this->db2->where("FK_PARTNER_ID",$partnerid);
        $browseSQL = $this->db2->get();
		$results  = $browseSQL->result();
		$partnerids='';
		foreach($results as $res){
		  $partnerids .= $res->PARTNER_ID.',';
		}
		return trim($partnerids,",");
	}




	public function getAllUserTurnoverCount($partner_id,$data){
        $this->db3->select('sum(total_bets) as tot, sum(total_wins) as totwin,partner_id,user_id,count(*) as cnt')->from('user_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("user_id");
        $browseSQL = $this->db3->get();
     //  echo $this->db2->last_query();
		$results  = $browseSQL->result();

		return count($results);
	}


	public function getAllUserTurnover($partner_id,$data){
            //echo "<pre>";print_r($data);die;
        $this->db3->select('sum(total_bets) as tot, sum(total_wins) as totwin,partner_id,user_id,sum(net) as net')->from('user_turnover_report_daily');
		$this->db3->where("partner_id",$partner_id);

		//print_r($data);
		if(!empty($data["user_id"]))
			$this->db3->where('USER_ID', $data["user_id"]);
		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('REPORT_DATE >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('REPORT_DATE <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("user_id");
        $browseSQL = $this->db3->get();
		//echo $this->db2->last_query();

		$results  = $browseSQL->result();
		return $results;
	}


	public function getGamesData() {
		$this->db2->select('MINIGAMES_ID,MINIGAMES_NAME')->from('minigames');
		$this->db2->where('MINIGAMES_ID !=','');
		$this->db2->order_by('MINIGAMES_NAME','asc');
		$browseSQL = $this->db2->get();
		return $browseSQL->result();
	}

	public function getPartnersData($gameID,$sdate,$edate) {

		$this->db3->select('t1.GAME_TRANSACTION_ID,t1.GAME_ID,SUM(t1.STAKE) as totalBets,SUM(t1.WIN) as totalWins,t1.PARTNER_ID,t2.PARTNER_NAME')->from('game_transaction_history t1');
		$this->db3->join('partner t2','t2.PARTNER_ID = t1.PARTNER_ID');
		$this->db3->where('t1.GAME_ID',$gameID);
                $this->db3->where('t1.STARTED >=',date('Y-m-d H:i:s',strtotime($sdate)));
                $this->db3->where('t1.ENDED <=',date('Y-m-d H:i:s',strtotime($edate)));
		$this->db3->group_by('t1.PARTNER_ID');
		$browseSQL = $this->db3->get();
                //echo $this->db2->last_query();
		return $browseSQL->result();
	}

        public function getParticularGroupIdGameInfo($group_id){
            $query = $this->db2->query("select * from oddneven_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }

        public function getParticularLuckGroupGameInfo($group_id){
            $query = $this->db2->query("select * from luck_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }


        public function getParticularluckynumGroupGameInfo($group_id){
            $query = $this->db2->query("select * from luckynumber_play where PLAY_GROUP_ID = '$group_id' ");
            $groupInfo  =  $query->result();
            return $groupInfo;
        }

        public function getCardNumbers($str){

            $splitString = explode("[",$str);
            $splitAgain = explode("_",$splitString[1]);

            $arrayCount =  count($splitAgain);
            $cardVAlues = '';
            for($i=0;$i<$arrayCount;$i++){
                if($splitAgain[$i] != '' && $splitAgain[$i] != "]"){
                $cardVAlues .= $splitAgain[$i].'_';
                }
            }
            return trim($cardVAlues,'_');
         }



		 public function getAllGameTypes(){
			$query = $this->db2->query('select MINIGAMES_ID,MINIGAMES_TYPE_ID,GAME_DESCRIPTION,MINIGAMES_TYPE_NAME from minigames_type where STATUS=1');
			$gameTypesInfo  =  $query->result();
			return $gameTypesInfo;
    	}

		public function getAllCurrencyTypes(){
			$query = $this->db2->query('select NAME,COIN_TYPE_ID from coin_type where STATUS=1');
			$gameCurrencyInfo  =  $query->result();
			return $gameCurrencyInfo;
    	}


		public function getGamesTOBySearchCriteria($searchData=array(),$limitend,$limitstart){
		 $gameId  = $this->report_model->getTournamentIDByName($searchData['TABLE_ID']);
		  if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) ){
			$conQuery = "";
			if($searchData['TABLE_ID']!=""){
				$conQuery .= "t.TOURNAMENT_ID = '".$gameId."'";
			}

			if($searchData['GAME_TYPE']!=""){
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					    $conQuery .= " CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."' ";
				}else{
					  $conQuery .= " AND CONCAT(t.SMALL_BLIND,'/',t.BIG_BLIND) = '".$searchData['STAKE']."'";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  if($searchData['STATUS']==2){
					  $conQuery .= " t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
				}else{
					  if($searchData['STATUS']==2){
					  $conQuery .= " AND t.IS_ACTIVE = 0";
					  }else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
					  }
			    }
			}
			$sql = 	$conQuery;
			$query = $this->db2->query("select t.TOURNAMENT_ID,th.TOTAL_STAKE,COIN_TYPE,MIN_BET,MAX_BET,t.IS_ACTIVE,sum(th.TOTAL_GAME_PLAYS) as totalgames,sum(th.TOTAL_POT_AMOUNT) as totalpot_amounts,sum(th.TOTAL_REVENUE) as total_revenue,th.DAILY_TOURNAMENT_ID from shan_tournament_tables t left join daily_tournament_table_history th on t.TOURNAMENT_ID=th.TABLE_ID where $sql and t.IS_ACTIVE=1 group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}else{
			$sql = 	$conQuery;
			$query = $this->db2->query("select t.TOURNAMENT_ID,th.TOTAL_STAKE,COIN_TYPE,MIN_BET,MAX_BET,t.IS_ACTIVE,sum(th.TOTAL_GAME_PLAYS) as totalgames,sum(th.TOTAL_POT_AMOUNT) as totalpot_amounts,sum(th.TOTAL_REVENUE) as total_revenue,th.DAILY_TOURNAMENT_ID from shan_tournament_tables t left join daily_tournament_table_history th on t.TOURNAMENT_ID=th.TABLE_ID where t.IS_ACTIVE=1 group by t.TOURNAMENT_ID limit $limitstart,$limitend");
		}
	  	$fetchResults  = $query->result();
	 	return $fetchResults;
	}

	public function getGamesDailyTOIds($data,$start,$end){

		//$query = $this->db2->query("select DAILY_TOURNAMENT_ID from daily_tournament_table_history where TABLE_ID=".$data." and date(CREATED_DATE) between '".date("Y-m-d",strtotime($start))."' and '".date("Y-m-d",strtotime($end))."'");
		$query = $this->db2->query("select DAILY_TOURNAMENT_ID from daily_tournament_table_user_history where DAILY_TOURNAMENT_ID=".$data." and date(CREATED_DATE) between '".date("Y-m-d",strtotime($start))."' and '".date("Y-m-d",strtotime($end))."'");
		$dailytournamentids  =  $query->result();
		return $dailytournamentids;
	}

	public function getGamesTOTotalPlayers($data,$start,$end){
		$query = $this->db2->query("select count(distinct USER_ID) as totalplayers from daily_tournament_table_user_history where DAILY_TOURNAMENT_ID in(".$data.") and date(CREATED_DATE) between '".date("Y-m-d",strtotime($start))."' and '".date("Y-m-d",strtotime($end))."'");
		$totalplayers  =  $query->row();
		return $totalplayers->totalplayers;
	}

	public function getGamesTOCountBySearchCriteria($searchData=array(),$limitend,$limitstart){
	$gameId  = $this->report_model->getTournamentIDByName($searchData['TABLE_ID']);
		if(!empty($searchData['TABLE_ID']) or !empty($searchData['GAME_TYPE']) or !empty($searchData['CURRENCY_TYPE'])  or !empty($searchData['STAKE'])  or (!empty($searchData['START_DATE_TIME']) and !empty($searchData['END_DATE_TIME'])) or !empty($searchData['STATUS']) ){
			$conQuery = "";
			if($searchData['TABLE_ID']!=""){
				$conQuery .= "t.TOURNAMENT_NAME = '".$gameId."'";
			}

			if($searchData['GAME_TYPE']!=""){
				if($searchData['TABLE_ID'] == ''){
					$conQuery .= ' t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}else{
					$conQuery .= ' AND t.MINI_GAME_TYPE_ID = "'.$searchData['GAME_TYPE'].'"';
				}
			}


			if($searchData['CURRENCY_TYPE']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['PLAYER_ID'] == ''){
					  $conQuery .= " t.COIN_TYPE = '".$searchData['CURRENCY_TYPE']."' ";
				}else{
					  $conQuery .= " AND t.COIN_TYPE = '".$searchData['CURRENCY_TYPE']."' ";
			  }
			}


			if($searchData['STAKE']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == ''){
					  $conQuery .= " (t.SMALL_BLIND = '".$searchData['STAKE']."' or t.BIG_BLIND = '".$searchData['STAKE']."') ";
				}else{
					  $conQuery .= " AND (t.SMALL_BLIND = '".$searchData['STAKE']."' or t.BIG_BLIND = '".$searchData['STAKE']."')";
			    }
			}

			if($searchData['START_DATE_TIME']!="" && $searchData['END_DATE_TIME']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == ''){
					  $conQuery .= " date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
				}else{
					  $conQuery .= " AND  date_format(th.CREATED_DATE,'%Y-%m-%d') BETWEEN  '".date("Y-m-d",strtotime($searchData['START_DATE_TIME']))."' AND '".date("Y-m-d",strtotime($searchData['END_DATE_TIME']))."' ";
			    }
			}

			if($searchData['STATUS']!=""){
				if($searchData['TABLE_ID'] == '' && $searchData['GAME_TYPE'] == '' && $searchData['CURRENCY_TYPE'] == '' && $searchData['STAKE'] == '' && $searchData['START_DATE_TIME']=='' && $searchData['END_DATE_TIME']==''){
					  $conQuery .= " t.IS_ACTIVE = '".$searchData['STATUS']."'";
				}else{
					  $conQuery .= " AND t.IS_ACTIVE = '".$searchData['STATUS']."'";
			    }
			}

			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from shan_tournament_tables t left join daily_tournament_table_history th  on t.tournament_id=th.TABLE_ID where $sql and t.IS_ACTIVE=1 group by t.TOURNAMENT_ID ) as cnt");

		}else{
			$sql = 	$conQuery;
			$querycnt=$this->db2->query("select count(*) as cnt from (select t.tournament_id from shan_tournament_tables t left join daily_tournament_table_history th  on t.tournament_id=th.TABLE_ID where t.IS_ACTIVE=1 group by t.TOURNAMENT_ID) as cnt");
		}
	  $gameInfo  =  $querycnt->row();
	  return $gameInfo->cnt;
	}

	public function getCurrencyNameByID($id){
		$query = $this->db2->query('select NAME from coin_type where COIN_TYPE_ID = '.$id);
		$gameTypesInfo  =  $query->row();
		return $gameTypesInfo->NAME;
	}

	public function getAgentIds($allpartnerids){
		if($allpartnerids){
		$allpartnerids1=implode(",",$allpartnerids);
		$query=$this->db2->query('select PARTNER_ID from partner where PARTNER_ID in('.$allpartnerids1.') and FK_PARTNER_TYPE_ID=14');
		$partnerids= $query->result();
		}else{
		$partnerids='';
		}
		return $partnerids;
	}


	public function getPartnersList($partnertype,$partnerid){

			$partnerids = $partnerid;
			
			if($partnertype==11){
				$supdistributorlists = $this->getPartnerList($partnerid,15);
				
				$supdistids="";
				if(isset($supdistributorlists)){
					foreach($supdistributorlists as $key=>$value){
						if($partnerids){
							$partnerids=$partnerids.",".$supdistributorlists[$key]->PARTNER_ID;
							if($supdistids)
								$supdistids=$supdistids.",".$supdistributorlists[$key]->PARTNER_ID;
								else
									$supdistids=$supdistributorlists[$key]->PARTNER_ID;
						}else{
							$partnerids=$supdistributorlists[$key]->PARTNER_ID;
							if($supdistids)
								$supdistids=$supdistids.",".$supdistributorlists[$key]->PARTNER_ID;
								else
									$supdistids=$supdistributorlists[$key]->PARTNER_ID;
						}
					}
				}
				
				$distributorlists = $this->getPartnerList($supdistids,12);
				$distids="";
				if(isset($distributorlists)){
					foreach($distributorlists as $key=>$value){
						if($partnerids){
							$partnerids=$partnerids.",".$distributorlists[$key]->PARTNER_ID;
							if($distids)
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
							else
							$distids=$distributorlists[$key]->PARTNER_ID;
						}else{
							$partnerids=$distributorlists[$key]->PARTNER_ID;
							if($distids)
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
							else
							$distids=$distributorlists[$key]->PARTNER_ID;
						}
					}
				}
				$subdistids="";
				if(isset($distids)){
					$subdistributorlists = $this->getPartnerList($distids,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}
						}
					}

					if(isset($subdistids)){
						$subdid = explode(",",$subdistids);
						$subdistagentlist = $this->getPartnerList($subdid,14);

						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								}
							}
						}
					}

					if(isset($distids)){
						$agentslists = $this->getPartnerList($distids,14);
					}



					if(isset($agentslists)){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
				}
			}if($partnertype==15){
				
				$distributorlists = $this->getPartnerList($partnerids,12);
				$distids="";
				if(isset($distributorlists)){
					foreach($distributorlists as $key=>$value){
						if($partnerids){
							$partnerids=$partnerids.",".$distributorlists[$key]->PARTNER_ID;
							if($distids)
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
							else
							$distids=$distributorlists[$key]->PARTNER_ID;
						}else{
							$partnerids=$distributorlists[$key]->PARTNER_ID;
							if($distids)
							$distids=$distids.",".$distributorlists[$key]->PARTNER_ID;
							else
							$distids=$distributorlists[$key]->PARTNER_ID;
						}
					}
				}
				$subdistids="";
				if(isset($distids)){
					$subdistributorlists = $this->getPartnerList($distids,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}
						}
					}

					if(isset($subdistids)){
						$subdid = explode(",",$subdistids);
						$subdistagentlist = $this->getPartnerList($subdid,14);

						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								}
							}
						}
					}

					if(isset($distids)){
						$agentslists = $this->getPartnerList($distids,14);
					}



					if(isset($agentslists)){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
				}
			}elseif($partnertype==12){
					$subdistids='';
					$subdistributorlists=$this->getPartnerList($partnerid,13);
					if($subdistributorlists){
						foreach($subdistributorlists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistributorlists[$key]->PARTNER_ID;
								if($subdistids)
								$subdistids=$subdistids.",".$subdistributorlists[$key]->PARTNER_ID;
								else
								$subdistids=$subdistributorlists[$key]->PARTNER_ID;

							}
						}
					}

					if(@$subdistids){
						$subdistagentlist=$this->getPartnerList($subdistids,14);
						if($subdistagentlist){
							foreach($subdistagentlist as $key=>$value){
								if($partnerids){
									$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								}else{
									$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								}
							}
						}
					}

					$agentslists=$this->getPartnerList(@$distids,14);

					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
			}elseif($partnertype==13){
					$subdistagentlist=$this->getPartnerList($partnerid,14);
					$subdistids='';
					if($subdistagentlist){
						foreach($subdistagentlist as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$subdistagentlist[$key]->PARTNER_ID;
								if($subdistids)
									$subdistids=$subdistids.",".$subdistagentlist[$key]->PARTNER_ID;
								else
									$subdistids=$subdistagentlist[$key]->PARTNER_ID;
							}else{
								$partnerids=$subdistagentlist[$key]->PARTNER_ID;
								if($subdistids)
									$subdistids=$subdistids.",".$subdistagentlist[$key]->PARTNER_ID;
								else
									$subdistids=$subdistagentlist[$key]->PARTNER_ID;
							}
						}
					}


					$agentslists=$this->getPartnerList($subdistids,14);

					if($agentslists){
						foreach($agentslists as $key=>$value){
							if($partnerids){
								$partnerids=$partnerids.",".$agentslists[$key]->PARTNER_ID;
							}else{
								$partnerids=$agentslists[$key]->PARTNER_ID;
							}
						}
					}
			}
			return $partnerids;
	}

	public function getPartnersPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$sessionData = $this->session->userdata('searchData');
		if(isset($sessionData["agentid"]))
			$data["agentid"] = $sessionData["agentid"];

		if(isset($sessionData["GAMES_TYPE"]))
			$data["GAMES_TYPE"] = $sessionData["GAMES_TYPE"];

		//$partnerids=$this->getPartnersList(11,$partner_id);
		$partnerids="";
		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		/*if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids; */

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		if($partner_type==0 || $partner_type==''){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ymainagent_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}

			$this->db3->group_by("MAIN_AGEN_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("MAIN_AGEN_ID",$partner_id);

			//if($partnerids)
			//$this->db->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUPERDISTRIBUTOR_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();die;
			$results['self_results']  = $browseSQL->result();
		}
		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);

			//if($partnerids)
			//$this->db->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();die;
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			//if($partnerids)
			//$this->db->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			#echo $this->db->last_query();
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);

			//if($partnerids)
			//$this->db->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			#echo $this->db->last_query();
			$subresults  = $subbrowseSQL->result();


			$results['subdist_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);

			//if($partnerids)
			//$this->db->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
			#echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results

		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$subresults  = $subbrowseSQL->result();


			$results['self_results'] = $subresults;

			#Agent results

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("PARTNER_ID",$partner_id);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
			//echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();

			$results['self_results'] = $agntresults;

			#Users list
			$this->db3->select('USER_ID,USER_NAME,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,sum(TOTAL_RAKE) as totrake, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			$this->db3->where("PARTNER_ID",$partner_id);

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");

			$userbrowseSQL = $this->db3->get();
			$userresults  = $userbrowseSQL->result();
			//echo $this->db->last_query();
			$results['user_results'] = $userresults;
		}

		//echo $this->db->last_query();
		$countval = $results;
		return $countval;
	}

	public function getPartnersPokerTurnoverGameWise($data){
		//$partner_id = $this->session->userdata('partnerid');
		$partner_id = $data['partner_id'];
		$partner_type = $this->session->userdata('partnertypeid');

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		$partid=$data['partner_id'];

		if($partner_type==0){
			$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ymainagent_game_turn_over_history');
			$this->db3->where("MAIN_AGEN_ID",$partid);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results['self_results']  = $browseSQL->result();
		}

		if($partner_type==11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(TOTAL_RAKE) as totrake,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			//echo $this->db->last_query(); die;
			$results['self_results']  = $browseSQL->result();
		}
		
		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,sum(TOTAL_RAKE) as totrake,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
			$browseSQL = $this->db3->get();
			$results['self_results']  = $browseSQL->result();		
		}		
		
		if($partner_type==12){
			#Self results
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,sum(TOTAL_RAKE) as totrake,MARGIN_PERCENTAGE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			//echo $this->db->last_query();
			$results['self_results']  = $browseSQL->result();

		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(TOTAL_RAKE) as totrake,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['subdist_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids)
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==13){
		   #Sub dist results
		    $this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('ysubdistributor_game_turn_over_history');
		    $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$subresults  = $subbrowseSQL->result();
			$results['self_results'] = $subresults;

			#Agent results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$agntbrowseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['agent_results'] = $agntresults;
		}

		if($partner_type==14){
			#Self results
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$partid);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");

			$agntbrowseSQL = $this->db3->get();
			//echo $this->db->last_query();
			$agntresults  = $agntbrowseSQL->result();
			$results['self_results'] = $agntresults;
		}

		//echo $this->db->last_query();
		$countval = $results;
		return $countval;
	}	

	public function getSubDistributorPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		/*$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids; */

		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		#Get sub distributor list
		if($partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db->where_in("SUBDISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		//echo $this->db->last_query();
		$countval['subdist_result'] = $subresults;

		#Get agents list
		if($partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db->where_in("SUBDISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}
		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db->last_query();
		$countval['distagnt_result'] = $distagntresults;
		return $countval;
	}

	public function getSuperDistributorPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$superdistributor_id=$data['superdistid'];

		$partnerids="";
		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		if($partner_type==0 || $partner_type=11){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$superdistributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUPERDISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			$countval['superdist_result'] = $results;
			
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$superdistributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;			
		} 
		return $countval;
	}

	public function getDistributorPokerTurnover_superdist($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');

		$partnerids="";
		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		if($partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");
			$browseSQL = $this->db3->get();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}
		return $countval;
	}

	public function getDistributorPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		//$partnerids=$this->getPartnersList(11,$partner_id);
		$partnerids="";
		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		/*if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;*/

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		if($partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
		//	echo $this->db->last_query();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;

			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db->last_query();
			$countval['subdist_result'] = $subresults;

			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(TOTAL_RAKE) as totrake,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db->last_query();
			$countval['distagnt_result'] = $distagntresults;
		}
		if($partner_type==11 || $partner_type==12 || $partner_type==15){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("DISTRIBUTOR_ID");

			$browseSQL = $this->db3->get();
			#echo $this->db->last_query();
			$results  = $browseSQL->result();
			$countval['dist_result'] = $results;
		}

		#Get sub distributor list
		if($partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==15){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("SUBDISTRIBUTOR_ID");

			$subbrowseSQL = $this->db3->get();
			$subresults  = $subbrowseSQL->result();
			//echo $this->db->last_query();
			$countval['subdist_result'] = $subresults;
		}

		#Get agents list
		if($partner_type==11 || $partner_type==12 || $partner_type==13 || $partner_type==15){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(TOTAL_RAKE) as totrake,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");

			$distagntbrowseSQL = $this->db3->get();
			$distagntresults  = $distagntbrowseSQL->result();
			//echo $this->db->last_query();
			$countval['distagnt_result'] = $distagntresults;
		}
		return $countval;
	}

	public function getMgntPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("MAIN_AGEN_ID");

		$browseSQL = $this->db3->get();
   //echo $this->db3->last_query(); die;
		$results  = $browseSQL->result();
	  $countval['magnt_result'] = $results;

		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("SUPERDISTRIBUTOR_ID");

		$browseSQL = $this->db3->get();
	//	echo $this->db3->last_query();
		$results  = $browseSQL->result();
		$countval['superdist_result'] = $results;

		return $countval;
	}

	public function getAgentPokerTurnover($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id=$data['agntid'];

		if($partner_type==11){
			$partnerids=$this->getPartnersList(11,$partner_id);
		}elseif($partner_type==12){
			$partnerids=$this->getPartnersList(12,$partner_id);
		}elseif($partner_type==13){
			$partnerids=$this->getPartnersList(13,$partner_id);
		}elseif($partner_type==15){
			$partnerids=$this->getPartnersList(15,$partner_id);		
		}elseif($partner_type==0){
			$partnerids='';
		}

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		#Get agents list
		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,sum(NET) as NET,MARGIN_PERCENTAGE,SUM(PLAYER_LOSS) AS PLAYER_LOSS,SUM(SETTLEMENT_AMOUNT) AS SETTLEMENT_AMOUNT')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

           	if($partnerids != ''){
				$astr = implode(",",$partnerids);
				if($agent_id != '')
					$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);

			//$partnerids = array_push($partnerids,$agent_id);
			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$agntbrowseSQL = $this->db3->get();
		$agntresults  = $agntbrowseSQL->result();
		//echo $this->db3->last_query();
		$countval['agnt_result'] = $agntresults;

		#Get users list
		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('USER_ID,USER_NAME,GAME_ID,sum(TOTAL_BETS) as totbet, sum(TOTAL_WINS) as totwin,sum(TOTAL_RAKE) as totrake, (sum(TOTAL_BETS)-sum(TOTAL_WINS)) as  NET')->from('yuser_turnover_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("USER_ID");
		}

		$userbrowseSQL = $this->db3->get();
		$userresults  = $userbrowseSQL->result();
		$countval['user_result'] = $userresults;
		return $countval;
	}
	
	public function getMagntTurnoverPokerGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$magnt_id=$data['magntid'];

		$this->db3->select('MAIN_AGEN_ID,MAIN_AGEN_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ymainagent_game_turn_over_history');
		$this->db3->where("MAIN_AGEN_ID",$magnt_id);
		$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db3->last_query();die;
		$results  = $browseSQL->result();
		$countval['magnt_result'] = $results;

		return $countval;
	}	

	public function getMagntSuperDistTurnoverPokerGameWise($data) {
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$superdistributor_id=$data['superdistid'];

		$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
		$this->db3->where("SUPERDISTRIBUTOR_ID",$superdistributor_id);
		$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db3->last_query();
		$results  = $browseSQL->result();
		$countval['superdist_result'] = $results;
		return $countval;	
	}

	public function getMagntDistTurnoverPokerGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
		$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
		$this->db3->where_in('GAME_ID', SHAN_GAME_IDS);

		if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
		}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
			$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
		}
		$this->db3->group_by("GAME_ID");

		$browseSQL = $this->db3->get();
		//echo $this->db3->last_query();
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;
		return $countval;
	}

	public function getSuperDistributorPokerTurnoverGameWise($data){
	
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$superdistributor_id=$data['superdistid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		if($partner_type==11 || $partner_type==0){
			$this->db3->select('SUPERDISTRIBUTOR_ID,SUPERDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ysuperdistributor_game_turn_over_history');
			$this->db3->where("SUPERDISTRIBUTOR_ID",$superdistributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("SUPERDISTRIBUTOR_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval['superdist_result'] = $results; 
		return $countval;
	}

	public function getDistributorPokerTurnoverGameWise($data){
	
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==0){
			$this->db3->select('DISTRIBUTOR_ID,DISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(TOTAL_RAKE) as totrake,sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ydistributor_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			/*
			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}
			*/
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$browseSQL = $this->db3->get();
		$results  = $browseSQL->result();
		$countval['dist_result'] = $results;

		#Get sub distributor list

		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==0){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			/*
			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}
			*/
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
	//	echo $this->db3->last_query();
		$countval['subdist_result'] = $subresults;

		#Get agents list

		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			}

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("PARTNER_ID");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db3->last_query();die;
		$countval['distagnt_result'] = $distagntresults;

		return $countval;
	}
	
	public function getSubDistributorPokerTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$distributor_id=$data['distid'];

		/*$partnerids=$this->getPartnersList(11,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids; */
		if(!empty($data["agentid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agentid"]); //Get selected partner, partners.
		}

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		#Get sub distributor list

		if($partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('SUBDISTRIBUTOR_ID,SUBDISTRIBUTOR_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('ysubdistributor_game_turn_over_history');
			$this->db3->where("SUBDISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//	$this->db3->where_in("SUBDISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$subbrowseSQL = $this->db3->get();
		$subresults  = $subbrowseSQL->result();
		$countval['subdist_result'] = $subresults;

		#Get agents list

		if($partner_type==11 || $partner_type==12 || $partner_type==13){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin,sum(TOTAL_RAKE) as totrake,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("DISTRIBUTOR_ID",$distributor_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			//if($partnerids)
			//$this->db3->where_in("DISTRIBUTOR_ID",$partnerids);
			if(!empty($data["agentid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$distagntbrowseSQL = $this->db3->get();
		$distagntresults  = $distagntbrowseSQL->result();
		//echo $this->db3->last_query();
		$countval['distagnt_result'] = $distagntresults;

		return $countval;
	}
	
	public function getAgentPokerTurnoverGameWise($data){
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		$agent_id = $data['agntid'];

		$partnerids=$this->getPartnersList($partner_type,$partner_id);

		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;

			if($partnerids != ''){
				if(is_array($partnerids))
					$astr = implode(",",$partnerids);
				else
					$astr = $partnerids;

					if($agent_id != '')
						$astr .= ','.$agent_id;
	       	}else{
		    	$astr ='';
		   	}
			$partnerids = explode(",",$astr);
		/*if(!empty($data["agntid"])) {
			$getSPartnerIDs=$this->getSPartnerPartners($data["agntid"]); //Get selected partner, partners.
		}*/

		$mobGameIDs=MOBILE_GAMES;
		if(!empty($mobGameIDs)) {
			$expMobGameId=explode(",",$mobGameIDs);
			foreach($expMobGameId as $gIndex=>$mobData) {
				$mobileGameIDs[]=$mobData;
			}
		}

		if($partner_type==11 || $partner_type==15 || $partner_type==12 || $partner_type==13 || $partner_type==0){
			$this->db3->select('PARTNER_ID,PARTNER_NAME,sum(PLAY_POINTS) as totbet,sum(TOTAL_RAKE) as totrake, sum(WIN_POINTS) as totwin,sum(MARGIN) as MARGIN,sum(NET) as NET,MARGIN_PERCENTAGE,GAME_ID,GAME_DESCRIPTION,PARTNER_COMMISSION_TYPE')->from('yagent_game_turn_over_history');
			$this->db3->where("PARTNER_ID",$agent_id);
			$this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));

			if($partnerids!='' && $partner_type!=0){
				$this->db3->where_in("PARTNER_ID",$partnerids);
			}
			/*if(!empty($data["agntid"]))
				$this->db3->where_in("PARTNER_ID",$getSPartnerIDs);*/

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="pc")
				$this->db3->where_not_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["GAMES_TYPE"]) && $data["GAMES_TYPE"]=="mobile")
				$this->db3->where_in("GAME_ID",$mobileGameIDs);

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}
			$this->db3->group_by("GAME_ID");
		}

		$browseSQL = $this->db3->get();
		//echo $this->db3->last_query();
		$results  = $browseSQL->result();
		return $results;
	}		

	public function getPartnersTurnoverByCategory($data) {
		$partner_id = $this->session->userdata('partnerid');
		$partner_type = $this->session->userdata('partnertypeid');
		/*
		$partnerids=$this->getPartnersList($partner_type,$partner_id);
		if(strstr($partnerids,","))
			$partnerids=explode(",",$partnerids);
		else
			$partnerids=$partnerids;
		*/
		if($partner_type==0 || $partner_type==''){
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ymainagent_game_turn_over_history');
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));

			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ymainagent_game_turn_over_history');
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();	
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ymainagent_game_turn_over_history');
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			//echo $this->db3->last_query();exit;
			$results['poker_results']  = $browseSQL->result();					
		}
			
		if($partner_type==11){
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysuperdistributor_game_turn_over_history');
			 $this->db3->where("MAIN_AGEN_ID",$partner_id);
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));				
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysuperdistributor_game_turn_over_history');
			 $this->db3->where("MAIN_AGEN_ID",$partner_id);			 
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {

				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysuperdistributor_game_turn_over_history');
		     $this->db3->where("MAIN_AGEN_ID",$partner_id);			 
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}

			$browseSQL = $this->db3->get();
			$results['poker_results']  = $browseSQL->result();			
		}

		if($partner_type==15){
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ydistributor_game_turn_over_history');
			 $this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);	
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));			 				
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ydistributor_game_turn_over_history');
			 $this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);			 
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ydistributor_game_turn_over_history');
			 $this->db3->where("SUPERDISTRIBUTOR_ID",$partner_id);			 
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));							 
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['poker_results']  = $browseSQL->result();			
		}
		
		if($partner_type==12){
			/** sub distributor */
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysubdistributor_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));		 				
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysubdistributor_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('ysubdistributor_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['poker_results']  = $browseSQL->result();
			/** sub distributor end */
			
			/** agent list */
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));		 				
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results1']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results1']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("DISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			//echo $this-db3->last_query();exit;
			$results['poker_results1']  = $browseSQL->result();		
			/** agent list end */			
		}
		
		if($partner_type==13){
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("SUBDISTRIBUTOR_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));						 
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['poker_results']  = $browseSQL->result();			
		}
		
		if($partner_type==14){
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("PARTNER_ID",$partner_id);
			 $this->db3->where_not_in('GAME_ID', unserialize(CASINO_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['casino_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("PARTNER_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', SHAN_GAME_IDS);
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['shan_results']  = $browseSQL->result();
			
			$this->db3->select('sum(PLAY_POINTS) as totbet, sum(WIN_POINTS) as totwin, sum(MARGIN) as margin,IF(SETTLEMENT_AMOUNT=0,SUM(NET),sum(SETTLEMENT_AMOUNT)) AS company',FALSE)
			 ->from('yagent_game_turn_over_history');
			 $this->db3->where("PARTNER_ID",$partner_id);
			 $this->db3->where_in('GAME_ID', unserialize(POKER_GAME_IDS));
			if(!empty($data["START_DATE_TIME"]) && $data["END_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
			}else if(!empty($data["END_DATE_TIME"]) && $data["START_DATE_TIME"] == '' ) {
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));
			}else if(!empty($data["START_DATE_TIME"]) && !empty($data["START_DATE_TIME"]) ) {
				$this->db3->where('START_TIME >=', date('Y-m-d H:i:s',strtotime($data["START_DATE_TIME"])));
				$this->db3->where('START_TIME <=', date('Y-m-d H:i:s',strtotime($data["END_DATE_TIME"])));		
			}
			$browseSQL = $this->db3->get();
			$results['poker_results']  = $browseSQL->result();			
		}
		
		//echo $this->db3->last_query();
		$countval = $results;
		return $countval;	
	}


	public function getPSubDistributorCount($partnerID) {
		$this->db->where('FK_PARTNER_ID',$partnerID);
		$this->db->where('FK_PARTNER_TYPE_ID',13);
		$this->db->where('STATUS',1);
		$browseSQL = $this->db->get('partner');
		$rsResult  = $browseSQL->num_rows();
		return $rsResult;
	}

	public function getPAgentCount($partnerID) {
		$this->db->select('PARTNER_ID,PARTNER_NAME');
		$this->db->where('FK_PARTNER_ID',$partnerID);
		$this->db->where('FK_PARTNER_TYPE_ID',13);
		$this->db->where('STATUS',1);
		$browseSQL = $this->db->get('partner');
		$rsResult  = $browseSQL->result();
		if(empty($rsResult)) {
			$rPartnerIDs=$partnerID;
		} else {
			$rPartnerIDs=$partnerID;
			foreach($rsResult as $rIndex=>$sDisIDS) {
				$rPartnerIDs=$rPartnerIDs.",".$sDisIDS->PARTNER_ID;
			}
		}

		$this->db->where_in('FK_PARTNER_ID',$rPartnerIDs);
		$this->db->where('FK_PARTNER_TYPE_ID',14);
		$this->db->where('STATUS',1);
		$browseSQLR = $this->db->get('partner');
		$rsResultR  = $browseSQLR->num_rows();
		return $rsResultR;
	}

	public function getPPlayerCount($partnerID) {
		$this->db->select('PARTNER_ID,PARTNER_NAME');
		$this->db->where('FK_PARTNER_ID',$partnerID);
		$this->db->where('FK_PARTNER_TYPE_ID',13);
		$this->db->where('STATUS',1);
		$browseSQL = $this->db->get('partner');
		$rsResult  = $browseSQL->result();
		if(empty($rsResult)) {
			$rPartnerIDs=$partnerID;
		} else {
			$rPartnerIDs=$partnerID;
			foreach($rsResult as $rIndex=>$sDisIDS) {
				$rPartnerIDs=$rPartnerIDs.",".$sDisIDS->PARTNER_ID;
			}
		}

		$this->db->select('PARTNER_ID,PARTNER_NAME');
		$this->db->where_in('FK_PARTNER_ID',$rPartnerIDs);
		$this->db->where('FK_PARTNER_TYPE_ID',14);
		$this->db->where('STATUS',1);
		$getAgentIDs= $this->db->get('partner');
		$rsAgentIDs = $getAgentIDs->result();
		if(empty($rsAgentIDs)) {
			$userAgentIDs=$partnerID;
		} else {
			foreach($rsAgentIDs as $userIndex=>$userData) {
				if(empty($userAgentIDs))
					$userAgentIDs = $userData->PARTNER_ID;
				else
					$userAgentIDs = $userAgentIDs.",".$userData->PARTNER_ID;
			}
		}

		$getUserData = $this->db->query("SELECT USER_ID,USERNAME FROM user WHERE ACCOUNT_STATUS=1 AND PARTNER_ID IN($userAgentIDs)");
		$rsUsersData = $getUserData->num_rows();
		return $rsUsersData;
	}

	public function getPartnerList($partnerid,$partner_type) {
		$this->db2->select("PARTNER_ID")->from("partner");
		$this->db2->where_in("FK_PARTNER_ID",$partnerid);
		$this->db2->where("FK_PARTNER_TYPE_ID",$partner_type);
		$result=$this->db2->get();
// 		echo $this->db2->last_query();exit;
		return $result->result();
	}

	public function getGameNameByDescription($desc){
		$descrip = str_replace("%20"," ",$desc);
		$this->db2->select("MINIGAMES_NAME")->from("minigames");
		$this->db2->where("DESCRIPTION",$descrip);
		$browseSQL = $this->db2->get();
		$resultsval = $browseSQL->result();
		return $resultsval[0]->MINIGAMES_NAME;
	}

	public function getGameNameByDescription_OLD($desc){
		$descrip = str_replace("%20"," ",$desc);
		$this->db2->select("MINIGAMES_NAME")->from("minigames");
		$this->db2->where("MINIGAMES_NAME",$descrip);
		$browseSQL = $this->db2->get();
		$resultsval = $browseSQL->result();
		if(strstr($resultsval[0]->MINIGAMES_NAME,"mobpoker")) {
			$this->db2->select("MINIGAMES_TYPE_NAME")->from("minigames_type");
			$this->db2->where("DESCRIPTION",$desc);
			$browseSQL1 = $this->db2->get();
			$resultsval1 = $browseSQL1->result();	
			//$gameName = $resultsval1[0]->MINIGAMES_TYPE_NAME;
			$gameName = $resultsval[0]->MINIGAMES_NAME;			
		} else {
			$gameName = $resultsval[0]->MINIGAMES_NAME;
		}
		return $gameName;
	}

	public function getGameDescriptionByName($desc){
		$this->db2->select("DESCRIPTION")->from("minigames");
		$this->db2->where("MINIGAMES_NAME",$desc);
		$browseSQL = $this->db2->get();
		$resultsval = $browseSQL->result();
		return $resultsval[0]->DESCRIPTION;
	}

	public function getAllMiniGameName(){
		$this->db2->select("MINIGAMES_NAME")->from("minigames");
		$browseSQL = $this->db2->get();
		$resultsval = $browseSQL->result();
		return $resultsval[0]->MINIGAMES_NAME;
	}

}

?>
