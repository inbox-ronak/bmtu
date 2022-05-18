<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {

	function __construct() {
	    parent::__construct();
	    $this->dbTable = 'role_master';
	}
	
	public function index()
	{
		$user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(ROLE,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/role/list';
		$this->load->view('layout/template',$data);
	}

	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ROLE,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(ROLE,'edit');
		$delete_permission = $this->permission->grant(ROLE,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
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
                  <td><?php echo $row['role_name'];?></td>
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-role_id="<?php echo $row['id'];?>" data-role="<?php echo $row['role_name'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-role_id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?>
                	<?php } ?>
                  </td>
                </tr>
              <?php }} ?>
                </tbody>  
              </table>
        <?php
	}

	public function add_role()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(ROLE,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// Role is already exists //
	    $role = trim($this->input->post('role'));
	    $record = $this->db->where('role_name',$role)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'Role is already exists.';
	        echo json_encode($response);exit;
	    }
	    //
		$data = array(
	        'user_id' => $user_id,
            'role_name' => $this->input->post('role'),
            'permission' => json_encode($this->input->post('modules'))
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'Role is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function getRoleEdit($id)
	{
	    $user_id=$_SESSION['user_id'];
	    if(!isset($_SESSION['user_id']))
	    {
	      redirect('admin/login');
		}
	    $permission = $this->permission->grant(ROLE,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(ROLE,'edit');
	    $delete_permission = $this->permission->grant(ROLE,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//print_r($data);
	    $this->load->view('backend/role/getRoleEdit',['data'=>$data[0]]);
	}

	public function update_role()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ROLE,'edit');
		if($permission == false)
		{
			redirect('dashboard');
		}

		$id=$this->input->post('role_id');
		// Role is already exists //
	    $role = trim($this->input->post('role'));
	    $record = $this->db->where('id !=',$id)->where('status !=',2)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['role_name'] == $role){
	        		$response['success'] = 0;
	        		$response['message'] = 'Role is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
                'role_name' => $this->input->post('role'),
                'status' => trim($this->input->post('status')),
        				'permission' => json_encode($this->input->post('modules'))
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'Role is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete_role()
	{
		$permission = $this->permission->grant(ROLE,'delete');

				$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
				$where_array = array('id' => $id);
				$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Role is deleted successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}
}