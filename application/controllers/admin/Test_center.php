<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_center extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'test_center';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(TEST_CENTER,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(TEST_CENTER,'edit');
		$delete_permission = $this->permission->grant(TEST_CENTER,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Location Name</th>
                  <th>Location Info</th>
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
                  <td><?php echo $row['location_name'];?></td>
                  <td><?php echo $row['location_info'];?></td>
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" data-role="<?php echo $row['latitude'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<!-- <?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?> -->
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
		$permission = $this->permission->grant(TEST_CENTER,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/test_center/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(TEST_CENTER,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// latitude is already exists //
	    $latitude = trim($this->input->post('latitude'));
	    $longitude = trim($this->input->post('longitude'));
	    $location_name = trim($this->input->post('location_name'));
	    $location_info = trim($this->input->post('location_info'));
	    $record = $this->db->where('latitude',$latitude)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'Location Name is already exists.';
	        echo json_encode($response);exit;
	    }
	    //
		$data = array(
	        //'user_id' => $user_id,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'location_name' => $location_name,
            'location_info' => $location_info,
            'status' => $this->input->post('status')
            //'permission' => json_encode($this->input->post('modules'))
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();

        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'Loaction Name is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(TEST_CENTER,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Location is deleted successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function getEdit($id)
	{
	    $user_id=$_SESSION['user_id'];
	    if(!isset($_SESSION['user_id']))
	    {
	      redirect('admin/login');
		}
	    $permission = $this->permission->grant(TEST_CENTER,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(TEST_CENTER,'edit');
	    $delete_permission = $this->permission->grant(TEST_CENTER,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//print_r($data);
	    $this->load->view('backend/test_center/getEdit',['data'=>$data[0]]);
	}
	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(TEST_CENTER,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		//$id=$this->input->post('user_id');
		// Role is already exists //
		$id = $_POST['id'];
	    $latitude = trim($this->input->post('latitude'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['latitude'] == $latitude){
	        		$response['success'] = 0;
	        		$response['message'] = 'Loaction is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
                'latitude' => $this->input->post('latitude'),
        		'status' => $this->input->post('status')
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'Series is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

}
