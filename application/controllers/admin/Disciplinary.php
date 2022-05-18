<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Disciplinary extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'disciplinary';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(DISCIPLINARY,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(DISCIPLINARY,'edit');
		$delete_permission = $this->permission->grant(DISCIPLINARY,'delete');
		$data = array();
		//$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Employee Name</th>
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
                    //$disciplinary = '<span class="badge badge-danger">Deactive</span>';
	                  if($row['disciplinary'] == 1){
	                    $disciplinary = '<span class="badge badge-success">Verbel Warning</span>';
	                  }else if($row['disciplinary'] == 2){
	                    $disciplinary = '<span class="badge badge-success">Writing Warning</span>';
	                  }else if($row['disciplinary'] == 3){
	                    $disciplinary = '<span class="badge badge-success">Demotion</span>';
	                  }else if ($row['disciplinary'] == 4){
	                    $disciplinary = '<span class="badge badge-success">Suspension</span>';}
               ?>
                  <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php 
                       $category = $this->db->where('id',$row['employee'])->get('employees')->row_array();
                       if($category){ echo $category['first_name']; } ?></td>
                  <td><?php echo $row['title']; ?></td>			
                  <td><?php echo $disciplinary; ?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/Disciplinary/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(DISCIPLINARY,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/disciplinary/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(DISCIPLINARY,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$data = array(
						'employee'=>$this->input->post('employee'),
						'disciplinary'=>$this->input->post('disciplinary'),
						'title'=>$this->input->post('title'),
						'details'=>$this->input->post('details'),
        );
				//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Disciplinary is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Disciplinary');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/disciplinary/add';
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
		$permission = $this->permission->grant(DISCIPLINARY,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $data = array(
            'employee'=>$this->input->post('employee'),
						'disciplinary'=>$this->input->post('disciplinary'),
						'title'=>$this->input->post('title'),
						'details'=>$this->input->post('details'),
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Disciplinary is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Disciplinary');
    }else{
    	$where_array = array('id' => $id);
    	$data['record'] = $this->common_model->get_records('disciplinary','',$where_array,true);
    	//print_r($data['product']);die;
    	$data['main_page'] = 'backend/disciplinary/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(DISCIPLINARY,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Disciplinary is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
