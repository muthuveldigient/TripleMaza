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
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersTurnover($data);
			$self_results 	 = $results['self_results'];
			//print_r($results);

			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					
					if($this->session->userdata('partnertypeid')==0 || $this->session->userdata('partnertypeid')==''){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/magntreport/'.$self_results[$i]->MAIN_AGEN_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->MAIN_AGEN_NAME.'</a>';
						
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
						$resvalue['NET'] = $partner_comm;
					}
					
					if($this->session->userdata('partnertypeid')==11){
						$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
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
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner"]     	= $this->input->post('game'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$this->session->set_userdata(array('searchData'=>$data));
			
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
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
		$data['rid'] = $this->input->get_post('rid',TRUE);
		
		if($this->input->get_post('keyword',TRUE)=="Search"){
			$data["partner_id"]     	= $this->input->get_post('id'); 
			$data['START_DATE_TIME']= $this->input->get_post('START_DATE_TIME',TRUE);
            $data['END_DATE_TIME'] 	= $this->input->get_post('END_DATE_TIME',TRUE);
			$data['gtype']			= $this->input->get_post('gtype',TRUE);
			
			$this->session->set_userdata(array('searchData'=>$data));
			
			$data["partnertype"] = $this->session->userdata('partnertypeid');
			$results = $this->agentreport_model->getPartnersTurnoverGameWise($data);
			$self_results 	 = $results['self_results'];
			
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
						$resvalue['GAME_ID'] = $self_results[$i]->GAME_ID;
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
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
	
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
		$dist_result=$results['dist_result'];
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($dist_result);$i++){ 
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
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
	
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
		$dist_result=$results['dist_result'];
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($dist_result);$i++){ 
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
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
				
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	 }
	
	
	public function magntdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
		$dist_result=$results['dist_result'];
		
		if(count($dist_result)>0 && is_array($dist_result)){
			for($i=0;$i<count($dist_result);$i++){ 
				//get partner name
				
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$dist_result[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$dist_result[$i]->DISTRIBUTOR_NAME.'</a>';;
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
	
	public function magntdistshanreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
		$dist_result=$results['dist_result'];
		
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
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function distreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
	
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
	
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
			$xmlres .= "<cell>". $value['NET']."</cell>";
			$xmlres .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";
			$xmlres .= "</row>";
		}
		$xmlres .= "</rows>";	
		echo	$xmlres;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function subdistreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
		$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
			$results= $this->agentreport_model->getSubDistributorTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorTurnover($data);
		}
		
		$subdist_result=$results['subdist_result'];
		
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids'] = $this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
			$xmlres_subdist .= "<cell>". $value['NET']."</cell>";
			$xmlres_subdist .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_subdist .= "</row>";
		}
		$xmlres_subdist .= "</rows>";	
		echo	$xmlres_subdist;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}	
	
	public function agent_report(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
			$results= $this->agentreport_model->getSubDistributorTurnover($data);
		}else{
			$results= $this->agentreport_model->getDistributorTurnover($data);
		}
		
		$agent_result = $results['distagnt_result'];
		
		if(count($agent_result)>0 && is_array($agent_result)){
			for($i=0;$i<count($agent_result);$i++){ 
				//get partner name
				
				$partnername	  = '<a href="'.base_url().'reports/agent_turnover/agentreport/'.$agent_result[$i]->PARTNER_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$agent_result[$i]->PARTNER_NAME.'</a>';
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
	
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
			$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
		//$this->load->view('reports/agent_dist_turnover',$data);  
	}
	
	public function subgrid_gamewise_magntdistreport(){
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
			$results = $this->agentreport_model->getMagntDistTurnoverGameWise($data);
			$self_results 	 = $results['dist_result'];
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					$partnername	  = '<a href="'.base_url().'reports/agent_turnover/distreport/'.$self_results[$i]->DISTRIBUTOR_ID.'?rid=62&sdate='.$data['START_DATE_TIME'].'&edate='.$data['END_DATE_TIME'].'&keyword=Search">'.$self_results[$i]->DISTRIBUTOR_NAME.'</a>';
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			
			
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==0){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type; die;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==13 ||  $this->session->userdata('partnertypeid')==0){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		$partner_type = $this->session->userdata('partnertypeid');
		
		//echo $partner_type; die;
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			if(count($self_results)>0 && is_array($self_results)){
				for($i=0;$i<count($self_results);$i++){ 
					//get partner name
					if($this->session->userdata('partnertypeid')==11 || $this->session->userdata('partnertypeid')==12 || $this->session->userdata('partnertypeid')==13 ||  $this->session->userdata('partnertypeid')==0){
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
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			$xmlres_agnt .= "<cell>". $value['TOTAL_RAKE']."</cell>";
			$xmlres_agnt .= "<cell>". $value['MARGIN']."</cell>";
			$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
	}	
	 
	public function agent_shan_userreport(){
	 	$loggedinPartnerIDs=$this->partner_model->loggedinPartnerIDs();
		
		if($loggedinPartnerIDs)
			$data['agentids']=$this->agentreport_model->getAgentIds($loggedinPartnerIDs);
		
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
			$xmlres_agnt .= "<cell>". $value['NET']."</cell>";
			$xmlres_agnt .= "<cell>". $value['SETTLEMENT_AMOUNT']."</cell>";			
			$xmlres_agnt .= "</row>";
		}
		$xmlres_agnt .= "</rows>";	
		echo	$xmlres_agnt;
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