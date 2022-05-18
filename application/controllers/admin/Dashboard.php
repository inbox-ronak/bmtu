<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct() {
	    parent::__construct();
	    $this->load->model('home_model');
	}
	public function index()
	{
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}

		// start Dashboard Data //

		/*$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$sql= $this->db->get('users');
		$data['total_users'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('status',1);
		$sql= $this->db->get('users');
		$data['active_users'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('status',0);
		$sql= $this->db->get('users');
		$data['inactive_users'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$sql= $this->db->get('products');
		$data['total_products'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('isVerified',1);
		$sql= $this->db->get('products');
		$data['active_products'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('isVerified',0);
		$sql= $this->db->get('products');
		$data['inactive_products'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$sql= $this->db->get('categories');
		$data['total_categories'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('isVerified',1);
		$sql= $this->db->get('categories');
		$data['active_categories'] = $sql->row_array();

		$this->db->select('count(*) as total');
		$this->db->where('trash',0);
		$this->db->where('isVerified',0);
		$sql= $this->db->get('categories');
		$data['inactive_categories'] = $sql->row_array();

		// Unverified Products //

		/*$module = 'products';
		$user_id = $_SESSION['user_id'];
		$user_role = $_SESSION['user_role'];
		
		$array = array('trash' =>0,'isVerified'=>0);
		if($user_role != 1){
			$array = array('trash' => 0,'isVerified'=>0,'user_id' => $user_id);
		}
		$query = $this->db->get_where($module,$array);
		$data['products'] = $query->result_array();*/

		// end Dashboard Data //

		$data['users'] = array();//$this->home_model->all_users();
		$data['main_page'] = 'backend/home';
		$this->load->view('layout/template',$data);
	}
	/*public function active_products()
	{
		$module = 'products';
		$user_id = $_SESSION['user_id'];
		$user_role = $_SESSION['user_role'];

		$permission = $this->permission->grant(PRODUCTS,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(PRODUCTS,'edit');
		$delete_permission = $this->permission->grant(PRODUCTS,'delete');
		
		$array = array('trash' =>0,'isVerified'=>1);
		if($user_role != 1){
			$array = array('trash' => 0,'isVerified'=>1,'user_id' => $user_id);
		}
		$query = $this->db->get_where($module,$array);
		$products = $query->result_array();

	    $draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));
	    
	    $data = array();
	    if($products){
	      $i = 0;
	      foreach($products as $row) {
	        //print_r($row);
	        $number = $i+1;
	        $data[$i][] = $number;
	        $data[$i][] = '<div class="zoomin submain"><img class="img-circle img-size-32 mr-2" width="80" src="'.base_url().'assets/uploads/products/'.$row['mainImage'].'"></div>';
	        $data[$i][] = $row['product_name'];

	        $category = $this->category_model->get_category($row['category_id']);
	        $data[$i][] = $category['category'];
	        $data[$i][] = ($row['isVerified'] == 1) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Not Verified</span>';
	        $data[$i][] = ($row['status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>';

	        $action = '';

	        if($user_role == 1){

	            $title = 'Unverify';
	            $icon = 'fa fa-times';
	            $verified = 'btn-danger';
	          if($row['isVerified'] == 0){
	            $title = 'Verify';
	            $icon = 'fa fa-check';
	            $verified = 'btn-success'; 
	          }

	        $action .= '<a data-toggle="tooltip" title="'.$title.' Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" data-verify="'.$row['isVerified'].'" class="btn '.$verified.' btn-sm item_verify"><i class="'.$icon.'"></i></a>&nbsp;';
	        
	        }

	        if($edit_permission == true){

	        //$action .= '<a data-toggle="tooltip" title="Edit Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>&nbsp;';
	        
	        } 
	        if($delete_permission == true){

	       	//$action .= '<a data-toggle="tooltip" title="Delete Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>';
	        
	        }

	        //$data[$i][] = $action;
	        $i++;
	      }
	    }
	    //print_r($data);
	    $output = array(
	      "draw" => $draw,
	      "recordsTotal" => count($data),
	      "recordsFiltered" => count($data),
	      "data" => $data
	    );
	    echo json_encode($output);
	}

	public function inactive_products()
	{
		$module = 'products';
		$user_id = $_SESSION['user_id'];
		$user_role = $_SESSION['user_role'];

		$permission = $this->permission->grant(PRODUCTS,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(PRODUCTS,'edit');
		$delete_permission = $this->permission->grant(PRODUCTS,'delete');
		
		$array = array('trash' =>0,'isVerified'=>0);
		if($user_role != 1){
			$array = array('trash' => 0,'isVerified'=>0,'user_id' => $user_id);
		}
		$query = $this->db->get_where($module,$array);
		$products = $query->result_array();

	    $draw = intval($this->input->get("draw"));
	    $start = intval($this->input->get("start"));
	    $length = intval($this->input->get("length"));
	    
	    $data = array();
	    if($products){
	      $i = 0;
	      foreach($products as $row) {
	        //print_r($row);
	        $number = $i+1;
	        $data[$i][] = $number;
	        $data[$i][] = '<div class="zoomin submain"><img class="img-circle img-size-32 mr-2" width="80" src="'.base_url().'assets/uploads/products/'.$row['mainImage'].'"></div>';
	        $data[$i][] = $row['product_name'];

	        $category = $this->category_model->get_category($row['category_id']);
	        $data[$i][] = $category['category'];
	        $data[$i][] = ($row['isVerified'] == 1) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Not Verified</span>';
	        $data[$i][] = ($row['status'] == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>';

	        $action = '';

	        if($user_role == 1){

	            $title = 'Unverify';
	            $icon = 'fa fa-times';
	            $verified = 'btn-danger';
	          if($row['isVerified'] == 0){
	            $title = 'Verify';
	            $icon = 'fa fa-check';
	            $verified = 'btn-success'; 
	          }

	        $action .= '<a data-toggle="tooltip" title="'.$title.' Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" data-verify="'.$row['isVerified'].'" class="btn '.$verified.' btn-sm item_verify"><i class="'.$icon.'"></i></a>&nbsp;';
	        
	        }

	        if($edit_permission == true){

	        //$action .= '<a data-toggle="tooltip" title="Edit Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>&nbsp;';
	        
	        } 
	        if($delete_permission == true){

	       	//$action .= '<a data-toggle="tooltip" title="Delete Product" href="javascript:void(0);" data-product_id="'.$row['product_id'].'" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>';
	        
	        }

	        $data[$i][] = $action;
	        $i++;
	      }
	    }
	    //print_r($data);
	    $output = array(
	      "draw" => $draw,
	      "recordsTotal" => count($data),
	      "recordsFiltered" => count($data),
	      "data" => $data
	    );
	    echo json_encode($output);
	}

	public function inactive_categories()
	{
		$user_id=$_SESSION['user_id'];
		$user_role=$_SESSION['user_role'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(CATEGORY,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(CATEGORY,'edit');
		$delete_permission = $this->permission->grant(CATEGORY,'delete');
		
		if($user_role != 1){
    		$this->db->where('user_id',$user_id);
    	}
    	$this->db->where('trash',0);
    	$this->db->where('isVerified',0);
        $this->db->order_by("category_id", "desc");
	    $query = $this->db->get('categories');
		$data = $query->result_array();
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Category</th>
                  <th>Parent Category</th>
                  <th>Verified</th>
                  <th>Status</th>
                  <!-- <th>Icon Class</th> -->
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
                  <td><?php echo $row['category'];?></td>
                  <td><?php 
                  $parent_category = $this->db->where('category_id',$row['parentId'])->get('categories')->row_array();
                  echo ($parent_category) ? $parent_category['category'] : '';
                  ?>
                  </td>
                  <td><?php 
                  echo ($row['isVerified'] == 1) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Not Verified</span>';?>
                  </td>
                  <td><?php echo $status;?></td>
                  <!-- <td><?php //echo $row['icon_class'];?></td> -->
                  <td>
                  	<?php 
                  		if($user_role == 1){
                  			$title = 'Unverify';
				            $icon = 'fa fa-times';
				            $verified = 'btn-danger';
				          if($row['isVerified'] == 0){
				            $title = 'Verify';
				            $icon = 'fa fa-check';
				            $verified = 'btn-success'; 
				          }
				    ?>
					<a data-toggle="tooltip" title="<?php echo $title;?> Category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" data-verify="<?php echo $row['isVerified'];?>" class="btn <?php echo $verified;?> btn-sm item_verify"><i class="<?php echo $icon;?>"></i></a>
                  	<?php } ?>
                  	<?php if($edit_permission == true){ ?>
                  	<a data-toggle="tooltip" title="Edit category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" data-category="<?php echo $row['category'];?>" data-parent_category="<?php echo $row['parentId'];?>" data-status="<?php echo $row['status'];?>" data-icon_class="<?php echo $row['icon_class'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a data-toggle="tooltip" title="Delete category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?>
                  </td>
                </tr>
              <?php } } ?>
                </tbody>  
              </table>
        <?php
	}

	public function active_categories()
	{
		$user_id=$_SESSION['user_id'];
		$user_role=$_SESSION['user_role'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(CATEGORY,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(CATEGORY,'edit');
		$delete_permission = $this->permission->grant(CATEGORY,'delete');
		
		if($user_role != 1){
    		$this->db->where('user_id',$user_id);
    	}
    	$this->db->where('trash',0);
    	$this->db->where('isVerified',1);
        $this->db->order_by("category_id", "desc");
	    $query = $this->db->get('categories');
		$data = $query->result_array();
	?>
		<table id="dataTable6" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Category</th>
                  <th>Parent Category</th>
                  <th>Verified</th>
                  <th>Status</th>
                  <!-- <th>Icon Class</th> -->
                  <!-- <th>Action</th> -->
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
                  <td><?php echo $row['category'];?></td>
                  <td><?php 
                  $parent_category = $this->db->where('category_id',$row['parentId'])->get('categories')->row_array();
                  echo ($parent_category) ? $parent_category['category'] : '';
                  ?>
                  </td>
                  <td><?php 
                  echo ($row['isVerified'] == 1) ? '<span class="badge badge-success">Verified</span>' : '<span class="badge badge-danger">Not Verified</span>';?>
                  </td>
                  <td><?php echo $status;?></td>
                  <!-- <td><?php //echo $row['icon_class'];?></td> -->
                  <!--<td>
                  	<?php 
                  		if($user_role == 1){
                  			$title = 'Unverify';
				            $icon = 'fa fa-times';
				            $verified = 'btn-danger';
				          if($row['isVerified'] == 0){
				            $title = 'Verify';
				            $icon = 'fa fa-check';
				            $verified = 'btn-success'; 
				          }
				    ?>
					<a data-toggle="tooltip" title="<?php echo $title;?> Category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" data-verify="<?php echo $row['isVerified'];?>" class="btn <?php echo $verified;?> btn-sm item_verify"><i class="<?php echo $icon;?>"></i></a>
                  	<?php } ?>
                  	<?php if($edit_permission == true){ ?>
                  	<a data-toggle="tooltip" title="Edit category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" data-category="<?php echo $row['category'];?>" data-parent_category="<?php echo $row['parentId'];?>" data-status="<?php echo $row['status'];?>" data-icon_class="<?php echo $row['icon_class'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a data-toggle="tooltip" title="Delete category" href="javascript:void(0);" data-category_id="<?php echo $row['category_id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?>
                  </td>-->
                </tr>
              <?php } } ?>
                </tbody>  
              </table>
        <?php
	}
	public function active_users()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(USERS,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(USERS,'edit');
		$delete_permission = $this->permission->grant(USERS,'delete');
		$data = array();
		$module = 'users';
		$id = $_SESSION['user_id'];
		$query = $this->db->get_where($module, array('status'=>1,'trash' =>0));
		$data = $query->result_array();
	?>
	<table id="dataTable4" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile Number</th>
          <th>Role</th>
          <th>Status</th>
          <!-- <th>Action</th> -->
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
                  <td><?php echo $row['firstname'].' '.$row['lastname'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['phone_no'];?></td>
                  <td><?php $role = $this->db->where('role_id',$row['role_id'])->get('roles')->row_array();
                            echo $role['role_name'];  ?>
                  </td>
                  <td><?php echo $status;?></td>
                  <!-- <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a data-toggle="tooltip" title="Edit User" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a data-toggle="tooltip" title="Delete user" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?>
                  </td> -->
                </tr>
          <?php } } ?>
        </tbody>  
      </table>
    <?php
	}
	public function inactive_users()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(USERS,'view');
		if($permission == false){
			redirect('dashboard');
		}
		$edit_permission = $this->permission->grant(USERS,'edit');
		$delete_permission = $this->permission->grant(USERS,'delete');
		$data = array();
		$module = 'users';
		$id = $_SESSION['user_id'];
		$query = $this->db->get_where($module, array('status'=>0,'trash' =>0));
		$data = $query->result_array();
	?>
	<table id="dataTable5" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile Number</th>
          <th>Role</th>
          <th>Status</th>
          <!-- <th>Action</th> -->
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
                  <td><?php echo $row['firstname'].' '.$row['lastname'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['phone_no'];?></td>
                  <td><?php $role = $this->db->where('role_id',$row['role_id'])->get('roles')->row_array();
                            echo $role['role_name'];  ?>
                  </td>
                  <td><?php echo $status;?></td>
                  <!-- <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a data-toggle="tooltip" title="Edit User" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php if($delete_permission == true){ ?>
                    <a data-toggle="tooltip" title="Delete user" href="javascript:void(0);" data-user_id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?>
                  </td> -->
                </tr>
          <?php } } ?>
        </tbody>  
      </table>
    <?php
	}
	/*public function add(){
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$this->load->view('user_add');
	}
	public function add_user(){
		
		if(isset($_POST['submit'])){
			
			$name = trim($_POST['name']);
			$email = trim($_POST['email']);
			$mobile = trim($_POST['mobile']);
			$password = md5($_POST['password']);
			$role_name = trim($_POST['role_name']);

			$this->db->where('email',$email);
			$this->db->where('trash',0);
			$sql= $this->db->get('user');
			$result_uniq = $sql->result_array();

			if($result_uniq){
				$this->session->set_flashdata("error", "Email Id is already exists.");
				redirect('users/add');exit;
			}
			
			$data['user_name'] = $name;
			$data['name'] = $name;
			$data['mobile'] = $mobile;
			$data['email'] = $email;
			$data['password'] = $password;
			$data['role_name'] = $role_name;
			$insert = $this->db->insert('user',$data);
			if($insert){
				$this->session->set_flashdata("success", "User is successfully created");
				redirect('home');
			}else{
				$this->session->set_flashdata("error", "Something went wrong.");
				redirect('users/add');
			}

		}else{
			redirect('admin/login');
		}
	}
	
	public function update_user()
	{
		if(isset($_POST['submit'])){
			$name= $_POST['name'];
			$email= $_POST['email'];
			$mobile = $_POST['mobile'];
			$role_name=$_POST['role_name'];
			
			$this->db->where('user_id !=',$_POST['id']);
			$this->db->where('trash',0);
			$sql= $this->db->get('user');
			$result_uniq =$sql->result_array();

			if($result_uniq){
				foreach($result_uniq as $row)
				{
					if($row['email'] == $email){
						$this->session->set_flashdata("error", "Email Id already exists..");
						redirect('users/edit/'.$_POST['id']);exit;
					 }
				}
			}
			
			$data['user_name'] = $name;
			$data['name'] = $name;
			$data['mobile'] = $mobile;
			$data['email'] = $email;
			if($_POST['password'] != ""){
				$password = md5($_POST['password']);
				$data['password'] = $password;
			}

			$data['role_name'] = $role_name;
				
			$this->db->where('user_id', $_POST['id']);
			$update = $this->db->update('user', $data);
			if($update){
				$this->session->set_flashdata("success", "User is successfully updated.");
				redirect('home');
			}else{
				$this->session->set_flashdata("error", "Something went wrong.");
				redirect('users/edit/'.$_POST['id']);
			}
			
		}
	}
	public function edit(){
		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != 1){
			redirect('products');
		}
		$id = $this->uri->segment(3);
		$table = 'user';
		$data['user'] = $this->home_model->getuser($id);
		//echo '<pre>';print_r($data['user']);
		if($data['user']){
			$this->load->view('edit_user',$data);	
		}else{
			redirect('home');
		}
	}
	
	public function delete_user() {
		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != 1){
			redirect('products');
		}
			$id = $this->uri->segment(3);
			//echo $id;exit;
			$data['trash']="1";
			$this->db->where('user_id',$id);
			$this->db->update('user',$data);
		
			$this->session->set_flashdata("error", "User is successfully deleted.");
			redirect('home');
    }*/

    /*public function sendmail()
    {
    	$this->load->config('email');
        $this->load->library('email');
        
        $from = $this->config->item('smtp_user');
        $to = 'rahul@inboxtechs.com';
        $subject = "Test Subject";
        //$message = "Send Mail successfully";
        $data['records'] = array();
        $message = $this->load->view('register_mail', $data,  TRUE);

        $this->email->set_newline("\r\n");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
        } else {
            show_error($this->email->print_debugger());
        }
    }
    public function test()
    {

   		$data['user_id'] = base64_encode(1);

    	$query = $this->db->query("SELECT * FROM header_settings");
        $data['header'] = $query->row_array();

        $query = $this->db->query("SELECT * FROM contact_us");
        $data['contact_us'] = $query->row_array();

        $data['logo'] = base_url().'assets/uploads/'.$data['header']['logo'];

    	$this->load->view('register_mail',$data);
    }
    public function complete_registration()
    {
   		$user_id = base64_decode($this->uri->segment(2));
		//echo $id;exit;
		$data['status'] = 1;
		$data['isVerified'] = 1;
		$this->db->where('id',$user_id);
		$update = $this->db->update('users',$data);
		//echo $this->db->last_query();exit;
   		if($update){

   			$query = $this->db->query("SELECT * FROM header_settings");
	        $data['header'] = $query->row_array();

	        $query = $this->db->query("SELECT * FROM contact_us");
	        $data['contact_us'] = $query->row_array();

	        $data['logo'] = base_url().'assets/uploads/'.$data['header']['logo'];
	        $data['website'] = $data['header']['website'];

   			$this->load->view('thankyou',$data);
   		}
    }
    public function success()
    {
    	$query = $this->db->query("SELECT * FROM header_settings");
        $data['header'] = $query->row_array();

        $query = $this->db->query("SELECT * FROM contact_us");
        $data['contact_us'] = $query->row_array();

        $data['logo'] = base_url().'assets/uploads/'.$data['header']['logo'];
        $data['website'] = $data['header']['website'];

		$this->load->view('success_forgotpassword',$data);
    }
    public function resetpassword()
    {
    	$query = $this->db->query("SELECT * FROM header_settings");
	    $data['header'] = $query->row_array();

	    $query = $this->db->query("SELECT * FROM contact_us");
	    $data['contact_us'] = $query->row_array();

	    $data['logo'] = base_url().'assets/uploads/'.$data['header']['logo'];
	    $data['website'] = $data['header']['website'];

   		$user_id = base64_decode($this->uri->segment(2));

   		$this->db->where('id',$user_id);
		$this->db->where('password_request',0);
		$sql= $this->db->get('users');
		$result_uniq = $sql->result_array();

		if($result_uniq){

			redirect($data['website']);
		}

   		if(isset($_POST['submit'])){

   			$data2['password_request'] = 0;
   			$data2['password'] = md5(trim($_POST['password']));
			$this->db->where('id',$user_id);
			$update = $this->db->update('users',$data2);
			if($update){
				redirect('dashboard/success');
			}else{
				$this->load->view('forgotpassword',$data);
			}
   		}else{
   			$this->load->view('forgotpassword',$data);
  		}
    }*/
}