<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('page_model', 'page_model');
        $this->langArr = langArr();
        $this->load->library('image_moo'); 
        //$this->load->library('datatable'); // loaded my custom serverside datatable library
    }

    public function index() {
        // echo 'hi'; die;
        $data['title'] ='Page List';      
        $data['main_page'] = 'backend/pages/page_list';
        $this->load->view('layout/template',$data);
    }

    public function datatable_json() {
       
        $table_name = 'ci_pages';
        $columns = '*';
        $search_columns = 'page_id, page_name_en,page_content,url_type,page_created_at';
        $order_by = 'page_created_at desc';

        // echo $sql = $this->db->last_query(); die;
        // echo 'hi'; die;
        $where = array();
        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());
        $data = array();

        foreach ($records['data'] as $row) {
            $pageContentArr = unserialize($row['page_content']);
            $pagecontentdesc = '';
            if (isset($pageContentArr['page_desc']['en']))  {
                $pagecontentdesc = base64_decode($pageContentArr['page_desc']['en']);
                $pagecontentdesc = trim($pagecontentdesc);
            }
            if (isset($row['page_name_en']) && strlen($row['page_name_en']) <= 40) {
                $row['page_name_en'] = strip_tags($row['page_name_en']);
            } else {
                $row['page_name_en'] = substr(strip_tags($row['page_name_en']), 0, 40) . '...';
            }
            if ($pagecontentdesc != '' && strlen($pagecontentdesc) <= 40) {
                $page_content_en = strip_tags($pagecontentdesc);
            } else {
                $pageContentArr['page_desc']['en'] = $pagecontentdesc;
                $page_content_en = substr(strip_tags($pagecontentdesc), 0, 40) . '';
            }
            $data[] = array(
                '<div class="icheck-primary d-inline"><input type="checkbox" class="chkbox" name="ids[]" value="' . $row['page_id'] . '" id="all_chkbox' . $row['page_id'] . '"><label for="all_chkbox' . $row['page_id'] . '"></label></div>',
                ucwords($row['page_name_en']),
                $page_content_en,
                ucfirst($row['url_type']),
                '<a title="Edit" class="update btn btn-xs btn-primary pull-left" href="' . base_url('admin/pages/edit/' . $row['page_id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;');
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function valid_url($str) {
        return (filter_var($str, FILTER_VALIDATE_URL) !== FALSE);
    }

    public function add() {
        $websiteType = $this->session->userdata('website_type');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            foreach ($this->langArr as $key => $val) {
                $required = '';
                
                    $required = '|required';
                
                $this->form_validation->set_rules('page_name_' . $key, 'Page Name', 'trim' . $required);
            }
            $this->form_validation->set_rules('identifier', 'Page Slug', 'trim|required');
            $this->form_validation->set_rules('url_type', 'Page URL', 'trim|required');
            if ($this->input->post('url_type') == 'customized') {
                $this->form_validation->set_rules('url', 'URL','trim|required|callback_valid_url');
            }
            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
            } else {
                $url_ar = '';
                if ($this->input->post('url_type') == 'internal') {
                    $url = '';
                } else {
                    $url = $this->input->post('url');
                    $url_ar = $this->input->post('url_ar');
                }

                $slug_value = $this->input->post('identifier');
                $unique_slug = $this->common_model->get_unique_slug_pages('ci_pages', 'page_slug', $slug_value);
                
                
                /* new updated code for stor data language wise start here 14/06/2019 */
                $langArr = langArr();
                $pageNameArr = array();
                $pageDescArr = array();
                $pageLongDescArr = array();
                $page_name_en=$page_name_hi='';
                foreach ($langArr as $key => $val) {
                    $page_name[$key] = $this->input->post('page_name_' . $key);
                    $page_desc[$key] = base64_encode($this->input->post('page_content_' . $key));
                    $pageNameArr['page_name'] = $page_name;
                    $pageDescArr['page_desc'] = $page_desc;
                    if ($websiteType == 'b2b') {
                        if ($this->input->post('page_long_content_' . $key) != '') {
                            $page_long_content[$key] = base64_encode($this->input->post('page_long_content_' . $key));
                            $pageLongDescArr['page_long_desc'] = $page_long_content;
                        }
                    }
                    
                    if($key == 'en')
                    {
                        $page_name_en = trim($this->input->post('page_name_' . $key));
                    }
                    if($key == 'hi')
                    {
                        $page_name_hi = trim($this->input->post('page_name_' . $key));
                    }
                }
                $bannerArr=$imageArr=array();
                 foreach ($this->langArr as $key => $val) {
                      
                        if ($_FILES['banner_img_'.$key]['name'] != "") {
                            if (!file_exists("assets/uploads/pages")) {
                                mkdir("assets/uploads/pages", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/pages/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('banner_img_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $filename ='';
                                $attachment = $this->upload->data();
                                $new['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $imageArr[$key] = $new;
                                $filename = $attachment['file_name'];
                             

                               if (move_uploaded_file($_FILES['banner_img_'.$key]["tmp_name"], "assets/uploads/pages/" . $filename)) {

                                    if (!file_exists("assets/uploads/pages/thumb")) {
                                        mkdir("assets/uploads/pages/thumb/", 0777);
                                    }
                                    copy("assets/uploads/pages/" . $filename, "assets/uploads/pages/thumb/" . $filename);
                                    $this->image_size('assets/uploads/pages/thumb/' . $filename,  348,320);
                                }
                            } 
                        }
                    }
                    
                $pageName = serialize($pageNameArr);
                $pageDesc = serialize($pageDescArr);
                /* new updated code for stor data language wise end here 14/06/2019 */
                $data = array(
                    'page_name' => $pageName,
                    'page_name_en' => $page_name_en,
                    'page_name_hi' => $page_name_hi,
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'cms_page' => $this->input->post('cms_page'),
                    'page_name_ku' => trim($this->input->post('page_name_ku')),
                    'page_url' => $url,
                    'page_url_ar' => $url_ar,
                    'page_slug' => $unique_slug,
                    'url_type' => $this->input->post('url_type'),
                    'page_content' => $pageDesc,
                    'banner_image' => serialize($imageArr),
                );
                    if (!empty($pageLongDescArr)) {
                        $pageLongDesc = serialize($pageLongDescArr);
                        $data['page_long_content'] = $pageLongDesc;
                    }
                if (isset($_FILES['page_image']['name']) && $_FILES['page_image']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('page_image')) {
                        echo $this->upload->display_errors();
                    } else {
                        $attachment = $this->upload->data();
                        $data['page_image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_image_ar']['name']) && $_FILES['page_image_ar']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('page_image_ar')) {
                        echo $this->upload->display_errors();
                    } else {
                        $attachment = $this->upload->data();
                        $data['page_image_fr'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_pdf']['name']) && $_FILES['page_pdf']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }
                    $config = array();
                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;
                    
                    $this->load->library('upload', $config, 'dynamic_pdf_en');
                    

                    if (!$this->dynamic_pdf_en->do_upload('page_pdf')) {
                        echo 'sdb';
                        echo $this->dynamic_pdf_en->display_errors();
                    } else {
                        $attachment = $this->dynamic_pdf_en->data();

                        $data['page_pdf'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_pdf_ar']['name']) && $_FILES['page_pdf_ar']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }
                    $config = array();
                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config, 'dynamic_pdf_ar');

                    if (!$this->dynamic_pdf_fr->do_upload('page_pdf_fr')) {
                        echo $this->dynamic_pdf_fr->display_errors();
                    } else {
                        $attachment = $this->dynamic_pdf_fr->data();
                        $data['page_pdf_fr'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                
                
                $this->db->set('page_created_at', 'NOW()', FALSE);
                $result = $this->page_model->add_page($data);
                if ($result) {
                    $last_id = $this->db->insert_id();
                    $this->session->set_flashdata('msg', 'Page has been added successfully!');
                    $buttonname = $this->input->post('submit');
                    if($buttonname == 'Apply'){
                        redirect(base_url('admin/pages/edit/'.$last_id));
                    } else {
                        redirect(base_url('admin/pages'));
                    }
                }
            }
        }

        //$data['view'] = 'backend/pages/page_add';
        $data['websiteType'] = $websiteType;
        $data['title'] = 'Add Page';
        //$this->load->view('layout/template', $data);

        $data['main_page'] = 'backend/pages/page_add';
        $this->load->view('layout/template',$data);
    }

    public function edit($id = 0) {
         $data['title'] = 'Edit Page';
        $websiteType = $this->session->userdata('website_type');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            foreach ($this->langArr as $key => $val) {
                $required = '';
                $required = '|required';
                
                $this->form_validation->set_rules('page_name_' . $key, 'Page Name', 'trim' . $required);
            }
            $this->form_validation->set_rules('identifier', 'Page Slug', 'trim|required');
            $this->form_validation->set_rules('url_type', 'Page URL', 'trim|required');

            if ($this->input->post('url_type') == 'customized') {
                $this->form_validation->set_rules('url', 'URL', 'trim|required|valid_url');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
            } else {
                $page_data = $this->page_model->get_page_by_id($id);
                $url_ar = '';
                if ($this->input->post('url_type') == 'internal') {
                    $url = '';
                } else {
                    $url = $this->input->post('url');
                    $url_ar = $this->input->post('url_ar');
                }
                /* new updated code for stor data language wise start here 14/06/2019 */
                $langArr = langArr();
                $pageNameArr = array();
                $pageDescArr = array();
                $pageLongDescArr = array();
                $page_name_en=$page_name_hi='';
                foreach ($langArr as $key => $val) {
                    $page_name[$key] = $this->input->post('page_name_' . $key);
                    $page_desc[$key] = base64_encode($this->input->post('page_content_' . $key));
                    $pageNameArr['page_name'] = $page_name;
                    $pageDescArr['page_desc'] = $page_desc;
                        if ($this->input->post('page_long_content_' . $key) != '') {
                            $page_long_content[$key] = base64_encode($this->input->post('page_long_content_' . $key));
                            $pageLongDescArr['page_long_desc'] = $page_long_content;
                        }
                    
                    if($key == 'en')
                    {
                        $page_name_en = trim($this->input->post('page_name_' . $key));
                    }
                    if($key == 'hi')
                    {
                        $page_name_hi = trim($this->input->post('page_name_' . $key));
                    }
                }
                $pageName = serialize($pageNameArr);
                $pageDesc = serialize($pageDescArr);

                $bannerArr=$imageArr=array();
                foreach ($this->langArr as $key => $val) {
                        echo "files".$this->input->post('banner_uploaded_img_'.$key);
                        if ($_FILES['banner_img_'.$key]['name'] != "") {
                            echo "files".$this->input->post('banner_uploaded_img_'.$key);
                            if (!file_exists("assets/uploads/pages")) {
                                mkdir("assets/uploads/pages", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/pages/';
                            $config['allowed_types'] = 'jpg|jpeg|png|PNG';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('banner_img_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $filename ='';
                                $attachment = $this->upload->data();
                                $new['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $imageArr[$key] = $new;
                                $filename = $attachment['file_name'];
                             

                               if (move_uploaded_file($_FILES['banner_img_'.$key]["tmp_name"], "assets/uploads/pages/" . $filename)) {

                                    if (!file_exists("assets/uploads/pages")) {
                                        mkdir("assets/uploads/pages/thumb/", 0777);
                                    }
                                    copy("assets/uploads/pages/" . $filename, "assets/uploads/pages/thumb/" . $filename);
                                    $this->image_size('assets/uploads/pages/thumb/' . $filename,  348,320);
                                }
                            } 
                        }
                    

                    
                            if (empty($_FILES['banner_img_'.$key]['name'])) {
                                $imageArr[$key]['image'] = $this->input->post('banner_uploaded_img_'.$key);
                            }else if (!empty($_FILES['banner_img_'.$key]['name'])) {
                                @unlink('assets/uploads/pages/'.$this->input->post('banner_uploaded_img_'.$key));
                                @unlink('assets/uploads/pages/thumb/'.$this->input->post('banner_uploaded_img_'.$key));
                            }
                        

                    }  


                $data = array(
                    'page_name' => $pageName,
                    'page_name_en' => $page_name_en,
                    'page_name_hi' => $page_name_hi,
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_desc' => $this->input->post('meta_desc'),
                    'meta_key' => $this->input->post('meta_key'),
                    'cms_page' => $this->input->post('cms_page'),
                    'page_name_ku' => trim($this->input->post('page_name_ku')),
                    'page_url' => $url,
                    'page_url_ar' => $url_ar,
                    'url_type' => $this->input->post('url_type'),
                    'page_content' => $pageDesc,
                    'banner_image' => serialize($imageArr),
                );
                //echo '<pre>';print_r($data);exit;
                if ($websiteType == 'b2b') {
                    if (!empty($pageLongDescArr)) {
                        $pageLongDesc = serialize($pageLongDescArr);
                        $data['page_long_content'] = $pageLongDesc;
                    }
                }

                if (isset($_FILES['page_image']['name']) && $_FILES['page_image']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('page_image')) {
                        echo $this->upload->display_errors();
                    } else {
                        $attachment = $this->upload->data();
                        if(file_exists($this->input->post('hidden_page_image'))){
                            unlink($this->input->post('hidden_page_image'));
                        }
                        $data['page_image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_image_ar']['name']) && $_FILES['page_image_ar']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('page_image_ar')) {
                        echo $this->upload->display_errors();
                    } else {
                        $attachment = $this->upload->data();
                        if(file_exists($this->input->post('hidden_page_image_fr'))){
                            unlink($this->input->post('hidden_page_image_fr'));
                        }
                        $data['page_image_ar'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_pdf']['name']) && $_FILES['page_pdf']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config, 'dynamic_pdf_en');

                    if (!$this->dynamic_pdf_en->do_upload('page_pdf')) {
                        echo $this->dynamic_pdf_en->display_errors();
                    } else {
                        $attachment = $this->dynamic_pdf_en->data();
                        if (file_exists($this->input->post('hidden_page_pdf'))) {
                            unlink($this->input->post('hidden_page_pdf'));
                        }
                        $data['page_pdf'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }
                if (isset($_FILES['page_pdf_ar']['name']) && $_FILES['page_pdf_ar']['name'] != "") {
                    if (!file_exists("assets/uploads/pages/")) {
                        mkdir("assets/uploads/pages/", 0777);
                    }

                    $config['upload_path'] = 'assets/uploads/pages/';
                    $config['allowed_types'] = 'pdf';
                    $config['max_size'] = 0;
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config, 'dynamic_pdf_ar');


                    if (!$this->dynamic_pdf_fr->do_upload('page_pdf_ar')) {
                        echo $this->dynamic_pdf_fr->display_errors();
                    } else {
                        $attachment = $this->dynamic_pdf_fr->data();
                if (file_exists($this->input->post('hidden_page_pdf_ar'))) {
                            unlink($this->input->post('hidden_page_pdf_ar'));
                        }
                        $data['page_pdf_fr'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                    }
                }

                if ($this->input->post('identifier') != $page_data['page_slug'] && $id == 0) {
                    $slug_value = $this->input->post('identifier');
                    $data['page_slug'] = $this->common_model->get_unique_slug_pages('ci_pages', 'page_slug', $slug_value, $id);
                }

                $result = $this->page_model->edit_page($data, $id);
                if ($result) {
                   // exit;
                    $this->session->set_flashdata('msg', 'Page has been updated successfully!');
                    $buttonname = $this->input->post('submit');
                    if($buttonname == 'Apply'){
                        redirect(base_url('admin/pages/edit/'.$id));
                    } else {
                        redirect(base_url('admin/pages'));
                    }
                }
            }
        }
        $data['websiteType'] = $websiteType;
        $page_data = $this->page_model->get_page_by_id($id);
        $langArr = langArr();

        $page_name = !empty($page['page_name']) ? unserialize($page['page_name']) : '';
        $page_content = !empty($page['page_content']) ? unserialize($page['page_content']) : '';
        $page_long_content = !empty($page['page_long_content']) ? unserialize($page['page_long_content']) : '';
        foreach ($langArr as $key => $lVal) {
            $page['page_name_' . $key] = !empty($page_name) ? $page_name['page_name'][$key] : '';
            $page['page_content_' . $key] = !empty($page_content) ? $page_content['page_desc'][$key] : '';
            $page['page_long_content_' . $key] = !empty($page_long_content) ? $page_long_content['page_long_desc'][$key] : '';
            
        }
        $data['page'] = $page_data;
        $data['main_page'] = 'backend/pages/page_edit';
        $this->load->view('layout/template',$data);
    }

    public function del($id = 0) {
        $this->db->delete('ci_pages', array('page_id' => $id));
        $this->session->set_flashdata('success', 'Pages has been deleted successfully!');
        redirect(base_url('admin/pages'));
    }

    /*
     * check unique slug exist or not for both type (ex. b2b,b2c)
     */

    public function checkUniqueSlug($data) {
        $unique_slug = $this->common_model->get_unique_slug_check_sharp('ci_pages', 'page_name_en', $data);
        if (!$unique_slug) {
            $this->form_validation->set_message('checkUniqueSlug', '<b>' . $data . '</b> is already exist, please try with new %s');
            return false;
        } else {
            // User picked something.
            return true;
        }
    }

    /*
     * unlink and delete image
     */

    public function DeleteImage() {
        $id = $this->input->post('id');
        $lang = $this->input->post('lang');
        if (!empty($id)) {
            $get_records = $this->db->select('*')->from('ci_pages')->where_in('page_id', $id)->get()->result_array();
            foreach ($get_records as $value) {
                if(!empty($lang) && $lang == 'en'){
                    if(file_exists($value['page_image'])){
                        unlink($value['page_image']);
                        $record_deleted = $this->common_model->update_data_by_condition('ci_pages', array('page_image' => ''), array('page_id' => $id));
                    }
                } else if(!empty($lang) && $lang == 'hi'){
                    if(file_exists($value['page_image_hi'])){
                        unlink($value['page_image_ar']);
                        $record_deleted = $this->common_model->update_data_by_condition('ci_pages', array('page_image_hi' => ''), array('page_id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
    }
    /*
     * unlink and delete pdf
    */
    public function DeletePdf() {
        $id = $this->input->post('id');
        $lang = $this->input->post('img_lng');
        if (!empty($id) && !empty($lang)) {
            $get_records = $this->db->select('*')->from('ci_pages')->where_in('page_id', $id)->get()->result_array();
            foreach ($get_records as $value) {
                if(!empty($lang) && $lang == 'en'){
                    if(file_exists($value['page_pdf'])){
                        unlink($value['page_pdf']);
                        $record_deleted = $this->common_model->update_data_by_condition('ci_pages', array('page_pdf' => ''), array('page_id' => $id));
                    }
                } else if(!empty($lang) && $lang == 'hi'){
                    if(file_exists($value['page_pdf_hi'])){
                        unlink($value['page_pdf_ar']);
                        $record_deleted = $this->common_model->update_data_by_condition('ci_pages', array('page_pdf_hi' => ''), array('page_id' => $id));
                    }
                }
                
            }
            return true;
        }
        return false;
    }
    public function image_size($image, $x, $y) {
        $this->image_moo
                ->load($image)
                ->set_background_colour("#ffffff")
                ->resize($x, $y, TRUE)
                ->save_pa($prepend = '', $append = '', $overwrite = TRUE);
    }
    /**
     * Check and multidelete record
     */
    public function multidel() {
        $get_records = $this->db->select('*')->from('ci_pages')->where_in('page_id', $this->input->post('records_to_del'))->get()->result_array();
        foreach ($get_records as $value)
        {
            if(file_exists($value['page_pdf']))
            {
                unlink($value['page_pdf']);
            }
            if(file_exists($value['page_pdf_ar']))
            {
                unlink($value['page_pdf_ar']);
            }
            if(file_exists($value['page_image_ar']))
            {
                unlink($value['page_image_ar']);
            }
            if(file_exists($value['page_image']))
            {
                unlink($value['page_image']);
            }
        }
        $this->db->where_in('page_id', $this->input->post('records_to_del'));
        $this->db->delete('ci_pages');
        
        
        
        //for menu
        $this->db->where_in('pageid', $this->input->post('records_to_del'));
        $this->db->delete('ci_menus');
       
        $this->session->set_flashdata('msg', 'Pages has been deleted successfully!');
        exit();
    }    
  

}

?>
