<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
       
        parent::__construct();
        $this->lang_helper = langArr();  
    }
    public function index() {
        $get_setting = $this->common_model->getRows('ci_setting','*');
        $data['post_hidden_tab'] = ($this->session->userdata('hidden_tab_session')) ? $this->session->userdata('hidden_tab_session') : 'general_settings';
        $data['title'] = 'Settings';
        $data['main_page'] = 'backend/setting/general';
        $data['setting_data'] = $get_setting;
        $tbl_details = array();
        if (!empty($get_setting)) {
            foreach ($get_setting as $key => $value) {
                $tbl_details[$value['setting_key']] = $value['setting_value'];
            }
        }
        $data['posts'] = $tbl_details;
        $this->load->view('layout/template', $data);
    }

    public function update_settings() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

             //==== start Home Page Block Enable ======//
            if(!empty($_POST['home_page_block_enable'])){
               $_POST['home_page_block_enable'] = $_POST['home_page_block_enable'];
            }
            else{
                $_POST['home_page_block_enable'] = 0;
            }
              //==== end Home Page Block Enable ======//
            
            $this->form_validation->set_rules('facebook_link', 'Facebook Link', 'trim');
            $this->form_validation->set_rules('twitter_link', 'Twitter Link', 'trim');
            $this->form_validation->set_rules('linkedin_link', 'Linkedin Link', 'trim');
            $this->form_validation->set_rules('by_default_listing', 'By Default Listing', 'trim');
            $this->form_validation->set_rules('mail_sending_method', 'Mail Sending Method', 'trim|required');
            if ($this->input->post('mail_sending_method') == 'smtp') {
                $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required');
                $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required');
                $this->form_validation->set_rules('smtp_tls_ssl_opt', 'Select SMTP TLS/SSL', 'trim|required');
                $this->form_validation->set_rules('smtp_user', 'SMTP Username', 'trim|required');
                $this->form_validation->set_rules('smtp_pass', 'SMTP Password', 'trim|required');
            }
            $this->form_validation->set_rules('smtp_mail_from', 'Mail From', 'trim|required');
            $this->form_validation->set_rules('smtp_mail_from_name', 'Mail From Name', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->index();
            } else {


                
                if (isset($_FILES['site_logo']['name']) && $_FILES['site_logo']['name'] != "") {

                    if (!file_exists("assets/uploads/setting/")) {
                        mkdir("assets/uploads/setting", 0777);
                    }
                    $this->load->helper(array('form', 'url'));
                    $config['upload_path'] = 'assets/uploads/setting/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('site_logo')) {
                        echo $this->upload->display_errors();
                    } else {
                        $is_data_avail = $this->common_model->getRow('ci_setting', '*', array('setting_key' => 'site_logo'), $other_condition = '', $order_by = 'id', $sort_type = 'DESC');
                        $attachment = $this->upload->data();

                        $shippingArr = get_setting_data()['site_logo'];
                        $check_webiste_type = 'assets/uploads/setting/' . $attachment['file_name'];
    					if(file_exists($shippingArr))
                        unlink(setImagePath() . $shippingArr);
                        // print_r($shippingArr);die();

                        if ($is_data_avail) {
                            $insert_data = array(
                                'id' => $is_data_avail['id'],
                                'setting_key' => 'site_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        } else {
                            $insert_data = array(
                                'setting_key' => 'site_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        }

                        if ($is_data_avail) {
                            $this->common_model->update_data('ci_setting', $insert_data, array('id' => $is_data_avail['id']));
                        } else {
                            $this->common_model->insert_data('ci_setting', $insert_data);
                        }
                    }
                }

                if (isset($_FILES['footer_logo']['name']) && $_FILES['footer_logo']['name'] != "") {

                    if (!file_exists("assets/uploads/setting/")) {
                        mkdir("assets/uploads/setting", 0777);
                    }
                    $this->load->helper(array('form', 'url'));
                    $config['upload_path'] = 'assets/uploads/setting/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('footer_logo')) {
                        echo $this->upload->display_errors();
                    } else {
                        $is_data_avail = $this->common_model->getRow('ci_setting', '*', array('setting_key' => 'footer_logo'), $other_condition = '', $order_by = 'id', $sort_type = 'DESC');
                        $attachment = $this->upload->data();

                        $shippingArr = get_setting_data()['footer_logo'];
                        $check_webiste_type = 'assets/uploads/setting/' . $attachment['file_name'];
    					if(file_exists($shippingArr))
                        unlink(setImagePath() . $shippingArr);
                        if ($is_data_avail) {
                            $insert_data = array(
                                'id' => $is_data_avail['id'],
                                'setting_key' => 'footer_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        } else {
                            $insert_data = array(
                                'setting_key' => 'footer_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        }

                        if ($is_data_avail) {
                            $this->common_model->update_data('ci_setting', $insert_data, array('id' => $is_data_avail['id']));
                        } else {
                            $this->common_model->insert_data('ci_setting', $insert_data);
                        }
                    }
                }
                
    			
    			if (isset($_FILES['backend_main_logo']['name']) && $_FILES['backend_main_logo']['name'] != "") {

                    if (!file_exists("assets/uploads/setting/")) {
                        mkdir("assets/uploads/setting", 0777);
                    }
                    $this->load->helper(array('form', 'url'));
                    $config['upload_path'] = 'assets/uploads/setting/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('backend_main_logo')) {
                        echo $this->upload->display_errors();
                    } else {
                        $is_data_avail = $this->common_model->getRow('ci_setting', '*', array('setting_key' => 'backend_main_logo'), $other_condition = '', $order_by = 'id', $sort_type = 'DESC');
                        $attachment = $this->upload->data();

                        $shippingArr = get_setting_data()['backend_main_logo'];
                        $check_webiste_type = 'assets/uploads/setting/' . $attachment['file_name'];
    					if(file_exists($shippingArr))
                        unlink(setImagePath() . $shippingArr);

                        if ($is_data_avail) {
                            $insert_data = array(
                                'id' => $is_data_avail['id'],
                                'setting_key' => 'backend_main_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        } else {
                            $insert_data = array(
                                'setting_key' => 'backend_main_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        }

                        if ($is_data_avail) {
                            $this->common_model->update_data('ci_setting', $insert_data, array('id' => $is_data_avail['id']));
                        } else {
                            $this->common_model->insert_data('ci_setting', $insert_data);
                        }
                    }
                }

    			if (isset($_FILES['backend_side_logo']['name']) && $_FILES['backend_side_logo']['name'] != "") {

                    if (!file_exists("assets/uploads/setting/")) {
                        mkdir("assets/uploads/setting", 0777);
                    }
                    $this->load->helper(array('form', 'url'));
                    $config['upload_path'] = 'assets/uploads/setting/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('backend_side_logo')) {
                        echo $this->upload->display_errors();
                    } else {
                        $is_data_avail = $this->common_model->getRow('ci_setting', '*', array('setting_key' => 'backend_side_logo'), $other_condition = '', $order_by = 'id', $sort_type = 'DESC');
                        $attachment = $this->upload->data();

                        $shippingArr = get_setting_data()['backend_side_logo'];
                        $check_webiste_type = 'assets/uploads/setting/' . $attachment['file_name'];
    					if(file_exists($shippingArr))
                        unlink(setImagePath() . $shippingArr);

                        if ($is_data_avail) {
                            $insert_data = array(
                                'id' => $is_data_avail['id'],
                                'setting_key' => 'backend_side_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        } else {
                            $insert_data = array(
                                'setting_key' => 'backend_side_logo',
                                'setting_value' => $check_webiste_type,
                            );
                        }

                        if ($is_data_avail) {
                            $this->common_model->update_data('ci_setting', $insert_data, array('id' => $is_data_avail['id']));
                        } else {
                            $this->common_model->insert_data('ci_setting', $insert_data);
                        }
                    }
                }
                    
                foreach ($this->input->post() as $key => $value) { 


                    if($key == 'social_label'){
                        $value = serialize($_POST['social_label']);
                    }
                    if($key == 'social_link'){
                        $value = serialize($_POST['social_link']);
                    }
                    if($key == 'social_icon'){
                        $value = serialize($_POST['social_icon']);
                    }

                    foreach ($this->lang_helper as $key_lang => $val_lang) {
                        //print_r($key_lang);
                        if($key == 'chart_block_'.$key_lang){
                        $value =base64_encode (($_POST['chart_block_'.$key_lang]));
                        
                        }
                        if($key == 'overview_block_'.$key_lang){
                        $value = base64_encode(($_POST['overview_block_'.$key_lang]));
                       
                        }
                    }
                    
                    if($key !='name'){
                        $is_data_avail = $this->common_model->getRow('ci_setting', '*', array('setting_key' => $key), $other_condition = '', $order_by = 'id', $sort_type = 'DESC');
                        if ($is_data_avail) {
                            $update_data_arr[] = array(
                                'id' => $is_data_avail['id'],
                                'setting_key' => $key,
                                'setting_value' => $value,
                            );
                        } 
                        else {
                            $insert_data_arr[] = array(
                                'setting_key' => $key,
                                'setting_value' => $value,
                            );
                        }
                    }
                }
                //print_r($update_data_arr);
                //exit();
                if (!empty($insert_data_arr)) {
                    $this->common_model->batchInsert('ci_setting', $insert_data_arr);
                }
                if (!empty($update_data_arr)) {
                    $this->common_model->batchUpdate('ci_setting', $update_data_arr, 'id');
                }
                redirect('admin/setting');
                    
                if ($this->input->post('hidden_tab')) {
                    $this->session->set_userdata('hidden_tab_session', $this->input->post('hidden_tab'));
                }
            }                 
        }else {
            $this->session->set_userdata('hidden_tab_session', 'general_settings');
        }
    }

}
