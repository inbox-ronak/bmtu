<?php 
/* namespace App\Controllers;
use App\Models\CollegeModel;
use CodeIgniter\Controller;
class CollegeController extends Controller */
defined('BASEPATH') OR exit('No direct script access allowed');

class CollegeController extends CI_Controller {
    // show users list
    public function index(){
        // print_r('here');die();
        $collegeModel = new CollegeModel();
        $data['college'] = $collegeModel->orderBy('id', 'DESC')->findAll();
        return view('backend/college/list', $data);
    }
    // add user form
    public function create(){
        return view('college/add_update');
    }
 
    // insert data
    public function store() {
        $collegeModel = new CollegeModel();
        $data = [
            'college_name' => $this->request->getVar('college_name'),
            'status'  => $this->request->getVar('status'),
        ];
        $collegeModel->insert($data);
        return $this->response->redirect(site_url('/college-list'));
    }
    // show single user
    public function edit(){
        $edit_id = $this->request->getVar('edit_id');
        $collegeModel = new CollegeModel();
        $data['college_obj'] = $collegeModel->where('id', $edit_id)->first();
        return view('college/add_update', $data);
    }
    // update user data
    public function update(){
        $collegeModel = new CollegeModel();
        $id = $this->request->getVar('update_id');
        $data = [
            'college_name' => $this->request->getVar('college_name'),
            'status'  => $this->request->getVar('status'),
        ];
        $collegeModel->update($id, $data);
        return $this->response->redirect(site_url('/college-list'));
    }
 
    // delete college
    public function destroy($id = null){
        $collegeModel = new CollegeModel();
        $data['college'] = $collegeModel->where('id', $id)->delete($id);
        return $this->response->redirect(site_url('/college-list'));
    }    
}