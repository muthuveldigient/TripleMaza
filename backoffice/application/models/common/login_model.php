<?php

ob_start();

class Login_model extends CI_Model {

    public function validate_login() {

        $this->load->database();
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = md5($this->security->xss_clean($this->input->post('password')));
        $this->db2->where('USERNAME', $username);
        $this->db2->where('PASSWORD', $password);
        $this->db2->where('ACCOUNT_STATUS', 1);
        $this->db2->where('ONLINE_AGENT_STATUS', 1);
        $query = $this->db2->get('admin_user');
        /*
          if($query->num_rows == 1) {
          $chkAccessIDs=$this->getDomainBasedPartnerIDs();
          $result      = $query->row();
          if($result->FK_PARTNER_ID!=ADMIN_ID) {
          if(in_array($result->FK_PARTNER_ID,$chkAccessIDs)) {
          $valid=1;
          } else {
          return false;
          }
          }
          }
         */
        $arrTraking["DATE_TIME"] = date('Y-m-d h:i:s');
        $arrTraking["USERNAME"] = $username;
        $arrTraking["ACTION_NAME"] = "Login";
        $arrTraking["SYSTEM_IP"] = $_SERVER['REMOTE_ADDR'];
        $arrTraking["REFERRENCE_NO"] = uniqid();
        $arrTraking["STATUS"] = 1;
        $arrTraking["LOGIN_STATUS"] = 1;
        $arrTraking["CUSTOM2"] = 1;

        if ($query->num_rows == 1) {
            $row = $query->row();

            //  echo "select FK_PARTNER_TYPE_ID from partner where PARTNER_ID='".$row->FK_PARTNER_ID."'"; die;
            $partnertypeid = $this->db2->query("select PASSWORD_RESET_STATUS,PARTNER_NAME,FK_PARTNER_TYPE_ID from partner where PARTNER_ID='" . $row->FK_PARTNER_ID . "'");
            $prow = $partnertypeid->row();
            $session_id = uniqid();


            $data = array(
                'session_id' => $session_id,
                'adminusername' => $row->USERNAME,
                'partnerusername' => $row->USERNAME,
                'partnerid' => $row->FK_PARTNER_ID,
                'partnerpassword' => $row->PASSWORD,
                'partnertransaction_password' => $row->TRANSACTION_PASSWORD,
                'adminuserid' => $row->ADMIN_USER_ID,
                'partnertypeid' => (!empty($prow->FK_PARTNER_TYPE_ID)?$prow->FK_PARTNER_TYPE_ID:''),
                'is_admin_user' => $row->IS_ADMIN_USER,
                'partnerstatus' => $row->STATUS,
				'password_reset_status'	  => $prow->PASSWORD_RESET_STATUS,
                'partnername' => (!empty($prow->PARTNER_NAME)?$prow->PARTNER_NAME:'')
            );

            $this->db->query("update admin_user set SESSION_ID='" . $this->session->userdata('session_id') . "' where ADMIN_USER_ID='" . $row->ADMIN_USER_ID . "'");
            $this->session->set_userdata($data);

            $arrTraking["CUSTOM1"] = json_encode(array('formData' => $_REQUEST, 'message' => 'Login success'));
            $this->db->insert("tracking", $arrTraking);

            #Check search users
            /* $query1=$this->db->query("SELECT
              group_mp_sub_menu_info.GROUP_ID as groupid
              FROM
              group_mp_sub_menu_info
              INNER JOIN sub_menu_info
              ON (group_mp_sub_menu_info.SUB_MENU_ID = sub_menu_info.SUB_MENU_ID)
              WHERE (group_mp_sub_menu_info.GROUP_ID ='".$row->GROUP_ID."' AND sub_menu_info.MAIN_MENU_ID='5')
              ORDER BY sub_menu_info.SUB_MENU_ORDER ASC;");
              $query1->result();
              $row1 = $query1->row();

              if($row1->groupid!=''){
              $chk="5";
              } */
            return true;
        }
        $arrTraking["CUSTOM1"] = json_encode(array('formData' => $_REQUEST, 'message' => 'Login failure'));
        $this->db->insert("tracking", $arrTraking);
        return false;
    }

