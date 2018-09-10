<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class assignroles {
	private $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database(); 
        
    }
    public function getmainmenu($userdata,$agent)
    { //echo $agent;
		if(isset($userdata['ADMIN_USER_ID'])){
		 $grp_main_menu_q="SELECT main_menu_info.MAIN_MENU_NAME ,main_menu_info.MAIN_MENU_ID ,main_menu_info.MAIN_MENU_ID AS Mid FROM
group_mp_main_menu_info RIGHT JOIN main_menu_info ON
(group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='' )
where main_menu_info.MENU_ROLE_STATUS in (0,2)";
		}
		elseif($userdata['isownpartner']==1){
		if($agent==1){
		$grp_main_menu_q="SELECT
		main_menu_info.MAIN_MENU_NAME
		,group_mp_main_menu_info.MAIN_MENU_ID
		,main_menu_info.MAIN_MENU_ID AS Mid
		FROM
		group_mp_main_menu_info
		INNER JOIN main_menu_info 
		ON (group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='".$userdata['groupid']."' ) AND main_menu_info.MAIN_MENU_NAME NOT IN('Balance Management','Mac Address  Activation')";
		}else{
		$grp_main_menu_q="SELECT
		main_menu_info.MAIN_MENU_NAME
		,group_mp_main_menu_info.MAIN_MENU_ID
		,main_menu_info.MAIN_MENU_ID AS Mid
		FROM
		group_mp_main_menu_info
		INNER JOIN main_menu_info 
		ON (group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='".$userdata['groupid']."')";
		}
		}
		else{
		$grp_main_menu_q="SELECT
		main_menu_info.MAIN_MENU_NAME
		,group_mp_main_menu_info.MAIN_MENU_ID
		,main_menu_info.MAIN_MENU_ID AS Mid
		FROM
		group_mp_main_menu_info
		INNER JOIN main_menu_info 
		ON (group_mp_main_menu_info.MAIN_MENU_ID = main_menu_info.MAIN_MENU_ID and group_mp_main_menu_info.GROUP_ID ='".$userdata['groupid']."' ) AND main_menu_info.MAIN_MENU_NAME NOT IN('Balance Management','Mac Address  Activation')";
		}
                //echo $grp_main_menu_q;
		$query=$this->CI->db->query($grp_main_menu_q);
		return $query->result();
		
}
public function getsubmenu($userdata,$Mid){
if(isset($userdata['ADMIN_USER_ID'])){
$sub_menu_list_query="SELECT sub_menu_info.SUB_MENU_NAME ,group_mp_sub_menu_info.SUB_MENU_ID ,sub_menu_info.SUB_MENU_ID AS Sid FROM group_mp_sub_menu_info RIGHT JOIN sub_menu_info ON (group_mp_sub_menu_info.SUB_MENU_ID = sub_menu_info.SUB_MENU_ID and group_mp_sub_menu_info.GROUP_ID ='') where sub_menu_info.MAIN_MENU_ID ='".$Mid."'";
}
elseif($userdata['partnerstatus']!=1){
		if($userdata['isownpartner']==1){
		$sub_menu_list_query="SELECT
		sub_menu_info.MAIN_MENU_ID,sub_menu_info.SUB_MENU_NAME
		, sub_menu_info.SUB_MENU_ID   AS Sid
		, sub_menu_info.SUB_MENU_ORDER
		, group_mp_sub_menu_info.SUB_MENU_ID
		
		, sub_menu_info.MAIN_MENU_ID
		FROM
		group_mp_sub_menu_info
		INNER JOIN sub_menu_info 
		ON (group_mp_sub_menu_info.SUB_MENU_ID = sub_menu_info.SUB_MENU_ID AND group_mp_sub_menu_info.GROUP_ID ='".$userdata['groupid']."'
		) where  sub_menu_info.MAIN_MENU_ID ='".$Mid."' and sub_menu_info.SUB_MENU_NAME not in('Create Distributor','My Distributors') order by sub_menu_info.SUB_MENU_ORDER
		";
		}
		else{
		$sub_menu_list_query="SELECT
		sub_menu_info.SUB_MENU_NAME
		, sub_menu_info.SUB_MENU_ID   AS Sid
		, sub_menu_info.SUB_MENU_ORDER
		, group_mp_sub_menu_info.SUB_MENU_ID
		
		, sub_menu_info.MAIN_MENU_ID
		FROM
		group_mp_sub_menu_info
		INNER JOIN sub_menu_info 
		ON (group_mp_sub_menu_info.SUB_MENU_ID = sub_menu_info.SUB_MENU_ID AND group_mp_sub_menu_info.GROUP_ID ='".$userdata['groupid']."'
		) where  sub_menu_info.MAIN_MENU_ID ='".$Mid."' and sub_menu_info.SUB_MENU_NAME not in('Create Distributor','My Distributors','Create Agent','Create Kiosk') order by sub_menu_info.SUB_MENU_ORDER
		";
		}
}
else
{
$sub_menu_list_query="SELECT
sub_menu_info.SUB_MENU_NAME
, sub_menu_info.SUB_MENU_ID   AS Sid
, sub_menu_info.SUB_MENU_ORDER
, group_mp_sub_menu_info.SUB_MENU_ID

, sub_menu_info.MAIN_MENU_ID
FROM
group_mp_sub_menu_info
RIGHT JOIN sub_menu_info 
ON (group_mp_sub_menu_info.SUB_MENU_ID = sub_menu_info.SUB_MENU_ID AND group_mp_sub_menu_info.GROUP_ID ='".$userdata['groupid']."'
) where  sub_menu_info.MAIN_MENU_ID ='".$Mid."' and sub_menu_info.SUB_MENU_NAME not in('Create Distributor','My Distributors','Create Agent','Create Kiosk')  order by sub_menu_info.SUB_MENU_ORDER";
}
	$query=$this->CI->db->query($sub_menu_list_query);
	return $query->result();
}

