<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Attendance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'attendance';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ATTENDANCE,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(ATTENDANCE,'edit');
		$delete_permission = $this->permission->grant(ATTENDANCE,'delete');
		$data = array();
		//$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Employee Name</th>
                  <th>Date</th>
                  <th>Sign In</th>
                  <th>Sign Out</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php               
            if(isset($data) && !empty($data)) {
            	$i = 1;
                    foreach ($data as $row) { 
               ?>
                  <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php 
                       $category = $this->db->where('id',$row['employee'])->get('employees')->row_array();
                       if($category){ echo $category['first_name']; } ?></td>
                  <td><?php echo $row['date']; ?></td>			
                  <td><?php echo $row['sign_in']; ?></td>
                  <td><?php echo $row['sign_out']; ?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/Attendance/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(ATTENDANCE,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/attendance/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(ATTENDANCE,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$data = array(
						'employee'=>$this->input->post('employee'),
						'date'=>$this->input->post('date'),
						'sign_in'=>$this->input->post('sign_in'),
						'sign_out'=>$this->input->post('sign_out'),
						'place'=>$this->input->post('place'),
        );
				//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Attendance is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Attendance');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/attendance/add';
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
		$permission = $this->permission->grant(ATTENDANCE,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $data = array(
            'employee'=>$this->input->post('employee'),
						'date'=>$this->input->post('date'),
						'sign_in'=>$this->input->post('sign_in'),
						'sign_out'=>$this->input->post('sign_out'),
						'place'=>$this->input->post('place'),
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Attendance is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Attendance');
    }else{
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('attendance','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/attendance/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(ATTENDANCE,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Attendance is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
