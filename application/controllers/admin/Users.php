<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	function __construct() {
	    parent::__construct();
      $this->dbTable = 'user_master';
	}

	public function index()
	{
    $user_id=$_SESSION['user_id'];
		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		//$user_id=$_SESSION['user_id'];
		$permission = $this->permission->grant(USERS,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
    $data['main_page'] = 'backend/users/list';
    $this->load->view('layout/template',$data);
	}

	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(USERS,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(USERS,'edit');
		$delete_permission = $this->permission->grant(USERS,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
    $data = $this->common_model->get_records($this->dbTable,'',$where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile Number</th>
          <th>Role</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          <?php               
            	if(isset($data) && !empty($data)){
            		$i = 1;
                foreach ($data as $row){
                  $status = '<span class="badge badge-danger">Deactive</span>';
                  if($row['status'] == 1){
                    $status = '<span class="badge badge-success">Active</span>';
                  }
               ?>
                <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row['username'];?></td>
                  <td><?php echo $row['first_name'].' '.$row['last_name'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['mobile_no'];?></td>
                  <td><?php $role = $this->db->where('id',$row['role_id'])->get('role_master')->row_array();
                            echo $role['role_name'];  ?>
                  </td>
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a data-toggle="tooltip" title="Edit User" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a data-toggle="tooltip" title="Delete user" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?>
                  </td>
                </tr>
          <?php } } ?>
        </tbody>  
      </table>
    <?php
	}

	public function addUser()
  {
		$user_id=$_SESSION['user_id'];
		if(!isset($user_id))
    {
      redirect('admin/login');
    }

		$permission = $this->permission->grant(USERS,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

    // Email Id already exists //
    $username = trim($this->input->post('username'));
    $userdetail = $this->db->where('status !=',2)->where('username',$username)->get($this->dbTable)->row_array();
    if($userdetail){
        $response['success'] = 0;
        $response['message'] = 'Username already exists.';
        echo json_encode($response);exit;
    }
    //

    // Email Id already exists //
    $email = trim($this->input->post('email'));
    $userdetail = $this->db->where('status !=',2)->where('email',$email)->get($this->dbTable)->row_array();
    if($userdetail){
        $response['success'] = 0;
        $response['message'] = 'Email already exists.';
        echo json_encode($response);exit;
    }
    //

    // Phone No. already exists //
    $phone_no = trim($this->input->post('phone_no'));
    if($phone_no){
        $userdetail = $this->db->where('status !=',2)->where('mobile_no',$phone_no)->get($this->dbTable)->row_array();
        if($userdetail){
            $response['success'] = 0;
            $response['message'] = 'Phone No. already exists.';
            echo json_encode($response);exit;
        }
    }

    $modules = array();
    if(array_key_exists('modules',$_POST)){
      $modules_array = $_POST['modules'];
      if($modules_array){
        foreach ($modules_array as $key => $value) {
          $modules[] = array($key=>implode(',',$value));
        }

      }
    }
    
    $data = array(
      'username' => trim($this->input->post('username')),
      'first_name' => trim($this->input->post('firstname')),
      'last_name' => trim($this->input->post('lastname')),
      'address' => trim($this->input->post('address')),
      'role_id' => trim($this->input->post('role_id')),
      'email' => trim($this->input->post('email')),
      'password' => md5(trim($this->input->post('password'))),
      'mobile_no' => trim($this->input->post('phone_no')),
      'status' => trim($this->input->post('status')),
      'user_id' => $_SESSION['user_id'],
      'module_permission' => json_encode($modules),
    );
    //print_r($data);die;
    $insert = $this->common_model->add_records($this->dbTable,$data);

    $response = array();
    if($insert){
    	$response['success'] = 1;
    	$response['message'] = 'User is created successfully.';
    }else{
    	$response['success'] = 0;
    	$response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
	}

  public function getUserEdit($id)
  {
    $user_id=$_SESSION['user_id'];
    if(!isset($_SESSION['user_id'])){
      redirect('admin/login');
    }
    $permission = $this->permission->grant(USERS,'edit');
    if($permission == false){
      redirect('admin/dashboard');
    }
    $edit_permission = $this->permission->grant(USERS,'edit');
    $delete_permission = $this->permission->grant(USERS,'delete');
    $where_arr = array('id' => $id); 
    $data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
    //print_r($data);exit;
    $this->load->view('backend/users/getUserEdit',['data'=>$data]);
  }

  public function update_user()
  {
    $user_id=$_SESSION['user_id'];
    if(!isset($_SESSION['user_id']))
    {
      redirect('admin/login');
    }
    $permission = $this->permission->grant(USERS,'edit');
    if($permission == false)
    {
      redirect('dashboard'); 
    }

    $id=$this->input->post('user_id');

    // Start Email Id OR Phone No already exists //
    $username = trim($this->input->post('username'));
    $phone_no = trim($this->input->post('phone_no'));
    $email = trim($this->input->post('email'));
    $userdetail = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
    if($userdetail){
      foreach ($userdetail as $value) {
        // Username already exists //
        if($username == $value['username']){
          $response['success'] = 0;
          $response['message'] = 'Username already exists.';
          echo json_encode($response);exit;
        }
        // Email Id already exists //
        if($email == $value['email']){
          $response['success'] = 0;
          $response['message'] = 'Email already exists.';
          echo json_encode($response);exit;
        }
        // Phone No. already exists //
        if($phone_no){
          if($phone_no == $value['mobile_no']){
            $response['success'] = 0;
            $response['message'] = 'Phone No. already exists.';
            echo json_encode($response);exit;
          }
        }
        //
      }
    }
    // End Email ID OR Phone No. already exists //

    $modules = array();
    if(array_key_exists('modules',$_POST)){
      $modules_array = $_POST['modules'];
      if($modules_array){
        foreach ($modules_array as $key => $value) {
          $modules[] = array($key=>implode(',',$value));
        }

      }
    }

    $data = array(
      'username' => trim($this->input->post('username')),
      'first_name' => trim($this->input->post('firstname')),
      'last_name' => trim($this->input->post('lastname')),
      'address' => trim($this->input->post('address')),
      'role_id' => trim($this->input->post('role_id')),
      'email' => trim($this->input->post('email')),
      //'password' => md5(trim($this->input->post('password'))),
      'mobile_no' => trim($this->input->post('phone_no')),
      'status' => trim($this->input->post('status')),
      //'user_id' => $_SESSION['user_id'],
      'module_permission' => json_encode($modules),
    );

    $password = trim($this->input->post('password'));
    if($password != ''){
      $data['password'] = md5($password);

      $old_data = $this->users_model->getuser($id);
      //echo $old_data->password;exit;
      $data['last_password'] = $old_data->password;
    }
    $where_array = array('id' => $id);
    $update = $this->common_model->update_records($this->dbTable,$data,$where_array);
    $response = array();
    if($update){
      $response['success'] = 1;
      $response['message'] = 'User is updated successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

  public function delete_user()
  {
        $permission = $this->permission->grant(USERS,'delete');

        $url = $_SERVER['REQUEST_URI'];
        $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
        $where_array = array('id' => $id);
        $delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
        if($delete){
          $response['success'] = 1;
          $response['message'] = 'User is deleted successfully.';
        }else{
          $response['success'] = 0;
          $response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
  }
  public function modules_permission(){
    $user_id=$_SESSION['user_id'];
    if(!isset($_SESSION['user_id']))
    {
      redirect('admin/login');
    }

    $user_role=$_POST['user_role'];
    if($user_role != 1 && $user_role != ''){
    $roles = $this->db->where('id',$user_role)->get('role_master')->row_array();
    $role_module = array(0);
    $per_array = json_decode($roles['permission'],true);
    if($per_array){
      $role_module = array_merge($role_module,$per_array);
    }
    //echo '<pre>';print_r($role_module);
    
  ?>
    <table class="mt-3 table">
      <tr>
        <td colspan="5"><label>Module Permission</label></td>
      </tr>
      <?php 
        $modules = $this->db->where('parent',0)->get('modules')->result_array();
        foreach ($modules as $module){

          if(in_array($module['id'],$role_module)){

            if($module['has_child'] == 1){
      ?>
        <tr>
        <td valign="top"><span><?php echo $module['module_name'];?></span></td>
        <td colspan="4" class="pt-0 pl-0" style="border: none;">
            <input type="checkbox" class="hidecheck parent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="view" <?php if($user_role == 2){ echo 'checked'; } ?>>
            <input type="checkbox" class="hidecheck parent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="add" <?php if($user_role == 2){ echo 'checked'; } ?>>
            <input type="checkbox" class="hidecheck parent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="edit" <?php if($user_role == 2){ echo 'checked'; } ?>>
            <input type="checkbox" class="hidecheck parent<?php echo $module['id'];?>" name="modules[<?php echo $module['module_slug'];?>][]" value="delete" <?php if($user_role == 2){ echo 'checked'; } ?>>
            <table class="table">
            <?php 
            $sub_modules = $this->db->where('parent',$module['id'])->get('modules')->result_array(); 
              if($sub_modules){
              foreach ($sub_modules as $value) {
                if(in_array($value['id'],$role_module)){
            ?>
            <tr>
              <td valign="top" style="width:10.25rem;"><span><?php echo $value['module_name'];?></span></td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="child custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="view" data-id="<?php echo $module['id'];?>" id="view<?php echo $value['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
                    <label class="custom-control-label" for="view<?php echo $value['id'];?>">View</label>
                  </div>
                </div>
              </td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="child custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="add" data-id="<?php echo $module['id'];?>" id="add<?php echo $value['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
                    <label class="custom-control-label" for="add<?php echo $value['id'];?>">Add</label>
                  </div>
                </div>
              </td>
              <td>
                <div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="child custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="edit" data-id="<?php echo $module['id'];?>" id="edit<?php echo $value['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
                    <label class="custom-control-label" for="edit<?php echo $value['id'];?>">Edit</label>
                  </div>
                </div>
              </td>
              <td><div class="form-group">
                  <div class="custom-control custom-switch custom-switch-on-success">
                    <input type="checkbox" class="child custom-control-input" name="modules[<?php echo $value['module_slug'];?>][]" value="delete" data-id="<?php echo $module['id'];?>" id="delete<?php echo $value['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
                    <label class="custom-control-label" for="delete<?php echo $value['id'];?>">Delete</label>
                  </div>
                </div>
              </td>
            </tr>
            <?php } } } ?>
          </table>
        </td>
      </tr>
    <?php }else{ ?>
      <tr>
        <td valign="top"><span><?php echo $module['module_name'];?></span></td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="view" id="view<?php echo $module['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
              <label class="custom-control-label" for="view<?php echo $module['id'];?>">View</label>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="add" id="add<?php echo $module['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
              <label class="custom-control-label" for="add<?php echo $module['id'];?>">Add</label>
            </div>
          </div>
        </td>
        <td>
          <div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="edit" id="edit<?php echo $module['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
              <label class="custom-control-label" for="edit<?php echo $module['id'];?>">Edit</label>
            </div>
          </div>
        </td>
        <td><div class="form-group">
            <div class="custom-control custom-switch custom-switch-on-success">
              <input type="checkbox" class="custom-control-input" name="modules[<?php echo $module['module_slug'];?>][]" value="delete" id="delete<?php echo $module['id'];?>" <?php if($user_role == 2){ echo 'checked'; } ?>>
              <label class="custom-control-label" for="delete<?php echo $module['id'];?>">Delete</label>
            </div>
          </div>
        </td>
      </tr>
      <?php } } } ?>
    </table>
  <?php
    }
  }
}