<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Qr_code extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$Sess_ID = $this->session->userdata('id');
		if (!isset($Sess_ID) || $Sess_ID == false)
		{
			redirect(base_url('admin/login'),'refresh');
		}
		$this->dbTable = 'distribute_label';
		$this->dbTable2 = 'qr_data';
		$this->QRfileName = '';
		// include APPPATH . '/assets/phpqrcode/qrlib.php';
	}
	public function data()
	{
		$user_id=$_SESSION['user_id'];
		if(!isset($_SESSION['user_id'])){
			redirect('admin/login');
		}
		/*$permission = $this->permission->grant(QR_CODE,'view');
		if($permission == false){
			redirect('admin/dashboard');
		}
		$edit_permission = $this->permission->grant(QR_CODE,'edit');
		$delete_permission = $this->permission->grant(QR_CODE,'delete');
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
		
		$data = $this->common_model->get_records($this->dbTable,'',$filter_array);*/

		$permission = $this->permission->grant(QR_CODE,'view');
		// 'user_list' => $_GET['quantity']
		//$where_array = array('label_series' => $_POST['series_id']);
		$data = $this->common_model->get_records($this->dbTable2,'');
		
	?>
		<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
	                  <th>#</th>
	                  <th>Serial Number</th>
	                  <th>img</th>
	                  <th>Label Seires</th>
	                  <th>User List</th>
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
			                  <td><?= $i++; ?></td>
			                  <td><?= $row['serial_number'] ?></td>
			                  <td><?= $row['qr_code'] ?></td>
			                  <td><?= $row['label_series'] ?></td>
			                  <td><?= $row['user_list'] ?></td>
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
		$permission = $this->permission->grant(QR_CODE,'view');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		$data = array();
		$data['main_page'] = 'backend/qr_code/list';
		$this->load->view('layout/template',$data);
	}

	public function add()
	{
		$user_id=$_SESSION['user_id'];

		if(!isset($user_id))
		{
			redirect('admin/login');
		}
		
		$permission = $this->permission->grant(QR_CODE,'add');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit']))
		{
			function generateRandomNumber($digit){
		        return substr(str_shuffle(str_repeat($x='0123456789',$digit)),0,$digit);
			}
		    $serial_number = trim(generateRandomNumber(16));
		    $qr_code = trim('path comes here');
		    $label_series = trim($this->input->post('series_id'));
		    $user_list = trim($this->input->post('user_list'));
	 
				$data = array(
            'serial_number' => $serial_number,
            'qr_code' => $this->QRfileName,
            'label_series' => $label_series,
            'user_list' => $user_list,
           
        );
        $insert = $this->common_model->add_records($this->dbTable2,$data);
        $response = array();
        if($insert){
        	$this->session->set_flashdata('success','QR is created successfully.');
        }else{
        	$this->session->set_flashdata('error','Something went wrong.');
        }
        // redirect('admin/Label');
      }else{
        $data = array();
      	$data['main_page'] = 'backend/qr_code/add';
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
		$permission = $this->permission->grant(QR_CODE,'edit');
		if($permission == false)
		{
			redirect('admin/dashboard');
		}
		if(isset($_POST['submit'])){
	    $series_id = trim($this->input->post('series_id'));
	    $quantity = trim($this->input->post('quantity'));
	    

	    $data = array(
            'series_id' => $series_id,
            'quantity' => $quantity,
            
      );
        $where_array = array('id' => $id);
				$update = $this->common_model->update_records($this->dbTable,$data,$where_array);
        
        if($update){
        	 $this->session->set_flashdata('success','Label is updated successfully.');
      	}else{
        	$this->session->set_flashdata('error','Something went wrong.');
      	}
      redirect('admin/Label');
    }else{
    	$where_array = array('id' => $id);
    	$data['label'] = $this->common_model->get_records('label','',$where_array,true);
    	
    	$data['main_page'] = 'backend/qr_code/add';
			$this->load->view('layout/template',$data);
      }
  }

  public function delete()
  {
    $permission = $this->permission->grant(QR_CODE,'delete');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode("/", $url);
    $id= end($parts); 
        
    $data['status'] = 2;
    $where_array = array('id' => $id);
		$delete = $this->common_model->update_records($this->dbTable,$data,$where_array);
    if($delete){
      $response['success'] = 1;
      $response['message'] = 'Label is deleted successfully.';
    }else{
      $response['success'] = 0;
      $response['message'] = 'Something went wrong.';
    }
    echo json_encode($response);
  }

  public function generateQR($text)
  {
  	//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = FCPATH.'assets/temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = base_url().'assets/temp/';

    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);

    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'H';

    $matrixPointSize = 6;
  	// echo base_url().'assets/phpqrcode/qrlib.php';
  	// die;
  	include APPPATH . 'libraries/phpqrcode/qrlib.php';
  	// $this->load->view('backend/qr_code/phpqrcode/qrlib.php');
  
	// $text="Om";
	// Generates QR Code and Stores it in directory given
	//QRimage::png($text);
	$filename = $PNG_TEMP_DIR.'test'.md5($text.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($text, $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
  	echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
  	// echo basename($filename);
  	$this->QRfileName = basename($filename);
  	$this->add();
// Displaying the stored QR code from directory
  }

  public function getDataWithQR()
  {
  	// var_dump($_POST);
	$permission = $this->permission->grant(QR_CODE,'view');
	// 'user_list' => $_POST['quantity']
	$where_array = array('label_series' => $_POST['series_id']);
	$data = $this->common_model->get_records($this->dbTable,'',$where_array);
	// print_r($data);
	
	$html = '<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
	                  <th>#</th>
	                  <th>Label</th>
	                  <th>Qty</th>
	                  <th>Required Qty</th>
	                  <th>Date & Time</th>
                </tr>
                </thead>
                <tbody>';
                            
		      if(isset($data) && !empty($data)) {
		            	$i = 1;
		                    foreach ($data as $row) { 
		                    	if ($row["user_list"] == $_POST['quantity']) {
				                 $html .= '<tr>
					                  <td>'.$i++.'</td>
					                  <td>'.$row['label_series'].'</td>
					                  <td>'.$row['qty'].'</td>
					                  <td>'.$row['req_label'].'</td>
					                  <td>'.$row['created_at'].'</td>
				                  </tr>';
		                  }else if ($row['chapter_user_list'] == $_POST['quantity']) {
				                $html .= '<tr>
					                  <td>'.$i++.'</td>
					                  <td>'.$row['label_series'].'</td>
					                  <td>'.$row['qty'].'</td>
					                  <td>'.$row['req_label'].'</td>
					                  <td>'.$row['created_at'].'</td>
				                  </tr>';

		                    	}
		               }
		            }
	      
	        $html .='</tbody>
	    </table>';
	$this->generateQR($html);
   }
}
