<?php
class Turnover_report_manager_model extends CI_Model {
	function __construct(){
		$this->load->database();
		$this->load->model('reports/turnover_report_model');
	}

	
	public function managePartnersTurnover($data){
		$response = array();
		$partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 11:
				$response = $this->turnover_report_model->getMainAgentTurnover($data);
				break;
			case 12:
				$response = $this->turnover_report_model->getDistributorTurnover($data);
				break;
			case 13:
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			case 15: 
				$response = $this->turnover_report_model->getSuperDistributorTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getMainAgentTurnover($data);
				break;		
		}
		return $response;
	}
	
	public function manageMainAgentTurnover($data){
		$response = array();
		$partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 12:
				$response = $this->turnover_report_model->getDistributorTurnover($data);
				break;
			case 13:
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			case 15: 
				$response = $this->turnover_report_model->getSuperDistributorTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getSuperDistributorTurnover($data);
				break;		
		}
		
		return $response;
	}
	
	public function manageSuperDistributorTurnover($data){
		$response = array();
		$partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 12:
				$response = $this->turnover_report_model->getDistributorTurnover($data);
				break;
			case 13:
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getDistributorTurnover($data);
				break;		
		}
		
		return $response;
	}
	
	
	public function manageDistributorTurnover($data){
		$response = array();
		$partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 13:
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;		
		}
		
		return $response;
	}
	
	public function manageSubDistributorTurnover($data){
		$response = array();

		$partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;		
		}
	
		return $response;
	}
	
	public function manageAgentTurnover($data){
		$response = array();
		$response = $this->turnover_report_model->getAgentTurnover($data);
		/* $partner_type = $data['PARTNER_TYPE'];
		switch($partner_type){
			case 11:
				$response = $this->turnover_report_model->getMainAgentTurnover($data);
				break;
			case 12:
				$response = $this->turnover_report_model->getDistributorTurnover($data);
				break;
			case 13:
				$response = $this->turnover_report_model->getSubDistributorTurnover($data);
				break;
			case 14:
				$response = $this->turnover_report_model->getAgentTurnover($data);
				break;
			case 15: 
				$response = $this->turnover_report_model->getSuperDistributorTurnover($data);
				break;
			default :
				$response = $this->turnover_report_model->getMainAgentTurnover($data);
				break;		
		} */
		
		return $response;
	}
	
	
	
}
?>
