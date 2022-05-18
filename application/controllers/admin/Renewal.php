<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Renewal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'renewal_master';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(RENEWAL,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(RENEWAL,'edit');
		$delete_permission = $this->permission->grant(RENEWAL,'delete');
		$data = array();
		$filter_array['status!='] = 2;
		if($_POST['series_id'] != ''){
			$filter_array['series_id'] = $_POST['series_id'];
		}
		if($_POST['user_type'] != ''){
			$filter_array['user_type'] = $_POST['user_type'];
		}
		if($_POST['created_at1'] != ''){
			$filter_array['created_at>='] = $_POST['created_at1'].' 00:00:00';
		}
		if($_POST['created_at2'] != ''){
			$filter_array['created_at<='] = $_POST['created_at2'].' 23:59:00';
		}
		//$select_array = array('*','str_to_date(created_at, "%Y-%c-%d") day');
		$data = $this->common_model->get_records($this->dbTable,'',$filter_array);
		//echo $this->db->last_query();die;
		//print_r($data);die;
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Door No</th>
                  <th>Road</th>
                  <th>Area</th>
                  <th>City</th>
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
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['door_no'];?></td>
                  <td><?php echo $row['road'];?></td>
                  <td><?php echo $row['area'];?></td>
                  <td><?php echo $row['city'];?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/renewal/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<!-- <?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a> -->
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
		$permission = $this->permission->grant(RENEWAL,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/renewal/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(RENEWAL,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		//$where_arr = array('status' => 1);
		//$data['member_type'] = $this->common_model->get_records($this->member_type,'',$where_arr);
		if(isset($_POST['submit']))
		{
	    $renewal_description = trim($this->input->post('renewal_description'));
	    $name = trim($this->input->post('name'));
	    $door_no = trim($this->input->post('door_no'));
	    $road = trim($this->input->post('road'));
	    $area = trim($this->input->post('area'));
	    $city = trim($this->input->post('city'));
	    $state = trim($this->input->post('state'));
	    $pin = trim($this->input->post('pin'));
	    $name_phone = trim($this->input->post('name_phone'));
	    $member_type = trim($this->input->post('member_type'));
	    $std_phone = trim($this->input->post('std_phone'));
	    $std_mobile_number = trim($this->input->post('std_mobile_number'));
	    $email = trim($this->input->post('email'));
	    $nature_of_business = trim($this->input->post('nature_of_business'));
	    $nature_of_organistation = trim($this->input->post('nature_of_organistation'));
	    $au_registration = trim($this->input->post('au_registration'));
	    $registration_date = trim($this->input->post('registration_date'));
	    $footer_description = trim($this->input->post('footer_description'));
	    $status = trim($this->input->post('status'));
				$data = array(
            'renewal_description' => $renewal_description,
            'name' => $name,
            'door_no' => $door_no,
            'road' => $road,
            'area' => $area,
            'city' => $city,
            'state' => $state,
            'pin' => $pin,
            'name_phone' => $name_phone,
            'member_type' => $member_type,
            'std_phone' => $std_phone,
            'std_mobile_number' => $std_mobile_number,
            'email' => $email,
            'nature_of_business' => $nature_of_business,
            'nature_of_organistation' => $nature_of_organistation,
            'au_registration' => $au_registration,
            'registration_date' => $registration_date,
            'footer_description' => $footer_description,
            'status' => $status,
           
        );
		//print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Renewal is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/renewal');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/renewal/add';
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
		$permission = $this->permission->grant(RENEWAL,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{

	    $renewal_description = trim($this->input->post('renewal_description'));
	    $name = trim($this->input->post('name'));
	    $door_no = trim($this->input->post('door_no'));
	    $road = trim($this->input->post('road'));
	    $area = trim($this->input->post('area'));
	    $city = trim($this->input->post('city'));
	    $state = trim($this->input->post('state'));
	    $pin = trim($this->input->post('pin'));
	    $name_phone = trim($this->input->post('name_phone'));
	    $member_type = trim($this->input->post('member_type'));
	    $std_phone = trim($this->input->post('std_phone'));
	    $std_mobile_number = trim($this->input->post('std_mobile_number'));
	    $email = trim($this->input->post('email'));
	    $nature_of_business = trim($this->input->post('nature_of_business'));
	    $nature_of_organistation = trim($this->input->post('nature_of_organistation'));
	    $au_registration = trim($this->input->post('au_registration'));
	    $registration_date = trim($this->input->post('registration_date'));
	    $footer_description = trim($this->input->post('footer_description'));
	    $status = trim($this->input->post('status'));

	    $data = array(
            'renewal_description' => $renewal_description,
            'name' => $name,
            'door_no' => $door_no,
            'road' => $road,
            'area' => $area,
            'city' => $city,
            'state' => $state,
            'pin' => $pin,
            'name_phone' => $name_phone,
            'member_type' => $member_type,
            'std_phone' => $std_phone,
            'std_mobile_number' => $std_mobile_number,
            'email' => $email,
            'nature_of_business' => $nature_of_business,
            'nature_of_organistation' => $nature_of_organistation,
            'au_registration' => $au_registration,
            'registration_date' => $registration_date,
            'footer_description' => $footer_description,
            'status' => $status,
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Renewal is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/renewal');
    }else{
    	$where_array = array('id' => $id);
    	$data['renewal'] = $this->common_model->get_records('renewal_master','',$where_array,true);
    	//print_r($data['label']);die;
    	$data['main_page'] = 'backend/renewal/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(RENEWAL,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Renewal is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

}
