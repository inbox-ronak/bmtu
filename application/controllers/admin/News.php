<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->lang_helper = langArr();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'news_master';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		$permission = $this->permission->grant(NEWS,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(NEWS,'edit');
		$delete_permission = $this->permission->grant(NEWS,'delete');
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
                  <th>News Title Name</th>
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
                  <td><?php echo $row['news_title_name_en'];?></td>
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
		$permission = $this->permission->grant(NEWS,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/news/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(NEWS,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		// faq_name is already exists //
		$news_titleArr = $linkArr = array();
	    $tag = trim($this->input->post('tag'));
	    $slug = trim($this->input->post('slug'));
	    $news_title_name = trim($this->input->post('news_title_name'));
	    $catagory = trim($this->input->post('catagory'));
	    $ordering = trim($this->input->post('ordering'));
	    $news_description = trim($this->input->post('news_description'));
	    $status = trim($this->input->post('status'));
	    $record = $this->db->where('news_title_name',$news_title_name)->where('status !=',2)->get($this->dbTable)->row_array();
	    if($record){
	        $response['success'] = 0;
	        $response['message'] = 'NEWS is already exists.';
	        echo json_encode($response);exit;
	    }
	    $news_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $news_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $news_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $news_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    //
		$data = array(
			'news_title_name' => serialize($news_titleArr),
            'news_title_name_en' => $news_title_en,
			'news_description' => serialize($descArr),
            'tag' => $tag,
            'slug' => $slug,
            'catagory' => $catagory,
            'ordering' => $orderingordering,
            'status' => $status,
            
            //'permission' => json_encode($this->input->post('modules'))
        );
        // print_r($data);die;
        $insert = $this->common_model->add_records($this->dbTable,$data);
        $response = array();
        if($insert){
        	$response['success'] = 1;
        	$response['message'] = 'NEWS is created successfully.';
        }else{
        	$response['success'] = 0;
        	$response['message'] = 'Something went wrong.';
        }
        echo json_encode($response);
	}

	public function update()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id']))
		{
			redirect('admin/login');
		}
		$permission = $this->permission->grant(NEWS,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}

		//$id=$this->input->post('user_id');
		// Role is already exists //
		$id = $_POST['id'];
	    
		$news_titleArr = $linkArr = array();
	    $tag = trim($this->input->post('tag'));
	    $slug = trim($this->input->post('slug'));
	    //$news_title_name = trim($this->input->post('news_title_name'));
	    $catagory = trim($this->input->post('catagory'));
	    //$news_description = trim($this->input->post('news_description'));
	    $status = trim($this->input->post('status'));


	    $record = $this->db->where('status !=',2)->where('id !=',$id)->get($this->dbTable)->result_array();
	    if($record){
	    	foreach ($record as $value){
	    		if($value['news_title_name'] == $news_title_name){
	        		$response['success'] = 0;
	        		$response['message'] = 'News is already exists.';
	        		echo json_encode($response);exit;
	        	}
	        }
	    }
	    //
	    $news_titleArr = $linkArr = array();
        $descArr = array();
        $title_fr = $news_title_en = '';
        foreach ($this->lang_helper as $key => $val) {
            $news_titleArr[$key] = $this->input->post('title_' . $key);
            if($key == 'en')  {
                $news_title_en = trim($this->input->post('title_' . $key));
            }                        
            $descArr[$key] = base64_encode($this->input->post('desc_' . $key));

        }
	    $data = array(
	    	'news_title_name' => serialize($news_titleArr),
            'news_title_name_en' => $news_title_en,
            'news_description' => serialize($descArr),
            'tag' => $this->input->post('tag'),
            'slug' => $this->input->post('slug'),
            'catagory' => $this->input->post('catagory'),
        	'status' => $this->input->post('status')
           
        );
        //echo '<pre>';print_r($data);exit;
        $where_array = array('id' => $id);
		$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        $response = array();
        if($update){
        	$response['success'] = 1;
        	$response['message'] = 'News is updated successfully.';
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
	    $permission = $this->permission->grant(NEWS,'edit');
	    if($permission == false)
	    {
	      redirect('admin/dashboard');
	    }
	    $edit_permission = $this->permission->grant(NEWS,'edit');
	    $delete_permission = $this->permission->grant(NEWS,'delete');
	    $where_arr = array('id' => $id); 
		$data = $this->common_model->get_records_object($this->dbTable,'',$where_arr,true);
		//print_r($data);
	    $this->load->view('backend/news/getEdit',['data'=>$data]);
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


	public function delete()
	{
		$permission = $this->permission->grant(NEWS,'delete');

		$url = $_SERVER['REQUEST_URI'];
	    $parts = explode("/", $url);
        $id= end($parts); 
        $data['status'] = 2;
		$where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
      	if($delete){
        	$response['success'] = 1;
        	$response['message'] = 'News is deleted successfully.';
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
