<?php
//error_reporting(E_ALL);
/*
  Class Name	: Ajax
  Package Name  : User
  Purpose       : Controller all the Ajax functionalitys related to Poker
  Auther 	    : Sivakumar
  Date of create: July 01 2014

*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends CI_Controller{
    
    function __construct(){
	  parent::__construct();
	  		$CI = &get_instance();
   			$this->db2 = $CI->load->database('db2', TRUE);
			$this->db3 = $CI->load->database('db3', TRUE);
	        $this->load->helper('url');
			$this->load->helper('functions');
			$this->load->library('session');
			$this->load->database();
			$this->load->library('pagination');
			$this->load->model('user/Account_model');	
			$this->load->model('reports/report_model');
			$this->load->model('partners/partner_model');
			$this->load->model('reports/agentreport_model');
			//player model
    }
	
	/*
	 Function Name: index
	 Purpose: This is the default method for this class
	*/
        
	public function index()
	{
		
		//if needed
	}//EO: index function
	
	
	public function getPartnersData($gameID,$sdate,$edate) {
           // echo $gameID;die;
                $sdate = str_replace("--"," ",$sdate);                
                $edate = str_replace("--"," ",$edate);
                
		$partnersData["partnersList"] = $this->report_model->getPartnersData($gameID,$sdate,$edate);
                $partnersData["sdate"] = $sdate;
                $partnersData["edate"] = $edate;
                //echo "<pre>";print_r($partnersData);die;
		$this->load->view('reports/partnerlist',$partnersData);	
	}	
	
	public function subgrid_report(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['GAMES_TYPE']= $this->input->get_post('GAMES_TYPE',TRUE);
			$data['AGENT_LIST']= $this->input->get_post('AGENT_LIST',TRUE);
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data["PARTNER_TYPE"] = $this->input->get_post('PARTNER_TYPE',TRUE);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersTurnover($data);
			//print_r($results); die;
			$self_results 	 = $results['self_results'];
			$session_partnertypeid = $this->session->userdata('partnertypeid');
			if($_REQUEST['PARTNER_TYPE'] != ''){
				if($_REQUEST['PARTNER_TYPE'] == 15){
					$_REQUEST['PARTNER_TYPE'] = 11;
				}elseif($_REQUEST['PARTNER_TYPE'] == 12){
					$_REQUEST['PARTNER_TYPE'] = 15;
				}elseif($_REQUEST['PARTNER_TYPE'] == 13){
					$_REQUEST['PARTNER_TYPE'] = 12;
				}elseif($_REQUEST['PARTNER_TYPE'] == 14){
					$_REQUEST['PARTNER_TYPE'] = 14;
				}else{
					$_REQUEST['PARTNER_TYPE'] =0;
				}
				
				$session_partnertypeid = $_REQUEST['PARTNER_TYPE'];
				
			}
			if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			//print_r($self_results);
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					
					if($session_partnertypeid==0 || $session_partnertypeid==''){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/magntreport/'.$self_results[$i]->MAIN_AGEN_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->MAIN_AGEN_NAME.'</a>';
						
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						if($self_results[$i]->NET)
						$partner_comm=$self_results[$i]->NET; 
						else
						$partner_comm="0.00";
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
					}
					
					if($session_partnertypeid==11){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/supdistreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
					
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
					
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
							else
								$commission="0.00";
									
								//$net=$totalbets-$totalwins;
								if($self_results[$i]->NET)
						$partner_comm=$self_results[$i]->NET; 
						else
						$partner_comm="0.00";
									
								//$resvalue['SNO']=$j+1;
								$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
								$resvalue['PARTNER']= $partnername;
								$resvalue['PLAYPOINTS'] = $totalbets;
								$resvalue['WINPOINTS']	= $totalwins;
								$resvalue['MARGIN'] = $commission;
								$resvalue['NET'] = $partner_comm;
					}
					
					if($session_partnertypeid==15){
						
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						if($self_results[$i]->NET)
						$partner_comm=$self_results[$i]->NET; 
						else
						$partner_comm="0.00";
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						
					}
					
					if($session_partnertypeid==12){
						//print_r($self_results);
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->SUBDISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUBDISTRIBUTOR_NAME.'</a>';
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						if($self_results[$i]->NET)
						$partner_comm=$self_results[$i]->NET; 
						else
						$partner_comm="0.00";
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						
					}
					
					if($session_partnertypeid==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						  
						if($self_results[$i]->NET)
						$partner_comm=$self_results[$i]->NET; 
						else
						$partner_comm="0.00";
							
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
					}							
					
					//$resvalue['NET'] = 100;
					
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
				//PRINT_R($arrs);
		  }else{
				$arrs="";
		  }		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $_GET['page']; 
			@$limit = $_GET['rows']; 
			
			if(@$_GET['sord']=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$_GET['sord']=='desc'){
				@$sord=SORT_DESC;
			} 
			@$sidx = @$_GET['sidx']; 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($_GET['sord']=='asc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_ASC);
				}elseif($_GET['sord']=='desc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_DESC);
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			foreach($arrs1 as $value){
				$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
				$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['MARGIN']."</cell>";
				$xmlres .= "<cell>". $value['NET']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			
			echo	$xmlres;
		} 
	 }
	 
	public function shan_subgrid_report(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
			
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			
			if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersShanTurnover($data);
			$self_results 	 = $results['self_results'];
			//print_r($results);

			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					
					if($this->session->userdata('partnertypeid')==0 || $this->session->userdata('partnertypeid')==''){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/magntshanreport/'.$self_results[$i]->MAIN_AGEN_ID.'?rid=77&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->MAIN_AGEN_NAME.'</a>';
						
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;						
					}
					
					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/shansupdistreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;							
					}
					
					if($this->session->userdata('partnertypeid')==15){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distshanreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
							
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;
					
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
							else
								$commission="0.00";
					
								//$net=$totalbets-$totalwins;
								$partner_comm=$self_results[$i]->NET;
					
								//$resvalue['SNO']=$j+1;
								$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
								$resvalue['PARTNER']= $partnername;
								$resvalue['PLAYPOINTS'] = $totalbets;
								$resvalue['WINPOINTS']	= $totalwins;
								$resvalue['TOTAL_RAKE']	= $totalrake;
								$resvalue['MARGIN'] = $commission;
								$resvalue['NET'] = $partner_comm;
								$resvalue['PLAYER_LOSS'] = $playerloss;
								$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;
					}
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;							
					}							
					
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  }else{
				$arrs="";
		  }		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $_GET['page']; 
			@$limit = $_GET['rows']; 
			
			if(@$_GET['sord']=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$_GET['sord']=='desc'){
				@$sord=SORT_DESC;
			} 
			@$sidx = @$_GET['sidx']; 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($_GET['sord']=='asc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_ASC);
				}elseif($_GET['sord']=='desc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_DESC);
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			foreach($arrs1 as $value){
				$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
				$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
				$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $value['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $value['NET']."</cell>";
				$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	 }	 
	
	 public function subgrid_gamewise_report(){
		 
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['gtype']			= $this->input->get_post('gtype',TRUE);
			
			$this->session->set_userdata(array('searchData'=>$data));
			
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			//print_r($data);
			$results = $this->agentreport_model->getPartnersTurnoverGameWise($data);
			$self_results 	 = $results['self_results'];
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			//echo'<pre>';print_r($self_results);exit;
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
				    
				    if($this->session->userdata('partnertypeid')==15){
				    	$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
				    	//get partner revenueshare
				    	//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
				    		
				    	$totalbets  = $self_results[$i]->totbet;
				    	$totalwins  = $self_results[$i]->totwin;
				    
				    	if($self_results[$i]->MARGIN)
				    		$commission=$self_results[$i]->MARGIN;
				    		else
				    			$commission="0.00";
				    
				    			//$net=$totalbets-$totalwins;
				    			$partner_comm=$self_results[$i]->NET;
				    				
				    			//$resvalue['SNO']=$j+1;
				    			$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
				    			$resvalue['PARTNER']= $partnername;
				    			$resvalue['PLAYPOINTS'] = $totalbets;
				    			$resvalue['WINPOINTS']	= $totalwins;
				    			$resvalue['MARGIN'] = $commission;
				    			$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
				    			$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
				    			$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
				    			$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
					
				}
		  }else{
				$arrs="";
		  }		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	} 
	
	public function shan_subgrid_gamewise_report(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['gtype']			= $this->input->get_post('gtype',TRUE);
			
			$this->session->set_userdata(array('searchData'=>$data));
			
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersTurnoverShanGameWise($data);
			$self_results 	 = $results['self_results'];
			
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
				    if($this->session->userdata('partnertypeid')==15){
				    	$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
				    	//get partner revenueshare
				    	//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
				    		
				    	$totalbets  = $self_results[$i]->totbet;
				    	$totalwins  = $self_results[$i]->totwin;
				    	$totalrake  = $self_results[$i]->TOTAL_RAKE;
				    
				    	if($self_results[$i]->MARGIN)
				    		$commission=$self_results[$i]->MARGIN;
				    		else
				    			$commission="0.00";
				    
				    			//$net=$totalbets-$totalwins;
				    			$partner_comm=$self_results[$i]->NET;
				    				
				    			//$resvalue['SNO']=$j+1;
				    			$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
				    			$resvalue['PARTNER']= $partnername;
				    			$resvalue['PLAYPOINTS'] = $totalbets;
				    			$resvalue['WINPOINTS']	= $totalwins;
				    			$resvalue['TOTAL_RAKE']	= $totalrake;
				    			$resvalue['MARGIN'] = $commission;
				    			$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
				    			$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
				    			$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
				    			$resvalue['NET'] = $partner_comm;
				    }
				    
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  }else{
				$arrs="";
		  }		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";				
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";				
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}	
	
	
	public function magntreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['magntid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		$results= $this->agentreport_model->getMgntTurnover($data);
		$agent_result = $results['magnt_result'];
		$dist_result=$results['supdist_result'];
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				
				$partnername	  = $agent_result[$i]->MAIN_AGEN_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				
				if($agent_result[$i]->MARGIN)
				$commission=$agent_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$agent_result[$i]->MAIN_AGEN_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
			
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
				
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	 }
	 
	public function magntshanreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['magntid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		$results= $this->agentreport_model->getMgntShanTurnover($data);
		
		$agent_result = $results['magnt_result'];
		$dist_result=$results['supdist_result'];;
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				
				$partnername	  = $agent_result[$i]->MAIN_AGEN_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$totalrake  = $agent_result[$i]->TOTAL_RAKE;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				
				
				if($agent_result[$i]->MARGIN)
				$commission=$agent_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$agent_result[$i]->MAIN_AGEN_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['TOTAL_RAKE']	= $totalrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;				
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
			
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
			$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
				
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	 }
	
	 public function supdistreport(){ 
	 	
	 
	 		$data["partner"]     	= $this->input->post('game');
	 		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
	 		$data['GAMES_TYPE']= $this->input->get_post('GAMES_TYPE',TRUE);
	 		$data['AGENT_LIST']= $this->input->get_post('AGENT_LIST',TRUE);
	 		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
	 		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
	 		$this->session->set_userdata(array('searchData'=>$data));
	 		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
	 
	 		$data['rid'] = $this->input->get_post('rid',TRUE);
	 		$data['magntid'] = $this->uri->segment(4,0);
	 		$data["partnertype"] = $this->session->userdata('partnertypeid');
			//echo'<pre>';print_r($this->uri->segment(4,0));exit;
	 		if (isset($_REQUEST['level']) && !empty($_REQUEST['level'])){
	 			$data['supdistid'] = $this->uri->segment(4,0);
	 			$results= $this->agentreport_model->getSupDistTurnover($data);
	 		}else{
	 			$results= $this->agentreport_model->getMgntTurnover($data);
	 		}
	 		$agent_result = $results['supdist_result'];
// 	 		$dist_result=$results['dist_result'];
	 		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
	 		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
	 		 if(count($agent_result)>0 && is_array($agent_result)){
	 			for($i=0;$i<count($agent_result);$i++){
	 				//get partner name
	 				
	 				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/supdistreport/'.$agent_result[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$agent_result[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
	 				if (isset($_REQUEST['level']) && !empty($_REQUEST['level'])){
	 					$partnername	  = $agent_result[$i]->SUPERDISTRIBUTOR_NAME;
	 				} 
	 				//get partner revenueshare
	 				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
	 					
	 				$totalbets  = $agent_result[$i]->totbet;
	 				$totalwins  = $agent_result[$i]->totwin;
	 
	 				if($agent_result[$i]->MARGIN)
	 					$commission=$agent_result[$i]->MARGIN;
	 					else
	 						$commission="0.00";
	 
	 						//$net=$totalbets-$totalwins;
	 						$partner_comm=$agent_result[$i]->NET;
	 							
	 						//$resvalue['SNO']=$j+1;
	 						$resvalue['PARTNER_ID'] =$agent_result[$i]->SUPERDISTRIBUTOR_ID;
	 						$resvalue['PARTNER']= $partnername;
	 						$resvalue['PLAYPOINTS'] = $totalbets;
	 						$resvalue['WINPOINTS']	= $totalwins;
	 						$resvalue['MARGIN'] = $commission;
	 						$resvalue['NET'] = $partner_comm;
	 							
	 						if($resvalue){
	 							$arrs[] = $resvalue;
	 						}

	 			} 
	 		}else{
	 			$arrs="";
	 		} 
	
	 		foreach($arrs as $key => $row){
	 			$volume[$key]  = $row['PLAYPOINTS'];
	 		}
	 			
	 		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
	 		array_pop($arrs);
	 
	 		@$page = $this->input->get_post('page',TRUE);
	 		@$limit = $this->input->get_post('rows',TRUE);
	 
	 		if(@$this->input->get_post('sord',TRUE)=='asc'){
	 			@$sord=SORT_ASC;
	 		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
	 			@$sord=SORT_DESC;
	 		}
	 		$sidx = $this->input->get_post('sidx',TRUE);
	 		if(!$sidx) $sidx =1;
	 
	 		if($sidx!='1'){
	 			if($this->input->get_post('sord',TRUE)=='asc'){
	 				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
	 				$arrs1 = $arrs;
	 			}elseif($this->input->get_post('sord',TRUE)=='desc'){
	 				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
	 				$arrs1 = $arrs;
	 			}
	 		}else{
	 			$arrs1 = $arrs;
	 		}
	 		
	 		$et = ">";
	 		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
	 		$xmlres .= "<rows>";
	 		$xmlres .= "<page>".$page."</page>";
	 		$xmlres .= "<total>".@$total_pages."</total>";
	 		$xmlres .= "<records>".@$count."</records>";
	 		foreach($arrs1 as $value){
	 			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
	 			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
	 			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
	 			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
	 			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
	 			$xmlres .= "<cell>". $value['NET']."</cell>";
	 			$xmlres .= "</row>";
	 		}
	 		$xmlres .= "</rows>";
			
	 		echo	$xmlres;
	 		//$this->load->view('reports/agent_dist_turnover',$data);
	}
	 
	public function shansupdistreport(){
	 		$data["partner"]     	= $this->input->post('game');
	 		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
	 		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
	 		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
	 		$this->session->set_userdata(array('searchData'=>$data));
	 		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
	 
	 		$data['rid'] = $this->input->get_post('rid',TRUE);
// 	 		$data['supdistid'] = $this->uri->segment(4,0);
	 		$data["partnertype"] = $this->session->userdata('partnertypeid');
	 		if (isset($_REQUEST['level']) && !empty($_REQUEST['level'])){
	 			$data['supdistid'] = $this->uri->segment(4,0);
	 			$results= $this->agentreport_model->getShanSupDistTurnover($data);
	 		}else{
	 			$data['magntid'] = $this->uri->segment(4,0);
	 			$results= $this->agentreport_model->getMgntShanTurnover($data);
	 		}
			
	 		$self_results = $results['supdist_result'];
	 		$dist_result=$results['dist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
	 		if(count($self_results)>0 && is_array($self_results)){
	 			for($i=0;$i<count($self_results);$i++){
	 				//get partner name
	 				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/shansupdistreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';;
	 				if (isset($_REQUEST['level']) && !empty($_REQUEST['level'])){
	 					$partnername	  = $self_results[$i]->SUPERDISTRIBUTOR_NAME;
	 				}
	 				//get partner revenueshare
	 				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
	 				
 						$totalbets  = $self_results[$i]->totbet;
 						$totalwins  = $self_results[$i]->totwin;
 						$totalrake  = $self_results[$i]->TOTAL_RAKE;
 				
 						if($self_results[$i]->MARGIN)
 							$commission=$self_results[$i]->MARGIN;
 							else
 								$commission="0.00";
 				
 								//$net=$totalbets-$totalwins;
 								$partner_comm=$self_results[$i]->NET;
 				
 								//$resvalue['SNO']=$j+1;
 								$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
 								$resvalue['PARTNER']= $partnername;
 								$resvalue['PLAYPOINTS'] = $totalbets;
 								$resvalue['WINPOINTS']	= $totalwins;
 								$resvalue['PLAYER_LOSS']	= $self_results[$i]->PLAYER_LOSS;;
 								$resvalue['TOTAL_RAKE']	= $totalrake;
 								$resvalue['MARGIN'] = $commission;
 								$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
 								$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
 								$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
 								$resvalue['NET'] = $partner_comm;
 								$resvalue['SETTLEMENT_AMOUNT'] = $self_results[$i]->SETTLEMENT_AMOUNT;
 				
 								if($resvalue){
 									$arrs[] = $resvalue;
 								}
	 					}
	 				}else{
	 					$arrs="";
	 				}
	 				
	 				foreach($arrs as $key => $row){
	 					$volume[$key]  = $row['PLAYPOINTS'];
	 				}
	 				
	 				$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
	 				array_pop($arrs);
	 				
	 				@$page = $this->input->get_post('page',TRUE);
	 				@$limit = $this->input->get_post('rows',TRUE);
	 				
	 				if(@$this->input->get_post('sord',TRUE)=='asc'){
	 					@$sord=SORT_ASC;
	 				}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
	 					@$sord=SORT_DESC;
	 				}
	 				$sidx = $this->input->get_post('sidx',TRUE);
	 				if(!$sidx) $sidx =1;
	 				
	 				
	 				if($sidx!='1'){
	 					if($this->input->get_post('sord',TRUE)=='asc'){
	 						//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
	 						$arrs1 = $arrs;
	 					}elseif($this->input->get_post('sord',TRUE)=='desc'){
	 						//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
	 						$arrs1 = $arrs;
	 					}
	 				}else{
	 					$arrs1 = $arrs;
	 				}
	 				
	 				$et = ">";
	 				$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
	 				$xmlres .= "<rows>";
	 				$xmlres .= "<page>".$page."</page>";
	 				$xmlres .= "<total>".@$total_pages."</total>";
	 				$xmlres .= "<records>".@$count."</records>";
	 				for($k=0;$k<count($arrs1);$k++){
	 					$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
	 					$xmlres .= "<cell><![CDATA[". $arrs1[$k]['PARTNER']."]]></cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['PLAYER_LOSS']."</cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
	 					//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
	 					//$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
	 					$xmlres .= "<cell>". $arrs1[$k]['SETTLEMENT_AMOUNT']."</cell>";
	 					$xmlres .= "</row>";
	 				}
 				$xmlres .= "</rows>";
 				echo	$xmlres;
	 		//$this->load->view('reports/agent_dist_turnover',$data);
	 }
	 
	public function magntdistreport(){
	 	
	
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		$data['AGENT_LIST'] 	= $this->input->get_post('AGENT_LIST',TRUE);
        $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['supdistid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		$results= $this->agentreport_model->getSupDistTurnover($data);
		$dist_result=$results['dist_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){ 
				//get partner name
				
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				
				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				if(!empty($dist_result[$i]->NET))
					$partner_comm=$dist_result[$i]->NET;   
				else
					$partner_comm="0.00";   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
			
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function magntdistshanreport(){
	 	
	
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['supdistid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		$results= $this->agentreport_model->getShanSupDistTurnover($data);
		$dist_result=$results['dist_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){ 
				//get partner name
				
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distshanreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=77&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$totalrake  = $dist_result[$i]->TOTAL_RAKE;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;				
				
				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$dist_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['TOTAL_RAKE']	= $totalrake;
				$resvalue['MARGIN'] = $commission;
			//	$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;				
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
			
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";			
			$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function distreport(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['distid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getDistributorTurnover($data);
		$dist_result=$results['dist_result'];
		$subdist_result=$results['subdist_result'];
		$agent_result = $results['distagnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){ 
				//get partner name
				
				$partnername	  = $dist_result[$i]->DISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				
				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$dist_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
		
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function distshanreport(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['distid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getDistributorShanTurnover($data);
		$dist_result=$results['dist_result'];
		$subdist_result=$results['subdist_result'];
		$agent_result = $results['distagnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){ 
				//get partner name
				
				$partnername	  = $dist_result[$i]->DISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$totalrake  = $dist_result[$i]->TOTAL_RAKE;	
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;							
				
				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$dist_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;    
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
				$resvalue['TOTAL_RAKE']	= $totalrake;						
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;				
									
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}		
		
		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}
		
		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
			$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";			
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function subdistreport(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		if($this->uri->segment(4,0)){
			$data['distid'] = $this->uri->segment(4,0);
		}else{
			$data['distid'] = $this->session->userdata('partnerid');
		}
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		if($_REQUEST['PARTNER_TYPE']==13){
			$partnerTypeId = 13;
			$data["PARTNER_TYPE"] =13;
		}else{
			$partnerTypeId = $this->session->userdata('partnertypeid');
		}
		if($partnerTypeId==13){
			$results= $this->agentreport_model->getSubDistributorTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorTurnover($data);
		}
		
		$subdist_result=$results['subdist_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($subdist_result)>0 && is_array($subdist_result)){
			for($i=0;$i<count($subdist_result);$i++){ 
				//get partner name
				$partnername	  = $subdist_result[$i]->SUBDISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $subdist_result[$i]->totbet;
				$totalwins  = $subdist_result[$i]->totwin;
				
				if($subdist_result[$i]->MARGIN)
				$commission=$subdist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$subdist_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue_subdist['PARTNER_ID'] =$subdist_result[$i]->SUBDISTRIBUTOR_ID;    
				$resvalue_subdist['PARTNER']= $partnername;
				$resvalue_subdist['PLAYPOINTS'] = $totalbets;
				$resvalue_subdist['WINPOINTS']	= $totalwins;
				$resvalue_subdist['MARGIN'] = $commission;
				$resvalue_subdist['NET'] = $partner_comm;
									
				if($resvalue_subdist){
					$arrsp[] = $resvalue_subdist;
				}
			}
		}else{
			$arrsp="";
		}		
		
		foreach($arrsp as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
		
		$arrsp[]= array_multisort($volume, SORT_DESC, $arrsp);
		array_pop($arrsp);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsp1 = $arrsp;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsp1 = $arrsp;
			}
		}else{
			$arrsp1 = $arrsp;
		}
		
		$et = ">";
		$xmlres_subdist = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_subdist .= "<rows>";
		$xmlres_subdist .= "<page>".$page."</page>";
		$xmlres_subdist .= "<total>".@$total_pages."</total>";
		$xmlres_subdist .= "<records>".@$count."</records>";
		foreach($arrsp1 as $value){
			$xmlres_subdist .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_subdist .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_subdist .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres_subdist .= "<cell>". $value['NET']."</cell>";
			$xmlres_subdist .= "</row>";
		}
		$xmlres_subdist .= "</rows>";	
		echo	$xmlres_subdist;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function subdistshanreport(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		if($this->uri->segment(4,0)){
			$data['distid'] = $this->uri->segment(4,0);
		}else{
			$data['distid'] = $this->session->userdata('partnerid');
		}
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		if($this->session->userdata('partnertypeid')==13){
			$results= $this->agentreport_model->getSubDistributorShanTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorShanTurnover($data);
		}
		
		$subdist_result=$results['subdist_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids'] = $this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($subdist_result)>0 && is_array($subdist_result)){
			for($i=0;$i<count($subdist_result);$i++){ 
				//get partner name
				$partnername	  = $subdist_result[$i]->SUBDISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $subdist_result[$i]->totbet;
				$totalwins  = $subdist_result[$i]->totwin;
				$totalrake  = $subdist_result[$i]->TOTAL_RAKE;
				$playerloss = $subdist_result[$i]->PLAYER_LOSS;
				$settleamount= $subdist_result[$i]->SETTLEMENT_AMOUNT;								
				
				if($subdist_result[$i]->MARGIN)
				$commission=$subdist_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$subdist_result[$i]->NET;   
											
				//$resvalue['SNO']=$j+1;
				$resvalue_subdist['PARTNER_ID'] =$subdist_result[$i]->SUBDISTRIBUTOR_ID;    
				$resvalue_subdist['PARTNER']= $partnername;
				$resvalue_subdist['PLAYPOINTS'] = $totalbets;
				$resvalue_subdist['WINPOINTS']	= $totalwins;
				$resvalue_subdist['TOTAL_RAKE']	= $totalrake;				
				$resvalue_subdist['MARGIN'] = $commission;
				$resvalue_subdist['NET'] = $partner_comm;
				$resvalue_subdist['PLAYER_LOSS'] = $playerloss;
				$resvalue_subdist['SETTLEMENT_AMOUNT'] = $settleamount;				
									
				if($resvalue_subdist){
					$arrsp[] = $resvalue_subdist;
				}
			}
		}else{
			$arrsp="";
		}		
		
		foreach($arrsp as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
		
		$arrsp[]= array_multisort($volume, SORT_DESC, $arrsp);
		array_pop($arrsp);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsp1 = $arrsp;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsp1 = $arrsp;
			}
		}else{
			$arrsp1 = $arrsp;
		}
		
		$et = ">";
		$xmlres_subdist = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_subdist .= "<rows>";
		$xmlres_subdist .= "<page>".$page."</page>";
		$xmlres_subdist .= "<total>".@$total_pages."</total>";
		$xmlres_subdist .= "<records>".@$count."</records>";
		foreach($arrsp1 as $value){
			$xmlres_subdist .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_subdist .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_subdist .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['PLAYER_LOSS']."</cell>";			
			$xmlres_subdist .= "<cell>". $value['TOTAL_RAKE']."</cell>";			
			$xmlres_subdist .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_subdist .= "<cell>". $value['NET']."</cell>";
			$xmlres_subdist .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_subdist .= "</row>";
		}
		$xmlres_subdist .= "</rows>";	
		echo	$xmlres_subdist;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function agent_report(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		$data['AGENT_LIST'] 	= $this->input->get_post('AGENT_LIST',TRUE);
		$data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->uri->segment(4,0))
			$data['distid'] = $this->uri->segment(4,0);
		else
			$data['distid'] = $this->session->userdata('partnerid');
		
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		
		if($_REQUEST['PARTNER_TYPE']==13){
			$partnerTypeId = 13;
			$data["PARTNER_TYPE"] =13;
		}else{
			$partnerTypeId = $this->session->userdata('partnertypeid');
		}
		
		if($partnerTypeId==13){
			$results= $this->agentreport_model->getSubDistributorTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorTurnover($data);
		}
		
		$agent_result = $results['distagnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/agentreport/'.$agent_result[$i]->PARTNER_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$agent_result[$i]->PARTNER_NAME.'</a>';
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				
				if($agent_result[$i]->MARGIN)
				$commission=$agent_result[$i]->MARGIN; 
				else
				$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				if(!empty($agent_result[$i]->NET))
					$partner_comm=$agent_result[$i]->NET;   	
				else
					$partner_comm="0.00";
											
				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;    
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
									
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}		
		
		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
		
		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
	
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{
			$arrsagnt1 = $arrsagnt;
		}
		
		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}

	public function agent_shan_report(){
		$data["partner"]     	= $this->input->post('game'); 
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->uri->segment(4,0))
			$data['distid'] = $this->uri->segment(4,0);
		else
			$data['distid'] = $this->session->userdata('partnerid');
		
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		if($this->session->userdata('partnertypeid')==13){
			$results= $this->agentreport_model->getSubDistributorShanTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorShanTurnover($data);
		}
		
		$agent_result = $results['distagnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/agentshanreport/'.$agent_result[$i]->PARTNER_ID.'?rid=77&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$agent_result[$i]->PARTNER_NAME.'</a>';
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$totalrake  = $agent_result[$i]->TOTAL_RAKE;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				
				
				if($agent_result[$i]->MARGIN)
					$commission=$agent_result[$i]->MARGIN; 
				else
					$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_result[$i]->NET;   
				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;    
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
				$resvalue_agnt['TOTAL_RAKE']	= $totalrake;	
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
				$resvalue_agnt['PLAYER_LOSS'] = $playerloss;
				$resvalue_agnt['SETTLEMENT_AMOUNT'] = $settleamount;					
									
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}		
		
		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
		
		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
	
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{
			$arrsagnt1 = $arrsagnt;
		}
		
		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYER_LOSS']."</cell>";			
			$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";						
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function subgrid_gamewise_magntsupdistreport(){
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);
	
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['GAMES_TYPE']= $this->input->get_post('GAMES_TYPE',TRUE);
			$data['AGENT_LIST']= $this->input->get_post('AGENT_LIST',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntSupDistTurnoverGameWise($data);
			$self_results 	 = $results['supdist_result'];
				
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/supdistreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&GAMES_TYPE='.$data['GAMES_TYPE'].'&AGENT_LIST='.$data['AGENT_LIST'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
	
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
						
					if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";
								
							//$net=$totalbets-$totalwins;
							$partner_comm=$self_results[$i]->NET;
	
							//$resvalue['SNO']=$j+1;
							$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
							$resvalue['PARTNER']= $partnername;
							$resvalue['PLAYPOINTS'] = $totalbets;
							$resvalue['WINPOINTS']	= $totalwins;
							$resvalue['MARGIN'] = $commission;
							$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
							$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
							$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
							$resvalue['NET'] = $partner_comm;
	
							if($resvalue){
								$arrs[] = $resvalue;
							}
				}
			}else{
				$arrs="";
			}
	
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
				
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
				
			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);
				
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;
	
				
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
				
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}
	
	public function subgrid_shangamewise_magntsupdistreport(){
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);
	
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
			$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntSupDistTurnoverShanGameWise($data);
			$self_results 	 = $results['supdist_result'];
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/shansupdistreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
	
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
					if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";
								
							//$net=$totalbets-$totalwins;
							$partner_comm=$self_results[$i]->NET;
							$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
							$resvalue['PARTNER']= $partnername;
							$resvalue['PLAYPOINTS'] = $totalbets;
							$resvalue['WINPOINTS']	= $totalwins;
							$resvalue['PLAYER_LOSS']	= $self_results[$i]->PLAYER_LOSS;;
							$resvalue['TOTAL_RAKE']	= $totalrake;
							$resvalue['MARGIN'] = $commission;
							$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
							$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
							$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
							$resvalue['NET'] = $partner_comm;
							$resvalue['SETTLEMENT_AMOUNT'] = $self_results[$i]->SETTLEMENT_AMOUNT;
							
							if($resvalue){
								$arrs[] = $resvalue;
							}
				}
			}else{
				$arrs="";
			}
	
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
				
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
				
			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);
				
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;
	
				
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
				
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
// 				$xmlres .= "<cell>". $arrs1[$k]['PLAYER_LOSS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}
	
	public function subgrid_gamewise_magntdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
            $data['AGENT_LIST'] 	= $this->input->get_post('AGENT_LIST',TRUE);
            $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntDistTurnoverGameWise($data);
			$self_results 	 = $results['dist_result'];
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&AGENT_LIST='.$data['AGENT_LIST'].'&GAMES_TYPE='.$data['GAMES_TYPE'].'&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
														
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					
					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
					else
					$commission="0.00"; 
					
					//$net=$totalbets-$totalwins;   
					$partner_comm=$self_results[$i]->NET;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
			}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}
	
	public function subgrid_shangamewise_magntdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntDistTurnoverShanGameWise($data);
