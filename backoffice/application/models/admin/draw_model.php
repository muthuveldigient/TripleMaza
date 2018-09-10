<?php

//error_reporting(E_ALL);
class Draw_model extends CI_Model {

    function __construct() {
        $this->load->database();
    }

    public function minigamesList($gameID = '') {
        $this->load->database();
        $this->db2->select('MINIGAMES_NAME,DESCRIPTION,MINIGAMES_ID')->from('minigames');
        $this->db2->where('STATUS', 1);
        //$this->db2->where_not_in('MINIGAMES_ID', 62); 
        if ($gameID != '' && !empty($gameID))
            $this->db2->where_in('MINIGAMES_ID', $gameID);

        $browseSQL = $this->db2->get();
        //echo $this->db2->last_query(); die;
        return $browseSQL->result();
    }

    public function getDrawInfo($config, $searchArray) {
        $limit = $config["per_page"];
        $offset = $config["cur_page"];

        $this->db2->select("*")->from("tc_maza_draw");
        if (!empty($searchArray["DRAW_NAME"])) {
            $this->db2->like("DRAW_DESCRIPTION", $searchArray["DRAW_NAME"]);
        }

        if (!empty($searchArray["DRAW_NUMBER"])) {
            $this->db2->like("DRAW_NUMBER", $searchArray["DRAW_NUMBER"]);
        }
        if (isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"] != '') {
            $this->db2->where("IS_ACTIVE", $searchArray["DRAW_STATUS"]);
        }

        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $this->db2->order_by('draw_id', 'desc');
        $this->db2->limit($limit, $offset);
        $resultInfo = $this->db2->get();
        //echo $this->db2->last_query();exit;
        return $resultInfo->result();
    }

    public function getDrawcount($searchArray) {
        $this->db2->select("count(*) as cnt")->from("tc_maza_draw");
        if (!empty($searchArray["DRAW_NAME"])) {
            $this->db2->like("DRAW_DESCRIPTION", $searchArray["DRAW_NAME"]);
        }

        if (!empty($searchArray["DRAW_NUMBER"])) {
            $this->db2->like("DRAW_NUMBER", $searchArray["DRAW_NUMBER"]);
        }
        if (isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"] != '') {
            $this->db2->where("IS_ACTIVE", $searchArray["DRAW_STATUS"]);
        }


        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $this->db2->order_by('draw_id', 'desc');
        $resultInfo = $this->db2->get();

        return $resultInfo->row_object();
    }

    public function getTcDrawInfo($config, $searchArray) {
        $limit = $config["per_page"];
        $offset = $config["cur_page"];

        $this->db2->select("*")->from("tc_maza_draw");
        if (!empty($searchArray["DRAW_NAME"])) {
            $this->db2->like("DRAW_DESCRIPTION", $searchArray["DRAW_NAME"]);
        }

        if (!empty($searchArray["DRAW_NUMBER"])) {
            $this->db2->like("DRAW_NUMBER", $searchArray["DRAW_NUMBER"]);
        }
        if (isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"] != '') {
            $this->db2->where("IS_ACTIVE", $searchArray["DRAW_STATUS"]);
        }

        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $this->db2->order_by('draw_id', 'desc');
        $this->db2->limit($limit, $offset);
        $resultInfo = $this->db2->get();
//		echo $this->db2->last_query();exit;
        return $resultInfo->result();
    }

    public function getTcDrawcount($searchArray) {
        $this->db2->select("count(*) as cnt")->from("tc_maza_draw");
        if (!empty($searchArray["DRAW_NAME"])) {
            $this->db2->like("DRAW_DESCRIPTION", $searchArray["DRAW_NAME"]);
        }

        if (!empty($searchArray["DRAW_NUMBER"])) {
            $this->db2->like("DRAW_NUMBER", $searchArray["DRAW_NUMBER"]);
        }
        if (isset($searchArray["DRAW_STATUS"]) && $searchArray["DRAW_STATUS"] != '') {
            $this->db2->where("IS_ACTIVE", $searchArray["DRAW_STATUS"]);
        }


        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $this->db2->order_by('draw_id', 'desc');
        $resultInfo = $this->db2->get();
        //echo $this->db2->last_query();exit;
        return $resultInfo->row_object();
    }

    function updateDrawStatus($drawDetails, $drawId) {

        $this->db2->where("DRAW_ID", $drawId);
        $rsResult = $this->db2->update('tc_maza_draw', $drawDetails);
        return $rsResult;
    }
	
