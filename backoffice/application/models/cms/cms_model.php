<?php
/*
  Class Name	: Cms_model
  Package Name  : CMS
  Purpose       : Handle all the database services related to Agent -> Agent
  Auther 	    : Azeem
  Date of create: Aug 02 2013
*/
class Cms_model extends CI_Model
{
	
	public function getAllStaticPages($limit,$start){
	
	   $query			 = $this->db2->query("select * from static_page limit $start,$limit");
	   $pageInfo		 = $query->result();
	   return $pageInfo;
	}
	
	public function getTotStaticPagesCount(){
	    $numGames = $this->db2->count_all_results('static_page');
	    return $numGames;
	}
	
	public function getMenuNameById($id){
	  $query 	 = $this->db2->query('select PAGE_NAME from static_page_master where  STATIC_PAGE_MASTER_ID = '.$id);
	  $menuInfo  =  $query->row();
	  return $menuInfo->PAGE_NAME;
	}
	
	public function getMenuInfoById($id){
	  $query 	 = $this->db2->query('select * from static_page_master where  STATIC_PAGE_MASTER_ID = '.$id);
	  $menuInfo  =  $query->row();
	  return $menuInfo;
	}
	
	public function getNewsInfoById($id){
	  $query 	 = $this->db2->query('select * from news where NEWS_ID = '.$id);
	  $newsInfo  =  $query->row();
	  return $newsInfo;
	}

	public function getLangInfoById($id){
		$res=$this->db2->query("Select * from locale where LOCALE_ID = $id");
        $langInfo  =  $res->row();
		return $langInfo;
	}
	
	public function getBannerInfoById($id){
	  	$res=$this->db2->query("Select * from banner_manager where BANNER_MANAGER_ID = $id");
        $bannerInfo  =  $res->row();
		return $bannerInfo;
	}
	
	public function getConfigInfoById($id){
	   $res=$this->db2->query("Select * from site_config where CONFIG_ID = $id");
       $configInfo  =  $res->row();
	   return $configInfo;
	}
	
	
	public function getLanguageNameByCode($id){
	  $query 		  = $this->db2->query('select LOCALE_NAME from locale where LOCALE_ID = '.$id);
	  $languageInfo   =  $query->row();
	  return $languageInfo->LOCALE_NAME;
	}
	
	public function getPageInfoById($pageid){
		$res=$this->db2->query("Select * from static_page where STATIC_PAGE_ID = $pageid");
        $pageInfo  =  $res->row();
		return $pageInfo;
    }
	
	public function insertPage($data){
	 $page_name 	= $data['PAGE_NAME'];
	 $page_lang 	= $data['PAGE_LANG'];
	 $page_visible 	= $data['PAGE_VISIBLE'];
	 $page_title	= $data['PATE_TITLE']; 
	 $page_content  = $data['PAGE_CONTENT'];
	 
	 $insertData = array(
		   'LOCALE_ID' => $page_lang,
		   'STATIC_PAGE_MASTER_ID' => $page_name ,
		   'STATIC_PAGE_TITLE' => $page_title,
		   'CONTENT_TEXT' => $page_content ,
		   'PAGE_VISIBLE_STATUS' => $page_visible,
	    );

		$res = $this->db->insert('static_page', $insertData); 
		if($res)
		$returnMsg  = "Sucessfully Inserted";
	    return $returnMsg;
			
	}
	
	public function insertLanguage($data){
	 $lang_name 	= $data['LANGUAGE'];
	 $lang_code 	= $data['LANGUAGE_CODE'];
	 
	 $insertData = array(
		   'LOCALE_NAME' => $lang_name,
		   'LOCALE_CODE' => $lang_code ,
	    );

		$res = $this->db->insert('locale', $insertData); 
		if($res)
		$returnMsg  = "Sucessfully Inserted";
	    return $returnMsg;
			
	}
	
	
	public function insertMenu($data){
	 
	 $menu_title 	= $data['MENU_TITLE'];
	 $parent_menu 	= $data['PARENT_MENU'];
	 
	 $insertData = array(
		   'PAGE_NAME' => $menu_title,
		   'PARENT_ID' => $parent_menu ,
	    );

		$res = $this->db->insert('static_page_master', $insertData); 
		if($res)
		$returnMsg  = "Sucessfully Inserted";
	    return $returnMsg;
			
	}
	
	
	public function insertNews($data){
	
	 $news_title 	= $data['NEWS_TITLE'];
	 $news_desc 	= $data['NEWS_DESC'];
	 $active_days 	= $data['ACTIVE_DAYS']*24;
	 $status  = 1;
	 $today = date("Y-m-d H:i:s");
	 $higlighted  = 0;

	 $insertData = array(
		   'NEWS_TITLE' => $news_title,
		   'NEWS_DESCRIPTION' => $news_desc ,
		   'STATUS' => $status ,
		   'CREATE_TIMESTAMP' => $today ,
		   'HIGHLIGHTED' => $higlighted ,
		   'ACTIVE_HOURS' => $active_days ,	
	    );

		$res = $this->db->insert('news', $insertData); 
		if($res)
		$returnMsg  = "Sucessfully Inserted";
	    return $returnMsg;
			
	}
	
