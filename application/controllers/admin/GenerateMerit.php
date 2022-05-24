<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class GenerateMerit extends CI_Controller {

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
		$permission = $this->permission->grant(GENERATE_MERIT,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(GENERATE_MERIT,'edit');
		$delete_permission = $this->permission->grant(GENERATE_MERIT,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'', $where_arr);
		$totalBookedSeats = $this->db->query("SELECT SUM(acceptance_status) as booked FROM  $this->dbTable");
		$totalSeats = $this->db->query("SELECT acceptance_status as booked FROM  $this->dbTable");
		// print_r($totalBookedSeats->result_array()[0]['booked']);
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
                  <th>Accept/Reject</th>
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
                  <td><?php echo $row['seat_no']; ?></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['total_marks']; ?></td>
                  <td><?php echo $row['grade']; ?></td>
                  <td><?php echo $row['percentile_rank']; ?></td>
                  <td><?php echo $row['stream']; ?></td>
                  <td><?php echo $row['remark']; ?></td>
				  <td>
                  	<?php if($edit_permission == true){ ?>
						<a href="<?php echo base_url();?>admin/GenerateMerit/approve/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><?= ($row['approval_status'] == '1') ? 'Reject' : 'Approve' ?></a>
                  	<?php } ?>
				  </td> 
				  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<!-- <a href="<?php echo base_url();?>admin/GenerateMerit/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a> -->
						<!-- <a href="<?php echo base_url();?>admin/GenerateMerit/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit" data-bs-toggle="modal" data-bs-target="#addRemarkPopup"><i class="fa fa-edit"></i></a> -->
						<button class="btn btn-danger btn-sm item_edit addRemarkLink" data-id="<?php echo $row['id'];?>" data-toggle="modal" data-target="#addRemarkPopup">Add Remark</button>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo base64_encode($row['id']);?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
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
		$permission = $this->permission->grant(GENERATE_MERIT,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/generate_merit/list';
		$this->load->view('layout/template',$data);
	}

	public function AllfileUploding($files)
	{
		// print_r($files['hsc_marksheet']['name']); die();
		// HSC Marksheet File Upload
		$hsc_marksheet_path = 'assets/uploads/hsc_marksheet/';
		if (!is_dir($hsc_marksheet_path))
		{
			mkdir($hsc_marksheet_path, 0777, true);
		}
		if($files['hsc_marksheet']['error'] == 0){
			$config['upload_hsc_marksheet_path'] = $hsc_marksheet_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['hsc_marksheet']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $hsc_marksheet_path . basename($files["hsc_marksheet"]["name"]);
			// if($this->upload->do_upload('hsc_marksheet'))
			if(move_uploaded_file($files["hsc_marksheet"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$hsc_marksheet = $uploadData['file_name'];
			}
		}

		// Leaving Certificate File Upload
		$leaving_certificate_path = 'assets/uploads/leaving_certificate/';
		if (!is_dir($leaving_certificate_path))
		{
			mkdir($leaving_certificate_path, 0777, true);
		}
		if($files['leaving_certificate']['error'] == 0){
			$config['upload_leaving_certificate_path'] = $leaving_certificate_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['leaving_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $leaving_certificate_path . basename($files["leaving_certificate"]["name"]);
			// if($this->upload->do_upload('leaving_certificate'))
			if(move_uploaded_file($files["leaving_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$leaving_certificate = $uploadData['file_name'];
			}
		}

		// print_r($files); die();
		
		// Cast Certificate File Upload
		$cast_certificate_path = 'assets/uploads/cast_certificate/';
		if (!is_dir($cast_certificate_path))
		{
			mkdir($cast_certificate_path, 0777, true);
		}
		if($files['cast_certificate']['error'] == 0){
			$config['upload_cast_certificate_path'] = $cast_certificate_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['cast_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $cast_certificate_path . basename($files["cast_certificate"]["name"]);
			
			// if($this->upload->do_upload('cast_certificate'))
			if(move_uploaded_file($files["cast_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$cast_certificate = $uploadData['file_name'];
			}
		}

		// Non-Creamy Layer Certificate File Upload
		$non_creamy_certificate_path = 'assets/uploads/non_creamy_certificate/';
		if (!is_dir($non_creamy_certificate_path))
		{
			mkdir($non_creamy_certificate_path, 0777, true);
		}
		if($files['non_creamy_certificate']['error'] == 0){
			$config['upload_non_creamy_certificate_path'] = $non_creamy_certificate_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['non_creamy_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $non_creamy_certificate_path . basename($files["non_creamy_certificate"]["name"]);

			// if($this->upload->do_upload('non_creamy_certificate'))
			if(move_uploaded_file($files["non_creamy_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$non_creamy_certificate = $uploadData['file_name'];
			}
		}

		// Aadhar Card File Upload
		$aadhar_card_path = 'assets/uploads/aadhar_card/';
		if (!is_dir($aadhar_card_path))
		{
			mkdir($aadhar_card_path, 0777, true);
		}
		if($files['aadhar_card']['error'] == 0){
			$config['upload_aadhar_card_path'] = $aadhar_card_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['aadhar_card']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $aadhar_card_path . basename($files["aadhar_card"]["name"]);

			// if($this->upload->do_upload('aadhar_card'))
			if(move_uploaded_file($files["aadhar_card"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$aadhar_card = $uploadData['file_name'];
			}
		}

		// ST/SC/EWC/OBC Certificate File Upload
		$sc_bc_obc_certificate_path = 'assets/uploads/sc_bc_obc_certificate/';
		if (!is_dir($sc_bc_obc_certificate_path))
		{
			mkdir($sc_bc_obc_certificate_path, 0777, true);
		}
		if($files['sc_bc_obc_certificate']['error'] == 0){
			$config['upload_sc_bc_obc_certificate_path'] = $sc_bc_obc_certificate_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['sc_bc_obc_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $sc_bc_obc_certificate_path . basename($files["sc_bc_obc_certificate"]["name"]);

			// if($this->upload->do_upload('sc_bc_obc_certificate'))
			if(move_uploaded_file($files["sc_bc_obc_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$sc_bc_obc_certificate = $uploadData['file_name'];
			}
		}

		// ST/SC Certificate File Upload
		$sc_st_certificate_path = 'assets/uploads/sc_st_certificate/';
		if (!is_dir($sc_st_certificate_path))
		{
			mkdir($sc_st_certificate_path, 0777, true);
		}
		if($files['sc_st_certificate']['error'] == 0){
			$config['upload_sc_st_certificate_path'] = $sc_st_certificate_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['sc_st_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $sc_st_certificate_path . basename($files["sc_st_certificate"]["name"]);
			
			// if($this->upload->do_upload('sc_st_certificate'))
			if(move_uploaded_file($files["sc_st_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$sc_st_certificate = $uploadData['file_name'];
			}
		}

		// EWS File Upload
		$ews_path = 'assets/uploads/ews/';
		if (!is_dir($ews_path))
		{
			mkdir($ews_path, 0777, true);
		}
		if($files['ews_certificate']['error'] == 0){
			$config['upload_ews_path'] = $ews_path;
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['file_name'] = $files['ews_certificate']['name'];
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			$target_file = $ews_certificate_path . basename($files["ews_certificate"]["name"]);
			
			// if($this->upload->do_upload('ews_certificate'))
			if(move_uploaded_file($files["ews_certificate"]["tmp_name"],$target_file))
			{
				$uploadData = $this->upload->data();
				$ews_certificate = $uploadData['file_name'];
			}
		}
		return ['hsc_marksheet'=>$hsc_marksheet, 'leaving_certificate'=>$leaving_certificate, 'cast_certificate'=>$cast_certificate, 'non_creamy_certificate'=>$non_creamy_certificate, 'aadhar_card'=>$aadhar_card, 'sc_bc_obc_certificate'=>$sc_bc_obc_certificate, 'sc_st_certificate'=>$sc_st_certificate, 'ews_certificate'=>$ews_certificate];
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(GENERATE_MERIT,'add');
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
			redirect('admin/GenerateMerit');
      }else{
        $data = array();
		// $where_arr = array('status=' => 1);
        // $data['student_ids'] = $this->common_model->get_records($this->dbTable,'',$where_arr);
		$where_arr = array('status=' => 1);
        $data['student_ids'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
      	$data['main_page'] = 'backend/generate_merit/add';
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
		$permission = $this->permission->grant(GENERATE_MERIT,'edit');
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
      redirect('admin/GenerateMerit');
    }else{
		$where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('merit','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/generate_merit/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(GENERATE_MERIT,'delete');

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

  public function approve($id)
  {
	  $id = base64_decode($id);
	  $user_id=$_SESSION['user_id'];
	  if(!isset($_SESSION['user_id']))
	  {
		  redirect('admin/login');
	  }
	  $permission = $this->permission->grant(GENERATE_MERIT,'edit');
	  if($permission == false)
	  {
		  redirect('admin/dashboard');
	  }
	  $update = $this->db->query("UPDATE $this->dbTable SET `approval_status` = ABS(`approval_status` - 1)   WHERE `id`= $id");
	  $fetchApproval = $this->db->query("SELECT approval_status FROM  $this->dbTable WHERE `id` = '".$id."'");
	  $appral = ($fetchApproval->result_array()[0]['approval_status'] == '1') ? 'approved' : 'rejected';
	  // print_r($fetchApproval->result_array()[0]['approval_status']);die;
	  if($update){
			  $this->session->set_flashdata('success','Student '.$appral.' successfully.');
	  }else{
		  $this->session->set_flashdata('error','Something went wrong.');
	  }
	  redirect('admin/GenerateMerit');
	}

	public function addRemark()
	{
		// print_r($this->input->post('id')); die();
		$id = $this->input->post('id');
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(GENERATE_MERIT,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$update = $this->db->query("UPDATE $this->dbTable SET `remark` = '".$this->input->post('remark')."' WHERE `id`= $id");
		// $fetchApproval = $this->db->query("SELECT approval_status FROM  $this->dbTable WHERE `id` = '".$id."'");
		// $appral = ($fetchApproval->result_array()[0]['approval_status'] == '1') ? 'approved' : 'rejected';
		// print_r($fetchApproval->result_array()[0]['approval_status']);die;
		if($update){
				$this->session->set_flashdata('success','Remark added successfully.');
		}else{
			$this->session->set_flashdata('error','Something went wrong.');
		}
		redirect('admin/GenerateMerit');
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