	function updateStremingStatus($data, $STREAMING_ID) {
        $this->db2->where("STREAMING_ID", $STREAMING_ID);
        $rsResult = $this->db2->update('streaming_settings', $data);
        return $rsResult;
    }
	
	function getStremingStatus($STREAMING_ID) {
		if(!empty($STREAMING_ID)){
			$this->db2->where("STREAMING_ID", $STREAMING_ID);
		}
        return $this->db2->get('streaming_settings')->row();
    }
	
	function updateSalesSettings($data, $SETTING_ID) {

        $this->db2->where("SETTING_ID", $SETTING_ID);
        $rsResult = $this->db2->update('tc_maza_sales_settings', $data);
        return $rsResult;
    }
	
	function getSalesSettings($SETTING_ID) {
		if(!empty($SETTING_ID)){
			$this->db2->where("SETTING_ID", $SETTING_ID);
		}
        $resultInfo = $this->db2->get('tc_maza_sales_settings');
        return $resultInfo->result();;
    }

    public function getCategoryManagementInfo() {
        $this->db2->select("c.CATEGORY_ID,c.MINIGAME_ID,cc.CATEGORY_NAME,m.DESCRIPTION")
                ->from("categories_management as c");
        $this->db2->join("categories as cc", "cc.CATEGORY_ID=c.CATEGORY_ID", "left");
        $this->db2->join("minigames as m", "m.MINIGAMES_ID=c.MINIGAME_ID", "left");
        $this->db2->where("CATEGORY_STATUS", 1);
        //echo $this->db2->last_query();exit;
        $resultInfo = $this->db2->get();
        return $resultInfo->result();
    }

    public function getCategory() {
        $this->db2->select("*")->from("categories");
        $this->db2->where("CATEGORY_STATUS", 1);
        $this->db2->order_by('CATEGORY_NAME', 'ASC');
        $resultInfo = $this->db2->get();
        //echo $this->db2->last_query();exit;
        return $resultInfo->result();
    }

    public function getCategoryGames($catID) {
        $select = $this->db2->query("SELECT MINIGAMES_ID,DESCRIPTION FROM minigames WHERE STATUS=1 AND MINIGAMES_ID IN(SELECT MINIGAME_ID FROM categories_management WHERE CATEGORY_ID=" . $catID . ")");
        return $select->result();
    }

    public function getCategoryUnknownGames($catID) {
        $select = $this->db2->query("SELECT MINIGAMES_ID,DESCRIPTION FROM minigames WHERE STATUS=1 AND MINIGAMES_ID NOT IN(SELECT MINIGAME_ID FROM categories_management WHERE CATEGORY_ID=" . $catID . ")");
        return $select->result();
    }

    public function deleteCategory($catID) {
        $this->db2->delete('categories_management', array('CATEGORY_ID' => $catID));
    }

    public function InsertCategory($data) {
        $this->db2->insert('categories_management', $data);
        return $this->db2->insert_id();
    }

    public function getWinBigBossGameDetails() {
        $this->load->database();
        $this->db2->select("*");
        $this->db2->where("STATUS", 1);
        $browseSQL = $this->db2->get("lucky7_games");
        $gameInfo = $browseSQL->result();
        return $gameInfo;
    }

    public function insertLuckyGames($data) {
        if (empty($data)) {
            return 0;
        }
        $res = $this->db2->update_batch('lucky7_games', $data, 'GAMES_ID');
        return $res;
    }

    public function create_result($data) {
        $this->db2->insert('tc_maza_draw_result', $data);
        return $this->db2->insert_id();
    }

    public function update_result($data, $drawID) {
        if (empty($data) || empty($drawID)) {
            return 0;
        }
        $this->db2->where('DRAW_ID', $drawID);
        $res = $this->db2->update('tc_maza_draw_result', $data);
        if ($res) {
            return 1;
        } else {
            return 0;
        }
    }

    public function result_list_search_count($data) {

        $this->db2->select('ld.DRAW_STARTTIME,ld.DRAW_ID,ldr.*');
        $this->db2->join('tc_maza_draw as ld', 'ld.DRAW_ID=ldr.DRAW_ID');
        if (!empty($data["DRAW_ID"])) {
            $this->db2->where('ldr.DRAW_ID', $data["DRAW_ID"]);
        }
        if (!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"])) {
            $startDate = date('Y-m-d', strtotime($data["START_DATE_TIME"]));
            $endDate = date('Y-m-d', strtotime($data["END_DATE_TIME"]));
            $this->db2->where("DATE_FORMAT(ldr.UPDATED_DATE,'%Y-%m-%d') BETWEEN $startDate AND $endDate");
        }

        return $this->db2->from('tc_maza_draw_result as ldr')->count_all_results();
        //echo $this->db2->last_query();exit;
    }

