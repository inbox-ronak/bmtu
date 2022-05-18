<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ads extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang_helper = langArr();  
        $this->load->library('image_moo');   
    }

    public function index() {
        $this->session->unset_userdata('search_form_status');
        $data['title'] = 'Ads List';
        $data['main_page'] = 'backend/ads/list';
        $this->load->view('layout/template',$data);
    }

    public function add_edit_form($id = -1) {
        $data['title'] = 'Add Ads';
        $form_details = $this->common_model->get_details('ci_ads', array('id' => $id), $id);
        $where = array('is_active' =>1);
        $data['page_data'] = $this->common_model->getrows('ci_pages', 'page_id,page_name_en,page_slug', $where);
        //print_r($data['page_data']);die;
        $data['form_details'] = $form_details;
        $data['id'] = $id;
        if ($id > 0 && empty($form_details)) {
            $data['title'] = $this->lang->line('page_not_found');
            $data['page_title'] = $this->lang->line('page_not_found');
            $data['heading'] = $this->lang->line('page_not_found') . "!";
            $data['message'] = "<a href=" . base_url('admin/news/') . ">" . 'Go Back To Previous Page' . "</a>";
            $data['main_page'] = 'admin/error_404';
        } 
        else {
            if ($id == -1) {
                $data['title'] = 'Add Ads';
            } else {
                $data['title'] = 'Edit Ads';
            } 
            $data['main_page'] = 'backend/ads/add_edit_form';
        }
      
        $this->load->view('layout/template',$data);
    }

    public function save($id = -1) {

        if ($this->input->post()) {
            $login_id = $this->session->userdata('user_id');     
            $this->form_validation->set_rules('page_slug', 'Page Name', 'trim|required');
            $this->form_validation->set_rules('status', ' Status', 'trim|required');
            //    foreach ($this->lang_helper as $key => $val)
            //    {
            //     if($key =='en'){
            //     $required = '';
            //      $required = '|required';
             
            //     if ($id == -1) {
            //         $this->form_validation->set_rules("top_ads_".$key, " Top Ads Image ".$val, "trim|required");                   
            //         $this->form_validation->set_rules("left_ads_".$key, " Left Ads Image".$val, "trim|required");                   
            //         $this->form_validation->set_rules("right_ads_".$key, " Right Ads Image ".$val, "trim|required");                   
            //         $this->form_validation->set_rules("bottom_ads_".$key, " Bottom Ads Image ".$val, "trim|required");                   
            //         }

            // }   
            // }      

            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->add_edit_form($id);
            }  else {

                    $top_ads = $left_ads =$right_ads= $bottom_ads =  array();
                    $top_ads_url = $left_ads_url = $right_ads_url = $bottom_ads_url = array();

                    foreach ($this->lang_helper as $key => $val) {
                      
                        if ($_FILES['top_ads_'.$key]['name'] != "") {
                            if (!file_exists("assets/uploads/ads")) {
                                mkdir("assets/uploads/ads", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/ads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('top_ads_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $top_ads_filename ='';
                                $attachment = $this->upload->data();
                                $new['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $top_ads[$key] = $new;
                                $top_ads_filename = $attachment['file_name'];

                               if (move_uploaded_file($_FILES['top_ads_'.$key]["tmp_name"], "assets/uploads/ads/" . $top_ads_filename)) {

                                    if (!file_exists("assets/uploads/ads")) {
                                        mkdir("assets/uploads/ads/thumb/", 0777);
                                    }
                                    copy("assets/uploads/ads/" . $top_ads_filename, "assets/uploads/ads/thumb/" . $top_ads_filename);
                                    $this->image_size('assets/uploads/ads/thumb/' . $top_ads_filename,  348,320);
                                }
                            } 
                        }
                    

                        if ($id > 0) {
                            if (empty($_FILES['top_ads_'.$key]['name'])) {
                                if(!empty($this->input->post('hidden_top_ads_'.$key))){
                                     $top_ads[$key]['image'] = $this->input->post('hidden_top_ads_'.$key);
                                 }
                            }else if (!empty($_FILES['top_ads_'.$key]['name'])) {
                                @unlink('assets/uploads/ads/'.$this->input->post('hidden_top_ads_'.$key));
                                @unlink('assets/uploads/ads/thumb/'.$this->input->post('hidden_top_ads_'.$key));
                            }
                        }

                        $top_ads_url[$key] = $this->input->post('top_ads_url_' . $key);



                    }  


                    foreach ($this->lang_helper as $key => $val) {
                      
                        if ($_FILES['left_ads_'.$key]['name'] != "") {
                            if (!file_exists("assets/uploads/ads")) {
                                mkdir("assets/uploads/ads", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/ads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('left_ads_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $left_ads_filename ='';
                                $attachment = $this->upload->data();
                                $left_ads_news['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $left_ads[$key] = $left_ads_news;
                                $left_ads_filename = $attachment['file_name'];

                               if (move_uploaded_file($_FILES['left_ads_'.$key]["tmp_name"], "assets/uploads/ads/" . $left_ads_filename)) {

                                    if (!file_exists("assets/uploads/ads")) {
                                        mkdir("./uploads/ads/thumb/", 0777);
                                    }
                                    copy("assets/uploads/ads/" . $left_ads_filename, "assets/uploads/ads/thumb/" . $left_ads_filename);
                                    $this->image_size('assets/uploads/ads/thumb/' . $left_ads_filename,  348,320);
                                }
                            } 
                        }
                    

                        if ($id > 0) {
                            if (empty($_FILES['left_ads_'.$key]['name'])) {
                                if(!empty($this->input->post('hidden_left_ads_'.$key))){
                                     $left_ads[$key]['image'] = $this->input->post('hidden_left_ads_'.$key);
                                }
                               
                            }else if (!empty($_FILES['left_ads_'.$key]['name'])) {
                                @unlink('assets/uploads/ads/'.$this->input->post('hidden_left_ads_'.$key));
                                @unlink('assets/uploads/ads/thumb/'.$this->input->post('hidden_left_ads_'.$key));
                            }
                        }

                        $left_ads_url[$key] = $this->input->post('left_ads_url_' . $key);

                    } 


                    foreach ($this->lang_helper as $key => $val) {
                      
                        if ($_FILES['right_ads_'.$key]['name'] != "") {
                            if (!file_exists("assets/uploads/ads")) {
                                mkdir("assets/uploads/ads", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/ads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('right_ads_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $right_ads_filename ='';
                                $attachment = $this->upload->data();
                                $right_ads_news['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $right_ads[$key] = $right_ads_news;
                                $right_ads_filename = $attachment['file_name'];

                               if (move_uploaded_file($_FILES['right_ads_'.$key]["tmp_name"], "assets/uploads/ads/" . $right_ads_filename)) {

                                    if (!file_exists("assets/uploads/ads")) {
                                        mkdir("assets/uploads/ads/thumb/", 0777);
                                    }
                                    copy("assets/uploads/ads/" . $right_ads_filename, "assets/uploads/ads/thumb/" . $right_ads_filename);
                                    $this->image_size('assets/uploads/ads/thumb/' . $right_ads_filename,  348,320);
                                }
                            } 
                        }
                    

                        if ($id > 0) {
                            if (empty($_FILES['right_ads_'.$key]['name'])) {
                                if(!empty($this->input->post('hidden_right_ads_'.$key))){
                                   $right_ads[$key]['image'] = $this->input->post('hidden_right_ads_'.$key);  
                                }
                               
                            }else if (!empty($_FILES['right_ads_'.$key]['name'])) {
                                @unlink('assets/uploads/ads/'.$this->input->post('hidden_right_ads_'.$key));
                                @unlink('assets/uploads/ads/thumb/'.$this->input->post('hidden_right_ads_'.$key));
                            }
                        }

                        $right_ads_url[$key] = $this->input->post('right_ads_url_' . $key);

                    } 


                      // ==== Bottom =================//
                    foreach ($this->lang_helper as $key => $val) {
                      
                        if ($_FILES['bottom_ads_'.$key]['name'] != "") {
                            if (!file_exists("./uploads/ads")) {
                                mkdir("assets/uploads/ads", 0777);
                            }
                            $config['upload_path'] = 'assets/uploads/ads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['max_size'] = 0;
                            $config['encrypt_name'] = TRUE;

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('bottom_ads_'.$key)) {
                                echo $this->upload->display_errors();
                            } else {
                                $bottom_ads_filename ='';
                                $attachment = $this->upload->data();
                                $bottom_new['image'] = setImagePath() . $config['upload_path'] . $attachment['file_name'];
                                $bottom_ads[$key] = $bottom_new;
                                $bottom_ads_filename = $attachment['file_name'];

                               if (move_uploaded_file($_FILES['bottom_ads_'.$key]["tmp_name"], "assets/uploads/ads/" . $bottom_ads_filename)) {

                                    if (!file_exists("assets/uploads/ads")) {
                                        mkdir("assets/uploads/ads/thumb/", 0777);
                                    }
                                    copy("assets/uploads/ads/" . $bottom_ads_filename, "assets/uploads/ads/thumb/" . $bottom_ads_filename);
                                    $this->image_size('assets/uploads/ads/thumb/' . $bottom_ads_filename,  348,320);
                                }
                            } 
                        }
                    

                        if ($id > 0) {
                            if (empty($_FILES['bottom_ads_'.$key]['name'])) {
                                if(!empty($this->input->post('hidden_bottom_ads_'.$key))){
                                $bottom_ads[$key]['image'] = $this->input->post('hidden_bottom_ads_'.$key);
                                }
                            }else if (!empty($_FILES['bottom_ads_'.$key]['name'])) {
                                @unlink('assets/uploads/ads/'.$this->input->post('hidden_bottom_ads_'.$key));
                                @unlink('assets/uploads/ads/thumb/'.$this->input->post('hidden_bottom_ads_'.$key));
                            }
                        }
                         $bottom_ads_url[$key] = $this->input->post('bottom_ads_url_' . $key);

                    } 


                $insert_update = 
                array(
                    'page_slug' => $this->input->post('page_slug'),                   
                    'top_ads' => serialize($top_ads),
                    'left_ads' => serialize($left_ads),
                    'right_ads' => serialize($right_ads),
                    'bottom_ads' => serialize($bottom_ads),
                    'top_ads_url' => serialize($top_ads_url),
                    'left_ads_url' => serialize($left_ads_url),
                    'right_ads_url' => serialize($right_ads_url),
                    'bottom_ads_url' => serialize($bottom_ads_url),
                    'status' => $this->input->post('status'),                                  
                );
                if ($id == -1) {
                    $this->db->set('created_at', 'NOW()', FALSE);
                    $this->db->set('updated_at', 'NOW()', FALSE);
                    $insert_update['created_by'] = $login_id;
                    $result = $this->common_model->insert_data('ci_ads', $insert_update);
                    $insert_id = $this->db->insert_id();
                    if ($result) {
                        $this->session->set_flashdata('msg', 'Ads has been added successfully!');
                        if ($this->input->post('submit') == 'Apply') {
                          redirect(base_url('admin/ads/add_edit_form/' . $insert_id));
                        } else {
                          redirect(base_url('admin/ads'), 'refresh');
                        }
                    }

                } else {

                    $this->db->set('updated_at', 'NOW()', FALSE);
                    $insert_update['updated_by'] = $login_id;
                     $update = array(
                             'page_slug' => $this->input->post('page_slug'), 
                             'status' => $this->input->post('status'), 
                             'top_ads_url' => serialize($top_ads_url),
                             'left_ads_url' => serialize($left_ads_url),
                             'right_ads_url' => serialize($right_ads_url),
                             'bottom_ads_url' => serialize($bottom_ads_url)                                 
                        );
                     if(!empty($top_ads)){
                        $update['top_ads'] = serialize($top_ads);
                     }
                     if(!empty($left_ads)){
                        $update['left_ads'] = serialize($left_ads);
                     }
                     if(!empty($right_ads)){
                        $update['right_ads'] = serialize($right_ads);
                     }
                     if(!empty($bottom_ads)){
                        $update['bottom_ads'] = serialize($bottom_ads);
                     }


                    $result = $this->common_model->update_data('ci_ads', $update, array('id' => $id));
                    
                    if ($result) {
                        $this->session->set_flashdata('msg', 'Ads has been Updated successfully!');
                        if ($this->input->post('submit') == 'Apply') {
                            redirect(base_url('admin/ads/add_edit_form/' . $id));
                        } else {
                            redirect(base_url('admin/ads'), 'refresh');
                        }
                    }

                }
            }
        }
    }

    public function datatable_json() {
        $table_name = 'ci_ads';
        $columns = '*';
        $search_columns = 'page_slug';
        $order_by = 'id desc';
        $where = array();
        if ($this->session->userdata('search_form_status') != '') {
            $where['ci_ads.status'] = $this->session->userdata('search_form_status');
        }

        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());
        $data = array();


        foreach ($records['data'] as $row) {

                        $position_html ='';
                        $top_checked = '';
                        $left_checked = '';
                        $right_checked = '';
                        $bottom_checked = '';
                        $top_ads_array = $left_ads_array = $right_ads_array = $bottom_ads_array = array();


                        if(!empty($row['top_ads'])){
                            $top_ads_array = unserialize($row['top_ads']);
                        }
                        $top_ads_flag = 0;
                        if(!empty($top_ads_array)){
                        	foreach ($top_ads_array as $key_top => $value_top) {
                        		if(!empty($value_top['image'])){
                        			$top_ads_flag = 1;
                        		}                        		
                        	}
                        	if($top_ads_flag >0){
                        		 $top_checked = 'checked';
                        	}
                           
                        }
                        // == left 
                          $left_ads_flag = 0;
                         if(!empty($row['left_ads'])){
                            $left_ads_array = unserialize($row['left_ads']);
                          }
                        if(!empty($left_ads_array)){
                        	foreach ($left_ads_array as $key_left => $value_left) {
                        		if(!empty($value_left['image'])){
                        			$left_ads_flag = 1;
                        		}                        		
                        	}
                        	if($left_ads_flag >0){
                        		 $left_checked = 'checked';
                        	}                            
                        }
                        //right

                         $right_ads_flag = 0;

                         if(!empty($row['right_ads'])){
                            $right_ads_array = unserialize($row['right_ads']);
                        }
                        if(!empty($right_ads_array)){
                            
                            foreach ($right_ads_array as $key_right => $value_right) {
                        		if(!empty($value_right['image'])){
                        			$right_ads_flag = 1;
                        		}                        		
                        	}
                        	if($right_ads_flag >0){
                        		 $right_checked = 'checked';
                        	}
                        }

                               // bottom

                         $bottom_ads_flag = 0;
                         if(!empty($row['bottom_ads'])){
                            $bottom_ads_array = unserialize($row['bottom_ads']);
                          }

                        if(!empty($bottom_ads_array)){
                        	foreach ($bottom_ads_array as $key_bottom => $value_bottom) {
                        		if(!empty($value_bottom['image'])){
                        			$bottom_ads_flag = 1;
                        		}                        		
                        	}
                        	if($bottom_ads_flag >0){
                        		 $bottom_checked = 'checked';
                        	}                            
                        }

                        $position_html.= '<input type="checkbox" id="top" disabled name="top" value="1" '.$top_checked.'>
                              <label for="top" style="margin-top:-5px" > Top</label>
                              <input type="checkbox" id="left" name="left" disabled value="1" '.$left_checked.' >
                              <label for="left" style="margin-top:-5px" > Left</label>
                              <input type="checkbox" id="right" name="right" disabled value="1" '.$right_checked.' >
                              <label for="right" style="margin-top:-5px" > Right</label>
                              <input type="checkbox" id="bottom" name="bottom" disabled value="1" '.$bottom_checked.'>
                              <label for="bottom" style="margin-top:-5px" > Bottom </label>';  

           
            if ($row['status'] == 1) {
                $status = '<span class="btn-xs btn-success btn-flat btn-xs">Active<span>';
            }else{
                 $status = '<span class="btn-xs btn-danger btn-flat btn-xs">Inactive<span>';
            }

            $delete_faq = '<a style="margin-left:5px;color:#fff" title="Delete" class="update btn btn-xs btn-danger" onclick="ConfirmDelete(' . $row['id'] . ')" > <i class="fa fas fa-trash-alt"></i></a>';

            $data[] = array(
                '<div class="icheck-primary d-inline"><input type="checkbox" class="chkbox" name="ids[]" value="' . $row['id'] . '" id="all_chkbox'.$row['id'].'"><label for="all_chkbox'.$row['id'].'"></label></div>',

                '<span class="">' . ucfirst($row['page_slug']) . '<span>', 
                $position_html,
                $status,
                '<a title="Edit" class="update btn btn-xs btn-primary" href="' . base_url('admin/ads/add_edit_form/' . $row['id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>'
                
            );
        }
       
        $records['data'] = $data;
        echo json_encode($records);
    }

    public function search() {
        $this->session->set_userdata('search_form_status', $this->input->post('search_form_status'));
    }

       public function multidel() {
        $ids = $this->input->post('records_to_del');
        if (!empty($ids)) {
            foreach ($ids as $val) {
                $news = $this->common_model->select_data_by_condition('ci_ads', 'top_ads,left_ads,right_ads,bottom_ads', array('id' => $val));
                if (!empty($news)) {
                    foreach ($news as $val) {
                        //== remove top image =========
                        if (!empty($val['top_ads'])) {
                            $imgArr = unserialize($val['top_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        //=======Remove left image ===========//

                         if (!empty($val['left_ads'])) {
                            $imgArr = unserialize($val['left_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        // ============Remove Right image =======//

                         if (!empty($val['right_ads'])) {
                            $imgArr = unserialize($val['right_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        // ======== Remove Bottom image =======//

                         if (!empty($val['bottom_ads'])) {
                            $imgArr = unserialize($val['bottom_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }
        $this->db->where_in('id', $this->input->post('records_to_del'));
        $this->db->delete('ci_ads');
        $this->session->set_flashdata('msg', 'Ads has been deleted successfully!');
        exit();
    }

    public function delete($id = '') {
        $this->db->delete('ci_ads', array('id' => $id));        
        $this->session->set_flashdata('msg', 'Ads  Deleted successfully!');
        redirect(base_url('admin/ads'), 'refresh');
     
    }
   /* function for create thumbnil image 
     *  pass the image path and height and width 
     */

    public function image_size($image, $x, $y) {
        $this->image_moo
                ->load($image)
                ->set_background_colour("#ffffff")
                ->resize($x, $y, TRUE)
                ->save_pa($prepend = '', $append = '', $overwrite = TRUE);
    }

   public function del($id = 0) {
         
             if (!empty($id)) {          
                $news = $this->common_model->select_data_by_condition('ci_ads', '*', array('id' => $id));
                if (!empty($news)) {
                    foreach ($news as $val) {
                        //== remove top image =========
                        if (!empty($val['top_ads'])) {
                            $imgArr = unserialize($val['top_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        //=======Remove left image ===========//

                         if (!empty($val['left_ads'])) {
                            $imgArr = unserialize($val['left_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        // ============Remove Right image =======//

                         if (!empty($val['right_ads'])) {
                            $imgArr = unserialize($val['right_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                        // ======== Remove Bottom image =======//

                         if (!empty($val['bottom_ads'])) {
                            $imgArr = unserialize($val['bottom_ads']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                    }
                }         
                
         $this->db->delete('ci_ads', array('id' => $id));
         $this->session->set_flashdata('msg', 'Ads has been deleted successfully!');
        redirect(base_url('admin/ads'));
        }
        
    }



    /**
     * Check and delete image record
     */
    public function DeleteImage() {
        $img_lng = $this->input->post('img_lng');
        $id = $this->input->post('id');
        $news = $this->common_model->select_data_by_condition('ci_ads', '*', array('id' => $id));
        if (!empty($news)) {
            foreach ($news as $val) {
                $newImgArr = array();
                if (!empty($val['top_ads'])) {
                    $imgArr = unserialize($val['top_ads']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("ads","ads",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('ci_ads', array('top_ads' => $newImgArr), array('id' => $id));
                    }
                }
                    $newImgArr = array();
                   if (!empty($val['left_ads'])) {
                    $imgArr = unserialize($val['left_ads']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("ads","ads",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('ci_ads', array('left_ads' => $newImgArr), array('id' => $id));
                    }
                }
                   $newImgArr = array();
                   if (!empty($val['right_ads'])) {
                    $imgArr = unserialize($val['right_ads']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("ads","ads",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('ci_ads', array('right_ads' => $newImgArr), array('id' => $id));
                    }
                }

                   $newImgArr = array();
                   if (!empty($val['bottom_ads'])) {
                    $imgArr = unserialize($val['bottom_ads']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("ads","ads",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('ci_ads', array('bottom_ads' => $newImgArr), array('id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
    }
     /* function for  Check URL Validation for Each Language 
     *  
     */

    public function check_valid_url( $param ){
      if( ! filter_var($param, FILTER_VALIDATE_URL) ){
        $this->form_validation->set_message('check_valid_url', 'The {field} must be a valid url');
        return FALSE;
      }else{
        return TRUE;
      }
  
    } 

    public function view_news($id = -1){
        $table_name = 'ci_news';
        $columns = '*';
        $where = array("ci_news.id" => $id);
        $joins = array();
        $joins = array();
        $data['news_details'] = $news_details=$this->common_model->getRow($table_name,$columns, $where,$other_condition = "", $order_by = "", $sort_type = "", $limit = 0, $offset = 0, $group_by = "", $joins=array()); 

        $data['title'] = 'View News | etender';
        $data['main_page'] = 'backend/news/news_view';
        $this->load->view('layout/template',$data);
    }
}
