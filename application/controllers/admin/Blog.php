<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang_helper = langArr();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'blog_post';
		$this->blog_comments = 'blog_comments';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(BLOG,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(BLOG,'edit');
		$delete_permission = $this->permission->grant(BLOG,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$sort_order = 'ordering asc';
		$data = $this->common_model->get_records_with_sort_group($this->dbTable,'',$where_arr,'',$sort_order);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><center>#</center></th>
                  <th><center>Blog Title</center></th>
                  <th><center>Status</center></th>
                  <th><center>Action</center></th>
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
                  <td><center><?php echo $i++;?></center></td>
                  <td><center><?php echo $row['blog_title_en'];?></center></td>
                  <td><center><?php echo $status;?></center></td>
                  
                  <td><center>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<!-- <?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php } ?> -->

                    <a href="<?php echo base_url();?>admin/blog/comments/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_comments"><i class="fas fa-comment" aria-hidden="true"></i></a></center>
                    
                	
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
		$permission = $this->permission->grant(BLOG,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/blog/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(BLOG,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

			$imagePrefix = time();
			$mainImage = '';
			//$blog_image = $_POST['blog_image'];

			if($_FILES['blog_image']['error'] == 0){
				$config['upload_path'] = 'assets/uploads/blog/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = $imagePrefix.'-'.$_FILES['blog_image']['name'];
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('blog_image'))
				{
					$uploadData = $this->upload->data();
					$mainImage = $uploadData['file_name'];
				}
			}

		// blog is already exists //
		$news_titleArr = $linkArr = array();
	    $blog_title = trim($this->input->post('blog_title'));
	    $ordering = trim($this->input->post('ordering'));
	    $blog_description = trim($this->input->post('blog_description'));
	    $blog_published_date = trim($this->input->post('blog_published_date'));
	    $slug = trim($this->input->post('slug'));
	    $intro_content = trim($this->input->post('intro_content'));
	    $record = $this->db->where('blog_title',$title)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'BLOG is already exists.';
	        echo json_encode($response);exit;
	    }
	    $blog_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $blog_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $blog_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $blog_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    //
		$data = array(
			'blog_title' => serialize($blog_titleArr),
            'blog_title_en' => $blog_title_en,
			'blog_description' => serialize($descArr),
            'ordering' => $ordering,
            'blog_image' => $mainImage,
            'blog_published_date' => $blog_published_date,
            'slug' => $slug,
            'intro_content' => $intro_content,
            'status' => $this->input->post('status'),
            //'permission' => json_encode($this->input->post('modules'))
        );
        //print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'BLOG is created successfully.';
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
	    $permission = $this->permission->grant(BLOG,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(BLOG,'edit');
	    $delete_permission = $this->permission->grant(BLOG,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
		//print_r($data);
	    $this->load->view('backend/blog/getEdit',['data'=>$data]);
	}

	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(BLOG,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		$imagePrefix = time();
			$mainImage = '';
			//$blog_image = $_POST['blog_image'];

			if($_FILES['blog_image']['error'] == 0){
				$config['upload_path'] = 'assets/uploads/blog/';
				$config['allowed_types'] = 'jpg|jpeg|png';
				$config['file_name'] = $imagePrefix.'-'.$_FILES['blog_image']['name'];
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('blog_image'))
				{
					$uploadData = $this->upload->data();
					$mainImage = $uploadData['file_name'];
				}
			}

		//$id=$this->input->post('user_id');
		// Role is already exists //
		$id = $_POST['id'];
	    $blog_title = trim($this->input->post('blog_title'));
	    $slug = trim($this->input->post('slug'));
	    $blog_description = trim($this->input->post('blog_description'));
	    $blog_published_date = trim($this->input->post('blog_published_date'));
	    $intro_content = trim($this->input->post('intro_content'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['blog_title'] == $blog_title){
	        		$response['success'] = 0;
	        		$response['message'] = 'BLOG is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $blog_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $blog_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $blog_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $blog_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    $data = array(
            //'blog_title' => $blog_title,
	    	'blog_title' => serialize($blog_titleArr),
            'blog_title_en' => $blog_title_en,
            'blog_description' => serialize($descArr),
            'blog_published_date' => $blog_published_date,
            'slug' => $slug,
            'intro_content' => $intro_content,
        	'status' => $this->input->post('status')
           
        );
        if($mainImage){
        	$data['blog_image'] = $mainImage;
        }
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'BLOG is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function multidel() {
        $ids = $this->input->post('records_to_del');
        if (!empty($ids)) {
            foreach ($ids as $val) {
                $title = $this->common_model->select_data_by_condition('events', 'banner_image', array('id' => $val));
                if (!empty($title)) {
                    foreach ($title as $val) {
                        if (!empty($val['banner_image'])) {
                            $imgArr = unserialize($val['banner_image']);
                            foreach ($this->lang_helper as $key => $lval) {
                                if (isset($imgArr[$key]) && !empty($imgArr[$key]['image'])) {
                                    if (file_exists($imgArr[$key]['image'])) {
                                        unlink($imgArr[$key]['image']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->db->where_in('id', $this->input->post('records_to_del'));
        $this->db->delete('events');
        $this->session->set_flashdata('success', 'Category has been deleted successfully!');
        exit();
    }

    public function DeleteImage() {
        $img_lng = $this->input->post('img_lng');
        $id = $this->input->post('id');
        $title = $this->common_model->select_data_by_condition('events', 'banner_image', array('id' => $id));
        if (!empty($title)) {
            foreach ($title as $val) {
                if (!empty($val['banner_image'])) {
                    $imgArr = unserialize($val['banner_image']);
                    if (isset($imgArr[$img_lng]) && !empty($imgArr[$img_lng]['image'])) {
                        if (file_exists($imgArr[$img_lng]['image'])) {
                           $thumb_image_path = str_replace("title","title/thumb",$imgArr[$img_lng]['image']);                                              
                            unlink($imgArr[$img_lng]['image']);   
                            $thumb_image_path_del = './'.$thumb_image_path;
                            if (file_exists($imgArr[$img_lng]['image'])) {
                                 @unlink($thumb_image_path_del);
                            } 
                        }
                        $imgArr[$img_lng]['image'] = '';
                        $newImgArr = serialize($imgArr);
                        $this->common_model->update_data('events', array('banner_image' => $newImgArr), array('id' => $id));
                    }
                }
            }
            return true;
        }
        return false;
    }


	public function comments($id)
	{
		$blog_id = base64_decode($id);
	    $user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(BLOG,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		//$data['record'] = $this->db->where('status !=',2)->where('blog_id =',$blog_id)->get($this->blog_comments)->result_array();
	    //$record = $this->db->query('Select * from blog_comments where blog_id = '.$blog_id)->result_array();
	    $where_arr = array('id' => $blog_id); 
		$data['blog'] = $this->common_model->get_records($this->dbTable,'',$where_arr,true);
		//echo $this->db->last_query();
		//print_r($data);exit();
		$data['main_page'] = 'backend/blog/blog_comments_list';
		$this->load->view('layout/template',$data);
	}
	public function blog_comments()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(BLOG,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(BLOG,'edit');
		$delete_permission = $this->permission->grant(BLOG,'delete');
		$data = array();
		$blog_id=$_POST['blog_id'];
		$where_arr = array('status!=' => 2,'blog_id'=>$blog_id); 
		$sort_order = 'id desc';
		$data = $this->common_model->get_records_with_sort_group($this->blog_comments,'',$where_arr,'',$sort_order);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Comment</th>
                  <th>Status</th>
                  
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
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['email'];?></td>
                  <td><?php echo $row['comments'];?></td>
                  <td><?php echo $status;?></td>
                </tr>
              <?php }} ?>
                </tbody>  
              </table>
        <?php
	}
	public function delete()
	{
		$permission = $this->permission->grant(BLOG,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'BLOG is deleted successfully.';
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
	    	$data['ordering_list'] = $i;
	    	$where_array = array('id' => $v);
			$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
	        $i++;
    	}
	}
}