    public function result_list_search_data($data, $config) {
        $this->db2->select('ld.DRAW_STARTTIME,ld.DRAW_ID,ldr.*');
        $this->db2->join('tc_maza_draw as ld', 'ld.DRAW_ID=ldr.DRAW_ID');
        if (!empty($data["DRAW_ID"])) {
            $this->db2->where('ldr.DRAW_ID', $data["DRAW_ID"]);
        }
        if (!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"])) {
            $startDate = date('Y-m-d', strtotime($data["START_DATE_TIME"]));
            $endDate = date('Y-m-d', strtotime($data["END_DATE_TIME"]));
            $this->db2->where("DATE_FORMAT(ldr.UPDATED_DATE,'%Y-%m-%d') BETWEEN $startDate AND $endDate");
        }

        if (!empty($config['per_page']) && !empty($config['cur_page'])) {
            $this->db2->limit($config['per_page'], $config['cur_page']);
        }

        return $this->db2->get('tc_maza_draw_result as ldr')->result();
    }

    public function tc_result_list_search_data($data, $config) {
        $this->db2->select('ld.DRAW_STARTTIME,ld.DRAW_ID,ldr.*');
        $this->db2->join('tc_maza_draw as ld', 'ld.DRAW_ID=ldr.DRAW_ID');
        if (!empty($data["DRAW_ID"])) {
            $this->db2->where('ldr.DRAW_ID', $data["DRAW_ID"]);
        }
        if (!empty($data["START_DATE_TIME"]) && !empty($data["END_DATE_TIME"])) {
            $startDate = date('Y-m-d', strtotime($data["START_DATE_TIME"]));
            $endDate = date('Y-m-d', strtotime($data["END_DATE_TIME"]));
            $this->db2->where("DATE_FORMAT(ldr.UPDATED_DATE,'%Y-%m-%d') BETWEEN $startDate AND $endDate");
        }

        if (!empty($config['per_page']) && !empty($config['cur_page'])) {
            $this->db2->limit($config['per_page'], $config['cur_page']);
        }


        $res = $this->db2->get('tc_maza_draw_result as ldr')->result();
        //echo $this->db2->last_query();exit;
        return $res;
    }

    public function drawList($gameId = '', $drawId = '', $searchArray = array()) {
        $this->load->database();
        $this->db2->select("*");
        if (!empty($gameId)) {
            $this->db2->where("DRAW_GAME_ID", $gameId);
        }
        if (!empty($drawId)) {
            $this->db2->where("DRAW_ID", $drawId);
        }
        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $browseSQL = $this->db2->get("tc_maza_draw");
        $gameInfo = $browseSQL->result();
        //echo $this->db2->last_query();exit;
        return $gameInfo;
    }

    public function tc_drawList($gameId = '', $drawId = '', $searchArray = array()) {
        $this->load->database();
        $this->db2->select("*");
        if (!empty($gameId)) {
            $this->db2->where("DRAW_GAME_ID", $gameId);
        }
        if (!empty($drawId)) {
            $this->db2->where("DRAW_ID", $drawId);
        }
        if (!empty($searchArray['START_DATE_TIME']) && !empty($searchArray['END_DATE_TIME'])) {
            $start_date = $searchArray['START_DATE_TIME'];
            $end_date = $searchArray['END_DATE_TIME'];
            $this->db2->where('DRAW_STARTTIME BETWEEN "' . date('Y-m-d H:i:s', strtotime($start_date)) . '" and "' . date('Y-m-d H:i:s', strtotime($end_date)) . '"');
        }
        $browseSQL = $this->db2->get("tc_maza_draw");
        $gameInfo = $browseSQL->result();
        //echo $this->db2->last_query();exit;
        return $gameInfo;
    }

    public function drawResultList($drawId) {
        $this->load->database();
        $this->db2->select("*");
        if (!empty($drawId)) {
            $this->db2->where("DRAW_ID", $drawId);
        }
        $browseSQL = $this->db2->get("tc_maza_draw_result");
        $gameInfo = $browseSQL->result();
        //echo $this->db2->last_query();exit;
        return $gameInfo;
    }

