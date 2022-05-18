<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Merit extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable2 = 'college';
		$this->dbTable = 'merit';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(MERIT,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(MERIT,'edit');
		$delete_permission = $this->permission->grant(MERIT,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Course Name</th>
                  <th>Merit</th>
                  <th>Status</th>
                  <th>Action</th>
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
                  <td><?php echo $row['course_name']; ?></td>
                  <td><?php echo $row['merit']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/Merit/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
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
		$permission = $this->permission->grant(MERIT,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/merit/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(MERIT,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$data = array(
				'college_name'=>$this->input->post('college_name'),
				'department'=>$this->input->post('department'),
				'program_name'=>$this->input->post('program_name'),
				'course_group_name'=>$this->input->post('course_group_name'),
				'course_name'=>$this->input->post('course_name'),
				'merit'=>$this->input->post('merit'),
				'status'=>$this->input->post('status'),
        );
				//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Merit is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Merit');
      }else{
        $data = array();
		$where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
      	$data['main_page'] = 'backend/merit/add';
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
		$permission = $this->permission->grant(MERIT,'edit');
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
        	 $this->session->set_flashdata('success','Merit is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Merit');
    }else{
		$where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('merit','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/merit/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(MERIT,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Income Master is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
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
