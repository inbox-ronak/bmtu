<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang_helper = langArr();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'faq_master';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(FAQ,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(FAQ,'edit');
		$delete_permission = $this->permission->grant(FAQ,'delete');
		$data = array();
		$where_arr = array('status!=' => 2);
		$sort_order = 'ordering asc';
		$data = $this->common_model->get_records_with_sort_group($this->dbTable,'',$where_arr,'',$sort_order);
		//echo $this->db->last_query();exit;
		//echo json_encode($data);
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><center>#</center></th>
                  <th><center>Title</center></th>
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
                  <td><center><?php echo $row['title_en'];?></center></td>
                  <td><center><?php echo $status;?></center></td>
                  <td><center>
                  	<?php if($edit_permission == true){ ?>
                  	<a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-info btn-sm item_edit"><i class="fa fa-edit"></i></a>
                  	<?php } ?>
                  	<?php //if($row['id'] > 3){ ?>
                  	<!-- <?php if($delete_permission == true){ ?>
                    <a href="javascript:void(0);" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn-sm item_delete"><i class="fa fa-trash-alt"></i></a>
                    <?php //} ?> -->
                	<?php } ?></center>
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
		$permission = $this->permission->grant(FAQ,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/faq/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(FAQ,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// faq_name is already exists //
	    $title = trim($this->input->post('title'));
	    $description = trim($this->input->post('description'));
	    $ordering = trim($this->input->post('ordering'));
	    $slug = trim($this->input->post('slug'));

	    $record = $this->db->where('title',$title)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'FAQ is already exists.';
	        echo json_encode($response);exit;
	    }
	    $titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }

	    //
		$data = array(
	        //'user_id' => $user_id,
            //'title' => $title,
            'title' => serialize($titleArr),
			'title_en' => $title_en,

            //'description' => $description,
            'description' => serialize($descArr),
            'ordering' => $ordering,
            'slug' => $slug,
            'status' => $this->input->post('status'),
            //'permission' => json_encode($this->input->post('modules'))
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'FAQ is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function delete()
	{
		$permission = $this->permission->grant(FAQ,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'FAQ is deleted successfully.';
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
	    $permission = $this->permission->grant(FAQ,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(FAQ,'edit');
	    $delete_permission = $this->permission->grant(FAQ,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
		//print_r($data);
	    $this->load->view('backend/faq/getEdit',['data'=>$data]);
	}
	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(FAQ,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		//$id=$this->input->post('user_id');
		// Role is already exists //
		$id = $_POST['id'];
	    // $title = trim($this->input->post('title'));
	    // $description = trim($this->input->post('description'));
	    $slug = trim($this->input->post('slug'));
	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['title'] == $title){
	        		$response['success'] = 0;
	        		$response['message'] = 'FAQ is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //

	    $faq_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $faq_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $faq_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $faq_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }

	    $data = array(
                'title' => serialize($faq_titleArr),
            	'title_en' => $faq_title_en,
            	'description' => serialize($descArr),
                'slug' => $slug,
        		'status' => $this->input->post('status')
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'FAQ is updated successfully.';
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

