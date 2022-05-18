<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_version extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'app_version';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(APPVERSION,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(APPVERSION,'edit');
		$delete_permission = $this->permission->grant(APPVERSION,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		//$sort_order = 'ordering asc';
		$data = $this->common_model->get_records_with_sort_group($this->dbTable,'',$where_arr,'');
		//echo $this->db->last_query();exit;
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>App Version</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody class="row_position">
                <?php               
            if(isset($data) && !empty($data)) {
            	$i = 1;
                    foreach ($data as $row) { 
                    	 $status = '<span class="badge badge-danger">Deactive</span>';
	                  if($row['status'] == 1){
	                    $status = '<span class="badge badge-success">Active</span>';
	                  }
               ?>
                  <tr id="<?php echo $row['id'] ?>">
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row['app_version'];?></td>
                  <td><?php echo $row['changelog_date'];?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(APPVERSION,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/app_version/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(APPVERSION,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// faq_name is already exists //
	    $app_version = trim($this->input->post('app_version'));
	    $changelog_date = trim($this->input->post('changelog_date'));
	    $changelog = trim($this->input->post('changelog'));
	    //$slug = trim($this->input->post('slug'));

	    $record = $this->db->where('app_version',$app_version)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'App Version is already exists.';
	        echo json_encode($response);exit;
	    }
	    //
				$data = array(
	        //'user_id' => $user_id,
            'app_version' => $app_version,
            'changelog_date' => $changelog_date,
            'changelog' => $changelog,
            'status' => 1,
        );
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'App Version is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(APPVERSION,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'App Version is deleted successfully.';
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
	    $permission = $this->permission->grant(APPVERSION,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(APPVERSION,'edit');
	    $delete_permission = $this->permission->grant(APPVERSION,'delete');
	    $where_arr = array('id' => $id); 
			$data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
		//print_r($data);
	    $this->load->view('backend/app_version/getEdit',['data'=>$data]);
	}
	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(APPVERSION,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		//$id=$this->input->post('user_id');
		// Role is already exists //
			$id = $_POST['id'];
	    $app_version = trim($this->input->post('app_version'));
	    $changelog_date = trim($this->input->post('changelog_date'));
	    $changelog = trim($this->input->post('changelog'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['app_version'] == $app_version){
	        		$response['success'] = 0;
	        		$response['message'] = 'App Version is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
                'app_version' => $this->input->post('app_version'),
                'changelog_date' => $this->input->post('changelog_date'),
                'changelog' => $changelog,
        				//'status' => $this->input->post('status')
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'App Version is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

}

