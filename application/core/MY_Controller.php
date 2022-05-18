<?php

class MY_Controller extends CI_Controller {	
    function __construct() {
        parent::__construct();
        $this->load->model('common_model');  
        
        $this->user_type = $this->session->userdata('website_type');
        if (!$this->session->has_userdata('is_user_login')) {
            redirect('admin/auth', 'refresh');
        }
        
//        $user_details = $this->common_model->get_all_records('ci_users','id,is_active',array('id'=>$this->session->userdata('user_id')))->row();
//        if(!empty($user_details)){
//            if($user_details->is_active == 0){
//                redirect('auth/login', 'refresh');
//            }
//        }
        
    }

}
?>