public function getsubmenuoptlistvalue($Sid){
$sub_menu_op_list_query="SELECT sub_menu_options_info.SUB_MENU_OP_NAME
, sub_menu_options_info.SUB_MENU_OP_ID AS Soid , group_sub_menu_option_info.GRP_OP_ID
FROM  group_sub_menu_option_info RIGHT JOIN  sub_menu_options_info ON (group_sub_menu_option_info.SUB_MENU_OP_ID = sub_menu_options_info.SUB_MENU_OP_ID)
WHERE (sub_menu_options_info.SUB_MENU_ID ='".$Sid."');";
$query=$this->CI->db->query($sub_menu_op_list_query);
return count($query->result());
}

public function getsubmenuoptlist($userdata,$Sid){
if(isset($userdata['ADMIN_USER_ID'])){
$sub_menu_op_list_query="SELECT
                    sub_menu_options_info.SUB_MENU_OP_NAME
                    , sub_menu_options_info.SUB_MENU_OP_ID AS Soid
                    , group_mp_sub_menu_option_info.GRP_MP_OP_ID
                FROM
                    group_mp_sub_menu_option_info
                    RIGHT JOIN sub_menu_options_info 
                        ON (group_mp_sub_menu_option_info.SUB_MENU_OP_ID = sub_menu_options_info.SUB_MENU_OP_ID)
                WHERE (sub_menu_options_info.SUB_MENU_ID ='".$Sid."' AND sub_menu_options_info.SUB_MENU_OP_NAME !='View') group by Soid;";
}elseif($userdata['partnerstatus']!=1){
$sub_menu_op_list_query="SELECT
                    sub_menu_options_info.SUB_MENU_OP_NAME
                    , sub_menu_options_info.SUB_MENU_OP_ID AS Soid
                    , group_sub_menu_option_info.GRP_OP_ID
                FROM
                     group_sub_menu_option_info
                    RIGHT JOIN  sub_menu_options_info 
                        ON (group_sub_menu_option_info.SUB_MENU_OP_ID = sub_menu_options_info.SUB_MENU_OP_ID)
                WHERE (sub_menu_options_info.SUB_MENU_ID ='".$Sid."');";					 
}
else
{
$sub_menu_op_list_query="SELECT
                    sub_menu_options_info.SUB_MENU_OP_NAME
                    , sub_menu_options_info.SUB_MENU_OP_ID AS Soid
                    , group_mp_sub_menu_option_info.GRP_MP_OP_ID
                FROM
                    group_mp_sub_menu_option_info
                    RIGHT JOIN sub_menu_options_info 
                        ON (group_mp_sub_menu_option_info.SUB_MENU_OP_ID = sub_menu_options_info.SUB_MENU_OP_ID)
                WHERE (sub_menu_options_info.SUB_MENU_ID ='".$Sid."' AND sub_menu_options_info.SUB_MENU_OP_NAME !='View') group by Soid;";					 
}	
$query=$this->CI->db->query($sub_menu_op_list_query);
return $query->result();
}

}
?>
