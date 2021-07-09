<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminHome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['url','captcha']);
		$this->load->library(['session', 'form_validation']);
		$this->load->database();
		$this->load->model("AdminHomeModel");
		$this->load->model("RegistrationModel");
	}
	public function index()
	{
		$userDetails=$this->RegistrationModel->getUserDetails($this->session->userdata('user_id'));
		$allUserDetails=$this->RegistrationModel->getUserDetails(null);		
		$data=array('userDetails'=>$userDetails[0],'allUserDetails'=>$allUserDetails);
		$this->load->view('admin_home',$data);
	}
	public function edituser($userId){
		$userDetails=$this->RegistrationModel->getUserDetails($this->session->userdata('user_id'));
		$userDetailsForEdit=$this->RegistrationModel->getUserDetails($userId);
		$countries=$this->RegistrationModel->getCountries();
		$subscriptions=$this->RegistrationModel->getSubscriptions();
		$data=array('userDetails'=>$userDetails[0],'userDetailsForEdit'=>$userDetailsForEdit[0],'countries'=>$countries,'subscriptions'=>$subscriptions);
		$this->load->view('edit_user',$data);
	}
	public function deleteUser($userId){
		if($this->RegistrationModel->deleteUser($userId)){
			$this->session->set_flashdata('updation_success_msg', 'Deletion Successfull !');
		}else{
			$this->session->set_flashdata('updation_failure_msg', 'Deletion Failed !');
		}
		redirect('adminhome');
	}
	
}
