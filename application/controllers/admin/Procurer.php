<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procurer extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $data['title'] = 'Procurers';
        $data['main_page'] = 'backend/procurer/list';
        $this->load->view('layout/template', $data);
    } 

    public function add_edit_form($id='-1'){
        if($id=='-1'){
            $data['title'] = 'Add Client';
            $this->session->set_userdata('hidden_tab_session', 'account_registration');
            $data['post_hidden_tab'] = ($this->session->userdata('hidden_tab_session')) ? $this->session->userdata('hidden_tab_session') : 'account_registration';


        }else{
            $data['title'] = 'Edit Client';
            $this->session->set_userdata('hidden_tab_session', 'account_registration');
            $data['post_hidden_tab'] = ($this->session->userdata('hidden_tab_session')) ? $this->session->userdata('hidden_tab_session') : 'account_registration';
            

        }
        $data['country_data'] = $this->common_model->getRows('ci_countries','*');
        $data['tender_data'] = $this->common_model->getRows('ci_tender_type','*',array('status'=>1));
        $data['form_details'] = $this->common_model->getRow('ci_users','*',array('id'=>$id));      
        $data['form_details_register'] = $this->common_model->getRow('ci_user_register','*',array('user_id'=>$id));
        $data['form_details_kyc'] = $this->common_model->getRow('ci_user_kyc','*',array('user_id'=>$id));
        $data['id'] = $id;
        $data['main_page'] = 'backend/procurer/add_edit_form';
        $this->load->view('layout/template', $data);
    }



    public function datatable_json() {
        $table_name = 'ci_users';
        $columns = '*';
        $search_columns = 'company_name, first_name, last_name, email, phone';
        $order_by = 'id desc';
        $where = array('user_type' =>2);
        if(!empty($this->input->post('search_form_status')=='1')){
            $where['status'] = $this->input->post('search_form_status');
        }else if($this->input->post('search_form_status')=='0'){
            $where['status'] = $this->input->post('search_form_status');
        }
        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());
        
       
        $data = array();
        foreach ($records['data'] as $row) {
            if ($row['status'] == 1) {
                $status = '<span class="btn-xs btn-success btn-flat btn-xs">Active<span>';
            } else {
                $status = '<span class="btn-xs btn-danger btn-flat btn-xs" title="status">Inactive<span>';
            }

            $button_design = '<a style="margin-left:5px;color:#fff" title="Delete" class="update btn btn-xs btn-danger" onclick="ConfirmDelete(' . $row['id'] . ')" > <i class="fa fas fa-trash-alt"></i></a>';
                    
           
            $data[] = array(
                '<div class="icheck-primary d-inline"><input type="checkbox" class="chkbox" name="ids[]" value="' . $row['id'] . '" id="all_chkbox' . $row['id'] . '"><label for="all_chkbox' . $row['id'] . '"></label></div>',
                '<span class="">' . $row['company_name'] . '<span>',
                '<span class="">' . $row['first_name'].' '.$row['last_name'] . '<span>',
                '<span class="">' . $row['email'] . '<span>',
                '<span class="">' . $row['phone'] . '<span>',
                '<span class="">' . date('M, d, Y', strtotime($row['created_at'])) . '<span>',
                $status,
                '<a title="Edit" class="update btn btn-xs btn-primary" href="' . base_url('admin/procurer/add_edit_form/' . $row['id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>'.                
            $button_design
            );
        }

        $records['data'] = $data;
        echo json_encode($records);
    }

     public function save($id="-1"){
           $kyc_validation_flag = get_setting_data()['kyc_validation'];    
           if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $login_id = $this->session->userdata('user_id');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[0]|max_length[50]|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[0]|max_length[50]|required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|min_length[7]|max_length[13]|required');
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|max_length[50]|required');
            $this->form_validation->set_rules('register_company_number', 'Company Mobile Number', 'trim|min_length[7]|max_length[13]|required');
            $this->form_validation->set_rules('register_company_email', 'Company Email ', 'trim|max_length[50]|required');
            $this->form_validation->set_rules('register_company_address', 'Company Address ', 'trim|max_length[255]|required');
            // $this->form_validation->set_rules('company_field_of_expertise', 'Company Experties ', 'trim|max_length[50]|required');
            $this->form_validation->set_rules('register_company_representative', 'Name of Company Representative', 'trim|max_length[50]|required');
            $this->form_validation->set_rules('register_company_representative_phone', 'Phone Number of Company Representative', 'trim|min_length[7]|max_length[13]|required');
            $this->form_validation->set_rules('representative_position', 'Position of Company Representative', 'trim|max_length[50]|required');
            $this->form_validation->set_rules('register_company_representative', 'Email of Company Representative', 'trim|max_length[50]|required');
            //$this->form_validation->set_rules('kyc_mandatory_documents_input', 'KYC Document', 'required');
            //$this->form_validation->set_rules('kyc_identity_proof_input', 'KYC Proof', 'required');
            //$this->form_validation->set_rules('email', 'email', 'trim|required');
            //$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[25]|trim');
            //$this->form_validation->set_rules('cnf_password', 'Confirm Password', 'required|min_length[6]|matches[password]|max_length[25]|trim');
            if (empty($_FILES['kyc_mandatory_documents_input']['name']) && $id=="-1" && $kyc_validation_flag==1){
            $this->form_validation->set_rules('kyc_mandatory_documents_input', 'KYC Document', 'required');
            }

            if (empty($_FILES['kyc_identity_proof_input']['name']) && $id=='-1' && $kyc_validation_flag==1){
            $this->form_validation->set_rules('kyc_identity_proof_input', 'KYC Proof Document', 'required');
            }
            if ($id == '-1') {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[25]|trim');
                $this->form_validation->set_rules('cnf_password', 'Confirm Password', 'required|min_length[6]|matches[password]|max_length[25]|trim');
               

            }
            if ($this->input->post('password') != '' && $id > 0) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[25]|trim');
                $this->form_validation->set_rules('cnf_password', 'Confirm Password', 'required|min_length[6]|matches[password]|max_length[25]|trim');
            }

            if ($id == '-1') {
                $this->form_validation->set_rules('email', 'User Email', 'required|is_unique[ci_users.email]');
                $this->form_validation->set_rules('register_company_email', 'Company Email ', 'required');
                      
            }
           
            /*$this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('tender_type', 'Tender', 'trim|required');*/
    
           
           // $this->form_validation->set_rules('company_name_data', 'Company Name', 'trim|min_length[0]|max_length[50]|required');
            //$this->form_validation->set_rules('company_type', 'Company Type', 'trim|min_length[0]|max_length[50]|required');
           // $this->form_validation->set_rules('register_company_email', 'Company  Email', 'trim|min_length[0]|max_length[50]|required');
             
        
        

            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->add_edit_form($id);
            }else{
                if($this->input->post('profile_approve')==''){
                    $is_approve=0;
                }else{
                  $is_approve=1;  
                } 
                $insert_update = array(
                    'user_type' => 2,
                    'company_name' => $this->input->post('company_name'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'), 
                    'status' => $this->input->post('status'),
                   // 'is_approve' => $is_approve,
                );
                if ($this->input->post('password') != '') {
                    $insert_update['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                }

                if ($id == -1) {
                    $insert_update['created_by'] = $login_id;
                    $this->db->set('created_at', 'NOW()', FALSE);
                    $result = $this->common_model->insert_data('ci_users',$insert_update);
                    $insert_id = $this->db->insert_id();
                    if($result){
                            //user file upload
                            $user_file = '';
                            if ($_FILES['user_image']['name'] != "") {
                                if (!file_exists("./uploads/users")) {
                                    mkdir("./uploads/users", 0777);
                                }
                                $config['upload_path'] = './uploads/users/';
                                $config['allowed_types'] = 'jpg|jpeg|png';
                                $config['max_size'] = 0;
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload('user_image')) {
                                    $uploadData = $this->upload->data();
                                    $user_file = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                }
                            }
                            // insert for document data
                            $user_register_table_data = 
                            array(
                                'user_id' => $insert_id,
                                'user_file' => $user_file,
                                'registration_identification_number' => $this->input->post('registration_identification_number'),
                                'register_company_email' => $this->input->post('register_company_email'),
                                'register_company_number' => $this->input->post('register_company_number'),
                                'register_company_address' => $this->input->post('register_company_address'),
                                'registered_on_etender' => $this->input->post('registered_on_etender'),
                                 'won_etender' => $this->input->post('won_etender'),
                                 'company_field_of_expertise' => $this->input->post('company_field_of_expertise'),
                                 'company_representative_email' => $this->input->post('company_representative_email'),
                                 'register_company_representative' => $this->input->post('register_company_representative'),
                                 'representative_position' => $this->input->post('representative_position'),
                                 'refer_company_name' => json_encode($this->input->post('refer_company_name')),
                                 'refer_representative_name' => json_encode($this->input->post('refer_representative_name')),
                                 'register_tender_name' => $this->input->post('register_tender_name'),
                                 'won_tender_name' => $this->input->post('won_tender_name'),
                                 'register_terms_condition' => $this->input->post('register_terms_condition'),
                                 'register_company_representative_phone' => 
                                  $this->input->post('register_company_representative_phone')                   
                                   );

                              $this->db->set('created_at','NOW()',FALSE);
                              $this->common_model->insert_data('ci_user_register',$user_register_table_data);

                           // Save KYC save data 
                              $kyc_mandatory_documents_input = '';
                              $kyc_identity_proof_input = '';

                               
                            if ($_FILES['kyc_mandatory_documents_input']['name'] != "") {
                                if (!file_exists("./uploads/user_kyc")) {
                                    mkdir("./uploads/user_kyc", 0777);
                                }
                                $config['upload_path'] = './uploads/user_kyc/';
                                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                                $config['max_size'] = 0;
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload('kyc_mandatory_documents_input')) {
                                    $uploadData = $this->upload->data();
                                    $kyc_mandatory_documents_input = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                }
                            }

                             $kyc_identity_proof_input = '';
                            if ($_FILES['kyc_identity_proof_input']['name'] != "") {
                                if (!file_exists("./uploads/user_kyc")) {
                                    mkdir("./uploads/user_kyc", 0777);
                                }
                                $config['upload_path'] = './uploads/user_kyc/';
                                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                                $config['max_size'] = 0;
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload('kyc_identity_proof_input')) {
                                    $uploadData = $this->upload->data();
                                    $kyc_identity_proof_input = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                }
                            }

                              $user_kyc_data = array(
                                 'user_id' => $insert_id,
                                 'kyc_mandatory_documents_input' => $kyc_mandatory_documents_input,
                                 'kyc_identity_proof_input' => $kyc_identity_proof_input,
                              );

                        $data_id = $this->common_model->insert_data('ci_user_kyc',$user_kyc_data);
                        $is_approve = $this->input->post('profile_approve');
                        if($data_id != '' && $is_approve == '1'){
                            $name  = '';
                            $name .= $this->input->post('first_name');
                            $name .= ' ';
                            $name .= $this->input->post('last_name');
                            $this->send_verification_email($this->input->post('email'),$name,'Client');
                        }
                    
                        $this->session->set_flashdata('msg', 'Procurer has been added successfully!');
                        if ($this->input->post('submit') == 'Apply') {
                            redirect(base_url('admin/procurer/add_edit_form/' . $result));
                        } else {
                            redirect(base_url('admin/procurer'));
                        }
                    }
                }else{
                    $insert_update['updated_by'] = $login_id;
                   // $user_register_table_data['updated_by'] = $login_id;
                    $this->db->set('updated_at', 'NOW()', FALSE);
                    $this->common_model->update_data('ci_users',$insert_update, array('id'=>$id));

                      //user file upload
                            $user_file = '';
                            if ($_FILES['user_image']['name'] != "") {
                                if (!file_exists("./uploads/users")) {
                                    mkdir("./uploads/users", 0777);
                                }
                                $config['upload_path'] = './uploads/users/';
                                $config['allowed_types'] = 'jpg|jpeg|png';
                                $config['max_size'] = 0;
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if ($this->upload->do_upload('user_image')) {
                                    $uploadData = $this->upload->data();
                                    $user_file = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                }
                            }else{
                                $user_file=$this->input->post('user_image_hidden');
                            }
                            // insert for document data
                            $user_register_table_data = 
                            array(
                                'user_file' => $user_file,
                                'registration_identification_number' => $this->input->post('registration_identification_number'),
                                'register_company_email' => $this->input->post('register_company_email'),
                                'register_company_number' => $this->input->post('register_company_number'),
                                'register_company_address' => $this->input->post('register_company_address'),
                                'registered_on_etender' => $this->input->post('registered_on_etender'),
                                 'won_etender' => $this->input->post('won_etender'),
                                 'company_field_of_expertise' => $this->input->post('company_field_of_expertise'),
                                 'company_representative_email' => $this->input->post('company_representative_email'),
                                 'register_company_representative' => $this->input->post('register_company_representative'),
                                 'representative_position' => $this->input->post('representative_position'),
                                 'refer_company_name' => json_encode($this->input->post('refer_company_name')),
                                 'refer_representative_name' => json_encode($this->input->post('refer_representative_name')),
                                 'register_tender_name' => $this->input->post('register_tender_name'),
                                 'won_tender_name' => $this->input->post('won_tender_name'),
                                 'register_terms_condition' => $this->input->post('register_terms_condition'),
                                 'register_company_representative_phone' => 
                                  $this->input->post('register_company_representative_phone')                   
                                   );

                                 $this->db->set($user_register_table_data);
                                 $this->common_model->update_data('ci_user_register',$user_register_table_data, array('user_id'=>$id)); 
                                $kyc_mandatory_documents_input = '';
                                if ($_FILES['kyc_mandatory_documents_input']['name'] != "") { 
                                    if (!file_exists("./uploads/user_kyc")) {
                                        mkdir("./uploads/user_kyc", 0777);
                                    }
                                    $config['upload_path'] = './uploads/user_kyc/';
                                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                                    $config['max_size'] = 0;
                                    $config['encrypt_name'] = TRUE;
                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);
                                    if ($this->upload->do_upload('kyc_mandatory_documents_input')) { 
                                        $uploadData = $this->upload->data();
                                        $kyc_mandatory_documents_input = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                        echo '</br>'.$kyc_mandatory_documents_input.'</br>';
                                    }
                                }else{
                                    $kyc_mandatory_documents_input= $this->input->post('kyc_mandatory_documents_input_hidden') ;
                                } 
                                 $kyc_identity_proof_input = '';
                                
                                 
                                if ($_FILES['kyc_identity_proof_input']['name'] != "") { 
                                    if (!file_exists("./uploads/user_kyc")) {
                                        mkdir("./uploads/user_kyc", 0777);
                                    }
                                    $config['upload_path'] = './uploads/user_kyc/';
                                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                                    $config['max_size'] = 0;
                                    $config['encrypt_name'] = TRUE;
                                    $this->load->library('upload', $config);
                                    $this->upload->initialize($config);
                                    if ($this->upload->do_upload('kyc_identity_proof_input')) { 
                                        $uploadData = $this->upload->data();
                                        $kyc_identity_proof_input = setImagePath() . $config['upload_path'] . $uploadData['file_name'];
                                    }
                                }else{ 
                                    $kyc_identity_proof_input= $this->input->post('kyc_identity_proof_input_hidden') ;
                                }

                                  $user_kyc_data = array(
                                     'kyc_mandatory_documents_input' => $kyc_mandatory_documents_input,
                                     'kyc_identity_proof_input' => $kyc_identity_proof_input,
                                  );
                    
                    $this->common_model->update_data('ci_user_kyc',$user_kyc_data, array('user_id'=>$id));
                    
                    $this->session->set_flashdata('msg', 'Supplier has been updated successfully!');
                    if ($this->input->post('submit') == 'Apply') {
                        redirect(base_url('admin/procurer/add_edit_form/' . $id));
                    } else {
                        redirect(base_url('admin/procurer'));
                    }
                }

            }
        }
    } 

    public function save_back_up($id="-1"){
        if($this->input->post('submit')){
            $login_id = $this->session->userdata('user_id');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[0]|max_length[50]|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[0]|max_length[50]|required');
            $this->form_validation->set_rules('email', 'email', 'trim|required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|max_length[12]');
            if ($id == '-1') {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[25]|trim');
            }
            if ($this->input->post('password') != '' && $id > 0) {
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[25]|trim');
            }
            if ($id == '-1') {
                $this->form_validation->set_rules('email', 'Email', 'required|is_unique[ci_users.email]');
                      
            }
            if ($id > 0) {
                if ($this->input->post('email') != $this->input->post('original_email')) {
                    $is_unique_email = '|is_unique[ci_users.email]';
                } else {
                    $is_unique_email = '';
                }

                $this->form_validation->set_rules('email', 'Email', 'required'.$is_unique_email);

                $this->form_validation->set_message('check_user', 'This Email ' . '<strong>' . $this->input->post('email') . '</strong> is already registered, please try with new');
            }
            $this->form_validation->set_rules('company_name', 'Company Name', 'trim|required');
            $this->form_validation->set_rules('country', 'Country', 'trim|required');
            $this->form_validation->set_rules('state', 'State', 'trim|required');
            $this->form_validation->set_rules('city', 'City', 'trim|required');
            $this->form_validation->set_rules('tender_type', 'Tender', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->add_edit_form($id);
            }else{
                $insert_update = array(
                    'user_type' => 2,
                    'company_name' => $this->input->post('company_name'),
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'phone_code' => $this->input->post('phone_code'),
                    'country' => $this->input->post('country'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'tender_type' => $this->input->post('tender_type'),
                    'status' => $this->input->post('status'),
                );
                if ($this->input->post('password') != '') {
                    $insert_update['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
                }

                if ($id == -1) {
                    $insert_update['created_by'] = $login_id;
                    $this->db->set('created_at', 'NOW()', FALSE);
                    $result = $this->common_model->insert_data('ci_users',$insert_update);
                    if($result){
                        $this->session->set_flashdata('msg', 'Procurer has been added successfully!');
                        if ($this->input->post('submit') == 'Apply') {
                            redirect(base_url('admin/procurer/add_edit_form/' . $result));
                        } else {
                            redirect(base_url('admin/procurer'));
                        }
                    }
                }else{
                    $insert_update['updated_by'] = $login_id;
                    $this->db->set('updated_at', 'NOW()', FALSE);
                    $this->common_model->update_data('ci_users',$insert_update, array('id'=>$id));
                    $this->session->set_flashdata('msg', 'Procurer has been updated successfully!');
                    if ($this->input->post('submit') == 'Apply') {
                        redirect(base_url('admin/procurer/add_edit_form/' . $id));
                    } else {
                        redirect(base_url('admin/procurer'));
                    }
                }

            }
        }
    }
    public function search() {
        $this->session->set_userdata('search_form_status', $this->input->post('search_form_status'));
    }
    public function multidel() {  
        $ids =  $this->input->post('records_to_del'); 
        
        $this->db->where_in('id', $ids);
        $this->db->delete('ci_users'); 
        $this->session->set_flashdata('msg', 'Procurer has been deleted successfully!');
        redirect(base_url('admin/procurer'));

    }

    public function delete($id = '') {   
             
        $delete = $this->common_model->delete_data('ci_users', array('id ' => $id));
        $this->session->set_flashdata('msg', 'Procurer has been deleted successfully!');
        redirect(base_url('admin/procurer'));

    }

    public function state_data_phone_code(){
        $country_id = $this->input->post('country_id');
        $state_id = $this->input->post('state_id');
        $phone_code = $this->common_model->getVal('ci_countries','phonecode',array('id'=>$country_id));
        $state_data = $this->common_model->getRows('ci_states','*',array('country_id'=>$country_id),'','name','ASC');
        $state_data_html = "";
        $state_data_html.='<select class="form-control" name="state" id="state_data"><option value="">Select State</option>';
            if(!empty($state_data)){
                foreach($state_data as $val){
                    $selected = "";
                    if(!empty($state_id)){
                        $selected = "selected";
                    }
                    $state_data_html.='<option value="'.$val["id"].'"'.$selected.'>'.$val["name"].'</option>';
                }
                 $data = array('state_data'=>$state_data_html,'phone_code'=>$phone_code);
            }
        $state_data_html.="</select>";
       
        echo json_encode($data);

    }

    public function send_verification_email($email,$name,$user_type){
        $headers = '';
        $lang = 'en';                 
        $email_template = GET_MAIL_TEMPLATE('admin-user-registration', $lang);
        if (!empty($email_template)) {                 
            $get_settings = get_setting_data();
            $email_template_subject_content = $email_template['email_template_subject'];
            $email_template_subject = '';
            $email_template_subject = str_replace("{{user_type}}", $user_type, $email_template_subject_content);
            $message_content = html_entity_decode($email_template['email_template_body']);                  
            $site_url = site_url();
            $verification_link = base_url();
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message = str_replace("{{user_name}}", $name, $message_content);
            $message = str_replace("{{site_url}}", $verification_link, $message);
            $message = str_replace("http://", "", $message); 
            
            $user_email = $email;
            
            if ($get_settings['mail_sending_method'] == 'php_mail') {
                $headers .= 'From: <' . $get_settings['smtp_mail_from'] . '>' . "\r\n";
                $email_status = mail($user_email, $email_template_subject, $message, $headers);
                
            }elseif ($get_settings['mail_sending_method'] == 'smtp') {
                $email_status = sendEmail_PRM($user_email, $email_template_subject, $message, $file = '', $cc = '', $get_settings['smtp_mail_from']);
            }
            
            return $email_status;
        }

        $msg = $this->lang->line('register_verification_email');
        $this->session->set_flashdata('msg', $msg);
        // redirect(site_url());
    }


    function approveUserProfile(){
        $user_id = $this->input->post('id');
        $data = array(
            'is_approve' => 1,
        ); 
        $table ='ci_users';
        $condition = "id=".$user_id;
        $queryStatus = $this->common_model->update_data($table, $data, $condition); 
        if($queryStatus){ 
            $userData = $this->common_model->getRow($table,'*',$condition);
            if($userData != ''){ 
                $name = '';
                $name .= $userData['first_name'];
                $name .= ' ';
                $name .= $userData['last_name'];
                $user_type='';
                if($userData['user_type'] == '2'){ 
                    $user_type='Client';
                }
                if($this->send_verification_email($userData['email'],$name,$user_type)){ 
                    echo json_encode(["status"=>true,"mail_status"=>true]);
                }else{ 
                    echo json_encode(["status"=>true,"mail_status"=>false]);
                }
            }else{ 
                echo json_encode(["status"=>true,"mail_status"=>false]);
            }
        }else{ 
            echo json_encode(["status"=>true,"mail_status"=>false]);
        }
    }

       /**
     * Check and delete image record
     */
    public function DeleteImage() {
        $img_lng = $this->input->post('img_lng');
        $id = $this->input->post('id');
        $user_register = $this->common_model->select_data_by_condition('ci_user_register', 'user_file', array('id' => $id));
        if (!empty($user_register)) {
            foreach ($user_register as $val) {
                if (!empty($val['user_file'])) {
                    $imgArr = $val['user_file'];
                    if (isset($imgArr)) {
                                                              
                            unlink($imgArr);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                        $imgArr = '';
                        $newImgArr = $imgArr;
                        $this->common_model->update_data('ci_user_register', array('user_file' => $newImgArr), array('id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
    }

       /**
     * Check and delete image record
     */
    public function DeleteImageKyc() {
        $img_lng = $this->input->post('img_lng');
        $id = $this->input->post('id');
        $kyc_img_type = $this->input->post('kyc_img_type');
        $user_register = $this->common_model->select_data_by_condition('ci_user_kyc', 'kyc_identity_proof_input', array('id' => $id));
        if (!empty($user_register)) {
            foreach ($user_register as $val) {
                if(!empty($val['kyc_identity_proof_input']) && $kyc_img_type == 'ip') {
                    $imgArr = $val['kyc_identity_proof_input'];
                    if (isset($imgArr)) {
                                                              
                        unlink($imgArr);   
                        $imgArr = '';
                        $newImgArr = $imgArr;
                        $this->common_model->update_data('ci_user_kyc', array('kyc_identity_proof_input' => $newImgArr), array('id' => $id));
                    }
                }else if(!empty($val['kyc_mandatory_documents_input']) && $kyc_img_type == 'md') {
                    $imgArr = $val['kyc_mandatory_documents_input'];
                    if (isset($imgArr)) {
                                                              
                        unlink($imgArr);   
                        $imgArr = '';
                        $newImgArr = $imgArr;
                        $this->common_model->update_data('ci_user_kyc', array('kyc_mandatory_documents_input' => $newImgArr), array('id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
    }
}
?>