<?php
class Campaign_model extends CI_Model {
	function __construct(){
		$this->load->database();
	}
		
    public function getCampaignTypes(){  
		$this->db2->where('PROMO_CAMPAIGN_TYPE_ID !=','');
        $this->db2->order_by('PROMO_CAMPAIGN_TYPE','asc');
        $browseSQL = $this->db2->get('promo_campaign_type');
        //echo $this->db->last_query();
		return $browseSQL->result();
	}

	public function getPartnerNames() {
		$this->db2->select('PARTNER_ID,PARTNER_NAME');
		$this->db2->where('PARTNER_ID !=','1');
		$browseSQL = $this->db2->get('partner');
		return $browseSQL->result();		
	}
	
	public function getCampaignStatus() {
		$this->db2->select('PROMO_STATUS_ID,PROMO_STATUS_DESC');
		$browseSQL = $this->db2->get('promo_status');
		return $browseSQL->result();		
	}
	
	public function addCampaign($data) {
		$browseSQL = $this->db->insert('promo_campaign',$data);
		return $this->db->insert_id();			
	}
	
	public function addCampaignPromoRule($data) {
		$browseSQL = $this->db->insert('promo_rule',$data);
		return $this->db->insert_id();		
	}
	
	public function getCampaignDataCount($searchData) {
		if($this->session->userdata('searchData')!="") {
			$searchData = $this->session->userdata('searchData');
		}
				
        $this->db2->select('t1.*,t2.PROMO_CAMPAIGN_TYPE,t3.PROMO_STATUS_DESC')->from('promo_campaign t1');
		$this->db2->join('promo_campaign_type t2', 't2.PROMO_CAMPAIGN_TYPE_ID = t1.PROMO_CAMPAIGN_TYPE_ID', 'left');
		$this->db2->join('promo_status t3', 't3.PROMO_STATUS_ID = t1.STATUS', 'left');		
		$this->db2->where('t1.PROMO_CAMPAIGN_ID !=','');

		if(!empty($searchData["PROMO_CAMPAIGN_TYPE_ID"]))
			$this->db2->where('t1.PROMO_CAMPAIGN_TYPE_ID', $searchData["PROMO_CAMPAIGN_TYPE_ID"]);
		if(!empty($searchData["PROMO_CAMPAIGN_NAME"]))
			$this->db2->like('t1.PROMO_CAMPAIGN_NAME', $searchData["PROMO_CAMPAIGN_NAME"]);
		if(!empty($searchData["PROMO_CAMPAIGN_CODE"]))
			$this->db2->like('t1.PROMO_CAMPAIGN_CODE', $searchData["PROMO_CAMPAIGN_CODE"]);
		if(!empty($searchData["PROMO_STATUS_ID"]))
			$this->db2->where('t1.PROMO_STATUS_ID', $searchData["PROMO_STATUS_ID"]);
											
		if(!empty($searchData["START_DATE_TIME"]) && ($searchData["END_DATE_TIME"])) {
			$this->db2->where('t1.START_DATE_TIME >=', date('Y-m-d',strtotime($searchData["START_DATE_TIME"])));
			$this->db2->where('t1.END_DATE_TIME <=', date('Y-m-d',strtotime($searchData["END_DATE_TIME"])));								
		}
			
        $browseSQL = $this->db2->get();
		//$this->db->last_query();
		return $browseSQL->num_rows();		
	}
	
