<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verification extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : Verification
	 *
	 * verification controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/verification.php
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
		
		# load model, library and helper
		$this->load->model('user_model','', TRUE);
		
		
		
    }
# constuction ------------------------------	

# index ------------------------------------	 
	public function index()
	{
		redirect('user/verification/pin');
	}
# index ------------------------------------	

# pin verification ---------------------------	
	public function pin()
	{
		# call view
		$data['email'] = $this->session->flashdata('email');
		$data['pin'] = $this->session->flashdata('pin');
		$this->load->view('pin_verification', $data);
	}
	
	public function do_pin_verification()
	{
		# get data
		$email = $this->input->post('email');
		$email_encrypt = $email;
		
		$pin = $this->input->post('pin');
		$pin_encrypt = $this->encrypt->sha1($pin, $this->config->item('encryption_key'));
		
		# call model
		$result = $this->user_model->do_verification($email_encrypt, $pin_encrypt);
		
		# check pin to verify
		if($result)
		   {
			 # if pin sucess prepare session
			 $sess_array = array();
			 foreach($result as $row)
			 {
			   $sess_array = array(
				 'ui_nama' => $this->encrypt->decode($row->ui_nama, $this->config->item('encryption_key')), 
				 'ui_nipp' => $row->ui_nipp, 
				 'ui_hp' => $this->encrypt->decode($row->ui_hp, $this->config->item('encryption_key')), 
				 'ui_email' => $email, #sh 
				 'ui_level' => $row->ui_level,
				 'ui_jabatan' => $row->ui_jabatan,
				 'ui_verification' => $row->ui_verification, 
				 'ui_ver_date' => $row->ui_ver_date,
				 'ui_registration_on' => $row->ui_registration_on,
				 'ui_approval' => $row->ui_approval,
				 'ui_approval_by' => $row->ui_approval_by,
				 'ui_approval_on' => $row->ui_approval_on,
			   );
			   # set session for auto login
			   $this->session->set_userdata('logged_in', $sess_array);
			   
			 }
			 # redirect to dashboard after logged in
			redirect('user/profile/');
			
		   }
		   else
		   {
			 # verification pin fail, force to try again
			 # call view
			$data['email'] = $this->session->flashdata('email');
			#$data['pin'] = $this->session->flashdata('pin');
			$this->load->view('pin_verification', $data);
			 
		   }
		
	}
# pin verification ---------------------------	

# link verification --------------------------
	public function link()
	{
		# get data
		$email_link= $this->uri->segment(4, 0);
		if($email_link == 0){ redirect('message/error/unknown_error'); }
		
		$email_link = urldecode($email_link);
		$email_link = base64_decode($email_link);
		
		# split data			
		$url_result = explode("+", $email_link);
		$email = $url_result[0];
		$pin = $url_result[1];
		
		# call model
		$result = $this->user_model->do_verification($email, $pin);
		
		# check verification link
		if($result)
		   {
			$time = mdate('%H:%i:%s',time());
			$shift = $this->user_model->get_shift($time); 
			
			# if success prepare session
			 $sess_array = array();
			 foreach($result as $row)
			 {
			   $sess_array = array(
			    'ui_nama' => $this->encrypt->decode($row->ui_nama, $this->config->item('encryption_key')), 
				 'ui_nipp' => $row->ui_nipp, 
				 'ui_hp' => $this->encrypt->decode($row->ui_hp, $this->config->item('encryption_key')), 
				 'ui_email' => $email, #sh 
				 'ui_level' => $row->ui_level,
				 'ui_jabatan' => $row->ui_jabatan,
				 'ui_verification' => $row->ui_verification, 
				 'ui_ver_date' => $row->ui_ver_date,
				 'ui_registration_on' => $row->ui_registration_on,
				 'ui_approval' => $row->ui_approval,
				 'ui_approval_by' => $row->ui_approval_by,
				 'ui_approval_on' => $row->ui_approval_on,
				 'shift' => $shift,
				);
			   # set session
			  $this->session->set_userdata('logged_in', $sess_array);
			   
			 }
			 # logged in and redirect user to dashboard
			 redirect('dashboard');
		   }
		   else
		   {
			 # verification fail force user to input pin from email
			 $data['success_message'] = 'link yang anda klik salah, masukan kode verifikasi yang anda terima di inbox email.';
			 $this->load->view('login/login_verification_view', $data);
		   }
		   
	}
# link verification --------------------------
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */