<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {

		parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('home_model');
	}

	public function index()
	{
		if (isset($_SESSION['user_logged_in'])){
			redirect(base_url().'admin/dashboard');
		}else{
			$this->load->view('login/login');
		}
	}

	public function Auth() 
	{

		$checkLogin = $this->Login_model->auth_login();

		if ($checkLogin == 1 && $this->session->userdata('status')==1) {
			$this->session->set_flashdata('success', 'Welcome to Dashboard.');
           	// If Email & password match
			redirect(base_url().'admin/dashboard');

		} elseif($checkLogin == 1 && $this->session->userdata('status')==0) {
           	// If Status = 2 Inactive		
			$data['error']= 'You dont have permission access this account.';
			//$this->load->view('login/login',$data);

		}elseif($checkLogin == 1 && $this->session->userdata('status')==2) {
            // If Status = 2 Deleted        
			$data['error']= 'Your account suspended.';
			//$this->load->view('login/login',$data);

		}else{
            // If Email & password wrong
			$data['error'] = 'Invalid email or password.';
			//$this->load->view('login/login',$data);
		}
		$this->session->set_flashdata('error', $data['error']);
		redirect(base_url('admin/login'),'refresh');
	}

	public function Logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('admin/login'),'refresh');
	}

	public function Profile()
	{
		if(isset($_POST['btn-submit'])){
			//echo '<pre>';print_r($_FILES);exit;
			$first_name= $_POST['first_name'];
			$last_name= $_POST['last_name'];
			$email= $_POST['email'];
			$mobile_no = $_POST['mobile_no'];
			$address=$_POST['address'];
			$password = trim($_POST['password']);
			
			$this->db->where('id !=',$_POST['id']);
			$this->db->where('status !=',2);
			//$this->db->where('trash',0);
			$sql= $this->db->get('user_master');
			$result_uniq =$sql->result_array();

			if($result_uniq){
				foreach($result_uniq as $row)
				{
					if($row['email'] == $email){
						$this->session->set_flashdata("error", "Email Id already exists..");
						redirect($_SERVER['HTTP_REFERER']);exit;
					 }
				}
			}
			
			$data['first_name'] = $first_name;
			$data['last_name'] = $last_name;
			$data['mobile_no'] = $mobile_no;
			$data['email'] = $email;
			$data['address'] = $address;
			if($password){
				$data['password'] = md5($password);
			}

			// start of profile image //
			$statusMsg = '';
			// File upload path
			$targetDir = "assets/uploads/users/";
			$fileName = basename($_FILES["profile_image"]["name"]);
			$targetFilePath = $targetDir . $fileName;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

			if(!empty($_FILES["profile_image"]["name"])){
			    // Allow certain file formats
			    $allowTypes = array('jpg','png','jpeg');
			    if(in_array($fileType, $allowTypes)){
			        // Upload file to server
			        if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)){
			             $data['profile_image'] = $fileName;
			        }else{
			            $statusMsg = "Sorry, there was an error uploading your file.";
			        }
			    }else{
			        $statusMsg = 'Sorry, only JPG, JPEG & PNG files are allowed to upload.';
			    }
			}
			// end of profile image //
				
			$this->db->where('id', $_POST['id']);
			//print_r($data);die();
			$update = $this->db->update('user_master', $data);
			if($update){
				$this->session->set_flashdata("success", "Profile is successfully updated.".$statusMsg);
				
			}else{
				$this->session->set_flashdata("error", "Something went wrong.");
			}
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			
			if(isset($_SESSION['id'])){
				$id = $_SESSION['id'];
				$table = 'user_master';
				$data['user'] = $this->home_model->getuser($id);
				if($data['user']){
					$data['main_page'] = 'user/profile';
					$this->load->view('layout/template',$data);
					//$this->load->view('user/profile',$data);	
				}else{
					redirect('admin/dashboard');
				}
			}
		}
	}
}
