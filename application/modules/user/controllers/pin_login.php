<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pin_login extends CI_Controller {

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
		$this->load->library('module_management');
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
			$this->load->view('pin_login');
		}
	}
# index ------------------------------------	


# do pin login ------------------------------
	public function pin_do_login()
	{
		# check module active
		if($this->module_management->module_active() == FALSE){redirect('messages/error/module_inactive');}

		# get email data from form		
		$email = $this->input->post('email');
		$email_encrypt = $email;	
		
		#validate data
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		

		if ($this->form_validation->run() == FALSE)
		{
			# validation fail do re-login
			$data['message'] = 'invalid email';
			$this->load->view('pin_login', $data);
		}
		else
		{
			# check email on local database 
			$result = $this->user_model->check_reg_email($email_encrypt);
			
			if($result)
			{
					# if email found on database
					foreach($result as $row):
						 $ui_id = $row->ui_id;
						 $hp_encrypt = $this->encrypt->decode($row->ui_hp); 
						 $approval = $row->ui_approval;
			 		endforeach;
					
					# check email
					if($this->user_access->check_email(array('ui_id' => $row->ui_id)) <> $email){redirect('messages/error/error_db');}
					
					# if user exist then check user approval by admin
					if($approval == 'n')
					{
						# if user exist but no approve yet, call admin
						$data['message'] = 'Your profile not approved yet, please contact admin';
						$this->load->view('pin_login', $data);
					}
					else
					{
						# send view
						$data['email'] = $email;
						
						# call models to delete previous verification duplicate data
						$this->user_model->del_dup_prev_ver_data($email_encrypt);
						
						# call models to delete unverify duplicate user data on user identity table
						$this->user_model->del_dup_prev_user_unver_data($email);
						
						# create random pin
						$this->load->helper('pin');
						$pin = get_pin(); 
						$email_link = $email . '+' . $pin ;
						$pin_encypt = $this->encrypt->sha1($pin, $this->config->item('encryption_key'));
						
						# encrypt email link to send via email
						$email_link = urlencode(base64_encode($email_link));
						
						# set request date & expired date
						$request = mdate("%Y-%m-%d %H:%i:%s", time());
						$expired = mdate("%Y-%m-%d %H:%i:%s", time()+3600);
						
						# set verification type
						$type = 'login';
						
						# call models to save verification data
						$this->user_model->save_verification($email_encrypt, $hp_encrypt, $type, $pin_encypt, $email_link, $request, $expired);
						
						# send pin and link via email
						$config['protocol'] = 'sendmail';
						$config['mailpath'] = '/usr/sbin/sendmail';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->email->initialize($config);
						
						# send pin and link via smtp
						/*$config['protocol'] = 'smtp';
						$config['smtp_host'] = 'ssl://smtp.googlemail.com';
						$config['smtp_port'] = 465;
						$config['smtp_user'] = 'xxx@gapura.co.id';
						$config['smtp_pass'] = 'xxxx';
						$config['charset'] = 'iso-8859-1';
						$config['wordwrap'] = TRUE;
						$config['mailtype'] = 'html';
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");*/
						# send pin and link via smtp
						
						$this->email->from($this->config->item('admin_email'), $this->config->item('admin_name'));
						$this->email->to($email); 
						$this->email->subject($this->config->item('station'));
						$this->email->message('
						
						<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
						<title>Untitled Document</title>
						</head>
						
						<body>
						<p>Anda telah melakukan registrasi pin untuk melakukan login pada aplikasi ' . $this->config->item('app_name') . '</p>
						<p>Silahkan melakukan verifikasi dengan menggunakan pin berikut pada halaman verifikasi</p>
						<p>PIN : ' . $pin . '</p>
						<p>atau</p>
						<p>klik link dibawah ini</p>
						<p>LINK : {unwrap}' . anchor("user/verification/link/" . $email_link, base_url() . 'user/verification/link/' . $email_link) . '{/unwrap}</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>Terima kasih</p>
						<p>&nbsp;</p>
						<p>' . $this->config->item('admin_name') . '</p>
						<p>&nbsp;</p>
						</body>
						</html>
						
						');
						$this->email->send();
			
						# send data email through flash data
						$this->session->set_flashdata('email', $email);
						#$this->session->set_flashdata('pin', $pin);
						
						# call views
						redirect('user/verification/pin');
						
					}
					
			}
			else
			{
				# send mesg to view
				$data['message']='silahkan melakukan registrasi';
				
				# not register user redirect to register page
				redirect('messages/error/not_registered');
			}
		}
	}
# do pin login ------------------------------
	
}
/* End of file user.php */
/* Location: ./application/controllers/user.php */