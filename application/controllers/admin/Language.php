<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->lang_helper = langArr();
    }
    
    public function index() 
    {
        $data['title'] = 'Language List | Etender';
        $data['main_page'] = 'backend/language/list';
        $this->load->view('layout/template', $data);
    }
    

	public function add_edit_form($id = '-1'){
        if($id >0){
            $data['title'] = 'Language Edit | Etender';
        }else{
            $data['title'] = 'Language Add | Etender';
        }
		$data['form_details'] = $this->common_model->getRow('ci_lang','*', array('id' => $id));
        //echo '<pre>';print_r($data);exit;
		$data['id'] = $id;
        $data['main_page'] = 'backend/language/add_edit_form';
        $this->load->view('layout/template', $data);
    }

	public function datatable_json() {
        $table_name = 'ci_lang';
        $columns = '*';
        $search_columns = ' lang_en, lang_hi';//lang_ar, lang_ku';
        $order_by = 'id desc';

        $where = array();
        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());

        $data = array();
		foreach ($records['data'] as $row) {
            $data[] = array(
                '<span class="">' . $row['lang_name'] . '<span>',
                '<span class="">' . $row['lang_en'] . '<span>',
                '<span class="">' . $row['lang_hi'] . '<span>',
                //'<span class="">' . $row['lang_ar'] . '<span>',
                //'<span class="">' . $row['lang_ku'] . '<span>',
                '<a title="Edit" class="update btn btn-xs btn-primary" href="' . base_url('admin/language/add_edit_form/' . $row['id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>'
            );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function save($id = -1) {
        if ($this->input->post('submit')){
            if ($id == -1) {
                $this->form_validation->set_rules('lang_name', 'Lang Name', 'trim|required');
            }
            
			$this->form_validation->set_rules('lang_en', 'Lang [English]', 'trim|required');
            $this->form_validation->set_rules('lang_hi', 'Lang [Hindi]', 'trim|required');
            //$this->form_validation->set_rules('lang_ar', 'Lang [Arabic]', 'trim|required');
            //$this->form_validation->set_rules('lang_ku', 'Lang [Kurdish]', 'trim|required');
            if ($this->form_validation->run() == FALSE){
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->add_edit_form($id);
            } else {
                if($id > 0) {
                    $insert_update = array(
                        'lang_en' => $this->input->post('lang_en',true),
                        'lang_hi' => $this->input->post('lang_hi',true),
                        //'lang_ar' => $this->input->post('lang_ar',true),
                        //'lang_ku' => $this->input->post('lang_ku',true),
                    );  
                    $result = $this->common_model->update_data('ci_lang', $insert_update, array('id' => $id));
                    $this->session->set_flashdata('success', 'Detail has been updated successfully!');
                    if($this->input->post('submit')=='Apply'){
                        redirect(base_url('admin/language/add_edit_form/'.$id));
                    }else{
                        redirect(base_url('admin/language'));
                    }
                }else{
                    $insert_update = array(
                        'lang_name' => $this->input->post('lang_name',true),
                        'lang_en' => $this->input->post('lang_en',true),
                        'lang_hi' => $this->input->post('lang_hi',true),
                        //'lang_ar' => $this->input->post('lang_ar',true),
                        //'lang_ku' => $this->input->post('lang_ku',true),
                    );  
                    $result = $this->common_model->insert_data('ci_lang', $insert_update);
                    if ($result) {
                        $this->session->set_flashdata('success', 'Detail has been added successfully!');
                        if($this->input->post('submit')=='Apply'){
                            redirect(base_url('admin/language/add_edit_form/'.$result));
                        }else{
                            redirect(base_url('admin/language'));
                        }
                    }
                }
            }
        }else{
           redirect('admin/language/add_edit_form'); 
        }
	}
} 
?>