    function getPreviousDrawData($drawID, $gameID) {
        if ($drawID != '') { //previous draw
            $browseSQL = "SELECT ld.*,ldr.PENDING_WINNUMBER,ldr.DRAW_STATUS as TC_DRAW_STATUS,ldr.DRAW_WINNUMBER as DRAW_RESULT_WINNUMBER FROM tc_maza_draw as ld LEFT JOIN tc_maza_draw_result as ldr ON ld.DRAW_ID=ldr.DRAW_ID WHERE ld.DRAW_GAME_ID=" . $gameID . " AND ld.DRAW_ID < " . $drawID . " AND ld.IS_ACTIVE=1 AND DATE_FORMAT(ld.`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE()ORDER BY ld.DRAW_STARTTIME DESC";
        } else {
            $browseSQL = "SELECT ld.*,ldr.PENDING_WINNUMBER,ldr.DRAW_STATUS as TC_DRAW_STATUS,ldr.DRAW_WINNUMBER as DRAW_RESULT_WINNUMBER FROM tc_maza_draw as ld LEFT JOIN tc_maza_draw_result as ldr ON ld.DRAW_ID=ldr.DRAW_ID WHERE ld.DRAW_GAME_ID=" . $gameID . " AND  ld.IS_ACTIVE=1 AND ld.`DRAW_STARTTIME` < NOW() AND DATE_FORMAT(ld.`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() ORDER BY ld.DRAW_STARTTIME DESC";
        }
        $query = $this->db->query($browseSQL);
        $res = $query->result();
        return $res;
    }

    function getUpcomingDrawData($gameID) {
        $query = $this->db->query("SELECT * FROM tc_maza_draw WHERE DRAW_GAME_ID=" . $gameID . " AND DRAW_ID!='' AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,2");
        $res = $query->result();
        return $res;
    }

    function getFutureDrawsList($gameID) {
        $browseSQL = "SELECT ld.*,ldr.PENDING_WINNUMBER,ldr.DRAW_STATUS as TC_DRAW_STATUS,ldr.DRAW_WINNUMBER as DRAW_RESULT_WINNUMBER FROM tc_maza_draw as ld LEFT JOIN tc_maza_draw_result as ldr ON ld.DRAW_ID=ldr.DRAW_ID  WHERE ld.DRAW_GAME_ID=" . $gameID . " AND ld.DRAW_STARTTIME > NOW() AND DATE_FORMAT(ld.`DRAW_STARTTIME`,'%Y-%m-%d')=CURDATE() AND ld.DRAW_STATUS=1 ORDER BY ld.DRAW_ID ASC";
        $query = $this->db->query($browseSQL);
        $res = $query->result();
        return $res;
    }

    function getCurrentDrawData($drawID, $gameID) {
        $this->load->database();
        $this->db2->select("*");
        if (!empty($drawID)) {
            $this->db2->where("DRAW_ID", $drawID);
        }

        if (!empty($gameID)) {
            $this->db2->where("DRAW_GAME_ID", $gameID);
        }

        $this->db2->where("DRAW_STATUS", 1);
        $this->db2->where("IS_ACTIVE", 1);
        $this->db2->where("DRAW_STARTTIME > NOW()");
        $this->db2->order_by("DRAW_STARTTIME ASC");
        $this->db2->limit(1);
        $browseSQL = $this->db2->get("tc_maza_draw");
        //echo $this->db2->last_query();exit;
        $res = $browseSQL->row_array();

        /* $query = $this->db->query("SELECT * FROM tc_maza_draw WHERE DRAW_GAME_ID=".$gameID." AND DRAW_ID=".$drawID." AND DRAW_STATUS=1 AND IS_ACTIVE=1 AND DRAW_STARTTIME > NOW() ORDER BY DRAW_STARTTIME ASC LIMIT 0,1");
          $res = $query->result(); */
        return $res;
    }
	
	public function getTrackingInfo($date,$action) {
		$this->db2->select("*")->from("tracking");
		if(!empty($date)){
			$start_date	=	$date.' 00:00:00';
			$end_date	=	$date.' 23:59:59';
			$this->db2->where('DATE_TIME BETWEEN "'. date('Y-m-d H:i:s', strtotime($start_date)). '" and "'. date('Y-m-d H:i:s', strtotime($end_date)).'"');
		}
		
		if(!empty($action)){
			$this->db2->like("ACTION_NAME",$action);
		}
		
		$this->db2->order_by('tracking_id', 'desc'); 
		$resultInfo = $this->db2->get();
		
		return $resultInfo->result();
	}
	
	public function getStreamingStatus($STREAMING_ID){
		$this->db2->select("*")->from("streaming_settings");
		if(!empty($STREAMING_ID)){
			$this->db2->where('STREAMING_ID', $STREAMING_ID); 
		}
		$resultInfo = $this->db2->get();
		return $resultInfo->row_array();
	}

}

?>
