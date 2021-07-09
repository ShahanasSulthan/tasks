<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserHome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['url','captcha']);
		$this->load->library(['session', 'form_validation']);
		$this->load->database();
		$this->load->model("UserHomeModel");
		$this->load->model("RegistrationModel");
		$this->checkSession();
	}
	public function index()
	{		
		$userDetails=$this->RegistrationModel->getUserDetails($this->session->userdata('user_id'));
		$data=array('userDetails'=>$userDetails[0]);
		$this->load->view('user_home',$data);
	}
	public function checkSession(){
		if($this->session->userdata('user_id') && $this->session->userdata('user_role')=='2' ){
			return true;
		}else{
			redirect('Login');
		}
	}
	public function loadDetails($page = 0){		
		$userDetails=$this->RegistrationModel->getUserDetails($this->session->userdata('user_id'));
		$tag=$userDetails[0]['tag_name']??'';
		$url = 'https://hn.algolia.com/api/v1/search_by_date?&tags='.$tag.'&page='.$page.'&hitsPerPage=10';  
        $curl = curl_init($url);   
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
		$resultDecoded=json_decode($result);
		$totalNumberOfPages=$resultDecoded->nbPages;
		//echo "Number of pages:".$pages;
		//print_r($result);
        curl_close($curl);
		$this->load->library('pagination');
		$config['base_url'] = base_url() . 'userhome/loadDetails';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $totalNumberOfPages;
		$config['per_page'] = 10;
		$config['cur_page'] = $page;
		$config['full_tag_open']    = '<div class="catalogue-pagination"><ul class="pagi" id="ul_pagination">';
		$config['full_tag_close']   = '</ul></div>';
		$config['num_tag_open']     = '<li class="page-item to-focus-top"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li><a class="current" href="">';
		$config['cur_tag_close']    = '</a></li>';
		$config['next_tag_open']    = '<li class="page-item to-focus-top"><span class="page-link" >';
		$config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tag_close']  = '</span></li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tag_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tag_close']  = '</span></li>';
		$config['uri_segment'] = 3;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['result'] = $resultDecoded;
		$data['row'] = $page;
		echo json_encode($data);
	}
}
