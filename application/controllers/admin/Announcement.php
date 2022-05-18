<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang_helper = langArr();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'announcement_master';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ANNOUNCEMENT,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(ANNOUNCEMENT,'edit');
		$delete_permission = $this->permission->grant(ANNOUNCEMENT,'delete');
		$data = array();
		$where_arr = array('status!=' => 2); 
		$sort_order = 'ordering asc';
		$data = $this->common_model->get_records_with_sort_group($this->dbTable,'',$where_arr,'',$sort_order);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Announcement Title</th>
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
                  <td><?php echo $row['announcement_title_en'];?></td>
                  <td><?php echo $status;?></td>
                  
                  <td>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="<?php echo base_url();?>admin/announcement/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<?php if($delete_permission == true){ ?>
                    <!-- <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?>
                	<?php } ?> -->
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
		$permission = $this->permission->grant(ANNOUNCEMENT,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/announcement/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(ANNOUNCEMENT,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			$imagePrefix = time();
			$mainImage = '';
			//$announcement_image = $_POST['announcement_image'];

			//image
			if($_FILES['image_document']['error'] == 0){
				// $config['upload_path'] = 'assets/uploads/announcement/';
				// $config['allowed_types'] = 'jpg|jpeg|png';
				// $config['file_name'] = $imagePrefix.'-'.$_FILES['image_document']['name'];
				// $this->load->library('upload',$config);
				// $this->upload->initialize($config);
				// if($this->upload->do_upload('image_document'))
				// {
				// 	$uploadData = $this->upload->data();
				// 	$mainImage = $uploadData['file_name'];
				// }

				$path = 'assets/uploads/announcement/';
				$file_name = $_FILES['image_document']['name'];
				$file_size =$_FILES['image_document']['size'];
				$file_tmp =$_FILES['image_document']['tmp_name'];
				$file_type=$_FILES['image_document']['type'];
				$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
				$webp_image = basename($file_name, ".".$file_ext).'.webp';
				// an option to specify img extensions you may add as you like
				$extensions= array("jpeg","jpg","png");

				if(in_array($file_ext,$extensions)=== false){
				 	$error ="Extension not allowed, please choose a JPEG or PNG file.";
				 	$response['success'] = 0;
	        		$response['message'] = $error;
	        		echo json_encode($response);exit;
				}
				if(move_uploaded_file($file_tmp,$path.$webp_image)){
					$mainImage = $webp_image;
				}
			}



			//document
			if($_FILES['document']['error'] == 0){
				$config['upload_path'] = 'assets/uploads/announcement/';
				$config['allowed_types'] = 'jpg|jpeg|png|pdf';
				$config['file_name'] = $imagePrefix.'-'.$_FILES['document']['name'];
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('document'))
				{
					$uploadData = $this->upload->data();
					$document = $uploadData['file_name'];
				}
			}

			//video
			if($_FILES['video_document']['error'] == 0){
				$config['upload_path'] = 'assets/uploads/announcement/';
				$config['allowed_types'] = 'mp4';
				$config['upload_max_size'] = '10mb';
				$config['file_name'] = $imagePrefix.'-'.$_FILES['video_document']['name'];
				$this->load->library('upload',$config);
				$this->upload->initialize($config);

				if($this->upload->do_upload('video_document'))
				{
					$uploadData = $this->upload->data();
					$video = $uploadData['file_name'];
				}
			}

		// Announcement is already exists //
	   	$announcement_title = trim($this->input->post('announcement_title'));
	    $slug = trim($this->input->post('slug'));
	    $url = trim($this->input->post('url'));
	    $announcement_date = trim($this->input->post('announcement_date'));
	    $announcement_time = trim($this->input->post('announcement_time'));
	    $intro_content = trim($this->input->post('intro_content'));
	    $choice = json_encode($this->input->post('choice'));
	    $ordering = trim($this->input->post('ordering'));
	    $announcement_description = trim($this->input->post('announcement_description'));
	   
	    $record = $this->db->where('announcement_title',$announcement_title)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'Announcement is already exists.';
	        echo json_encode($response);exit;
	    }
     	$announcement_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $announcement_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $announcement_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $announcement_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    //
		$data = array(
	        //'user_id' => $user_id,
	        'announcement_title' => serialize($announcement_titleArr),
            'announcement_title_en' => $announcement_title_en,
            'slug' => $slug,
            'url' => $url,
            'image_document' => $mainImage,
            'document' => $document,
            'video_document' => $video,
            'announcement_date' => $announcement_date,
            'announcement_time' => $announcement_time,
            'intro_content' => $intro_content,
            'ordering' => $ordering,
       		'choice' => $choice,
            'announcement_description' => serialize($descArr),

            'status' => $this->input->post('status'),
            //'permission' => json_encode($this->input->post('modules'))
        );
        //print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','Announcement is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        redirect('admin/Announcement');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/announcement/add';
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
		$permission = $this->permission->grant(ANNOUNCEMENT,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// $where_arr = array('status' => 1);
		// $data['member_type'] = $this->common_model->get_records($this->member_type,'',$where_arr);
		if(isset($_POST['submit'])){
	    //$announcement_title = trim($this->input->post('announcement_title'));
	    $announcement_titleArr = $linkArr = array();
	    $slug = trim($this->input->post('slug'));
	    $url = trim($this->input->post('url'));
	    $image_document = trim($this->input->post('image_document'));
	    $document = trim($this->input->post('document'));
	    $video_document = trim($this->input->post('video_document'));
	    $announcement_date = trim($this->input->post('announcement_date'));
	    $announcement_time = trim($this->input->post('announcement_time'));
	    $intro_content = trim($this->input->post('intro_content'));
	    $choice = json_encode($this->input->post('choice'));
	    $ordering = trim($this->input->post('ordering'));
	    $announcement_description = trim($this->input->post('announcement_description'));
	    $status = trim($this->input->post('status'));
	    
	    $announcement_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $announcement_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $announcement_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $announcement_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    $data = array(
            //'announcement_title' => $announcement_title,

             'announcement_title' => serialize($announcement_titleArr),
            'announcement_title_en' => $announcement_title_en,

            'slug' => $slug,
            'url' => $url,
            'image_document' => $image_document,
            'document' => $document,
            'video_document' => $video_document,
            'announcement_date' => $announcement_date,
            'announcement_time' => $announcement_time,
            'intro_content' => $intro_content,
            'choice' => $choice,
            'ordering' => $ordering,
            'announcement_description' => serialize($descArr),
            'status' => $status,
            
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        //print_r($update);die;
        if($update){
        	 $this->session->set_flashdata('success','Announcement is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Announcement');
    }else{
    	$where_array = array('id' => $id);
    	$data['announcement'] = $this->common_model->get_records('announcement_master','',$where_array,true);
    	//print_r($data['announcement']);die;
    	$data['main_page'] = 'backend/announcement/add';
		$this->load->view('layout/template',$data);
      }
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

	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(ANNOUNCEMENT,'edit');
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
	        		$response['message'] = 'Blog is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $data = array(
            'blog_title' => $blog_title,
            'blog_description' => $blog_description,
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
        	$response['message'] = 'Announcement is updated successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(ANNOUNCEMENT,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'ANNOUNCEMENT is deleted successfully.';
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
