<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class StudentRegistration extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'student_registration';
		$this->dbTable2 = 'student_login';
		$this->dbTable3 = 'student_details';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(STUDENT_REGISTRATION,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(STUDENT_REGISTRATION,'edit');
		$delete_permission = $this->permission->grant(STUDENT_REGISTRATION,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'', $where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Student Id</th>
                  <th>Reference Number</th>
                  <th>HSC Seat No.</th>
                  <th>Mother Name</th>
                  <th>Primary Mobile Number</th>
                  <th>Secondary Mobile Number</th>
                  <th>Email</th>
                  <th>DOB</th>
                  <th>Gender</th>
                  <th>Category</th>
                  <th>Sub-Category</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php               
            if(isset($data) && !empty($data)) {
            	$i = 1;
                    foreach ($data as $row) { 
                    	/* $status = '<span class="badge badge-danger">Deactive</span>';
						if($row['status'] == 1){
							$status = '<span class="badge badge-success">Active</span>';
						} */
               ?>
                  <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row['student_id']; ?></td>
                  <td><?php echo $row['reference_number']; ?></td>
                  <td><?php echo $row['hsc_seat_no']; ?></td>
                  <td><?php echo $row['mother_name']; ?></td>
                  <td><?php echo $row['primary_mobile_no']; ?></td>
                  <td><?php echo $row['secondary_mobile_no']; ?></td>
                  <td><?php echo $row['email']; ?></td>
                  <td><?php echo $row['dob']; ?></td>
                  <td><?php echo $row['gender']; ?></td>
                  <td><?php echo $row['category']; ?></td>
                  <td><?php echo $row['sub_category']; ?></td>
                  <!-- <td><?php echo $status; ?></td> -->
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/StudentRegistration/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" data-student_id="<?php echo $row['student_id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?>
                	<?php } ?>
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
		$permission = $this->permission->grant(STUDENT_REGISTRATION,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/student_registration/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(STUDENT_REGISTRATION,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$next = $this->db->query("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$this->db->database."' AND TABLE_NAME   = '".$this->dbTable."'");
			// print_r($next->result_array()[0]['AUTO_INCREMENT']); die();
			$student_register_data = array(
				'student_id'=>'Student_'.$next->result_array()[0]['AUTO_INCREMENT'],
				'reference_number'=> ($next->result_array()[0]['AUTO_INCREMENT'] * 2),
				'hsc_seat_no'=>$this->input->post('hsc_seat_no'),
				'mother_name'=>$this->input->post('mother_name'),
				'primary_mobile_no'=>$this->input->post('primary_mobile_no'),
				'secondary_mobile_no'=>$this->input->post('secondary_mobile_no'),
				'email'=>$this->input->post('email'),
				'dob'=>$this->input->post('dob'),
				'category'=>$this->input->post('category'),
				'sub_category'=>$this->input->post('sub_category'),
				'gender'=>$this->input->post('gender'),
				'status'=>'1',
			);
			$student_login_data = array(
				'student_id'=>'Student_'.$next->result_array()[0]['AUTO_INCREMENT'],
				'username'=>$this->input->post('email'),
				'password'=>md5('12345678'),
				'flag'=>'0',
				'status'=>'1',
			);
				//print_r($student_register_data);die;
        $insert = $this->common_model->add_records($this->dbTable,$student_register_data);
        $insert = $this->common_model->add_records($this->dbTable2,$student_login_data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Student Register details added successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/StudentRegistration');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/student_registration/add';
		$this->load->view('layout/template',$data);
      }
	}
	public function edit($id)
	{
		$id = base64_decode($id);
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(STUDENT_REGISTRATION,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
			$student_register_data = array(
				'hsc_seat_no'=>$this->input->post('hsc_seat_no'),
				'mother_name'=>$this->input->post('mother_name'),
				'primary_mobile_no'=>$this->input->post('primary_mobile_no'),
				'secondary_mobile_no'=>$this->input->post('secondary_mobile_no'),
				'email'=>$this->input->post('email'),
				'dob'=>$this->input->post('dob'),
				'category'=>$this->input->post('category'),
				'sub_category'=>$this->input->post('sub_category'),
				'gender'=>$this->input->post('gender'),
			);
			$student_login_data = array(
				// 'student_id'=>'Student_'.$next->result_array()[0]['AUTO_INCREMENT'],
				'username'=>$this->input->post('email'),
				// 'password'=>md5('12345678'),
				// 'flag'=>'0',
				// 'status'=>'1',
			);
			$where_array = array('id' => $id);
			$update = $this->common_model->update_records($this->dbTable,$student_register_data,$where_array);
			$login_where_array = array('student_id' => $this->input->post('student_id'));
			$update = $this->common_model->update_records($this->dbTable2,$student_login_data,$login_where_array);
        // print_r($student_login_data);die;
        if($update){
        	 $this->session->set_flashdata('success','Student Register details updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/StudentRegistration');
    }else{
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('student_registration','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/student_registration/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(STUDENT_REGISTRATION,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
	$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    $login_where_array = array('student_id' => $this->input->post('student_id'));
	$delete = $this->common_model->update_records($this->dbTable2,$data,$login_where_array);
    // $details_where_array = array('student_id' => $this->input->post('student_id'));
	$delete = $this->common_model->update_records($this->dbTable3,$data,$login_where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Student Register details deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
