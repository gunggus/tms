<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	/**
	 * User Controller
	 *
	 */
	
	
	 function __construct()
	{
        parent::__construct();
		
		# load model, library and helper
		//$this->load->model('member_model','', TRUE);
		
	/*	
		# restrict all function access after log in
		if ($this->session->userdata('logged_in'))
				{ 
					# check module active
					if($this->module_management->module_active('module_active') == FALSE){redirect('messages/error/module_inactive');}
					
					# kick guest user
					if($this->user_access->level('user_access')==0){redirect('messages/error/not_authorized');}
				}
			
				else
				{
					# redirect to login if not
					redirect('user/password_login');
				}	
    */
	}

	function index()
	{
		redirect("task/manage");
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */