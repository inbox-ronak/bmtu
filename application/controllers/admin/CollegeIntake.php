<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class CollegeIntake extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable2 = 'college';
		$this->dbTable = 'college_intake';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(COLLEGE_INTAKE,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(COLLEGE_INTAKE,'edit');
		$delete_permission = $this->permission->grant(COLLEGE_INTAKE,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
	?>
		<table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th>#</th>
                  <th>College Name</th>
                  <th>College Intake</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php               
            if(isset($data) && !empty($data)) {
            	$i = 1;
                    foreach ($data as $row) { 
                        $where_arr = array('status=' => 1, 'id'=>$row['college_name']);
                        $colleges = $this->common_model->get_records($this->dbTable2,'',$where_arr);
                    $status = '<span class="badge badge-danger">Deactive</span>';
	                  if($row['status'] == 1){
	                    $status = '<span class="badge badge-success">Active</span>';
	                  }
               ?>
                  <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $colleges[0]['college_name']; ?></td>
                  <td><?php echo $row['college_intake']; ?></td>
                  <td><?php echo $status; ?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/CollegeIntake/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(COLLEGE_INTAKE,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/college_intake/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(COLLEGE_INTAKE,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$data = array(
						'college_name'=>$this->input->post('college_name'),
						'college_intake'=>$this->input->post('college_intake'),
						'status'=>$this->input->post('status'),
        );
				//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','College Intake created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/CollegeIntake');
      }else{
        $where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
        // $data = array();
      	$data['main_page'] = 'backend/college_intake/add';
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
		$permission = $this->permission->grant(COLLEGE_INTAKE,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
			$data = array(
				'college_name'=>$this->input->post('college_name'),
                'college_intake'=>$this->input->post('college_intake'),
				'status'=>$this->input->post('status'),
			);
			$where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','College Intake is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/CollegeIntake');
    }else{
        $where_arr = array('status=' => 1);
        $data['colleges'] = $this->common_model->get_records($this->dbTable2,'',$where_arr);
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('college_intake','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/college_intake/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(COLLEGE_INTAKE,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'College Intake is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
