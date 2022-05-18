<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

	function __construct() {
	    parent::__construct();
	    $this->dbTable = 'gallery_master';
	}
	
	public function index()
	{
		$user_id=$_SESSION['user_id'];  

		if(!isset($user_id)) 
		{
			redirect('admin/login');
		}
		//echo 'hello';die;
		$permission = $this->permission->grant(GALLERY,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/gallery/list';
		$this->load->view('layout/template',$data);
	}

	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(GALLERY,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(GALLERY,'edit');
		$delete_permission = $this->permission->grant(GALLERY,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$data = $this->common_model->get_records($this->dbTable,'',$where_arr);
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Image</th>
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
                  	<td><?php
                  		$attached_files = json_decode($row['galleryImage'],true);
                        ?>
                        <?php if(isset($attached_files[0])){ ?>
                        <embed src="<?php echo base_url().'assets/uploads/gallery/'.$attached_files[0];?>" width="105px" height="100px" />
                        <?php } ?>
                    </td>
                  	<td>
                  		<?php if($edit_permission == true){ ?>
                  		<a href="<?php echo base_url();?>admin/gallery/edit/<?php echo base64_encode($row['id']);?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
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

	public function add(){
		$permission = $this->permission->grant(GALLERY,'add');
	    if($permission == false)
	    {
	      redirect('dashboard');
	    }
		if(isset($_POST['btn-submit']))
		{
			$imagePrefix = time();

		    $attached_files = array();
				$attached_filesData = $_FILES['gallery_images'];

			    for($i=0;$i<count($attached_filesData['name']);$i++){
			      if($attached_filesData['name'][$i] != ''){
			          $imagePrefix = time();
			          $config['upload_path'] = 'assets/uploads/gallery/';
			          $config['allowed_types'] = 'jpg|jpeg|png';
			          $config['file_name'] = $imagePrefix.'-'.$attached_filesData['name'][$i];
			          
			          // Define new $_FILES array - $_FILES['file']
			          $_FILES['gallery_images']['name'] = $attached_filesData['name'][$i];
			          $_FILES['gallery_images']['type'] = $attached_filesData['type'][$i];
			          $_FILES['gallery_images']['tmp_name'] = $attached_filesData['tmp_name'][$i];
			          $_FILES['gallery_images']['error'] = $attached_filesData['error'][$i];
			          $_FILES['gallery_images']['size'] = $attached_filesData['size'][$i];

			          //Load upload library and initialize configuration
			          $this->load->library('upload',$config);
			          $this->upload->initialize($config);
			          
			          if($this->upload->do_upload('gallery_images'))
			          {
			              $uploadData = $this->upload->data();
			              $attached_files[] = $uploadData['file_name'];
			          }
			      }
			    }
			$data = array(
				'galleryImage' => json_encode($attached_files),
			);
			//print_r($data);die();
			if ($this->common_model->add_records('gallery_master',$data) )
			{
				$this->session->set_flashdata('success', 'Record inserted successfully!');
				redirect(base_url('admin/Gallery'));
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please try again!');
				redirect(base_url('admin/Gallery'));
			}

		}
		$where_arr = array('status' => 1); 
		$data['record'] = '';
		$data['main_page'] = 'backend/gallery/add';
		$this->load->view('layout/template',$data);
	}

  public function edit($id){
  		$id = base64_decode($id);

			$permission = $this->permission->grant(GALLERY,'edit');
	    if($permission == false)
	    {
	      redirect('dashboard');
	    }
	    $edit_permission = $this->permission->grant(GALLERY,'edit');
	    $delete_permission = $this->permission->grant(GALLERY,'delete');
			//$id = base64_decode($this->uri->segment(4));
			$where_arr = array('id'=>$id);
			$data['record'] = $product = $this->common_model->get_records('gallery_master','',$where_arr);
			if(isset($_POST['btn-submit']))
			{

				$attached_files = array();

    		$attachedFiles = json_decode($product[0]['galleryImage'],true);

    		$remove_images = array();
		    if($attachedFiles){
		      foreach ($attachedFiles as $key => $value) {
		        if(array_key_exists('uploaded_files',$_POST)){
		          if(in_array($key,$_POST['uploaded_files'])){
		            $attached_files[] = $value;
		          }else{
		            $file_url = 'assets/uploads/gallery/'.$value;
		            //unlink($file_url);
		            $remove_images[] = $file_url;
		          }
		        }else{
		          $file_url = 'assets/uploads/gallery/'.$value;
		          //unlink($file_url);
		          $remove_images[] = $file_url;
		        }
		      }
		    }
		   //echo '<pre>';print_r($attached_files);die();
			$imagePrefix = time();
		    
			$attached_filesData = $_FILES['gallery_images'];

		    for($i=0;$i<count($attached_filesData['name']);$i++){
		      if($attached_filesData['name'][$i] != ''){
		          $imagePrefix = time();
		          $config['upload_path'] = 'assets/uploads/gallery/';
		          $config['allowed_types'] = 'jpg|jpeg|png';
		          $config['file_name'] = $imagePrefix.'-'.$attached_filesData['name'][$i];
		          
		          // Define new $_FILES array - $_FILES['file']
		          $_FILES['gallery_images']['name'] = $attached_filesData['name'][$i];
		          $_FILES['gallery_images']['type'] = $attached_filesData['type'][$i];
		          $_FILES['gallery_images']['tmp_name'] = $attached_filesData['tmp_name'][$i];
		          $_FILES['gallery_images']['error'] = $attached_filesData['error'][$i];
		          $_FILES['gallery_images']['size'] = $attached_filesData['size'][$i];

		          //Load upload library and initialize configuration
		          $this->load->library('upload',$config);
		          $this->upload->initialize($config);
		          
		          if($this->upload->do_upload('gallery_images'))
		          {
		              $uploadData = $this->upload->data();
		              $attached_files[] = $uploadData['file_name'];
		          }
		      }
		    }
		  $data2['galleryImage'] = json_encode(array());
			if($attached_files){
      			$attached_files = array_values($attached_files);
      			$data2['galleryImage'] = json_encode($attached_files);
    		}

			$where_array = array('id' => $id);
			if ($this->common_model->update_records('gallery_master',$data2,$where_array) )
			{
				$this->session->set_flashdata('success', 'Record updated successfully!');
				redirect(base_url('admin/gallery'));
			}else{
				$this->session->set_flashdata('error', 'Something went wrong, Please try again!');
				redirect(base_url('admin/gallery'));
			}

		}
		
		$data['main_page'] = 'backend/gallery/add';
		$this->load->view('layout/template',$data);
	}

	public function delete()
	{
		$permission = $this->permission->grant(GALLERY,'delete');

				$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
				$where_array = array('id' => $id);
				$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'Gallery is deleted successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}
}