	public function insertBanner($data){
		
		$postion  = explode("-",$data['BANNER_POSITION']);
		$ban_position_ID= $postion[0];
		$ban_position	= $postion[1];
		$ban_lang 		= $data['BANNER_LANGUAGE'];
	 	$ban_image	 	= $data['bannerImage'];
	 	$banner_link	= $data['BANNER_LINK']; 
		$created        = date("Y-m-d H:i:s");
		$modified       = date("Y-m-d H:i:s");
		$status         = 0;

		$insertData = array(
		   'BANNER_POSITION' => $ban_position,
		   'POSITION_ID' => $ban_position_ID,
		   'BANNER_IMAGE' => $ban_image,
		   'BANNER_URL' => $banner_link,
		   'STATUS' => $status,
		   'LOCALE_CODE' => $ban_lang,
		   'CREATED_TIMESTAMP' => $created,
		   'MODIFIED_TIMESTAMP' => $modified,				   
		 );
		 
		$res = $this->db->insert('banner_manager', $insertData); 
		if($res)
		$returnMsg  = "Sucessfully Inserted";
	    return $returnMsg;
	}
	
	
	public function updatePage($data){
		
		$page_name 		= $data['PAGE_NAME'];
		$page_lang 		= $data['PAGE_LANG'];
	 	$page_visible 	= $data['PAGE_VISIBLE'];
	 	$page_title		= $data['PATE_TITLE']; 
	 	$page_content   = $data['PAGE_CONTENT'];
		$page_id  		= $data['pageid'];


		$updateData = array(
				   'LOCALE_ID' => $page_lang,
				   'STATIC_PAGE_MASTER_ID' => $page_name,
				   'STATIC_PAGE_TITLE' => $page_title,
				   'CONTENT_TEXT' => $page_content,
				   'PAGE_VISIBLE_STATUS' => $page_visible,
				   
		 );
		 
		$this->db->where('STATIC_PAGE_ID', $page_id);
		$this->db->update('static_page', $updateData); 
		$status = 1;
		return $status; 
	}
	
	
	
	public function updateLanguage($data){
	
		$lang_name 		= $data['LANGUAGE'];
		$lang_code 		= $data['LANGUAGE_CODE'];
		$lang_id  		= $data['lang_id'];


		$updateData = array(
				   'LOCALE_NAME' => $lang_name,
				   'LOCALE_CODE' => $lang_code,
		 );
		 
		$this->db->where('LOCALE_ID', $lang_id);
		$this->db->update('locale', $updateData); 
		$status = 1;
		return $status; 	
	
	}
	
	public function updateMenu($data){
	
		$menu_title 	= $data['MENU_TITLE'];
		$parent_menu	= $data['PARENT_MENU'];
		$menu_id  		= $data['menu_id'];

		$updateData = array(
				   'PAGE_NAME' => $menu_title,
				   'PARENT_ID' => $parent_menu,
		 );
		 
		$this->db->where('STATIC_PAGE_MASTER_ID', $menu_id);
		$this->db->update('static_page_master', $updateData); 
		$status = 1;
		return $status; 	
	
	}
	
	public function updateNews($data){
	 
		$news_title 	= $data['NEWS_TITLE'];
		$news_desc		= $data['NEWS_DESC'];
		$active_days	= $data['ACTIVE_DAYS']*24;
		$news_id  		= $data['news_id'];
		
		$updateData = array(
				   'NEWS_TITLE' => $news_title,
				   'NEWS_DESCRIPTION ' => $news_desc,
				   'ACTIVE_HOURS' => $active_days,
		 );
		$this->db->where('NEWS_ID', $news_id);
		$this->db->update('news', $updateData); 
		$status = 1;
		return $status; 	
	}
	
	public function updateBanner($data){
		
		$postion  = explode("-",$data['BANNER_POSITION']);
		$ban_position_ID= $postion[0];
		$ban_position	= $postion[1];
		$ban_lang		= $data['BANNER_LANGUAGE'];
		$ban_link		= $data['BANNER_LINK'];
		$ban_image		= $data['bannerImage'];
		$banner_id  	= $data['banner_id'];
		
		$updateData = array(
			   'BANNER_POSITION' => $ban_position,
			   'POSITION_ID'     => $ban_position_ID,
			   'BANNER_IMAGE '   => $ban_image,
			   'BANNER_URL' 	 => $ban_link,
			   'LOCALE_CODE' 	 => $ban_lang,
		 );
		$this->db->where('BANNER_MANAGER_ID', $banner_id);
		$this->db->update('banner_manager', $updateData); 
		$status = 1;
		return $status; 	
	}
	
	
	public function updateConfig($data){
	 
	   $config_value	= $data['value'];
	   $config_id		= $data['id'];
	   
	   $updateData = array(
			   'VALUE' => $config_value,
		 );
		$this->db->where('CONFIG_ID', $config_id);
		$this->db->update('site_config', $updateData); 
		$status = 1;
		return $status; 	
	
	}
	
