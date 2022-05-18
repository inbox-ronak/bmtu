<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

require_once( BASEPATH .'database/DB.php' );
$db =& DB();
$db->select('page_id,page_slug');
$db->from('ci_pages');
$db->where('is_active', 1);
$query = $db->get();
$slug_list = $query->result();

$slug_list_array = array();
if(!empty($slug_list)){
    foreach($slug_list as $value){
        $slug_list_array[$value->page_id] = $value->page_slug;
    }
}

/* start tender controllers routes  */

// $route['tender'] = 'tender/tender_list';
$route['tender/(:any)'] = 'tender/tender_list/$1';
$route['all-bid-list/(:any)'] = 'tender/all_bid_tender_list/$1';
$route['add-tender'] = 'tender/index';
$route['delete-tender/(:any)'] = 'tender/delete_tender/$1';
//$route['add-tender'] = 'tender/Getonchange';
//$route['send_accepted_email_to_supplier'] = 'tender/send_accepted_email_to_supplier';
$route['save_tender'] = 'tender/save_tender';
$route['edit_save_tender/(:any)'] = "tender/edit_save_tender/$1";
$route['save_bid/(:any)'] = "tender/save_bid/$1";
$route['save_edit_tender/(:any)'] = 'tender/save_edit_tender';
$route['get-sub-category'] = 'tender/get_sub_category/$1';
$route['get-sub-category-edit'] = 'tender/get_sub_category_in_edit/$1';
$route['get-more-item'] = 'tender/add_more_items';
$route['get-more-item-edit'] = 'tender/add_more_items_edit';
$route['get-more-category'] = 'tender/add_more_category';
$route['get-more-category-edit'] = 'tender/add_more_category_edit';
$route['view-tender/(:any)'] = "tender/view_tender/$1";
// $route['view-bid/(:any)'] = "tender/view_bid/$1";
$route['edit-tender/(:any)'] = "tender/edit_tender/$1";
$route['bid-tender/(:any)'] = "tender/bid_tender/$1";
$route['remove-tender-item'] = "tender/remove_tender_item";
$route['awarded-tender/(:any)'] = "tender/won_tender/$1";
$route['won-tender/(:any)'] = "tender/won_tender/$1";
$route['supplier-bid-view/(:any)'] = "tender/supplier_bid_view/$2";
$route['view-bid/(:any)'] = "tender/bid_view/$2";
$route['edit-bid-view/(:any)'] = "tender/edit_bid_view/$2";
$route['bid-accept'] = "tender/accept_bid/$2";
$route['tmp-email'] = "tender/send_accepted_email";
$route['edit_save_bid/(:any)'] = "tender/edit_save_bid/$1";
$route['tmp-email-tender'] = "tender/send_verification_email";
$route['forgot-password'] = "login/forgot_password1";
$route['supplier-profile/(:any)/(:any)'] = "tender/supplier_profile_view/$1/$2";
$route['supplier-view-supplies/(:any)'] = "tender/supplier_equipment_view/$1";
$route['supplier-view-single-supplies/(:any)'] = "equipment/supplier_equipment_view/$1";
$route['accept-bid-document/(:any)'] = "tender/accept_bid_document/$1";
//$route['^(en|ar|ku)/search/(:any)'] = 'web/searchList/index/$2';

/* end tender controllers routes  */

/* dashboard */
$route['user/dashboard'] = 'dashboard';
$route['user/change-password'] = 'dashboard/change_password';
$route['change_password'] = 'dashboard/change_password_update';
$route['logout'] = 'login/logout';


//$route['register'] = 'register';
$route['register'] = 'register/new';
$route['subscribe-newsletter-email'] = 'welcome/subscribe_newsletter_email';
$route['save_new_form_data'] = 'register/save_new_form_data';
$route['edit_save_new_form_data/(:any)'] = 'register/edit_save_new_form_data/$1';
$route['register1'] = 'welcome/register';
$route['user_register'] = 'register/user_register';
$route['login'] = 'login';
$route['forgot_password'] = 'login/forgot_password';
$route['check-user-email'] = 'register/check_user_mail';
$route['register-form-data'] = 'register/register_form_data';
$route['register-get-sub-category'] = 'register/get_sub_category/$1';
//$route['login'] = 'login/user_auth';
$route['admin'] = 'admin/login';
// $route['blog-detail/(:any)'] = 'welcome/blog/$1';
// $route['our-services-detail/(:any)'] = 'welcome/our_servies/$1';
// $route['training-detail/(:any)'] = 'welcome/training/$1';
$route['verify-account(/:any)'] = "register/verify_account";
$route['send_verification_email'] = "register/send_verification_email";
$route['get_captcha_refresh'] = 'login/get_captcha_refresh';

$route['reset-password/(:any)'] = 'login/reset_password/$1';
$route['edit_details/(:any)'] = 'register/save_edit/$1';
$route['logout'] = 'login/logout';
$route['profile'] = 'register/myprofile';
$route['edit-profile'] = 'register/edit_profile';
$route['get-state'] = 'register/state_data_phone_code';
$route['get-edit-captcha'] = 'register/get_captcha_refresh';
$route['blog/(:any)'] = 'blog/index/$1';

$route['test-center'] = 'test_center';
$route['csb'] = 'Useful_link';
$route['silk-varities'] = 'silk_varities';
$route['how-to-buy-silk'] = 'how_to_buy_silk';

/* College Routes */
$route['program'] = 'Program';
$route['college'] = 'College';
$route['college_intake'] = 'CollegeIntake';
$route['department'] = 'Department';
$route['course_group'] = 'CourseGroup';
$route['course'] = 'Course';
$route['course_component'] = 'CourseComponent';
$route['semester'] = 'Semester';
// $routes->get('college-add', 'CollegeController::create');
// $routes->post('editCollege', 'CollegeController::edit');
// $routes->post('updateCollege', 'CollegeController::update');
// $routes->post('addCollege', 'CollegeController::store');
// $routes->get('college-list', 'CollegeController::index');
// $routes->get('deleteCollege/(:any)', 'CollegeController::destroy/$1');