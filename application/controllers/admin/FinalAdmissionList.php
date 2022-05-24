<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class FinalAdmissionList extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable2 = 'student_registration';
		$this->dbTable = 'hsc_sheet';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		// echo $user_id;
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(FINAL_ADMISSION_LIST,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(FINAL_ADMISSION_LIST,'edit');
		$delete_permission = $this->permission->grant(FINAL_ADMISSION_LIST,'delete');
		$data = array();
		$where_arr = array('status!=' => 2, 'acceptance_status'=> 1);
		$data = $this->common_model->get_records($this->dbTable,'', $where_arr);
		// $totalSeats = $this->db->query("SELECT acceptance_status as booked FROM  $this->dbTable");
		$totalBookedSeats = $this->db->query("SELECT confirm_status FROM  $this->dbTable");
		// print_r($totalBookedSeats->result_array()[0]['confirm_status']);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>HSC Sheet Number</th>
                  <th>Name</th>
                  <th>Total Marks</th>
                  <th>Grade</th>
                  <th>Percentile Rank</th>
                  <th>Stream</th>
                  <th>Remark</th>
				  <th>Confirm/Reject</th>
				  <th>Fee Receipt</th>
                  <!-- <th>Action</th> -->
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
                  <td><?php echo $row['seat_no']; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['total_marks']; ?></td>
                  <td><?php echo $row['grade']; ?></td>
                  <td><?php echo $row['percentile_rank']; ?></td>
                  <td><?php echo $row['stream']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
				  <!--  && $totalBookedSeats->result_array()[0]['confirm_status'] == 0 -->
				  <?php if($edit_permission == true){ 
					  $fetchReferenceNo = $this->db->query("SELECT `student_id`, `reference_number`, `category` FROM  $this->dbTable2 WHERE `hsc_seat_no` = '".$row['seat_no']."'");
					//   print_r($fetchReferenceNo->result_array());

					  
					//   $this->session->set_userdata('date', date('d-m-Y'));
					//   $this->session->set_userdata('reference_number', $fetchReferenceNo->result_array()[0]['reference_number']);
					//   $this->session->set_userdata('student_name', $row['name']);
					//   $this->session->set_userdata('fees_amount', ($fetchReferenceNo->result_array()[0]['category'] == 'st') ? '0' : '1760' );
					$string = unique_code(20).base64_encode($row['id']);
					?>
				  <td>
						<a href="<?php echo base_url();?>admin/FinalAdmissionList/confirm/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><?= ($row['confirm_status'] != '1') ? 'Confirm' : 'Reject' ?></a>
				  </td> 
				  <?php } ?>
				  <?php if($edit_permission == true){ ?>
					<!-- <td>
						<a target="_blank" href="<?php echo base_url();?>admin/generatePdf/createPDF/<?php echo $string;?>" data-date="<?php echo date('d-m-Y'); ?>" data-reference_number="<?php echo $fetchReferenceNo->result_array()[0]['reference_number']; ?>" data-student_name="<?php echo $row['name']; ?>" data-fees_amount="<?php echo ($fetchReferenceNo->result_array()[0]['category'] == 'st') ? '0' : '1760'; ?>" class="btn btn-info btn-sm item_edit">Generate</a>
				  </td> -->
				  <td>
					<form target="_blank" action="<?php echo base_url();?>admin/generatePdf/createPDF/" method="post">
						<input type="hidden" readonly name="date" value="<?php echo date('d-m-Y'); ?>">
						<input type="hidden" readonly name="student_name" value="<?php echo $row['name']; ?>">
						<input type="hidden" readonly name="fees_amount" value="<?php echo ($fetchReferenceNo->result_array()[0]['category'] == 'st') ? '0' : '1760'; ?>">
						<input type="hidden" readonly name="reference_number" value="<?php echo $fetchReferenceNo->result_array()[0]['reference_number']; ?>">
						<button class="btn btn-info btn-sm item_edit">Generate</button>	
					</form>
				  </td>
				  <?php } ?>
				  <!-- <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/FinalAdmissionList/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?>
                	<?php } ?>
                  </td> -->
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
		$permission = $this->permission->grant(FINAL_ADMISSION_LIST,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/final_admission_list/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(FINAL_ADMISSION_LIST,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$where_arr = array('status!=' => 2, 'student_id'=>$this->input->post('student_id'));
			$data = $this->common_model->get_records($this->dbTable,'', $where_arr);
			// print_r($data); die();
			if(isset($data) && !empty($data)) {
				// $UploadAllFiles = new $this->AllfileUploding();
				$this->session->set_flashdata('error','Student details already exist.');
			}else{
				$values = $this->AllfileUploding($_FILES);
				// echo $values['hsc_marksheet']; die();
				$data = array(
					'entry_by'=>'offline',
					'student_id'=>$this->input->post('student_id'),
					'pwp_certificate'=>$this->input->post('pwp_certificate'),
					'physically_hendicap'=>$this->input->post('physically_hendicap'),
					'dob_ssc'=>$this->input->post('dob_ssc'),
					'dob_ssc_aadhar'=>$this->input->post('dob_ssc_aadhar'),
					'st_sc_ewc_obc_certificate'=>$this->input->post('st_sc_ewc_obc_certificate'),
					'certificate_validity_date'=>$this->input->post('certificate_validity_date'),
					'hsc_marksheet'=>$values['hsc_marksheet'],
					'lc'=>$values['leaving_certificate'],
					'cast_certificate'=>$values['cast_certificate'],
					'non_creamy_certificate'=>$values['non_creamy_certificate'],
					'aadhar_card'=>$values['aadhar_card'],
					'sc_bc_obc_certificate'=>$values['sc_bc_obc_certificate'],
					'sc_st_certificate'=>$values['sc_st_certificate'],
					'ews_certificate'=>$values['ews_certificate'],
					'non_creamy_date'=>$this->input->post('non_creamy_date'),
					// 'ews_certificate'=>$this->input->post('ews_certificate'),
					'status'=>'1',
				);
					// print_r($mainImage);die;
				$insert = $this->common_model->add_records($this->dbTable,$data);
				$response = array();
				if($insert){
					$this->session->set_flashdata('success','Student details are added successfully.');
				}else{
					$this->session->set_flashdata('error','Something went wrong.');
				}
			}
			redirect('admin/FinalAdmissionList');
      }else{
        $data = array();
		// $where_arr = array('status=' => 1);
        // $data['student_ids'] = $this->common_model->get_records($this->dbTable,'',$where_arr);
		$where_arr = array('status=' => 1);
        $data['student_ids'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
      	$data['main_page'] = 'backend/final_admission_list/add';
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
		$permission = $this->permission->grant(FINAL_ADMISSION_LIST,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $data = array(
            'college_name'=>$this->input->post('college_name'),
			'department'=>$this->input->post('department'),
			'program_name'=>$this->input->post('program_name'),
			'course_group_name'=>$this->input->post('course_group_name'),
			'course_name'=>$this->input->post('course_name'),
			'merit'=>$this->input->post('merit'),
			'status'=>$this->input->post('status'),
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Student details are updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/FinalAdmissionList');
    }else{
		$where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('merit','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/final_admission_list/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(FINAL_ADMISSION_LIST,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Student details are deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

public function confirm($id)
{
	$id = base64_decode($id);
	$user_id=$_SESSION['user_id'];
	if(!isset($_SESSION['user_id']))
	{
		redirect('admin/login');
	}
	$permission = $this->permission->grant(FINAL_ADMISSION_LIST,'edit');
	if($permission == false)
	{
		redirect('admin/dashboard');
	}
	// if(isset($_POST['submit'])){
	    /* $data = array(
            'approval_status'=> ABS(`approval_status` - 1),
      	);
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array); */
		$update = $this->db->query("UPDATE $this->dbTable SET `confirm_status` = ABS(`confirm_status` - 1)   WHERE `id`= $id");
		$fetchApproval = $this->db->query("SELECT confirm_status FROM  $this->dbTable WHERE `id` = '".$id."'");
		$appral = ($fetchApproval->result_array()[0]['confirm_status'] == '1') ? 'confirmed' : 'rejected';
		// print_r($fetchApproval->result_array()[0]['confirm_status']);die;
        if($update){
        	 $this->session->set_flashdata('success','Student admission '.$appral.'.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/FinalAdmissionList');
    // }
  }

  public function fetchDepartment()
  {
	$college_name = $this->input->post('college_name');
	$where_array = array('college_name' => $college_name, 'status'=> 1);
	$data['departments'] = $this->common_model->get_records('department','',$where_array);
	echo json_encode($data['departments']);
  }

  public function fetchProgram()
  {
	$department = $this->input->post('department');
	$college_name = $this->input->post('college_name');
	$where_array = array('college_name' => $college_name, 'department' => $department, 'status'=> 1);
	$data['programs'] = $this->common_model->get_records('program','',$where_array);
	echo json_encode($data['programs']);
  }

  public function fetchCourseGroup()
  {
	$college_name = $this->input->post('college_name');
	$program_name = $this->input->post('program_name');
	$department = $this->input->post('department');
	$where_array = array('college_name' => $college_name, 'department' => $department, 'program_name' => $program_name, 'status'=> 1);
	$data['departments'] = $this->common_model->get_records('course_group','',$where_array);
	echo json_encode($data['departments']);
  }

  public function fetchCourseComponent()
  {
	$college_name = $this->input->post('college_name');
	$program_name = $this->input->post('program_name');
	$department = $this->input->post('department');
	$course_group_name = $this->input->post('course_group_name');
	$where_array = array('college_name' => $college_name, 'department' => $department, 'program_name' => $program_name, 'course_group_name' => $course_group_name, 'status'=> 1);
	$data['course_group_name'] = $this->common_model->get_records('course','',$where_array);
	echo json_encode($data['course_group_name']);
  }

}
