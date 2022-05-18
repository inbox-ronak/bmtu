<?php
class Login_model extends CI_Model
{
	function auth_login() {
        $email = $this->input->post('email');
        $first_name = $this->input->post('first_name');
        $password = md5($this->input->post('password'));
        $query = $this->db->get_where('user_master', array('status'=> 1, 'email' => $email, 'password' => $password));
        $admin = $query->row();
        if ($query->num_rows() > 0) {
            $admin = $query->row();
            $sessiondata = array(
                'id' => $admin->id,
                'username' => $admin->email,
                'first_name' =>$admin->first_name,
                'profile_image' =>$admin->profile_image,
                'status' => $admin->status,
                'user_id'=>$admin->id,
                'user_role'=>$admin->role_id,
                'user_logged_in' => 1
            );
            $userdata =$this->session->set_userdata($sessiondata);
            return 1;
        } else {
            return 0;
        }
    }
}
