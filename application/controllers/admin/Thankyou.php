<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Thankyou extends CI_Controller {

	function __construct() {
	    parent::__construct();
      $this->dbTable = 'user_master';
	}

	public function index()
	{
    echo 'thankyou';exit;
		$data = array();
    $data['main_page'] = 'backend/users/list';
    $this->load->view('layout/template',$data);
	}
}