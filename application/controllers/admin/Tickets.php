<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tickets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang_helper = langArr();   
        $this->load->library('image_moo');     
    }

    public function index() {
        $data['title'] = 'Tickets List';
        $data['main_page'] = 'backend/tickets/list';
        $this->load->view('layout/template', $data);
    }

    public function add_edit_form($id = '-1') {

        if($id=='-1'){
        $data['title'] = 'Add Ticket';
        }else{
         $data['title'] = 'Edit Ticket';
        }

       
        $form_details = $this->common_model->get_details('tickets', array('id' => $id), $id);
        $data['form_details'] = $form_details;

        $data['user_type'][0] = array('id'=>1,'user_type'=>'Contacts');
        $data['user_type'][1] = array('id'=>2,'user_type'=>'Organizations');

        $data['ticket_status'][0] = array('id'=>1,'ticket_status'=>'Open');
        $data['ticket_status'][1] = array('id'=>2,'ticket_status'=>'In Progress');
        $data['ticket_status'][2] = array('id'=>3,'ticket_status'=>'Wait For Response');
        $data['ticket_status'][3] = array('id'=>4,'ticket_status'=>'Closed');

        $this->db->select('id,CONCAT(first_name , " ", last_name  )as name');
        $this->db->where('status',1);
        $this->db->where_in('role_id', ['1','2','3']);
        $data['users'] = $this->db->get('user_master')->result_array();
        $data['id'] = $id;
        $data['main_page'] = 'backend/tickets/add_edit_form';
        $this->load->view('layout/template', $data);
    }

    public function datatable_json() 
    {
        $where_arr = array('status' => 1);
        $ticket_status = $this->common_model->get_records('ticket_status','',$where_arr);

        $table_name = 'tickets';
        $columns = '*';
        $search_columns = 'id, title,status, desc';
        $order_by = 'created_at desc';
        $where = array('status !=' => '2');
        $records = $this->common_model->json_datatable($table_name, $columns, $where, $order_by, $search_columns, $joins = array());
        $data = array();
        foreach ($records['data'] as $key=>$row) {
            $data[$key][] = '<div class="icheck-primary d-inline"><input type="checkbox" class="chkbox" name="ids[]" value="' . $row['id'] . '" id="all_chkbox'.$row['id'].'"><label for="all_chkbox'.$row['id'].'"></label></div>';

            $data[$key][] = '<span class="">' . $row['title_en'] . '<span>';

            $data[$key][] = '<span class="">' . date('d-m-Y H:i:s', strtotime($row['created_at'])) . '<span>';

            $data[$key][] = ($row['status'] == 0)?'<span class="badge badge-danger">Deactive</span>':'<span class="badge badge-success">Active</span>';

            $html = '<select onchange="ticket_status('.$row['id'].');" id="ticket-status'.$row['id'].'" data-id="'.$row['id'].'" name="status[]" required class="form-control select2">';
            $html .= '<option value="">Select</option>';
            foreach ($ticket_status as $value) {
                $html .= '<option '.(($row['ticket_status'] == $value['id'])?"selected":"").' value="'.$value['id'].'">'.$value['ticket_status'].'</option>';
            }
            $html .= '</select>';
            $data[$key][] = $html;

            $data[$key][] = '<a title="Edit" class="update btn btn-xs btn-primary" href="' . base_url('admin/tickets/add_edit_form/' . $row['id']) . '"> <i class="fa fas fa-pencil-alt"></i></a>&nbsp;&nbsp;&nbsp;'.
                '<a title="Delete" href="javascript:void(0)" class="delete btn btn-xs btn-danger pull-right" style="color:#fff;margin-left:5px" data-href="' . base_url('admin/tickets/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="fa fa-trash-alt"></i></a>';
        }
        $records['data'] = $data;
        echo json_encode($records);
    }

    function check_unique($string) {
        $this->db->select('title');
        $this->db->from('tickets');
        if ($string != '') {
            $this->db->like('title', $string);
        } else {
            $this->db->where('title', $string);
        }
        $this->db->where('status !=',2);
        $query = $this->db->get();
        $result = $query->row();

        if (!empty($result)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function save($id = -1) {
        if ($this->input->post('submit')) {
            //echo '<pre>';print_r($_POST);exit;
            foreach ($this->lang_helper as $key => $val){
                $required = '';
                $required = '|required';
                $max_length='|max_length[85]';

             
                if ($id == -1) {
                    $this->form_validation->set_rules('title_' . $key, 'Title [' . $val . ']','trim|max_length[85]' . $required.$max_length, array('required' => 'This Title [' . $val . ']  is required'));
                    //$this->form_validation->set_rules('slug', 'Slug', 'trim|required');
                } else {
                    $this->form_validation->set_rules('title_' . $key, 'Title [' . $val . ']', 'trim|max_length[85]' . $required.$max_length);
                }
            }
            //$this->form_validation->set_rules('assign_user', 'Slug', 'trim|required');
            //$this->form_validation->set_rules('order', 'Navigation Order', 'trim|required|max_length[4]');
            if ($this->form_validation->run() == FALSE) {
                $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', validation_errors());
                $this->add_edit_form($id);
            } else {
                if ($id == -1) {
                    $checkcat=$this->common_model->getRow_Val('select id from tickets where title_en="'.$this->input->post('title_en').'" and status != 2');
                }  else {
                    $checkcat=$this->common_model->getRow_Val('select id from tickets where id!="'.$id.'" and title_en="'.$this->input->post('title_en').'" and status != 2');
                }

                //echo '<pre>';print_r($checkcat);exit;
                
                if(!empty($checkcat)) {
                    $this->common_model->flash_alert_message('warning', '<i class="fa fa-warning"></i> Form Error!', 'Title already exists, please try another!!');
                    $this->add_edit_form($id);
                } else {
                    $titleArr = $linkArr = array();
                    $descArr = array();
                    $title_fr = $title_en = '';
                    foreach ($this->lang_helper as $key => $val) {
                        $titleArr[$key] = $this->input->post('title_' . $key);
                        if($key == 'en')  {
                            $title_en = trim($this->input->post('title_' . $key));
                        }                        
                        $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

                    } 
                                    
                    $insert_update = array(
                        'title' => serialize($titleArr),
                        'title_en' => $title_en,
                        'desc' => serialize($descArr),
                        'user_id' => $this->input->post('user_id'),
                        'user_type'=>$this->input->post('user_type'),
                        'ticket_status'=>$this->input->post('ticket_status'),
                        'cat_order' => $this->input->post('order'),
                        'assign_user' => $this->input->post('assign_user'),
                        'stall_no' => $this->input->post('stall_no'),
                        'slug' => $this->input->post('slug'),
                    );
                    //echo '<pre>';print_r($insert_update);exit;
                    if ($id == -1) {
                        $insert_update['created_by'] = $_SESSION['user_id'];
                        $this->db->set('created_at', 'NOW()', FALSE);
                        $this->db->set('updated_at', 'NOW()', FALSE);
                        $result = $this->common_model->insert_data('tickets', $insert_update);
                        $last_id = $this->db->insert_id();
                        if ($result) {
                            $this->session->set_flashdata('success', 'Category has been added successfully!');
                            if($this->input->post('submit')=="Apply"){
                                redirect(base_url('admin/tickets/add_edit_form/'.$last_id));
                            }else{
                                redirect(base_url('admin/tickets'));                                
                            }
                        }
                    } else {
                        $insert_update['updated_by'] = $_SESSION['user_id'];
                        $this->db->set('updated_at', 'NOW()', FALSE);
                        $result = $this->common_model->update_data('tickets', $insert_update, array('id' => $id));
                        if ($result) {
                            $this->session->set_flashdata('success', 'Category has been updated successfully!');
                            if($this->input->post('submit')=="Apply"){
                                redirect(base_url('admin/tickets/add_edit_form/'.$id));
                            }else{
                                redirect(base_url('admin/tickets'));                                
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     * Check and multidelete record and delete image also
     */
    public function multidel() {
        $ids = $this->input->post('records_to_del');
        if (!empty($ids)) {
            foreach ($ids as $val) {
                $title = $this->common_model->select_data_by_condition('tickets', 'banner_image', array('id' => $val));
                if (!empty($title)) {
                    foreach ($title as $val) {
                        if (!empty($val['banner_image'])) {
                            $imgArr = unserialize($val['banner_image']);
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
        $this->db->delete('tickets');
        $this->session->set_flashdata('success', 'Category has been deleted successfully!');
        exit();
    }
    
    
    
     public function del($id = 0) 
     {  
        if (!empty($id)) {
            $tabledata['status'] = '2';
            $this->db->where('id',$id);
            $this->db->update('tickets',$tabledata);
            $this->session->set_flashdata('success', 'Category has been deleted successfully!');
            redirect(base_url('admin/tickets'));
        } 
    }

    /**
     * Check and delete image record
     */
    public function DeleteImage() {
        $img_lng = $this->input->post('img_lng');
        $id = $this->input->post('id');
        $title = $this->common_model->select_data_by_condition('tickets', 'banner_image', array('id' => $id));
        if (!empty($title)) {
            foreach ($title as $val) {
                if (!empty($val['banner_image'])) {
                    $imgArr = unserialize($val['banner_image']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("title","title/thumb",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('tickets', array('banner_image' => $newImgArr), array('id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
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
    public function get_users()
    {
        $id = $_POST['id'];
        $data[0] = array("id"=>"", "text"=>"Select");
        if($id == 1){
            $where_arr = array('status' => 1);
            $contacts = $this->common_model->get_records('contact','',$where_arr);
            if($contacts)
            {
                foreach($contacts as $row){
                    $data[] = array("id"=>$row['id'], "text"=>trim($row['firstname'].' '.$row['lastname']));
                }
            }
        }else{
            $where_arr = array('status' => 1,'role_id'=>4);
            $contacts = $this->common_model->get_records('user_master','',$where_arr);
            if($contacts)
            {
                foreach($contacts as $row){
                    $data[] = array("id"=>$row['id'], "text"=>trim($row['first_name'].' '.$row['last_name']));
                }
            }
        }
        echo json_encode($data);
    }
    public function ticket_status() 
    {
        $id = trim($_POST['id']);
        $status = trim($_POST['status']);
        $data['ticket_status'] = $status;
        $where_array = array('id' => $id);
        $update = $this->common_model->update_records('tickets',$data,$where_array);
        $response = array();
        if($update){
            $response['success'] = 1;
            $response['message'] = 'Status is updated successfully.';
        }else{
            $response['success'] = 0;
            $response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
    }
}

?>