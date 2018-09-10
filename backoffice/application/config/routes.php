<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|	
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login";
$route['404_override'] = '';

/*
   Custom router variables
   Needed for this application
*/


/* Marketing routing */
$route['marketing/campaign/index']       = "marketing/campaign/campaign/index";
$route['marketing/campaign']          = "marketing/campaign/campaign/index";
$route['marketing/campaign/addcampaign'] = "marketing/campaign/campaign/addcampaign";
$route['marketing/campaign/index/(:num)']= "marketing/campaign/campaign/index/(:num)";

/* Agent Partner routing */
/* $route['game/history']           = "games/shan/game/history";
$route['game/userhistory/(:num']           = "games/shan/game/userhistory/$1";
$route['gamedetails/view']           = "games/shan/gamedetails/view"; */

$route['partners/index']           = "partners/partners/index";
$route['partners']            = "partners/partners/index";
$route['partners/addpartner']          = "partners/partners/addpartner";
$route['partners/addUser']          = "partners/partners/addUser";
$route['partners/editPartner/(:num)']  = "partners/partners/editPartner/$1";
$route['partners/viewPartnerPlayers/(:num)']  = "partners/partners/viewPartnerPlayers/$1";
$route['partners/viewPartnerAdmins/(:num)']   = "partners/partner/viewPartnerAdmins/$1";
$route['partners/viewPlayers']          = "partners/partner/viewPlayers";
$route['partners/viewAdmins']          = "partners/partner/viewAdmins";
$route['partners/createUser']           = "partners/partners/createUser";
/* Partner routing */
$route['partner/index']           = "partner/partner/index";
$route['partner']            = "partner/partner/index";
$route['partner/addpartner']          = "partner/partner/addpartner";
$route['partner/index/(:num)']    = "partner/partner/index/(:num)";
$route['partner/viewPartner/(:num)']  = "partner/partner/viewPartner/$1";
$route['partner/editPartner/(:num)']  = "partner/partner/editPartner/$1";


/* Admin routing */
$route['admin/index']           = "partners/admin/index";
$route['admin']             = "partners/admin/index";
$route['admin/addadmin']           = "partners/admin/addadmin";
$route['admin/index/(:num)']    = "partners/admin/index/(:num)";
$route['admin/viewUser/(:num)']          = "partners/admin/viewUser/$1";
$route['admin/editAdmin/(:num)']      = "partners/admin/editAdmin/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */