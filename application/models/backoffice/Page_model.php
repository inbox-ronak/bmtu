<?php
class Page_model extends CI_Model {
    public function add_page($data) {
        $this->db->insert('ci_pages', $data);
        return true;
    }

    public function get_all_pages() {
        $wh = array();
        $SQL = 'SELECT * FROM ' . $this->db->dbprefix . 'pages';
        $wh[] = " is_active = 1";
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            return $this->datatable->LoadJson($SQL, $WHERE);
        } else {
            return $this->datatable->LoadJson($SQL);
        }
    }

    public function get_all_simple_pages() {
        $query = $this->db->get('pages');
        return $result = $query->result_array();
    }

    public function get_all_category() {
        $query = $this->db->get('ci_category');
        return $result = $query->result_array();
    }

    public function count_all_users() {
        return $this->db->count_all('pages');
    }

    public function get_all_users_for_pagination($limit, $offset) {
        $wh = array();
        $this->db->order_by('page_id', 'desc');
        $this->db->limit($limit, $offset);
        if (count($wh) > 0) {
            $WHERE = implode(' and ', $wh);
            $query = $this->db->get_where('pages', $WHERE);
        } else {
            $query = $this->db->get('pages');
        }
        return $query->result_array();
    }
    public function get_page_by_id($id) {
        $query = $this->db->get_where('ci_pages', array('page_id' => $id ));
        return $result = $query->row_array();
    }

    public function edit_page($data, $id) {
        $this->db->where( array('page_id' => $id) );
        $this->db->update('ci_pages', $data);
        return true;
    }
}

?>