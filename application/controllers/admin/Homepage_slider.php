<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage_slider extends CI_Controller {

    /**
     * Construct function
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('download');
        $this->load->helper('file');
        $this->lang_helper = langArr();
        $this->load->library('image_moo');
    }

    /**
     * Index function
     */
    public function index() {

        $this->session->unset_userdata('search_form_status');
        $data['title'] = 'Home page Slider Management | Slider List';
        $data['main_page'] = 'backend/homepage_slider/list';
        $this->load->view('layout/template',$data);
    }

    /**
     * Add new Banner 
     */
    public function add_homepage_slider() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_FILES['file']['name'])) {
                $this->form_validation->set_rules('file', 'file', 'trim|required');
            }
            foreach ($this->lang_helper as $key => $val) {
                $required = '';
                //if ($key == 'en') {
                    $required = '|required';
               // }

                $this->form_validation->set_rules('title_' . $key, 'Title [' . $val . ']', 'trim' . $required, array('required' => 'This Title  is required'));    
                if ($key == 'English') {            
                    $this->form_validation->set_rules('link_'.$key, 'Title [' . $val . ']', 'trim|callback_check_valid_url[link_'.$key.']', array('check_valid_url' => 'The URL you entered is not correctly formatted.'));
                }
            }


            //$this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('file_type', 'File type', 'trim|required');
            $this->form_validation->set_rules('interval', 'Slide interval', 'trim|required|numeric');
            $this->form_validation->set_rules('slide_order', 'Slide order', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
            } else {
                /* new updated code for store data language wise start here 14/06/2019 */
                $filetype = $this->input->post('file_type');
                $titleArr = array();
                $subArr = array();
                $title_heading = array(); 
                $btn_link  =  array();
                $btn_label=array();
                foreach ($this->lang_helper as $key => $val) {
                    $titleArr[$key] = $this->input->post('title_' . $key);
                    $subArr[$key] = $this->input->post('sub_title_' . $key);
                    $title_heading[$key] = $this->input->post('title_heading_' . $key);
                    $btn_link[$key] = $this->input->post('link_'.$key);
                    $btn_label[$key] = $this->input->post('label_'.$key);
                }
                $title = serialize($titleArr);
                $subTitle = serialize($subArr);
                $title_heading = serialize($title_heading);
                $btn_link = serialize($btn_link);
                $btn_label = serialize($btn_label);
                $data = array(
                    //'status' => $this->input->post('status'),
                    'slide_interval' => $this->input->post('interval'),
                    'slide_order' => $this->input->post('slide_order'),
                    'link' => $btn_link ,
                    'label' => $btn_label,
                    'title' => $title,
                    'sub_title' => $subTitle,
                    'title_heading' => $title_heading,
                    'file_type' => $filetype,
                );
                if ($filetype == 1) {
                    $validtype = 'jpg|jpeg|png';
                }
                if ($filetype == 2) {
                    $validtype = 'mp4|mov';
                }
				$error = false;
                if ($_FILES['file']['name'] != "") {
                   
                        if (!file_exists("assets/uploads/homepage_slider/")) {
                            mkdir("assets/uploads/homepage_slider/", 0777);
                        }

                        if (!file_exists("assets/uploads/homepage_slider/thumb/")) {
                        mkdir("assets/uploads/homepage_slider/", 0777);
                        }
                       $config['upload_path'] = 'assets/uploads/homepage_slider/';
                  

                    $config['allowed_types'] = $validtype;
                    $config['max_size'] = 0;
                    //$config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $error = false;
                    if (!$this->upload->do_upload('file')) {
                        $error = true;
                        $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', $this->upload->display_errors());
                    } else {
                        $attachment = $this->upload->data();
                        $data['file_name'] = $config['upload_path'] . $attachment['file_name'];
                        $filename=$attachment['file_name'];

                        if (move_uploaded_file($_FILES['file']["tmp_name"], "assets/uploads/homepage_slider/" . $filename)) {
                            
                               if (!file_exists("assets/uploads/homepage_slider/thumb")) {
                                        mkdir("assets/uploads/homepage_slider/thumb/", 0777);
                             }
                             copy("assets/uploads/homepage_slider/" . $filename, "assets/uploads/homepage_slider/thumb/" . $filename);
                             $this->image_size('assets/uploads/homepage_slider/thumb/' . $filename, 1351 , 547);
                        } 
                    }
                }
				
                if (!$error) {
                    $this->db->set('created_at', 'NOW()', FALSE);

                    $ins = $this->common_model->insert_data('ci_homepage_slider', $data);

                    $last_id = $this->db->insert_id();
                    if ($ins == TRUE) {
                        $this->session->set_flashdata('msg', 'File added successfully!');
						$buttonname = $this->input->post('submit');
						if($buttonname == 'Apply'){
							redirect(base_url('admin/homepage_slider/edit_slider/'.$last_id));
						} else {
							redirect(base_url('admin/homepage_slider'));
						}
                    }
                }
            }
        }

        $data['title'] = 'Home page Slider Management | Slider List';
        $data['main_page'] = 'backend/homepage_slider/add_form';
        $this->load->view('layout/template',$data);
    }

    /**
     * Display Slider list datatable list record
     */
    public function datatable_json() {
        $table_name = 'ci_homepage_slider';
        $columns = '*';
        $search_columns = 'file_type';
        $order_by = 'created_at desc';

        $where = array();
        if ($this->session->userdata('search_form_status') != '') {
            $where['ci_homepage_slider.status'] = $this->session->userdata('search_form_status');
        }
        
        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());
        $data = array();
        foreach ($records['data'] as $row) 
        {
            $title = unserialize($row['title']);
            $title_en='';
            if (isset($title['en']) && strlen($title['en']) <= 40) {
                $title_en = strip_tags($title['en']);
            } else {
                $title_en = substr(strip_tags($title['en']), 0, 40) . '...';
            }
            
            $status = ($row['status'] == 0) ? '<span class="btn-xs btn-danger btn-flat btn-xs">Inactive<span>' : '<span class="btn-xs btn-success btn-flat btn-xs" title="status">Active<span>';
            $img = '--';
            if (!empty($row['file_name']) && $row['file_type'] == 1) {
                $img = 'image';
            }
            if (!empty($row['file_name']) && $row['file_type'] == 2) {
                $img = 'video';
            }
                $data[] = array(
                '<div class="icheck-primary d-inline"><input type="checkbox" class="chkbox" name="ids[]" value="' . $row['id'] . '" id="all_chkbox'.$row['id'].'"><label for="all_chkbox'.$row['id'].'"></label></div>',
                $title_en,
                $img,
                $row['slide_order'],
                $status,
                '<a title="Edit" class="update btn btn-xs btn-primary" href="' . base_url('admin/homepage_slider/edit_slider/' . $row['id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;'.
                '<a title="Delete" class="delete btn btn-xs btn-danger pull-right" style="color:#fff;margin-left:5px" data-href="' . base_url('admin/homepage_slider/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>'
                
                );
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    /**
     * Edit and update Banner
     */
    public function edit_slider($id = '') {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $oldfile = $this->input->post('old_file');
			$oldfile_fr = $this->input->post('old_file_fr');
            if (empty($oldfile)) {
                $this->form_validation->set_rules('file', 'file', 'trim|required');
            }
            $this->form_validation->set_rules('file_type', 'File type', 'trim|required');
            //$this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('interval', 'Slide interval', 'trim|required|numeric');
            $this->form_validation->set_rules('slide_order', 'Slide order', 'trim|required|numeric');
            // $this->form_validation->set_rules('link', 'Link', 'trim|callback_check_valid_url[link]', array('check_valid_url' => 'The URL you entered is not correctly formatted.'));
            foreach ($this->lang_helper as $key => $val) {
                $required = '';
                //if ($key == 'en') {
                    $required = '|required';
               // }

                $this->form_validation->set_rules('title_' . $key, 'Title [' . $val . ']', 'trim' . $required, array('required' => 'This Title  is required'));    
                if ($key == 'English') {            
                    $this->form_validation->set_rules('link_'.$key, 'Title [' . $val . ']', 'trim|callback_check_valid_url[link_'.$key.']', array('check_valid_url' => 'The URL you entered is not correctly formatted.'));
                }
            }
            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
            } else {
                $titleArr = array();
                $subArr = array();
                $title_heading = array();
                $btn_link  =  array();
                $btn_label=array();
                foreach ($this->lang_helper as $key => $val) {
                    $titleArr[$key] = $this->input->post('title_' . $key);
                    $subArr[$key] = $this->input->post('sub_title_' . $key);
                    $title_heading[$key] = $this->input->post('title_heading_' . $key);
                    $btn_link[$key] = $this->input->post('link_'.$key);
                    $btn_label[$key] = $this->input->post('label_'.$key);
                }
                $title = serialize($titleArr);
                $subTitle = serialize($subArr);
                $title_heading = serialize($title_heading);
                $filetype = $this->input->post('file_type');
				$link_fr = $this->input->post('link_fr');
                $btn_link = serialize($btn_link);
                $btn_label = serialize($btn_label);
                $data = array(
                    //'status' => $this->input->post('status'),
                    'slide_interval' => $this->input->post('interval'),
                    'slide_order' => $this->input->post('slide_order'),
                    'link' => $btn_link ,
                    'label' => $btn_label,
                    'title' => $title,
                    'sub_title' => $subTitle,
                    'title_heading' => $title_heading,
                    'file_type' => $filetype,
                );
                if ($filetype == 1) {
                    $validtype = 'jpg|jpeg|png';
                }
                if ($filetype == 2) {
                    $validtype = 'mp4|mov';
                }
				$error = false;
                if ($_FILES['file']['name'] != "") {
                 if (!file_exists("./uploads/homepage_slider/")) {
                            mkdir("./uploads/homepage_slider/", 0777);
                        }
                 if (!file_exists("./uploads/homepage_slider/thumb")) {
                        mkdir("./uploads/homepage_slider/thumb", 0777);
                    }

                    
                    $config['upload_path'] = './uploads/homepage_slider/';
                    

                    $config['allowed_types'] = 'jpg|jpeg|png|mp4';
                    $config['max_size'] = 0;
                    //$config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $error = false;
                    if (!$this->upload->do_upload('file')) {
                        $error = true;
                        $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', $this->upload->display_errors());
                    } else {
                        $attachment = $this->upload->data();
                        $data['file_name'] = $config['upload_path'] . $attachment['file_name'];
                        $filename = $attachment['file_name'];

                        if (move_uploaded_file($_FILES['file']["tmp_name"], "./uploads/homepage_slider/" . $filename)) {
                            
                               if (!file_exists("./uploads/homepage_slider")) {
                                        mkdir("./uploads/homepage_slider/thumb/", 0777);
                             }
                             copy("./uploads/homepage_slider/" . $filename, "./uploads/homepage_slider/thumb/" . $filename);
                             $this->image_size('./uploads/homepage_slider/thumb/' . $filename, 1351,547);
                        } 
                    }
                }
                
				
                if (!$error) {
                    $this->db->set('updated_at', 'NOW()', FALSE);

                    $ins = $this->common_model->update_data('ci_homepage_slider', $data, array('id' => $id));

                    if ($ins == TRUE) {
                        $this->session->set_flashdata('msg', 'File updated successfully!');
                        $buttonname = $this->input->post('submit');
						if($buttonname == 'Apply'){
							redirect(base_url('admin/homepage_slider/edit_slider/'.$id));
						} else {
							redirect(base_url('admin/homepage_slider'));
						}
                    }
                }
            }
        }
        $sliderdata = $this->common_model->select_data_by_condition('ci_homepage_slider', '*', array('id' => $id));
        $data['id'] = $id;
        $langArr = langArr();
        $Title = !empty($sliderdata[0]['title']) ? unserialize($sliderdata[0]['title']) : '';
        $SubTitle = !empty($sliderdata[0]['sub_title']) ? unserialize($sliderdata[0]['sub_title']) : '';
        $title_heading = !empty($sliderdata[0]['title_heading']) ? unserialize($sliderdata[0]['title_heading']) : '';
        foreach ($langArr as $key => $lVal) {
            $sliderdata[0]['title_' . $key] = !empty($Title) ? $Title[$key] : '';
            $sliderdata[0]['sub_title_' . $key] = !empty($SubTitle) ? $SubTitle[$key] : '';
            $sliderdata[0]['title_heading_' . $key] = !empty($title_heading) ? $title_heading[$key] : '';
        }
        $data['sliderdata'] = $sliderdata;
        $data['title'] = 'Home page Slider Management | Slider List';
        $data['main_page'] = 'backend/homepage_slider/add_form';
        $this->load->view('layout/template',$data);
    }

    /**
     * Datatable record search 
     */
    public function search() {
        $this->session->set_userdata('search_form_status', $this->input->post('search_form_status'));
    }

    /**
     * Check and multidelete record
     */
    public function multidel() {
        $get_records = $this->db->select('*')->from('ci_homepage_slider')->where_in('id', $this->input->post('records_to_del'))->get()->result_array();

        foreach ($get_records as $value) {
            unlink($value['file_name']);
        }

        $this->db->where_in('id', $this->input->post('records_to_del'));
        $this->db->delete('ci_homepage_slider');
        $this->session->set_flashdata('msg', 'Home Page Slider has been deleted successfully!');
        exit();
    }
    
    public function image_size($image, $x, $y) {
        $this->image_moo
                ->load($image)
                ->set_background_colour("#ffffff")
                ->resize($x, $y, TRUE)
                ->save_pa($prepend = '', $append = '', $overwrite = TRUE);
    }

   public function del($id = 0) {
       $get_records = $this->db->select('*')->from('ci_homepage_slider')->where('id', $id)->get()->result_array();

        foreach ($get_records as $value) {
            unlink($value['file_name']);
        }
        $this->db->delete('ci_homepage_slider', array('id' => $id));
       $this->session->set_flashdata('msg', 'Home Page Slider has been deleted successfully!');
        redirect(base_url('admin/homepage_slider'));
    }
    /**
     * Callback function for check Valid URL
     */
    function check_valid_url($url) {
        if (!empty($url)) {
            $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
            if (!preg_match($pattern, $url)) {
                return FALSE;
            }
        }
        return TRUE;
    }

}
