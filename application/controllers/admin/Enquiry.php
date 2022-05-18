<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Enquiry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'enquiry';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ENQUIRY,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(ENQUIRY,'edit');
		$delete_permission = $this->permission->grant(ENQUIRY,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Contact No</th>
                  <th>Email</th>
                  <th>Message</th>
                </tr>
                </thead>
                <tbody>
                <?php               
            if(isset($data) && !empty($data)) {
            	$i = 1;
                    foreach ($data as $row) { 
                    $status = '<span class="badge badge-danger">Deactive</span>';
	                  if($row['status'] == 1){
	                    $status = '<span class="badge badge-success">Active</span>';
	                  }
               ?>
                  <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row['created_at']; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['phone_no']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['message']; ?></td>
                  </td>
                </tr>
              <?php }} ?>
                </tbody>  
              </table>
        <?php
	}
	public function Index(){
	    $user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(ENQUIRY,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/enquiry/list';
		$this->load->view('layout/template',$data);
	}
	// public function View()
	// {
	// 	$id = base64_decode($this->uri->segment(4));
	// 	$where_arr = array('id'=>$id);
	// 	$data['record1'] = $this->common_model->get_records('enquiry','',$where_arr);
	// 	echo $sql = $this->db->last_query();die;
	// 	//$this->load->view('material_master/print',$data);
	// 	$data['main_page'] = 'contact_us_form/view';
	// 	$this->load->view('enquiry/view',$data);
	// }
}