    public function getDomainBasedPartnerIDs() {
        $domainName = $_SERVER['SERVER_NAME'];
        $partner_id = $this->config->item($domainName);
        $partner_type_id = 11;
        if (is_array($partner_id)) {
            foreach ($partner_id as $key => $value) {
                $partnerids[] = $value;
            }
        } else {
            $partnerids[] = $partner_id;
        }

        if ($partner_type_id == "11") {
            $this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
            $this->db2->where_in("FK_PARTNER_ID", $partner_id);
            $this->db2->where("FK_PARTNER_TYPE_ID", 15);
            $supdistributorIds = $this->db2->get();
            $supdistributor_result = $supdistributorIds->result();
            if ($supdistributor_result) {
                $supdistributorids = array();
                foreach ($supdistributor_result as $value) {
                    $partnerids[] = $value->PARTNER_ID;
                    $supdistributorids[] = $value->PARTNER_ID;
                }
            }
            if ($supdistributorids) {
                $this->db2->select("PARTNER_ID")->from("partner");
                $this->db2->where_in("FK_PARTNER_ID", $supdistributorids);
                $this->db2->where("FK_PARTNER_TYPE_ID", 12);
                $distributorIds = $this->db2->get();
                $distributor_result = $distributorIds->result();
                if ($distributor_result) {
                    $distributorids = array();
                    foreach ($distributor_result as $value) {
                        $partnerids[] = $value->PARTNER_ID;
                        $distributorids[] = $value->PARTNER_ID;
                    }
                }
            }
            if (@$partnerids) {
                $this->db2->select("PARTNER_ID")->from("partner");
                $this->db2->where_in("FK_PARTNER_ID", $partnerids);
                $this->db2->where("FK_PARTNER_TYPE_ID", 13);
                $subdistributorIds = $this->db2->get();
                $subdistributor_result = $subdistributorIds->result();
                if ($subdistributor_result) {
                    $subdistids = array();
                    foreach ($subdistributor_result as $value) {
                        $partnerids[] = $value->PARTNER_ID;
                        $subdistids[] = $value->PARTNER_ID;
                    }
                }
                if ($subdistids) {
                    $this->db2->select("PARTNER_ID")->from("partner");
                    $this->db2->where_in("FK_PARTNER_ID", $subdistids);
                    $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                    $subdistributor_agentIds = $this->db2->get();
                    $subdistributor_agentresult = $subdistributor_agentIds->result();
                    if ($subdistributor_agentresult) {
                        foreach ($subdistributor_agentresult as $value) {
                            $partnerids[] = $value->PARTNER_ID;
                        }
                    }
                }
                if ($distributorids) {
                    $this->db2->select("PARTNER_ID")->from("partner");
                    $this->db2->where_in("FK_PARTNER_ID", $distributorids);
                    $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                    $distributor_agentIds = $this->db2->get();
                    $distributor_agentresult = $distributor_agentIds->result();
                    if ($distributor_agentresult) {
                        foreach ($distributor_agentresult as $value) {
                            $partnerids[] = $value->PARTNER_ID;
                        }
                    }
                }
            } else {
                $partnerids = '';
            }
        } elseif ($partner_type_id == "15") {
            $this->db2->select("PARTNER_USERNAME,PARTNER_ID")->from("partner");
            $this->db2->where_in("FK_PARTNER_ID", $partner_id);
            $this->db2->where("FK_PARTNER_TYPE_ID", 12);
            $distributorIds = $this->db2->get();
            $distributor_result = $distributorIds->result();
            if ($distributor_result) {
                $distributorids = array();
                foreach ($distributor_result as $value) {
                    $partnerids[] = $value->PARTNER_ID;
                    $distributorids[] = $value->PARTNER_ID;
                }
            }
            if (@$partnerids) {
                $this->db2->select("PARTNER_ID")->from("partner");
                $this->db2->where_in("FK_PARTNER_ID", $partnerids);
                $this->db2->where("FK_PARTNER_TYPE_ID", 13);
                $subdistributorIds = $this->db2->get();
                $subdistributor_result = $subdistributorIds->result();
                if ($subdistributor_result) {
                    $subdistids = array();
                    foreach ($subdistributor_result as $value) {
                        $partnerids[] = $value->PARTNER_ID;
                        $subdistids[] = $value->PARTNER_ID;
                    }
                }
                if ($subdistids) {
                    $this->db2->select("PARTNER_ID")->from("partner");
                    $this->db2->where_in("FK_PARTNER_ID", $subdistids);
                    $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                    $subdistributor_agentIds = $this->db2->get();
                    $subdistributor_agentresult = $subdistributor_agentIds->result();
                    if ($subdistributor_agentresult) {
                        foreach ($subdistributor_agentresult as $value) {
                            $partnerids[] = $value->PARTNER_ID;
                        }
                    }
                }
                if ($distributorids) {
                    $this->db2->select("PARTNER_ID")->from("partner");
                    $this->db2->where_in("FK_PARTNER_ID", $distributorids);
                    $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                    $distributor_agentIds = $this->db2->get();
                    $distributor_agentresult = $distributor_agentIds->result();
                    if ($distributor_agentresult) {
                        foreach ($distributor_agentresult as $value) {
                            $partnerids[] = $value->PARTNER_ID;
                        }
                    }
                }
            } else {
                $partnerids = '';
            }
        } elseif ($partner_type_id == "12") {
            $this->db2->select("PARTNER_ID")->from("partner");
            $this->db2->where_in("FK_PARTNER_ID", $partner_id);
            $this->db2->where("FK_PARTNER_TYPE_ID", 13);
            $subdistributorIds = $this->db2->get();
            $subdistributor_result = $subdistributorIds->result();
            if ($subdistributor_result) {
                $subdistids = array();
                foreach ($subdistributor_result as $value) {
                    $partnerids[] = $value->PARTNER_ID;
                    $subdistids[] = $value->PARTNER_ID;
                }
            }
            if ($subdistids) {
                $this->db2->select("PARTNER_ID")->from("partner");
                $this->db2->where_in("FK_PARTNER_ID", $subdistids);
                $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                $subdistributor_agentIds = $this->db2->get();
                $subdistributor_agentresult = $subdistributor_agentIds->result();
                if ($subdistributor_agentresult) {
                    foreach ($subdistributor_agentresult as $value) {
                        $partnerids[] = $value->PARTNER_ID;
                    }
                }
            }
            if ($partner_id) {
                $this->db2->select("PARTNER_ID")->from("partner");
                $this->db2->where_in("FK_PARTNER_ID", $partner_id);
                $this->db2->where("FK_PARTNER_TYPE_ID", 14);
                $distributor_agentIds = $this->db2->get();
                $distributor_agentresult = $distributor_agentIds->result();
                if ($distributor_agentresult) {
                    foreach ($distributor_agentresult as $value) {
                        $partnerids[] = $value->PARTNER_ID;
                    }
                }
            }
        } elseif ($partner_type_id == "13") {
            $this->db2->select("PARTNER_ID")->from("partner");
            $this->db2->where_in("FK_PARTNER_ID", $partner_id);
            $this->db2->where("FK_PARTNER_TYPE_ID", 14);
            $subdistributor_agentIds = $this->db2->get();
            $subdistributor_agentresult = $subdistributor_agentIds->result();
            if ($subdistributor_agentresult) {
                foreach ($subdistributor_agentresult as $value) {
                    $partnerids[] = $value->PARTNER_ID;
                }
            }
        } elseif ($partner_type_id == "14") {
            $partnerids[] = $partner_id;
        }
        if (@$partnerids == '') {
            $partnerids = -1;
        }
        $this->db->flush_cache();
        return $partnerids;
    }

    public function chkDashboardAccess($roleAccess) {
        $this->db2->select('ROLE_TO_ADMIN_ID')->from('role_to_admin');
        $this->db2->where('FK_ADMIN_USER_ID', $roleAccess["FK_ADMIN_USER_ID"]);
        $this->db2->where('FK_ROLE_ID', $roleAccess["FK_ROLE_ID"]);
        $browsesQL = $this->db2->get();
        return $browsesQL->result();
    }

}

?>