<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('menu_model');
        $this->load->model('page_model');
        
    }

    public function index() {

        $data['title'] = 'Menu Manager | Etender';

		$mst_menu_id = 0;
		$data['records'] = $this->common_model->getRows('ci_pages', '*',array('is_active' => 1),'','page_name_en','asc');
        
        if ($this->input->post('hidden_mst_menu_id_post')) {
            $mst_menu_id = $this->input->post('hidden_mst_menu_id_post');
        } else {
            $mst_menu_asc_id = $this->common_model->getRow('ci_mst_menu', 'id', array('status' => 1), '','menu_name', 'asc');
            //echo $sql = $this->db->last_query();die;

            if (!empty($mst_menu_asc_id)) {
                $mst_menu_id = $mst_menu_asc_id['id'];
            }
        }

// echo $mst_menu_id; die;
        $menu_arr = $this->menu_model->get_generate_menu2($mst_menu_id);
        // echo $mst_menu_id; die;
        $menuArray = array();
        if (!empty($menu_arr)) {
            $i = 0;
            foreach ($menu_arr as $value) {
                $menuArray[] = array(
                    'mid' => $value['mid'],
                    'id' => $value['id'],
                    'text' => strtoupper($value['text']),
                    'menu_type' => $value['menu_type']
                );

                $subarray = $this->common_model->getRows('ci_menus','*',array('mst_menu_id'=>$mst_menu_id,'parent_id'=>$value['mid'],'active'=>1),'','order_no','asc');
               
                if (!empty($subarray)) {
                    foreach ($subarray as $subarrayi) {
                        if ($subarrayi->menu_type == 1 || $subarrayi->menu_type == 0) {
                            if (!empty($this->menu_model->get_sub_menu1($value['mid'], $mst_menu_id))) {
                                $menuArray[$i]['children'] = $this->menu_model->get_sub_menu1($value['mid'], $mst_menu_id);
                            }
                        }
                    }
                }
                $i++;
            }
        }
   
        $data["menu_arr"] = json_encode($menuArray);

        $data['mst_menu_list'] = $this->common_model->getRows('ci_mst_menu', 'id,menu_name', array('status' => 1),'', 'menu_name', 'asc');
        $data['mst_menu_asc_id'] = $mst_menu_id;

        $data['main_page'] = 'backend/menus/generate';
        $this->load->view('layout/template',$data);
    }

    public function add_menu() {
        if ($this->input->post('pageid') != '') {
            $this->menu_model->add_menu($this->input->post('pageid'), trim($this->input->post('hidden_mst_menu_id')), 'page');
            //echo TRUE;
            $this->session->set_flashdata('msg', 'Page added successfully.');
            exit;
        } else {
            $this->session->set_flashdata('alert', 'Please select at least 1 page.');
        }
    }

    public function save_menu() {
        $post = $this->input->post();
        $mst_menu_id = $post['mst_menu_id'];
		$menu_name = $post['menu_name'];
        //$this->menu_model->reset_list($mst_menu_id);
        $arrs = json_decode($post['text'], true);
        $order_no = 1;
        if (!empty($arrs)) {
            $order_no = 1;
            foreach ($arrs as $value) {
                $this->menu_model->update_order($value['mid'], $order_no, '', $mst_menu_id);
                if (isset($value['children'])) {
                    $this->menu_model->update_order1($value, $mst_menu_id);
                }
                $order_no++;
            }
        }

        //Update Menu Name 
        $this->common_model->update_data('ci_mst_menu', array('menu_name' => $menu_name), array('id' => $mst_menu_id));
        echo "success";
    }

    public function reset_list() {
        $mst_menu_id = $this->input->post('mst_menu_id');
        $this->menu_model->reset_list($mst_menu_id);
    }

    public function delete_menu() {
        //$delete_data = $this->common_model->
        $this->menu_model->delete_menu($this->input->post('mid'));
        echo TRUE;
        $this->session->set_flashdata('msg', 'Page removed from menu successfully.');
        redirect(base_url('admin/menus'));
        exit;
    }

    //----View Menu Bar--------
    public function view() {
        $menu_arr = $this->menu_model->get_generate_menu();
        $data['arr'] = $menu_arr;
        $data['menuLists'] = $menu_arr;
        $this->load->view('menubar', $data);
    }

    function save_menu_name() {
        $menu_name = trim($this->input->post('menu_name'));
        if ($menu_name != '') {
            $id = '-1';
            $table_name = 'ci_mst_menu';
            $where = array('menu_name' => $menu_name);
            $result = $this->common_model->check_exists($table_name, $where, $id, 'id');
            if ($result) {
                $this->common_model->insert_data($table_name, array('menu_name' => $menu_name));
                echo 'success';
            } else {
                echo 'error';
            }
        }
        exit;
    }

    function get_menulist() {
        $menu_name = trim($this->input->post('menu_name'));
        $menu_id = $this->common_model->getVal('ci_mst_menu','id', array('menu_name' => $menu_name));
        $menu_arr = array();
        if ($menu_id) {
            $menu_arr = $this->menu_model->get_menulist($menu_id);

            if (!empty($menu_arr)) {
                $i = 0;
                foreach ($menu_arr as $value) {
                    if (!empty($this->menu_model->get_sub_menulist($value['mid'], $menu_id))) {
                        $menu_arr[$i]['children'] = $this->menu_model->get_sub_menulist($value['mid'], $menu_id);
                    }
                    $i++;
                }
            }
        }

        $data["menu_arr"] = json_encode($menu_arr);

        echo json_encode($data);
        exit;
    }

}

?>
