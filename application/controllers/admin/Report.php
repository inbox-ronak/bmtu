<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
    parent::__construct();
    $this->dbTable = 'user_master';
    $this->member_type = 'member_type';
    $this->trade_partner = 'trade_partners';
    $this->type_of_business = 'type_of_business';
    $this->user_master = 'user_master';
    $this->payment_type = 'type_of_payable';
        $this->lang_helper = langArr();  
        $this->load->library('image_moo');   
    }

    public function Index(){
        $user_id=$_SESSION['user_id'];  

        if(!isset($user_id)) 
        {
            redirect('admin/login');
        }
        //echo 'hello';die;
        $permission = $this->permission->grant(REPORT,'view');
        if($permission == false)
        {
            redirect('admin/dashboard');
        }
        $data = array();
        $data['main_page'] = 'backend/report/list';
        $this->load->view('layout/template',$data);
    }
}
