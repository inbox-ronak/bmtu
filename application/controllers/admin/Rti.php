<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rti extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'rti';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(RTI,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(RTI,'edit');
		$delete_permission = $this->permission->grant(RTI,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
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
                  <td><?php echo $row['title'];?></td>
                 
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  		<form method="post" id="editForm" action="<?php echo base_url();?>admin/rti/<?php echo 'edit/'.base64_encode($row['id']); ?>">
                  			<input type="hidden" value="<?php echo base64_encode($row['id']); ?>" readonly name="id">
                  			<!-- <button class="btn btn-info btn-sm item_edit" type="submit">
                  				<i class='fa fa-edit'>
                  			</button> -->
	                  		<a onclick="document.getElementById('editForm').submit();" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  		</form>
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
	public function Index()
	{
	    $user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(RTI,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/rti/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(RTI,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
	    $title = trim($this->input->post('title'));
	    $description = trim($this->input->post('description'));
	   
				$data = array(
            'title' => $title,
            'description' => $description,
           
        );
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','RTI is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Rti');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/rti/add';
				$this->load->view('layout/template',$data);
      }
	}

	public function delete()
	{
		$permission = $this->permission->grant(RTI,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'RTI is deleted successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function edit($id)
	{
		$id = base64_decode($id);
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(RTI,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $title = trim($this->input->post('title'));
	    $description = trim($this->input->post('description'));
	    $status = trim($this->input->post('status'));
	    

	    $data = array(
            'title' => $title,
            'description' => $description,
            'status' => $status
           
      );
	    //print_r($data); die;
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','RTI is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/rti');
    }else{
    	$where_array = array('id' => $id);
    	$data['label'] = $this->common_model->get_records('rti','',$where_array,true);
    	// print_r($data['label']);die;
    	$data['main_page'] = 'backend/rti/add';
			$this->load->view('layout/template',$data);
      }
  }

}
