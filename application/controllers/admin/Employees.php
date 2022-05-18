<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Employees extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'employees';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(EMPLOYEES,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(EMPLOYEES,'edit');
		$delete_permission = $this->permission->grant(EMPLOYEES,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Employee Code</th>
                  <th>NID</th>
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
                  <td><?php echo $row['first_name']; ?></td>
                  <td><?php echo $row['last_name']; ?></td>
                  <td><?php echo $row['employee_code']; ?></td>
                  <td><?php echo $row['nid']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/Employees/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(EMPLOYEES,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/employees/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(EMPLOYEES,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$data = array(
						'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'employee_code'=>$this->input->post('employee_code'),
						'nid'=>$this->input->post('nid'),
						'contact_number'=>$this->input->post('contact_number'),
						'dob'=>$this->input->post('dob'),
						'dob_joining'=>$this->input->post('dob_joining'),
						'leaving'=>$this->input->post('leaving'),
						'user_name'=>$this->input->post('user_name'),
						'email'=>$this->input->post('email'),
						'status'=>$this->input->post('status'),
						'gender'=>$this->input->post('gender'),
						'blood'=>$this->input->post('blood'),
						'designation'=>$this->input->post('designation'),
        );
				//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Semester is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Employees');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/employees/add';
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
		$permission = $this->permission->grant(EMPLOYEES,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $data = array(
            'first_name'=>$this->input->post('first_name'),
						'last_name'=>$this->input->post('last_name'),
						'employee_code'=>$this->input->post('employee_code'),
						'nid'=>$this->input->post('nid'),
						'contact_number'=>$this->input->post('contact_number'),
						'dob'=>$this->input->post('dob'),
						'dob_joining'=>$this->input->post('dob_joining'),
						'leaving'=>$this->input->post('leaving'),
						'user_name'=>$this->input->post('user_name'),
						'email'=>$this->input->post('email'),
            'status'=>$this->input->post('status'),
            'gender'=>$this->input->post('gender'),
            'blood'=>$this->input->post('blood'),
            'designation'=>$this->input->post('designation'),
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Employees is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Employees');
    }else{
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('employees','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/employees/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(EMPLOYEES,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Employees Master is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
