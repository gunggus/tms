<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller {

	/**
	 * Studio Kami Mandiri
	 * Online Office
	 * ver 1.0.0
	 *
	 * user controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/user.php
	 * developer : www.studiokami.com
	 * phone : 0361 853 2400
	 * email : support@studiokami.com
	 */
	
	
# constuction ------------------------------	
	 function __construct()
	{
        parent::__construct();
		
		
    }
# constuction ------------------------------	

# index ------------------------------------	 
	public function index()
	{
		#redirect('user/login');
		#$this->load->view('header');
		$this->load->view('not_registered');
		
	}
# index ------------------------------------	
	
	public function error_404()
	{
		$this->load->view('error_404');
	}
	
	public function not_registered()
	{
		$this->load->view('not_registered');
	}

	public function invalid_nipp()
	{
		echo 'duplicate nipp';
	}
	
	public function module_inactive()
	{
		$this->load->view('module_inactive');
	}
	
	public function unknown_error()
	{
		
	}
	
	public function error_db()
	{
		$this->load->view('error_db');
	}
	
	public function not_authorized()
	{
		$this->load->view('not_authorized');
	}
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */