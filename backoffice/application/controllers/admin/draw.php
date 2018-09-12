<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Draw extends CI_Controller {

    function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $this->db3 = $CI->load->database('db3', TRUE);
        $this->authendication();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'session', 'pagination', 'encrypt'));
        //$partnerTypeId=$this->session->userdata['partnertypeid'];
        //echo '<pre>';print_r($this->session->userdata);exit;
        $partner_id = $this->session->userdata['partnerid'];
        if ($partner_id == 3 || $partner_id == 4) {
            redirect('login');
        }

        $USR_ID = $this->session->userdata['partnerusername'];
        $USR_NAME = $this->session->userdata['partnerusername'];
        //$USR_STATUS = $_SESSION['partnerstatus'];
        $USR_STATUS = "2";

        $searchdata['rdoSearch'] = '';
        $this->load->model('common/common_model');
        $this->load->model('admin/draw_model');

        $data = array("id" => $partner_id);
        $amount['amt'] = 0; //$this->common_model->getBalance($data);
        $this->load->view("common/header", $amount);
    }

    function authendication() {
        $adminusername = $this->session->userdata('adminusername');
        if ($this->uri->uri_string() !== 'login' && !$adminusername) {
            $this->session->set_flashdata('message', 'Please login to access the page.');
            redirect('login');
        }
    }

    public function index() {
        $gameId = array(LIVE_TC_GAME_ID, RR_GAME_ID); //LIVESTREAM and RR MINIGAMES_ID
        $data["page_title"] = "Draw List";
        if ($this->input->post('frmClear')) {
            $this->session->unset_userdata('drawSearchData');
        }

        if ($this->input->get('start') == 1) {
            $this->session->unset_userdata('drawSearchData');
        }
        $noOfRecords = 0;
        if ($this->input->post('keyword', TRUE) == "Search") {
            $data["DRAW_NAME"] = $this->input->post('draw_name');
            $data["DRAW_STATUS"] = $this->input->post('draw_status');
            $data["START_DATE_TIME"] = $this->input->post('START_DATE_TIME');
            $data["END_DATE_TIME"] = $this->input->post('END_DATE_TIME');
            $data["SEARCH_LIMIT"] = $this->input->post('SEARCH_LIMIT');
            $data["GAME_TYPE"] = $this->input->post('GAME_TYPE');

	     $noOfRecords = $this->draw_model->getDrawcount($data);
            $this->session->set_userdata(array('drawSearchData' => $data));
        } else if ($this->session->userdata('drawSearchData')) {
            $data = $this->session->userdata('drawSearchData');
	     $noOfRecords = $this->draw_model->getDrawcount($data);
        }

        /* Set the config parameters */
        $config['base_url'] = base_url() . "admin/draw/index";
        $config['total_rows'] = (!empty($noOfRecords->cnt) ? $noOfRecords->cnt : '');
        $config['per_page'] = $this->config->item('limit');
        $config['cur_page'] = $this->uri->segment(4);
        $config['suffix'] = '?rid=51';
        $config['order_by'] = "DRAW_ID";
        $config['sort_order'] = "asc";

        if ($this->input->post('keyword', TRUE) == "Search") {
	     $data["results"] = $this->draw_model->getDrawInfo($config, $data);
        } else if ($this->session->userdata('drawSearchData')) {
            $data = $this->session->userdata('drawSearchData');
	     $data["results"] = $this->draw_model->getDrawInfo($config, $data);

            //$data["results"] = $this->draw_model->getDrawInfo($config,$this->session->userdata('drawSearchData'));
        } /* else {
          $data["result"] = $this->draw_model->getDrawInfo($config,$data);
          } */
//echo '<pre>';print_r($data);exit;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['rid'] = 51;
        $data['activeGames'] = $this->draw_model->minigamesList($gameId);
        //if needed
        //$draw = $this->draw_model->getDrawInfo();
        //echo '<pre>';print_r($draw);exit;
        $this->load->view("admin/draw_list", $data);
    }

    public function creation() {
        $gameId = array(LIVE_TC_GAME_ID, RR_GAME_ID); //LIVESTREAM and RR MINIGAMES_ID
        $miniGameList = $this->draw_model->minigamesList($gameId);
        $gameList = array();
        if (!empty($miniGameList)) {
            $gameList[''] = 'Select';
            foreach ($miniGameList as $list) {
                $gameList[$list->MINIGAMES_ID] = $list->DESCRIPTION;
            }
            $data['miniGameList'] = $gameList;
        }
        $this->load->view("admin/drawcreation", $data);
    }

    public function createdraw() {

        if (!empty($_POST["DRAW_GAME_ID"]) && isset($_POST["frmSubmit"])) {
            $arrDraw["DRAW_GAME_ID"] = $_POST["DRAW_GAME_ID"];
            $arrDraw["DRAW_DESCRIPTION"] = $_POST["DRAW_NAME"];
            $arrDraw["DRAW_PRICE"] = $_POST["DRAW_PRICE"];
            $arrDraw["DRAW_COUNTDOWN_TIME"] = 60; //60seconds
            $arrDraw["DRAW_START_DATE"] = $_POST["START_DATE_TIME"];
            $arrDraw["DRAW_END_DATE"] = $_POST["END_DATE_TIME"];
            $arrDraw["DRAW_INTERVAL"] = $_POST["DRAW_INTERVAL"];
            $arrDraw["DRAW_STATUS"] = $_POST["DRAW_STATUS"];
            //$arrDraw["DRAW_TOTNUM"]     = $_POST["TOTAL_NUMBER_OF_DRAWS"];	

            if (!empty($arrDraw)) {
                if (!empty($arrDraw["DRAW_START_DATE"])) {
                    $drawSDate = strtotime($arrDraw["DRAW_START_DATE"]);
                    $cTime = date('d-m-Y H:i:s', strtotime('+1 minutes', strtotime(date('d-m-Y H:i:s'))));
                    $currentTime = strtotime($cTime);

                    if ($drawSDate < $currentTime) {
                        redirect("admin/draw/creation?err=2&chk=1");
                        die;
                    }
                }
                if (!empty($arrDraw["DRAW_END_DATE"])) {
                    $drawEDate = strtotime($arrDraw["DRAW_END_DATE"]);
                    $cTime = date('d-m-Y H:i:s', strtotime('+1 minutes', strtotime(date('d-m-Y H:i:s'))));
                    $currentTime = strtotime($cTime);
                    if ($drawEDate < $currentTime) {
                        redirect("admin/draw/creation?err=3&chk=1");
                        die;
                    }
                }

                if (empty($arrDraw["DRAW_START_DATE"]) || empty($arrDraw["DRAW_END_DATE"])) {
                    redirect("admin/draw/creation?err=7&chk=1");
                    die;
                }

                /* just define date for get draw exists or not */
                $dateInfo["START_DATE_TIME"] = $_POST["START_DATE_TIME"];
                $dateInfo["END_DATE_TIME"] = $_POST["END_DATE_TIME"];

                $spData = '';
                if ($arrDraw["DRAW_GAME_ID"] == RR_GAME_ID) {
                    $rExists = $this->draw_model->drawList('', '', $dateInfo);
                    if (!empty($rExists)) {
                        redirect("admin/draw/creation?err=6&chk=1");
                        die;
                    }
                    /* RajaRani game type lists */
                    $arrDraw["GAME_TYPE_ID"] = '1,2,3,4,5,6,7,8,9,10';
                    $arrDraw["GAME_TYPE_DRAW_PRICE"] = 0;
                    $spData = "CALL sp_lotto_draw_recurrence('" . $arrDraw["DRAW_GAME_ID"] . "','" . $arrDraw["DRAW_DESCRIPTION"] . "','" . $arrDraw["DRAW_PRICE"] . "','" . $arrDraw["DRAW_COUNTDOWN_TIME"] . "','" . date('Y-m-d H:i:s', strtotime($arrDraw["DRAW_START_DATE"])) . "','" . date('Y-m-d H:i:s', strtotime($arrDraw["DRAW_END_DATE"])) . "'," . $arrDraw["DRAW_INTERVAL"] . "," . $arrDraw["DRAW_STATUS"] . ",'" . $arrDraw["GAME_TYPE_ID"] . "','" . $arrDraw["GAME_TYPE_DRAW_PRICE"] . "',@V_OUT1)";
                }
                /* 		if(empty($arrDraw["DRAW_TOTNUM"])) {
                  header("Location: admin-home.php?p=cdraw&err=5&chk=1"); die; //invalid input is given - the total number of draws is in-correct
                  } */
                //DRAW EXISTENSE VALIDATION NEED TO CHECK


                //if ($arrDraw["DRAW_GAME_ID"] == LIVE_TC_GAME_ID) {
                    $tcExists = $this->draw_model->tc_drawList('', '', $dateInfo);
                    if (!empty($tcExists)) {
                        redirect("admin/draw/creation?err=6&chk=1");
                        die;
                    }
                    /* LIVESTREAM game type lists */
                    $arrDraw["GAME_TYPE_ID"] = '0';
                    $arrDraw["GAME_TYPE_DRAW_PRICE"] = 0;
                    $spData = "CALL sp_tc_maza_draw_recurrence('" . $arrDraw["DRAW_GAME_ID"] . "','" . $arrDraw["DRAW_DESCRIPTION"] . "','" . $arrDraw["DRAW_PRICE"] . "','" . $arrDraw["DRAW_COUNTDOWN_TIME"] . "','" . date('Y-m-d H:i:s', strtotime($arrDraw["DRAW_START_DATE"])) . "','" . date('Y-m-d H:i:s', strtotime($arrDraw["DRAW_END_DATE"])) . "'," . $arrDraw["DRAW_INTERVAL"] . "," . $arrDraw["DRAW_STATUS"] . ",'" . $arrDraw["GAME_TYPE_ID"] . "','" . $arrDraw["GAME_TYPE_DRAW_PRICE"] . "',@V_OUT1)";
                //}
                if (!empty($spData)) {
                    $this->db2->query($spData);
                    $select = $this->db2->query('SELECT @V_OUT1');
                    $result = $select->row_array();
                    $resOut = $result['@V_OUT1'];
                }

                if ($resOut == 1) {
                    redirect("admin/draw/creation?err=1&chk=1");
                    die; //success
                } else if ($resOut == 2) {
                    redirect("admin/draw/creation?err=6&chk=1");
                    die; //duplicate record exists
                } else {
                    redirect("admin/draw/creation?err=4&chk=1");
                    die; //failed
                }
            }
        } else {
            redirect("admin/draw/creation?err=4&chk=1");
            die; //failed
        }
    }

    public function drawstatus() {

        if ($_REQUEST["drawID"] || $_REQUEST["drawStatus"]) {
            $newDrawStatus = "";
            if ($_REQUEST["drawStatus"] == 1)
                $newDrawStatus = 0;
            else
                $newDrawStatus = 1;

            $drawStatus["DRAW_ID"] = $_REQUEST["drawID"];
            $drawStatus1["IS_ACTIVE"] = $newDrawStatus;
            $updateDrawStatus = $this->draw_model->updateDrawStatus($drawStatus1, $_REQUEST["drawID"]);
            if ($drawStatus1["IS_ACTIVE"] == 1)
                $statusString = "<a href='javascript:updateDrawStatus(" . $drawStatus["DRAW_ID"] . "," . $drawStatus1["IS_ACTIVE"] . ")' title='Deactive' class='viewuserActive'>Active</a>";
            else
                $statusString = "<a href='javascript:updateDrawStatus(" . $drawStatus["DRAW_ID"] . "," . $drawStatus1["IS_ACTIVE"] . ");' title='Active' class='viewuserDeactive'>Deactive</a>";

            echo $statusString;
            die;
        }
    }

    public function categorymanagement() {

        if (isset($_POST['Submit'])) {
            if (!empty($_POST["category"])) {
                $delExistingCatGames = $this->draw_model->deleteCategory($_POST["category"]);
                if (!empty($_POST["center_ids"])) {
                    $gameIDs = explode(",", $_POST["center_ids"]);
                    foreach ($gameIDs as $gIndex => $gameID) {
                        $data['CATEGORY_ID'] = $_POST["category"];
                        $data['MINIGAME_ID'] = $gameID;
                        $data['CREATED_DATE'] = date('Y-m-d H:i:s');
                        $assignGame = $this->draw_model->InsertCategory($data);
                        if (!empty($assignGame)) {
                            $err = 1;
                        } else {
                            $err = 2;
                        }
                    }
                }
            }
            $err = 1;
        }

        $data['category'] = $this->draw_model->getCategory();
        $data['getCategoryGames'] = $this->draw_model->getCategoryManagementInfo();
        $data['err'] = $err;
        $this->load->view("admin/category", $data);
    }

    public function categorygames() {

        $catID = $_REQUEST["catid"];
        $selectbox1 = "";
        $selectbox2 = "";
        if (isset($catID)) {
            $getCAssignedGames = $this->draw_model->getCategoryGames($catID);
            if (!empty($getCAssignedGames)) {
                $existingGames = "";
                foreach ($getCAssignedGames as $rsCAssignedGames) {
                    $selectbox2 .= '<option value="' . $rsCAssignedGames->MINIGAMES_ID . '">' . $rsCAssignedGames->DESCRIPTION . '</option>';
                    if (!empty($existingGames))
                        $existingGames = $existingGames . "," . $rsCAssignedGames->MINIGAMES_ID;
                    else
                        $existingGames = $rsCAssignedGames->MINIGAMES_ID;
                }
            }

            $getCUAssignedGames = $this->draw_model->getCategoryUnknownGames($catID);
            if (!empty($getCUAssignedGames)) {
                foreach ($getCUAssignedGames as $rsCUAssignedGames) {
                    $selectbox1 .= '<option value="' . $rsCUAssignedGames->MINIGAMES_ID . '">' . $rsCUAssignedGames->DESCRIPTION . '</option>';
                }
            }
        }
        echo $selectbox1 . "###" . $selectbox2 . "###" . $existingGames;
        die;
    }

    public function gamelist() {
        if (isset($_POST['submit'])) {
            extract($_POST);

            $game1 = addslashes($game1);
            $game2 = addslashes($game2);
            $game3 = addslashes($game3);
            $game4 = addslashes($game4);
            $game5 = addslashes($game5);
            $game6 = addslashes($game6);
            $game7 = addslashes($game7);
            $game8 = addslashes($game8);
            $game9 = addslashes($game9);
            $game10 = addslashes($game10);

            $description1 = addslashes($description1);
            $description2 = addslashes($description2);
            $description3 = addslashes($description3);
            $description4 = addslashes($description4);
            $description5 = addslashes($description5);
            $description6 = addslashes($description6);
            $description7 = addslashes($description7);
            $description8 = addslashes($description8);
            $description9 = addslashes($description9);
            $description10 = addslashes($description10);

            $data = array(
                array(
                    'GAMES_ID' => 1,
                    'GAMES_NAME' => $game1,
                    'DESCRIPTION' => $description1
                ),
                array(
                    'GAMES_ID' => 2,
                    'GAMES_NAME' => $game2,
                    'DESCRIPTION' => $description2
                ),
                array(
                    'GAMES_ID' => 3,
                    'GAMES_NAME' => $game3,
                    'DESCRIPTION' => $description3
                ),
                array(
                    'GAMES_ID' => 4,
                    'GAMES_NAME' => $game4,
                    'DESCRIPTION' => $description4
                ),
                array(
                    'GAMES_ID' => 5,
                    'GAMES_NAME' => $game5,
                    'DESCRIPTION' => $description5
                ),
                array(
                    'GAMES_ID' => 6,
                    'GAMES_NAME' => $game6,
                    'DESCRIPTION' => $description6
                ),
                array(
                    'GAMES_ID' => 7,
                    'GAMES_NAME' => $game7,
                    'DESCRIPTION' => $description7
                ),
                array(
                    'GAMES_ID' => 8,
                    'GAMES_NAME' => $game8,
                    'DESCRIPTION' => $description8
                ),
                array(
                    'GAMES_ID' => 9,
                    'GAMES_NAME' => $game9,
                    'DESCRIPTION' => $description9
                ),
                array(
                    'GAMES_ID' => 10,
                    'GAMES_NAME' => $game10,
                    'DESCRIPTION' => $description10
                )
            );

            $result = $this->draw_model->insertLuckyGames($data);

            /* $query = "INSERT INTO lucky7_games (GAMES_ID,GAMES_NAME, DESCRIPTION) VALUES (1,'$game1','$description1'),(2,'$game2','$description2'),(3,'$game3','$description3'),(4,'$game4','$description4'),(5,'$game5','$description5'),(6,'$game6','$description6'),(7,'$game7','$description7'),(8,'$game8','$description8'),(9,'$game9','$description9'),(10,'$game10','$description10')
              ON DUPLICATE KEY UPDATE GAMES_NAME=VALUES(GAMES_NAME),DESCRIPTION=VALUES(DESCRIPTION)";
              $result = mysql_query($query) or die (mysql_error()); */
            $data['msg'] = LIVE_TC_GAME_ID;
            if (!empty($result)) {
                $data['msg'] = 1;
            }
        }
        $result = $this->draw_model->getWinBigBossGameDetails();
        foreach ($result as $row) {
            $data['gameList'][$row->GAMES_ID]['GAMES_NAME'] = $row->GAMES_NAME;
            $data['gameList'][$row->GAMES_ID]['DESCRIPTION'] = $row->DESCRIPTION;
        }
        //echo '<prE>';print_r($data);exit;
        $this->load->view("admin/updategame", $data);
    }

    public function result() {
        $data = array();
        $gameId = LIVE_TC_GAME_ID; //LIVESTREAM MINIGAMES_ID
        $data['drawList'] = $this->draw_model->tc_drawList($gameId);
        $this->session->set_flashdata('result', $msg);
        $this->load->view("admin/result/result_view", $data);
    }

    public function result_list() {
        $this->session->set_userdata(array('keywords' => ''));
        $this->load->view("admin/result/result_list");
    }

    public function result_list_search() {

        $data = array();
        $post = array();
        $data['result_data'] = false;

        if (!empty($_POST)) {
            // Form Post Data
            $post = $this->input->post();
            $this->session->set_userdata(array('keywords' => $post));
            $data['result_data'] = true;
        } else if ($this->session->userdata['keywords'] != '') {
            // For Pagination
            $post = $this->session->userdata['keywords'];
            $data['result_data'] = true;
        }

        if (!empty($post)) {
            $config['base_url'] = base_url() . "admin/draw/result_list_search";
            $config['total_rows'] = $this->draw_model->result_list_search_count($post);
            $config['per_page'] = $this->config->item('limit');
            $config['cur_page'] = $this->uri->segment(4);
            $data['result_list'] = $this->draw_model->tc_result_list_search_data($post, $config);
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
        }

        $this->load->view("admin/result/result_list", $data);
    }

    public function canceldraw_old($drawIDValue) {
		$drawID = (!empty($drawIDValue)?base64_decode($drawIDValue):'');
        $msg = array('message' => 'Please try again', 'class' => 'ErrorMsg');
		$STREAMING_ID=1;
		$streaming_status = $this->draw_model->getStreamingStatus($STREAMING_ID);
		$streamingONOFF = (isset($streaming_status['STREAMING_STATUS'])?$streaming_status['STREAMING_STATUS']:'');
		if(!empty($streamingONOFF)){
			if (!empty($drawID)) {
				$postData['DRAW_ID'] = $drawID;
				//$getCurrentDrawID = $this->draw_model->getCurrentDrawData('', LIVE_TC_GAME_ID);
				$drawExists = $this->draw_model->tc_drawList('', $drawID);
				if (isset($drawExists[0]->DRAW_STATUS) &&  $drawExists[0]->DRAW_STATUS > 1 ) {
					// $currentDraw = $this->draw_model->getCurrentDrawData($drawID);
					if ($drawExists[0]->DRAW_STATUS!=6 && $drawExists[0]->DRAW_STATUS!=7) { //validate is cancelled in tc_lotto_draw table 6 then canncelled, 7 then advance draw cancelled
						if (empty($drawExists[0]->DRAW_WINNUMBER)) {//win number empty in tc_lotto_draw table
							$exists = $this->draw_model->tc_result_list_search_data($postData);
							$msg = array('message' => 'Draw not exists', 'class' => 'ErrorMsg');
							if (!empty($exists)) {
								if (empty($exists[0]->DRAW_WINNUMBER)) {
									$data['DRAW_STATUS'] = 2; //draw cancelled
									$result = $this->draw_model->update_result($data, $drawID);

									$msg = array('message' => 'Failed', 'class' => 'ErrorMsg');
									if ($result) {
										$msg = array('message' => 'Successfully cancelled', 'class' => 'SuccessMsg');
									}
								} else {
									$msg = array('message' => 'Win number available can not be cancelled ', 'class' => 'ErrorMsg');
								}
							} else {
								$postData['DRAW_NAME'] = '';
								$postData['DRAW_WINNUMBER'] = '';
								$postData['DRAW_STATUS'] = 2; //draw cancelled
								$result = $this->draw_model->create_result($postData);
								$msg = array('message' => 'Failed', 'class' => 'ErrorMsg');
								if ($result) {
									$msg = array('message' => 'Successfully cancelled', 'class' => 'SuccessMsg');
								}
							}
						} else {
							$msg = array('message' => 'Win number available in this draw, So can not be cancelled ', 'class' => 'ErrorMsg');
						} 
					} else {
						$msg = array('message' => 'Draw cancelled already', 'class' => 'ErrorMsg');
					} 
				} else {
					$msg = array('message' => 'Draw can not completed yet', 'class' => 'ErrorMsg');
				}
			}else {
					$msg = array('message' => 'Invalid draw', 'class' => 'ErrorMsg');
			}
		}else {
				$msg = array('message' => 'Streaming is turned off, so can not cancel the game!', 'class' => 'ErrorMsg');
		}

        /** tracking info */
        $arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
        $arrTraking["USERNAME"] = $this->session->userdata('partnerusername');
        $arrTraking["ACTION_NAME"] = "Cancel Draw";
        $arrTraking["SYSTEM_IP"] = $_SERVER['REMOTE_ADDR'];
        $arrTraking["REFERRENCE_NO"] = uniqid();
        $arrTraking["STATUS"] = 1;
        $arrTraking["LOGIN_STATUS"] = 1;
        $arrTraking["CUSTOM2"] = 1;
        $arrTraking["CUSTOM1"] = json_encode(array('formData' => $_REQUEST, 'msg' => $msg['message'],'DrawID'=>$drawID));
        $this->db->insert("tracking", $arrTraking);

        $this->session->set_flashdata('result', $msg);
        redirect('admin/draw/drawresult');
    }

    public function drawresult() {
        //$serverTime = $this->common_model->getServerTime();
        //echo $serverTime;exit;
        $gameID = LIVE_TC_GAME_ID; //LIVESTREAM MINIGAMES_ID
        $upcomingDraw = $this->draw_model->getUpcomingDrawData($gameID);
        $drawCountDownTime = '';
        $nxtDrawTime = "--:--";
        if (!empty($upcomingDraw)) {
            $expDDate1 = date('d-m-Y', strtotime(substr($upcomingDraw[0]->DRAW_STARTTIME, 0, 10)));
            $expDTime1 = date('H:i:s', strtotime($upcomingDraw[0]->DRAW_STARTTIME));

            $expDDate = explode('-', $expDDate1);
            $expDTime = explode(':', $expDTime1);
            $drawCountDownTime = $expDDate[2] . ',' . ($expDDate[1] - 1) . ',' . $expDDate[0] . ',' . $expDTime[0] . ',' . $expDTime[1] . ',' . $expDTime[2];

            if (!empty($upcomingDraw[1]->DRAW_STARTTIME)) {
                $nxtDrawDate = date('d/m/Y', strtotime(substr($upcomingDraw[1]->DRAW_STARTTIME, 0, 10)));
                $nxtDrawTime = date('h:i A', strtotime($upcomingDraw[1]->DRAW_STARTTIME));
            }
        }

        $data['nxtDrawTime'] = $nxtDrawTime;
        $data['drawCountDownTime'] = $drawCountDownTime;
        $data['upcomingDraw'] = (!empty($upcomingDraw) ? $upcomingDraw : '');
        //$data['drawList'] = $this->draw_model->drawList($gameID);
        $drawList = $this->draw_model->getFutureDrawsList($gameID);
        /** Future Draw is available then 
          showed in previous draw record based on DRAW_ID
          else showed overall today previous draw list
         */
        if (!empty($drawList[0]->DRAW_ID)) {
            $data['preDrawInfo'] = $this->draw_model->getPreviousDrawData($drawList[0]->DRAW_ID, $gameID);
        } else {
            $data['preDrawInfo'] = $this->draw_model->getPreviousDrawData('', $gameID);
        }
		/** get streaming status */
		$STREAMING_ID=1;
		$streaming_status = $this->draw_model->getStreamingStatus($STREAMING_ID);
		$data['streaming_status'] = (isset($streaming_status['STREAMING_STATUS'])?$streaming_status['STREAMING_STATUS']:'');
		$data['drawList'] = $drawList;
        $this->load->view("admin/result/draw_result", $data);
    }

    public function createdraw_winnumber($drawIDValue) {
		$drawID = (!empty($drawIDValue)?base64_decode($drawIDValue):'');
        $data = array();
        $data['message'] = '';
		
		$STREAMING_ID=1;
		$streaming_status = $this->draw_model->getStreamingStatus($STREAMING_ID);
		$streamingONOFF = (isset($streaming_status['STREAMING_STATUS'])?$streaming_status['STREAMING_STATUS']:'');
		if(!empty($streamingONOFF)){
			if (!empty($_POST['DRAW_WINNUMBER'])) {
				$num_length = strlen((string) $_POST['DRAW_WINNUMBER']);
				if ($num_length == 3) {
					if (!empty($drawID)) {
						/** validate drawid exists or not in tc_lotto_draw table* */
						$drawExists = $this->draw_model->tc_drawList('', $drawID);
						if (isset($drawExists[0]->DRAW_STATUS) &&  $drawExists[0]->DRAW_STATUS > 1  ) {
							if($drawExists[0]->DRAW_STATUS!=6 && $drawExists[0]->DRAW_STATUS!=7){ //validate is cancelled in tc_lotto_draw table 6 then canncelled, 7 then advance draw cancelled
								if (empty($drawExists[0]->DRAW_WINNUMBER)) { //win number empty in tc_lotto_draw table
									/** validate drawID exists or not in tc_lotto_draw_result table * */
									$drawResultExists = $this->draw_model->drawResultList($drawID);
									if (empty($drawResultExists)) {
										/** Insert drawid in tc_lotto_draw_result table* */
										$postData['DRAW_ID'] = $drawID;
										$postData['DRAW_NAME'] = (!empty($drawExists[0]->DRAW_DESCRIPTION) ? $drawExists[0]->DRAW_DESCRIPTION : '');
										$postData['PENDING_WINNUMBER'] = $_POST['DRAW_WINNUMBER'];
										$postData['DRAW_STATUS'] = 0;
										$result = $this->draw_model->create_result($postData);
										if ($result) {
											$data['message'] = 'Created successfully.';
											$data['class'] = 'SuccessMsg';
										} else {
											$data['message'] = 'Could not be created.';
											$data['class'] = 'ErrorMsg';
										}
									} else {
										$action = (!empty($_REQUEST['action']) ? $_REQUEST['action'] : '');
										/** approve DRAW_STATUS=1 in tc_lotto_draw_result table* */
										if ($drawResultExists[0]->DRAW_STATUS == 0 && !empty($drawResultExists[0]->PENDING_WINNUMBER) && $action == 'approve') {
											$updateData['DRAW_STATUS'] = 1;
											$updateData['DRAW_WINNUMBER'] = $drawResultExists[0]->PENDING_WINNUMBER;
											$updateData['PENDING_WINNUMBER'] = '';
											$result = $this->draw_model->update_result($updateData, $drawID);
											if ($result) {
												$data['message'] = 'Approved successfully.';
												$data['class'] = 'SuccessMsg';
											} else {
												$data['message'] = 'Could not be approved.';
												$data['class'] = 'ErrorMsg';
											}
											/** Edit DRAW_STATUS=0 and DRAW_WINNUMBER in tc_lotto_draw_result table* */
										} elseif ($drawResultExists[0]->DRAW_STATUS == 0 && !empty($drawResultExists[0]->PENDING_WINNUMBER) && $action == 'update') {
											$ediData['DRAW_STATUS'] = 0;
											$ediData['PENDING_WINNUMBER'] = $_POST['DRAW_WINNUMBER'];
											$result = $this->draw_model->update_result($ediData, $drawID);
											if ($result) {
												$data['message'] = 'Successfully updated.';
												$data['class'] = 'SuccessMsg';
											} else {
												$data['message'] = 'Failed to update Win number.';
												$data['class'] = 'ErrorMsg';
											}
										} else {
											if (!empty($drawResultExists[0]->DRAW_WINNUMBER)) {
												$data['message'] = 'Draw win-number already processed';
												$data['class'] = 'ErrorMsg';
											} else {
												$data['message'] = 'Please try again';
												$data['class'] = 'ErrorMsg';
											}
										}
									}
								} else {
									$data['message'] = "Win number available in this draw, So can not be cancelled";
									$data['class'] = 'ErrorMsg';
								}
							} else {
								$data['message'] = "Draw cancelled already";
								$data['class'] = 'ErrorMsg';
							}
						} else {
							$data['message'] = "Draw can not completed yet";
							$data['class'] = 'ErrorMsg';
						}
					} else {
						$data = array('message' => 'Invalid draw', 'class' => 'ErrorMsg');
					}
				} else {
					$data['message'] = "Please enter 3 digit win number";
					$data['class'] = 'ErrorMsg';
				}
			} else {
				$data['message'] = 'Please Enter Win Number';
				$data['class'] = 'ErrorMsg';
			}
		} else {
				$data['message'] = "Streaming is turned off, so can not enter the result";
				$data['class'] = 'ErrorMsg';
		}

        /** tracking info */
        $arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
        $arrTraking["USERNAME"] = $this->session->userdata('partnerusername');
        $arrTraking["ACTION_NAME"] = "Win Number Generation";
        $arrTraking["SYSTEM_IP"] = $_SERVER['REMOTE_ADDR'];
        $arrTraking["REFERRENCE_NO"] = uniqid();
        $arrTraking["STATUS"] = 1;
        $arrTraking["LOGIN_STATUS"] = 1;
        $arrTraking["CUSTOM2"] = 1;
        $arrTraking["CUSTOM1"] = json_encode(array('formData' => $_REQUEST, 'msg' => $data['message'],'DrawID'=>$drawID));
        $this->db2->insert("tracking", $arrTraking);

        $this->session->set_flashdata('result', $data);
        redirect('admin/draw/drawresult');
    }

    public function getdbtime() {
        $dbTime = $this->common_model->getServerTime();
        echo date("M j, Y H:i:s O", strtotime($dbTime)) . "\n";
        exit;
    }

    public function nextdrawtime($cDrawID) {

        if (!empty($cDrawID)) {
            $gameID = LIVE_TC_GAME_ID;
            $drawType = "NEXTDRAW";
            $getNextDrawTime = $this->draw_model->getUpcomingDrawData($gameID);

            $draws = '';
            $futureDraw = $this->draw_model->getFutureDrawsList($gameID);
            if (!empty($futureDraw)) {

                $preDrawTime = '';
                $preDrawNo = '';
                $preDrawInfo = $this->draw_model->getPreviousDrawData($futureDraw[0]->DRAW_ID, $gameID);
                if (!empty($preDrawInfo)) {
                    $preDrawTime = date('H:i', strtotime($preDrawInfo[0]->DRAW_STARTTIME));
                    $preDrawNo = substr($preDrawInfo[0]->DRAW_NUMBER, strlen($preDrawInfo[0]->DRAW_NUMBER) - 5, 5);

                    foreach ($preDrawInfo as $drawList) {
                        $draws .= '<tr class="prev_draw" title="Previous Draw"><td>' . $drawList->DRAW_STARTTIME . '</td><td>' . $drawList->DRAW_DESCRIPTION . '</td><td>' . (!empty($drawList->DRAW_WINNUMBER) ? $drawList->DRAW_WINNUMBER : '--') . '</td></tr>';
                    }
                }

                foreach ($futureDraw as $index => $list) {
                    $url = base_url() . 'admin/draw/createdraw_winnumber/' . base64_encode($list->DRAW_ID);
                    $drawID = "'" . 'DRAW_WINNUMBER_' . $list->DRAW_ID . "'";
                    $drawID1 = 'DRAW_WINNUMBER_' . $list->DRAW_ID;
                    $err_id = 'error_msg_' . $drawID1;
                    $formValue = '<form name="win_update_' . $drawID1 . '" id="win_update_' . $drawID1 . '" action="' . $url . '" method="post"><div><input type="text" name="DRAW_WINNUMBER" value="" maxlength="3" id="' . $drawID1 . '" class="Text-win" required="true"> <input type="submit" id="submit_value" value="Create" onclick="updateInfoData(' . $drawID . ')" /></div><div><label for="' . $drawID1 . '" generated="true" class="error" id="' . $err_id . '" style="display:none"></label></div></form>';

                    $resValue[$index]['DRAW_DATETIME'] = date('d-m-Y H:i:s', strtotime($list->DRAW_STARTTIME));
                    $resValue[$index]['TICKET_NUMBER'] = (!empty($list->DRAW_RESULT_WINNUMBER) ? $list->DRAW_RESULT_WINNUMBER : $formValue);
                    $resValue[$index]['DRAW_NAME'] = $list->DRAW_DESCRIPTION;
                }

                $k = 0;
                $curr_draw_time = '--:--';
                foreach ($resValue as $draw) {
                    //$nxtDraw = (!empty($draw->DRAW_STARTTIME)?date('H:i',strtotime($draw->DRAW_STARTTIME)):'00:00');
                    if ($k == 0) {
                        $curr_draw_time = (!empty($draw['DRAW_STARTTIME']) ? date('H:i', strtotime($draw['DRAW_STARTTIME'])) : '--:--');
                        $draws .= '<tr class="curr_draw" title="Current Draw"><td>' . $draw['DRAW_DATETIME'] . '</td><td>' . $draw['DRAW_NAME'] . '</td><td>' . $draw['TICKET_NUMBER'] . '</td></tr>';
                    } else {
                        $draws .= '<tr class="future_draw" title="Future Draw"><td>' . $draw['DRAW_DATETIME'] . '</td><td>' . $draw['DRAW_NAME'] . '</td><td>---</td></tr>';
                    }
                    $k++;
                }
            }

            if (!empty($getNextDrawTime)) {

                $nxtDrawDate = (!empty($getNextDrawTime[1]->DRAW_STARTTIME) ? date('d/m/Y', strtotime($getNextDrawTime[1]->DRAW_STARTTIME)) : '');
                $nxtDrawTime = (!empty($getNextDrawTime[1]->DRAW_STARTTIME) ? date('h:i A', strtotime($getNextDrawTime[1]->DRAW_STARTTIME)) : '');

                $expDDate1 = date('d-m-Y', strtotime(substr($getNextDrawTime[0]->DRAW_STARTTIME, 0, 10)));
                $expDTime1 = date('H:i:s', strtotime($getNextDrawTime[0]->DRAW_STARTTIME));
                $expDDate = explode('-', $expDDate1);
                $expDTime = explode(':', $expDTime1);
                $drawCountDownTime = $expDDate[2] . ',' . ($expDDate[1] - 1) . ',' . $expDDate[0] . ',' . $expDTime[0] . ',' . $expDTime[1] . ',' . $expDTime[2]; //'Y,m,d,h,m,s'	
                //$price =	(!empty($getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE)?explode(",",$getNextDrawTime[0]->GAME_TYPE_DRAW_PRICE):0);
                $price = (!empty($getNextDrawTime[0]->DRAW_PRICE) ? $getNextDrawTime[0]->DRAW_PRICE : 0);
                $status = array('status' => 'available',
                    'DRAW_ID' => $getNextDrawTime[0]->DRAW_ID,
                    'DRAW_NUMBER' => $getNextDrawTime[0]->DRAW_NUMBER,
                    'GAME_NO' => substr($getNextDrawTime[0]->DRAW_NUMBER, strlen($getNextDrawTime[0]->DRAW_NUMBER) - 5, 5),
                    'DRAW_PRICE' => (!empty($price) ? $price : '0'),
                    'DRAW_STARTTIME' => $getNextDrawTime[0]->DRAW_STARTTIME,
                    'COUNT_DOWN' => $drawCountDownTime,
                    'NXT_DRAW_DATE' => $nxtDrawDate,
                    'NXT_DRAW_TIME' => $nxtDrawTime,
                    'CUR_DRAW_TIME' => $curr_draw_time,
                    'NXT_SEL' => $draws
                );
                echo json_encode($status);
                exit;
            } else {
                $status = array('status' => 'Next draw not available', 'NXT_SEL' => $draws);
                echo json_encode($status);
                exit;
            }
        } else {
            $status = array('status' => 'Draw not available', 'NXT_SEL' => $draws);
            echo json_encode($status);
            exit;
        }
    }

    public function streaming_settings() {

		$streamingID = 1;
        $status      = !empty( $_POST['status'] ) ? $_POST['status'] : '';

		if( !empty( $status ) ) {

            $data['STREAMING_STATUS'] = ( $status == 'active' ) ? 1 : 0;
            $data['UPDATED_BY']       = $this->session->userdata('partnerusername');
            $result                   = $this->draw_model->updateStremingStatus($data, $streamingID);

            if ( $result ) {
                $data['message'] = ( $status == 'active' ) ? 'Streaming enabled.' : 'Streaming disabled.';
                $data['class']   = 'SuccessMsg';
            } else {
                $data['message'] = ( $status == 'active' ) ? 'Failed to enabled.' : 'Failed to disabled.';
                $data['class']   = 'ErrorMsg';
            }
			
			/** tracking info */
			$arrTraking["DATE_TIME"]     = date('Y-m-d h:i:s');
			$arrTraking["USERNAME"]      = $this->session->userdata('partnerusername');
			$arrTraking["ACTION_NAME"]   = "Streaming ON/OFF";
			$arrTraking["SYSTEM_IP"]     = $_SERVER['REMOTE_ADDR'];
			$arrTraking["REFERRENCE_NO"] = uniqid();
			$arrTraking["STATUS"]        = 1;
			$arrTraking["LOGIN_STATUS"]  = 1;
			$arrTraking["CUSTOM2"]       = 1;
			$arrTraking["CUSTOM1"]       = json_encode(array('formData' => $_REQUEST, 'msg' => $data['message']));
			$this->db2->insert("tracking", $arrTraking);
			echo json_encode($data); exit;
		}

		$dataInfo['streamingInfo'] = $this->draw_model->getStremingStatus($streamingID);
		$this->load->view("admin/result/streaming_settings", $dataInfo);
	}
	
	public function sales_settings() {
		$SETTING_ID = 1;
        $post       = $_POST;
        if( !empty( $post['submit'] ) ) {
    		if( !empty( $post['single'] ) && !empty( $post['double'] ) && !empty( $post['triple'] ) ) {
    			$data['SETTING_ID'] = 1;
    			$data['SINGLE'] = $post['single'];
    			$data['DOUBLE'] = $post['double'];
    			$data['TRIPLE'] = $post['triple'];
    			$data['UPDATED_BY'] = $this->session->userdata('partnerusername');
    			$result = $this->draw_model->updateSalesSettings($data, $SETTING_ID);
    			if ($result) {
    				$data['message'] = 'Settings updated.';
    				$data['class'] = 'SuccessMsg';
    			} else {
    				$data['message'] = 'Failed to Settings.';
    				$data['class']   = 'ErrorMsg';
    			}

    			/** tracking info */
    			$arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
    			$arrTraking["USERNAME"] = $this->session->userdata('partnerusername');
    			$arrTraking["ACTION_NAME"] = "Sale settings";
    			$arrTraking["SYSTEM_IP"] = $_SERVER['REMOTE_ADDR'];
    			$arrTraking["REFERRENCE_NO"] = uniqid();
    			$arrTraking["STATUS"] = 1;
    			$arrTraking["LOGIN_STATUS"] = 1;
    			$arrTraking["CUSTOM2"] = 1;
    			$arrTraking["CUSTOM1"] = json_encode(array('formData' => $_REQUEST, 'msg' => $data['message']));
    			$this->db2->insert("tracking", $arrTraking);
    			
    			//echo json_encode($data);exit;
    		} else {
                $data['message'] = 'All fields required.';
                $data['class']   = 'ErrorMsg';
            }
        }

		$data['salesInfo'] = $this->draw_model->getSalesSettings($SETTING_ID);
		
		$this->load->view("admin/result/sales_settings",$data);
	}
	
	public function logtracking(){
		if( isset($_REQUEST['date']) ){
			$date = date('Y-m-d',strtotime($_REQUEST['date']));
			$data['tracking'] = $this->draw_model->getTrackingInfo( $date,$_REQUEST['action']);
			$this->load->view('admin/result/tracking',$data);
		}exit;

	}

}

?>
    