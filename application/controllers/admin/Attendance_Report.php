<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Attendance_Report extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'attendance';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ATTENDANCEREPORT,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(ATTENDANCEREPORT,'edit');
		$delete_permission = $this->permission->grant(ATTENDANCEREPORT,'delete');
		$data = array();
		$filter_array = array();
		if($_POST['employee'] != ''){
			$filter_array['employee'] = $_POST['employee'];
		}
		if($_POST['created_at1'] != ''){
			$filter_array['date>='] = $_POST['created_at1'].' 00:00:00';
		}
		if($_POST['created_at2'] != ''){
			$filter_array['date<='] = $_POST['created_at2'].' 23:59:00';
		}
		//$select_array = array('*','str_to_date(created_at, "%Y-%c-%d") day');
		$data = $this->common_model->get_records($this->dbTable,'',$filter_array);
		//echo $sql = $this->db->last_query(); die;
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
	                  <th>#</th>
	                  <th>Name</th>
	                  <th>Date</th>
	                  <th>In</th>
	                  <th>Out</th>
                </tr>
                </thead>
                <tbody>
                <?php               
			            if(isset($data) && !empty($data)) {
			            	$i = 1;
			                    foreach ($data as $row) { 
			      
			               ?>
			                  <tr>
			                  <td><?php echo $i++;?></td>
			                  <td><?php 
                       $category = $this->db->where('id',$row['employee'])->get('employees')->row_array();
                       if($category){ echo $category['first_name']; } ?></td>
			                  <td><?php echo $row['date']; ?></td>
			                  <td><?php echo $row['sign_in']; ?></td>
			                  <td><?php echo $row['sign_out']; ?></td>
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
		$permission = $this->permission->grant(ATTENDANCEREPORT,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/attendance_report/list';
		$this->load->view('layout/template',$data);
	}

}
