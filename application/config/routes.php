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
| In some instances, however, you may want to re-map this relationship
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


$route['subscribers/(:any)'] = "subscribers_controller/$1";
$route['subscribers'] = "subscribers_controller";
$route['authentication/(:any)'] = "auth_controller/$1";
$route['authentication'] = "auth_controller";
$route['ajax_controller'] = "ajax_controller";
$route['ajax_controller/(:any)'] = "ajax_controller/$1";
$route['feed_controller'] = "feed_controller";
$route['partners/(:any)'] = "partners/$1";
$route['partners'] = "partners";
$route['cron'] = "cron_controller";
$route['admin'] = "admin";
$route['admin/(:any)'] = "admin/$1";
$route['(:any)'] = "main_controller/$1";
$route['default_controller'] = "main_controller";
$route['404_override'] = 'page_not_found';


// $route['default_controller'] = "main_controller";
// $route['404_override'] = '';
// $route['(administration/:any)'] = "administration/$1";
// $route['(:any)'] = "main_controller/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */