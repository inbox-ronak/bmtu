<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Type_of_payable extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'type_of_payable';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(TYPE_OF_PAYABLE,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(TYPE_OF_PAYABLE,'edit');
		$delete_permission = $this->permission->grant(TYPE_OF_PAYABLE,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Type Of Payable</th>
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
                  <td><?php echo $row['type_of_payable'];?></td>
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php /*if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    
                	<?php }*/ ?>
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
		$permission = $this->permission->grant(TYPE_OF_PAYABLE,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/type_of_payable/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(TYPE_OF_PAYABLE,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// type_of_payable is already exists //
	    $type_of_payable = trim($this->input->post('type_of_payable'));
	    $record = $this->db->where('type_of_payable',$type_of_payable)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'Type Of Payable is already exists.';
	        echo json_encode($response);exit;
	    }
	    //
		$data = array(
            'type_of_payable' => $type_of_payable,
            'status' => $this->input->post('status'),
            'created_by' => $_SESSION['user_id'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_ip_address' => @$_SERVER['REMOTE_ADDR'],
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'Type Of Payable is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(TYPE_OF_PAYABLE,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Type Of Payable is deleted successfully.';
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
	    $permission = $this->permission->grant(TYPE_OF_PAYABLE,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(TYPE_OF_PAYABLE,'edit');
	    $delete_permission = $this->permission->grant(TYPE_OF_PAYABLE,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//print_r($data);
	    $this->load->view('backend/type_of_payable/getEdit',['data'=>$data[0]]);
	}
	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(TYPE_OF_PAYABLE,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		// Type Of Payable is already exists //
		$id = $_POST['id'];
	    $type_of_payable = trim($this->input->post('type_of_payable'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['type_of_payable'] == $type_of_payable){
	        		$response['success'] = 0;
	        		$response['message'] = 'Type Of Payable is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
                'type_of_payable' => $this->input->post('type_of_payable'),
        		'status' => $this->input->post('status'),
        		'updated_by' => $_SESSION['user_id'],
            	'updated_at' => date('Y-m-d H:i:s'),
            	'updated_ip_address' => @$_SERVER['REMOTE_ADDR'],           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'Type Of Payable is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

}
