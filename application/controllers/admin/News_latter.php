<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_latter extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'news_latter_master';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(NEWS_LATTER,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(NEWS_LATTER,'edit');
		$delete_permission = $this->permission->grant(NEWS_LATTER,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		//$sort_order = 'ordering asc';
		$data = $this->common_model->get_records_with_sort_group($this->dbTable,'',$where_arr,'',$sort_order);
		//echo $this->db->last_query();exit;
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
                  <td><?php echo $row['title'];?></td>
                  <td><?php echo $status;?></td>
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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
		$permission = $this->permission->grant(NEWS_LATTER,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/news_latter/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(NEWS_LATTER,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// faq_name is already exists //
	    $title = trim($this->input->post('title'));
	    $sub_title = trim($this->input->post('sub_title'));
	    $email = trim($this->input->post('email'));
	    $description = trim($this->input->post('description'));
	    // $ordering_list = trim($this->input->post('ordering_list'));
	    // $slug = trim($this->input->post('slug'));

	    $record = $this->db->where('title',$title)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'News Latter is already exists.';
	        echo json_encode($response);exit;
	    }
	    //
		$data = array(
	        //'user_id' => $user_id,
            'title' => $title,
            'sub_title' => $sub_title,
            'email' => $email,
            'description' => $description,
            // 'ordering_list' => $ordering_list,
            // 'slug' => $slug,
            'status' => $this->input->post('status'),
            //'permission' => json_encode($this->input->post('modules'))
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'News Latter is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(NEWS_LATTER,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'News Latter is deleted successfully.';
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
	    $permission = $this->permission->grant(NEWS_LATTER,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(NEWS_LATTER,'edit');
	    $delete_permission = $this->permission->grant(NEWS_LATTER,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
		//print_r($data);
	    $this->load->view('backend/news_latter/getEdit',['data'=>$data]);
	}
	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(NEWS_LATTER,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		//$id=$this->input->post('user_id');
		// Role is already exists //
		$id = $_POST['id'];
	    $title = trim($this->input->post('title'));
	    $sub_title = trim($this->input->post('sub_title'));
	    $email = trim($this->input->post('email'));
	    $description = trim($this->input->post('description'));
	    //$slug = trim($this->input->post('slug'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['title'] == $title){
	        		$response['success'] = 0;
	        		$response['message'] = 'News Latter is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
                'title' => $this->input->post('title'),
                'sub_title' => $this->input->post('sub_title'),
                'email' => $this->input->post('email'),
                'description' => $this->input->post('description'),
                //'slug' => $slug,
        		'status' => $this->input->post('status')
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'News Latter is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function ordering()
	{
		$position = $_POST['position'];
	    $i=1;
	    // Update Orting Data 
	    foreach($position as $k=>$v){
	    	$data['ordering'] = $i;
	    	$where_array = array('id' => $v);
			$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
	        $i++;
    	}
	}

}