// 			echo '<pre>';print_r($results);exit;
			$self_results 	 = $results['dist_result'];
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
														
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					$totalrake  = $self_results[$i]->TOTAL_RAKE;					
					
					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
					else
					$commission="0.00"; 
					
					//$net=$totalbets-$totalwins;   
					$partner_comm=$self_results[$i]->NET;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['TOTAL_RAKE']	= $totalrake;					
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
			}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";				
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}	
	
	public function subgrid_gamewise_agntdistreport(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getDistributorTurnoverGameWise($data);
			$self_results 	 = $results['dist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12){
					$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
														
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					
					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
					else
					$commission="0.00"; 
					
					//$net=$totalbets-$totalwins;   
					$partner_comm=$self_results[$i]->NET;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;
				    }
					
					
					
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  }else{
				$arrs="";
		  }		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			
			if($sidx!='1'){
			
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				
				$arrs1 = $arrs;
			}
			
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++)
			{
				
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			
			echo	$xmlres;
		} 
		
	 }
	
	
	public function subgrid_gamewise_distreport(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getDistributorTurnoverGameWise($data);
			$self_results 	 = $results['dist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}  
	 
	public function subgrid_gamewise_distshanreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getDistributorTurnoverShanGameWise($data);
			$self_results 	 = $results['dist_result'];
// 			echo '<pre>';print_r($self_results);exit;
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;						
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";										
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}  

	 public function subgrid_gamewise_magntreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['magntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntTurnoverGameWise($data);
			$self_results 	 = $results['magnt_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
														
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					
					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
					else
					$commission="0.00"; 
					
					//$net=$totalbets-$totalwins;   
					$partner_comm=$self_results[$i]->NET;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;
				    
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
		
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	 }
	 
	 public function subgrid_shan_gamewise_magntreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['magntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntTurnoverShanGameWise($data);
			$self_results 	 = $results['magnt_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
														
					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;
					$totalrake  = $self_results[$i]->TOTAL_RAKE;
					
					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN; 
					else
					$commission="0.00"; 
					
					//$net=$totalbets-$totalwins;   
					$partner_comm=$self_results[$i]->NET;   
												
					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;    
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
					$resvalue['TOTAL_RAKE']	= $totalrake;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;
				    
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
		
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	 }	 
	 
	 public function subgrid_gamewise_subdistreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			if($this->session->userdata('partnertypeid')==13){
				$results = $this->agentreport_model->getSubDistributorTurnoverGameWise($data);
			}else{
				$results = $this->agentreport_model->getDistributorTurnoverGameWise($data);
			}
			$self_results 	 = $results['subdist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						if(@$self_results[$i]->DISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->PARTNER_NAME){
							$partnername	  = $self_results[$i]->PARTNER_NAME;
						}
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						if(@$self_results[$i]->DISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						}elseif(@$self_results[$i]->PARTNER_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						}
						
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==13){
						$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}			
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}
	
	 public function subgrid_gamewise_subdistshanreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			if($this->session->userdata('partnertypeid')==13){
				$results = $this->agentreport_model->getSubDistributorTurnoverShanGameWise($data);
			}else{
				$results = $this->agentreport_model->getDistributorTurnoverShanGameWise($data);
			}
			$self_results 	 = $results['subdist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 ||$this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						if(@$self_results[$i]->DISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->PARTNER_NAME){
							$partnername	  = $self_results[$i]->PARTNER_NAME;
						}
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
												
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						if(@$self_results[$i]->DISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;    
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						}elseif(@$self_results[$i]->PARTNER_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						}
						
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;						
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==13){
						$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}			
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
		
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";						
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}
		
	public function subgrid_gamewise_agentreport(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type; die;
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			
			
			$this->session->set_userdata(array('searchData'=>$data));
			$data['agntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$self_results = $this->agentreport_model->getAgentTurnoverGameWise($data);
			//echo "<pre>"; print_r($self_results); die;
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==13 ||  $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  	}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}
	
	public function subgrid_shangamewise_agentreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type; die;
	
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['agntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$self_results = $this->agentreport_model->getAgentTurnoverShanGameWise($data);
			//echo "<pre>"; print_r($self_results); die;
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==13 ||  $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN; 
						else
							$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;						
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
					
					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
															
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$totalrake  = $self_results[$i]->TOTAL_RAKE;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN; 
						else
						$commission="0.00"; 
						
						//$net=$totalbets-$totalwins;   
						$partner_comm=$self_results[$i]->NET;   
													
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;    
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['TOTAL_RAKE']	= $totalrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }
														
					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  	}else{
				$arrs="";
		  	}		
		
			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}
			
			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);
			
			@$page = $this->input->get_post('page',TRUE); 
			@$limit = $this->input->get_post('rows',TRUE); 
			
			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			} 
			$sidx = $this->input->get_post('sidx',TRUE); 
			if(!$sidx) $sidx =1; 
			
			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}
			
			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";			
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";	
			echo	$xmlres;
		} 
	}	
	 
	public function agent_userreport(){
	 	
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$result = $this->agentreport_model->getAgentTurnover($data);
		}
		$agent_result=$result['agnt_result'];
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				$partnername	  = $agent_result[$i]->PARTNER_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$totalrake  = $agent_result[$i]->TOTAL_RAKE;
				
				if($agent_result[$i]->MARGIN)
					$commission=$agent_result[$i]->MARGIN; 
				else
					$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_result[$i]->NET;   
				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;    
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
				$resvalue_agnt['TOTAL_RAKE']	= $totalrake;
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
									
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}		
		
		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{
			
			$arrsagnt1 = $arrsagnt;
		}
		
		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			//$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
	}	
	 
	public function agent_shan_userreport(){
	 	
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);	
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$result = $this->agentreport_model->getShanAgentTurnover($data);
		}
		$agent_result=$result['agnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				$partnername	  = $agent_result[$i]->PARTNER_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
													
				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$totalrake  = $agent_result[$i]->TOTAL_RAKE;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				
				
				if($agent_result[$i]->MARGIN)
					$commission=$agent_result[$i]->MARGIN; 
				else
					$commission="0.00"; 
				
				//$net=$totalbets-$totalwins;   
				$partner_comm=$agent_result[$i]->NET;   
				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;    
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
				$resvalue_agnt['TOTAL_RAKE']	= $totalrake;
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
				$resvalue_agnt['PLAYER_LOSS'] = $playerloss;
				$resvalue_agnt['SETTLEMENT_AMOUNT'] = $settleamount;					
									
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}		
		
		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}
			
		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);
		
		@$page = $this->input->get_post('page',TRUE); 
		@$limit = $this->input->get_post('rows',TRUE); 
		
		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		} 
		$sidx = $this->input->get_post('sidx',TRUE); 
		if(!$sidx) $sidx =1; 
		
		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{
			
			$arrsagnt1 = $arrsagnt;
		}
		
		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";			
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYER_LOSS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";			
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
	}

	public function poker_subgrid_report(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');

		//echo $partner_type;

		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['agentid'] 	    = $this->input->get_post('agentid',TRUE);
            $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));

			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersPokerTurnover($data);
			$self_results 	 = $results['self_results'];
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name

					if($this->session->userdata('partnertypeid')==0 || $this->session->userdata('partnertypeid')==''){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/magntpokerreport/'.$self_results[$i]->MAIN_AGEN_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->MAIN_AGEN_NAME.'</a>';

						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;			
					}
