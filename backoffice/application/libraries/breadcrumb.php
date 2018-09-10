<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class breadcrumb{
	private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database(); 
    }
    public function getmenu($pts=null)
    {
        
        if($pts==null){
            $mainmenu="Agent Management";
            $submenu="Search Kiosk";
            $user=array('MAIN_MENU_NAME'=>$mainmenu,'SUB_MENU_NAME'=>$submenu);
            return (object) $user;
        }else{
            if($pts=="vdisd"){
                $mainmenu="Agent Management";
                $submenu="My Distributors";
                $user=array('MAIN_MENU_NAME'=>$mainmenu,'SUB_MENU_NAME'=>$submenu);
                return (object) $user;
            }elseif($pts=="vinpts"){
                $mainmenu="Agent Report";
                $submenu="In Points";
                $user=array('MAIN_MENU_NAME'=>$mainmenu,'SUB_MENU_NAME'=>$submenu);
                return (object) $user;
            }elseif($pts=="voutpts"){
                $mainmenu="Agent Report";
                $submenu="Out Points";
                $user=array('MAIN_MENU_NAME'=>$mainmenu,'SUB_MENU_NAME'=>$submenu);
                return (object) $user;
            }else{
                $sql_menudetails="select MAIN_MENU_NAME,SUB_MENU_NAME from main_menu_info m,sub_menu_info s where s.SUB_MENU_PARAM='".$pts."' and m.MAIN_MENU_ID=s.MAIN_MENU_ID";
                $query=$this->CI->db->query($sql_menudetails);
                $resQry = $query->row();
                if($resQry){
                return $resQry;
                }else{
                $user=array('MAIN_MENU_NAME'=>'','SUB_MENU_NAME'=>'');
                return (object) $user;    
                }
                
            }
        }
    }
}
?>