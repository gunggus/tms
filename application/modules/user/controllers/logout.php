<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : Logout
	 *
	 * logout controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/logout.php
	 * developer : pandhawa digital
	 * phone : 0361 853 2400
	 * email : pandhawa.digital@gmail.com
	 *
	 * warning !!!
	 * please do not copy, edit, or distribute this script without developer permission.
	 *
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
		session_start();
		$this->session->unset_userdata('logged_in');
   		session_destroy();
		redirect('user/pin_login', 'refresh');
	}
# index ------------------------------------	
	
}

/* End of file logout.php */
/* Location: ./application/modules/user/controller/logout.php */