//echo $this->session->userdata('partnertypeid'); die;
					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/superdistpokerreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;
						
						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
						$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;	
					}

					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						

						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
						$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['NET'] = $partner_comm;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;				
					}

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  }else{
				$arrs="";
		  }

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $_GET['page'];
			@$limit = $_GET['rows'];

			if(@$_GET['sord']=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$_GET['sord']=='desc'){
				@$sord=SORT_DESC;
			}
			@$sidx = @$_GET['sidx'];
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($_GET['sord']=='asc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_ASC);
				}elseif($_GET['sord']=='desc'){
					$arrs1 = array_sort($arrs, $sidx, SORT_DESC);
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			foreach($arrs1 as $value){
				$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
				$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
				$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
        		$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $value['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $value['NET']."</cell>";
				$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";	
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	 }	

	public function poker_subgrid_gamewise_report(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');

		//echo $partner_type;

		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['agentid'] 	    = $this->input->get_post('agentid',TRUE);
            $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
			$data['gtype']			= $this->input->get_post('gtype',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));

			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersPokerTurnoverGameWise($data);
			$self_results 	 = $results['self_results'];

			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					if($this->session->userdata('partnertypeid')==0){



						$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;
						$playerloss = $self_results[$i]->PLAYER_LOSS;
						$settleamount= $self_results[$i]->SETTLEMENT_AMOUNT;						

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
            			$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['NET'] = $partner_comm;
						$resvalue['PLAYER_LOSS'] = $playerloss;
						$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;							
				    }

					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = $self_results[$i]->SUPERDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
              			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
				    }

					if($this->session->userdata('partnertypeid')==15){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
						$commission="0.00";

						$partner_comm=$self_results[$i]->NET;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
              			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
				    }

					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
						$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
              			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
				    }

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  }else{
				$arrs="";
		  }

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}
	
	public function poker_subgrid_gamewise_agentreport(){
	
		$partner_type = $this->session->userdata('partnertypeid');
		//echo $partner_type; die;

		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['agntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');

			$self_results = $this->agentreport_model->getAgentPokerTurnoverGameWise($data);
			//echo "<pre>"; print_r($self_results); die;
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==13 ||  $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            $resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
						$commission=$self_results[$i]->MARGIN;
						else
						$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            $resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
		  	}else{
				$arrs="";
		  	}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
      			$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}

	public function poker_agent_userreport(){
	 	

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
			$this->session->set_userdata(array('searchData'=>$data));
			//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);
			$data['rid'] = $this->input->get_post('rid',TRUE);
			$data['agntid'] = $this->uri->segment(4,0);
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$result = $this->agentreport_model->getAgentPokerTurnover($data);
		}
		$agent_result=$result['agnt_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){
				//get partner name
				$partnername	  = $agent_result[$i]->PARTNER_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				

				if($agent_result[$i]->MARGIN)
					$commission=$agent_result[$i]->MARGIN;
				else
					$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$agent_result[$i]->NET;
				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
        $resvalue_agnt['TOTAL_RAKE'] =$agent_result[$i]->totrake;
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
				$resvalue_agnt['PLAYER_LOSS'] = $playerloss;
				$resvalue_agnt['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}

		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{

			$arrsagnt1 = $arrsagnt;
		}

		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";
		echo	$xmlres_agnt;
	}

	public function poker_agent_report(){
	 	

		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		$data['agentid'] = $this->input->get_post('agentid',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

	
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->uri->segment(4,0))
			$data['distid'] = $this->uri->segment(4,0);
		else
			$data['distid'] = $this->session->userdata('partnerid');

		$data["partnertype"] = $this->session->userdata('partnertypeid');
		if($this->session->userdata('partnertypeid')==13){
			$results= $this->agentreport_model->getSubDistributorPokerTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorPokerTurnover($data);
		}

		$agent_result = $results['distagnt_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0; $i<count($agent_result); $i++){
				//get partner name

				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/agentpokerreport/'.$agent_result[$i]->PARTNER_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$agent_result[$i]->PARTNER_NAME.'</a>';
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				

				if($agent_result[$i]->MARGIN)
				$commission=$agent_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$agent_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue_agnt['PARTNER_ID'] =$agent_result[$i]->PARTNER_ID;
				$resvalue_agnt['PARTNER']= $partnername;
				$resvalue_agnt['PLAYPOINTS'] = $totalbets;
				$resvalue_agnt['WINPOINTS']	= $totalwins;
        $resvalue_agnt['TOTAL_RAKE'] =$agent_result[$i]->totrake;
				$resvalue_agnt['MARGIN'] = $commission;
				$resvalue_agnt['NET'] = $partner_comm;
				$resvalue_agnt['PLAYER_LOSS'] = $playerloss;
				$resvalue_agnt['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue_agnt){
					$arrsagnt[] = $resvalue_agnt;
				}
			}
		}else{
			$arrsagnt="";
		}

		foreach($arrsagnt as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrsagnt[]= array_multisort($volume, SORT_DESC, $arrsagnt);
		array_pop($arrsagnt);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsagnt1 = $arrsagnt;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsagnt1 = $arrsagnt;
			}
		}else{
			$arrsagnt1 = $arrsagnt;
		}

		$et = ">";
		$xmlres_agnt = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_agnt .= "<rows>";
		$xmlres_agnt .= "<page>".$page."</page>";
		$xmlres_agnt .= "<total>".@$total_pages."</total>";
		$xmlres_agnt .= "<records>".@$count."</records>";
		foreach($arrsagnt1 as $value){
			$xmlres_agnt .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres_agnt .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_agnt .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";
		echo	$xmlres_agnt;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}

	 public function poker_subgrid_gamewise_subdistreport(){

		$partner_type = $this->session->userdata('partnertypeid');

		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['agentid'] 	    = $this->input->get_post('agentid',TRUE);
            $data['GAMES_TYPE'] 	= $this->input->get_post('GAMES_TYPE',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			if($this->session->userdata('partnertypeid')==13){
				$results = $this->agentreport_model->getSubDistributorPokerTurnoverGameWise($data);
			}else{
				$results = $this->agentreport_model->getDistributorPokerTurnoverGameWise($data);
			}
			$self_results 	 = $results['subdist_result'];

			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						if(@$self_results[$i]->DISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_NAME){
							$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						}elseif(@$self_results[$i]->PARTNER_NAME){
							$partnername	  = $self_results[$i]->PARTNER_NAME;
						}
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						if(@$self_results[$i]->DISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
						}elseif(@$self_results[$i]->SUBDISTRIBUTOR_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;
						}elseif(@$self_results[$i]->PARTNER_ID){
							$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						}

						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($this->session->userdata('partnertypeid')==13){
						$partnername	  = $self_results[$i]->SUBDISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->SUBDISTRIBUTOR_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($this->session->userdata('partnertypeid')==14){
						$partnername	  = $self_results[$i]->PARTNER_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;

						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->PARTNER_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
           				$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;


			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}

	public function poker_subdistreport(){
		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		if($this->uri->segment(4,0)){
			$data['distid'] = $this->uri->segment(4,0);
		}else{
			$data['distid'] = $this->session->userdata('partnerid');
		}
		$data["partnertype"] = $this->session->userdata('partnertypeid');

		if($this->session->userdata('partnertypeid')==13){
			$results= $this->agentreport_model->getSubDistributorPokerTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorPokerTurnover($data);
		}

		$subdist_result=$results['subdist_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($subdist_result)>0 && is_array($subdist_result)){
			for($i=0;$i<count($subdist_result);$i++){
				//get partner name
				$partnername	  = $subdist_result[$i]->SUBDISTRIBUTOR_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $subdist_result[$i]->totbet;
				$totalwins  = $subdist_result[$i]->totwin;
				$playerloss = $subdist_result[$i]->PLAYER_LOSS;
				$settleamount= $subdist_result[$i]->SETTLEMENT_AMOUNT;				

				if($subdist_result[$i]->MARGIN)
				$commission=$subdist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$subdist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue_subdist['PARTNER_ID'] =$subdist_result[$i]->SUBDISTRIBUTOR_ID;
				$resvalue_subdist['PARTNER']= $partnername;
				$resvalue_subdist['PLAYPOINTS'] = $totalbets;
				$resvalue_subdist['WINPOINTS']	= $totalwins;
        		$resvalue_subdist['TOTAL_RAKE'] = $subdist_result[$i]->totrake;
				$resvalue_subdist['MARGIN'] = $commission;
				$resvalue_subdist['NET'] = $partner_comm;
				$resvalue_subdist['PLAYER_LOSS'] = $playerloss;
				$resvalue_subdist['SETTLEMENT_AMOUNT'] = $settleamount;				

				if($resvalue_subdist){
					$arrsp[] = $resvalue_subdist;
				}
			}
		}else{
			$arrsp="";
		}

		foreach($arrsp as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrsp[]= array_multisort($volume, SORT_DESC, $arrsp);
		array_pop($arrsp);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrsp1 = $arrsp;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrsp1 = $arrsp;
			}
		}else{
			$arrsp1 = $arrsp;
		}

		$et = ">";
		$xmlres_subdist = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres_subdist .= "<rows>";
		$xmlres_subdist .= "<page>".$page."</page>";
		$xmlres_subdist .= "<total>".@$total_pages."</total>";
		$xmlres_subdist .= "<records>".@$count."</records>";
		foreach($arrsp1 as $value){
			$xmlres_subdist .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres_subdist .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres_subdist .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres_subdist .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres_subdist .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres_subdist .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres_subdist .= "<cell>". $value['NET']."</cell>";
			$xmlres_subdist .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres_subdist .= "</row>";
		}
		$xmlres_subdist .= "</rows>";
		echo	$xmlres_subdist;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}
	
	public function poker_magntreport(){
		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['magntid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');

		$results= $this->agentreport_model->getMgntPokerTurnover($data);
		$agent_result = $results['magnt_result'];
		$dist_result=$results['dist_result'];
//echo count($agent_result); die;
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){
				//get partner name

				$partnername	  = $agent_result[$i]->MAIN_AGEN_NAME;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $agent_result[$i]->totbet;
				$totalwins  = $agent_result[$i]->totwin;
				$playerloss = $agent_result[$i]->PLAYER_LOSS;
				$settleamount= $agent_result[$i]->SETTLEMENT_AMOUNT;				

				if($agent_result[$i]->MARGIN)
				$commission=$agent_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$agent_result[$i]->NET;

        $totalRake =$agent_result[$i]->totrake;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$agent_result[$i]->MAIN_AGEN_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        $resvalue['TOTAL_RAKE'] = $totalRake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;				

				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";	
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";

		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);
	 }

	public function poker_magntsuperdistreport() {
		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['magntid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');

		$results= $this->agentreport_model->getMgntPokerTurnover($data);
		$dist_result=$results['superdist_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){
				//get partner name

				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/superdistpokerreport/'.$dist_result[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->SUPERDISTRIBUTOR_NAME.'</a>';;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;

				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$dist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->SUPERDISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        		$resvalue['TOTAL_RAKE'] = $dist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;					
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>"; 
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;	
	}

	public function poker_magntdistreport(){
	 	

		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['magntid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');

		$results= $this->agentreport_model->getMgntPokerTurnover($data);
		$dist_result=$results['dist_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){
				//get partner name

				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distpokerreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';;
				//get partner revenueshare
				//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;

				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$dist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        $resvalue['TOTAL_RAKE'] = $dist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;					
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
      		$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>"; 
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}

	public function superdistpokerreport(){
	 	
		$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		$this->session->set_userdata(array('searchData'=>$data));

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['superdistid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getSuperDistributorPokerTurnover($data);
		$superdist_result=$results['superdist_result'];
		
		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);

		if(count($superdist_result)>0 && is_array($superdist_result)){
			for($i=0;$i<count($superdist_result);$i++){

				$partnername	  = $superdist_result[$i]->SUPERDISTRIBUTOR_NAME;
				$totalbets  = $superdist_result[$i]->totbet;
				$totalwins  = $superdist_result[$i]->totwin;
				$playerloss = $superdist_result[$i]->PLAYER_LOSS;
				$settleamount= $superdist_result[$i]->SETTLEMENT_AMOUNT;				

				if($superdist_result[$i]->MARGIN)
				$commission=$superdist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$superdist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$superdist_result[$i]->SUPERDISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        		$resvalue['TOTAL_RAKE'] = $superdist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
     		$xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}

	public function poker_superdistreport() {
	 	$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['superdistid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getSuperDistributorPokerTurnover($data);
		$dist_result=$results['dist_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){
				//get partner name
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distpokerreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';
				//$partnername	  = $dist_result[$i]->DISTRIBUTOR_NAME;
				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;				

				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$dist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        		$resvalue['TOTAL_RAKE'] = $dist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
     		 $xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;	
	}

	public function distpokerreport_superdist(){
	 	$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['distid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getDistributorPokerTurnover_superdist($data);
		$dist_result=$results['dist_result'];
		$subdist_result=$results['subdist_result'];
		$agent_result = $results['distagnt_result'];


		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);

		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distpokerreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';

				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;				

				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$dist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        		$resvalue['TOTAL_RAKE'] = $dist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
     		 $xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}

	public function distpokerreport(){
	 	$data["partner"]     	= $this->input->post('game');
		$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
		$data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
		//$data['loggedinPartnerIDs'] = $loggedinPartnerIDs;
		$this->session->set_userdata(array('searchData'=>$data));
		//$noOfRecords  = $this->agentreport_model->getSelfTurnoverCount($data);

		$data['rid'] = $this->input->get_post('rid',TRUE);
		$data['distid'] = $this->uri->segment(4,0);
		$data["partnertype"] = $this->session->userdata('partnertypeid');
		$results= $this->agentreport_model->getDistributorPokerTurnover($data);
		$dist_result=$results['dist_result'];
		$subdist_result=$results['subdist_result'];
		$agent_result = $results['distagnt_result'];

		$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();

		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);

		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){
				$partnername	  = $dist_result[$i]->DISTRIBUTOR_NAME;

				$totalbets  = $dist_result[$i]->totbet;
				$totalwins  = $dist_result[$i]->totwin;
				$playerloss = $dist_result[$i]->PLAYER_LOSS;
				$settleamount= $dist_result[$i]->SETTLEMENT_AMOUNT;				

				if($dist_result[$i]->MARGIN)
				$commission=$dist_result[$i]->MARGIN;
				else
				$commission="0.00";

				//$net=$totalbets-$totalwins;
				$partner_comm=$dist_result[$i]->NET;

				//$resvalue['SNO']=$j+1;
				$resvalue['PARTNER_ID'] =$dist_result[$i]->DISTRIBUTOR_ID;
				$resvalue['PARTNER']= $partnername;
				$resvalue['PLAYPOINTS'] = $totalbets;
				$resvalue['WINPOINTS']	= $totalwins;
        		$resvalue['TOTAL_RAKE'] = $dist_result[$i]->totrake;
				$resvalue['MARGIN'] = $commission;
				$resvalue['NET'] = $partner_comm;
				$resvalue['PLAYER_LOSS'] = $playerloss;
				$resvalue['SETTLEMENT_AMOUNT'] = $settleamount;	
				if($resvalue){
					$arrs[] = $resvalue;
				}
			}
		}else{
			$arrs="";
		}

		foreach($arrs as $key => $row){
			$volume[$key]  = $row['PLAYPOINTS'];
		}

		$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
		array_pop($arrs);

		@$page = $this->input->get_post('page',TRUE);
		@$limit = $this->input->get_post('rows',TRUE);

		if(@$this->input->get_post('sord',TRUE)=='asc'){
			@$sord=SORT_ASC;
		}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
			@$sord=SORT_DESC;
		}
		$sidx = $this->input->get_post('sidx',TRUE);
		if(!$sidx) $sidx =1;

		if($sidx!='1'){
			if($this->input->get_post('sord',TRUE)=='asc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
				$arrs1 = $arrs;
			}elseif($this->input->get_post('sord',TRUE)=='desc'){
				//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
				$arrs1 = $arrs;
			}
		}else{
			$arrs1 = $arrs;
		}

		$et = ">";
		$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
		$xmlres .= "<rows>";
		$xmlres .= "<page>".$page."</page>";
		$xmlres .= "<total>".@$total_pages."</total>";
		$xmlres .= "<records>".@$count."</records>";
		foreach($arrs1 as $value){
			$xmlres .= "<row id='".$value['PARTNER_ID']."'>";
			$xmlres .= "<cell><![CDATA[". $value['PARTNER']."]]></cell>";
			$xmlres .= "<cell>". $value['PLAYPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['WINPOINTS']."</cell>";
			$xmlres .= "<cell>". $value['PLAYER_LOSS']."</cell>";
     		 $xmlres .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres .= "<cell>". $value['MARGIN']."</cell>";
			//$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);
	}

	public function poker_subgrid_gamewise_superdistreport(){
		$partner_type = $this->session->userdata('partnertypeid');
		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['superdistid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getSuperDistributorPokerTurnoverGameWise($data);
			$self_results 	 = $results['superdist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            $resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}

	public function poker_subgrid_gamewise_distreport(){
		$partner_type = $this->session->userdata('partnertypeid');

		//echo $partner_type;
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getDistributorPokerTurnoverGameWise($data);
			$self_results 	 = $results['dist_result'];
			
			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==15 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
						$partnername	  = $self_results[$i]->DISTRIBUTOR_NAME;
						//get partner revenueshare
						//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);
						$totalbets  = $self_results[$i]->totbet;
						$totalwins  = $self_results[$i]->totwin;

						if($self_results[$i]->MARGIN)
							$commission=$self_results[$i]->MARGIN;
						else
							$commission="0.00";

						//$net=$totalbets-$totalwins;
						$partner_comm=$self_results[$i]->NET;
						//$resvalue['SNO']=$j+1;
						$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
						$resvalue['PARTNER']= $partnername;
						$resvalue['PLAYPOINTS'] = $totalbets;
						$resvalue['WINPOINTS']	= $totalwins;
            			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
						$resvalue['MARGIN'] = $commission;
						$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
						$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
						$resvalue['NET'] = $partner_comm;
				    }

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}

	public function poker_subgrid_gamewise_magntsuperdistreport() {
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['superdistid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntSuperDistTurnoverPokerGameWise($data);
			$self_results 	 = $results['superdist_result'];

			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distpokerreport/'.$self_results[$i]->SUPERDISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->SUPERDISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;

					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN;
					else
					$commission="0.00";

					//$net=$totalbets-$totalwins;
					$partner_comm=$self_results[$i]->NET;

					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->SUPERDISTRIBUTOR_ID;
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
          			$resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
			}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;


			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}	
	}

	public function poker_subgrid_gamewise_magntdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['distid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntDistTurnoverPokerGameWise($data);
			$self_results 	 = $results['dist_result'];

			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distpokerreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;

					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN;
					else
					$commission="0.00";

					//$net=$totalbets-$totalwins;
					$partner_comm=$self_results[$i]->NET;

					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->DISTRIBUTOR_ID;
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
          $resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
			}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;


			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        		$xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	}

	 public function poker_subgrid_gamewise_magntreport(){
	 	
		$partner_type = $this->session->userdata('partnertypeid');

		//echo $partner_type;

		$data['rid'] = $this->input->get_post('rid',TRUE);

		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id');
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			$data['magntid'] = $this->input->get_post('id');
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getMagntTurnoverPokerGameWise($data);
			$self_results 	 = $results['magnt_result'];

			$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
			if($loggedinPartnerIDs)
				$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){
					//get partner name
					$partnername	  = $self_results[$i]->MAIN_AGEN_NAME;
					//get partner revenueshare
					//$share	 = $this->Agent_model->getRevenueShareByPartnerId($results[$i]->partner_id);

					$totalbets  = $self_results[$i]->totbet;
					$totalwins  = $self_results[$i]->totwin;

					if($self_results[$i]->MARGIN)
					$commission=$self_results[$i]->MARGIN;
					else
					$commission="0.00";

					//$net=$totalbets-$totalwins;
					$partner_comm=$self_results[$i]->NET;

					//$resvalue['SNO']=$j+1;
					$resvalue['PARTNER_ID'] =$self_results[$i]->MAIN_AGEN_ID;
					$resvalue['PARTNER']= $partnername;
					$resvalue['PLAYPOINTS'] = $totalbets;
					$resvalue['WINPOINTS']	= $totalwins;
          $resvalue['TOTAL_RAKE'] = $self_results[$i]->totrake;
					$resvalue['MARGIN'] = $commission;
					$resvalue['MARGIN_PERCENTAGE'] = $self_results[$i]->MARGIN_PERCENTAGE;
					$resvalue['GAME_ID'] = $self_results[$i]->GAME_DESCRIPTION;
					$resvalue['TYPE'] = $self_results[$i]->PARTNER_COMMISSION_TYPE;
					$resvalue['NET'] = $partner_comm;

					if($resvalue){
						$arrs[] = $resvalue;
					}
				}
			}else{
				$arrs="";
		  	}

			foreach($arrs as $key => $row){
				$volume[$key]  = $row['PLAYPOINTS'];
			}

			$arrs[]= array_multisort($volume, SORT_DESC, $arrs);
			array_pop($arrs);

			@$page = $this->input->get_post('page',TRUE);
			@$limit = $this->input->get_post('rows',TRUE);

			if(@$this->input->get_post('sord',TRUE)=='asc'){
				@$sord=SORT_ASC;
			}elseif(@$this->input->get_post('sord',TRUE)=='desc'){
				@$sord=SORT_DESC;
			}
			$sidx = $this->input->get_post('sidx',TRUE);
			if(!$sidx) $sidx =1;

			if($sidx!='1'){
				if($this->input->get_post('sord',TRUE)=='asc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_ASC);
					$arrs1 = $arrs;
				}elseif($this->input->get_post('sord',TRUE)=='desc'){
					//$arrs1 = $this->array_sort($arrs, $sidx, SORT_DESC);
					$arrs1 = $arrs;
				}
			}else{
				$arrs1 = $arrs;
			}

			$et = ">";
			$xmlres = "<?xml version='1.0' encoding='utf-8'?$et\n";
			$xmlres .= "<rows>";
			$xmlres .= "<page>".$page."</page>";
			$xmlres .= "<total>".@$total_pages."</total>";
			$xmlres .= "<records>".@$count."</records>";
			for($k=0;$k<count($arrs1);$k++){
				$xmlres .= "<row id='".$arrs1[$k]['PARTNER_ID']."'>";
				$xmlres .= "<cell><![CDATA[". $arrs1[$k]['GAME_ID']."]]></cell>";
				$xmlres .= "<cell>". $arrs1[$k]['PLAYPOINTS']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['WINPOINTS']."</cell>";
        $xmlres .= "<cell>". $arrs1[$k]['TOTAL_RAKE']."</cell>";
        $xmlres .= "<cell>". $arrs1[$k]['MARGIN']."</cell>";
				//$xmlres .= "<cell>". $arrs1[$k]['NET']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['MARGIN_PERCENTAGE']."</cell>";
				$xmlres .= "<cell>". $arrs1[$k]['TYPE']."</cell>";
				$xmlres .= "</row>";
			}
			$xmlres .= "</rows>";
			echo	$xmlres;
		}
	 }	
		 
	public function array_sort($array, $on, $order=SORT_ASC){ 
			$new_array = array();
			$sortable_array = array();
			if (count($array) > 0) {
				foreach ($array as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $k2 => $v2) {
							if ($k2 == $on) {
								$sortable_array[$k] = $v2;
							}
						}
					} else {
						$sortable_array[$k] = $v;
					}
				}
				switch ($order) {
					case 4:
						asort($sortable_array);
					break;
					case 3:
						arsort($sortable_array);
					break;
				}
				foreach ($sortable_array as $k => $v) {
					$new_array[$k] = $array[$k];
				}
			}
			return $new_array;
	}
	
	
	public function partnerslist(){
		 $this->load->view('reports/partnerlist');  
	} 
	
}
/* End of file game.php */
/* Location: ./application/controllers/games/poker/game.php */