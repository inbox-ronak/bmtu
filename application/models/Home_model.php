<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	
	}

	public function all_users(){
		$module = 'users';
		$id = $_SESSION['user_id'];
		$query = $this->db->get_where($module, array('trash' =>0,'id !='=>1));
		return $query->result_array();
	}
	
	public function get_user(){
		$module = 'users';
		$id = $_SESSION['user_id'];
		$query = $this->db->get_where($module, array('id' => $id));
		return $query->result_array();
	}
	public function getuser($id){
		$module = 'user_master';
		$query = $this->db->get_where($module, array('id' => $id));
		return $query->result_array();
	}
	
	public function update_record($table,$where,$data){
		$this->db->where(array('id'=>$where));
		$update = $this->db->update($table,$data); 
		return $update;
	}
}