	public function activeNews($newsid,$mode){
	   
	    if($mode == 'deactive'){
		   $status  = 0;
		}else if($mode == 'active'){
		   $status  = 1; 
		}
	   
	    $updateData = array(
				   'STATUS' => $status,
		 );
		 
		$this->db->where('NEWS_ID', $newsid);
		$this->db->update('news', $updateData); 
		$status = 1;
		return $status;  
	
	}
	
	public function activeBanner($bannid,$status){
	   
	    $updateData = array(
				   'STATUS' => $status,
		 );
		 
		$this->db->where('BANNER_MANAGER_ID', $bannid);
		$this->db->update('banner_manager', $updateData); 
		$status = 1;
		return $status;  
	
	}
	
	
	public function highlightNews($newsid,$mode){
		 
		 $updateData = array(
				   'HIGHLIGHTED' => $mode,
		 );
		 
		$this->db->where('NEWS_ID', $newsid);
		$this->db->update('news', $updateData); 
		$status = 1;
		return $status;
	
	}
	
	public function getAllConfigValues(){
	   $query			 = $this->db2->query("select * from site_config");
	   $siteInfo		 = $query->result();
	   return $siteInfo;	
	}
	
	public function getAllMenu(){
	   $query			 = $this->db2->query("select * from static_page_master");
	   $menuInfo		 = $query->result();
	   return $menuInfo;
	}
	
	public function getAllNews(){
	   $query			 = $this->db2->query("select * from news");
	   $newsInfo		 = $query->result();
	   return $newsInfo;
	}
	
	public function getAllBanners(){
	   $query			 = $this->db2->query("select * from banner_manager");
	   $bannerInfo		 = $query->result();
	   return $bannerInfo;
	}
	
    public function getAllBannerPositions(){
	   $query			 	= $this->db2->query("select * from banner_positions");
	   $bannerPositionsInfo	= $query->result();
	   return $bannerPositionsInfo;
	}
	
	public function getAllLanguages(){
	   $query			 = $this->db2->query("select * from locale");
	   $langInfo		 = $query->result();
	   return $langInfo;
	}
	
	public function deletePage($id){
		$res  = $this->db->delete('static_page', array('STATIC_PAGE_ID' => $id)); 
		if($res)
		$returnMsg  = "Page deleted successfully";
		
		return $returnMsg;
	}
	
	public function deleteLanguage($id){
		$res  = $this->db->delete('locale', array('LOCALE_ID' => $id)); 
		if($res)
		$returnMsg  = "Deleted successfully";
		
		return $returnMsg;
	}
	
	public function deleteMenu($id){
		$res  = $this->db->delete('static_page_master', array('STATIC_PAGE_MASTER_ID' => $id)); 
		if($res)
		$returnMsg  = "Deleted successfully";
		
		return $returnMsg;
	}
	
	public function deleteNews($id){
		$res  = $this->db->delete('news', array('NEWS_ID' => $id)); 
		if($res)
		$returnMsg  = "Deleted successfully";
		
		return $returnMsg;
	}
	
	public function deleteBanner($id){
		$res  = $this->db->delete('banner_manager', array('BANNER_MANAGER_ID' => $id)); 
		if($res)
		$returnMsg  = "Deleted successfully";
		
		return $returnMsg;
	}
	
	public function getAllCategory(){
	   $query			 = $this->db2->query("select * from static_page_master where PARENT_ID = 0");
	   $menuInfo		 = $query->result();
	   foreach($menuInfo as $menu){
	   		$menuArray = $this->getCategoryTreeForParentId($menu->PARENT_ID);
	   }
	   echo "<pre>";
	   print_r($menuArray);
	}
	
	
	public function getCategoryTreeForParentId($parent_id = 0) {
		  $categories = array();
		  $this->db2->from('static_page_master');
		  $this->db2->where('PARENT_ID', $parent_id);
		  $result = $this->db2->get()->result();
		  foreach ($result as $mainCategory) {
			$category = array();
			$category['id'] = $mainCategory->STATIC_PAGE_MASTER_ID;
			$category['name'] = $mainCategory->PAGE_NAME;
			$category['parent_id'] = $mainCategory->PARENT_ID;
			$category['sub_categories'] = $this->getCategoryTreeForParentId($category['id']);
			$categories[$mainCategory->STATIC_PAGE_MASTER_ID] = $category;
		  }
		  return $categories;
	}
	
}