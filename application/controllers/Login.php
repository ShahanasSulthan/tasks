<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['url','captcha']);
		$this->load->library(['session', 'form_validation']);
		$this->load->database();
		$this->load->model("LoginModel");
	}
	public function index()
	{
		$config = array(
            'img_url' => base_url() . 'captcha_images/',
            'img_path' => 'captcha_images/',
            'img_height' => 45,
            'word_length' => 5,
            'img_width' => '150',
            'font_size' => 14
        );
        $captcha = create_captcha($config);
        $this->session->unset_userdata('captcha_value');
        $this->session->set_userdata('captcha_value', $captcha['word']);
		$data=array('captchaImg'=>$captcha['image']);
		$this->load->view('login',$data);
	}
	public function login(){		
		$this->load->helper('email');
		$this->form_validation->set_rules('user_email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('user_password','Password','trim|required|min_length[8]');
		$this->form_validation->set_rules('captcha','Captcha','trim|required|callback_captcha_validation');
		if($this->form_validation->run() == false){		
			$this->index();
		}else{
			$userDetails=$this->LoginModel->checkLogin($this->input->post('user_email'));
			if (sizeof($userDetails) == 1 && password_verify($this->input->post('user_password'), $userDetails[0]['user_password'])) {
				$this->session->set_userdata('user_id', $userDetails[0]['user_id']);
				$this->session->set_userdata('user_role', $userDetails[0]['user_role']);
				if( $userDetails[0]['user_role']==1){
					redirect('adminhome');
				}else{
					redirect('userhome');
				}			
			} else {
				$this->session->set_flashdata('login_failure_msg', 'Invalid email / password');
				redirect('Login');
			}
		}


	}
	public function captcha_validation(){
		if ($this->input->post('captcha') != $this->session->userdata('captcha_value')) {
			$this->form_validation->set_message('captcha_validation', 'Invalid captcha');
			return false;
		} else {
			return true;
		}
	}
	public function logout(){
		$this->session->sess_destroy();
		redirect('Login');
	}
}
