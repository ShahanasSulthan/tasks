<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['url','captcha']);
		$this->load->library(['session', 'form_validation']);
		$this->load->database();
		$this->load->model("RegistrationModel");
	}
	public function index()
	{
		$countries=$this->RegistrationModel->getCountries();
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
		$data=array('countries'=>$countries,'captchaImg'=>$captcha['image']);
		$this->load->view('registration',$data);
	}
	public function store(){		
		$this->load->helper('email');
		$this->form_validation->set_rules('first_name','First Name','trim|required');
		$this->form_validation->set_rules('last_name','Last Name','trim|required');
		$this->form_validation->set_rules('phone_number','Phone Number','trim|required|callback_ukphone_number_check');
		$this->form_validation->set_rules('dob','Date of Birth','trim|required');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[8]');
		$this->form_validation->set_rules('country','Country','trim|required');
		$this->form_validation->set_rules('subscription_for','Subscription','trim|required');
		$this->form_validation->set_rules('captcha','Captcha','trim|required|callback_captcha_validation');
		if($this->form_validation->run() == false){		
			$this->index();
		}else{
			//print_r($this->input->post());
			if($this->RegistrationModel->checkEmailIdExistsOrNot($this->input->post('email'))){
				$this->session->set_flashdata('registration_failure_msg', 'Email Id already exists !');
				redirect('registration');
			}
			$dobFormatted=date("Y-m-d", strtotime($this->input->post('dob'))); 
			$data['user_first_name']=$this->input->post('first_name');
			$data['user_last_name']=$this->input->post('last_name');
			$data['user_phone_number']=$this->input->post('phone_number');
			$data['user_dob']=$dobFormatted;
			$data['user_email']=$this->input->post('email');
			$data['user_password']=password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$data['user_country']=$this->input->post('country');
			$data['user_subscription']=$this->input->post('subscription_for');
			$data['user_role']=2;			
			if($this->RegistrationModel->createUser($data)){
				$this->session->set_flashdata('registration_success_msg', 'Registration Successfull !');
				if($this->config->item('email_smtp_user')!='' && $this->config->item('email_smtp_pass')!=''){
					$this->sendEmail($data['user_email']);
				}				
				redirect('login');
			}else{
				$this->session->set_flashdata('registration_failure_msg', 'Registration Failed !');
				$this->index();
			}
		}
	}
	public function ukphone_number_check($input){
		$pattern = "/^(\(?(0|\+44)[1-9]{1}\d{1,4}?\)?\s?\d{3,4}\s?\d{3,4})$/";
		$match = preg_match($pattern,$input);
		if ($match != false) {
			return TRUE;
		} else {
			$this->form_validation->set_message('ukphone_number_check', "Please enter a valid phone number");
			return FALSE;
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
	public function captchaRefresh() {
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
       	echo $captcha['image'];
   	}
  	public function edit(){
		$this->form_validation->set_rules('first_name','First Name','trim|required');
		$this->form_validation->set_rules('last_name','Last Name','trim|required');
		$this->form_validation->set_rules('phone_number','Phone Number','trim|required|callback_ukphone_number_check');
		$this->form_validation->set_rules('dob','Date of Birth','trim|required');
		$this->form_validation->set_rules('country','Country','trim|required');
		$this->form_validation->set_rules('subscription_for','Subscription','trim|required');
		if($this->form_validation->run() == false){		
			$this->index();
		}else{
			//print_r($this->input->post());
			$dobFormatted=date("Y-m-d", strtotime($this->input->post('dob'))); 
			$data['user_first_name']=$this->input->post('first_name');
			$data['user_last_name']=$this->input->post('last_name');
			$data['user_phone_number']=$this->input->post('phone_number');
			$data['user_dob']=$dobFormatted;
			$data['user_country']=$this->input->post('country');
			$data['user_subscription']=$this->input->post('subscription_for');
			if($this->RegistrationModel->updateUser($data,$this->input->post('user_id'))){
				$this->session->set_flashdata('updation_success_msg', 'Updation Successfull !');				
			}else{
				$this->session->set_flashdata('updation_failure_msg', 'Updation Failed !');
			}
			redirect('adminhome');
		}
   	}
	
	public function sendEmail($toEmail){
		$this->load->library('email');
		$config = array();
		$config['protocol'] = $this->config->item('email_protocol');
		$config['smtp_host'] = $this->config->item('email_smtp_host');
		$config['smtp_user'] = $this->config->item('email_smtp_user');
		$config['smtp_pass'] = $this->config->item('email_smtp_pass');
		$config['smtp_port'] = $this->config->item('email_smtp_port');
		$config['mailtype'] = $this->config->item('email_mailtype');
		$config['charset'] = $this->config->item('email_charset');
		$config['priority'] = $this->config->item('email_priority');
		//$config['starttls'] =true;
		$config['wordwrap'] = TRUE;
		$config['newline'] = "\r\n";
		$this->email->set_header('MIME-Version', '1.0; charset=utf-8');
		$this->email->set_header('Content-type', 'text/html');
		$this->email->initialize($config);
		$this->email->from($this->config->item('email_smtp_user'));
		$this->email->to($toEmail);
		$this->email->subject('Registration Test');
		$emailContent = "Your registration is successfull";
		$this->email->message($emailContent);
		try {
			$this->email->send();
		} 
		catch (Exception $e) {
		}
	}
}
