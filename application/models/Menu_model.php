<?php

class Menu_model extends CI_Model {

    public function get_generate_menu($mst_menu_id) {
        $this->db->select('menu_id as mid,page_id as id,page_name_en as text');
        $this->db->from('ci_menus');
        $this->db->join('ci_pages', 'ci_menus.pageid=ci_pages.page_id', 'left');
        $this->db->where('mst_menu_id', $mst_menu_id);
        $this->db->where('parent_id', NULL);
        $this->db->where('active', 1);
        $this->db->order_by('order_no', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_generate_menu2($mst_menu_id) {
        $data = $this->getRows("select * from ci_menus where mst_menu_id='" . $mst_menu_id . "' and parent_id is NULL and active = 1 order by order_no asc");
        if (!empty($data)) {
            $arrayData = array();
            foreach ($data as $datai) {
                $pagename = '';
                $pageid = '';
                if ($datai->menu_type == 1 || $datai->menu_type == 0) {
                    $getData = $this->getRow("select page_id,page_name_en from ci_pages where page_id='" . $datai->pageid . "'");
                    if (!empty($getData)) {
                        $pagename = $getData->page_name_en;
                        $pageid = $getData->page_id;
                        $menu_type = $datai->menu_type;


                        $arrayData[] = array(
                            'mid' => $datai->menu_id,
                            'id' => $pageid,
                            'text' => $pagename,
                            'menu_type' => $menu_type
                        );
                    }
                }
            }
            return $arrayData;
        } else {
            return FALSE;
        }
    }

    public function add_menu($page_ids, $mst_menu_id, $menu_type) {
        $count = count($page_ids);
        if ($count != 0) {
            $this->db->limit(1);
            $this->db->where('mst_menu_id', $mst_menu_id);
            $this->db->order_by('menu_id', 'desc');
            $order = $this->db->get('ci_menus')->result_array();
            $order_no = 100;
            if (!empty($order)) {
                $order_no = $order[0]['order_no'] + 1;
            }

            foreach ($page_ids as $page_id) {
                // below code comment for add multiple time menu start here  
                $this->db->from('ci_menus');
                $this->db->where('mst_menu_id', $mst_menu_id);
                $this->db->where('pageid', $page_id);
                $query = $this->db->get();
                $num_rows = $query->num_rows();                
                               
                // Insert Menu table 
                if($num_rows <= 0){
                    if ($menu_type == 'page') {
                        $page['menu_type'] = 1;
                    }

                    $page['pageid'] = $page_id;
                    $page['active'] = 1;
                    $page['order_no'] = $order_no;
                    $page['mst_menu_id'] = $mst_menu_id;
                    $this->db->insert('ci_menus', $page);
                    $order_no++;
                }
                // below code comment for add multiple time menu end here   
            }
        }
    }

    public function get_sub_menu($menu_id) {
        $this->db->select('menu_id as mid,page_id as id,page_name_en as text');
        $this->db->from('ci_menus');
        $this->db->join('ci_pages', 'ci_menus.pageid=ci_pages.page_id', 'left');
        $this->db->where('parent_id', $menu_id);
        $this->db->order_by('order_no', 'ASC');
        return $this->db->get()->result_array();
    }

    public function update_order($menu_id, $order_no, $parent_id = "", $mst_menu_id = '') {

        $this->db->where('mst_menu_id', $mst_menu_id);
        $this->db->where('menu_id', $menu_id);
        if ($parent_id != "") {
            $menu['parent_id'] = $parent_id;
        } else {
            $menu['parent_id'] = NULL;
        }
        $menu['active'] = 1;
        $menu['order_no'] = $order_no;
        $this->db->update('ci_menus', $menu);
    }

    public function reset_list($mst_menu_id) {
        $this->db->where_in('mst_menu_id', array($mst_menu_id));
        $this->db->delete('ci_menus');
    }

    public function delete_menu($mid) {
        $this->db->where('menu_id', $mid);
        $this->db->delete('ci_menus');

        $child_arr = $this->db->get_where('ci_menus', array('parent_id' => $mid))->result_array();

        if (!empty($child_arr)) {
            return $this->delete_menu($child_arr[0]['menu_id']);
        } else {
            return false;
        }
    }

    public function get_sub_menu1($menu_id, $mst_menu_id) {
        $menu_id ==
        $this->db->select('menu_id as mid,page_id as id,page_name_en as text');
        $this->db->from('ci_menus');
        $this->db->join('ci_pages', 'ci_menus.pageid=ci_pages.page_id', 'left');
        $this->db->where('mst_menu_id', $mst_menu_id);
        $this->db->where('parent_id', $menu_id);
        $this->db->order_by('order_no', 'ASC');
        $submenu_list = $this->db->get()->result_array();
       
        $i = 0;
        $submenuArray = array();
        foreach ($submenu_list as $p_cat) {
            $submenu_text_unserialize = $p_cat['text'];
            $submenuArray[] = array(
                'mid' => $p_cat['mid'],
                'id' => $p_cat['id'],
                'text' => strtoupper($submenu_text_unserialize)
            );
            if (!empty($this->get_sub_menu1($p_cat['mid'], $mst_menu_id))) {
                $submenuArray[$i]['children'] = array(
                    'mid' => $p_cat['mid'],
                    'id' => $p_cat['id'],
                    'text' => strtoupper($submenu_text_unserialize)
                );
                $submenuArray[$i]['children'] = $this->get_sub_menu1($p_cat['mid'],$mst_menu_id);
            }
            $i++;
        }
        return $submenuArray;
    }

    public function get_sub_menu2($menu_id, $mst_menu_id) {
        $data = $this->getRows("select * from ci_menus where mst_menu_id='" . $mst_menu_id . "' and parent_id='" . $menu_id . "' and active = 1 order by order_no asc");
        if (!empty($data)) {
            foreach ($data as $datai) {
                //print_r($datai);
                $pagename = '';
                $pageid = '';
                if ($datai->menu_type == 1 || $datai->menu_type == 0) {
                    $getData = $this->getRow("select page_id,page_name_en from ci_pages where page_id='" . $datai->pageid . "'");
                    $pagename = $getData->page_name_en;
                    $pageid = $getData->page_id;
                    $menu_type = $datai->menu_type;
                }

                $arrayData[] = array(
                    'mid' => $datai->menu_id,
                    'id' => $pageid,
                    'text' => $pagename,
                    'menu_type' => $menu_type
                );
            }
            return $arrayData;
        } else {
            return FALSE;
        }
    }

    public function update_order1($value, $mst_menu_id) {

        if (!empty($value) && isset($value['children'])) {

            foreach ($value as $k => $v) {
                if ($k == 'children') {

                    $i = 1;
                    foreach ($v as $val) {

                        $this->db->where('mst_menu_id', $mst_menu_id);
                        $this->db->where('menu_id', $val['mid']);
                        if ($value['mid'] != "") {
                            $menu['parent_id'] = $value['mid'];
                        } else {
                            $menu['parent_id'] = NULL;
                        }
                        $menu['active'] = 1;
                        $menu['order_no'] = $i;
                        $this->db->update('ci_menus', $menu);

                        if (isset($val['children'])) {
                            $this->update_order1($val, $mst_menu_id);
                        }
                        $i++;
                    }
                }
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_menulist($mst_menu_id) {
        $this->db->select('menu_id as mid,page_id as id,page_name_en as text');
        $this->db->from('ci_menus');
        $this->db->join('ci_pages', 'ci_menus.pageid=ci_pages.page_id', 'left');
        $this->db->where('mst_menu_id', $mst_menu_id);
        $this->db->where('parent_id', NULL);
        $this->db->where('active', 1);
        $this->db->order_by('order_no', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_sub_menulist($menu_id, $mst_menu_id) {
        $this->db->select('menu_id as mid,page_id as id,page_name_en as text');
        $this->db->from('ci_menus');
        $this->db->join('ci_pages', 'ci_menus.pageid=ci_pages.page_id', 'left');
        $this->db->where('mst_menu_id', $mst_menu_id);
        $this->db->where('parent_id', $menu_id);
        $this->db->order_by('order_no', 'ASC');
        $submenu_list = $this->db->get()->result_array();
        $i = 0;
        foreach ($submenu_list as $p_cat) {
            if (!empty($this->get_sub_menulist($p_cat['mid'], $mst_menu_id))) {
                $submenu_list[$i]['children'] = $this->get_sub_menulist($p_cat['mid'], $mst_menu_id);
            }
            $i++;
        }
        return $submenu_list;
    }

    function getRow($str_query) {
        $result = $this->db->query($str_query);
        $numofrecords = $result->num_rows();
        if ($numofrecords > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    function getRows($str_query) {
        $result = $this->db->query($str_query);
        $numofrecords = $result->num_rows();
        if ($numofrecords > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    function getVal($str_query) {
        $result = $this->db->query($str_query);
        $numofrecords = $result->num_rows();
        if ($numofrecords > 0) {
            foreach ($result->row() as $onefield) {
                return $onefield;
            }
        } else {
            return false;
        }
    }

}

?>