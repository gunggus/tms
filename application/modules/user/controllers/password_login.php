<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_login extends CI_Controller {

	/**
	 * PT Gapura Angkasa
	 * Module : User 
	 * Sub Module : pin login, password login
	 *
	 * login controller
	 *
	 * url : http://localhost/github/office/modules/user/controller/login.php
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
		# call view
		if ($this->session->userdata('logged_in'))
		{
			redirect('user/profile', 'refresh');
		}
		else
		{
			$this->load->view('password_login');
		}
	}
# index ------------------------------------	

# do password login ------------------------
	public function do_password_login()
	{
		# check module active
		#if($this->module_management->module_active() == FALSE){redirect('messages/error/module_inactive');}
		
		# get email data from form		
		$email = $this->input->post('email');
		$email_encrypt = $email;	
		
		$password = $this->input->post('password');
		$password_encrypt = $this->user_access->encrypt_md5($email_encrypt, $password);	
		
		#validate data
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		

		if ($this->form_validation->run() == FALSE)
		{
			# form validation fail, push to do re-login
			$data['message'] = 'invalid email';
			$this->load->view('password_login', $data);
		}
		else
		{
			# validation success, continue login process
			
			# check email registered or not
			$check_reg = $this->user_model->do_pass_verification($email_encrypt, $password_encrypt);
			
			if($check_reg <> NULL)
			{
				$time = mdate('%H:%i:%s',time());
				//$shift = $this->user_model->get_shift($time); 
			
				# if email already registered
				$sess_array = array();
				foreach($check_reg as $row):
					 $ui_id = $row->ui_id;
					 $ui_approval = $row->ui_approval;
					 $sess_array = array(
					 'ui_id' => $row->ui_id,
					 'ui_nama' => $this->encrypt->decode($row->ui_nama), 
					 'ui_nipp' => $row->ui_nipp, 
					 'ui_hp' => $this->encrypt->decode($row->ui_hp), 
					 'ui_email' => $email, #sh 
					 'ui_level' => $row->ui_level,
					 'ui_jabatan' => $row->ui_jabatan,
					 'ui_verification' => $row->ui_verification, 
					# 'ui_ver_date' => $row->ui_ver_date,
					 #'ui_registration_on' => $row->ui_registration_on,
					 'ui_approval' => $row->ui_approval,
					# 'ui_approval_by' => $row->ui_approval_by,
					# 'ui_approval_on' => $row->ui_approval_on,
					 //'shift' => $shift,
					);
				endforeach;
				
				# check email
				if($this->user_access->check_email(array('ui_id' => $ui_id)) == $email)
				{
					# check email passed
					$check_email = 0;
				}
				else
				{
					# check email failed
					$check_email = 1;
					$data['message'] = 'Email not found, please contact admin';
				}
				
				# check approval
				if($ui_approval == 'n')
				{
					# if user exist but no approve yet, call admin
					$check_approval = 1;
					$data['message'] = 'Your profile not approved yet, please contact admin';
				}
				else
				{
					# user approve
					$check_approval = 0;
				}
				
				$check = $check_email + $check_approval;
				
				if($check < 1)
				{
					# do login
					$this->session->set_userdata('logged_in', $sess_array);
					redirect('user/profile/');
				}
				else
				{
					# do re login
					$this->load->view('password_login', $data);
				}
			}
			else
			{
				# email not found, push to register
				$data['message']='silahkan melakukan registrasi';
				
				# not register user redirect to register page
				redirect('messages/error/not_registered');
			}
			
		}
		
	}
# do password login ------------------------
	
}
/* End of file user.php */
/* Location: ./application/controllers/user.php */