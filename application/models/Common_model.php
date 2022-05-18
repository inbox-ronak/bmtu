<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model 
{
	public function get_records_by_query($q,$single_result=FALSE)
	{
		//return $this->db->query($q)->result_array();
		if(isset($single_result) && $single_result==true || $single_result == TRUE)
		{
			return $this->db->query($q)->row_array();
		}else{ 
			return $this->db->query($q)->result_array();			
		}
	}
	public function add_records($table_name,$insert_array)
	{
		if (is_array($insert_array)) 
		{
			if ($this->db->insert($table_name,$insert_array))
				
				return true;
			else
				return false;
		}else 
		{
			return false; 
		}
	}

	public function update_records($table_name,$update_array,$where_array)
	{
		if (is_array($update_array) && is_array($where_array)) 
		{
			$this->db->where($where_array);
			if($this->db->update($table_name,$update_array))
			{				 
				//echo $this->db->last_query();exit();
				return true;
			}else{
				return false;
			}	
		} 
		else 
		{
			return false;
		}
	}
	public function delete_records($table_name,$where_array)
	{
		if (is_array($where_array)) 
		{  
			$this->db->where($where_array);
			if($this->db->delete($table_name))
				return true;
			else
				return false;
		} 
		else 
		{
			return false;
		}
	}

	public function get_records_with_sort_group($table_name,$field_name_array=FALSE,$where_array=FALSE,$single_result=FALSE,$sort_order=FALSE,$group_by=FALSE)
	{
		$this->db->distinct($group_by);
		if(is_array($field_name_array) && isset($field_name_array))
	  	{
	  		$str=implode(',',$field_name_array);
			$this->db->select($str);
		}
		if(is_array($where_array)&& isset($where_array))
		{
			$this->db->where($where_array);
		}

		if(isset($group_by) && $group_by!='')
		{
			$this->db->group_by($group_by);
		}
		if(isset($sort_order) && $sort_order!='')
		{
			$this->db->order_by($sort_order);
		}
		$result=$this->db->get($table_name);
		if($single_result==true && isset($single_result))
		{
			return $result->row_array();
		} 
		else 
		{
			return $result->result_array();			
		}		
	}

	
	public function get_records($table_name,$field_name_array=FALSE,$where_array=FALSE,$single_result=FALSE)
	{
		if(is_array($field_name_array) && isset($field_name_array))
	  	{
	  		$str=implode(',',$field_name_array);
			$this->db->select($str);
		}
		if(is_array($where_array)&& isset($where_array))
		{
			$this->db->where($where_array);
			//$this->db->order_by('id','asc');
		}
		$result=$this->db->get($table_name);
		if($single_result==true && isset($single_result))
		{
			return $result->row_array();
		} 
		else 
		{
			return $result->result_array();			
		}		
	}
	public function get_records_object($table_name,$field_name_array=FALSE,$where_array=FALSE,$single_result=FALSE)
	{
		if(is_array($field_name_array) && isset($field_name_array))
	  	{
	  		$str=implode(',',$field_name_array);
			$this->db->select($str);
		}
		if(is_array($where_array)&& isset($where_array))
		{
			$this->db->where($where_array);
			//$this->db->order_by('id','asc');
		}
		$result=$this->db->get($table_name);
		if($single_result==true && isset($single_result))
		{
			return $result->row();
		} 
		else 
		{
			return $result->result();			
		}		
	}
	function json_datatable($table, $columns, $where = '', $order_by = '', $search_columns = '', $join_array = '', $group_by = '', $where_other = '') {

        $datatable_search_value = trim($_POST['search']['value']);
        $datatable_columns = $_POST['columns'];
        $datatable_limit = $_POST['length'];
        $datatable_offset = $_POST['start'];
        $datatable_order_name = $_POST['columns'][$_POST['order'][0]['column']]['name'];
        $datatable_order_by = $_POST['order'][0]['dir'];
        $datatable_draw = $_POST['draw'];

        $this->db->select($columns);
        $this->db->from($table);
        if ($join_array) {
            foreach ($join_array as $join) {
                if (!isset($join['type'])) {
                    $this->db->join($join['table'], $join['condition']);
                } else {
                    $this->db->join($join['table'], $join['condition'], $join['type']);
                }
            }
        }

        if (!empty($where)) {
            foreach ($where as $key => $val) {
                $this->db->where($key, $val);
            }
        }

        $SQL = '';
        if (!empty($datatable_search_value)) {
            $qry = array();
            if ($search_columns != '') {
                if (!is_array($search_columns)) {
                    $search_columns = explode(',', $search_columns);
                }
                foreach ($search_columns as $s_cl) {
                    $qry[] = " " . $s_cl . " like '%" . $datatable_search_value . "%' ";
                }
            } else {
                foreach ($datatable_columns as $cl) {
                    if ($cl['searchable'] == 'true')
                        $qry[] = " " . $cl['name'] . " like '%" . $datatable_search_value . "%' ";
                }
            }

            $SQL .= "( ";
            $SQL .= implode("OR", $qry);
            $SQL .= " )";
        }
        if ($SQL != '') {
            $this->db->where($SQL);
        }

        if (!empty($where_other)) {
            $this->db->where($where_other);
        }
        $order_by_array = array();
        if ($order_by) {
            if ($_POST['order'][0]['column'] != 0) {
                $order_by_array[] = $datatable_order_name . ' ' . $datatable_order_by;
            } else {
                if (is_array($order_by)) {
                    foreach ($order_by as $k => $v) {
                        $order_by_array[] = $k . ' ' . $v;
                    }
                } else {
                    $order_by_array[] = $order_by;
                }
            }
        } else {

            if ($_POST['order'][0]['column'] != 0) {
                $order_by_array[] = $datatable_order_name . ' ' . $datatable_order_by;
            } else {
                $order_by_array[] = $order_by;
            }
        }

        if (!empty($order_by_array)) {
            $order_by = implode(',', $order_by_array);
            $this->db->order_by($order_by); // Order by}
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }

        $this->db->limit($datatable_limit, $datatable_offset);
        $get_query = $this->db->get();

        $query = $this->db->last_query();

        $explod_query = explode('LIMIT', $query);

        $total = $this->db->query($explod_query[0])->num_rows();

        $data = $get_query->result_array();
         //echo $this->db->last_query();die; 
        return array("recordsTotal" => $total, "recordsFiltered" => $total, 'data' => $data);
    }
    function getRows($table, $columns, $where = array(), $other_condition = "", $order_by = "", $sort_type = "", $limit = 0, $offset = 0, $group_by = "", $join_array = array()) {
        $this->db->select($columns);
        $this->db->from($table);
        if ($join_array) {
            foreach ($join_array as $join) {
                if (!isset($join['type'])) {
                    $this->db->join($join['table'], $join['condition']);
                } else {
                    $this->db->join($join['table'], $join['condition'], $join['type']);
                }
            }
        }

        if ($where) {
            $this->db->where($where);
        }

        if ($other_condition) {
            $this->db->where($other_condition);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }

        if ($order_by != '' && $sort_type != '') {
            $this->db->order_by($order_by, $sort_type);
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $numofrecords = $query->num_rows();

        if ($numofrecords > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getRow($table,$columns,$where=array(),$other_condition="", $order_by = "", $sort_type = "", $limit = 0, $offset = 0, $group_by="", $join_array = array()) {
        $this->db->select($columns);
        $this->db->from($table);
        if ($join_array) {
            foreach ($join_array as $join) {
                if (!isset($join['type'])) {
                    $this->db->join($join['table'], $join['condition']);
                } else {
                    $this->db->join($join['table'], $join['condition'], $join['type']);
                }
            }
        }

        if ($where) {
            $this->db->where($where);
        }

        if ($other_condition) {
            $this->db->where($other_condition);
        }

        if($group_by != '') {
            $this->db->group_by($group_by);
        }

        if($order_by!='' && $sort_type!='') {
            $this->db->order_by($order_by, $sort_type);
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $query = $this->db->get();
        $numofrecords = $query->num_rows();

        if($numofrecords> 0) {
            return $query->row_array();
        }
        else {
            return false;
        }
    }
    public function insert_data($table, $data) {
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function update_data($table, $data, $condition) {
        $this->db->where($condition);
        $this->db->update($table, $data);

        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_data($table, $condition) {
        $this->db->where($condition);
        $this->db->delete($table);
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    function flash_alert_message($message_type, $message_title, $message_detail) {
        $my_flash = $this->session->set_flashdata('message', '<div class="alert alert-' . $message_type . ' alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4>' . $message_title . '</h4>
                            ' . $message_detail . '
                        </div>');
        return $my_flash;
    }
    public function get_details($table, $where, $id) {

        if ($id != -1) {
            foreach ($where as $key => $value) {
                $this->db->where($key, $value);
            }
            $query = $this->db->get($table);
            // echo $this->db->last_query();exit();         
            $result = $query->row();
            return $result;
        } else {
            $tbl_fields = new stdClass();
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field) {
                $tbl_fields->$field = '';
            }
            return $tbl_fields;
        }
    }
    function getRow_Val($str_query) {
        $result = $this->db->query($str_query);
        $numofrecords = $result->num_rows();
        if ($numofrecords > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function select_data_by_condition($table, $columns, $where = array(), $other_condition = '', $order_by = 'id', $sort_type = 'DESC', $limit = 0, $offset = 0,$group_by="") {
        $this->db->select($columns);
        $this->db->from($table);

        if ($where) {
            $this->db->where($where);
        }
        if ($other_condition) {
            $this->db->where($other_condition);
        }
        
        $this->db->order_by($order_by, $sort_type); // Order by
        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        if ($group_by != '') {
            $this->db->group_by($group_by);
        }
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
     public function get_unique_slug($table, $slug_column, $slug_value, $id = '', $key = '') {
        if (!empty($id)) {
            if (!empty($key)) {
                $page_key = $key . '!=';
            } else {
                $page_key = 'page_id != ';
            }
            $is_slug_avail = $this->db->select('COUNT(*) AS NumHits')->from($table)->where(array($page_key => $id))->like($slug_column, $slug_value, 'both')->get()->row();
            $numHits = $is_slug_avail->NumHits;

            if ($numHits > 0) {
                return $page_slug = strtolower($slug_value . '-' . $numHits);
            } else {
                return $page_slug = strtolower($slug_value);
            }
        } else {
            $is_slug_avail = $this->db->select('COUNT(*) AS NumHits')->from($table)->like($slug_column, $slug_value, 'both')->get()->row();
            
            $numHits = $is_slug_avail->NumHits;

            if ($numHits > 0) {
                return $page_slug = strtolower($slug_value . '-' . $numHits);
            } else {
                return $page_slug = strtolower($slug_value);
            }
        }
    }

    public function get_unique_slug_check($table, $slug_column, $slug_value) {
        $is_slug_avail = $this->db->select('COUNT(*) AS NumHits')->from($table)->like($slug_column, $slug_value, 'both')->get()->row();
        $numHits = $is_slug_avail->NumHits;

        if ($numHits > 0) {
            return FALSE;
        } else {
            return true;
        }
    }
    public function batchInsert($table, $data_arr) {
        return $this->db->insert_batch($table, $data_arr);
    }

    public function batchUpdate($table, $data_arr, $string) {
        return $this->db->update_batch($table, $data_arr, $string);
    }

     public function get_unique_slug_pages($table, $slug_column, $slug_value, $id = '', $key = '') {
        if (!empty($id)) {
            if (!empty($key)) {
                $page_key = $key . '!=';
            } else {
                $page_key = 'page_id != ';
            }
            $is_slug_avail = $this->db->select('COUNT(*) AS NumHits')->from($table)->where(array($page_key => $id))->like($slug_column, $slug_value, 'both')->get()->row();
            $numHits = $is_slug_avail->NumHits;

            if ($numHits > 0) {
                return $page_slug = strtolower($slug_value . '-' . $numHits);
            } else {
                return $page_slug = strtolower($slug_value);
            }
        } else {
            $is_slug_avail = $this->db->select('COUNT(*) AS NumHits')->from($table)->like($slug_column, $slug_value, 'both')->get()->row();

            $numHits = $is_slug_avail->NumHits;

            if ($numHits > 0) {
                return $page_slug = strtolower($slug_value . '-' . $numHits);
            } else {
                return $page_slug = strtolower($slug_value);
            }
        }
    }

    public function select_data_by_id($table, $columns, $where, $other_condition = '', $order_by = 'id', $sort_type = 'DESC', $limit = 1, $offset = 0) {
        $this->db->select($columns);
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        if ($other_condition) {
            $this->db->where($other_condition);
        }
        $this->db->order_by($order_by, $sort_type); // Order by
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }
    public function check_exists($table_name, $where, $id, $id_field_name) {
        if ($id == -1) {
            if (is_array($where)) {
                foreach ($where as $key => $val) {
                    $this->db->where($key, $val);
                }
            }
            $query = $this->db->get($table_name);
            $result = $query->num_rows();
            if ($result > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            if (is_array($where)) {
                foreach ($where as $key => $val) {
                    $this->db->where($key, $val);
                }
            }
            $this->db->where($id_field_name, $id);
            $query = $this->db->get($table_name);
            $result = $query->num_rows();
            if ($result > 0) {
                return TRUE;
            } else {
                if (is_array($where)) {
                    foreach ($where as $key => $val) {
                        $this->db->where($key, $val);
                    }
                }
                $query1 = $this->db->get($table_name);
                $result1 = $query1->num_rows();

                if ($result1 > 0) {
                    return FALSE;
                } else {
                    return TRUE;
                }
            }
        }
    }
}