	public function getCampainInfo($config,$searchData) {
		if($this->session->userdata('searchData')!="") {
			$searchData = $this->session->userdata('searchData');
		}

		$limit = $config["per_page"];
		$offset = $config["cur_page"];
				
        $this->db2->select('t1.*,t2.PROMO_CAMPAIGN_TYPE,t3.PROMO_STATUS_DESC')->from('promo_campaign t1');
		$this->db2->join('promo_campaign_type t2', 't2.PROMO_CAMPAIGN_TYPE_ID = t1.PROMO_CAMPAIGN_TYPE_ID', 'left');
		$this->db2->join('promo_status t3', 't3.PROMO_STATUS_ID = t1.STATUS', 'left');		
		$this->db2->where('t1.PROMO_STATUS_ID !=','');
		
		if(!empty($searchData["PROMO_CAMPAIGN_TYPE_ID"]))
			$this->db2->where('t1.PROMO_CAMPAIGN_TYPE_ID', $searchData["PROMO_CAMPAIGN_TYPE_ID"]);
		if(!empty($searchData["PROMO_CAMPAIGN_NAME"]))
			$this->db2->like('t1.PROMO_CAMPAIGN_NAME', $searchData["PROMO_CAMPAIGN_NAME"]);
		if(!empty($searchData["PROMO_CAMPAIGN_CODE"]))
			$this->db2->like('t1.PROMO_CAMPAIGN_CODE', $searchData["PROMO_CAMPAIGN_CODE"]);
		if(!empty($searchData["PROMO_STATUS_ID"]))
			$this->db2->where('t1.PROMO_STATUS_ID', $searchData["PROMO_STATUS_ID"]);			
		
		if(!empty($searchData["START_DATE_TIME"]) && ($searchData["END_DATE_TIME"])) {
			$this->db2->where('t1.START_DATE_TIME >=', date('Y-m-d',strtotime($searchData["START_DATE_TIME"])));
			$this->db2->where('t1.END_DATE_TIME <=', date('Y-m-d',strtotime($searchData["END_DATE_TIME"])));								
		}
				
        $this->db2->order_by($config['order_by'], $config['sort_order']);
        $this->db2->limit($limit,$offset);		
        $browseSQL = $this->db2->get();
		//echo $this->db->last_query();
		return $browseSQL->result();		
	}

	public function viewCampaign($campaignID) {
        $this->db2->select('t1.*,t2.PROMO_CAMPAIGN_TYPE,t3.PARTNER_NAME,t4.*')->from('promo_campaign t1');
		$this->db2->join('promo_campaign_type t2', 't2.PROMO_CAMPAIGN_TYPE_ID = t1.PROMO_CAMPAIGN_TYPE_ID', 'left');
		$this->db2->join('partner t3', 't3.PARTNER_ID = t1.PARTNER_ID', 'left');		
		$this->db2->join('promo_rule t4', 't4.PROMO_CAMPAIGN_ID = t1.PROMO_CAMPAIGN_ID', 'left');
		$this->db2->where('t1.PROMO_CAMPAIGN_ID =',$campaignID);
        $browseSQL = $this->db2->get();
		//$this->db->last_query();		
		return $browseSQL->result();
	}
	
	public function changeCampaignStatus($campaignData) {
		$this->db->where('PROMO_CAMPAIGN_ID',$campaignData["PROMO_CAMPAIGN_ID"]);
		$this->db->update('promo_campaign',$campaignData);
		return $this->db->affected_rows();	
	}
	
	/* BELOW ARE THE FUNCTIONS TO BE USED FROM THE SITE */	
	public function getCampaignIDTYPE($campaignCODE) {
		$this->db2->select('PROMO_CAMPAIGN_ID,PROMO_CAMPAIGN_TYPE_ID,PARTNER_ID')->from('promo_campaign');	
		$this->db2->where('PROMO_CAMPAIGN_CODE',$campaignCODE);
		$browseSQL = $this->db2->get();
		return $browseSQL->result();		
	}
	
	public function updateCampaignClicksDataCount($campaignID) {
		$promClicksData = array('PROMO_CAMPAIGN_ID'=>$campaignID,
								'CLICKED_ON'=>date('Y-m-d h:i:s')
							);
		$browseSQL = $this->db->insert('promo_clicks',$promClicksData);
		echo $this->db->last_query();
		return $this->db->insert_id();			
	}
	
	public function chkCampaignStatus($campaignID) {
		$this->db2->select('PROMO_CAMPAIGN_ID,PARTNER_ID,STATUS,START_DATE_TIME,END_DATE_TIME,EXP_USER_MAX,COST_PER_USER')->from('promo_campaign');
		$this->db2->where('PROMO_CAMPAIGN_ID',$campaignID);
		$browseSQL = $this->db2->get();
		return $browseSQL->row();
	}
	
	public function getCampaignUsedCount($campaignID) {
		$this->db2->select('PROMO_CAMPAIGN_ID')->from('campaign_to_user');
		$this->db2->where('PROMO_CAMPAIGN_ID',$campaignID);
		return $this->db2->count_all_results();
	}
	/* BELOW ARE THE FUNCTIONS TO BE USED FROM THE SITE */	
	
}
?>