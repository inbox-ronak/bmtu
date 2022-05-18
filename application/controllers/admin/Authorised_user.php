<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authorised_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'user_master';
		$this->product_master = 'product_master';
		$this->trade_partner = 'trade_partners';
		$this->type_of_business = 'type_of_business';
		$this->user_master = 'user_master';
		$this->designation = 'designation';
	}

	public function index()
	{
	    $user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(AUTHORISED_USER,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		//echo '<pre>';print_r($data['users']);exit;
		$data['main_page'] = 'backend/authorised_user/list';
		$this->load->view('layout/template',$data);
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(AUTHORISED_USER,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(AUTHORISED_USER,'edit');
		$delete_permission = $this->permission->grant(AUTHORISED_USER,'delete');
		$data = array();
		$where_arr = array('status!=' => 2,'role_id'=>5); 
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Authorised User Name</th>
                  <th>Address</th>
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
                  <td><?php echo $row['first_name'];?></td>
                  <td><?php echo $row['address'];?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url('admin/authorised_user/update/').base64_encode($row['id']);?>" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                	<?php } ?>
                	
					<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_aproved"><i class="fa fa-check" aria-hidden="true"></i></a>
                  	<?php } ?>

                  </td>
                </tr>
              <?php }} ?>
                </tbody>  
              </table>
        <?php
	}
	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(AUTHORISED_USER,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$where_arr = array('status' => 1);
		//$data['member_type'] = $this->common_model->get_records($this->member_type,'',$where_arr);
		$data['silk_product'] = $this->common_model->get_records($this->product_master,'',$where_arr);
		$data['type_of_business'] = $this->common_model->get_records($this->type_of_business,'',$where_arr);
		$data['designation'] = $this->common_model->get_records($this->designation,'',$where_arr);
		//echo '<pre>';print_r($_POST);exit;
		if(isset($_POST['btn-submit']))
		{
			// authorised_user_name is already exists //
		    $email = trim($this->input->post('email'));
		    $record = $this->db->where('email !=','')->where('email',$email)->where('status !=',2)->get($this->dbTable)->row_array();
		    if($record){
		        $response['success'] = 0;
		        $response['message'] = 'Email ID is already exists.';
		        echo json_encode($response);exit;
		    }
		    //echo '<pre>';print_r($_POST);die;
		    $tabledata['first_name'] = trim($_POST['first_name']);
		    $tabledata['last_name'] = trim($_POST['last_name']);
		    $tabledata['fax'] = trim($_POST['fax']);
		    $tabledata['email'] = trim($_POST['email']);
		    $tabledata['document_kyc'] = trim($_POST['document_kyc']);
		    $tabledata['designation_id'] = trim($_POST['designation_id']);
		    $tabledata['address'] = trim($_POST['address']);
		    $tabledata['pincode'] = trim($_POST['pincode']);
		    $tabledata['contact_person'] = trim($_POST['contact_person']);
		    $tabledata['contact_designation_id'] = trim($_POST['contact_designation_id']);
		    //$tabledata['amount'] = trim($_POST['amount']);
		    //$tabledata['member_type'] = trim($_POST['member_type']);
		    
		    $tabledata['city'] = trim($_POST['city']);
		    $tabledata['state'] = trim($_POST['state']);
		    $tabledata['mobile_no'] = trim($_POST['mobile_no']);
		    $tabledata['telephone1'] = trim($_POST['telephone1']);
		    $tabledata['country'] = trim($_POST['country']);
		    //$tabledata['payment_type'] = trim($_POST['payment_type']);
		    //$tabledata['payment_value'] = trim($_POST['payment_value']);
		    $tabledata['area'] = trim($_POST['area']);
		    //$tabledata['received_date'] = trim($_POST['received_date']);
		    //
		    $tabledata['branch_name'] = json_encode($_POST['branch_name']);
		    $tabledata['branch_address'] = json_encode($_POST['branch_address']);
		    $tabledata['branch_area'] = json_encode($_POST['branch_area']);
		    $tabledata['branch_country'] = json_encode($_POST['branch_country']);
		    $tabledata['branch_state'] = json_encode($_POST['branch_state']);
		    $tabledata['branch_city'] = json_encode($_POST['branch_city']);
		    $tabledata['branch_pincode'] = json_encode($_POST['branch_pincode']);
		    $tabledata['type_of_business'] = json_encode($_POST['type_of_business']);
		    $tabledata['silk_product'] = json_encode($_POST['silk_product']);
		    //
		    $tabledata['unit_branch_name'] = trim($_POST['unit_branch_name']);
		    $tabledata['unit_address'] = trim($_POST['unit_address']);
		    $tabledata['unit_area'] = trim($_POST['unit_area']);
		    $tabledata['unit_country'] = trim($_POST['unit_country']);
		    $tabledata['unit_state'] = trim($_POST['unit_state']);
		    $tabledata['unit_city'] = trim($_POST['unit_city']);
		    $tabledata['unit_pincode'] = trim($_POST['unit_pincode']);
		    $tabledata['unit_mobile_no'] = trim($_POST['unit_mobile_no']);
		    $tabledata['unit_telephone1'] = trim($_POST['unit_telephone1']);
		    $tabledata['unit_type_of_business'] = json_encode($_POST['unit_type_of_business']);
		    $tabledata['unit_silk_product'] = json_encode($_POST['unit_silk_product']);
		    $tabledata['turn_over_in_production'] = trim($_POST['turn_over_in_production']);
		    $tabledata['turnover_details'] = trim($_POST['turnover_details']);
		    $tabledata['turnover'] = trim($_POST['turnover']);
		    $tabledata['details_of_sourcing'] = trim($_POST['details_of_sourcing']);
		    $tabledata['for_manufactures_facilities'] = trim($_POST['for_manufactures_facilities']);
		    $tabledata['quality_control'] = trim($_POST['quality_control']);
		    $tabledata['specify_the_items_proposed'] = trim($_POST['specify_the_items_proposed']);
		    $tabledata['do_you_propose'] = trim($_POST['do_you_propose']);
		    $tabledata['turn_over_of_silk_exports'] = trim($_POST['turn_over_of_silk_exports']);
		    $tabledata['rules_and_regulations'] = trim($_POST['rules_and_regulations']);
		    $tabledata['place'] = trim($_POST['place']);
		    $tabledata['submit_date'] = trim($_POST['submit_date']);
		    //$tabledata['name'] = trim($_POST['name']);
		    //$tabledata['contact_designation_id_2'] = trim($_POST['designation_id'];

		    $tabledata['status'] = trim($_POST['status']);
		    $tabledata['created_by'] = $_SESSION['user_id'];
		    $tabledata['created_at'] = date('Y-m-d H:i:s');
		    $tabledata['role_id'] = '5';
		    //echo '<pre>';print_r($tabledata);die;
	        $insert = $this->common_model->add_records($this->dbTable,$tabledata);
	        $response = array();
	        if($insert){
	        	$response['success'] = 1;
	        	$response['message'] = 'Authorised User is created successfully.';
	        }else{
	        	$response['success'] = 0;
	        	$response['message'] = 'Something went wrong.';
	        }
	        echo json_encode($response);
	    }else{
	    	$where_arr = array('status' => 1); 
			$data['main_page'] = 'backend/authorised_user/addEdit';
			$this->load->view('layout/template',$data);
	    }
	}

	public function delete()
	{
		$permission = $this->permission->grant(AUTHORISED_USER,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Authorised User is deleted successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function approved()
	{
		$permission = $this->permission->grant(AUTHORISED_USER,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['approved_status'] = 1;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Authorised is Approved successfully.';
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
	    $permission = $this->permission->grant(AUTHORISED_USER,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(AUTHORISED_USER,'edit');
	    $delete_permission = $this->permission->grant(AUTHORISED_USER,'delete');
	    $where_arr = array('id' => $id); 
		$data['data'] = $this->common_model->get_records($this->dbTable,'',$where_arr,true);
		//print_r($data);
		$this->db->select('id,CONCAT(first_name , " ", last_name  )as name');
		$this->db->where('status',1);
		$this->db->where_in('role_id', ['1','2','3']);
		$data['users'] = $this->db->get($this->user_master)->result_array();
		$where_arr = array('status' => 1);
		$data['member_type'] = $this->common_model->get_records($this->member_type,'',$where_arr);
		$data['trade_partners'] = $this->common_model->get_records($this->trade_partner,'',$where_arr);
		$data['type_of_business'] = $this->common_model->get_records($this->type_of_business,'',$where_arr);
		$data['payment_type'] = $this->common_model->get_records($this->payment_type,'',$where_arr);
		//echo '<pre>';print_r($data['users']);exit;
	    $this->load->view('backend/authorised_user/getEdit',$data);
	}
	public function update($id)
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(AUTHORISED_USER,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$where_arr = array('status' => 1);
		//$data['member_type'] = $this->common_model->get_records($this->member_type,'',$where_arr);
		$data['silk_product'] = $this->common_model->get_records($this->product_master,'',$where_arr);
		$data['type_of_business'] = $this->common_model->get_records($this->type_of_business,'',$where_arr);
		$data['designation'] = $this->common_model->get_records($this->designation,'',$where_arr);
		$where_arr = array('id'=>base64_decode($id)); 
		$data['record'] = $this->common_model->get_records($this->dbTable,'',$where_arr,true);
		if(isset($_POST['btn-submit']))
		{
			$id = base64_decode($_POST['id']);
			// Email is already exists //
		    $email = trim($this->input->post('email'));
		    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
		    if($record){
		    	foreach ($record as $value){
		    		if($value['email'] == $email){
		        		$response['success'] = 0;
		        		$response['message'] = 'Email ID is already exists.';
		        		echo json_encode($response);exit;
		        	}
		        }
		    }
		    //
		    //echo '<pre>';print_r($_POST);die;
		    $tabledata['first_name'] = trim($_POST['first_name']);
		    $tabledata['last_name'] = trim($_POST['last_name']);
		    $tabledata['fax'] = trim($_POST['fax']);
		    $tabledata['email'] = trim($_POST['email']);
		    $tabledata['document_kyc'] = trim($_POST['document_kyc']);
		    $tabledata['designation_id'] = trim($_POST['designation_id']);
		    $tabledata['address'] = trim($_POST['address']);
		    $tabledata['pincode'] = trim($_POST['pincode']);
		    $tabledata['contact_person'] = trim($_POST['contact_person']);
		    $tabledata['contact_designation_id'] = trim($_POST['contact_designation_id']);
		    //$tabledata['amount'] = trim($_POST['amount']);
		    //$tabledata['member_type'] = trim($_POST['member_type']);
		    
		    $tabledata['city'] = trim($_POST['city']);
		    $tabledata['state'] = trim($_POST['state']);
		    $tabledata['mobile_no'] = trim($_POST['mobile_no']);
		    $tabledata['telephone1'] = trim($_POST['telephone1']);
		    $tabledata['country'] = trim($_POST['country']);
		    //$tabledata['payment_type'] = trim($_POST['payment_type']);
		    //$tabledata['payment_value'] = trim($_POST['payment_value']);
		    $tabledata['area'] = trim($_POST['area']);
		    //$tabledata['received_date'] = trim($_POST['received_date']);
		    //
		    $tabledata['branch_name'] = json_encode($_POST['branch_name']);
		    $tabledata['branch_address'] = json_encode($_POST['branch_address']);
		    $tabledata['branch_area'] = json_encode($_POST['branch_area']);
		    $tabledata['branch_country'] = json_encode($_POST['branch_country']);
		    $tabledata['branch_state'] = json_encode($_POST['branch_state']);
		    $tabledata['branch_city'] = json_encode($_POST['branch_city']);
		    $tabledata['branch_pincode'] = json_encode($_POST['branch_pincode']);
		    $tabledata['type_of_business'] = json_encode($_POST['type_of_business']);
		    $tabledata['silk_product'] = json_encode($_POST['silk_product']);
		    //
		    $tabledata['unit_branch_name'] = trim($_POST['unit_branch_name']);
		    $tabledata['unit_address'] = trim($_POST['unit_address']);
		    $tabledata['unit_area'] = trim($_POST['unit_area']);
		    $tabledata['unit_country'] = trim($_POST['unit_country']);
		    $tabledata['unit_state'] = trim($_POST['unit_state']);
		    $tabledata['unit_city'] = trim($_POST['unit_city']);
		    $tabledata['unit_pincode'] = trim($_POST['unit_pincode']);
		    $tabledata['unit_mobile_no'] = trim($_POST['unit_mobile_no']);
		    $tabledata['unit_telephone1'] = trim($_POST['unit_telephone1']);
		    $tabledata['unit_type_of_business'] = json_encode($_POST['unit_type_of_business']);
		    $tabledata['unit_silk_product'] = json_encode($_POST['unit_silk_product']);
		    $tabledata['turn_over_in_production'] = trim($_POST['turn_over_in_production']);
		    $tabledata['turnover_details'] = trim($_POST['turnover_details']);
		    $tabledata['turnover'] = trim($_POST['turnover']);
		    $tabledata['details_of_sourcing'] = trim($_POST['details_of_sourcing']);
		    $tabledata['for_manufactures_facilities'] = trim($_POST['for_manufactures_facilities']);
		    $tabledata['quality_control'] = trim($_POST['quality_control']);
		    $tabledata['specify_the_items_proposed'] = trim($_POST['specify_the_items_proposed']);
		    $tabledata['do_you_propose'] = trim($_POST['do_you_propose']);
		    $tabledata['turn_over_of_silk_exports'] = trim($_POST['turn_over_of_silk_exports']);
		    $tabledata['rules_and_regulations'] = trim($_POST['rules_and_regulations']);
		    $tabledata['place'] = trim($_POST['place']);
		    $tabledata['submit_date'] = trim($_POST['submit_date']);
		    //$tabledata['name'] = trim($_POST['name']);
		    //$tabledata['contact_designation_id_2'] = trim($_POST['designation_id'];

		    $tabledata['status'] = trim($_POST['status']);
		    //$tabledata['role_id'] = '5';
		    $data['updated_by'] = $_SESSION['user_id'];
		    $data['updated_at'] = date('Y-m-d H:i:s');
	        //echo '<pre>';print_r($data);exit;
	        $where_array = array('id' => $id);
			$update = $this->common_model->update_records($this->dbTable,$tabledata,$where_array);
	        $response = array();
	        if($update){
	        	$response['success'] = 1;
	        	$response['message'] = 'Authorised User is updated successfully.';
	        }else{
	        	$response['success'] = 0;
	        	$response['message'] = 'Something went wrong.';
	        }
	        echo json_encode($response);exit;
	    }else{
	    	$where_arr = array('status' => 1); 
			$data['main_page'] = 'backend/authorised_user/addEdit';
			$this->load->view('layout/template',$data);
	    }
	}
}